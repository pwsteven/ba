<?php

namespace App\Controller;

use App\Service\UploaderHelper;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class CompleteController
 * @package App\Controller
 * @IsGranted("ROLE_USER")
 */
class CompleteController extends BaseController
{
    /**
     * @Route("/dashboard/complete", name="app_complete")
     * @param Request $request
     * @param EntityManagerInterface $entityManager
     * @param UploaderHelper $uploaderHelper
     * @return Response
     */
    public function index(Request $request, EntityManagerInterface $entityManager, UploaderHelper $uploaderHelper)
    {

        $showForm = $this->getUser()->getAppEmotionalDistress();
        if (!$showForm){
            return $this->redirectToRoute('app_dashboard');
        }

        return $this->render('dashboard/complete.html.twig', [
            'step_integer' => 100,
            'step_string' => 'Step 10 of 10 - Complete!',
            'header_icon' => 'ik ik-check-square',
            'header_text' => 'Complete',
        ]);
    }
}
