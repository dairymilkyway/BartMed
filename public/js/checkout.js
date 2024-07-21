$(document).ready(function() {
    var customerId = $('#customerId').val();

    $.ajax({
        url: `/api/cart-items`,
        method: 'GET',
        success: function(response) {
            renderCartItems(response.items);
            $('#totalAmount').text(`$${response.total.toFixed(2)}`);
        },
        error: function(xhr) {
            console.error('Failed to fetch cart items:', xhr.responseJSON.error);
        }
    });


    $.ajax({
        url: `/api/user-email`,
        method: 'GET',
        success: function(response) {
            $('#email').val(response.email);
        },
        error: function(xhr) {
            console.error('Failed to fetch user email:', xhr.responseJSON.error);
        }
    });

    $.ajax({
        url: `/api/user-name`,
        method: 'GET',
        success: function(response) {
            $('#card-holder').val(response.name);
        },
        error: function(xhr) {
            console.error('Failed to fetch user name:', xhr.responseJSON.error);
        }
    });

    $(document).ready(function() {
        $.ajax({
            url: '/api/get-address',
            type: 'GET',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                if (typeof response.address === 'string') {
                    $('#billing-address').val(response.address);
                } else {
                    console.error('Address field is not a string:', response.address);
                }
            },
            error: function(xhr) {
                console.error('An error occurred while fetching the address.');
            }
        });
    });

    function renderCartItems(items) {
        var itemsHtml = '';
        items.forEach(function(item) {
            itemsHtml += `
            <div class="cart-item" data-product-id="${item.product.id}">
                <div class="flex flex-col rounded-lg bg-white sm:flex-row">
                    <img class="m-2 h-24 w-28 rounded-md border object-cover object-center" src="${item.product.img_path}" alt="" />
                    <div class="flex w-full flex-col px-4 py-4">
                        <span class="font-semibold">${item.product.product_name}</span>
                        <span class="float-right text-gray-400">${item.product.id}</span>
                        <p class="text-lg font-bold">$${item.product.price}</p>
                         <p>Quantity: <input type="number" class="quantity" value="${item.quantity}" min="1" /></p>
                    </div>
                </div>
                </div>
            `;
        });
        $('#cartItems').html(itemsHtml);
    }

    const shippingCosts = {
        'standard': 15,
        'express': 30
    };


    function updateTotal() {
        const selectedShipping = $('input[name="shipping"]:checked').val();
        const shippingCost = shippingCosts[selectedShipping] || 0;

        const subtotalText = $('#totalAmount').text();
        const subtotal = parseFloat(subtotalText.replace('$', '')) || 0;

        const total = subtotal + shippingCost;

        $('#shippingAmount').text(`$${shippingCost.toFixed(2)}`);
        $('#total').text(`$${total.toFixed(2)}`);
    }

    $('input[name="shipping"]').on('change', function() {
        updateTotal();
    });

    updateTotal();


    $('#placeOrderButton').click(function(e) {
        e.preventDefault();
        var shippingMethod = $('input[name="shipping"]:checked').val();

        var products = [];
        $('#cartItems .cart-item').each(function() {
            var quantity = $(this).find('.quantity').val();
            var product = {
                id: $(this).data('product-id'),
                quantity: quantity || 1
            };
            products.push(product);
        });

        var data = {
            courier: shippingMethod,
            payment_method: $('#payment-method').val(),
            products: products,
            _token: $('meta[name="csrf-token"]').attr('content')
        };

        $.ajax({
            url: '/api/order-store',
            type: 'POST',
            data: JSON.stringify(data),
            contentType: 'application/json',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                if (response.success) {
                    alert(response.message);
                    window.location.href = '/orders';
                    $('#cartItems').empty();
                    $('#totalAmount').text('$0.00');
                    $('#shippingFee').text('$0.00');
                } else {
                    alert(response.message);
                }
            },
            error: function(xhr) {
                alert('An error occurred while placing the order.');
            }
        });
    });




});
