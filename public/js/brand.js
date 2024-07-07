$(document).ready(function () {
    var table = $('#brandtable').DataTable({
        ajax: {
            url: "/api/brands",
            dataSrc: ""
        },
        dom: 'Bfrtip',
        buttons: [
            {
                extend: 'pdfHtml5',
                text: 'Export to PDF',
                exportOptions: {
                    columns: [0, 1, 2] // Exclude the Actions column
                },
                customize: function (doc) {
                    // Process images and embed them in the PDF
                    var images = [];
                    $('#brandtable tbody tr').each(function () {
                        var imgPaths = $(this).find('td:eq(2)').text().split(',');
                        var imagesHTML = '';
                        imgPaths.forEach(function (path) {
                            if (path.endsWith('.jpg') || path.endsWith('.jpeg') || path.endsWith('.png')) {
                                imagesHTML += `<img src="${path}" width="50" height="60" style="margin-right: 5px;">`;
                            }
                        });
                        images.push(imagesHTML);
                    });

                    doc.content[1].table.body.forEach(function (row, index) {
                        if (index > 0 && images[index - 1]) {
                            var imgData = images[index - 1];
                            row[2] = {
                                image: imgData,
                                width: 50,
                                height: 60
                            };
                        }
                    });
                }
            },
            'excel',
            {
                text: 'Add Brand',
                className: 'btn btn-primary',
                action: function (e, dt, node, config) {
                    $("#brandform").trigger("reset");
                    $('#brandModal').modal('show');
                    $('#brandUpdate').hide();
                    $('#brandSubmit').show();
                    $('#brandImages').remove();
                }
            }
        ],
        columns: [
            { data: 'id', title: 'ID' },
            { data: 'brand_name', title: 'Brand Name' },
            {
                data: 'img_path',
                title: 'Image',
                render: function (data, type, row) {
                    var imgPaths = data.split(',');
                    var imagesHTML = '';
                    imgPaths.forEach(function (path) {
                        if (path.endsWith('.jpg') || path.endsWith('.jpeg') || path.endsWith('.png')) {
                            imagesHTML += `<img src="${path}" width="50" height="60" style="margin-right: 5px;">`;
                        }
                    });
                    return imagesHTML;
                }
            },
            {
                data: null,
                title: 'Actions',
                render: function (data, type, row) {
                    return `<a href='#' class='editBtn' data-id="${data.id}"><i class='fas fa-edit' style='font-size:24px'></i></a>
                            <a href='#' class='deleteBtn' data-id="${data.id}"><i class='fas fa-trash-alt' style='font-size:24px; color:red'></i></a>`;
                }
            }
        ]
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
                table.ajax.reload();
            },
            error: function (error) {
                console.log(error);
            }
        });
    });
    
    
});
