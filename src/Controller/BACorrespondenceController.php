<?php

namespace App\Controller;


use App\Form\BACorrespondenceType;
use App\Repository\BACorrespondenceRepository;
use App\Repository\FileReferenceRepository;
use App\Service\ProClaimPutBACorrespondence;
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
     * @var FileReferenceRepository
     */
    private $BACorrespondenceRepository;
    private $fileReferenceRepository;

    public function __construct(BACorrespondenceRepository $BACorrespondenceRepository, FileReferenceRepository $fileReferenceRepository)
   {
       $this->BACorrespondenceRepository = $BACorrespondenceRepository;
       $this->fileReferenceRepository = $fileReferenceRepository;
   }

    /**
     * @Route("/dashboard/ba-correspondence", name="app_ba_correspondence")
     * @param Request $request
     * @param EntityManagerInterface $entityManager
     * @param ProClaimPutBACorrespondence $proClaimPutBACorrespondence
     * @return Response
     */
    public function index(Request $request, EntityManagerInterface $entityManager, ProClaimPutBACorrespondence $proClaimPutBACorrespondence)
    {

        $showForm = $this->getUser()->getAppContactDetails();
        if (!$showForm){
            return $this->redirectToRoute('app_dashboard');
        }

        $userID = $this->getUser()->getId();
        $baCorrespondenceDetails = $this->BACorrespondenceRepository->findOneBySomeField($userID);
        $fileReferences = $this->fileReferenceRepository->findByExampleField($userID);

        $form = $this->createForm(BACorrespondenceType::class, $baCorrespondenceDetails);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){

            // COMMIT FORM FIELD VALUES TO DATABASE
            $baCorrespondenceDetails->setComplete(true);
            $userSetBACorrespondence = $this->getUser()->setAppBACorrespondence(true);
            $UserSetAppCurrentForm = $this->getUser()->setAppCurrentForm('app_ba_correspondence');
            $entityManager->persist($userSetBACorrespondence);
            $entityManager->persist($UserSetAppCurrentForm);
            $entityManager->persist($baCorrespondenceDetails);
            $entityManager->flush();

            // COMMIT TO PROCLAIM TODO

            if (!empty($baCorrespondenceDetails->getBreachOneDateReceived())){
                $breach_one_date_received = date_format($baCorrespondenceDetails->getBreachOneDateReceived(), 'd/m/Y');
            } else {
                $breach_one_date_received = "";
            }
            if (!empty($baCorrespondenceDetails->getBreachOneDateOfBooking())){
                $breach_one_date_of_booking = date_format($baCorrespondenceDetails->getBreachOneDateOfBooking(), 'd/m/Y');
            } else {
                $breach_one_date_of_booking = "";
            }

            if (!empty($baCorrespondenceDetails->getBreachTwoDateReceived())) {
                $breach_two_date_received = date_format($baCorrespondenceDetails->getBreachTwoDateReceived(), 'd/m/Y');
            } else {
                $breach_two_date_received = "";
            }
            if (!empty($baCorrespondenceDetails->getBreachTwoDateOfBooking())){
                $breach_two_date_of_booking = date_format($baCorrespondenceDetails->getBreachTwoDateOfBooking(), 'd/m/Y');
            } else {
                $breach_two_date_of_booking = "";
            }

            $data = [
                'case_id' => $this->getUser()->getProClaimReference(),
                'ba_correspondence_email' => $baCorrespondenceDetails->getReceivedConfirmationEmail(),
                'breach_one_notification' => $baCorrespondenceDetails->getBreachOneNotification(),
                'breach_one_date_received' => $breach_one_date_received,
                'breach_one_notification_not_affected' => $baCorrespondenceDetails->getBreachOneNotificationNotAffected(),
                'breach_one_date_of_booking' => $breach_one_date_of_booking,
                'breach_one_email_address_used' => $baCorrespondenceDetails->getBreachOneEmailAddressUsed(),
                'breach_one_booking_reference' => $baCorrespondenceDetails->getBreachOneBookingReference(),
                'breach_one_booking_platform' => $baCorrespondenceDetails->getBreachOneBookingPlatform(),
                'breach_one_payment_method' => $baCorrespondenceDetails->getBreachOnePaymentMethod(),
                'breach_two_notification' => $baCorrespondenceDetails->getBreachTwoNotification(),
                'breach_two_date_received' => $breach_two_date_received,
                'breach_two_notification_not_affected' => $baCorrespondenceDetails->getBreachTwoNotificationNotAffected(),
                'breach_two_date_of_booking' => $breach_two_date_of_booking,
                'breach_two_email_address_used' => $baCorrespondenceDetails->getBreachTwoEmailAddressUsed(),
                'breach_two_booking_reference' => $baCorrespondenceDetails->getBreachTwoBookingReference(),
                'breach_two_booking_platform' => $baCorrespondenceDetails->getBreachTwoBookingPlatform(),
                'breach_two_payment_method' => $baCorrespondenceDetails->getBreachTwoPaymentMethod(),
            ];
            //dd($data);
            $proClaimPutBACorrespondence->putCaseDetails($data);

            // REDIRECT TO NEXT PAGE TODO
            $this->addFlash('page_success', 'BA Correspondence stage complete!');
            return $this->redirectToRoute('app_further_correspondence');

        }


        return $this->render('dashboard/ba_correspondence.html.twig', [
            'header_text' => 'BA Correspondence',
            'form' => $form->createView(),
            'files' => $fileReferences,
        ]);
    }
}
