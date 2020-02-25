const $ = require('jquery');

$('#find_address').click(function(event) {

    event.preventDefault();
    console.log('find address button clicked...');
    const postcode = $('#contact_details_postcode');
    const postcode_message = $('#find_postcode_message');
    if (postcode.val() === ""){
        postcode_message.html('<span class="font-weight-bold text-danger">Please enter a postcode to search for...</span>');
    } else {
        console.log('we have an address to find...');
        postcode_message.val('');
        $('#find_address').html('Searching <i class="fa fa-spinner fa-spin fa-fw"></i>');
        $.ajax({
            url: '/dashboard/address-lookup',
            type: 'POST',
            dataType: 'json',
            data: {postcode: postcode.val()},
        }).done(function (data) {
            if (data['status'] === 'not-found'){
                postcode_message.html('<span class="font-weight-bold text-danger">Postcode not found.</span>');
                $('#find_address').html('Find Address <i class="fa fa-search" aria-hidden="true"></i>');
            }
            if (data['status'] === 'invalid') {
                postcode_message.html('<span class="font-weight-bold text-danger">Postcode is invalid.</span>');
                $('#find_address').html('Find Address <i class="fa fa-search" aria-hidden="true"></i>');
            }
            if (data['status'] === 'found'){
                $('#find_address').html('Find Address <i class="fa fa-search" aria-hidden="true"></i>');
                postcode_message.html('');
                const address_counter = data['count'];
                console.log('No of address: '+address_counter);
                if (address_counter === 1){
                    $('#contact_details_streetAddress').val(data['address'][0]['street_address']);
                    $('#contact_details_streetAddress2').val(data['address'][0]['line_2']);
                    $('#contact_details_townCity').val(data['address'][0]['town_city']);
                    $('#contact_details_county').val(data['address'][0]['county']);
                } else {
                    $('#select_address_block').fadeIn(450);
                    let idx;
                    let addy;
                    let visual;
                    let value;
                    for(idx in data['address']) {
                        addy = data['address'][idx];
                        visual = addy['street_address'] + ' ' + addy['line_2'] + ' ' + addy['town_city'] + ' ' + addy['county'];
                        value = addy['street_address'] + '|' + addy['line_2'] + '|' + addy['town_city'] + '|' + addy['county'];
                        $('#address_picker').append($('<option>', {value: value, text: visual}));
                    }
                }
            }
        })
    }
});

$('#address_picker').on('change', function() {
    if ($(this).val() !== '') {
        const address_bits = $(this).val().split('|');
        $('#contact_details_streetAddress').val(address_bits[0]);
        $('#contact_details_streetAddress2').val(address_bits[1]);
        $('#contact_details_townCity').val(address_bits[2]);
        $('#contact_details_county').val(address_bits[3]);
        $('#select_address_block').fadeOut(250);
    }
});

$("#contact_details_postcode").change(function() {
    this.value = this.value.toUpperCase();
});
