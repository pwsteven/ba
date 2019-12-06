<?php

namespace App\Controller;

use App\Form\PersonalDetailsType;
use App\Repository\PersonalDetailsRepository;
use App\Service\ProClaimPutPersonalDetails;
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
     * @param ProClaimPutPersonalDetails $proClaimPutPersonalDetails
     * @return Response
     */
    public function index(Request $request, EntityManagerInterface $entityManager, UploaderHelper $uploaderHelper, ProClaimPutPersonalDetails $proClaimPutPersonalDetails)
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

            //Upload image file if not empty and commit to the database
            /** @var UploadedFile $uploadedFile */
            $uploadedFile = $form['imageFile']->getData();
            if ($uploadedFile) {
                $newFileName = $uploaderHelper->uploadClientFile($uploadedFile);
                $personalDetails->setImageFileName($newFileName);
            }

            //Commit form values to the database
            $personalDetails->setCompleted(true);
            $UserSetPersonalDetails = $this->getUser()->setAppPersonalDetails(true);
            $UserSetAppCurrentForm = $this->getUser()->setAppCurrentForm('app_contact_details');
            $entityManager->persist($UserSetPersonalDetails);
            $entityManager->persist($UserSetAppCurrentForm);
            $entityManager->persist($personalDetails);
            $entityManager->flush();

            //Commit to ProClaim
            $data = [
                'case_id' => $this->getUser()->getProClaimReference(),
                'first_name' => $personalDetails->getFirstName(),
                'middle_name' => $personalDetails->getMiddleName(),
                'surname' => $personalDetails->getSurname(),
                'date_of_birth' => date_format($personalDetails->getDateOfBirth(), "d/m/Y"),
            ];

            //dd($data);
            $proClaimPutPersonalDetails->putCaseDetails($data);

            //Redirect to next page
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

}
