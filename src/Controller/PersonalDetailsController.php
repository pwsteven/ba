<?php

namespace App\Controller;

use App\Form\PersonalDetailsType;
use App\Repository\PersonalDetailsRepository;
use App\Service\ProClaimRequest;
use App\Service\UploaderHelper;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\HttpFoundation\File\UploadedFile;
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
     * @param UploaderHelper $uploaderHelper
     * @return Response
     */
    public function index(Request $request, EntityManagerInterface $entityManager, UploaderHelper $uploaderHelper)
    {

        $showForm = $this->getUser()->getAppStarted();
        if (!$showForm){
            return $this->redirectToRoute('app_dashboard');
        }

        $userID = $this->getUser()->getId();
        $personalDetails = $this->personalDetailsRepository->findOneBySomeField($userID);
        $form = $this->createForm(PersonalDetailsType::class, $personalDetails);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){


            $personalDetails->setCompleted(true);
            $UserSetPersonalDetails = $this->getUser()->setAppPersonalDetails(true);
            $UserSetAppCurrentForm = $this->getUser()->setAppCurrentForm('app_contact_details');
            $entityManager->persist($UserSetPersonalDetails);
            $entityManager->persist($UserSetAppCurrentForm);
            $entityManager->persist($personalDetails);
            $entityManager->flush();
            $this->addFlash('success', 'Success! You have completed the Personal Details stage.');
            return $this->redirectToRoute('app_contact_details');

        }

        return $this->render('dashboard/personal_details.html.twig', [
            'step_integer' => 10,
            'step_string' => 'Step 1 of 10',
            'header_icon' => 'ik ik-user',
            'header_text' => 'Personal Details',
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/dashboard/proclaim/{id}", name="app_get_proclaim_details")
     * @param int $id
     * @param ProClaimRequest $proClaimRequest
     * @return Response
     */
    public function testGetCase(int $id, ProClaimRequest $proClaimRequest)
    {
        $proClaimRequest->getCaseDetails($id);
        $response = new Response();
        $response->headers->set('Content-Type', 'text/xml; charset=ISO-8859-1');
        return $response;
    }


    /**
     * @Route("dashboard/personal-details/test", name="app_personal_details_test")
     */
    public function temporaryUploadAction(Request $request)
    {
        dd($request->files->get('image'));
    }
}
