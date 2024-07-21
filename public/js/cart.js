$(document).ready(function() {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    function fetchCartItems() {
        $.ajax({
            url: '/api/fetchcart',
            type: 'GET',
            success: function(response) {
                renderCartItems(response.data);
            },
            error: function(err) {
                console.error('Error fetching cart items:', err);
            }
        });
    }
    function renderCartItems(cartItems) {
      $('#cartItemsContainer').empty();
  
      var tableHtml = `
        <section>
          <div class="mx-auto max-w-screen-xl px-4 py-8 sm:px-6 sm:py-12 lg:px-8">
            <header class="text-center">
            </header>
  
            <div class="mt-8">
              <div class="flex items-center gap-4 mb-4">
                <input type="checkbox" id="selectAll" class="form-checkbox">
                <label for="selectAll" class="text-gray-700">Select All</label>
              </div>
              
              <ul class="space-y-4" id="cartItemsList">
      `;
  
      cartItems.forEach(function(item) {
          tableHtml += `
            <li class="flex items-center gap-4 p-4 bg-white shadow-lg rounded-lg">
              <input
                type="checkbox"
                class="item-checkbox"
                data-cart-item-id="${item.id}"
              />
              
              <img
                src="${item.product.img_path}"
                alt="${item.product.product_name}"
                class="h-16 w-16 rounded-lg object-cover"
              />
  
              <div class="flex-1">
                <h3 class="text-sm text-gray-900">${item.product.product_name}</h3>
                <p class="text-sm text-gray-600">$${(item.product.price * item.quantity).toFixed(2)}</p>
  
                <dl class="mt-0.5 text-xs text-gray-600">
                  <div>
                    <dt class="inline">${item.product.description}</dt>
                  </div>
                </dl>
              </div>
  
              <div class="flex items-center gap-2">
                <form>
                  <label for="Line${item.id}Qty" class="sr-only">Quantity</label>
  
                  <input
                    type="number"
                    min="1"
                    value="${item.quantity}"
                    id="Line${item.id}Qty"
                    class="h-8 w-12 rounded border-gray-200 bg-gray-50 text-center text-xs text-gray-600 focus:outline-none quantity-input"
                    data-cart-item-id="${item.id}"
                  />
                </form>
  
                <button class="text-gray-600 transition hover:text-red-600 decrement-btn" data-cart-item-id="${item.id}">
                  <span class="sr-only">Decrease Quantity</span>
                  <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-4 w-4">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M20 12H4"/>
                  </svg>
                </button>
  
                <button class="text-gray-600 transition hover:text-red-600 increment-btn" data-cart-item-id="${item.id}">
                  <span class="sr-only">Increase Quantity</span>
                  <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-4 w-4">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                  </svg>
                </button>
  
                <button class="text-gray-600 transition hover:text-red-600 delete-btn" data-customer-id="${item.customer_id}" data-product-id="${item.product_id}">
                  <span class="sr-only">Remove item</span>
                  <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-4 w-4">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0"/>
                  </svg>
                </button>
              </div>
            </li>
          `;
      });
  
      tableHtml += `
              </ul>
  
              <div class="mt-8 flex justify-end border-t border-gray-100 pt-8">
                <div class="w-screen max-w-lg space-y-4">
                  <dl class="space-y-0.5 text-sm text-gray-700">
                    <div class="flex justify-between !text-base font-medium">
                      <dt>Total</dt>
                      <dd id="subtotal">$0.00</dd>
                    </div>
                  </dl>
  
                  <div class="flex justify-end">
                    <button id="checkoutButton" class="px-6 py-3 bg-blue-600 text-white font-medium rounded-lg shadow-lg hover:bg-blue-700 transition-colors duration-300">Checkout</button>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </section>
      `;
  
      $('#cartItemsContainer').html(tableHtml);
  
      function updateSubtotal() {
          let subtotal = 0;
          $('.item-checkbox:checked').each(function() {
              const itemId = $(this).attr('data-cart-item-id');
              const itemPrice = cartItems.find(item => item.id === parseInt(itemId)).product.price;
              const itemQuantity = parseInt($(this).closest('li').find('.quantity-input').val());
              subtotal += itemPrice * itemQuantity;
          });
          $('#subtotal').text(`$${subtotal.toFixed(2)}`);
      }
  
      $('.increment-btn').click(function() {
          var cartItemId = $(this).attr('data-cart-item-id');
          incrementQuantity(cartItemId);
          updateSubtotal();
      });
  
      $('.decrement-btn').click(function() {
          var cartItemId = $(this).attr('data-cart-item-id');
          decrementQuantity(cartItemId);
          updateSubtotal();
      });
  
      $('.quantity-input').change(function() {
          var cartItemId = $(this).attr('data-cart-item-id');
          var newQuantity = $(this).val();
          updateQuantity(cartItemId, newQuantity);
          updateSubtotal();
      });
  
      $('#selectAll').change(function() {
          var isChecked = $(this).is(':checked');
          $('.item-checkbox').prop('checked', isChecked);
          updateSubtotal();
      });
  
      $('.item-checkbox').change(updateSubtotal);
  
      $('#checkoutButton').click(function() {
          var selectedItems = [];
          $('.item-checkbox:checked').each(function() {
              selectedItems.push($(this).attr('data-cart-item-id'));
          });
  
          if (selectedItems.length > 0) {
              updateCartStatus(selectedItems, 'selected');
          } else {
              alert('Please select at least one item.');
          }
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

    function incrementQuantity(cartItemId) {
        var quantityInput = $(`.quantity-input[data-cart-item-id='${cartItemId}']`);
        var currentQuantity = parseInt(quantityInput.val());
        quantityInput.val(currentQuantity + 1);
        updateQuantity(cartItemId, currentQuantity + 1);
    }

    function decrementQuantity(cartItemId) {
        var quantityInput = $(`.quantity-input[data-cart-item-id='${cartItemId}']`);
        var currentQuantity = parseInt(quantityInput.val());
        if (currentQuantity > 1) {
            quantityInput.val(currentQuantity - 1);
            updateQuantity(cartItemId, currentQuantity - 1);
        }
    }

    function updateQuantity(cartItemId, newQuantity) {
        $.ajax({
            url: `/api/cart/update/${cartItemId}`,
            type: 'POST',
            data: { quantity: newQuantity },
            success: function(response) {
                console.log('Quantity updated successfully:', response);
            },
            error: function(err) {
                console.error('Error updating quantity:', err);
            }
        });
    }

    function updateCartStatus(cartItemIds, status) {
        $.ajax({
            url: '/api/cart/update-status',
            type: 'POST',
            data: {
                ids: cartItemIds,
                status: status
            },
            success: function(response) {
                window.location.href = '/checkout'; // Redirect to checkout page
            },
            error: function(err) {
                console.error('Error updating cart status:', err);
            }
        });
    }

    fetchCartItems();
});
