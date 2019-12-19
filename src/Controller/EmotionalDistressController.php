<?php

namespace App\Controller;

use App\Form\EmotionalDistressType;
use App\Repository\EmotionalDistressRepository;
use App\Service\ProClaimPutEmotionalDistress;
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
     * @var EmotionalDistressRepository
     */
    private $emotionalDistressRepository;

    public function __construct(EmotionalDistressRepository $emotionalDistressRepository)
    {
        $this->emotionalDistressRepository = $emotionalDistressRepository;
    }

    /**
     * @Route("/dashboard/emotional-distress", name="app_emotional_distress")
     * @param Request $request
     * @param EntityManagerInterface $entityManager
     * @param UploaderHelper $uploaderHelper
     * @param ProClaimPutEmotionalDistress $proClaimPutEmotionalDistress
     * @return Response
     */
    public function index(Request $request, EntityManagerInterface $entityManager, UploaderHelper $uploaderHelper, ProClaimPutEmotionalDistress $proClaimPutEmotionalDistress)
    {

        $showForm = $this->getUser()->getAppCreditMonitoring();
        if (!$showForm){
            return $this->redirectToRoute('app_dashboard');
        }

        $userID = $this->getUser()->getId();
        $emotionalDistressDetails = $this->emotionalDistressRepository->findOneBySomeField($userID);

        $form = $this->createForm(EmotionalDistressType::class, $emotionalDistressDetails);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            dd($form->getData());
        }

        return $this->render('dashboard/emotional_distress.html.twig', [
            'step_integer' => 90,
            'step_string' => 'Step 9 of 10',
            'header_icon' => 'ik ik-flag',
            'header_text' => 'Emotional Distress',
            'form' => $form->createView(),
        ]);
    }
}
