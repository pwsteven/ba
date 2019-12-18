<?php

namespace App\Controller;

use App\Form\ReimbursementsType;
use App\Repository\ReimbursementsRepository;
use App\Service\ProClaimPutReimbursements;
use App\Service\UploaderHelper;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class ReimbursementsController
 * @package App\Controller
 * @IsGranted("ROLE_USER")
 */
class ReimbursementsController extends BaseController
{
    /**
     * @var ReimbursementsRepository
     */
    private $reimbursementsRepository;

    public function __construct(ReimbursementsRepository $reimbursementsRepository)
    {
        $this->reimbursementsRepository = $reimbursementsRepository;
    }


    /**
     * @Route("/dashboard/reimbursements", name="app_reimbursements")
     * @param Request $request
     * @param EntityManagerInterface $entityManager
     * @param UploaderHelper $uploaderHelper
     * @param ProClaimPutReimbursements $proClaimPutReimbursements
     * @return Response
     */
    public function index(Request $request, EntityManagerInterface $entityManager, UploaderHelper $uploaderHelper, ProClaimPutReimbursements $proClaimPutReimbursements)
    {

        $showForm = $this->getUser()->getAppFinancialLoss();
        if (!$showForm){
            return $this->redirectToRoute('app_dashboard');
        }

        $userID = $this->getUser()->getId();
        $reimbursementDetails = $this->reimbursementsRepository->findOneBySomeField($userID);

        $form = $this->createForm(ReimbursementsType::class, $reimbursementDetails);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            //COLLECT + UPLOAD FILE|IMAGE FILES
            /** @var UploadedFile $reimbursementFiles */
            $reimbursementFiles = $form['reimbursementFiles']->getData();
            if ($reimbursementFiles){
                $filesData = [];
                foreach ($reimbursementFiles as $reimbursementFile) {
                    $newFileName = $uploaderHelper->uploadClientFile($reimbursementFile);
                    $filesData[] = $newFileName;
                }
                $reimbursementDetails->setReimbursementFilesPath($filesData);
            }

            // COMMIT FORM FIELD VALUES TO DATABASE
            $reimbursementDetails->setComplete(true);
            $userSetReimbursement = $this->getUser()->setAppReimbursements(true);
            $userSetAppCurrentForm = $this->getUser()->setAppCurrentForm('app_reimbursements');

            $entityManager->persist($userSetReimbursement);
            $entityManager->persist($userSetAppCurrentForm);
            $entityManager->persist($reimbursementDetails);
            $entityManager->flush();

            // COMMIT TO PROCLAIM TODO
            $data = [
                'case_id' => $this->getUser()->getProClaimReference(),
                'financial_loss_suffered' => $reimbursementDetails->getFinancialLossSuffered(),
                'provider' => $reimbursementDetails->getProvider(),
                'amount_reimbursed' => $reimbursementDetails->getAmountReimbursed(),
            ];
            $proClaimPutReimbursements->putCaseDetails($data);

            // REDIRECT TO NEXT PAGE
            $this->addFlash('success', 'Success! You have completed the Reimbursements stage.');
            return $this->redirectToRoute('app_credit_monitoring');

        }

        return $this->render('dashboard/reimbursements.html.twig', [
            'step_integer' => 70,
            'step_string' => 'Step 7 of 10',
            'header_icon' => 'ik ik-pocket',
            'header_text' => 'Reimbursements',
            'form' => $form->createView(),
        ]);
    }
}
