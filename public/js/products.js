$(document).ready(function() {
  let page = 1;

  function fetchProducts(page) {
      $.ajax({
          url: `/api/home?page=${page}`, // Adjust the URL according to your Laravel route
          type: 'GET',
          beforeSend: function() {
              $('#loadingSpinner').removeClass('hidden');
              $('#loadingText').text('Loading...');
          },
          success: function(response) {
              $('#loadingSpinner').addClass('hidden');
              $('#loadingText').text('');

              response.data.forEach(product => {
                  $('#productList').append(`
                      <a href="#" class="group block overflow-hidden" onclick="openModal('${product.product_name}', '£${product.price.toFixed(2)} GBP', '${product.img_path}')">
                          <img
                              src="${product.img_path}"
                              alt="${product.product_name}"
                              class="h-[350px] w-full object-cover transition duration-500 group-hover:scale-105 sm:h-[450px]"
                          />
                          <div class="relative bg-white pt-3">
                              <h3 class="text-xs text-gray-700 group-hover:underline group-hover:underline-offset-4">
                                  ${product.product_name}
                              </h3>
                              <p class="mt-2">
                                  <span class="sr-only">Regular Price</span>
                                  <span class="tracking-wider text-gray-900">£${product.price.toFixed(2)} GBP</span>
                              </p>
                          </div>
                      </a>
                  `);
              });

              if (response.next_page_url) {
                  $(window).on('scroll', onScroll);
              } else {
                  $(window).off('scroll', onScroll);
                  $('#productList').append('<p class="text-gray-500 text-center mt-4">End of Product Results</p>');
              }
          },
          error: function(err) {
              console.error('Error fetching products:', err);
              $('#loadingSpinner').addClass('hidden');
              $('#loadingText').text('');
          }
      });
  }

  function onScroll() {
      if ($(window).scrollTop() + $(window).height() >= $(document).height() - 200) {
          $(window).off('scroll', onScroll);
          fetchProducts(++page);
      }
  }

  fetchProducts(page);
  $(window).on('scroll', onScroll);
});

function openModal(productName, productPrice, productImage) {
  document.getElementById('productName').textContent = productName;
  document.getElementById('productPrice').textContent = productPrice;
  document.getElementById('productImage').src = productImage;
  document.getElementById('productModal').classList.remove('hidden');
}

function closeModal() {
  document.getElementById('productModal').classList.add('hidden');
}

function decreaseQuantity() {
  let quantity = document.getElementById('Quantity').value;
  if (quantity > 1) {
      document.getElementById('Quantity').value = --quantity;
  }
}

function increaseQuantity() {
  let quantity = document.getElementById('Quantity').value;
  document.getElementById('Quantity').value = ++quantity;
}
