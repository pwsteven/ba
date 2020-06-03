<?php

namespace App\Controller;

use App\Entity\ApiToken;
use App\Entity\BACorrespondence;
use App\Entity\Complaints;
use App\Entity\ContactDetails;
use App\Entity\CreditMonitor;
use App\Entity\EmotionalDistress;
use App\Entity\FinancialLoss;
use App\Entity\FurtherCorrespondence;
use App\Entity\PersonalDetails;
use App\Entity\Reimbursements;
use App\Entity\User;
use App\Form\ManualImportType;
use App\Repository\ApiTokenRepository;
use App\Repository\BACorrespondenceRepository;
use App\Repository\ComplaintsRepository;
use App\Repository\ContactDetailsRepository;
use App\Repository\CreditMonitorRepository;
use App\Repository\EmotionalDistressRepository;
use App\Repository\FileReferenceRepository;
use App\Repository\FinancialLossRepository;
use App\Repository\FurtherCorrespondenceRepository;
use App\Repository\PersonalDetailsRepository;
use App\Repository\ReimbursementsRepository;
use App\Repository\UserRepository;
use App\Service\ProClaimGetClientStarterDetails;
use App\Service\ProClaimRequest;
use App\Service\SendMail;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\QueryBuilder;
use Omines\DataTablesBundle\Adapter\Doctrine\ORMAdapter;
use Omines\DataTablesBundle\Column\BoolColumn;
use Omines\DataTablesBundle\Column\TextColumn;
use Omines\DataTablesBundle\DataTableFactory;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;


/**
 * Class AdminClientsController
 * @package App\Controller
 * @IsGranted("ROLE_ADMIN")
 */
class AdminClientsController extends BaseController
{

    /**
     * @var DataTableFactory
     * @var RouterInterface
     * @var UserRepository
     * @var PersonalDetailsRepository
     * @var ContactDetailsRepository
     * @var BACorrespondenceRepository
     * @var FurtherCorrespondenceRepository
     * @var ComplaintsRepository
     * @var FinancialLossRepository
     * @var ReimbursementsRepository
     * @var CreditMonitorRepository
     * @var EmotionalDistressRepository
     * @var FileReferenceRepository
     * @var string
     */
    private $dataTableFactory;
    private $router;
    private $userRepository;
    private $personalDetailsRepository;
    private $contactDetailsRepository;
    private $BACorrespondenceRepository;
    private $furtherCorrespondenceRepository;
    private $complaintsRepository;
    private $financialLossRepository;
    private $reimbursementsRepository;
    private $creditMonitorRepository;
    private $emotionalDistressRepository;
    private $fileReferenceRepository;
    private $errorMessage;

    public function __construct(DataTableFactory $dataTableFactory, RouterInterface $router, UserRepository $userRepository, PersonalDetailsRepository $personalDetailsRepository, ContactDetailsRepository $contactDetailsRepository, BACorrespondenceRepository $BACorrespondenceRepository, FurtherCorrespondenceRepository $furtherCorrespondenceRepository, ComplaintsRepository $complaintsRepository, FinancialLossRepository $financialLossRepository, ReimbursementsRepository $reimbursementsRepository, CreditMonitorRepository $creditMonitorRepository, EmotionalDistressRepository $emotionalDistressRepository, FileReferenceRepository $fileReferenceRepository)
    {
        $this->dataTableFactory = $dataTableFactory;
        $this->router = $router;
        $this->userRepository = $userRepository;
        $this->personalDetailsRepository = $personalDetailsRepository;
        $this->contactDetailsRepository = $contactDetailsRepository;
        $this->BACorrespondenceRepository = $BACorrespondenceRepository;
        $this->furtherCorrespondenceRepository = $furtherCorrespondenceRepository;
        $this->complaintsRepository = $complaintsRepository;
        $this->financialLossRepository = $financialLossRepository;
        $this->reimbursementsRepository = $reimbursementsRepository;
        $this->creditMonitorRepository = $creditMonitorRepository;
        $this->emotionalDistressRepository = $emotionalDistressRepository;
        $this->errorMessage = "";
        $this->fileReferenceRepository = $fileReferenceRepository;
    }

