$(document).ready(function() {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    function fetchCartItems() {
        $.ajax({
            url: '/api/fetchcart', // Replace with your API endpoint to fetch cart items
            type: 'GET',
            success: function(response) {
                renderCartItems(response.data); // Assuming response.data contains cart items
            },
            error: function(err) {
                console.error('Error fetching cart items:', err);
            }
        });
    }

    // Function to render cart items in the UI
    function renderCartItems(cartItems) {
        $('#cartItemsContainer').empty(); // Clear existing items

        var tableHtml = `
          <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
              <tr>
                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Image</th>
                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Product Name</th>
                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Description</th>
                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Price</th>
                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Quantity</th>
                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
              </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
        `;

        cartItems.forEach(function(item) {
            tableHtml += `
              <tr>
                <!-- Table cells for each item -->
                <td>
                  <!-- Product image -->
                  <img src="${item.product.img_path}" alt="${item.product.product_name}" class="h-16 w-16 rounded object-cover">
                </td>
                <td>${item.product.product_name}</td>
                <td>${item.product.description}</td>
                <td>$${item.product.price}</td>
                <td>
                  <!-- Quantity input and buttons -->
                  <div class="flex items-center">
                    <button type="button" class="text-gray-600 decrement-btn" data-cart-item-id="${item.product_id}">
                      <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="h-5 w-5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M20 12H4"/>
                      </svg>
                    </button>
                    <input type="text" value="${item.quantity}" class="h-10 w-14 rounded border-gray-200 bg-gray-50 p-0 text-center text-sm text-gray-600 focus:outline-none">
                    <button type="button" class="text-gray-600 increment-btn" data-cart-item-id="${item.product_id}">
                      <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="h-5 w-5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                      </svg>
                    </button>
                  </div>
                </td>
                <td>
                  <!-- Delete button -->
                  <button class="text-gray-600 hover:text-red-600 delete-btn" data-customer-id="${item.customer_id}"
                        data-product-id="${item.product_id}">
                    <span class="sr-only">Remove item</span>
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-6 w-6">
                      <path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0"/>
                    </svg>
                  </button>
                </td>
              </tr>
            `;
        });

        tableHtml += `
            </tbody>
          </table>
        `;

        $('#cartItemsContainer').html(tableHtml);

        $('.increment-btn').click(function() {
            var cartItemId = $(this).attr('data-cart-item-id');
            incrementQuantity(cartItemId);
        });

        $('.decrement-btn').click(function() {
            var cartItemId = $(this).attr('data-cart-item-id');
            decrementQuantity(cartItemId);
        });

        $('.delete-btn').click(function() {
            var customerId = $(this).attr('data-customer-id');
            var productId = $(this).attr('data-product-id');
            deleteCartItem(customerId, productId);
        });
    }
    function deleteCartItem(customerId, productId) {
        $.ajax({
            url: `/api/cart/${customerId}/${productId}`,
            type: 'DELETE',
            success: function(response) {
                fetchCartItems();
            },
            error: function(err) {
                console.error('Error deleting item:', err);
            }
        });
    }


    // Function to increment quantity of a cart item
    function incrementQuantity(cartItemId) {
        // Implement logic to update quantity
        console.log('Increment quantity for cart item:', cartItemId);
        // Make an AJAX request to update quantity
    }

    // Function to decrement quantity of a cart item
    function decrementQuantity(cartItemId) {
        // Implement logic to update quantity
        console.log('Decrement quantity for cart item:', cartItemId);
        // Make an AJAX request to update quantity
    }

    // Initial fetch of cart items when the page loads
    fetchCartItems();
});
