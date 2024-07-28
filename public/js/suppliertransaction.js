$(document).ready(function () {
    var table = $('#STtable').DataTable({
        ajax: {
            url: "/api/supplier-transactions",
            dataSrc: ""
        },
        dom: '<"top"lBf>rt<"bottom"ip><"clear">',
        buttons: [
            {
                extend: 'pdfHtml5',
                text: '<i class="fa fa-file-pdf"></i> Export to PDF',
                className: 'btn btn-danger mr-2',
                exportOptions: {
                    columns: [0, 1, 2, 3]
                }
            }
        ],
        columns: [
            { data: 'id', title: 'Supplier Transaction ID' },
            { data: 'supplier.supplier_name', title: 'Supplier Name' },
            { data: 'product.product_name', title: 'Product Name' },
            { data: 'quantity', title: 'Quantity' },
            {
                data: 'img_path',
                title: 'Images',
                render: function (data) {
                    var imgPaths = data.split(',');
                    var imagesHTML = '';
                    imgPaths.forEach(function (path) {
                        if (path.endsWith('.jpg') || path.endsWith('.jpeg') || path.endsWith('.png')) {
                            imagesHTML += `<img src="/storage/${path}" width="150" height="150" style="margin-right: 5px;">`;
                        }
                    });
                    return imagesHTML;
                }
            },
            {
                data: null,
                title: 'Actions',
                render: function (data) {
                    return `<button type='button' class='btn btn-sm btn-danger deleteBtn' data-id="${data.id}"><i class='fas fa-trash-alt'></i> Delete</button>`;
                }
            }
        ],
        responsive: true,
        order: [[0, 'asc']],
        language: {
            search: "_INPUT_",
            searchPlaceholder: "Search...",
            lengthMenu: "Show _MENU_ entries",
            info: "Showing _START_ to _END_ of _TOTAL_ entries",
            paginate: {
                first: "First",
                last: "Last",
                next: "Next",
                previous: "Previous"
            },
            emptyTable: "No data available in table"
        }
    });


    // Validation
    $('#SupplierTransactionForm').validate({
        rules: {
            supplier_id: {
                required: true
            },
            product_id:{
                required:true
            },
            quantity:{
                required:true,
                number:true
            },
            'uploads[]': {
                required: true
            }
        },
        messages: {
            supplier_id: {
                required: "Please select a Supplier",
            },
            product_id: {
                required: "Please select a Product",
            },
            quantity: {
                required: "Quantity is required",
                number: "Please input numbers only"
            },
            'img_path': {
                required: "Please upload image"
            }
        },
        errorClass: "error-message",
        errorPlacement: function (error, element) {
            error.insertAfter(element);
        },
        highlight: function (element) {
            $(element).addClass('is-invalid');
        },
        unhighlight: function (element) {
            $(element).removeClass('is-invalid');
        }
    });



    // Handle Add Supplier Transaction button click
    $("#addSupplierTransactionBtn").on('click', function () {
        $('#SupplierTransactionForm').trigger('reset');
        $('#SupplierTransactionModal').modal('show');
        loadSuppliersAndProducts();
        $('#SupplierTransactionForm').validate().resetForm();
        $('.is-invalid').removeClass('is-invalid');
    });

    // Load suppliers and products into the dropdowns
    function loadSuppliersAndProducts() {
        $.ajax({
            url: '/api/suppliers',
            method: 'GET',
            success: function (data) {
                $('#supplier_id').empty().append('<option value="">Select Supplier</option>');
                $.each(data, function (key, value) {
                    $('#supplier_id').append('<option value="' + value.id + '">' + value.supplier_name + '</option>');
                });
            }
        });

        $.ajax({
            url: '/api/products',
            method: 'GET',
            success: function (data) {
                $('#product_id').empty().append('<option value="">Select Product</option>');
                $.each(data, function (key, value) {
                    $('#product_id').append('<option value="' + value.id + '">' + value.product_name + '</option>');
                });
            }
        });
    }

    // Handle form submission for creating supplier transaction
    $("#SupplierTransactionForm").on('submit', function (e) {
        e.preventDefault();
        var formData = new FormData(this);
        $.ajax({
            type: "POST",
            url: "/api/supplier-transactions",
            data: formData,
            contentType: false,
            processData: false,
            success: function (data) {
                $('#SupplierTransactionModal').modal('hide');
                table.ajax.reload();
                showAlert('success', 'Supplier Transaction added successfully.');
            },
            error: function (error) {
                console.log(error);
            }
        });
    });

// Handle delete button click
$('#STtable').on('click', '.deleteBtn', function (e) {
    e.preventDefault(); // Prevent default action if the button is inside a form

    var id = $(this).data('id');
    var $row = $(this).closest('tr'); // Get the closest table row

    bootbox.confirm({
        message: "Are you sure you want to delete this transaction?",
        buttons: {
            confirm: {
                label: 'Yes',
                className: 'btn-success'
            },
            cancel: {
                label: 'No',
                className: 'btn-danger'
            }
        },
        callback: function (result) {
            if (result) {
                $.ajax({
                    url: '/api/supplier-transactions/' + id,
                    type: 'DELETE',
                    headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                    dataType: "json",
                    success: function (result) {
                        bootbox.alert('Transaction deleted successfully.');
                        table.ajax.reload();
                    },
                    error: function (error) {
                        bootbox.alert('An error occurred while deleting the transaction.');
                        console.log(error);
                    }
                });
            }
        }
    });
});

});
