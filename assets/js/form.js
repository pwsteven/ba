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
        $('#financial_loss_typeFinancialLoss_1').prop('disabled', true);
        $('#financial_loss_typeFinancialLoss_2').prop('disabled', true);
        $('#financial_loss_typeFinancialLoss_3').prop('disabled', true);
        $('#financial_loss_typeFinancialLoss_4').prop('disabled', true);
        $('#financial_loss_typeFinancialLoss_5').prop('disabled', true);
        $('#financial_loss_typeFinancialLossOtherComment').prop('disabled', true);
        $('#financial_loss_totalLossAmount').prop('disabled', true);
        $('#financial_loss_financialLossFiles').prop('disabled', true);
    } else {
        $('#financial_loss_typeFinancialLoss_1').prop('disabled', false);
        $('#financial_loss_typeFinancialLoss_2').prop('disabled', false);
        $('#financial_loss_typeFinancialLoss_3').prop('disabled', false);
        $('#financial_loss_typeFinancialLoss_4').prop('disabled', false);
        $('#financial_loss_typeFinancialLoss_5').prop('disabled', false);
        $('#financial_loss_typeFinancialLossOtherComment').prop('disabled', false);
        $('#financial_loss_totalLossAmount').prop('disabled', false);
        $('#financial_loss_financialLossFiles').prop('disabled', false);
    }
});
if ($('#financial_loss_typeFinancialLoss_0').prop("checked") === true){
    $('#financial_loss_typeFinancialLoss_1').prop('disabled', true);
    $('#financial_loss_typeFinancialLoss_2').prop('disabled', true);
    $('#financial_loss_typeFinancialLoss_3').prop('disabled', true);
    $('#financial_loss_typeFinancialLoss_4').prop('disabled', true);
    $('#financial_loss_typeFinancialLoss_5').prop('disabled', true);
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
