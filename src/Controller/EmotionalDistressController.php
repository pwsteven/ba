<?php

namespace App\Controller;

use App\Service\UploaderHelper;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class EmotionalDistressController
 * @package App\Controller
 * @IsGranted("ROLE_USER")
 */
class EmotionalDistressController extends BaseController
{
    /**
     * @Route("/dashboard/emotional-distress", name="app_emotional_distress")
     * @param Request $request
     * @param EntityManagerInterface $entityManager
     * @param UploaderHelper $uploaderHelper
     * @return Response
     */
    public function index(Request $request, EntityManagerInterface $entityManager, UploaderHelper $uploaderHelper)
    {
        return $this->render('dashboard/emotional_distress.html.twig', [
            'step_integer' => 90,
            'step_string' => 'Step 9 of 10',
            'header_icon' => 'ik ik-flag',
            'header_text' => 'Emotional Distress',
        ]);
    }
}
