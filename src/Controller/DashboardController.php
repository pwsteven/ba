<?php

namespace App\Controller;

use App\Service\UserLogger;
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
     * @var SecurityController
     */
    private $securityController;
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    public function __construct(SecurityController $securityController, EntityManagerInterface $entityManager)
    {
        $this->securityController = $securityController;
        $this->entityManager = $entityManager;
    }

    /**
     * @Route("/dashboard", name="app_dashboard")
     * @param Request $request
     * @param UserLogger $userLogger
     * @return Response
     */
    public function index(Request $request, UserLogger $userLogger)
    {

        $userID = $this->getUser()->getId();
        $userLogger->userLogin($userID);

        if ($this->securityController->isGranted("ROLE_ADMIN")){
            return $this->redirectToRoute('app_admin');
        }

        if ($request->isMethod('POST')) {
            $user = $this->getUser()->setAppStarted(true);
            $this->entityManager->persist($user);
            $this->entityManager->flush();
            return $this->redirectToRoute('app_personal_details');
        }

        return $this->render('dashboard/index.html.twig', [

        ]);
    }
}
