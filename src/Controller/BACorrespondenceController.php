<?php

namespace App\Controller;


use App\Form\BACorrespondenceType;
use App\Repository\BACorrespondenceRepository;
use App\Service\UploaderHelper;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\HttpFoundation\File\UploadedFile;
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

        if ($form->isSubmitted() && $form->isValid()){

            //COLLECT + UPLOAD FILE|IMAGE FILES
            /** @var UploadedFile $breachOneNotificationFile */
            $breachOneNotificationFile = $form['breachOneNotificationFile']->getData();
            if ($breachOneNotificationFile){
                $newFileName = $uploaderHelper->uploadClientFile($breachOneNotificationFile);
                $baCorrespondenceDetails->setBreachOneNotificationFilePath($newFileName);
            }

            /** @var UploadedFile $breachOneBookingConfirmationFile */
            $breachOneBookingConfirmationFile = $form['breachOneBookingConfirmationFile']->getData();
            if ($breachOneBookingConfirmationFile){
                $newFileName = $uploaderHelper->uploadClientFile($breachOneBookingConfirmationFile);
                $baCorrespondenceDetails->setBreachOneBookingConfirmationFilePath($newFileName);
            }

            // COMMIT FORM FIELD VALUES TO DATABASE
            $baCorrespondenceDetails->setComplete(true);
            $userSetBACorrespondence = $this->getUser()->setAppBACorrespondence(true);
            $UserSetAppCurrentForm = $this->getUser()->setAppCurrentForm('app_ba_correspondence');
            $entityManager->persist($userSetBACorrespondence);
            $entityManager->persist($UserSetAppCurrentForm);
            $entityManager->persist($baCorrespondenceDetails);
            $entityManager->flush();

            // COMMIT TO PROCLAIM TODO
            $data = [
                'case_id' => $this->getUser()->getProClaimReference(),

            ];
            //dd($data);
            //$proClaimPutBACorrespondenceDetails->putCaseDetails($data);

            // REDIRECT TO NEXT PAGE TODO
            $this->addFlash('success', 'Success! You have completed the BA Correspondence stage.');
            return $this->redirectToRoute('app_further_correspondence');

        }


        return $this->render('dashboard/ba_correspondence.html.twig', [
            'step_integer' => 30,
            'step_string' => 'Step 3 of 10',
            'header_icon' => 'ik ik-navigation',
            'header_text' => 'BA Correspondence',
            'form' => $form->createView(),
        ]);
    }
}
