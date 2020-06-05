const $ = require('jquery');

$('#admin_form').submit(function(event) {
    $('#submit-form-button').html('Submitting <i class="fa fa-spinner fa-spin fa-fw"></i>').prop('disabled', true);
});
$('#delete_form').submit(function(event) {
    $('#delete-form-button').html('Deleting <i class="fa fa-spinner fa-spin fa-fw"></i>').prop('disabled', true);
});