    /**
     * @Route("/admin/clients", name="app_admin_clients")
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $table = $this->dataTableFactory->create()
            ->add('firstName', TextColumn::class, [
                'label' => 'Name',
            ])
            ->add('appStarted', BoolColumn::class, [
                'label' => 'Started',
                'trueValue' => 'Yes',
                'falseValue' => 'No',
                'nullValue' => 'No',
            ])
            ->add('appCompleted', BoolColumn::class, [
                'label' => 'Completed',
                'trueValue' => 'Yes',
                'falseValue' => 'No',
                'nullValue' => 'No',
            ])
            ->add('id', TextColumn::class, [
                'label' => 'Actions',
                'className' => 'text-center',
                'render' => function($value) {
                    return '<a href="'.$this->router->generate('app_admin_client_edit', ['id' => $value]).'"><i class="icon icon-auth-screen icon-fw icon-xl"  data-toggle="tooltip" data-placement="top" title="Client Database Entries"></i></a> - <a href="'.$this->router->generate('app_admin_client_proclaim', ['id' => $value]).'" title="Client ProClaim Entries"><i class="icon icon-components icon-fw icon-xl"></i></a> - <a href="'.$this->router->generate('app_admin_client_delete', ['id' => $value]).'" title="Delete Client"><i class="icon icon-close-circle icon-fw icon-xl"></i></a>';
                }
            ])
            ->createAdapter(ORMAdapter::class, [
                'entity' => User::class,
                'query' => function (QueryBuilder $queryBuilder) {
                    $queryBuilder
                        ->select('e')
                        ->from(User::class, 'e')
                        ->where('e.proClaimReference IS NOT NULL')
                    ;
                },
            ])->handleRequest($request);

        if ($table->isCallback()) {
            return $table->getResponse();
        }

        return $this->render('admin/clients.html.twig', [
            'datatable' => $table,
        ]);
    }

    /**
     * @Route("admin/clients/db/{id}", name="app_admin_client_edit")
     * @param int $id
     * @return Response
     */
    public function clientViewDB(int $id)
    {

        return $this->render('admin/clients_view_db.html.twig', [
            'client_user' => $this->userRepository->findByExampleField($id),
            'client_personal' => $this->personalDetailsRepository->findByExampleField($id),
            'client_contact' => $this->contactDetailsRepository->findByExampleField($id),
            'client_ba' => $this->BACorrespondenceRepository->findByExampleField($id),
            'client_further' => $this->furtherCorrespondenceRepository->findByExampleField($id),
            'client_complaints' => $this->complaintsRepository->findByExampleField($id),
            'client_finance' => $this->financialLossRepository->findByExampleField($id),
            'client_reimbursements' => $this->reimbursementsRepository->findByExampleField($id),
            'client_credit' => $this->creditMonitorRepository->findByExampleField($id),
            'client_emotions' => $this->emotionalDistressRepository->findByExampleField($id),
            'files' => $this->fileReferenceRepository->findByExampleField($id),
        ]);
    }

    /**
     * @Route("admin/clients/proclaim/{id}", name="app_admin_client_proclaim")
     * @param User $user
     * @param ProClaimRequest $proClaimRequest
     * @return Response
     */
    public function clientViewProClaim(User $user, ProClaimRequest $proClaimRequest)
    {

        $proClaimID = $user->getProClaimReference();
        $proClaimDetails = $proClaimRequest->getCaseDetails($proClaimID);

        return $this->render('admin/client_view_proclaim.html.twig', [
            'proclaim' => $proClaimDetails,
        ]);
    }

