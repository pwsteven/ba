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

            //**************************************************************************************
            //******************************* PERSONAL DETAILS *************************************
            //**************************************************************************************

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

            // GET CLIENT DATE OF BIRTH
            $param = [
                'csessionid' => $session_id,
                'ccasetype' => '93',
                'ccaseno' => $caseRefNo,
                'cfieldname' => 'Cl Date Of Birth.Date',
            ];
            $response = $client->proGetData($param);
            if ($response->cstatus!='OK') {
                $data['claim_type_client_date_of_birth'] = $response->cerror;
            } else {
                $session_id = $response->csessionid;
                $case_field_value = $response->cfieldvalue;
                $data['claim_type_client_date_of_birth'] = $case_field_value;
            }

            //**************************************************************************************
            //******************************** CONTACT DETAILS *************************************
            //**************************************************************************************

            // GET CLIENT ADDRESS BLOCK
            $param = [
                'csessionid' => $session_id,
                'ccasetype' => '93',
                'ccaseno' => $caseRefNo,
                'cfieldname' => 'Client.Address block',
            ];
            $response = $client->proGetData($param);
            if ($response->cstatus!='OK') {
                $data['claim_type_client_address_block'] = $response->cerror;
            } else {
                $session_id = $response->csessionid;
                $case_field_value = $response->cfieldvalue;
                $data['claim_type_client_address_block'] = $case_field_value;
            }

            // GET CLIENT POSTCODE
            $param = [
                'csessionid' => $session_id,
                'ccasetype' => '93',
                'ccaseno' => $caseRefNo,
                'cfieldname' => 'Client.Postcode',
            ];
            $response = $client->proGetData($param);
            if ($response->cstatus!='OK') {
                $data['claim_type_client_postcode'] = $response->cerror;
            } else {
                $session_id = $response->csessionid;
                $case_field_value = $response->cfieldvalue;
                $data['claim_type_client_postcode'] = $case_field_value;
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
                $data['claim_type_client_email'] = $response->cerror;
            } else {
                $session_id = $response->csessionid;
                $case_field_value = $response->cfieldvalue;
                $data['claim_type_client_email'] = $case_field_value;
            }

            // GET CLIENT MOBILE/TELEPHONE
            $param = [
                'csessionid' => $session_id,
                'ccasetype' => '93',
                'ccaseno' => $caseRefNo,
                'cfieldname' => 'Client.Tel Mobile',
            ];
            $response = $client->proGetData($param);
            if ($response->cstatus!='OK') {
                $data['claim_type_client_mobile_phone'] = $response->cerror;
            } else {
                $session_id = $response->csessionid;
                $case_field_value = $response->cfieldvalue;
                $data['claim_type_client_mobile_phone'] = $case_field_value;
            }

            //**************************************************************************************
            //****************************** BA CORRESPONDENCE *************************************
            //**************************************************************************************

            // GET BA CONFIRMATION EMAIL RESPONSE
            $param = [
                'csessionid' => $session_id,
                'ccasetype' => '93',
                'ccaseno' => $caseRefNo,
                'cfieldname' => 'BA - S1 Notification.Response',
            ];
            $response = $client->proGetData($param);
            if ($response->cstatus!='OK') {
                $data['claim_type_client_ba_confirmation_email'] = $response->cerror;
            } else {
                $session_id = $response->csessionid;
                $case_field_value = $response->cfieldvalue;
                $data['claim_type_client_ba_confirmation_email'] = $case_field_value;
            }

            // GET BREACH ONE NOTIFICATION TODO
            /*
            $param = [
                'csessionid' => $session_id,
                'ccasetype' => '93',
                'ccaseno' => $caseRefNo,
                'cfieldname' => '',
            ];
            $response = $client->proGetData($param);
            if ($response->cstatus!='OK') {
                $data['claim_type_breach_one_notification'] = $response->cerror;
            } else {
                $session_id = $response->csessionid;
                $case_field_value = $response->cfieldvalue;
                $data['claim_type_breach_one_notification'] = $case_field_value;
            }
            */

            // GET BREACH ONE DATE RECEIVED TODO
            /*
            $param = [
                'csessionid' => $session_id,
                'ccasetype' => '93',
                'ccaseno' => $caseRefNo,
                'cfieldname' => '',
            ];
            $response = $client->proGetData($param);
            if ($response->cstatus!='OK') {
                $data['claim_type_client_breach_one_date_received'] = $response->cerror;
            } else {
                $session_id = $response->csessionid;
                $case_field_value = $response->cfieldvalue;
                $data['claim_type_client_breach_one_date_received'] = $case_field_value;
            }
            */

            // GET BREACH ONE NOTIFICATION NOT AFFECTED
            $param = [
                'csessionid' => $session_id,
                'ccasetype' => '93',
                'ccaseno' => $caseRefNo,
                'cfieldname' => 'BA - S1 Notification NOT Affected.Response',
            ];
            $response = $client->proGetData($param);
            if ($response->cstatus!='OK') {
                $data['claim_type_client_breach_one_notification_not_affected'] = $response->cerror;
            } else {
                $session_id = $response->csessionid;
                $case_field_value = $response->cfieldvalue;
                $data['claim_type_client_breach_one_notification_not_affected'] = $case_field_value;
            }

            // GET BREACH ONE DATE OF BOOKING
            $param = [
                'csessionid' => $session_id,
                'ccasetype' => '93',
                'ccaseno' => $caseRefNo,
                'cfieldname' => 'BA SOI - Date of Booking.Date',
            ];
            $response = $client->proGetData($param);
            if ($response->cstatus!='OK') {
                $data['claim_type_client_breach_one_date_of_booking'] = $response->cerror;
            } else {
                $session_id = $response->csessionid;
                $case_field_value = $response->cfieldvalue;
                $data['claim_type_client_breach_one_date_of_booking'] = $case_field_value;
            }

            // GET BREACH ONE EMAIL ADDRESS USED
            $param = [
                'csessionid' => $session_id,
                'ccasetype' => '93',
                'ccaseno' => $caseRefNo,
                'cfieldname' => 'GAC - Breached Email Address.Text',
            ];
            $response = $client->proGetData($param);
            if ($response->cstatus!='OK') {
                $data['claim_type_client_breach_one_email_address_used'] = $response->cerror;
            } else {
                $session_id = $response->csessionid;
                $case_field_value = $response->cfieldvalue;
                $data['claim_type_client_breach_one_email_address_used'] = $case_field_value;
            }

            // GET BREACH ONE BOOKING REFERENCE
            $param = [
                'csessionid' => $session_id,
                'ccasetype' => '93',
                'ccaseno' => $caseRefNo,
                'cfieldname' => 'BA - Booking Reference.Text',
            ];
            $response = $client->proGetData($param);
            if ($response->cstatus!='OK') {
                $data['claim_type_client_breach_one_booking_reference'] = $response->cerror;
            } else {
                $session_id = $response->csessionid;
                $case_field_value = $response->cfieldvalue;
                $data['claim_type_client_breach_one_booking_reference'] = $case_field_value;
            }

            // GET BREACH ONE BOOKING PLATFORM
            $param = [
                'csessionid' => $session_id,
                'ccasetype' => '93',
                'ccaseno' => $caseRefNo,
                'cfieldname' => 'BA - Booking Platform.Response',
            ];
            $response = $client->proGetData($param);
            if ($response->cstatus!='OK') {
                $data['claim_type_client_breach_one_booking_platform'] = $response->cerror;
            } else {
                $session_id = $response->csessionid;
                $case_field_value = $response->cfieldvalue;
                $data['claim_type_client_breach_one_booking_platform'] = $case_field_value;
            }

            // GET BREACH ONE PAYMENT METHOD
            $param = [
                'csessionid' => $session_id,
                'ccasetype' => '93',
                'ccaseno' => $caseRefNo,
                'cfieldname' => 'BA - Payment Method.Response',
            ];
            $response = $client->proGetData($param);
            if ($response->cstatus!='OK') {
                $data['claim_type_client_breach_one_payment_method'] = $response->cerror;
            } else {
                $session_id = $response->csessionid;
                $case_field_value = $response->cfieldvalue;
                $data['claim_type_client_breach_one_payment_method'] = $case_field_value;
            }

            //**************************************************************************************
            //**************************** FURTHER CORRESPONDENCE **********************************
            //**************************************************************************************

            // GET RECEIVED ANY OTHER BA CORRESPONDENCE TODO
            /*
            $param = [
                'csessionid' => $session_id,
                'ccasetype' => '93',
                'ccaseno' => $caseRefNo,
                'cfieldname' => '',
            ];
            $response = $client->proGetData($param);
            if ($response->cstatus!='OK') {
                $data['claim_type_client_received_any_other_ba_correspondence'] = $response->cerror;
            } else {
                $session_id = $response->csessionid;
                $case_field_value = $response->cfieldvalue;
                $data['claim_type_client_received_any_other_ba_correspondence'] = $case_field_value;
            }
            */

            //**************************************************************************************
            //********************************* COMPLAINTS *****************************************
            //**************************************************************************************

            // GET LODGED COMPLAINT
            $param = [
                'csessionid' => $session_id,
                'ccasetype' => '93',
                'ccaseno' => $caseRefNo,
                'cfieldname' => 'BA SOI - Complaint made?.Response',
            ];
            $response = $client->proGetData($param);
            if ($response->cstatus!='OK') {
                $data['claim_type_client_lodged_complaint'] = $response->cerror;
            } else {
                $session_id = $response->csessionid;
                $case_field_value = $response->cfieldvalue;
                $data['claim_type_client_lodged_complaint'] = $case_field_value;
            }

            // GET COMPLAINT MADE
            $param = [
                'csessionid' => $session_id,
                'ccasetype' => '93',
                'ccaseno' => $caseRefNo,
                'cfieldname' => 'BA SOI - Complaint date.Date',
            ];
            $response = $client->proGetData($param);
            if ($response->cstatus!='OK') {
                $data['claim_type_client_complaint_made'] = $response->cerror;
            } else {
                $session_id = $response->csessionid;
                $case_field_value = $response->cfieldvalue;
                $data['claim_type_client_complaint_made'] = $case_field_value;
            }

            // GET RECEIVED RESPONSE
            $param = [
                'csessionid' => $session_id,
                'ccasetype' => '93',
                'ccaseno' => $caseRefNo,
                'cfieldname' => 'BA SOI - Complaint response.Response',
            ];
            $response = $client->proGetData($param);
            if ($response->cstatus!='OK') {
                $data['claim_type_client_received_response'] = $response->cerror;
            } else {
                $session_id = $response->csessionid;
                $case_field_value = $response->cfieldvalue;
                $data['claim_type_client_received_response'] = $case_field_value;
            }

            // GET SATISFIED RESPONSE
            $param = [
                'csessionid' => $session_id,
                'ccasetype' => '93',
                'ccaseno' => $caseRefNo,
                'cfieldname' => 'BA SOI - Complaint satisfied.Response',
            ];
            $response = $client->proGetData($param);
            if ($response->cstatus!='OK') {
                $data['claim_type_client_satisfied_response'] = $response->cerror;
            } else {
                $session_id = $response->csessionid;
                $case_field_value = $response->cfieldvalue;
                $data['claim_type_client_satisfied_response'] = $case_field_value;
            }

            // GET REASON UNSATISFIED
            $param = [
                'csessionid' => $session_id,
                'ccasetype' => '93',
                'ccaseno' => $caseRefNo,
                'cfieldname' => 'BA SOI - Complaint unsatisfied.Text',
            ];
            $response = $client->proGetData($param);
            if ($response->cstatus!='OK') {
                $data['claim_type_client_reason_unsatisfied'] = $response->cerror;
            } else {
                $session_id = $response->csessionid;
                $case_field_value = $response->cfieldvalue;
                $data['claim_type_client_reason_unsatisfied'] = $case_field_value;
            }

            // GET CONTACTED IOC
            $param = [
                'csessionid' => $session_id,
                'ccasetype' => '93',
                'ccaseno' => $caseRefNo,
                'cfieldname' => 'BA SOI - ICO.Response',
            ];
            $response = $client->proGetData($param);
            if ($response->cstatus!='OK') {
                $data['claim_type_client_contacted_ioc'] = $response->cerror;
            } else {
                $session_id = $response->csessionid;
                $case_field_value = $response->cfieldvalue;
                $data['claim_type_client_contacted_ioc'] = $case_field_value;
            }

            // GET CONTACTED ACTION FRAUD
            $param = [
                'csessionid' => $session_id,
                'ccasetype' => '93',
                'ccaseno' => $caseRefNo,
                'cfieldname' => 'BA SOI - Action Fraud.Response',
            ];
            $response = $client->proGetData($param);
            if ($response->cstatus!='OK') {
                $data['claim_type_client_contacted_action_fraud'] = $response->cerror;
            } else {
                $session_id = $response->csessionid;
                $case_field_value = $response->cfieldvalue;
                $data['claim_type_client_contacted_action_fraud'] = $case_field_value;
            }

            // GET ACCESSED GET SAFE ONLINE
            $param = [
                'csessionid' => $session_id,
                'ccasetype' => '93',
                'ccaseno' => $caseRefNo,
                'cfieldname' => 'BA SOI - Get Safe Online.Response',
            ];
            $response = $client->proGetData($param);
            if ($response->cstatus!='OK') {
                $data['claim_type_client_accessed_get_safe_online'] = $response->cerror;
            } else {
                $session_id = $response->csessionid;
                $case_field_value = $response->cfieldvalue;
                $data['claim_type_client_accessed_get_safe_online'] = $case_field_value;
            }

            //**************************************************************************************
            //****************************** FINANCIAL LOSS ****************************************
            //**************************************************************************************

            // GET TYPE OF FINANCIAL LOSS
            $param = [
                'csessionid' => $session_id,
                'ccasetype' => '93',
                'ccaseno' => $caseRefNo,
                'cfieldname' => 'BA SOI - Financial Loss circumstances.Text',
            ];
            $response = $client->proGetData($param);
            if ($response->cstatus!='OK') {
                $data['claim_type_client_type_financial_Loss'] = $response->cerror;
            } else {
                $session_id = $response->csessionid;
                $case_field_value = $response->cfieldvalue;
                $data['claim_type_client_type_financial_Loss'] = $case_field_value;
            }

            // GET TOTAL LOSS AMOUNT
            $param = [
                'csessionid' => $session_id,
                'ccasetype' => '93',
                'ccaseno' => $caseRefNo,
                'cfieldname' => 'BA SOI - Financial Loss amount.Value',
            ];
            $response = $client->proGetData($param);
            if ($response->cstatus!='OK') {
                $data['claim_type_client_type_total_loss_amount'] = $response->cerror;
            } else {
                $session_id = $response->csessionid;
                $case_field_value = $response->cfieldvalue;
                $data['claim_type_client_type_total_loss_amount'] = $case_field_value;
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
