<?php

namespace App\Controller;

use App\Service\UploaderHelper;
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
     * @Route("/dashboard/credit-monitoring", name="app_credit_monitoring")
     * @param Request $request
     * @param EntityManagerInterface $entityManager
     * @param UploaderHelper $uploaderHelper
     * @return Response
     */
    public function index(Request $request, EntityManagerInterface $entityManager, UploaderHelper $uploaderHelper)
    {
        return $this->render('dashboard/credit_monitoring.html.twig', [
            'step_integer' => 80,
            'step_string' => 'Step 8 of 10',
            'header_icon' => 'ik ik-globe',
            'header_text' => 'Credit Monitoring',
        ]);
    }
}
