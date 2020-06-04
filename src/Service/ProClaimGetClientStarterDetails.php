<?php


namespace App\Service;


use Zend\Soap\Client;

class ProClaimGetClientStarterDetails
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
                $data['client_claim_code'] = $response->cerror;
            } else {
                $session_id = $response->csessionid;
                $case_field_value = $response->cfieldvalue;
                $data['client_claim_code'] = $case_field_value;
            }

            //**************************************************************************************
            //******************************* PERSONAL DETAILS *************************************
            //**************************************************************************************

            // GET CLIENT FIRST NAME
            $param = [
                'csessionid' => $session_id,
                'ccasetype' => '93',
                'ccaseno' => $caseRefNo,
                'cfieldname' => 'Client.Forename',
            ];
            $response = $client->proGetData($param);
            if ($response->cstatus!='OK') {
                $data['client_forename'] = $response->cerror;
            } else {
                $session_id = $response->csessionid;
                $case_field_value = $response->cfieldvalue;
                $data['client_forename'] = $case_field_value;
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
                $data['client_middle_name'] = $response->cerror;
            } else {
                $session_id = $response->csessionid;
                $case_field_value = $response->cfieldvalue;
                $data['client_middle_name'] = $case_field_value;
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
                $data['client_surname'] = $response->cerror;
            } else {
                $session_id = $response->csessionid;
                $case_field_value = $response->cfieldvalue;
                $data['client_surname'] = $case_field_value;
            }

            // GET CLIENT DATE OF BIRTH
            $param = [
                'csessionid' => $session_id,
                'ccasetype' => '93',
                'ccaseno' => $caseRefNo,
                'cfieldname' => 'Cl Date Of Birth.Date',
            ];
            $response = $client->proGetData($param);
            if ($response->cstatus!='OK') {
                $data['client_date_of_birth'] = $response->cerror;
            } else {
                $session_id = $response->csessionid;
                $case_field_value = $response->cfieldvalue;
                $data['client_date_of_birth'] = $case_field_value;
            }

            //**************************************************************************************
            //******************************** CONTACT DETAILS *************************************
            //**************************************************************************************

            // GET CLIENT POSTCODE
            $param = [
                'csessionid' => $session_id,
                'ccasetype' => '93',
                'ccaseno' => $caseRefNo,
                'cfieldname' => 'Client.Postcode',
            ];
            $response = $client->proGetData($param);
            if ($response->cstatus!='OK') {
                $data['client_postcode'] = $response->cerror;
            } else {
                $session_id = $response->csessionid;
                $case_field_value = $response->cfieldvalue;
                $data['client_postcode'] = $case_field_value;
            }

            // GET CLIENT EMAIL
            $param = [
                'csessionid' => $session_id,
                'ccasetype' => '93',
                'ccaseno' => $caseRefNo,
                'cfieldname' => 'Client.E-Mail Main',
            ];
            $response = $client->proGetData($param);
            if ($response->cstatus!='OK') {
                $data['client_email'] = $response->cerror;
            } else {
                $session_id = $response->csessionid;
                $case_field_value = $response->cfieldvalue;
                $data['client_email'] = $case_field_value;
            }

            // GET CLIENT MAIN MOBILE/TELEPHONE
            $param = [
                'csessionid' => $session_id,
                'ccasetype' => '93',
                'ccaseno' => $caseRefNo,
                'cfieldname' => 'Client.Tel Main',
            ];
            $response = $client->proGetData($param);
            if ($response->cstatus!='OK') {
                $data['client_mobile_phone'] = $response->cerror;
            } else {
                $session_id = $response->csessionid;
                $case_field_value = $response->cfieldvalue;
                $data['client_mobile_phone'] = $case_field_value;
            }

            //**************************************************************************************
            //*************************** END PROCLAIM SESSION *************************************
            //**************************************************************************************

            // LOGOUT OF PROCLAIM
            $client->proLogout([
                'csessionid' => $session_id,
            ]);

        }

        return $data;

    }
}
