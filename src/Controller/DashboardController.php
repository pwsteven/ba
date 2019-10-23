<?php

namespace App\Controller;

use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


/**
 * Class DashboardController
 * @package App\Controller
 * @IsGranted("ROLE_USER")
 */
class DashboardController extends BaseController
{
    /**
     * @Route("/dashboard", name="app_dashboard")
     * @param Request $request
     * @param EntityManagerInterface $entityManager
     * @return Response
     */
    public function index(Request $request, EntityManagerInterface $entityManager)
    {

        if ($request->isMethod('POST')) {
            $user = $this->getUser()->setAppStarted(true);
            $entityManager->persist($user);
            $entityManager->flush();
            return $this->redirectToRoute('app_personal_details');
        }

        return $this->render('dashboard/index.html.twig', [

        ]);
    }
}
