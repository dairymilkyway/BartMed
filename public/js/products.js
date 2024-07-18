$(document).ready(function() {
    let page = 1;
    let searchQuery = '';

    function fetchProducts(page, searchQuery = '') {
        $.ajax({
            url: `/api/home?page=${page}&search=${searchQuery}`,
            type: 'GET',
            beforeSend: function() {
                $('#loadingSpinner').removeClass('hidden');
                $('#loadingText').text('Loading...');
            },
            success: function(response) {
                $('#loadingSpinner').addClass('hidden');
                $('#loadingText').text('');

                if (page === 1) {
                    $('#productList').empty();
                }

                const productList = $('#productList');
                response.data.forEach(product => {
                    productList.append(`
                        <a href="#" class="group block overflow-hidden" onclick="openModal(${product.id}, '${product.product_name}', '£${product.price.toFixed(2)} GBP', '${product.img_path}')">
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

                // Update number of results message
                const displayedCount = $('#productList a').length;
                const totalResults = response.total;
                $('#resultsCount').text(`Showing ${displayedCount} of ${totalResults} results`);

                if (response.next_page_url) {
                    $(window).on('scroll', onScroll);
                } else {
                    $(window).off('scroll', onScroll);
                    productList.append('<p class="text-gray-500 text-center mt-4">End of Product Results</p>');
                }
            },
            error: function(err) {
                console.error('Error fetching products:', err);
                $('#loadingSpinner').addClass('hidden');
                $('#loadingText').text('');
            }
        });
    }


    const searchInput = $('#searchInput');
    const suggestionBox = $('#suggestionBox');

    function fetchSuggestions(searchQuery) {
        $.ajax({
            url: `/api/home/suggestions?search=${searchQuery}`,
            type: 'GET',
            success: function(response) {
                suggestionBox.empty();

                response.data.forEach(item => {
                    suggestionBox.append(`
                        <div class="px-4 py-2 cursor-pointer hover:bg-gray-100 suggestion-item">
                            ${item.product_name}
                        </div>
                    `);
                });

                suggestionBox.removeClass('hidden');
            },
            error: function(err) {
                console.error('Error fetching suggestions:', err);
            }
        });
    }

    // Event delegation for dynamically added elements (suggestion items)
    suggestionBox.on('click', '.suggestion-item', function() {
        let selectedValue = $(this).text().trim();
        $('#searchInput').val(selectedValue); // Set search input value to the selected suggestion
        suggestionBox.addClass('hidden'); // Hide suggestion box
        searchQuery = selectedValue; // Update searchQuery to the selected suggestion
        page = 1; // Reset page number
        fetchProducts(page, searchQuery); // Fetch products based on selected suggestion
    });

    function onScroll() {
        if ($(window).scrollTop() + $(window).height() >= $(document).height() - 200) {
            $(window).off('scroll', onScroll); // Turn off scroll event to prevent multiple calls
            fetchProducts(++page, searchQuery); // Fetch next page of products
        }
    }

    searchInput.on('input', function() {
        searchQuery = $(this).val().trim();
        page = 1; // Reset page number
        fetchProducts(page, searchQuery); // Fetch products based on search query

        if (searchQuery.length > 0) {
            fetchSuggestions(searchQuery); // Fetch suggestions based on search query
        } else {
            suggestionBox.addClass('hidden'); // Hide suggestion box if no input
        }
    });

    $('#clearSearch').on('click', function() {
        $('#searchInput').val('');
        searchQuery = '';
        $('#productList').empty(); // Clear current products
        $('#resultsCount').empty(); // Clear results count message
        suggestionBox.addClass('hidden'); // Clear and hide suggestion box
        fetchProducts(page, searchQuery); // Fetch products with empty search query
    });

    // Initial fetch of products
    fetchProducts(page);

    // Event listener for infinite scroll
    $(window).on('scroll', onScroll);
});

function openModal(productId, productName, productPrice, productImage) {
    $('#productName').text(productName);
    $('#productPrice').text(productPrice);
    $('#productImage').attr('src', productImage);
    $('#productId').text(productId);
    $('#productModal').data('product-id', productId);
    $('#productModal').removeClass('hidden');
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


// cart-counter functionality
let cartCount = 0;


function updateCartCounter() {
    const counter = document.getElementById('cart-counter');
    counter.textContent = cartCount;
}


function addToCart() {
    const productId = $('#productId').text().trim();
    const quantity = $('#Quantity').val();

    // Validate quantity (ensure it's a number and greater than 0)
    if (!quantity || isNaN(quantity) || parseInt(quantity) <= 0) {
        alert('Please enter a valid quantity.');
        return;
    }

    $.ajax({
        url: `/api/add/${productId}/${quantity}`,
        type: 'POST',
        beforeSend: function() {
            $('#globalLoadingSpinner').removeClass('hidden');
        },
        success: function(response) {
            $('#globalLoadingSpinner').addClass('hidden');

            alert('Item added to cart successfully!');
        },
        error: function(err) {
            $('#globalLoadingSpinner').addClass('hidden');
            console.error('Error adding to cart:', err);
            alert('Failed to add item to cart. Please try again later.');
        }
    });
    closeModal(); // Close modal after successful addition
    cartCount++; // Increment cart count locally
    updateCartCounter(); // Update UI for cart count
}


// simulation lang to pang add ng items
// document.addEventListener('DOMContentLoaded', function() {

//     setInterval(addToCart, 2000);
// });