    /**
     * @Route("admin/clients/manual-import", name="app_admin_client_manual_import")
     * @param Request $request
     * @param ProClaimGetClientStarterDetails $claimGetClientStarterDetails
     * @param EntityManagerInterface $entityManager
     * @param UserPasswordEncoderInterface $passwordEncoder
     * @param SendMail $sendMail
     * @param ApiTokenRepository $apiTokenRepository
     * @return Response
     */
    public function clientManualInput(Request $request, ProClaimGetClientStarterDetails $claimGetClientStarterDetails, EntityManagerInterface $entityManager, UserPasswordEncoderInterface $passwordEncoder, SendMail $sendMail, ApiTokenRepository $apiTokenRepository)
    {

        $form = $this->createForm(ManualImportType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){

            date_default_timezone_set('Europe/London');
            $proClaimRefNo = $form['ProClaimRefNo']->getData();
            $proClaimDetails = $claimGetClientStarterDetails->getCaseDetails($proClaimRefNo);
            $tempPassword = $this->randomPassword(8);


            if ($proClaimDetails['client_claim_code'] === "CON"){

                if (!empty($proClaimDetails['client_date_of_birth'])) {
                    $date_of_birth = DateTime::createFromFormat('d/m/Y', $proClaimDetails['client_date_of_birth']);
                    $date_of_birth->format('Ymd');
                } else {
                    $date_of_birth = null;
                }

                // IMPORT DETAILS FROM PROCLAIM TO DATABASE 'USER' TABLE
                $user = new User();
                $user->setEmail($proClaimDetails['client_email']);
                // THIS IS JUST FOR TESTING PURPOSES
                //$user->setEmail('paul@shopnbag.co.uk');
                $user->setRoles(['ROLE_USER']);
                $user->setPassword($passwordEncoder->encodePassword(
                   $user,
                   $tempPassword
                ));
                $user->setFirstName($proClaimDetails['client_forename']);
                $user->setProClaimReference($proClaimRefNo);

                // IMPORT DETAILS FROM PROCLAIM TO DATABASE 'PERSONAL DETAILS' TABLE
                $personalDetails = new PersonalDetails();
                $personalDetails->setUser($user);
                $personalDetails->setFirstName($proClaimDetails['client_forename']);
                $personalDetails->setMiddleName($proClaimDetails['client_middle_name']);
                $personalDetails->setSurname($proClaimDetails['client_surname']);
                $personalDetails->setDateOfBirth($date_of_birth);

                $contactDetails = new ContactDetails();
                $contactDetails->setUser($user);
                /**
                if (!empty($proClaimDetails['client_address_block'])){
                    $contactDetails->setAddressBlock($proClaimDetails['client_address_block']);
                    $contactDetails->setUseClientAddressBlock(true);
                }
                 **/
                $contactDetails->setPostcode($proClaimDetails['client_postcode']);
                $contactDetails->setEmailAddress($proClaimDetails['client_email']);
                $contactDetails->setMobileTelephoneNumber($proClaimDetails['client_mobile_phone']);

                $baCorrespondenceDetails = new BACorrespondence();
                $baCorrespondenceDetails->setUserID($user);

                $furtherCorrespondenceDetails = new FurtherCorrespondence();
                $furtherCorrespondenceDetails->setUser($user);

                $complaintDetails = new Complaints();
                $complaintDetails->setUser($user);

                $financialLossDetails = new FinancialLoss();
                $financialLossDetails->setUser($user);

                $reimbursementDetails = new Reimbursements();
                $reimbursementDetails->setUser($user);

                $creditMonitorDetails = new CreditMonitor();
                $creditMonitorDetails->setUser($user);

                $emotionalDistressDetails = new EmotionalDistress();
                $emotionalDistressDetails->setUser($user);

                // CREATE API TOKEN
                $apiToken = new ApiToken($user);

                $entityManager->persist($user);
                $entityManager->persist($personalDetails);
                $entityManager->persist($contactDetails);
                $entityManager->persist($baCorrespondenceDetails);
                $entityManager->persist($furtherCorrespondenceDetails);
                $entityManager->persist($complaintDetails);
                $entityManager->persist($financialLossDetails);
                $entityManager->persist($reimbursementDetails);
                $entityManager->persist($creditMonitorDetails);
                $entityManager->persist($emotionalDistressDetails);
                $entityManager->persist($apiToken);

                $entityManager->flush();

                $token = $apiTokenRepository->findOneBySomeField($user);

                $sendMail->appInvite($proClaimDetails['client_email'], $proClaimDetails['client_forename'], $this->randomPassword(7).$token->getToken());
                $this->addFlash('client_added_success', 'Client details added... Invitation email sent!');

                return $this->redirectToRoute('app_admin_clients');

            } else {
                // SEND MESSAGE BACK TO FORM THAT PROCLAIM REF NO CANNOT BE FOUND
                $this->errorMessage = 'Sorry! ProClaim Reference Number not found!';
            }

        }

        return $this->render('admin/client_manual_import.html.twig', [
            'form' => $form->createView(),
            'error' => $this->errorMessage,
        ]);
    }

    /**
     * @Route("admin/clients/auto-import", name="app_admin_client_auto_import")
     */
    public function clientAutoInput()
    {

        return $this->render('admin/client_auto_import.html.twig', [

        ]);
    }

    public function randomPassword($length = 8): string
    {
        $chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
        return substr(str_shuffle( $chars ), 0, $length);
    }

    /**
     * @Route("admin/clients/delete/{id}", name="app_admin_client_delete", methods={"DELETE"})
     * @return Response
     */
    public function clientDelete()
    {
        return $this->render('admin/clients_delete.html.twig', [

        ]);
    }

}
