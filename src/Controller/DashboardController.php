<?php

namespace App\Controller;

use App\Entity\UserLogger;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Sinergi\BrowserDetector\Browser;
use Sinergi\BrowserDetector\Device;
use Sinergi\BrowserDetector\Language;
use Sinergi\BrowserDetector\Os;
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

    public function __construct(SecurityController $securityController)
    {
        $this->securityController = $securityController;
    }

    /**
     * @Route("/dashboard", name="app_dashboard")
     * @param Request $request
     * @param EntityManagerInterface $entityManager
     * @return Response
     */
    public function index(Request $request, UserLogger $userLogger, EntityManagerInterface $entityManager)
    {

        if ($this->securityController->isGranted("ROLE_ADMIN")){
            return $this->redirectToRoute('app_admin');
        }

        if ($request->isMethod('POST')) {
            $user = $this->getUser()->setAppStarted(true);

            $browser = new Browser();
            $os = new Os();
            $device = new Device();
            $language = new Language();

            $userLogger->setUser($user);
            $userLogger->setBrowser($browser);
            $userLogger->setOperatingSystem($os);
            $userLogger->setDevice($device);
            $userLogger->setOpLanguage($language);
            $userLogger->setTimeLogged(new \DateTime());


            $entityManager->persist($user);
            $entityManager->persist($userLogger);
            $entityManager->flush();
            return $this->redirectToRoute('app_personal_details');
        }

        return $this->render('dashboard/index.html.twig', [

        ]);
    }
}
