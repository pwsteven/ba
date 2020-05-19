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
                $newFileName = $uploaderHelper->uploadClientFile($uploadedFile, $personalDetails->getImageFileName());
                $personalDetails->setImageFileName($newFileName);
                $userAvatar = $this->getUser()->setAvatar($newFileName);
                $entityManager->persist($userAvatar);
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

            if (!empty($personalDetails->getDateOfBirth())){
                $date_of_birth = date_format($personalDetails->getDateOfBirth(), "d/m/Y");
            } else {
                $date_of_birth = "";
            }

            $data = [
                'case_id' => $this->getUser()->getProClaimReference(),
                'first_name' => $personalDetails->getFirstName(),
                'middle_name' => $personalDetails->getMiddleName(),
                'surname' => $personalDetails->getSurname(),
                'date_of_birth' => $date_of_birth,
            ];

            //dd($data);
            $proClaimPutPersonalDetails->putCaseDetails($data);

            //Redirect to next page
            $this->addFlash('page_success', 'Personal Details stage complete!');
            return $this->redirectToRoute('app_contact_details');

        }

        return $this->render('dashboard/personal_details.html.twig', [
            'header_text' => 'Personal Details',
            'form' => $form->createView(),
        ]);
    }

}
