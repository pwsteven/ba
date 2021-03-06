<?php

namespace App\Controller;

use App\Form\CreditMonitorType;
use App\Repository\CreditMonitorRepository;
use App\Service\ProClaimPutCreditMonitoring;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class CreditMonitoringController
 * @package App\Controller
 * @IsGranted("ROLE_USER")
 */
class CreditMonitoringController extends BaseController
{

    /**
     * @var CreditMonitorRepository
     */
    private $creditMonitorRepository;

    public function __construct(CreditMonitorRepository $creditMonitorRepository)
    {
        $this->creditMonitorRepository = $creditMonitorRepository;
    }

    /**
     * @Route("/dashboard/credit-monitoring", name="app_credit_monitoring")
     * @param Request $request
     * @param EntityManagerInterface $entityManager
     * @param ProClaimPutCreditMonitoring $proClaimPutCreditMonitoring
     * @return Response
     */
    public function index(Request $request, EntityManagerInterface $entityManager, ProClaimPutCreditMonitoring $proClaimPutCreditMonitoring)
    {

        $showForm = $this->getUser()->getAppReimbursements();
        if (!$showForm){
            return $this->redirectToRoute('app_dashboard');
        }

        $userID = $this->getUser()->getId();
        $creditMonitorDetails = $this->creditMonitorRepository->findOneBySomeField($userID);

        $form = $this->createForm(CreditMonitorType::class, $creditMonitorDetails);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            // COMMIT FORM FIELD VALUES TO DATABASE
            $creditMonitorDetails->setComplete(true);
            $userSetCreditMonitor = $this->getUser()->setAppCreditMonitoring(true);
            $userSetAppCurrentForm = $this->getUser()->setAppCurrentForm('app_credit_monitoring');

            $entityManager->persist($userSetCreditMonitor);
            $entityManager->persist($userSetAppCurrentForm);
            $entityManager->persist($creditMonitorDetails);
            $entityManager->flush();

            // COMMIT TO PROCLAIM TODO
            $data = [
                'case_id' => $this->getUser()->getProClaimReference(),
                'monitor_credit' => $creditMonitorDetails->getMonitorCredit(),
            ];
            $proClaimPutCreditMonitoring->putCaseDetails($data);

            // REDIRECT TO NEXT PAGE
            $this->addFlash('page_success', 'Credit Monitoring stage complete!');
            return $this->redirectToRoute('app_emotional_distress');

        }

        return $this->render('dashboard/credit_monitoring.html.twig', [
            'header_text' => 'Credit Monitoring',
            'form' => $form->createView(),
        ]);
    }
}
