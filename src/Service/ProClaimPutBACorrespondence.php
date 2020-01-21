<?php


namespace App\Service;


use Zend\Soap\Client;

class ProClaimPutBACorrespondence
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

            // UPDATE BA CONFIRMATION EMAIL
            $param = [
                'csessionid' => $session_id,
                'ccasetype' => '93',
                'ccaseno' => $caseData['case_id'],
                'cfieldname' => 'BA - S1 Notification.Response',
                'cfieldvalue' => $caseData['ba_correspondence_email'],
            ];
            $response = $client->proPutData($param);
            $session_id = $response->csessionid;
            if ($response->cstatus != 'OK') {
                $data['message'] = 'Set BA Confirmation Error: ' . $response->cerror;
            }

            // UPDATE BREACH ONE NOTIFICATION
            $param = [
                'csessionid' => $session_id,
                'ccasetype' => '93',
                'ccaseno' => $caseData['case_id'],
                'cfieldname' => 'BA - Reward Breach - notifcation received.response',
                'cfieldvalue' => $caseData['breach_one_notification'],
            ];
            $response = $client->proPutData($param);
            $session_id = $response->csessionid;
            if ($response->cstatus != 'OK') {
                $data['message'] = 'Set Breach One Notification Error: ' . $response->cerror;
            }

            // UPDATE BREACH ONE DATE RECEIVED TODO
            /*
            $param = [
                'csessionid' => $session_id,
                'ccasetype' => '93',
                'ccaseno' => $caseData['case_id'],
                'cfieldname' => '',
                'cfieldvalue' => $caseData['breach_one_date_received'],
            ];
            $response = $client->proPutData($param);
            $session_id = $response->csessionid;
            if ($response->cstatus != 'OK') {
                $data['message'] = 'Set Breach One Date Received Error: ' . $response->cerror;
            }
            */

            // UPDATE BREACH ONE NOTIFICATION NOT AFFECTED
            $param = [
                'csessionid' => $session_id,
                'ccasetype' => '93',
                'ccaseno' => $caseData['case_id'],
                'cfieldname' => 'BA - S1 Notification NOT Affected.Response',
                'cfieldvalue' => $caseData['breach_one_notification_not_affected'],
            ];
            $response = $client->proPutData($param);
            $session_id = $response->csessionid;
            if ($response->cstatus != 'OK') {
                $data['message'] = 'Set Breach One Notification Not Affected Error: ' . $response->cerror;
            }

            // UPDATE BREACH ONE DATE OF BOOKING
            $param = [
                'csessionid' => $session_id,
                'ccasetype' => '93',
                'ccaseno' => $caseData['case_id'],
                'cfieldname' => 'BA SOI - Date of Booking.Date',
                'cfieldvalue' => $caseData['breach_one_date_of_booking'],
            ];
            $response = $client->proPutData($param);
            $session_id = $response->csessionid;
            if ($response->cstatus != 'OK') {
                $data['message'] = 'Set Breach One Date Of Booking Error: ' . $response->cerror;
            }

            // UPDATE BREACH ONE EMAIL ADDRESS USED
            $param = [
                'csessionid' => $session_id,
                'ccasetype' => '93',
                'ccaseno' => $caseData['case_id'],
                'cfieldname' => 'GAC - Breached Email Address.Text',
                'cfieldvalue' => $caseData['breach_one_email_address_used'],
            ];
            $response = $client->proPutData($param);
            $session_id = $response->csessionid;
            if ($response->cstatus != 'OK') {
                $data['message'] = 'Set Breach One Email Address Used Error: ' . $response->cerror;
            }

            // UPDATE BREACH ONE BOOKING REFERENCE
            $param = [
                'csessionid' => $session_id,
                'ccasetype' => '93',
                'ccaseno' => $caseData['case_id'],
                'cfieldname' => 'BA - Booking Reference.Text',
                'cfieldvalue' => $caseData['breach_one_booking_reference'],
            ];
            $response = $client->proPutData($param);
            $session_id = $response->csessionid;
            if ($response->cstatus != 'OK') {
                $data['message'] = 'Set Breach One Booking Reference Error: ' . $response->cerror;
            }

            // UPDATE BREACH ONE BOOKING PLATFORM
            $param = [
                'csessionid' => $session_id,
                'ccasetype' => '93',
                'ccaseno' => $caseData['case_id'],
                'cfieldname' => 'BA - Booking Platform.Response',
                'cfieldvalue' => $caseData['breach_one_booking_platform'],
            ];
            $response = $client->proPutData($param);
            $session_id = $response->csessionid;
            if ($response->cstatus != 'OK') {
                $data['message'] = 'Set Breach One Booking Platform Error: ' . $response->cerror;
            }

            // UPDATE BREACH ONE PAYMENT METHOD
            $param = [
                'csessionid' => $session_id,
                'ccasetype' => '93',
                'ccaseno' => $caseData['case_id'],
                'cfieldname' => 'BA - Payment Method.Response',
                'cfieldvalue' => $caseData['breach_one_payment_method'],
            ];
            $response = $client->proPutData($param);
            $session_id = $response->csessionid;
            if ($response->cstatus != 'OK') {
                $data['message'] = 'Set Breach One Payment Method Error: ' . $response->cerror;
            }

            // UPDATE BREACH TWO NOTIFICATION TODO
            /*
            $param = [
                'csessionid' => $session_id,
                'ccasetype' => '93',
                'ccaseno' => $caseData['case_id'],
                'cfieldname' => '',
                'cfieldvalue' => $caseData['breach_two_notification'],
            ];
            $response = $client->proPutData($param);
            $session_id = $response->csessionid;
            if ($response->cstatus != 'OK') {
                $data['message'] = 'Set Breach Two Notification Error: ' . $response->cerror;
            }
            */

            // UPDATE BREACH TWO DATE RECEIVED TODO
            /*
            $param = [
                'csessionid' => $session_id,
                'ccasetype' => '93',
                'ccaseno' => $caseData['case_id'],
                'cfieldname' => '',
                'cfieldvalue' => $caseData['breach_two_date_received'],
            ];
            $response = $client->proPutData($param);
            $session_id = $response->csessionid;
            if ($response->cstatus != 'OK') {
                $data['message'] = 'Set Breach Two Date Received Error: ' . $response->cerror;
            }
            */

            // UPDATE BREACH TWO NOTIFICATION NOT AFFECTED TODO
            /*
            $param = [
                'csessionid' => $session_id,
                'ccasetype' => '93',
                'ccaseno' => $caseData['case_id'],
                'cfieldname' => '',
                'cfieldvalue' => $caseData['breach_two_notification_not_affected'],
            ];
            $response = $client->proPutData($param);
            $session_id = $response->csessionid;
            if ($response->cstatus != 'OK') {
                $data['message'] = 'Set Breach Two Notification Not Affected Error: ' . $response->cerror;
            }
            */

            // UPDATE BREACH TWO DATE OF BOOKING TODO
            /*
            $param = [
                'csessionid' => $session_id,
                'ccasetype' => '93',
                'ccaseno' => $caseData['case_id'],
                'cfieldname' => '',
                'cfieldvalue' => $caseData['breach_two_date_of_booking'],
            ];
            $response = $client->proPutData($param);
            $session_id = $response->csessionid;
            if ($response->cstatus != 'OK') {
                $data['message'] = 'Set Breach Two Date Of Booking Error: ' . $response->cerror;
            }
            */

            // UPDATE BREACH TWO EMAIL ADDRESS USED TODO
            /*
            $param = [
                'csessionid' => $session_id,
                'ccasetype' => '93',
                'ccaseno' => $caseData['case_id'],
                'cfieldname' => '',
                'cfieldvalue' => $caseData['breach_two_email_address_used'],
            ];
            $response = $client->proPutData($param);
            $session_id = $response->csessionid;
            if ($response->cstatus != 'OK') {
                $data['message'] = 'Set Breach Two Email Address Used Error: ' . $response->cerror;
            }
            */

            // UPDATE BREACH TWO BOOKING REFERENCE TODO
            /*
            $param = [
                'csessionid' => $session_id,
                'ccasetype' => '93',
                'ccaseno' => $caseData['case_id'],
                'cfieldname' => '',
                'cfieldvalue' => $caseData['breach_two_booking_reference'],
            ];
            $response = $client->proPutData($param);
            $session_id = $response->csessionid;
            if ($response->cstatus != 'OK') {
                $data['message'] = 'Set Breach Two Booking Reference Error: ' . $response->cerror;
            }
            */

            // UPDATE BREACH TWO BOOKING PLATFORM TODO
            /*
            $param = [
                'csessionid' => $session_id,
                'ccasetype' => '93',
                'ccaseno' => $caseData['case_id'],
                'cfieldname' => '',
                'cfieldvalue' => $caseData['breach_two_booking_platform'],
            ];
            $response = $client->proPutData($param);
            $session_id = $response->csessionid;
            if ($response->cstatus != 'OK') {
                $data['message'] = 'Set Breach Two Booking Platform Error: ' . $response->cerror;
            }
            */

            // UPDATE BREACH TWO PAYMENT METHOD TODO
            /*
            $param = [
                'csessionid' => $session_id,
                'ccasetype' => '93',
                'ccaseno' => $caseData['case_id'],
                'cfieldname' => '',
                'cfieldvalue' => $caseData['breach_two_payment_method'],
            ];
            $response = $client->proPutData($param);
            $session_id = $response->csessionid;
            if ($response->cstatus != 'OK') {
                $data['message'] = 'Set Breach Two Payment Method Error: ' . $response->cerror;
            }
            */


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
