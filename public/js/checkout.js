$(document).ready(function() {
    // Assuming you have the customerId available
    var customerId = $('#customerId').val();

    // Fetch Cart Items
    $.ajax({
        url: `/api/cart-items`, // No need for customerId in URL if it's handled in controller
        method: 'GET',
        success: function(response) {
            renderCartItems(response.items);
            $('#totalAmount').text(`$${response.total.toFixed(2)}`);
        },
        error: function(xhr) {
            console.error('Failed to fetch cart items:', xhr.responseJSON.error);
        }
    });

    // Fetch User Email
    $.ajax({
        url: `/api/user-email`, // No need for customerId in URL if it's handled in controller
        method: 'GET',
        success: function(response) {
            $('#email').val(response.email);
        },
        error: function(xhr) {
            console.error('Failed to fetch user email:', xhr.responseJSON.error);
        }
    });

    // Fetch User Name
    $.ajax({
        url: `/api/user-name`, // No need for customerId in URL if it's handled in controller
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
                // Ensure response.address is a string
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
                <div class="flex flex-col rounded-lg bg-white sm:flex-row">
                    <img class="m-2 h-24 w-28 rounded-md border object-cover object-center" src="${item.product.img_path}" alt="" />
                    <div class="flex w-full flex-col px-4 py-4">
                        <span class="font-semibold">${item.product.product_name}</span>
                        <span class="float-right text-gray-400">${item.product.size}</span>
                        <p class="text-lg font-bold">$${item.product.price}</p>
                        <p>Quantity: ${item.quantity}</p>
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

    // Function to update the shipping cost and total amount
    function updateTotal() {
        // Get selected shipping method
        const selectedShipping = $('input[name="shipping"]:checked').val();
        const shippingCost = shippingCosts[selectedShipping] || 0;

        // Get subtotal from element
        const subtotalText = $('#totalAmount').text();
        const subtotal = parseFloat(subtotalText.replace('$', '')) || 0;

        // Calculate total
        const total = subtotal + shippingCost;

        // Update the shipping and total amounts
        $('#shippingAmount').text(`$${shippingCost.toFixed(2)}`);
        $('#total').text(`$${total.toFixed(2)}`);
    }

    // On shipping method change
    $('input[name="shipping"]').on('change', function() {
        updateTotal();
    });

    // Initial call to set the total on page load
    updateTotal();
});
