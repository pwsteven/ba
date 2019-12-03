<?php


namespace App\Service;

use Zend\Soap\Client;

class ProClaimRequest
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

    public function getCaseDetails(int $caseRefNo): array
    {

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

            // GET CLAIM TYPE CODE
            $param = [
                'csessionid' => $session_id,
                'ccasetype' => '93',
                'ccaseno' => $caseRefNo,
                'cfieldname' => 'Claim Type.Code',
            ];
            $response = $client->proGetData($param);
            if ($response->cstatus != 'OK') {
                $data['claim_type_code'] = $response->cerror;
            } else {
                $session_id = $response->csessionid;
                $case_field_value = $response->cfieldvalue;
                $data['claim_type_code'] = $case_field_value;
            }

            // GET CLAIM TYPE DESCRIPTION
            $param = [
                'csessionid' => $session_id,
                'ccasetype' => '93',
                'ccaseno' => $caseRefNo,
                'cfieldname' =>'Claim Type - Confidential.Response',
            ];
            $response = $client->proGetData($param);
            $session_id = $response->csessionid;
            if ($response->cstatus!='OK') {
                $data['claim_type_confidential_response'] = $response->cerror;
            } else {
                $session_id = $response->csessionid;
                $case_field_value = $response->cfieldvalue;
                $data['claim_type_confidential_response'] = $case_field_value;
            }

            // GET CLIENT TITLE
            $param = [
                'csessionid' => $session_id,
                'ccasetype' => '93',
                'ccaseno' => $caseRefNo,
                'cfieldname' => 'Client.Title',
            ];
            $response = $client->proGetData($param);
            if ($response->cstatus!='OK') {
                $data['claim_type_client_title'] = $response->cerror;
            } else {
                $session_id = $response->csessionid;
                $case_field_value = $response->cfieldvalue;
                $data['claim_type_client_title'] = $case_field_value;
            }

            // GET CLIENT FIRST NAME
            $param = [
                'csessionid' => $session_id,
                'ccasetype' => '93',
                'ccaseno' => $caseRefNo,
                'cfieldname' => 'Client.Forename',
            ];
            $response = $client->proGetData($param);
            if ($response->cstatus!='OK') {
                $data['claim_type_client_forename'] = $response->cerror;
            } else {
                $session_id = $response->csessionid;
                $case_field_value = $response->cfieldvalue;
                $data['claim_type_client_forename'] = $case_field_value;
            }

            // GET CLIENT MIDDLE NAME
            $param = [
                'csessionid' => $session_id,
                'ccasetype' => '93',
                'ccaseno' => $caseRefNo,
                'cfieldname' => 'Client.udf5',
            ];
            $response = $client->proGetData($param);
            if ($response->cstatus!='OK') {
                $data['claim_type_client_middle_name'] = $response->cerror;
            } else {
                $session_id = $response->csessionid;
                $case_field_value = $response->cfieldvalue;
                $data['claim_type_client_middle_name'] = $case_field_value;
            }

            // GET CLIENT SURNAME
            $param = [
                'csessionid' => $session_id,
                'ccasetype' => '93',
                'ccaseno' => $caseRefNo,
                'cfieldname' => 'Client.Name',
            ];
            $response = $client->proGetData($param);
            if ($response->cstatus!='OK') {
                $data['claim_type_client_surname'] = $response->cerror;
            } else {
                $session_id = $response->csessionid;
                $case_field_value = $response->cfieldvalue;
                $data['claim_type_client_surname'] = $case_field_value;
            }

            // LOGOUT OF PROCLAIM
            $client->proLogout([
                'csessionid' => $session_id,
            ]);

        }

        return $data;

    }
}