<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class FurtherCorrespondenceController extends BaseController
{
    /**
     * @Route("/dashboard/further-correspondence", name="app_further_correspondence")
     */
    public function index()
    {
        return $this->render('dashboard/further_correspondence.html.twig', [
            'controller_name' => 'FurtherCorrespondenceController',
        ]);
    }
}
