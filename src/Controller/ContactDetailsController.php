<?php

namespace App\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class ContactDetailsController
 * @package App\Controller
 * @IsGranted("ROLE_USER")
 */
class ContactDetailsController extends BaseController
{
    /**
     * @Route("/dashboard/contact-details", name="app_contact_details")
     */
    public function index()
    {
        return $this->render('dashboard/contact_details.html.twig', [

        ]);
    }
}
