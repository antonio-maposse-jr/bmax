$(document).ready(function() {
    $('#customerSelect').select2({
        ajax: {
            url: '/admin/get-customers',
            dataType: 'json',
            delay: 250,
            processResults: function(data) {
                return {
                    results: $.map(data, function(customer) {
                        return {
                            id: customer.id,
                            text: customer.name
                        };
                    })
                };
            },
            cache: true
        },
        minimumInputLength: 2, // Set a minimum input length to trigger the AJAX request
        placeholder: 'Search for a customer',
        allowClear: true
    });
    $('#customerSelect').on('change', function() {
        var selectedCustomerId = $(this).val();
        // Use the selectedCustomerId as needed
    });

    $('#productSelect').select2({
        ajax: {
            url: '/admin/get-products',
            dataType: 'json',
            delay: 250,
            processResults: function(data) {
                return {
                    results: $.map(data, function(product) {
                        return {
                            id: product.id,
                            text: product.name
                        };
                    })
                };
            },
            cache: true
        },
        minimumInputLength: 2, // Set a minimum input length to trigger the AJAX request
        placeholder: 'Search for product',
        allowClear: true
    });
    
    $('#productSelect').on('change', function() {
        var selectedProductId = $(this).val();
        // Use the selectedCustomerId as needed
    });


    $('#order_confirmation').on('change', function() {
        var selectedOption = $(this).val();
        console.log(selectedOption)
        if(selectedOption === 'Call'){
            var confirmationCallRecordGroup = document.getElementById('confirmation_call_record_group');
            confirmationCallRecordGroup.classList.add('required');
        }

        if(selectedOption === 'In person'){
            var signedConfirmationGroup= document.getElementById('signed_confirmation_group');
            signedConfirmationGroup.classList.add('required');
        }
    });



});