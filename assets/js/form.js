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
