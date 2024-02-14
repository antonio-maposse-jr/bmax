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


    $('#colorSelect').select2({
        ajax: {
            url: '/admin/get-colors',
            dataType: 'json',
            delay: 250,
            processResults: function(data) {
                return {
                    results: $.map(data, function(color) {
                        return {
                            id: color.name,
                            text: color.name
                        };
                    })
                };
            },
            cache: true
        },
        minimumInputLength: 2, // Set a minimum input length to trigger the AJAX request
        placeholder: 'Search for colors',
        allowClear: true
    });
    
    $('#colorSelect').on('change', function() {
        var colorSelect = $(this).val();
        // Use the selectedCustomerId as needed
    });


});