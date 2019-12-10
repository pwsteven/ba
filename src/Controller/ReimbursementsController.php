<?php

namespace App\Controller;

use App\Service\UploaderHelper;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
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
     * @Route("/dashboard/reimbursements", name="app_reimbursements")
     * @param Request $request
     * @param EntityManagerInterface $entityManager
     * @param UploaderHelper $uploaderHelper
     * @return Response
     */
    public function index(Request $request, EntityManagerInterface $entityManager, UploaderHelper $uploaderHelper)
    {

        $showForm = $this->getUser()->getAppFinancialLoss();
        if (!$showForm){
            return $this->redirectToRoute('app_dashboard');
        }

        return $this->render('dashboard/reimbursements.html.twig', [
            'step_integer' => 70,
            'step_string' => 'Step 7 of 10',
            'header_icon' => 'ik ik-pocket',
            'header_text' => 'Reimbursements',
        ]);
    }
}
