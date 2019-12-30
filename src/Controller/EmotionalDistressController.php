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

            $entityManager->persist($userSetEmotionalDistress);
            $entityManager->persist($userSetAppCurrentForm);
            $entityManager->persist($emotionalDistressDetails);
            $entityManager->flush();

            // COMMIT TO PROCLAIM TODO

            $adverseConsequences = "";
            if (!empty($emotionalDistressDetails->getAdverseConsequences())) {
                $adverseConsequences = implode(', ', $emotionalDistressDetails->getAdverseConsequences());
            }

            $data = [
                'case_id' => $this->getUser()->getProClaimReference(),
                'personal_details' => $emotionalDistressDetails->getPersonalDetails(),
                'emotions_experienced_new' => $emotionalDistressDetails->getEmotionsExperiencedNew(),
                'emotions_experienced_comment' => $emotionalDistressDetails->getEmotionsExperiencedComment(),
                'emotional_distress_lasted' => $emotionalDistressDetails->getEmotionalDistressLasted(),
                'breach_question_a' => $emotionalDistressDetails->getBreachQuestionA(),
                'breach_question_a_example' => $emotionalDistressDetails->getBreachQuestionAExample(),
                'breach_question_b' => $emotionalDistressDetails->getBreachQuestionB(),
                'breach_question_b_example' => $emotionalDistressDetails->getBreachQuestionBExample(),
                'breach_question_c' => $emotionalDistressDetails->getBreachQuestionC(),
                'breach_question_c_example' => $emotionalDistressDetails->getBreachQuestionCExample(),
                'breach_question_d' => $emotionalDistressDetails->getBreachQuestionD(),
                'breach_question_d_example' => $emotionalDistressDetails->getBreachQuestionDExample(),
                'breach_question_e' => $emotionalDistressDetails->getBreachQuestionE(),
                'breach_question_e_example' => $emotionalDistressDetails->getBreachQuestionEExample(),
                'breach_question_f' => $emotionalDistressDetails->getBreachQuestionF(),
                'breach_question_f_example' => $emotionalDistressDetails->getBreachQuestionFExample(),
                'breach_question_g' => $emotionalDistressDetails->getBreachQuestionG(),
                'breach_question_g_example' => $emotionalDistressDetails->getBreachQuestionGExample(),
                'diagnosed_conditions' => $emotionalDistressDetails->getDiagnosedConditions(),
                'diagnosed_conditions_example' => $emotionalDistressDetails->getDiagnosedConditionsExample(),
                'impact_condition' => $emotionalDistressDetails->getImpactCondition(),
                'impact_condition_example' => $emotionalDistressDetails->getImpactConditionExample(),
                'steps_taken' => $emotionalDistressDetails->getStepsTaken(),
                'steps_taken_example' => $emotionalDistressDetails->getStepsTakenExample(),
                'steps_taken_details' => $emotionalDistressDetails->getStepsTakenDetails(),
                'adverse_consequences' => $adverseConsequences,
                'adverse_consequences_example' => $emotionalDistressDetails->getAdverseConsequencesExample(),
                'adverse_consequences_details' => $emotionalDistressDetails->getAdverseConsequencesDetails(),
                'additional_information' => $emotionalDistressDetails->getAdditionalInformation(),
                'lead_test_claimant' => $emotionalDistressDetails->getLeadTestClaimant(),
            ];
            //dd($data);
            $proClaimPutEmotionalDistress->putCaseDetails($data);

            // REDIRECT TO NEXT PAGE
            $this->addFlash('success', 'Success! You have completed the Emotional Distress stage.');
            return $this->redirectToRoute('app_complete');

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
