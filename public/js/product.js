$(document).ready(function () {
    $.ajax({
        type: "GET",
        url: "/api/products",
        dataType: 'json',
        success: function (data) {
            console.log(data);
            $.each(data, function (key, value) {
                console.log(value);
                id = value.id;
                var imgHtml = "";
                if (value.img_path) {
                    var images = value.img_path.split(',');
                    images.forEach(function (imgPath) {
                        imgPath = imgPath.trim();
                        console.log("Image Path: ", imgPath);  // Debugging image paths
                        imgHtml += "<img src='/" + imgPath + "' width='200px' height='200px' style='margin: 5px;' onerror='this.onerror=null;this.src=\"/default-image.jpg\";'/>";  // Added a default image for broken links
                    });
                }
                var tr = $("<tr>");
                tr.append($("<td>").html(value.id));
                tr.append($("<td>").html(imgHtml));
                tr.append($("<td>").html(value.product_name));
                tr.append($("<td>").html(value.description));
                tr.append($("<td>").html(value.brand.brand_name));
                tr.append($("<td>").html(value.price));
                tr.append($("<td>").html(value.stocks));
                tr.append($("<td>").html(value.category));
                tr.append("<td align='center'><a href='#' data-toggle='modal' data-target='#ProductModal' id='editbtn' data-id=" + id + "><i class='fas fa-edit' aria-hidden='true' style='font-size:24px; color:blue'></i></a></td>");
                tr.append("<td><a href='#'  class='deletebtn' data-id=" + id + "><i  class='fa fa-trash' style='font-size:24px; color:red' ></a></i></td>");
                $("#productbody").append(tr);
            });
        },
        error: function () {
            console.log('AJAX load did not work');
            alert("error");
        }
    });

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


    $("#ProductSubmit").on('click', function (e) {
        e.preventDefault();
        var data = $('#pform')[0];
        console.log(data);
        let formData = new FormData(data);
        console.log(formData);
        for (var pair of formData.entries()) {
            console.log(pair[0] + ', ' + pair[1]);
        }
        $.ajax({
            type: "POST",
            url: "/api/products",
            data: formData,
            contentType: false,
            processData: false,
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
            dataType: "json",
            success: function (data) {
                console.log(data);
              /*  $("#ProductModal").modal("hide");
                id = value.id;
                var img = "<img src=" + value.image_path + " width='200px', height='200px'/>";
                var tr = $("<tr>");
                tr.append($("<td>").html(value.id));
                tr.append($("<td>").html(img));
                tr.append($("<td>").html(value.product_name));
                tr.append($("<td>").html(value.description));
                tr.append($("<td>").html(value.brand.brand_name));
                tr.append($("<td>").html(value.price));
                tr.append($("<td>").html(value.stocks));
                tr.append($("<td>").html(value.category));
                tr.append("<td align='center'><a href='#' data-toggle='modal' data-target='#customerModal' id='editbtn' data-id=" + id + "><i class='fas fa-edit' aria-hidden='true' style='font-size:24px; color:blue'></i></a></td>");
                tr.append("<td><a href='#'  class='deletebtn' data-id=" + id + "><i  class='fa fa-trash' style='font-size:24px; color:red' ></a></i></td>");
                $("#productbody").append(tr);*/
               // table.ajax.reload();
            },
            error: function (error) {
                console.log(error);
            }
        });
    });


   $('#ProductModal').on('show.bs.modal', function(e) {
        $("#pform").trigger("reset");
        $('#productId').remove()
        $('#images').remove()
        console.log(e.relatedTarget)
        var id = $(e.relatedTarget).attr('data-id');
        console.log(id);
       
        $('<input>').attr({type: 'hidden', id:'productId',name: 'id',value: id}).appendTo('#pform');
        $.ajax({
            type: "GET",
            url: `/api/products/${id}`,
            success: function(data){
                   // console.log(data);
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
             error: function(){
              console.log('AJAX load did not work');
              alert("error");
              }
          });
    });

  /*     $("#ProductUpdate").on('click', function (e) {
        e.preventDefault
        var id = $('#productId').val();
        var $row = $('tr td > a[data-id="' + id + '"]').closest('tr');
        console.log($row)
        // var data = $('#cform')[0];
        let formData = new FormData($('#cform')[0]);
        formData.append('_method', 'PUT')
        $.ajax({
            type: "POST",
            url: `/api/products/${id}`,
            data: formData,
            contentType: false,
            processData: false,
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
            dataType: "json",
            success: function (data) {
                console.log(data);
                
                $('#ProductModal').modal('hide')
                $row.remove()
                var imgHtml = "";
                if (value.img_path) {
                    var images = value.img_path.split(',');
                    images.forEach(function (imgPath) {
                        imgPath = imgPath.trim();
                        console.log("Image Path: ", imgPath);  // Debugging image paths
                        imgHtml += "<img src='/" + imgPath + "' width='200px' height='200px' style='margin: 5px;' onerror='this.onerror=null;this.src=\"/default-image.jpg\";'/>";  // Added a default image for broken links
                    });
                }
                var tr = $("<tr>");
                tr.append($("<td>").html(value.id));
                tr.append($("<td>").html(imgHtml));
                tr.append($("<td>").html(value.product_name));
                tr.append($("<td>").html(value.description));
                tr.append($("<td>").html(value.brand.brand_name));
                tr.append($("<td>").html(value.price));
                tr.append($("<td>").html(value.stocks));
                tr.append($("<td>").html(value.category));
                tr.append("<td align='center'><a href='#' data-toggle='modal' data-target='#customerModal' id='editbtn' data-id=" + data.id + "><i class='fas fa-edit' aria-hidden='true' style='font-size:24px' ></a></i></td>");
                tr.append("<td><a href='#'  class='deletebtn' data-id=" + data.id + "><i  class='fa fa-trash' style='font-size:24px; color:red' ></a></i></td>");
                $('#productable').prepend(tr.hide().fadeIn(5000));
            },
            error: function (error) {
                console.log(error);
            }
        });
    });  */


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
            success: function (data) {
                $('#ProductModal').modal("hide");
                table.ajax.reload();
            },
            error: function (error) {
                console.log(error);
            }
        });
    });

    $('#productable productbody').on('click', 'a.deletebtn', function (e) {

        var id = $(this).data('id');
        var $row = $(this).closest('tr');
        console.log(id);
        // console.log(table);
        e.preventDefault();
        bootbox.confirm({
            message: "do you want to delete this customer",
            buttons: {
                confirm: {
                    label: 'yes',
                    className: 'btn-success'
                },
                cancel: {
                    label: 'no',
                    className: 'btn-danger'
                }
            },
            callback: function (result) {
                console.log(result);
                if (result)
                    $.ajax({
                        type: "DELETE",
                        url: `/api/products/${id}`,
                        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                        dataType: "json",
                        success: function (data) {
                            console.log(data);
                            $row.fadeOut(4000, function () {
                                $row.remove()
                            });

                            bootbox.alert(data.message);
                        },
                        error: function (error) {
                            console.log(error);
                        }
                    });
            }
        });
    });
})