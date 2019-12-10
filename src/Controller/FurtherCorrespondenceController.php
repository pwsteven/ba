<?php

namespace App\Controller;

use App\Service\UploaderHelper;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class FurtherCorrespondenceController
 * @package App\Controller
 * @IsGranted("ROLE_USER")
 */
class FurtherCorrespondenceController extends BaseController
{
    /**
     * @Route("/dashboard/further-correspondence", name="app_further_correspondence")
     * @param Request $request
     * @param EntityManagerInterface $entityManager
     * @param UploaderHelper $uploaderHelper
     * @return Response
     */
    public function index(Request $request, EntityManagerInterface $entityManager, UploaderHelper $uploaderHelper)
    {

        $showForm = $this->getUser()->getAppBACorrespondence();
        if (!$showForm){
            return $this->redirectToRoute('app_dashboard');
        }


        return $this->render('dashboard/further_correspondence.html.twig', [
            'step_integer' => 40,
            'step_string' => 'Step 4 of 10',
            'header_icon' => 'ik ik-at-sign',
            'header_text' => 'Further Correspondence',
        ]);
    }
}
