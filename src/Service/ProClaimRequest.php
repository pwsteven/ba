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
                $data['client_claim_code'] = $response->cerror;
            } else {
                $session_id = $response->csessionid;
                $case_field_value = $response->cfieldvalue;
                $data['client_claim_code'] = $case_field_value;
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
                $data['client_confidential_response'] = $response->cerror;
            } else {
                $session_id = $response->csessionid;
                $case_field_value = $response->cfieldvalue;
                $data['client_confidential_response'] = $case_field_value;
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
                $data['client_title'] = $response->cerror;
            } else {
                $session_id = $response->csessionid;
                $case_field_value = $response->cfieldvalue;
                $data['client_title'] = $case_field_value;
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

            // GET CLIENT STREET ADDRESS
            //************************************************************************
            $param = [
                'csessionid' => $session_id,
                'ccasetype' => '93',
                'ccaseno' => $caseRefNo,
                'cfieldname' => 'Client.Address Line 1',
            ];
            $response = $client->proGetData($param);
            if ($response->cstatus!='OK') {
                $data['client_street_address'] = $response->cerror;
            } else {
                $session_id = $response->csessionid;
                $case_field_value = $response->cfieldvalue;
                $data['client_street_address'] = $case_field_value;
            }

            // GET CLIENT STREET ADDRESS 2
            //************************************************************************
            $param = [
                'csessionid' => $session_id,
                'ccasetype' => '93',
                'ccaseno' => $caseRefNo,
                'cfieldname' => 'Client.Address Line 2',
            ];
            $response = $client->proGetData($param);
            if ($response->cstatus!='OK') {
                $data['client_street_address_2'] = $response->cerror;
            } else {
                $session_id = $response->csessionid;
                $case_field_value = $response->cfieldvalue;
                $data['client_street_address_2'] = $case_field_value;
            }

            // GET CLIENT STREET ADDRESS 3
            //************************************************************************
            $param = [
                'csessionid' => $session_id,
                'ccasetype' => '93',
                'ccaseno' => $caseRefNo,
                'cfieldname' => 'Client.Address Line 3',
            ];
            $response = $client->proGetData($param);
            if ($response->cstatus!='OK') {
                $data['client_street_address_3'] = $response->cerror;
            } else {
                $session_id = $response->csessionid;
                $case_field_value = $response->cfieldvalue;
                $data['client_street_address_3'] = $case_field_value;
            }

            // GET CLIENT TOWN/CITY
            //************************************************************************
            $param = [
                'csessionid' => $session_id,
                'ccasetype' => '93',
                'ccaseno' => $caseRefNo,
                'cfieldname' => 'Client.Address Line 4',
            ];
            $response = $client->proGetData($param);
            if ($response->cstatus!='OK') {
                $data['client_town_city'] = $response->cerror;
            } else {
                $session_id = $response->csessionid;
                $case_field_value = $response->cfieldvalue;
                $data['client_town_city'] = $case_field_value;
            }

            // GET CLIENT COUNTY
            //************************************************************************
            $param = [
                'csessionid' => $session_id,
                'ccasetype' => '93',
                'ccaseno' => $caseRefNo,
                'cfieldname' => 'Client.Address Line 5',
            ];
            $response = $client->proGetData($param);
            if ($response->cstatus!='OK') {
                $data['client_county'] = $response->cerror;
            } else {
                $session_id = $response->csessionid;
                $case_field_value = $response->cfieldvalue;
                $data['client_county'] = $case_field_value;
            }

            // GET CLIENT ADDRESS BLOCK
            //************************************************************************
            $param = [
                'csessionid' => $session_id,
                'ccasetype' => '93',
                'ccaseno' => $caseRefNo,
                'cfieldname' => 'Client.Address block',
            ];
            $response = $client->proGetData($param);
            if ($response->cstatus!='OK') {
                $data['client_address_block'] = $response->cerror;
            } else {
                $session_id = $response->csessionid;
                $case_field_value = $response->cfieldvalue;
                $data['client_address_block'] = $case_field_value;
            }

            // GET CLIENT POSTCODE
            //************************************************************************
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
            //************************************************************************
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
            //************************************************************************
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
                $data['client_ba_confirmation_email'] = $response->cerror;
            } else {
                $session_id = $response->csessionid;
                $case_field_value = $response->cfieldvalue;
                $data['client_ba_confirmation_email'] = $case_field_value;
            }

            // GET BREACH ONE NOTIFICATION

            $param = [
                'csessionid' => $session_id,
                'ccasetype' => '93',
                'ccaseno' => $caseRefNo,
                'cfieldname' => 'BA - Reward Breach - notification received.response',
            ];
            $response = $client->proGetData($param);
            if ($response->cstatus!='OK') {
                $data['client_breach_one_notification'] = $response->cerror;
            } else {
                $session_id = $response->csessionid;
                $case_field_value = $response->cfieldvalue;
                $data['client_breach_one_notification'] = $case_field_value;
            }


            // GET BREACH ONE DATE RECEIVED
            $param = [
                'csessionid' => $session_id,
                'ccasetype' => '93',
                'ccaseno' => $caseRefNo,
                'cfieldname' => 'BA - Reward Breach - notification date.date',
            ];
            $response = $client->proGetData($param);
            if ($response->cstatus!='OK') {
                $data['client_breach_one_date_received'] = $response->cerror;
            } else {
                $session_id = $response->csessionid;
                $case_field_value = $response->cfieldvalue;
                $data['client_breach_one_date_received'] = $case_field_value;
            }

            // GET BREACH ONE NOTIFICATION NOT AFFECTED
            $param = [
                'csessionid' => $session_id,
                'ccasetype' => '93',
                'ccaseno' => $caseRefNo,
                'cfieldname' => 'BA - S1 Notification NOT Affected.Response',
            ];
            $response = $client->proGetData($param);
            if ($response->cstatus!='OK') {
                $data['client_breach_one_notification_not_affected'] = $response->cerror;
            } else {
                $session_id = $response->csessionid;
                $case_field_value = $response->cfieldvalue;
                $data['client_breach_one_notification_not_affected'] = $case_field_value;
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
                $data['client_breach_one_date_of_booking'] = $response->cerror;
            } else {
                $session_id = $response->csessionid;
                $case_field_value = $response->cfieldvalue;
                $data['client_breach_one_date_of_booking'] = $case_field_value;
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
                $data['client_breach_one_email_address_used'] = $response->cerror;
            } else {
                $session_id = $response->csessionid;
                $case_field_value = $response->cfieldvalue;
                $data['client_breach_one_email_address_used'] = $case_field_value;
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
                $data['client_breach_one_booking_reference'] = $response->cerror;
            } else {
                $session_id = $response->csessionid;
                $case_field_value = $response->cfieldvalue;
                $data['client_breach_one_booking_reference'] = $case_field_value;
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
                $data['client_breach_one_booking_platform'] = $response->cerror;
            } else {
                $session_id = $response->csessionid;
                $case_field_value = $response->cfieldvalue;
                $data['client_breach_one_booking_platform'] = $case_field_value;
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
                $data['client_breach_one_payment_method'] = $response->cerror;
            } else {
                $session_id = $response->csessionid;
                $case_field_value = $response->cfieldvalue;
                $data['client_breach_one_payment_method'] = $case_field_value;
            }

            // GET BREACH TWO NOTIFICATION
            $param = [
                'csessionid' => $session_id,
                'ccasetype' => '93',
                'ccaseno' => $caseRefNo,
                'cfieldname' => 'BA - Booking Breach - notification received.response',
            ];
            $response = $client->proGetData($param);
            if ($response->cstatus!='OK') {
                $data['client_breach_two_notification'] = $response->cerror;
            } else {
                $session_id = $response->csessionid;
                $case_field_value = $response->cfieldvalue;
                $data['client_breach_two_notification'] = $case_field_value;
            }

            // GET BREACH TWO DATE RECEIVED
            $param = [
                'csessionid' => $session_id,
                'ccasetype' => '93',
                'ccaseno' => $caseRefNo,
                'cfieldname' => 'BA - Booking Breach - notification date.date',
            ];
            $response = $client->proGetData($param);
            if ($response->cstatus!='OK') {
                $data['client_breach_two_date_received'] = $response->cerror;
            } else {
                $session_id = $response->csessionid;
                $case_field_value = $response->cfieldvalue;
                $data['client_breach_two_date_received'] = $case_field_value;
            }

            // GET BREACH TWO NOTIFICATION NOT AFFECTED
            $param = [
                'csessionid' => $session_id,
                'ccasetype' => '93',
                'ccaseno' => $caseRefNo,
                'cfieldname' => 'BA - Booking Breach - not affected.response',
            ];
            $response = $client->proGetData($param);
            if ($response->cstatus!='OK') {
                $data['client_breach_two_notification_not_affected'] = $response->cerror;
            } else {
                $session_id = $response->csessionid;
                $case_field_value = $response->cfieldvalue;
                $data['client_breach_two_notification_not_affected'] = $case_field_value;
            }

            // GET BREACH TWO DATE OF BOOKING
            $param = [
                'csessionid' => $session_id,
                'ccasetype' => '93',
                'ccaseno' => $caseRefNo,
                'cfieldname' => 'BA - Booking Breach - booking date.date',
            ];
            $response = $client->proGetData($param);
            if ($response->cstatus!='OK') {
                $data['client_breach_two_date_of_booking'] = $response->cerror;
            } else {
                $session_id = $response->csessionid;
                $case_field_value = $response->cfieldvalue;
                $data['client_breach_two_date_of_booking'] = $case_field_value;
            }


            // GET BREACH TWO EMAIL ADDRESS USED
            $param = [
                'csessionid' => $session_id,
                'ccasetype' => '93',
                'ccaseno' => $caseRefNo,
                'cfieldname' => 'BA - Booking Breach - email used.text',
            ];
            $response = $client->proGetData($param);
            if ($response->cstatus!='OK') {
                $data['client_breach_two_email_address_used'] = $response->cerror;
            } else {
                $session_id = $response->csessionid;
                $case_field_value = $response->cfieldvalue;
                $data['client_breach_two_email_address_used'] = $case_field_value;
            }

            // GET BREACH TWO BOOKING REFERENCE
            $param = [
                'csessionid' => $session_id,
                'ccasetype' => '93',
                'ccaseno' => $caseRefNo,
                'cfieldname' => 'BA - Booking Breach - booking ref.text',
            ];
            $response = $client->proGetData($param);
            if ($response->cstatus!='OK') {
                $data['client_breach_two_booking_reference'] = $response->cerror;
            } else {
                $session_id = $response->csessionid;
                $case_field_value = $response->cfieldvalue;
                $data['client_breach_two_booking_reference'] = $case_field_value;
            }

            // GET BREACH TWO BOOKING PLATFORM
            $param = [
                'csessionid' => $session_id,
                'ccasetype' => '93',
                'ccaseno' => $caseRefNo,
                'cfieldname' => 'BA - Booking Platform 2.response',
            ];
            $response = $client->proGetData($param);
            if ($response->cstatus!='OK') {
                $data['client_breach_two_booking_platform'] = $response->cerror;
            } else {
                $session_id = $response->csessionid;
                $case_field_value = $response->cfieldvalue;
                $data['client_breach_two_booking_platform'] = $case_field_value;
            }

            // GET BREACH TWO PAYMENT METHOD
            $param = [
                'csessionid' => $session_id,
                'ccasetype' => '93',
                'ccaseno' => $caseRefNo,
                'cfieldname' => 'BA - Payment Method 2.response',
            ];
            $response = $client->proGetData($param);
            if ($response->cstatus!='OK') {
                $data['client_breach_two_payment_method'] = $response->cerror;
            } else {
                $session_id = $response->csessionid;
                $case_field_value = $response->cfieldvalue;
                $data['client_breach_two_payment_method'] = $case_field_value;
            }

            //**************************************************************************************
            //**************************** FURTHER CORRESPONDENCE **********************************
            //**************************************************************************************

            // GET RECEIVED ANY OTHER BA CORRESPONDENCE
            $param = [
                'csessionid' => $session_id,
                'ccasetype' => '93',
                'ccaseno' => $caseRefNo,
                'cfieldname' => 'BA - Other correspondence received?.response',
            ];
            $response = $client->proGetData($param);
            if ($response->cstatus!='OK') {
                $data['client_received_any_other_ba_correspondence'] = $response->cerror;
            } else {
                $session_id = $response->csessionid;
                $case_field_value = $response->cfieldvalue;
                $data['client_received_any_other_ba_correspondence'] = $case_field_value;
            }

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
                $data['client_lodged_complaint'] = $response->cerror;
            } else {
                $session_id = $response->csessionid;
                $case_field_value = $response->cfieldvalue;
                $data['client_lodged_complaint'] = $case_field_value;
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
                $data['client_complaint_made'] = $response->cerror;
            } else {
                $session_id = $response->csessionid;
                $case_field_value = $response->cfieldvalue;
                $data['client_complaint_made'] = $case_field_value;
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
                $data['client_received_response'] = $response->cerror;
            } else {
                $session_id = $response->csessionid;
                $case_field_value = $response->cfieldvalue;
                $data['client_received_response'] = $case_field_value;
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
                $data['client_satisfied_response'] = $response->cerror;
            } else {
                $session_id = $response->csessionid;
                $case_field_value = $response->cfieldvalue;
                $data['client_satisfied_response'] = $case_field_value;
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
                $data['client_reason_unsatisfied'] = $response->cerror;
            } else {
                $session_id = $response->csessionid;
                $case_field_value = $response->cfieldvalue;
                $data['client_reason_unsatisfied'] = $case_field_value;
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
                $data['client_contacted_ioc'] = $response->cerror;
            } else {
                $session_id = $response->csessionid;
                $case_field_value = $response->cfieldvalue;
                $data['client_contacted_ioc'] = $case_field_value;
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
                $data['client_contacted_action_fraud'] = $response->cerror;
            } else {
                $session_id = $response->csessionid;
                $case_field_value = $response->cfieldvalue;
                $data['client_contacted_action_fraud'] = $case_field_value;
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
                $data['client_accessed_get_safe_online'] = $response->cerror;
            } else {
                $session_id = $response->csessionid;
                $case_field_value = $response->cfieldvalue;
                $data['client_accessed_get_safe_online'] = $case_field_value;
            }

            //**************************************************************************************
            //****************************** FINANCIAL LOSS ****************************************
            //**************************************************************************************

            // GET TYPE OF FINANCIAL LOSS
            $param = [
                'csessionid' => $session_id,
                'ccasetype' => '93',
                'ccaseno' => $caseRefNo,
                'cfieldname' => 'BA - Financial Loss type.text',
            ];
            $response = $client->proGetData($param);
            if ($response->cstatus!='OK') {
                $data['client_financial_Loss'] = $response->cerror;
            } else {
                $session_id = $response->csessionid;
                $case_field_value = $response->cfieldvalue;
                $data['client_financial_Loss'] = $case_field_value;
            }

            // GET FINANCIAL LOSS OTHER COMMENT
            $param = [
                'csessionid' => $session_id,
                'ccasetype' => '93',
                'ccaseno' => $caseRefNo,
                'cfieldname' => 'BA - Financial Loss type - other.text',
            ];
            $response = $client->proGetData($param);
            if ($response->cstatus!='OK') {
                $data['client_financial_Loss_other_comment'] = $response->cerror;
            } else {
                $session_id = $response->csessionid;
                $case_field_value = $response->cfieldvalue;
                $data['client_financial_Loss_other_comment'] = $case_field_value;
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
                $data['client_total_loss_amount'] = $response->cerror;
            } else {
                $session_id = $response->csessionid;
                $case_field_value = $response->cfieldvalue;
                $data['client_total_loss_amount'] = $case_field_value;
            }

            //**************************************************************************************
            //****************************** REIMBURSEMENTS ****************************************
            //**************************************************************************************

            // GET FINANCIAL LOSS SUFFERED
            $param = [
                'csessionid' => $session_id,
                'ccasetype' => '93',
                'ccaseno' => $caseRefNo,
                'cfieldname' => 'BA SOI - Financial Loss.Response',
            ];
            $response = $client->proGetData($param);
            if ($response->cstatus!='OK') {
                $data['client_financial_loss_suffered'] = $response->cerror;
            } else {
                $session_id = $response->csessionid;
                $case_field_value = $response->cfieldvalue;
                $data['client_financial_loss_suffered'] = $case_field_value;
            }

            // GET PROVIDER
            $param = [
                'csessionid' => $session_id,
                'ccasetype' => '93',
                'ccaseno' => $caseRefNo,
                'cfieldname' => 'BA - who provided reimbursement.text',
            ];
            $response = $client->proGetData($param);
            if ($response->cstatus!='OK') {
                $data['client_provider'] = $response->cerror;
            } else {
                $session_id = $response->csessionid;
                $case_field_value = $response->cfieldvalue;
                $data['client_provider'] = $case_field_value;
            }

            // GET AMOUNT REIMBURSED
            $param = [
                'csessionid' => $session_id,
                'ccasetype' => '93',
                'ccaseno' => $caseRefNo,
                'cfieldname' => 'BA SOI - Financial Loss amount reimbursed.Value',
            ];
            $response = $client->proGetData($param);
            if ($response->cstatus!='OK') {
                $data['client_amount_reimbursed'] = $response->cerror;
            } else {
                $session_id = $response->csessionid;
                $case_field_value = $response->cfieldvalue;
                $data['client_amount_reimbursed'] = $case_field_value;
            }

            //**************************************************************************************
            //**************************** CREDIT MONITORING ***************************************
            //**************************************************************************************

            // GET MONITOR CREDIT
            $param = [
                'csessionid' => $session_id,
                'ccasetype' => '93',
                'ccaseno' => $caseRefNo,
                'cfieldname' => 'GAC - Credit Monitoring.Response',
            ];
            $response = $client->proGetData($param);
            if ($response->cstatus!='OK') {
                $data['client_monitor_credit'] = $response->cerror;
            } else {
                $session_id = $response->csessionid;
                $case_field_value = $response->cfieldvalue;
                $data['client_monitor_credit'] = $case_field_value;
            }

            //**************************************************************************************
            //*************************** EMOTIONAL DISTRESS ***************************************
            //**************************************************************************************

            // GET PERSONAL DETAILS USED FRAUDULENTLY
            $param = [
                'csessionid' => $session_id,
                'ccasetype' => '93',
                'ccaseno' => $caseRefNo,
                'cfieldname' => 'BA - concerned details used fraudulently.response',
            ];
            $response = $client->proGetData($param);
            if ($response->cstatus!='OK') {
                $data['client_personal_details'] = $response->cerror;
            } else {
                $session_id = $response->csessionid;
                $case_field_value = $response->cfieldvalue;
                $data['client_personal_details'] = $case_field_value;
            }

            // GET EMOTIONS EXPERIENCED
            $param = [
                'csessionid' => $session_id,
                'ccasetype' => '93',
                'ccaseno' => $caseRefNo,
                'cfieldname' => 'BA - Distress - emotions experienced.text',
            ];
            $response = $client->proGetData($param);
            if ($response->cstatus!='OK') {
                $data['client_emotions_experienced_new'] = $response->cerror;
            } else {
                $session_id = $response->csessionid;
                $case_field_value = $response->cfieldvalue;
                $data['client_emotions_experienced_new'] = $case_field_value;
            }

            // GET EMOTIONS EXPERIENCED COMMENT
            $param = [
                'csessionid' => $session_id,
                'ccasetype' => '93',
                'ccaseno' => $caseRefNo,
                'cfieldname' => 'BA - Distress - emotions experienced - other.text',
            ];
            $response = $client->proGetData($param);
            if ($response->cstatus!='OK') {
                $data['client_emotions_experienced_comment'] = $response->cerror;
            } else {
                $session_id = $response->csessionid;
                $case_field_value = $response->cfieldvalue;
                $data['client_emotions_experienced_comment'] = $case_field_value;
            }

            // GET EMOTIONAL DISTRESS LASTED
            $param = [
                'csessionid' => $session_id,
                'ccasetype' => '93',
                'ccaseno' => $caseRefNo,
                'cfieldname' => 'BA - Distress lasted.response',
            ];
            $response = $client->proGetData($param);
            if ($response->cstatus!='OK') {
                $data['client_emotional_distress_lasted'] = $response->cerror;
            } else {
                $session_id = $response->csessionid;
                $case_field_value = $response->cfieldvalue;
                $data['client_emotional_distress_lasted'] = $case_field_value;
            }

            // GET BREACH QUESTION A
            $param = [
                'csessionid' => $session_id,
                'ccasetype' => '93',
                'ccaseno' => $caseRefNo,
                'cfieldname' => 'MU anxious.response',
            ];
            $response = $client->proGetData($param);
            if ($response->cstatus!='OK') {
                $data['client_breach_question_a'] = $response->cerror;
            } else {
                $session_id = $response->csessionid;
                $case_field_value = $response->cfieldvalue;
                $data['client_breach_question_a'] = $case_field_value;
            }

            // GET BREACH QUESTION A EXAMPLE
            $param = [
                'csessionid' => $session_id,
                'ccasetype' => '93',
                'ccaseno' => $caseRefNo,
                'cfieldname' => 'MU anxious reason.text',
            ];
            $response = $client->proGetData($param);
            if ($response->cstatus!='OK') {
                $data['client_breach_question_a_example'] = $response->cerror;
            } else {
                $session_id = $response->csessionid;
                $case_field_value = $response->cfieldvalue;
                $data['client_breach_question_a_example'] = $case_field_value;
            }

            // GET BREACH QUESTION B
            $param = [
                'csessionid' => $session_id,
                'ccasetype' => '93',
                'ccaseno' => $caseRefNo,
                'cfieldname' => 'MU worry.response',
            ];
            $response = $client->proGetData($param);
            if ($response->cstatus!='OK') {
                $data['client_breach_question_b'] = $response->cerror;
            } else {
                $session_id = $response->csessionid;
                $case_field_value = $response->cfieldvalue;
                $data['client_breach_question_b'] = $case_field_value;
            }

            // GET BREACH QUESTION B EXAMPLE
            $param = [
                'csessionid' => $session_id,
                'ccasetype' => '93',
                'ccaseno' => $caseRefNo,
                'cfieldname' => 'MU worry reason.text',
            ];
            $response = $client->proGetData($param);
            if ($response->cstatus!='OK') {
                $data['client_breach_question_b_example'] = $response->cerror;
            } else {
                $session_id = $response->csessionid;
                $case_field_value = $response->cfieldvalue;
                $data['client_breach_question_b_example'] = $case_field_value;
            }

            // GET BREACH QUESTION C
            $param = [
                'csessionid' => $session_id,
                'ccasetype' => '93',
                'ccaseno' => $caseRefNo,
                'cfieldname' => 'MU different.response',
            ];
            $response = $client->proGetData($param);
            if ($response->cstatus!='OK') {
                $data['client_breach_question_c'] = $response->cerror;
            } else {
                $session_id = $response->csessionid;
                $case_field_value = $response->cfieldvalue;
                $data['client_breach_question_c'] = $case_field_value;
            }

            // GET BREACH QUESTION C EXAMPLE
            $param = [
                'csessionid' => $session_id,
                'ccasetype' => '93',
                'ccaseno' => $caseRefNo,
                'cfieldname' => 'MU different reason.text',
            ];
            $response = $client->proGetData($param);
            if ($response->cstatus!='OK') {
                $data['client_breach_question_c_example'] = $response->cerror;
            } else {
                $session_id = $response->csessionid;
                $case_field_value = $response->cfieldvalue;
                $data['client_breach_question_c_example'] = $case_field_value;
            }

            // GET BREACH QUESTION D
            $param = [
                'csessionid' => $session_id,
                'ccasetype' => '93',
                'ccaseno' => $caseRefNo,
                'cfieldname' => 'MU relaxing.response',
            ];
            $response = $client->proGetData($param);
            if ($response->cstatus!='OK') {
                $data['client_breach_question_d'] = $response->cerror;
            } else {
                $session_id = $response->csessionid;
                $case_field_value = $response->cfieldvalue;
                $data['client_breach_question_d'] = $case_field_value;
            }

            // GET BREACH QUESTION D EXAMPLE
            $param = [
                'csessionid' => $session_id,
                'ccasetype' => '93',
                'ccaseno' => $caseRefNo,
                'cfieldname' => 'MU relaxing reason.text',
            ];
            $response = $client->proGetData($param);
            if ($response->cstatus!='OK') {
                $data['client_breach_question_d_example'] = $response->cerror;
            } else {
                $session_id = $response->csessionid;
                $case_field_value = $response->cfieldvalue;
                $data['client_breach_question_d_example'] = $case_field_value;
            }

            // GET BREACH QUESTION E
            $param = [
                'csessionid' => $session_id,
                'ccasetype' => '93',
                'ccaseno' => $caseRefNo,
                'cfieldname' => 'MU restless.response',
            ];
            $response = $client->proGetData($param);
            if ($response->cstatus!='OK') {
                $data['client_breach_question_e'] = $response->cerror;
            } else {
                $session_id = $response->csessionid;
                $case_field_value = $response->cfieldvalue;
                $data['client_breach_question_e'] = $case_field_value;
            }

            // GET BREACH QUESTION E EXAMPLE
            $param = [
                'csessionid' => $session_id,
                'ccasetype' => '93',
                'ccaseno' => $caseRefNo,
                'cfieldname' => 'MU restless reason.text',
            ];
            $response = $client->proGetData($param);
            if ($response->cstatus!='OK') {
                $data['client_breach_question_e_example'] = $response->cerror;
            } else {
                $session_id = $response->csessionid;
                $case_field_value = $response->cfieldvalue;
                $data['client_breach_question_e_example'] = $case_field_value;
            }

            // GET BREACH QUESTION F
            $param = [
                'csessionid' => $session_id,
                'ccasetype' => '93',
                'ccaseno' => $caseRefNo,
                'cfieldname' => 'MU irritable.response',
            ];
            $response = $client->proGetData($param);
            if ($response->cstatus!='OK') {
                $data['client_breach_question_f'] = $response->cerror;
            } else {
                $session_id = $response->csessionid;
                $case_field_value = $response->cfieldvalue;
                $data['client_breach_question_f'] = $case_field_value;
            }

            // GET BREACH QUESTION F EXAMPLE
            $param = [
                'csessionid' => $session_id,
                'ccasetype' => '93',
                'ccaseno' => $caseRefNo,
                'cfieldname' => 'MU irritable reason.text',
            ];
            $response = $client->proGetData($param);
            if ($response->cstatus!='OK') {
                $data['client_breach_question_f_example'] = $response->cerror;
            } else {
                $session_id = $response->csessionid;
                $case_field_value = $response->cfieldvalue;
                $data['client_breach_question_f_example'] = $case_field_value;
            }

            // GET BREACH QUESTION G
            $param = [
                'csessionid' => $session_id,
                'ccasetype' => '93',
                'ccaseno' => $caseRefNo,
                'cfieldname' => 'MU afraid.response',
            ];
            $response = $client->proGetData($param);
            if ($response->cstatus!='OK') {
                $data['client_breach_question_g'] = $response->cerror;
            } else {
                $session_id = $response->csessionid;
                $case_field_value = $response->cfieldvalue;
                $data['client_breach_question_g'] = $case_field_value;
            }

            // GET BREACH QUESTION G EXAMPLE
            $param = [
                'csessionid' => $session_id,
                'ccasetype' => '93',
                'ccaseno' => $caseRefNo,
                'cfieldname' => 'MU afraid reason.text',
            ];
            $response = $client->proGetData($param);
            if ($response->cstatus!='OK') {
                $data['client_breach_question_g_example'] = $response->cerror;
            } else {
                $session_id = $response->csessionid;
                $case_field_value = $response->cfieldvalue;
                $data['client_breach_question_g_example'] = $case_field_value;
            }

            // GET DIAGNOSED CONDITIONS
            $param = [
                'csessionid' => $session_id,
                'ccasetype' => '93',
                'ccaseno' => $caseRefNo,
                'cfieldname' => 'BA - diagnosed conditions.Response',
            ];
            $response = $client->proGetData($param);
            if ($response->cstatus!='OK') {
                $data['client_diagnosed_conditions'] = $response->cerror;
            } else {
                $session_id = $response->csessionid;
                $case_field_value = $response->cfieldvalue;
                $data['client_diagnosed_conditions'] = $case_field_value;
            }

            // GET DIAGNOSED CONDITIONS MORE INFO
            $param = [
                'csessionid' => $session_id,
                'ccasetype' => '93',
                'ccaseno' => $caseRefNo,
                'cfieldname' => 'BA - diagnosed conditions other.text',
            ];
            $response = $client->proGetData($param);
            if ($response->cstatus!='OK') {
                $data['client_diagnosed_conditions_example'] = $response->cerror;
            } else {
                $session_id = $response->csessionid;
                $case_field_value = $response->cfieldvalue;
                $data['client_diagnosed_conditions_example'] = $case_field_value;
            }

            // GET IMPACT CONDITION
            $param = [
                'csessionid' => $session_id,
                'ccasetype' => '93',
                'ccaseno' => $caseRefNo,
                'cfieldname' => 'BA - diagnosed conditions other.response',
            ];
            $response = $client->proGetData($param);
            if ($response->cstatus!='OK') {
                $data['client_impact_condition'] = $response->cerror;
            } else {
                $session_id = $response->csessionid;
                $case_field_value = $response->cfieldvalue;
                $data['client_impact_condition'] = $case_field_value;
            }

            // GET IMPACT CONDITION MORE INFO EXAMPLE
            $param = [
                'csessionid' => $session_id,
                'ccasetype' => '93',
                'ccaseno' => $caseRefNo,
                'cfieldname' => 'BA - symptoms exacerbated.text',
            ];
            $response = $client->proGetData($param);
            if ($response->cstatus!='OK') {
                $data['client_impact_condition_example'] = $response->cerror;
            } else {
                $session_id = $response->csessionid;
                $case_field_value = $response->cfieldvalue;
                $data['client_impact_condition_example'] = $case_field_value;
            }

            // GET STEPS TAKEN
            $param = [
                'csessionid' => $session_id,
                'ccasetype' => '93',
                'ccaseno' => $caseRefNo,
                'cfieldname' => 'BA - steps taken.Text',
            ];
            $response = $client->proGetData($param);
            if ($response->cstatus!='OK') {
                $data['client_steps_taken'] = $response->cerror;
            } else {
                $session_id = $response->csessionid;
                $case_field_value = $response->cfieldvalue;
                $data['client_steps_taken'] = $case_field_value;
            }

            // GET STEPS TAKEN MORE INFO EXAMPLE
            $param = [
                'csessionid' => $session_id,
                'ccasetype' => '93',
                'ccaseno' => $caseRefNo,
                'cfieldname' => 'BA - steps taken other.Text',
            ];
            $response = $client->proGetData($param);
            if ($response->cstatus!='OK') {
                $data['client_steps_taken_example'] = $response->cerror;
            } else {
                $session_id = $response->csessionid;
                $case_field_value = $response->cfieldvalue;
                $data['client_steps_taken_example'] = $case_field_value;
            }

            // GET STEPS TAKEN DETAILS
            $param = [
                'csessionid' => $session_id,
                'ccasetype' => '93',
                'ccaseno' => $caseRefNo,
                'cfieldname' => 'BA - inconvenience.text',
            ];
            $response = $client->proGetData($param);
            if ($response->cstatus!='OK') {
                $data['client_steps_taken_details'] = $response->cerror;
            } else {
                $session_id = $response->csessionid;
                $case_field_value = $response->cfieldvalue;
                $data['client_steps_taken_details'] = $case_field_value;
            }

            // GET ADVERSE CONSEQUENCES
            $param = [
                'csessionid' => $session_id,
                'ccasetype' => '93',
                'ccaseno' => $caseRefNo,
                'cfieldname' => 'GAC - Adverse Breach Consequences.Text',
            ];
            $response = $client->proGetData($param);
            if ($response->cstatus!='OK') {
                $data['client_adverse_consequences'] = $response->cerror;
            } else {
                $session_id = $response->csessionid;
                $case_field_value = $response->cfieldvalue;
                $data['client_adverse_consequences'] = $case_field_value;
            }

            // GET ADVERSE CONSEQUENCES MORE INFO EXAMPLE
            $param = [
                'csessionid' => $session_id,
                'ccasetype' => '93',
                'ccaseno' => $caseRefNo,
                'cfieldname' => 'GAC - Adverse Breach Consequences other.text',
            ];
            $response = $client->proGetData($param);
            if ($response->cstatus!='OK') {
                $data['client_adverse_consequences_example'] = $response->cerror;
            } else {
                $session_id = $response->csessionid;
                $case_field_value = $response->cfieldvalue;
                $data['client_adverse_consequences_example'] = $case_field_value;
            }

            // GET ADVERSE CONSEQUENCES DETAILS
            $param = [
                'csessionid' => $session_id,
                'ccasetype' => '93',
                'ccaseno' => $caseRefNo,
                'cfieldname' => 'GAC - Adverse Breach Consequences Details.Text',
            ];
            $response = $client->proGetData($param);
            if ($response->cstatus!='OK') {
                $data['client_adverse_consequences_details'] = $response->cerror;
            } else {
                $session_id = $response->csessionid;
                $case_field_value = $response->cfieldvalue;
                $data['client_adverse_consequences_details'] = $case_field_value;
            }

            // GET ADDITIONAL INFORMATION
            $param = [
                'csessionid' => $session_id,
                'ccasetype' => '93',
                'ccaseno' => $caseRefNo,
                'cfieldname' => 'GAC - Additional Onboarding Information.Text',
            ];
            $response = $client->proGetData($param);
            if ($response->cstatus!='OK') {
                $data['client_additional_information'] = $response->cerror;
            } else {
                $session_id = $response->csessionid;
                $case_field_value = $response->cfieldvalue;
                $data['client_additional_information'] = $case_field_value;
            }

            // GET CLAIMANT TYPE SETTING
            $param = [
                'csessionid' => $session_id,
                'ccasetype' => '93',
                'ccaseno' => $caseRefNo,
                'cfieldname' => 'GAC - Claimant Type.Response',
            ];
            $response = $client->proGetData($param);
            if ($response->cstatus!='OK') {
                $data['client_lead_test_claimant'] = $response->cerror;
            } else {
                $session_id = $response->csessionid;
                $case_field_value = $response->cfieldvalue;
                $data['client_lead_test_claimant'] = $case_field_value;
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
