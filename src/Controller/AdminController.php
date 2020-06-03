<?php

namespace App\Controller;

use App\Repository\BACorrespondenceRepository;
use App\Repository\CreditMonitorRepository;
use App\Repository\EmotionalDistressRepository;
use App\Repository\FinancialLossRepository;
use App\Repository\FurtherCorrespondenceRepository;
use App\Repository\PersonalDetailsRepository;
use App\Repository\ReimbursementsRepository;
use App\Repository\UserRepository;
use App\Service\ProClaimPutPersonalDetails;
use App\Service\ProClaimRequest;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


/**
 * Class AdminController
 * @package App\Controller
 * @IsGranted("ROLE_ADMIN")
 */
class AdminController extends BaseController
{

    /**
     * @var string
     * @var PersonalDetailsRepository
     * @var UserRepository
     * @var BACorrespondenceRepository
     * @var FurtherCorrespondenceRepository
     * @var EmotionalDistressRepository
     * @var FinancialLossRepository
     * @var ReimbursementsRepository
     * @var CreditMonitorRepository
     */
    private $uploadUrl;
    private $personalDetailsRepository;
    private $userRepository;
    private $BACorrespondenceRepository;
    private $furtherCorrespondenceRepository;
    private $emotionalDistressRepository;
    private $financialLossRepository;
    private $reimbursementsRepository;
    private $creditMonitorRepository;

    public function __construct(string $uploadUrl, BACorrespondenceRepository $BACorrespondenceRepository, FurtherCorrespondenceRepository $furtherCorrespondenceRepository, PersonalDetailsRepository $personalDetailsRepository, EmotionalDistressRepository $emotionalDistressRepository, UserRepository $userRepository, FinancialLossRepository $financialLossRepository, ReimbursementsRepository $reimbursementsRepository, CreditMonitorRepository $creditMonitorRepository)
    {
        $this->uploadUrl = $uploadUrl;
        $this->personalDetailsRepository = $personalDetailsRepository;
        $this->userRepository = $userRepository;
        $this->BACorrespondenceRepository = $BACorrespondenceRepository;
        $this->furtherCorrespondenceRepository = $furtherCorrespondenceRepository;
        $this->emotionalDistressRepository = $emotionalDistressRepository;
        $this->financialLossRepository = $financialLossRepository;
        $this->reimbursementsRepository = $reimbursementsRepository;
        $this->creditMonitorRepository = $creditMonitorRepository;
    }

    /**
     * @Route("/admin", name="app_admin")
     */
    public function index()
    {
        return $this->render('admin/index.html.twig', [

        ]);
    }

    /**
     * @Route("/admin/users", name="app_admin_users")
     */
    public function viewUsers()
    {
        return $this->render('admin/view_users.html.twig', [
            'controller_name' => 'AdminController',
        ]);
    }

    /**
     * @Route("/admin/proclaim-request/{id}", name="app_admin_proclaim_get")
     * @param int $id
     * @param ProClaimRequest $proClaimRequest
     * @return Response
     */
    public function getProClaimCaseDetails(int $id, ProClaimRequest $proClaimRequest)
    {

        $proClaimDetails = $proClaimRequest->getCaseDetails($id);
        $userID = $this->userRepository->findOneBySomeField($id);
        $personalDetails = $this->personalDetailsRepository->findOneBySomeField($userID);
        $baCorrespondenceDetails = $this->BACorrespondenceRepository->findOneBySomeField($userID);
        $furtherCorrespondenceDetails = $this->furtherCorrespondenceRepository->findOneBySomeField($userID);
        $financialLossDetails = $this->financialLossRepository->findOneBySomeField($userID);
        $emotionalDistressDetails = $this->emotionalDistressRepository->findOneBySomeField($userID);
        $reimbursementDetails = $this->reimbursementsRepository->findOneBySomeField($userID);
        $creditMonitorDetails = $this->creditMonitorRepository->findOneBySomeField($userID);
        $imagePath = $personalDetails->getImageFileName();
        return $this->render('admin/proclaim_get.html.twig', [
            'proClaimData' => $proClaimDetails,
            'imagePath' => $imagePath,
            'ba' => $baCorrespondenceDetails,
            'fc' => $furtherCorrespondenceDetails,
            'fl' => $financialLossDetails,
            'ed' => $emotionalDistressDetails,
            're' => $reimbursementDetails,
            'cm' => $creditMonitorDetails,
        ]);

    }

    /**
     * @Route("/admin/proclaim-update/{id}", name="app_admin_proclaim_put")
     * @param int $id
     * @param ProClaimPutPersonalDetails $proClaimPutPersonalDetails
     * @return Response
     */
    public function putProClaimPersonalDetails(int $id, ProClaimPutPersonalDetails $proClaimPutPersonalDetails)
    {

        $stream_opts = [
            "ssl" => [
                "verify_peer"=>false,
                "verify_peer_name"=>false,
            ]
        ];


        $image = file_get_contents($this->uploadUrl.'/user.jpg', false, stream_context_create($stream_opts));
        $image_data = base64_encode($image);

        $data = [
            'case_id' => $id,
            'title' => 'Mr',
            //'image' => $image_data,
            'image' => $image,
        ];
        $proClaimDetails = $proClaimPutPersonalDetails->putCaseDetails($data);
        return $this->render('admin/proclaim_put.html.twig', [
            'proClaimData' => $proClaimDetails,
        ]);
    }

}
