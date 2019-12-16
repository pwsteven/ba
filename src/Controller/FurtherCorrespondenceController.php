<?php

namespace App\Controller;

use App\Form\FurtherCorrespondenceType;
use App\Repository\FurtherCorrespondenceRepository;
use App\Service\ProClaimPutFurtherCorrespondence;
use App\Service\UploaderHelper;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class FurtherCorrespondenceController
 * @package App\Controller
 * @IsGranted("ROLE_USER")
 */
class FurtherCorrespondenceController extends BaseController
{

    /**
     * @var FurtherCorrespondenceRepository
     */
    private $furtherCorrespondenceRepository;

    public function __construct(FurtherCorrespondenceRepository $furtherCorrespondenceRepository)
   {
       $this->furtherCorrespondenceRepository = $furtherCorrespondenceRepository;
   }

    /**
     * @Route("/dashboard/further-correspondence", name="app_further_correspondence")
     * @param Request $request
     * @param EntityManagerInterface $entityManager
     * @param UploaderHelper $uploaderHelper
     * @param ProClaimPutFurtherCorrespondence $proClaimPutFurtherCorrespondence
     * @return Response
     */
    public function index(Request $request, EntityManagerInterface $entityManager, UploaderHelper $uploaderHelper, ProClaimPutFurtherCorrespondence $proClaimPutFurtherCorrespondence)
    {

        $showForm = $this->getUser()->getAppBACorrespondence();
        if (!$showForm){
            return $this->redirectToRoute('app_dashboard');
        }

        $userID = $this->getUser()->getId();
        $furtherCorrespondenceDetails = $this->furtherCorrespondenceRepository->findOneBySomeField($userID);

        $form = $this->createForm(FurtherCorrespondenceType::class, $furtherCorrespondenceDetails);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){

            //COLLECT + UPLOAD FILE|IMAGE FILES
            /** @var UploadedFile $personalInformationBreachedFile */
            $personalInformationBreachedFile = $form['personalInformationBreachedFile']->getData();
            if ($personalInformationBreachedFile){
                $newFileName = $uploaderHelper->uploadClientFile($personalInformationBreachedFile);
                $furtherCorrespondenceDetails->setPersonalInformationBreachedFilePath($newFileName);
            }

            /** @var UploadedFile $allCorrespondenceSentReceivedFiles */
            $allCorrespondenceSentReceivedFiles = $form['allCorrespondenceSentReceivedFile']->getData();
            if ($allCorrespondenceSentReceivedFiles){
                $filesData = [];
                foreach ($allCorrespondenceSentReceivedFiles as $allCorrespondenceSentReceivedFile){
                    $newFileName = $uploaderHelper->uploadClientFile($allCorrespondenceSentReceivedFile);
                    $filesData[] = $newFileName;
                }
                $furtherCorrespondenceDetails->setAllCorrespondenceSentReceivedFilePath($filesData);
            }

            // COMMIT FORM FIELD VALUES TO DATABASE
            $furtherCorrespondenceDetails->setComplete(true);
            $userSetFurtherCorrespondence = $this->getUser()->setAppFutherCorrespondence(true);
            $userSetAppCurrentForm = $this->getUser()->setAppCurrentForm('app_further_correspondence');
            $entityManager->persist($userSetFurtherCorrespondence);
            $entityManager->persist($userSetAppCurrentForm);
            $entityManager->persist($furtherCorrespondenceDetails);
            $entityManager->flush();

            // COMMIT TO PROCLAIM TODO
            $data = [
                'case_id' => $this->getUser()->getProClaimReference(),
                'received_any_other_ba_correspondence' => $furtherCorrespondenceDetails->getReceivedAnyOtherBACorrespondence(),
            ];
            $proClaimPutFurtherCorrespondence->putCaseDetails($data);

            // REDIRECT TO NEXT PAGE
            $this->addFlash('success', 'Success! You have completed the Further Correspondence stage.');
            return $this->redirectToRoute('app_complaints');

        }

        return $this->render('dashboard/further_correspondence.html.twig', [
            'step_integer' => 40,
            'step_string' => 'Step 4 of 10',
            'header_icon' => 'ik ik-at-sign',
            'header_text' => 'Further Correspondence',
            'form' => $form->createView(),
        ]);
    }
}
