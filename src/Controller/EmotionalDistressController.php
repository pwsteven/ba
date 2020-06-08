<?php

namespace App\Controller;

use App\Form\EmotionalDistressType;
use App\Repository\EmotionalDistressRepository;
use App\Service\ProClaimPutEmotionalDistress;
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
     * @var string
     * @var string
     * @var string
     * @var string
     * @var string
     * @var string
     * @var string
     * @var string
     * @var string
     * @var string
     */
    private $emotionalDistressRepository;
    private $adverseConsequences;
    private $emotionsExperienced;
    private $breachQuestionA;
    private $breachQuestionB;
    private $breachQuestionC;
    private $breachQuestionD;
    private $breachQuestionE;
    private $breachQuestionF;
    private $breachQuestionG;
    private $stepsTaken;

    public function __construct(EmotionalDistressRepository $emotionalDistressRepository)
    {
        $this->emotionalDistressRepository = $emotionalDistressRepository;
        $this->adverseConsequences = "";
        $this->emotionsExperienced = "";
        $this->breachQuestionA = "";
        $this->breachQuestionB = "";
        $this->breachQuestionC = "";
        $this->breachQuestionD = "";
        $this->breachQuestionE = "";
        $this->breachQuestionF = "";
        $this->breachQuestionG = "";
        $this->stepsTaken = "";
    }

    /**
     * @Route("/dashboard/emotional-distress", name="app_emotional_distress")
     * @param Request $request
     * @param EntityManagerInterface $entityManager
     * @param ProClaimPutEmotionalDistress $proClaimPutEmotionalDistress
     * @return Response
     */
    public function index(Request $request, EntityManagerInterface $entityManager, ProClaimPutEmotionalDistress $proClaimPutEmotionalDistress)
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

            // COMMIT TO PROCLAIM
            if (!empty($emotionalDistressDetails->getEmotionsExperiencedNew())){
                $this->emotionsExperienced = implode(', ', $emotionalDistressDetails->getEmotionsExperiencedNew());
            }
            if (!empty($emotionalDistressDetails->getBreachQuestionA())){
                $this->breachQuestionA = implode(', ', $emotionalDistressDetails->getBreachQuestionA());
            }
            if (!empty($emotionalDistressDetails->getBreachQuestionB())){
                $this->breachQuestionB = implode(', ', $emotionalDistressDetails->getBreachQuestionB());
            }
            if (!empty($emotionalDistressDetails->getBreachQuestionC())){
                $this->breachQuestionC = implode(', ', $emotionalDistressDetails->getBreachQuestionC());
            }
            if (!empty($emotionalDistressDetails->getBreachQuestionD())){
                $this->breachQuestionD = implode(', ', $emotionalDistressDetails->getBreachQuestionD());
            }
            if (!empty($emotionalDistressDetails->getBreachQuestionE())){
                $this->breachQuestionE = implode(', ', $emotionalDistressDetails->getBreachQuestionE());
            }
            if (!empty($emotionalDistressDetails->getBreachQuestionF())){
                $this->breachQuestionF = implode(', ', $emotionalDistressDetails->getBreachQuestionF());
            }
            if (!empty($emotionalDistressDetails->getBreachQuestionG())){
                $this->breachQuestionG = implode(', ', $emotionalDistressDetails->getBreachQuestionG());
            }
            if (!empty($emotionalDistressDetails->getAdverseConsequences())) {
                $this->adverseConsequences = implode(', ', $emotionalDistressDetails->getAdverseConsequences());
            }
            if (!empty($emotionalDistressDetails->getStepsTaken())){
                $this->stepsTaken = implode(', ', $emotionalDistressDetails->getStepsTaken());
            }

            $data = [
                'case_id' => $this->getUser()->getProClaimReference(),
                'personal_details' => $emotionalDistressDetails->getPersonalDetails(),
                'emotions_experienced_new' => $this->emotionsExperienced,
                'emotions_experienced_comment' => $emotionalDistressDetails->getEmotionsExperiencedComment(),
                'emotional_distress_lasted' => $emotionalDistressDetails->getEmotionalDistressLasted(),
                'breach_question_a' => $this->breachQuestionA,
                'breach_question_a_example' => $emotionalDistressDetails->getBreachQuestionAExample(),
                'breach_question_b' => $this->breachQuestionB,
                'breach_question_b_example' => $emotionalDistressDetails->getBreachQuestionBExample(),
                'breach_question_c' => $this->breachQuestionC,
                'breach_question_c_example' => $emotionalDistressDetails->getBreachQuestionCExample(),
                'breach_question_d' => $this->breachQuestionD,
                'breach_question_d_example' => $emotionalDistressDetails->getBreachQuestionDExample(),
                'breach_question_e' => $this->breachQuestionE,
                'breach_question_e_example' => $emotionalDistressDetails->getBreachQuestionEExample(),
                'breach_question_f' => $this->breachQuestionF,
                'breach_question_f_example' => $emotionalDistressDetails->getBreachQuestionFExample(),
                'breach_question_g' => $this->breachQuestionG,
                'breach_question_g_example' => $emotionalDistressDetails->getBreachQuestionGExample(),
                'diagnosed_conditions' => $emotionalDistressDetails->getDiagnosedConditionsNew(),
                'diagnosed_conditions_example' => $emotionalDistressDetails->getDiagnosedConditionsExample(),
                'impact_condition' => $emotionalDistressDetails->getImpactConditionNew(),
                'impact_condition_example' => $emotionalDistressDetails->getImpactConditionExample(),
                'steps_taken' => $this->stepsTaken,
                'steps_taken_example' => $emotionalDistressDetails->getStepsTakenExample(),
                'steps_taken_details' => $emotionalDistressDetails->getStepsTakenDetails(),
                'adverse_consequences' => $this->adverseConsequences,
                'adverse_consequences_example' => $emotionalDistressDetails->getAdverseConsequencesExample(),
                'adverse_consequences_details' => $emotionalDistressDetails->getAdverseConsequencesDetails(),
                'additional_information' => $emotionalDistressDetails->getAdditionalInformation(),
                'lead_test_claimant' => $emotionalDistressDetails->getLeadTestClaimant(),
            ];
            //dd($data);
            $proClaimPutEmotionalDistress->putCaseDetails($data);

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
