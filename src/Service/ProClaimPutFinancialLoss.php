<?php


namespace App\Service;


use Zend\Soap\Client;

class ProClaimPutFinancialLoss
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

            // UPDATE TYPE OF FINANCIAL LOSS
            $param = [
                'csessionid' => $session_id,
                'ccasetype' => '93',
                'ccaseno' => $caseData['case_id'],
                'cfieldname' => 'BA SOI - Financial Loss circumstances.Text',
                'cfieldvalue' => $caseData['type_financial_Loss'],
            ];
            $response = $client->proPutData($param);
            $session_id = $response->csessionid;
            if ($response->cstatus != 'OK') {
                $data['message'] = 'Set Type Financial Loss Error: ' . $response->cerror;
            }

            // UPDATE TOTAL LOSS AMOUNT
            $param = [
                'csessionid' => $session_id,
                'ccasetype' => '93',
                'ccaseno' => $caseData['case_id'],
                'cfieldname' => 'BA SOI - Financial Loss amount.Value',
                'cfieldvalue' => $caseData['total_loss_amount'],
            ];
            $response = $client->proPutData($param);
            $session_id = $response->csessionid;
            if ($response->cstatus != 'OK') {
                $data['message'] = 'Set Total Loss Amount Error: ' . $response->cerror;
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
