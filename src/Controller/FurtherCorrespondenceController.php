<?php

namespace App\Controller;

use App\Form\FurtherCorrespondenceType;
use App\Repository\FileReferenceRepository;
use App\Repository\FurtherCorrespondenceRepository;
use App\Service\ProClaimPutFurtherCorrespondence;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
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
     * @var FileReferenceRepository
     */
    private $furtherCorrespondenceRepository;
    private $fileReferenceRepository;

    public function __construct(FurtherCorrespondenceRepository $furtherCorrespondenceRepository, FileReferenceRepository $fileReferenceRepository)
   {
       $this->furtherCorrespondenceRepository = $furtherCorrespondenceRepository;
       $this->fileReferenceRepository = $fileReferenceRepository;
   }

    /**
     * @Route("/dashboard/further-correspondence", name="app_further_correspondence")
     * @param Request $request
     * @param EntityManagerInterface $entityManager
     * @param ProClaimPutFurtherCorrespondence $proClaimPutFurtherCorrespondence
     * @return Response
     */
    public function index(Request $request, EntityManagerInterface $entityManager, ProClaimPutFurtherCorrespondence $proClaimPutFurtherCorrespondence)
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
            $this->addFlash('page_success', 'Further Correspondence stage complete!');
            return $this->redirectToRoute('app_complaints');

        }

        return $this->render('dashboard/further_correspondence.html.twig', [
            'header_text' => 'Further Correspondence',
            'form' => $form->createView(),
        ]);
    }
}
