<?php


namespace App\Service;


use Zend\Soap\Client;

class ProClaimPutEmotionalDistress
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

            // UPDATE PERSONAL DETAILS USED FRAUDULENTLY TODO
            /*
            $param = [
                'csessionid' => $session_id,
                'ccasetype' => '93',
                'ccaseno' => $caseData['case_id'],
                'cfieldname' => '',
                'cfieldvalue' => $caseData['personal_details'],
            ];
            $response = $client->proPutData($param);
            $session_id = $response->csessionid;
            if ($response->cstatus != 'OK') {
                $data['message'] = 'Set Personal Details Used Fraudulently Error: ' . $response->cerror;
            }
            */

            // UPDATE EMOTIONS EXPERIENCED TODO (EXPECTING A YES|NO ANSWER WHEN THE QUESTION IS MULTIPLE CHOICE ** NEEDS CHANGED
            /*
            $param = [
                'csessionid' => $session_id,
                'ccasetype' => '93',
                'ccaseno' => $caseData['case_id'],
                'cfieldname' => 'BA SOI - distress.Response',
                'cfieldvalue' => $caseData['emotions_experienced_new'],
            ];
            $response = $client->proPutData($param);
            $session_id = $response->csessionid;
            if ($response->cstatus != 'OK') {
                $data['message'] = 'Set Emotions Experienced Error: ' . $response->cerror;
            }
            */

            // UPDATE EMOTIONS EXPERIENCED COMMENT
            $param = [
                'csessionid' => $session_id,
                'ccasetype' => '93',
                'ccaseno' => $caseData['case_id'],
                'cfieldname' => 'BA SOI - distress explanation.Text',
                'cfieldvalue' => $caseData['emotions_experienced_comment'],
            ];
            $response = $client->proPutData($param);
            $session_id = $response->csessionid;
            if ($response->cstatus != 'OK') {
                $data['message'] = 'Set Emotions Experienced Comment Error: ' . $response->cerror;
            }

            // UPDATE EMOTIONAL DISTRESS LASTED TODO
            /*
            $param = [
                'csessionid' => $session_id,
                'ccasetype' => '93',
                'ccaseno' => $caseData['case_id'],
                'cfieldname' => '',
                'cfieldvalue' => $caseData['emotional_distress_lasted'],
            ];
            $response = $client->proPutData($param);
            $session_id = $response->csessionid;
            if ($response->cstatus != 'OK') {
                $data['message'] = 'Set Emotional Distress Lasted Error: ' . $response->cerror;
            }
            */

            // UPDATE BREACH QUESTION A TODO
            /*
            $param = [
                'csessionid' => $session_id,
                'ccasetype' => '93',
                'ccaseno' => $caseData['case_id'],
                'cfieldname' => '',
                'cfieldvalue' => $caseData['breach_question_a'],
            ];
            $response = $client->proPutData($param);
            $session_id = $response->csessionid;
            if ($response->cstatus != 'OK') {
                $data['message'] = 'Set Breach Question A Error: ' . $response->cerror;
            }
            */

            // UPDATE BREACH QUESTION A EXAMPLE TODO
            /*
            $param = [
                'csessionid' => $session_id,
                'ccasetype' => '93',
                'ccaseno' => $caseData['case_id'],
                'cfieldname' => '',
                'cfieldvalue' => $caseData['breach_question_a_example'],
            ];
            $response = $client->proPutData($param);
            $session_id = $response->csessionid;
            if ($response->cstatus != 'OK') {
                $data['message'] = 'Set Breach Question A Example Error: ' . $response->cerror;
            }
            */

            // UPDATE BREACH QUESTION B TODO
            /*
            $param = [
                'csessionid' => $session_id,
                'ccasetype' => '93',
                'ccaseno' => $caseData['case_id'],
                'cfieldname' => '',
                'cfieldvalue' => $caseData['breach_question_b'],
            ];
            $response = $client->proPutData($param);
            $session_id = $response->csessionid;
            if ($response->cstatus != 'OK') {
                $data['message'] = 'Set Breach Question B Error: ' . $response->cerror;
            }
            */

            // UPDATE BREACH QUESTION B EXAMPLE TODO
            /*
            $param = [
                'csessionid' => $session_id,
                'ccasetype' => '93',
                'ccaseno' => $caseData['case_id'],
                'cfieldname' => '',
                'cfieldvalue' => $caseData['breach_question_b_example'],
            ];
            $response = $client->proPutData($param);
            $session_id = $response->csessionid;
            if ($response->cstatus != 'OK') {
                $data['message'] = 'Set Breach Question B Example Error: ' . $response->cerror;
            }
            */

            // UPDATE BREACH QUESTION C TODO
            /*
            $param = [
                'csessionid' => $session_id,
                'ccasetype' => '93',
                'ccaseno' => $caseData['case_id'],
                'cfieldname' => '',
                'cfieldvalue' => $caseData['breach_question_c'],
            ];
            $response = $client->proPutData($param);
            $session_id = $response->csessionid;
            if ($response->cstatus != 'OK') {
                $data['message'] = 'Set Breach Question C Error: ' . $response->cerror;
            }
            */

            // UPDATE BREACH QUESTION C EXAMPLE TODO
            /*
            $param = [
                'csessionid' => $session_id,
                'ccasetype' => '93',
                'ccaseno' => $caseData['case_id'],
                'cfieldname' => '',
                'cfieldvalue' => $caseData['breach_question_c_example'],
            ];
            $response = $client->proPutData($param);
            $session_id = $response->csessionid;
            if ($response->cstatus != 'OK') {
                $data['message'] = 'Set Breach Question C Example Error: ' . $response->cerror;
            }
            */

            // UPDATE BREACH QUESTION D TODO
            /*
            $param = [
                'csessionid' => $session_id,
                'ccasetype' => '93',
                'ccaseno' => $caseData['case_id'],
                'cfieldname' => '',
                'cfieldvalue' => $caseData['breach_question_d'],
            ];
            $response = $client->proPutData($param);
            $session_id = $response->csessionid;
            if ($response->cstatus != 'OK') {
                $data['message'] = 'Set Breach Question D Error: ' . $response->cerror;
            }
            */

            // UPDATE BREACH QUESTION D EXAMPLE TODO
            /*
            $param = [
                'csessionid' => $session_id,
                'ccasetype' => '93',
                'ccaseno' => $caseData['case_id'],
                'cfieldname' => '',
                'cfieldvalue' => $caseData['breach_question_d_example'],
            ];
            $response = $client->proPutData($param);
            $session_id = $response->csessionid;
            if ($response->cstatus != 'OK') {
                $data['message'] = 'Set Breach Question D Example Error: ' . $response->cerror;
            }
            */

            // UPDATE BREACH QUESTION E TODO
            /*
            $param = [
                'csessionid' => $session_id,
                'ccasetype' => '93',
                'ccaseno' => $caseData['case_id'],
                'cfieldname' => '',
                'cfieldvalue' => $caseData['breach_question_e'],
            ];
            $response = $client->proPutData($param);
            $session_id = $response->csessionid;
            if ($response->cstatus != 'OK') {
                $data['message'] = 'Set Breach Question E Error: ' . $response->cerror;
            }
            */

            // UPDATE BREACH QUESTION E EXAMPLE TODO
            /*
            $param = [
                'csessionid' => $session_id,
                'ccasetype' => '93',
                'ccaseno' => $caseData['case_id'],
                'cfieldname' => '',
                'cfieldvalue' => $caseData['breach_question_e_example'],
            ];
            $response = $client->proPutData($param);
            $session_id = $response->csessionid;
            if ($response->cstatus != 'OK') {
                $data['message'] = 'Set Breach Question E Example Error: ' . $response->cerror;
            }
            */

            // UPDATE BREACH QUESTION F TODO
            /*
            $param = [
                'csessionid' => $session_id,
                'ccasetype' => '93',
                'ccaseno' => $caseData['case_id'],
                'cfieldname' => '',
                'cfieldvalue' => $caseData['breach_question_f'],
            ];
            $response = $client->proPutData($param);
            $session_id = $response->csessionid;
            if ($response->cstatus != 'OK') {
                $data['message'] = 'Set Breach Question F Error: ' . $response->cerror;
            }
            */

            // UPDATE BREACH QUESTION F EXAMPLE TODO
            /*
            $param = [
                'csessionid' => $session_id,
                'ccasetype' => '93',
                'ccaseno' => $caseData['case_id'],
                'cfieldname' => '',
                'cfieldvalue' => $caseData['breach_question_f_example'],
            ];
            $response = $client->proPutData($param);
            $session_id = $response->csessionid;
            if ($response->cstatus != 'OK') {
                $data['message'] = 'Set Breach Question F Example Error: ' . $response->cerror;
            }
            */

            // UPDATE BREACH QUESTION G TODO
            /*
            $param = [
                'csessionid' => $session_id,
                'ccasetype' => '93',
                'ccaseno' => $caseData['case_id'],
                'cfieldname' => '',
                'cfieldvalue' => $caseData['breach_question_g'],
            ];
            $response = $client->proPutData($param);
            $session_id = $response->csessionid;
            if ($response->cstatus != 'OK') {
                $data['message'] = 'Set Breach Question G Error: ' . $response->cerror;
            }
            */

            // UPDATE BREACH QUESTION G EXAMPLE TODO
            /*
            $param = [
                'csessionid' => $session_id,
                'ccasetype' => '93',
                'ccaseno' => $caseData['case_id'],
                'cfieldname' => '',
                'cfieldvalue' => $caseData['breach_question_g_example'],
            ];
            $response = $client->proPutData($param);
            $session_id = $response->csessionid;
            if ($response->cstatus != 'OK') {
                $data['message'] = 'Set Breach Question G Example Error: ' . $response->cerror;
            }
            */

            // UPDATE DIAGNOSED CONDITIONS TODO
            /*
            $param = [
                'csessionid' => $session_id,
                'ccasetype' => '93',
                'ccaseno' => $caseData['case_id'],
                'cfieldname' => 'BA SOI - diagnosis.Response',
                'cfieldvalue' => $caseData['diagnosed_conditions'],
            ];
            $response = $client->proPutData($param);
            $session_id = $response->csessionid;
            if ($response->cstatus != 'OK') {
                $data['message'] = 'Set Diagnosed Conditions Error: ' . $response->cerror;
            }
            */

            // UPDATE DIAGNOSED CONDITIONS MORE INFO TODO
            /*
            $param = [
                'csessionid' => $session_id,
                'ccasetype' => '93',
                'ccaseno' => $caseData['case_id'],
                'cfieldname' => '',
                'cfieldvalue' => $caseData['diagnosed_conditions_example'],
            ];
            $response = $client->proPutData($param);
            $session_id = $response->csessionid;
            if ($response->cstatus != 'OK') {
                $data['message'] = 'Set Diagnosed Conditions More Info Example Error: ' . $response->cerror;
            }
            */

            // UPDATE IMPACT CONDITION TODO
            /*
            $param = [
                'csessionid' => $session_id,
                'ccasetype' => '93',
                'ccaseno' => $caseData['case_id'],
                'cfieldname' => '',
                'cfieldvalue' => $caseData['impact_condition'],
            ];
            $response = $client->proPutData($param);
            $session_id = $response->csessionid;
            if ($response->cstatus != 'OK') {
                $data['message'] = 'Set Impact Condition Error: ' . $response->cerror;
            }
            */

            // UPDATE IMPACT CONDITION MORE INFO EXAMPLE TODO
            /*
            $param = [
                'csessionid' => $session_id,
                'ccasetype' => '93',
                'ccaseno' => $caseData['case_id'],
                'cfieldname' => '',
                'cfieldvalue' => $caseData['impact_condition_example'],
            ];
            $response = $client->proPutData($param);
            $session_id = $response->csessionid;
            if ($response->cstatus != 'OK') {
                $data['message'] = 'Set Impact Condition More Info Example Error: ' . $response->cerror;
            }
            */

            // UPDATE STEPS TAKEN TODO
            /*
            $param = [
                'csessionid' => $session_id,
                'ccasetype' => '93',
                'ccaseno' => $caseData['case_id'],
                'cfieldname' => '',
                'cfieldvalue' => $caseData['steps_taken'],
            ];
            $response = $client->proPutData($param);
            $session_id = $response->csessionid;
            if ($response->cstatus != 'OK') {
                $data['message'] = 'Set Steps Taken Error: ' . $response->cerror;
            }
            */

            // UPDATE STEPS TAKEN MORE INFO TODO
            /*
            $param = [
                'csessionid' => $session_id,
                'ccasetype' => '93',
                'ccaseno' => $caseData['case_id'],
                'cfieldname' => '',
                'cfieldvalue' => $caseData['steps_taken_example'],
            ];
            $response = $client->proPutData($param);
            $session_id = $response->csessionid;
            if ($response->cstatus != 'OK') {
                $data['message'] = 'Set Steps Taken More Info Example Error: ' . $response->cerror;
            }
            */

            // UPDATE STEPS TAKEN DETAILS TODO
            /*
            $param = [
                'csessionid' => $session_id,
                'ccasetype' => '93',
                'ccaseno' => $caseData['case_id'],
                'cfieldname' => '',
                'cfieldvalue' => $caseData['steps_taken_details'],
            ];
            $response = $client->proPutData($param);
            $session_id = $response->csessionid;
            if ($response->cstatus != 'OK') {
                $data['message'] = 'Set Steps Taken Details Error: ' . $response->cerror;
            }
            */

            // UPDATE ADVERSE CONSEQUENCES
            $param = [
                'csessionid' => $session_id,
                'ccasetype' => '93',
                'ccaseno' => $caseData['case_id'],
                'cfieldname' => 'GAC - Adverse Breach Consequences.Text',
                'cfieldvalue' => $caseData['adverse_consequences'],
            ];
            $response = $client->proPutData($param);
            $session_id = $response->csessionid;
            if ($response->cstatus != 'OK') {
                $data['message'] = 'Set Adverse Consequences Error: ' . $response->cerror;
            }

            // UPDATE ADVERSE CONSEQUENCES MORE INFO EXAMPLE TODO
            /*
            $param = [
                'csessionid' => $session_id,
                'ccasetype' => '93',
                'ccaseno' => $caseData['case_id'],
                'cfieldname' => '',
                'cfieldvalue' => $caseData['adverse_consequences_example'],
            ];
            $response = $client->proPutData($param);
            $session_id = $response->csessionid;
            if ($response->cstatus != 'OK') {
                $data['message'] = 'Set Adverse Consequences More Info Error: ' . $response->cerror;
            }
            */

            // UPDATE ADVERSE CONSEQUENCES DETAILS
            $param = [
                'csessionid' => $session_id,
                'ccasetype' => '93',
                'ccaseno' => $caseData['case_id'],
                'cfieldname' => 'GAC - Adverse Breach Consequences Details.Text',
                'cfieldvalue' => $caseData['adverse_consequences_details'],
            ];
            $response = $client->proPutData($param);
            $session_id = $response->csessionid;
            if ($response->cstatus != 'OK') {
                $data['message'] = 'Set Adverse Consequences Details Error: ' . $response->cerror;
            }

            // UPDATE ADDITIONAL INFORMATION
            $param = [
                'csessionid' => $session_id,
                'ccasetype' => '93',
                'ccaseno' => $caseData['case_id'],
                'cfieldname' => 'GAC - Additional Onboarding Information.Text',
                'cfieldvalue' => $caseData['additional_information'],
            ];
            $response = $client->proPutData($param);
            $session_id = $response->csessionid;
            if ($response->cstatus != 'OK') {
                $data['message'] = 'Set Additional Information Error: ' . $response->cerror;
            }

            // UPDATE CLAIMANT TYPE SETTING
            $param = [
                'csessionid' => $session_id,
                'ccasetype' => '93',
                'ccaseno' => $caseData['case_id'],
                'cfieldname' => 'GAC - Claimant Type.Response',
                'cfieldvalue' => $caseData['lead_test_claimant'],
            ];
            $response = $client->proPutData($param);
            $session_id = $response->csessionid;
            if ($response->cstatus != 'OK') {
                $data['message'] = 'Set Lead Test Claimant Error: ' . $response->cerror;
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
