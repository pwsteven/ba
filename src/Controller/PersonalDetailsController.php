<?php

namespace App\Controller;

use App\Repository\PersonalDetailsRepository;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class PersonalDetailsController
 * @package App\Controller
 * @IsGranted("ROLE_USER")
 */
class PersonalDetailsController extends BaseController
{

    /**
     * @var PersonalDetailsRepository
     */
    private $personalDetailsRepository;

    public function __construct(PersonalDetailsRepository $personalDetailsRepository)
    {
        $this->personalDetailsRepository = $personalDetailsRepository;
    }

    /**
     * @Route("/dashboard/personal-details", name="app_personal_details")
     * @param Request $request
     * @param EntityManagerInterface $entityManager
     * @return Response
     */
    public function index(Request $request, EntityManagerInterface $entityManager)
    {

        $userID = $this->getUser()->getId();

        return $this->render('dashboard/personal_details.html.twig', [

        ]);
    }
}
