<?php

namespace App\Controller;

use App\Form\EmotionalDistressType;
use App\Repository\EmotionalDistressRepository;
use App\Service\ProClaimPutEmotionalDistress;
use App\Service\UploaderHelper;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\HttpFoundation\File\UploadedFile;
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

            //COLLECT + UPLOAD FILE|IMAGE FILES
            /** @var UploadedFile $stepsTakenFiles */
            $stepsTakenFiles = $form['stepsTakenFiles']->getData();
            if ($stepsTakenFiles) {
                $filesData = [];
                foreach ($stepsTakenFiles as $stepsTakenFile) {
                    $newFileName = $uploaderHelper->uploadClientFile($stepsTakenFile);
                    $filesData[] = $newFileName;
                }
                $emotionalDistressDetails->setStepsTakenFilesPath($filesData);
            }

            /** @var UploadedFile $adverseConsequencesFiles */
            $adverseConsequencesFiles = $form['adverseConsequencesFiles']->getData();
            if ($adverseConsequencesFiles) {
                $filesData = [];
                foreach ($adverseConsequencesFiles as $adverseConsequencesFile) {
                    $newFileName = $uploaderHelper->uploadClientFile($adverseConsequencesFile);
                    $filesData[] = $newFileName;
                }
                $emotionalDistressDetails->setAdverseConsequencesFilesPath($filesData);
            }


            // COMMIT FORM FIELD VALUES TO DATABASE
            $emotionalDistressDetails->setComplete(true);
            $userSetEmotionalDistress = $this->getUser()->setAppEmotionalDistress(true);
            $userSetAppCurrentForm = $this->getUser()->setAppCurrentForm('app_emotional_distress');
            $userSetAppComplete = $this->getUser()->setAppCompleted(true);

            $entityManager->persist($userSetEmotionalDistress);
            $entityManager->persist($userSetAppCurrentForm);
            $entityManager->persist($userSetAppComplete);
            $entityManager->persist($emotionalDistressDetails);
            $entityManager->flush();



            // REDIRECT TO NEXT PAGE
            $this->addFlash('page_success', 'Emotional Distress stage complete!');
            return $this->redirectToRoute('app_complete');

        }

        return $this->render('dashboard/emotional_distress.html.twig', [
            'header_text' => 'Emotional Distress',
            'form' => $form->createView(),
        ]);
    }
}
