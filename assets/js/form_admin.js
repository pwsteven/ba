const $ = require('jquery');

$('#admin_form').submit(function(event) {
    $('#submit-form-button').html('Submitting <i class="fa fa-spinner fa-spin fa-fw"></i>').prop('disabled', true);
});
