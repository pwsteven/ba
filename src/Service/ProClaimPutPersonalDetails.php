<?php

namespace App\Service;

use Zend\Soap\Client;

class ProClaimPutPersonalDetails
{
    private $proClaimWsdl;
    private $proClaimUser;
    private $proClaimPassword;
    private $proClaimEndPoint;

    public function __construct(string $proClaimWsdl, string $proClaimUser, string $proClaimPassword, string $proClaimEndPoint)
    {
        $this->proClaimWsdl = $proClaimWsdl;
        $this->proClaimUser = $proClaimUser;
        $this->proClaimPassword = $proClaimPassword;
        $this->proClaimEndPoint = $proClaimEndPoint;
    }

    public function putCaseDetails(array $caseData)
    {

        //dd($caseData['image']);

        $data = [];

        $options = [
            'cuser'=>$this->proClaimUser,
            'cpassword'=>$this->proClaimPassword
        ];

        $client = new Client($this->proClaimWsdl, [
            'location'=>$this->proClaimEndPoint,
            'soap_version' => SOAP_1_1,
        ]);

        $reset = $client->proResetLogins($options);
        try {
            $response = $client->proLogin($options);
        } catch (\Exception $exception) {
            echo '<pre>';
            var_dump($exception);
            echo '</pre>';
            exit;
        }

        if ($response->cstatus == 'OK') {

            $session_id = $response->csessionid;

            // UPDATE CASE
            $param = [
                'csessionid' => $session_id,
                'ccasetype' => '93',
                'ccaseno' => $caseData['case_id'],
                'coperation' => 'update',
            ];
            $response = $client->proCaseOpen($param);

            if ($response->cstatus != 'OK') {
                $data['message'] = $response->cerror;
            } else {
                $session_id = $response->csessionid;
                $data['message'] = 'Case updated!';
            }

            // SET LINKED ACTION
            $param = [
                'csessionid' => $session_id,
                'ccasetype' => '93',
                'ccaseno' => $caseData['case_id'],
                'clinkedaction'	=>'Z API AR: BA Initial',
            ];
            $response = $client->proRunLinkedAction($param);
            $session_id = $response->csessionid;
            if ($response->cstatus != 'OK') {
                $data['message'] = 'Set Linked Action Error: ' .$response->cerror;
            }

            // UPDATE TITLE
            $param = [
                'csessionid' => $session_id,
                'ccasetype' => '93',
                'ccaseno' => $caseData['case_id'],
                'cfieldname' => 'Client.Title',
                'cfieldvalue' => $caseData['title'],
            ];
            $response = $client->proPutData($param);
            $session_id = $response->csessionid;
            if ($response->cstatus != 'OK') {
                $data['message'] = 'Set Title Error: ' .$response->cerror;
            }


            // COMMIT TO PROCLAIM
            $param = [
                'csessionid' => $session_id,
                'ccasetype' => '93',
                'ccaseno' => $caseData['case_id'],
                'coperation' => 'save,   unlock',
            ];
            $response = $client->proCaseUpdate($param);
            $session_id = $response->csessionid;

            if ($response->cstatus != 'OK') {
                $data['message'] = 'Commit Error: ' .$response->cerror;
            }

            // LOGOUT OF PROCLAIM
            $client->proLogout([
                'csessionid' => $session_id,
            ]);

        }

        return $data;

    }
}