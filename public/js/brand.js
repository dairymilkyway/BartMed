$(document).ready(function () {
    var table = $('#brandtable').DataTable({
        ajax: {
            url: "/api/brands",
            dataSrc: ""
        },
        dom: '<"top"lBf>rt<"bottom"ip><"clear">',
        buttons: [
            {
                extend: 'pdfHtml5',
                text: '<i class="fa fa-file-pdf"></i> Export to PDF',
                className: 'btn btn-primary mr-2',
                exportOptions: {
                    columns: [0, 1, 2]
                }
            }
        ],
        columns: [
            { 
                data: 'id', 
                title: 'ID' 
            },
            { 
                data: 'brand_name', 
                title: 'Brand Name' 
            },
            {
                data: 'img_path',
                title: 'Image',
                render: function (data, type, row) {
                    var imgPaths = data.split(',');
                    var imagesHTML = '';
                    imgPaths.forEach(function (path) {
                        if (path.endsWith('.jpg') || path.endsWith('.jpeg') || path.endsWith('.png')) {
                            imagesHTML += `<img src="${path}" class="img-thumbnail" width="100" height="100" style="margin-right: 5px;">`;
                        }
                    });
                    return imagesHTML;
                }
            },
            {
                data: null,
                title: 'Actions',
                render: function (data, type, row) {
                    return `<a href='#' class='btn btn-sm btn-primary editBtn' data-id="${data.id}"><i class='fas fa-edit'></i> Edit</a>
                            <button type='button' class='btn btn-sm btn-danger deleteBtn' data-id="${data.id}"><i class='fas fa-trash-alt'></i> Delete</button>`;
                }
            }
        ],
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



     $('#brandform').validate({
        rules: {
            brand_name: {
                required: true,
            }
        },
        messages: {
            brand_name: {
                required: "Brand name is required"
            },
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
        },
    });



    $("#brandSubmit").on('click', function (e) {
        e.preventDefault();
        var data = $('#brandform')[0];
        let formData = new FormData(data);
        $.ajax({
            type: "POST",
            url: "/api/brands",
            data: formData,
            contentType: false,
            processData: false,
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
            dataType: "json",
            success: function (data) {
                $("#brandModal").modal("hide");
                table.ajax.reload();
            },
            error: function (error) {
                console.log(error);
            }
        });
    });

    $('#brandtable tbody').on('click', 'a.editBtn', function (e) {
        e.preventDefault();
        $('#brandImages').remove();
        $('#brandId').remove();
        $("#brandform").trigger("reset");

        var id = $(this).data('id');
        $('<input>').attr({ type: 'hidden', id: 'brandId', name: 'id', value: id }).appendTo('#brandform');
        $('#brandModal').modal('show');
        $('#brandSubmit').hide();
        $('#brandUpdate').show();
        $('#brandform').validate().resetForm(); 
        $('#brandform .form-control').removeClass('is-invalid'); 

        $.ajax({
            type: "GET",
            url: `/api/brands/${id}`,
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
            dataType: "json",
            success: function (data) {
                $('#brand_id').val(data.brand_name);

                var imagesHTML = '';
                data.img_path.split(',').forEach(function (path) {
                    if (path.endsWith('.jpg') || path.endsWith('.jpeg') || path.endsWith('.png')) {
                        imagesHTML += `<img src="${path}" width='200px' height='200px'>`;
                    }
                });
                $("#brandform").append("<div id='brandImages'>" + imagesHTML + "</div>");
            },
            error: function (error) {
                console.log(error);
            }
        });
    });

    $("#brandUpdate").on('click', function (e) {
        e.preventDefault();
        var id = $('#brandId').val();
        var data = $('#brandform')[0];
        let formData = new FormData(data);
        formData.append("_method", "PUT");
        $.ajax({
            type: "POST",
            url: `/api/brands/${id}`,
            data: formData,
            contentType: false,
            processData: false,
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
            dataType: "json",
            success: function (data) {
                $('#brandModal').modal("hide");
                table.ajax.reload();
            },
            error: function (error) {
                console.log(error);
            }
        });
    });

    $('#brandtable tbody').on('click', 'a.deleteBtn', function (e) {
        e.preventDefault();
        var id = $(this).data('id');
        var $row = $(this).closest('tr');
        bootbox.confirm({
            message: "Do you want to delete this brand?",
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
                        url: `/api/brands/${id}`,
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
    $("#BexcelSubmit").on('click', function (e) {
        e.preventDefault();
        var formData = new FormData();
        formData.append('importFile', $('#importFile')[0].files[0]);
        $.ajax({
            type: "POST",
            url: "/api/brands/excel",
            data: formData,
            contentType: false,
            processData: false,
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
            success: function (data) {
                $("#ExcelBform").trigger("reset");
                $("#importExcelModal").modal("hide");
                table.ajax.reload();
            },
            error: function (error) {
                console.log(error);
            }
        });
    });

    // Handle Add Brand button click
    $("#addBrandBtn").on('click', function () {
        $("#brandform").trigger("reset");
        $('#brandModal').modal('show');
        $('#brandUpdate').hide();
        $('#brandSubmit').show();
        $('#brandImages').remove();
        $('#brandform').validate().resetForm(); 
        $('#brandform .form-control').removeClass('is-invalid'); 
    });

    // Handle Import Excel button click
    $("#importExcelBtn").on('click', function () {
        $("#ExcelBform").trigger("reset");
        $('#importExcelModal').modal('show');
    });
});
