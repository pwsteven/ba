<?php

namespace App\Controller;

use App\Service\UploaderHelper;
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
     * @Route("/dashboard/complaints", name="app_complaints")
     * @param Request $request
     * @param EntityManagerInterface $entityManager
     * @param UploaderHelper $uploaderHelper
     * @return Response
     */
    public function index(Request $request, EntityManagerInterface $entityManager, UploaderHelper $uploaderHelper)
    {
        return $this->render('dashboard/complaints.html.twig', [
            'step_integer' => 50,
            'step_string' => 'Step 5 of 10',
            'header_icon' => 'ik ik-clipboard',
            'header_text' => 'Complaints',
        ]);
    }
}
