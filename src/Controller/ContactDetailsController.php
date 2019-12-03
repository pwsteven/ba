<?php

namespace App\Controller;

use App\Form\ContactDetailsType;
use App\Repository\ContactDetailsRepository;
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
     * @return Response
     */
    public function index(Request $request, EntityManagerInterface $entityManager)
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
            $contactDetails->setCompleted(true);
            $userSetPersonalDetails = $this->getUser()->setAppContactDetails(true);
            $userSetAppCurrentForm = $this->getUser()->setAppCurrentForm('app_ba_correspondence');
            $entityManager->persist($userSetPersonalDetails);
            $entityManager->persist($userSetAppCurrentForm);
            $entityManager->persist($contactDetails);
            $entityManager->flush();
            $this->addFlash('success', 'Success! You have completed the Contact Details stage.');
            return $this->redirectToRoute('app_ba_correspondence');
        }

        return $this->render('dashboard/contact_details.html.twig', [
            'step_integer' => 20,
            'step_string' => 'Step 2 of 10',
            'header_icon' => 'ik ik-edit',
            'header_text' => 'Contact Details',
            'form' => $form->createView(),
        ]);
    }
}
