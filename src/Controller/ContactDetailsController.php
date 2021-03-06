<?php

namespace App\Controller;

use App\Form\ContactDetailsType;
use App\Repository\ContactDetailsRepository;
use App\Service\ProClaimPutContactDetails;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class ContactDetailsController
 * @package App\Controller
 * @IsGranted("ROLE_USER")
 */
class ContactDetailsController extends BaseController
{

    /**
     * @var ContactDetailsRepository
     */
    private $contactDetailsRepository;

    public function __construct(ContactDetailsRepository $contactDetailsRepository)
    {
        $this->contactDetailsRepository = $contactDetailsRepository;
    }

    /**
     * @Route("/dashboard/contact-details", name="app_contact_details")
     * @param Request $request
     * @param EntityManagerInterface $entityManager
     * @param ProClaimPutContactDetails $proClaimPutContactDetails
     * @return Response
     */
    public function index(Request $request, EntityManagerInterface $entityManager, ProClaimPutContactDetails $proClaimPutContactDetails)
    {
        $showForm = $this->getUser()->getAppPersonalDetails();
        if (!$showForm){
            return $this->redirectToRoute('app_dashboard');
        }

        $userID = $this->getUser()->getId();
        $contactDetails = $this->contactDetailsRepository->findOneBySomeField($userID);
        $form = $this->createForm(ContactDetailsType::class, $contactDetails);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){

            //Commit form values to the database
            $contactDetails->setCompleted(true);
            $userSetPersonalDetails = $this->getUser()->setAppContactDetails(true);
            $userSetAppCurrentForm = $this->getUser()->setAppCurrentForm('app_ba_correspondence');
            $entityManager->persist($userSetPersonalDetails);
            $entityManager->persist($userSetAppCurrentForm);
            $entityManager->persist($contactDetails);
            $entityManager->flush();

            $address_block = $contactDetails->getStreetAddress().', ';
            if (!empty($contactDetails->getStreetAddress2())):
                $address_block .= $contactDetails->getStreetAddress2().', ';
            endif;
            if (!empty($contactDetails->getStreetAddress3())):
                $address_block .= $contactDetails->getStreetAddress3().', ';
            endif;
            if (!empty($contactDetails->getTownCity())):
                $address_block .= $contactDetails->getTownCity();
            endif;
            if (!empty($contactDetails->getCounty())):
                $address_block .= ', '.$contactDetails->getCounty();
            endif;
            //Commit to ProClaim
            $data = [
                'case_id' => $this->getUser()->getProClaimReference(),
                'street_address' => $contactDetails->getStreetAddress(),
                'street_address_2' => $contactDetails->getStreetAddress2(),
                'street_address_3' => $contactDetails->getStreetAddress3(),
                'town_city' => $contactDetails->getTownCity(),
                'county' => $contactDetails->getCounty(),
                'postcode' => $contactDetails->getPostcode(),
                'address_block' => $address_block,
                'email' => $contactDetails->getEmailAddress(),
                'mobile_phone' => $contactDetails->getMobileTelephoneNumber(),
            ];

            //dd($data);
            $proClaimPutContactDetails->putCaseDetails($data);

            $this->addFlash('page_success', 'Contact Details stage complete!');
            return $this->redirectToRoute('app_ba_correspondence');
        }

        return $this->render('dashboard/contact_details.html.twig', [
            'header_text' => 'Contact Details',
            'form' => $form->createView(),
        ]);
    }
}
