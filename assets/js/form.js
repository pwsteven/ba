const $ = require('jquery');

$('#ba_correspondence_breachOneNotification').on('change', function () {
    const value = $('#ba_correspondence_breachOneNotification option:selected').attr("value");
    if (value === 'YES') {
        $('#breach_one_block').fadeIn(450);
    } else {
        $('#breach_one_block').fadeOut(250);
    }
});
$('#ba_correspondence_breachTwoNotification').on('change', function () {
    const value = $('#ba_correspondence_breachTwoNotification option:selected').attr("value");
    if (value === 'YES') {
        $('#breach_two_block').fadeIn(450);
    } else {
        $('#breach_two_block').fadeOut(250);
    }
});
$('#complaints_lodgedComplaint').on('change', function () {
    const value = $('#complaints_lodgedComplaint option:selected').attr("value");
    if (value === 'YES') {
        $('#complaint_block').fadeIn(450);
    } else {
        $('#complaint_block').fadeOut(250);
    }
});
$('#complaints_receivedResponse').on('change', function () {
    const value = $('#complaints_receivedResponse option:selected').attr("value");
    if (value === 'Yes') {
        $('#complaint_satisfied_response_block').fadeIn(450);
    } else {
        $('#complaint_satisfied_response_block').fadeOut(250);
    }
});
$('#complaints_satisfiedResponse').on('change', function () {
    const value = $('#complaints_satisfiedResponse option:selected').attr("value");
    if (value === 'No') {
        $('#complaint_reason_unsatisfied_block').fadeIn(450);
    } else {
        $('#complaint_reason_unsatisfied_block').fadeOut(250);
    }
});
$('#financial_loss_typeFinancialLoss_5').click(function () {
    if($(this).prop("checked") === true){
        $('#financial_loss_block').fadeIn(450);
    } else {
        $('#financial_loss_block').fadeOut(450);
    }
});
if ($('#financial_loss_typeFinancialLoss_5').prop("checked") === true){
    $('#financial_loss_block').show();
}
$('#financial_loss_typeFinancialLoss_0').click(function () {
    if($(this).prop("checked") === true){
        for (let i = 1; i < 6; i++) {
            $('#financial_loss_typeFinancialLoss_'+i).prop('disabled', true);
        }
        $('#financial_loss_typeFinancialLossOtherComment').prop('disabled', true);
        $('#financial_loss_totalLossAmount').prop('disabled', true);
        $('#financial_loss_financialLossFiles').prop('disabled', true);
    } else {
        for (let i = 1; i < 6; i++) {
            $('#financial_loss_typeFinancialLoss_'+i).prop('disabled', false);
        }
        $('#financial_loss_typeFinancialLossOtherComment').prop('disabled', false);
        $('#financial_loss_totalLossAmount').prop('disabled', false);
        $('#financial_loss_financialLossFiles').prop('disabled', false);
    }
});
if ($('#financial_loss_typeFinancialLoss_0').prop("checked") === true){
    for (let i = 1; i < 6; i++) {
        $('#financial_loss_typeFinancialLoss_'+i).prop('disabled', true);
    }
    $('#financial_loss_typeFinancialLossOtherComment').prop('disabled', true);
    $('#financial_loss_totalLossAmount').prop('disabled', true);
    $('#financial_loss_financialLossFiles').prop('disabled', true);
}
$('#reimbursements_financialLossSuffered').on('change', function () {
    const value = $('#reimbursements_financialLossSuffered option:selected').attr("value");
    if (value === 'YES') {
        $('#reimbursements_block').fadeIn(450);
    } else {
        $('#reimbursements_block').fadeOut(250);
    }
});
$('#credit_monitor_monitorCredit').on('change', function () {
    const value = $('#credit_monitor_monitorCredit option:selected').attr("value");
    if (value === 'YES') {
        $('#credit_monitor_block').fadeIn(450);
    } else {
        $('#credit_monitor_block').fadeOut(250);
    }
});
$('#emotional_distress_emotionsExperiencedNew_7').click(function () {
    if($(this).prop("checked") === true){
        $('#emotions_experienced_block').fadeIn(450);
    } else {
        $('#emotions_experienced_block').fadeOut(450);
    }
});
if ($('#emotional_distress_emotionsExperiencedNew_7').prop("checked") === true){
    $('#emotions_experienced_block').show();
}
$('#emotional_distress_emotionsExperiencedNew_8').click(function () {
    if($(this).prop("checked") === true){
        for (let i = 0; i < 8; i++) {
            $('#emotional_distress_emotionsExperiencedNew_'+i).prop('disabled', true);
        }
        $('#emotional_distress_emotionsExperiencedComment').prop('disabled', true);
    } else {
        for (let i = 0; i < 8; i++) {
            $('#emotional_distress_emotionsExperiencedNew_'+i).prop('disabled', false);
        }
        $('#emotional_distress_emotionsExperiencedComment').prop('disabled', false);
    }
});
if ($('#emotional_distress_emotionsExperiencedNew_8').prop("checked") === true){
    for (let i = 0; i < 8; i++) {
        $('#emotional_distress_emotionsExperiencedNew_'+i).prop('disabled', false);
    }
    $('#emotional_distress_emotionsExperiencedComment').prop('disabled', false);
}
$('#emotional_distress_diagnosedConditions_4').click(function () {
    if($(this).prop("checked") === true){
        $('#diagnosed_conditions_block').fadeIn(450);
    } else {
        $('#diagnosed_conditions_block').fadeOut(450);
    }
});
if ($('#emotional_distress_diagnosedConditions_4').prop("checked") === true){
    $('#diagnosed_conditions_block').show();
}
$('#emotional_distress_impactCondition_2').click(function () {
    if($(this).prop("checked") === true){
        $('#impact_condition_block').fadeIn(450);
    } else {
        $('#impact_condition_block').fadeOut(450);
    }
});
if ($('#emotional_distress_impactCondition_2').prop("checked") === true){
    $('#impact_condition_block').show();
}
$('#emotional_distress_stepsTaken_7').click(function () {
    if($(this).prop("checked") === true){
        $('#steps_taken_block').fadeIn(450);
    } else {
        $('#steps_taken_block').fadeOut(450);
    }
});
if ($('#emotional_distress_stepsTaken_7').prop("checked") === true){
    $('#steps_taken_block').show();
}
$('#emotional_distress_adverseConsequences_8').click(function () {
    if($(this).prop("checked") === true){
        $('#adverse_consequences_block').fadeIn(450);
    } else {
        $('#adverse_consequences_block').fadeOut(450);
    }
});
if ($('#emotional_distress_adverseConsequences_8').prop("checked") === true){
    $('#adverse_consequences_block').show();
}
