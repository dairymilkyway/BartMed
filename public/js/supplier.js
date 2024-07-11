$(document).ready(function () {
    var table = $('#stable').DataTable({
        ajax: {
            url: "/api/suppliers", // Ensure this URL matches your route
            dataSrc: ""
        },
        dom: '<"top"lBf>rt<"bottom"ip><"clear">',
        buttons: [
            {
               extend: 'pdfHtml5',
                text: 'Export to PDF',
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
                render: function (data, type, row) {
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
                render: function (data, type, row) {
                    return `<a href='#' class='editBtn' data-id="${data.id}"><i class='fas fa-edit' style='font-size:24px; color:blue'></i></a>
                            <a href='#' class='deleteBtn' data-id="${data.id}"><i class='fas fa-trash-alt' style='font-size:24px; color:red'></i></a>`;
                }
            }
        ]
    });

    $("#SupplierSubmit").on('click', function (e) {
        e.preventDefault();
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
    });

    $('#stable tbody').on('click', 'a.editBtn', function (e) {
        e.preventDefault();
        $('#SupplierImages').remove();
        $('#SupplierId').remove();
        $("#Supplierform").trigger("reset");

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
    });

    $('#stable tbody').on('click', 'a.deleteBtn', function (e) {
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

    // Handle Add Brand button click
    $("#addSupplierBtn").on('click', function () {
        $("#Supplierform").trigger("reset");
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
