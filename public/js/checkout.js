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
            // Split the img_path and take the first image
            var firstImage = item.product.img_path.split(',')[0];

            itemsHtml += `
            <div class="cart-item" data-product-id="${item.product.id}">
                <div class="flex flex-col rounded-lg bg-white sm:flex-row">
                    <img class="m-2 h-24 w-28 rounded-md border object-cover object-center" src="${firstImage}" alt="" />
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
        'J&T': 15,
        'LBC': 30
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
                if (response.order_id) {
                    alert(response.message);
                    window.location.href = '/home';
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

    $(document).ready(function() {
        // Function to open the review modal
        window.openReviewModal = function(orderId, productId) {
            $('#orderId').val(orderId);
            $('#productId').val(productId);
            $('#reviewModal').removeClass('hidden');
        };

        // Close the review modal
        $('#closeModal').on('click', function() {
            $('#reviewModal').addClass('hidden');
        });

        // Handle review form submission
        $('#reviewForm').on('submit', function(e) {
            e.preventDefault();

            const formData = $(this).serialize();

            $.ajax({
                url: '/api/add-review', // Your API endpoint
                method: 'POST',
                data: formData,
                success: function(response) {
                    alert('Review added successfully!');
                    $('#reviewModal').addClass('hidden');
                    // Optionally reload the order history or update the page
                },
                error: function(xhr) {
                    console.error('Failed to add review:', xhr.responseJSON.error);
                    alert('Failed to add review.');
                }
            });
        });

        // Fetch orders
        $.ajax({
            url: '/api/fetch-order', // Endpoint for fetching orders
            method: 'GET',
            success: function(response) {
                console.log(response); // Debugging: check the response structure
                renderOrderHistory(response);
            },
            error: function(xhr) {
                console.error('Failed to fetch orders:', xhr.responseJSON.error);
            }
        });
        function renderOrderHistory(orders) {
            if (!orders || !orders.length) {
                $('#userOrderHistory').html('<p>No orders found.</p>');
                return;
            }

            var ordersHtml = '';
            orders.forEach(function(order) {
                if (!order.products || !order.products.length) {
                    console.warn('No products found for order:', order.id);
                    return;
                }

                var productsHtml = '';
                order.products.forEach(function(product) {
                    var imgPath = product.img_path.split(',')[0];
                    productsHtml += `
                    <div class="grid grid-cols-4 w-full mb-4">
                        <div class="col-span-4 sm:col-span-1">
                            <img src="${imgPath}" alt="${product.product_name}" class="max-sm:mx-auto">
                        </div>
                        <div class="col-span-4 sm:col-span-3 flex flex-col justify-center max-sm:items-center">
                            <h6 class="font-manrope font-semibold text-2xl leading-9 text-black mb-3 whitespace-nowrap">
                                ${product.product_name}
                            </h6>
                            <div class="flex items-center gap-x-10 gap-y-3">
                                <p class="font-semibold text-xl leading-8 text-black whitespace-nowrap">Price $${product.price}</p>
                                <p class="font-semibold text-xl leading-8 text-black whitespace-nowrap">Quantity ${product.pivot.quantity}</p>
                            </div>
                        </div>
                        ${order.order_status === 'delivered' ? `
                        <div class="col-span-4 mt-4 flex gap-2">
                            <button class="rounded-full px-4 py-2 bg-blue-600 text-white font-semibold text-sm transition-all duration-500 hover:bg-blue-700"
                                    onclick="openReviewModal(${order.id}, ${product.id})"
                                    data-product-id="${product.id}">Add Review</button>
                            <button class="rounded-full px-4 py-2 bg-green-600 text-white font-semibold text-sm transition-all duration-500 hover:bg-green-700"
                                    onclick="viewReviews(${product.id})">View Reviews</button>
                        </div>
                        ` : ''}
                    </div>
                    `;
                });

                var statusClass;
                var statusText;
                var cancelButtonHtml = '';

                switch (order.order_status) {
                    case 'delivered':
                        statusClass = 'text-green-500';
                        statusText = 'Delivered';
                        break;
                    case 'cancelled':
                        statusClass = 'text-red-500';
                        statusText = 'Cancelled';
                        cancelButtonHtml = `
                        <button class="rounded-full px-7 py-3 bg-gray-400 text-white font-semibold text-sm transition-all duration-500 cursor-not-allowed">
                            Cancelled
                        </button>
                        `;
                        break;
                    default:
                        statusClass = 'text-gray-500';
                        statusText = order.order_status.charAt(0).toUpperCase() + order.order_status.slice(1); // Capitalize the first letter of the status
                        cancelButtonHtml = `
                        <button class="rounded-full px-4 py-2 bg-red-600 text-white font-semibold text-sm transition-all duration-500 hover:bg-red-700" data-order-id="${order.id}" onclick="cancelOrder(${order.id})">Cancel</button>
                        `;
                        break;
                }


                ordersHtml += `
                <div class="border border-gray-300 p-4 mb-4">
                    <div class="flex justify-between items-center mb-4">
                        <div>
                            <p class="font-medium text-lg leading-8 text-black">Order #: ${order.id}</p>
                            <p class="font-medium text-lg leading-8 text-black mt-3">Order Date: ${new Date(order.created_at).toLocaleDateString()}</p>
                            <p class="font-medium text-lg leading-8 text-black mt-3"><span class="text-black-500">Total Price:</span> &nbsp;$${order.total_price}</p>
                        </div>

                        <div class="flex flex-col justify-center items-start max-sm:items-center">
                            <p class="font-normal text-lg text-gray-500 leading-8 mb-2 text-left whitespace-nowrap">Status</p>
                            <p class="font-semibold text-lg leading-8 ${statusClass} text-left whitespace-nowrap">${statusText}</p>
                        </div>

                        <div>
                            ${cancelButtonHtml}
                        </div>
                    </div>
                    ${productsHtml}
                    <svg class="my-9 w-full" xmlns="http://www.w3.org/2000/svg" width="1216" height="2" viewBox="0 0 1216 2" fill="none">
                        <path d="M0 1H1216" stroke="#D1D5DB" />
                    </svg>
                </div>
                `;
            });

            $('#userOrderHistory').html(ordersHtml);
        }



        window.cancelOrder = function(orderId) {
            $.ajax({
                url: '/api/cancel-order',
                method: 'POST',
                data: {
                    order_id: orderId
                },
                success: function(response) {
                    alert(response.message); // Show a success message
                    location.reload(); // Reload the page to refresh the order list
                },
                error: function(xhr) {
                    console.error('Failed to cancel order:', xhr.responseJSON.error);
                    alert('Failed to cancel the order.');
                }
            });
        };
    });

    window.viewReviews = function(productId) {
        $.ajax({
            url: `/api/reviews/${productId}`,
            method: 'GET',
            success: function(response) {
                if (response && response.reviews && response.reviews.length) {
                    var reviewsHtml = '';
                    response.reviews.forEach(function(review) {
                        reviewsHtml += `
                        <div class="mb-4">
                            <p><strong>Rating:</strong> ${'⭐'.repeat(review.rating)}</p>
                            <p><strong>Review:</strong> ${review.review}</p>
                            <hr>
                        </div>
                        `;
                    });
                    $('#reviewsContainer').html(reviewsHtml);
                } else {
                    $('#reviewsContainer').html('<p>No reviews found for this product.</p>');
                }
                $('#reviewsModal').removeClass('hidden');
            },
            error: function(xhr) {
                console.error('Failed to fetch reviews:', xhr.responseJSON.error);
                alert('Failed to fetch the reviews.');
            }
        });
    };

    $('#closeReviewsModal').click(function() {
        $('#reviewsModal').addClass('hidden');
    });





});
