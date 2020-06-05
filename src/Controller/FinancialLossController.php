<?php

namespace App\Controller;

use App\Form\FinancialLossType;
use App\Repository\FinancialLossRepository;
use App\Service\ProClaimPutFinancialLoss;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class FinancialLossController
 * @package App\Controller
 * @IsGranted("ROLE_USER")
 */
class FinancialLossController extends BaseController
{

    /**
     * @var FinancialLossRepository
     */
    private $financialLossRepository;

    public function __construct(FinancialLossRepository $financialLossRepository)
    {
        $this->financialLossRepository = $financialLossRepository;
    }

    /**
     * @Route("/dashboard/financial-loss", name="app_financial_loss")
     * @param Request $request
     * @param EntityManagerInterface $entityManager
     * @param ProClaimPutFinancialLoss $proClaimPutFinancialLoss
     * @return Response
     */
    public function index(Request $request, EntityManagerInterface $entityManager, ProClaimPutFinancialLoss $proClaimPutFinancialLoss)
    {

        $showForm = $this->getUser()->getAppComplaints();
        if (!$showForm){
            return $this->redirectToRoute('app_dashboard');
        }

        $userID = $this->getUser()->getId();
        $financialLossDetails = $this->financialLossRepository->findOneBySomeField($userID);

        $form = $this->createForm(FinancialLossType::class, $financialLossDetails);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){

            // COMMIT FORM FIELD VALUES TO DATABASE
            $financialLossDetails->setComplete(true);
            $userSetFinancialLoss = $this->getUser()->setAppFinancialLoss(true);
            $userSetAppCurrentForm = $this->getUser()->setAppCurrentForm('app_financial_loss');

            $entityManager->persist($userSetFinancialLoss);
            $entityManager->persist($userSetAppCurrentForm);
            $entityManager->persist($financialLossDetails);

            $entityManager->flush();

            // COMMIT TO PROCLAIM
            $typeFinancialLoss = "";
            if (!empty($financialLossDetails->getTypeFinancialLoss())) {
                $typeFinancialLoss = implode(', ', $financialLossDetails->getTypeFinancialLoss());
            }

            /*
            if (!empty($financialLossDetails->getTypeFinancialLossOtherComment())){
                $typeFinancialLoss .= ', '.$financialLossDetails->getTypeFinancialLossOtherComment();
            }
            */

            $data = [
                'case_id' => $this->getUser()->getProClaimReference(),
                'type_financial_Loss' => $typeFinancialLoss,
                'type_financial_Loss_other_text' => $financialLossDetails->getTypeFinancialLossOtherComment(),
                'total_loss_amount' => $financialLossDetails->getTotalLossAmount(),
            ];
            //dd($data);
            $proClaimPutFinancialLoss->putCaseDetails($data);

            // REDIRECT TO NEXT PAGE
            $this->addFlash('page_success', 'Financial Loss stage complete!');
            return $this->redirectToRoute('app_reimbursements');

        }

        return $this->render('dashboard/financial_loss.html.twig', [
            'header_text' => 'Financial Loss',
            'form' => $form->createView(),
        ]);
    }
}
