$(document).ready(function () {

    var table = $('#productable').DataTable({
        ajax: {
            url: "/api/products",
            dataSrc: ""
        },
        dom: 'Bfrtip',
        buttons: [
            {
                extend: 'pdfHtml5',
                text: 'Export to PDF',
                exportOptions: {
                    columns: [0, 1, 2, 3, 4, 5, 6, 7] // Exclude the Actions column
                }
            },
            'excel',
            {
                text: 'Add Product',
                className: 'btn btn-primary',
                action: function (e, dt, node, config) {
                    $("#pform").trigger("reset");
                    $('#ProductModal').modal('show');
                    $('#ProductUpdate').hide();
                    $('#ProductSubmit').show();
                    $('#images').remove();
                }
            }
        ],
        columns: [
            { data: "id" },
            {
                data: "img_path",
                render: function (data) {
                    var imgHtml = "";
                    if (data) {
                        var images = data.split(',');
                        images.forEach(function (imgPath) {
                            imgPath = imgPath.trim();
                            imgHtml += "<img src='/" + imgPath + "' width='200px' height='200px' style='margin: 5px;' onerror='this.onerror=null;this.src=\"/default-image.jpg\";' />";
                        });
                    }
                    return imgHtml;
                }
            },
            { data: "product_name" },
            { data: "description" },
            { data: "brand.brand_name" },
            { data: "price" },
            { data: "stocks" },
            { data: "category" },
            {
                data: null,
                render: function (data) {
                    return "<a href='#' data-toggle='modal' data-target='#ProductModal' id='editbtn' data-id='" + data.id + "'><i class='fas fa-edit' aria-hidden='true' style='font-size:24px; color:blue'></i></a> " +
                        "<a href='#' class='deletebtn' data-id='" + data.id + "'><i class='fa fa-trash' style='font-size:24px; color:red'></a></i>";
                }
            }
        ]
    });

    // Fetch brands for the brand select dropdown
    $.ajax({
        type: "GET",
        url: "/api/brands",
        dataType: 'json',
        success: function (data) {
            var brandSelect = $("#brand_id");
            $.each(data, function (key, value) {
                var option = $("<option>").val(value.id).text(value.brand_name);
                brandSelect.append(option);
            });
        },
        error: function () {
            console.log('Failed to fetch brands');
        }
    });


    // Initialize jQuery validation
    $('#pform').validate({
        rules: {
            product_name: {
                required: true
            },
            description: {
                required: true
            },
            price: {
                required: true,
                number: true
            },
            stocks: {
                required: true,
                number: true
            },
            category: {
                required: true
            },
            brand_id: {
                required: true
            },
            'uploads[]': {
                required: true
            }
        },
        messages: {
            product_name: {
                required: "Product name is required"
            },
            description: {
                required: "Description is required"
            },
            price: {
                required: "Price is required",
                number: "Price must be a number"
            },
            stocks: {
                required: "Stocks are required",
                number: "Stocks must be a number"
            },
            category: {
                required: "Category is required"
            },
            brand_id: {
                required: "Please select a brand"
            },
            'uploads[]': {
                required: "Please upload at least one image"
            }
        },
        errorClass: "error-message",
        errorPlacement: function (error, element) {
            error.insertAfter(element);
        }
    });

    // Handle product submission
    $("#ProductSubmit").on('click', function (e) {
        e.preventDefault();
        var data = $('#pform')[0];
        let formData = new FormData(data);
        $.ajax({
            type: "POST",
            url: "/api/products",
            data: formData,
            contentType: false,
            processData: false,
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
            dataType: "json",
            success: function () {
                $("#ProductModal").modal("hide");
                table.ajax.reload();
            },
            error: function (error) {
                console.log(error);
            }
        });
    });

    // Handle delete button
    $('#productable').on('click', 'a.deletebtn', function (e) {
        e.preventDefault();
        var id = $(this).data('id');
        var $row = $(this).closest('tr');
        bootbox.confirm({
            message: "Do you want to delete this product?",
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
                        url: `/api/products/${id}`,
                        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                        dataType: "json",
                        success: function (data) {
                            $row.fadeOut(4000, function () {
                                $row.remove();
                            });
                            bootbox.alert(data.message);
                            table.ajax.reload();
                        },
                        error: function (error) {
                            console.log(error);
                        }
                    });
                }
            }
        });
    });

    // Handle modal form when opening for editing
    $('#ProductModal').on('show.bs.modal', function (e) {
        $("#pform").trigger("reset");
        $('#productId').remove();
        $('#images').remove();
        var id = $(e.relatedTarget).attr('data-id');
        if (id) {
            $('<input>').attr({ type: 'hidden', id: 'productId', name: 'id', value: id }).appendTo('#pform');
            $('#ProductUpdate').show();
            $('#ProductSubmit').hide();
            $.ajax({
                type: "GET",
                url: `/api/products/${id}`,
                success: function (data) {
                    $("#product_name").val(data.product_name);
                    $("#description").val(data.description);
                    $("#price").val(data.price);
                    $("#stocks").val(data.stocks);
                    $("#category").val(data.category);
                    $("#brand_id").val(data.brand_id);
                    var imagesHTML = '';
                    data.img_path.split(',').forEach(function (path) {
                        if (path.endsWith('.jpg') || path.endsWith('.jpeg') || path.endsWith('.png')) {
                            imagesHTML += `<img src="${path}" width='200px' height='200px'>`;
                        }
                    });
                    $("#pform").append("<div id='images'>" + imagesHTML + "</div>");
                },
                error: function () {
                    console.log('AJAX load did not work');
                    alert("error");
                }
            });
        } else {
            $('#ProductUpdate').hide();
            $('#ProductSubmit').show();
        }
    });

    // Handle product update
    $("#ProductUpdate").on('click', function (e) {
        e.preventDefault();
        var id = $('#productId').val();
        var data = $('#pform')[0];
        let formData = new FormData(data);
        formData.append("_method", "PUT");

        $.ajax({
            type: "POST",
            url: `/api/products/${id}`,
            data: formData,
            contentType: false,
            processData: false,
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
            dataType: "json",
            success: function () {
                $("#ProductModal").modal("hide");  // Hide the modal after successful update
                table.ajax.reload();
            },
            error: function (error) {
                console.log(error);
            }
        });
    });

    // Bind the add product button to open the modal
    $('#addProductButton').on('click', function () {
        $('#ProductModal').modal('show');
        $('#ProductUpdate').hide();
        $('#ProductSubmit').show();
        $('#images').remove();
    });


});
