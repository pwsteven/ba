<?php

namespace App\Controller;


use App\Form\BACorrespondenceType;
use App\Repository\BACorrespondenceRepository;
use App\Service\UploaderHelper;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class BACorrespondenceController
 * @package App\Controller
 * @IsGranted("ROLE_USER")
 */
class BACorrespondenceController extends BaseController
{

    /**
     * @var BACorrespondenceRepository
     */
    private $BACorrespondenceRepository;

    public function __construct(BACorrespondenceRepository $BACorrespondenceRepository)
   {
       $this->BACorrespondenceRepository = $BACorrespondenceRepository;
   }

    /**
     * @Route("/dashboard/ba-correspondence", name="app_ba_correspondence")
     * @param Request $request
     * @param EntityManagerInterface $entityManager
     * @param UploaderHelper $uploaderHelper
     * @return Response
     */
    public function index(Request $request, EntityManagerInterface $entityManager, UploaderHelper $uploaderHelper)
    {

        $userID = $this->getUser()->getId();
        $baCorrespondenceDetails = $this->BACorrespondenceRepository->findOneBySomeField($userID);

        $form = $this->createForm(BACorrespondenceType::class, $baCorrespondenceDetails);
        $form->handleRequest($request);


        return $this->render('dashboard/ba_correspondence.html.twig', [
            'step_integer' => 30,
            'step_string' => 'Step 3 of 10',
            'header_icon' => 'ik ik-navigation',
            'header_text' => 'BA Correspondence',
            'form' => $form->createView(),
        ]);
    }
}
