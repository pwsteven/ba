<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\ManualImportType;
use App\Repository\BACorrespondenceRepository;
use App\Repository\ComplaintsRepository;
use App\Repository\ContactDetailsRepository;
use App\Repository\CreditMonitorRepository;
use App\Repository\EmotionalDistressRepository;
use App\Repository\FinancialLossRepository;
use App\Repository\FurtherCorrespondenceRepository;
use App\Repository\PersonalDetailsRepository;
use App\Repository\ReimbursementsRepository;
use App\Repository\UserRepository;
use App\Service\ProClaimRequest;
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

    public function __construct(DataTableFactory $dataTableFactory, RouterInterface $router, UserRepository $userRepository, PersonalDetailsRepository $personalDetailsRepository, ContactDetailsRepository $contactDetailsRepository, BACorrespondenceRepository $BACorrespondenceRepository, FurtherCorrespondenceRepository $furtherCorrespondenceRepository, ComplaintsRepository $complaintsRepository, FinancialLossRepository $financialLossRepository, ReimbursementsRepository $reimbursementsRepository, CreditMonitorRepository $creditMonitorRepository, EmotionalDistressRepository $emotionalDistressRepository)
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
    public function clientEdit(int $id)
    {
        $clientUserDetails = $this->userRepository->findByExampleField($id);
        $clientPersonalDetails = $this->personalDetailsRepository->findByExampleField($id);
        $clientContactDetails = $this->contactDetailsRepository->findByExampleField($id);
        $clientBADetails = $this->BACorrespondenceRepository->findByExampleField($id);
        $clientFurtherCorrespondenceDetails = $this->furtherCorrespondenceRepository->findByExampleField($id);
        $clientComplaintDetails = $this->complaintsRepository->findByExampleField($id);
        $clientFinanceDetails = $this->financialLossRepository->findByExampleField($id);
        $clientReimbursementDetails = $this->reimbursementsRepository->findByExampleField($id);
        $clientCreditDetails = $this->creditMonitorRepository->findByExampleField($id);
        $clientEmotionsDetails = $this->emotionalDistressRepository->findByExampleField($id);

        return $this->render('admin/clients_edit.html.twig', [
            'client_user' => $clientUserDetails,
            'client_personal' => $clientPersonalDetails,
            'client_contact' => $clientContactDetails,
            'client_ba' => $clientBADetails,
            'client_further' => $clientFurtherCorrespondenceDetails,
            'client_complaints' => $clientComplaintDetails,
            'client_finance' => $clientFinanceDetails,
            'client_reimbursements' => $clientReimbursementDetails,
            'client_credit' => $clientCreditDetails,
            'client_emotions' => $clientEmotionsDetails,
        ]);
    }

    /**
     * @Route("admin/clients/delete/{id}", name="app_admin_client_delete")
     * @param int $id
     * @return Response
     */
    public function clientDelete(int $id)
    {
        return $this->render('admin/clients_delete.html.twig', [

        ]);
    }

    /**
     * @Route("admin/clients/proclaim/{id}", name="app_admin_client_proclaim")
     * @param int $id
     * @param User $user
     * @param ProClaimRequest $proClaimRequest
     * @return Response
     */
    public function clientProClaim(int $id, User $user, ProClaimRequest $proClaimRequest)
    {

        $proClaimID = $user->getProClaimReference($id);
        $proClaimDetails = $proClaimRequest->getCaseDetails($proClaimID);

        return $this->render('admin/client_proclaim.html.twig', [
            'proclaim' => $proClaimDetails,
        ]);
    }

    /**
     * @Route("admin/clients/manual-import", name="app_admin_client_manual_import")
     * @param Request $request
     * @return Response
     */
    public function clientManualInput(Request $request)
    {

        $form = $this->createForm(ManualImportType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){

            dd($form->getData());

        }

        return $this->render('admin/client_manual_import.html.twig', [
            'form' => $form->createView(),
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

}
