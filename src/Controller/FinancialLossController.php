<?php

namespace App\Controller;

use App\Service\UploaderHelper;
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
     * @Route("/dashboard/financial-loss", name="app_financial_loss")
     * @param Request $request
     * @param EntityManagerInterface $entityManager
     * @param UploaderHelper $uploaderHelper
     * @return Response
     */
    public function index(Request $request, EntityManagerInterface $entityManager, UploaderHelper $uploaderHelper)
    {
        return $this->render('dashboard/financial_loss.html.twig', [
            'step_integer' => 60,
            'step_string' => 'Step 6 of 10',
            'header_icon' => 'ik ik-dollar-sign',
            'header_text' => 'Financial Loss',
        ]);
    }
}
