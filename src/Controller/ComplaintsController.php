<?php

namespace App\Controller;

use App\Form\ComplaintsType;
use App\Repository\ComplaintsRepository;
use App\Service\ProClaimPutComplaints;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class ComplaintsController
 * @package App\Controller
 * @IsGranted("ROLE_USER")
 */
class ComplaintsController extends BaseController
{

    /**
     * @var ComplaintsRepository
     */
    private $complaintsRepository;

    public function __construct(ComplaintsRepository $complaintsRepository)
   {
       $this->complaintsRepository = $complaintsRepository;
   }

    /**
     * @Route("/dashboard/complaints", name="app_complaints")
     * @param Request $request
     * @param EntityManagerInterface $entityManager
     * @param ProClaimPutComplaints $proClaimPutComplaints
     * @return Response
     */
    public function index(Request $request, EntityManagerInterface $entityManager, ProClaimPutComplaints $proClaimPutComplaints)
    {

        $showForm = $this->getUser()->getAppFutherCorrespondence();
        if (!$showForm){
            return $this->redirectToRoute('app_dashboard');
        }

        $userID = $this->getUser()->getId();
        $complaintDetails = $this->complaintsRepository->findOneBySomeField($userID);

        $form = $this->createForm(ComplaintsType::class, $complaintDetails);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){

            // COMMIT FORM FIELD VALUES TO DATABASE
            $complaintDetails->setComplete(true);
            $userSetComplaints = $this->getUser()->setAppComplaints(true);
            $userSetAppCurrentForm = $this->getUser()->setAppCurrentForm('app_complaints');
            $entityManager->persist($userSetComplaints);
            $entityManager->persist($userSetAppCurrentForm);
            $entityManager->persist($complaintDetails);
            $entityManager->flush();

            // COMMIT TO PROCLAIM

            if (!empty($complaintDetails->getComplaintMade())){
                $complaintMade = date_format($complaintDetails->getComplaintMade(), 'd/m/Y');
            } else {
                $complaintMade = "";
            }

            $data = [
                'case_id' => $this->getUser()->getProClaimReference(),
                'lodged_complaint' => $complaintDetails->getLodgedComplaint(),
                'complaint_made' => $complaintMade,
                'received_response' => $complaintDetails->getReceivedResponse(),
                'satisfied_response' => $complaintDetails->getSatisfiedResponse(),
                'reason_unsatisfied' => $complaintDetails->getReasonUnsatisfied(),
                'contacted_ioc' => $complaintDetails->getContactedIOC(),
                'contacted_action_fraud' => $complaintDetails->getContactedActionFraud(),
                'accessed_get_safe_online' => $complaintDetails->getAccessedGetSafeOnline(),
            ];

            $proClaimPutComplaints->putCaseDetails($data);

            // REDIRECT TO NEXT PAGE
            $this->addFlash('success', 'Success! You have completed the Complaints stage.');
            return $this->redirectToRoute('app_financial_loss');

        }

        return $this->render('dashboard/complaints.html.twig', [
            'step_integer' => 50,
            'step_string' => 'Step 5 of 10',
            'header_icon' => 'ik ik-clipboard',
            'header_text' => 'Complaints',
            'form' => $form->createView(),
        ]);
    }
}
