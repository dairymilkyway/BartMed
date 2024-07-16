$(document).ready(function () {
    var table = $('#stable').DataTable({
        ajax: {
            url: "/api/suppliers",
            dataSrc: ""
        },
        dom: '<"top"lBf>rt<"bottom"ip><"clear">',
        buttons: [
            {
                extend: 'pdfHtml5',
                text: '<i class="fa fa-file-pdf"></i> Export to PDF',
                className: 'btn btn-primary mr-2',
                exportOptions: {
                    columns: [0, 1]
                }
            }
        ],
        columns: [
            { data: 'id', title: 'ID' },
            { data: 'supplier_name', title: 'Supplier Name' },
            {
                data: 'img_path',
                title: 'Image',
                render: function (data) {
                    var imgPaths = data.split(',');
                    var imagesHTML = '';
                    imgPaths.forEach(function (path) {
                        if (path.endsWith('.jpg') || path.endsWith('.jpeg') || path.endsWith('.png')) {
                            imagesHTML += `<img src="${path}" width="150" height="150" style="margin-right: 5px;">`;
                        }
                    });
                    return imagesHTML;
                }
            },
            {
                data: null,
                title: 'Actions',
                render: function (data) {
                    if (data.deleted_at) {
                        // Supplier is trashed
                        return `<button type='button' class='btn btn-sm btn-warning restoreBtn' data-id='${data.id}'><i class='fas fa-undo'></i> Restore</button>`;
                    } else {
                        // Supplier is not trashed
                        return `<a href='#' class='btn btn-sm btn-primary editBtn' data-id='${data.id}'><i class='fas fa-edit'></i> Edit</a> ` +
                               `<button type='button' class='btn btn-sm btn-danger deleteBtn' data-id='${data.id}'><i class='fas fa-trash-alt'></i> Delete</button>`;
                    }
                }
            }
        ],
        headerCallback: function (thead) {
            $(thead).find('th').css({
                'background-color': '#000000',
                'color': '#ffffff'
            });
        },
        responsive: true,
        order: [[0, 'asc']], // Sort by ID column ascending by default
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
    $('#Supplierform').validate({
        rules: {
            supplier_name: {
                required: true,
                letterswithspace: true
            },
            'uploads[]': {
                required: true
            }
        },
        messages: {
            supplier_name: {
                required: "Supplier name is required",
                letterswithspace: "Supplier name must be letters"
            },
            'uploads[]': {
                required: "Please upload at least one image"
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

    $.validator.addMethod("letterswithspace", function (value, element) {
        return this.optional(element) || /^[a-zA-Z\s]*$/.test(value);
    }, "Please enter letters and spaces only");

    function resetSupplierForm() {
        $('#Supplierform').trigger('reset');
        $('#Supplierform').validate().resetForm();
        $('.is-invalid').removeClass('is-invalid');
    }

    $("#SupplierSubmit").on('click', function (e) {
        e.preventDefault();
        if ($('#Supplierform').valid()) {
            var data = $('#Supplierform')[0];
            let formData = new FormData(data);
            $.ajax({
                type: "POST",
                url: "/api/suppliers",
                data: formData,
                contentType: false,
                processData: false,
                headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                dataType: "json",
                success: function (data) {
                    $("#SupplierModal").modal("hide");
                    table.ajax.reload();
                },
                error: function (error) {
                    console.log(error);
                }
            });
        }
    });

    $('#stable tbody').on('click', 'a.editBtn', function (e) {
        e.preventDefault();
        resetSupplierForm();
        $('#SupplierImages').remove();
        $('#SupplierId').remove();

        var id = $(this).data('id');
        $('<input>').attr({ type: 'hidden', id: 'SupplierId', name: 'id', value: id }).appendTo('#Supplierform');
        $('#SupplierModal').modal('show');
        $('#SupplierSubmit').hide();
        $('#SupplierUpdate').show();

        $.ajax({
            type: "GET",
            url: `/api/suppliers/${id}`,
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
            dataType: "json",
            success: function (data) {
                $('#supplier_name').val(data.supplier_name);

                var imagesHTML = '';
                data.img_path.split(',').forEach(function (path) {
                    if (path.endsWith('.jpg') || path.endsWith('.jpeg') || path.endsWith('.png')) {
                        imagesHTML += `<img src="${path}" width='200px' height='200px'>`;
                    }
                });
                $("#Supplierform").append("<div id='SupplierImages'>" + imagesHTML + "</div>");
            },
            error: function (error) {
                console.log(error);
            }
        });
    });

    $("#SupplierUpdate").on('click', function (e) {
        e.preventDefault();
        if ($('#Supplierform').valid()) {
            var id = $('#SupplierId').val();
            var data = $('#Supplierform')[0];
            let formData = new FormData(data);
            formData.append("_method", "PUT");
            $.ajax({
                type: "POST",
                url: `/api/suppliers/${id}`,
                data: formData,
                contentType: false,
                processData: false,
                headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                dataType: "json",
                success: function (data) {
                    $('#SupplierModal').modal("hide");
                    table.ajax.reload();
                },
                error: function (error) {
                    console.log(error);
                }
            });
        }
    });

    //delete
    $('#stable tbody').on('click', 'button.deleteBtn', function (e) {
        e.preventDefault();
        var id = $(this).data('id');
        var $row = $(this).closest('tr');
        bootbox.confirm({
            message: "Do you want to delete this Supplier?",
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
                        type: "DELETE",
                        url: `/api/suppliers/${id}`,
                        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                        dataType: "json",
                        success: function (data) {
                            table.row($row).remove().draw();
                            bootbox.alert(data.message);
                        },
                        error: function (error) {
                            console.log(error);
                        }
                    });
                }
            }
        });
    });

    // Handle restore action
    $('#stable tbody').on('click', 'button.restoreBtn', function (e) {
        e.preventDefault();
        var id = $(this).data('id');
        var $row = $(this).closest('tr');
        bootbox.confirm({
            message: "Do you want to restore this Supplier?",
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
                        type: "PUT", // Use PUT for restore action
                        url: `/api/suppliers/${id}/restore`,
                        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                        dataType: "json",
                        success: function (data) {
                            table.row($row).remove().draw();
                            bootbox.alert(data.message);
                        },
                        error: function (error) {
                            console.log(error);
                        }
                    });
                }
            }
        });
    });

     // Handle Excel import via AJAX
     $("#SexcelSubmit").on('click', function (e) {
        e.preventDefault();
        var formData = new FormData();
        formData.append('importFile', $('#importFile')[0].files[0]);
        $.ajax({
            type: "POST",
            url: "/api/suppliers/excel",
            data: formData,
            contentType: false,
            processData: false,
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
            success: function (data) {
                $("#ExcelSform").trigger("reset");
                $('#importExcelModal').modal('hide');
                table.ajax.reload();
            },
            error: function (error) {
                console.log(error);
            }
        });
    });

    // Handle Add Supplier button click
    $("#addSupplierBtn").on('click', function () {
        resetSupplierForm();
        $('#SupplierModal').modal('show');
        $('#SupplierUpdate').hide();
        $('#SupplierSubmit').show();
        $('#SupplierImages').remove();
    });

    // Handle Import Excel button click
    $("#importExcelBtn").on('click', function () {
        $("#ExcelBform").trigger("reset");
        $('#importExcelModal').modal('show');
    });

});
