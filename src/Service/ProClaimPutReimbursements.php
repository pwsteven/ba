<?php


namespace App\Service;


use Zend\Soap\Client;

class ProClaimPutReimbursements
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

        $options = [
            'cuser' => $this->proClaimUser,
            'cpassword' => $this->proClaimPassword
        ];

        $client = new Client($this->proClaimWsdl, [
            'location' => $this->proClaimEndPoint,
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
                'clinkedaction' => 'Z API AR: BA Initial',
            ];
            $response = $client->proRunLinkedAction($param);
            $session_id = $response->csessionid;
            if ($response->cstatus != 'OK') {
                $data['message'] = 'Set Linked Action Error: ' . $response->cerror;
            }

            // UPDATE FINANCIAL LOSS SUFFERED
            $param = [
                'csessionid' => $session_id,
                'ccasetype' => '93',
                'ccaseno' => $caseData['case_id'],
                'cfieldname' => 'BA SOI - Financial Loss.Response',
                'cfieldvalue' => $caseData['financial_loss_suffered'],
            ];
            $response = $client->proPutData($param);
            $session_id = $response->csessionid;
            if ($response->cstatus != 'OK') {
                $data['message'] = 'Set Financial Loss Suffered Error: ' . $response->cerror;
            }

            // UPDATE PROVIDER TODO
            /*
            $param = [
                'csessionid' => $session_id,
                'ccasetype' => '93',
                'ccaseno' => $caseData['case_id'],
                'cfieldname' => '',
                'cfieldvalue' => $caseData['provider'],
            ];
            $response = $client->proPutData($param);
            $session_id = $response->csessionid;
            if ($response->cstatus != 'OK') {
                $data['message'] = 'Set Provider Error: ' . $response->cerror;
            }
            */

            // UPDATE AMOUNT REIMBURSED
            $param = [
                'csessionid' => $session_id,
                'ccasetype' => '93',
                'ccaseno' => $caseData['case_id'],
                'cfieldname' => 'BA SOI - Financial Loss amount reimbursed.Value',
                'cfieldvalue' => $caseData['amount_reimbursed'],
            ];
            $response = $client->proPutData($param);
            $session_id = $response->csessionid;
            if ($response->cstatus != 'OK') {
                $data['message'] = 'Set Amount Reimbursed Error: ' . $response->cerror;
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
                $data['message'] = 'Commit Error: ' . $response->cerror;
            }

            // LOGOUT OF PROCLAIM
            $client->proLogout([
                'csessionid' => $session_id,
            ]);

        }
    }


}
