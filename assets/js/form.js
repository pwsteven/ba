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
