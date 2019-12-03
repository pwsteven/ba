<?php

namespace App\Controller;

use App\Service\ProClaimPutPersonalDetails;
use App\Service\ProClaimRequest;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


/**
 * Class AdminController
 * @package App\Controller
 * @IsGranted("ROLE_ADMIN")
 */
class AdminController extends AbstractController
{

    /**
     * @var string
     */
    private $uploadUrl;

    public function __construct(string $uploadUrl)
    {
        $this->uploadUrl = $uploadUrl;
    }

    /**
     * @Route("/admin", name="app_admin")
     */
    public function index()
    {
        return $this->render('admin/index.html.twig', [
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
        return $this->render('admin/proclaim_get.html.twig', [
            'proClaimData' => $proClaimDetails,
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
