$(document).ready(function () {
    // Initialize DataTable
    var table = $('#productable').DataTable({
        ajax: {
            url: "/api/products",
            dataSrc: ""
        },
        dom: '<"top"lBf>rt<"bottom"ip><"clear">',
        buttons: [
            {
                extend: 'pdfHtml5',
                text: '<i class="fa fa-file-pdf"></i> Export to PDF',
                className: 'btn btn-primary mr-2',
                exportOptions: {
                    columns: [0, 1, 2, 3, 4, 5, 6, 7]
                }
            }
        ],
        columns: [
            { data: 'id', title: 'ID' },
            {
                data: 'img_path',
                title: 'Images',
                render: function (data) {
                    var imgHtml = "";
                    if (data) {
                        var images = data.split(',');
                        images.forEach(function (imgPath) {
                            imgPath = imgPath.trim();
                            imgHtml += "<img src='/" + imgPath + "' width='150px' height='150px' style='margin: 5px;' onerror='this.onerror=null;this.src=\"/default-image.jpg\";' />";
                        });
                    }
                    return imgHtml;
                }
            },
            { data: 'product_name', title: 'Product Name' },
            { data: 'description', title: 'Description' },
            { data: 'brand.brand_name', title: 'Brand Name' },
            { data: 'price', title: 'Price' },
            { data: 'stocks', title: 'Stocks' },
            { data: 'category', title: 'Category' },
            {
                data: null,
                title: 'Actions',
                render: function (data) {
                    if (data.deleted_at) {
                        // If product is trashed, show restore button
                        return "<button type='button' class='btn btn-sm btn-warning restoreBtn' data-id='" + data.id + "'><i class='fas fa-undo'></i> Restore</button>";
                    } else {
                        // Otherwise, show edit and delete buttons
                        return "<a href='#' data-toggle='modal' data-target='#ProductModal' class='btn btn-sm btn-primary editBtn' data-id='" + data.id + "'><i class='fas fa-edit'></i> Edit</a> " +
                            "<button type='button' class='btn btn-sm btn-danger deleteBtn' data-id='" + data.id + "'><i class='fas fa-trash-alt'></i> Delete</button>";
                    }
                }
            }
        ],
        headerCallback: function(thead) {
            $(thead).find('th').css({
                'background-color': '#000000',
                'color': '#ffffff'
            });
        },
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

    // Fetch brands for dropdown (assuming this part remains unchanged)
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
    // Validation
    $('#pform').validate({
        rules: {
            product_name: {
                required: true,
                letterswithspace: true
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
                required: true,
                letterswithspace: true
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
                required: "Product name is required",
                letterswithspace: "Product name must be letters"
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
                required: "Category is required",
                letterswithspace: "Category must be letters"
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

    function resetProductForm() {
        $('#pform').trigger('reset');
        $('#pform').validate().resetForm();
        $('.is-invalid').removeClass('is-invalid');
        $('#stocks').prop('readonly', false);
    }


    $("#addProductBtn").on('click', function () {
        resetProductForm();
        $('#ProductModal').modal('show');
        $('#ProductUpdate').hide();
        $('#ProductSubmit').show();
        $('#images').remove();
        $('#stocks').prop('readonly', false);
    });

    $('#ProductModal').on('show.bs.modal', function (e) {
        resetProductForm();
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
                     // Disable the "stocks" textbox when updating a product
                     $('#stocks').prop('readonly', true);
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


    $("#ProductSubmit").on('click', function (e) {
        e.preventDefault();
        if ($('#pform').valid()) {
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
        }
    });


    $("#ProductUpdate").on('click', function (e) {
        e.preventDefault();
        if ($('#pform').valid()) {
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
                    $("#ProductModal").modal("hide");
                    table.ajax.reload();
                },
                error: function (error) {
                    console.log(error);
                }
            });
        }
    });

//delete
$('#productable').on('click', 'button.deleteBtn', function (e) {
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

// Restore functionality
$('#productable').on('click', 'button.restoreBtn', function (e) {
    e.preventDefault();
    var id = $(this).data('id');
    var $row = $(this).closest('tr');
    bootbox.confirm({
        message: "Do you want to restore this product?",
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
                    type: "POST",
                    url: `/api/products/${id}/restore`,
                    headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                    dataType: "json",
                    success: function (data) {
                        table.ajax.reload();
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

    // Excel import
    $("#PexcelSubmit").on('click', function (e) {
        e.preventDefault();
        var formData = new FormData();
        formData.append('importFile', $('#importFile')[0].files[0]);
        $.ajax({
            type: "POST",
            url: "/api/products/excel",
            data: formData,
            contentType: false,
            processData: false,
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
            success: function () {
                $("#ExcelPform").trigger("reset");
                $("#importExcelModal").modal("hide");
                table.ajax.reload();
            },
            error: function (error) {
                console.log(error);
            }
        });
    });

    // Handle Import Excel button click
    $("#importExcelBtn").on('click', function () {
        $("#ExcelBform").trigger("reset");
        $('#importExcelModal').modal('show');
    });
});
