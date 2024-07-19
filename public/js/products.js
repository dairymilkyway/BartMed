$(document).ready(function() {
    let page = 1;
    let lastScrollTop = 0;
    let isLoading = false;
    let searchQuery = '';

    function fetchProducts(page, searchQuery = '') {
        if (isLoading) return; // Prevent multiple requests at the same time

        isLoading = true;

        $.ajax({
            url: `/api/home?page=${page}&search=${encodeURIComponent(searchQuery)}`,
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
                        <a href="#" class="group block overflow-hidden" onclick="openModal(${product.id}, '${product.product_name}', '₱${product.price.toFixed(2)}', '${product.img_path}', ${product.stocks}, '${product.category}')">
                            <img
                                src="${product.img_path}"
                                alt="${product.product_name}"
                                class="h-[250px] w-full object-cover transition duration-500 group-hover:scale-105 sm:h-[300px]"
                            />
                            <div class="relative bg-white pt-3 p-4">
                                <h1 class="text-xl font-bold text-gray-700 group-hover:underline group-hover:underline-offset-4">
                                    ${product.product_name}
                                </h1>
                                <p class="mt-2">
                                    <span class="sr-only">Regular Price</span>
                                    <span class="tracking-wider text-gray-900">₱${product.price.toFixed(2)}</span>
                                </p>
                                <p class="mt-1 text-gray-600">
                                    Stocks: ${product.stocks}
                                </p>
                                <p class="mt-1 text-gray-600">
                                    Category: ${product.category}
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
                    $('#productList').append('<p class="text-gray-500 text-center mt-4">End of Product Results</p>');
                }

                isLoading = false;
            },
            error: function(err) {
                console.error('Error fetching products:', err);
                $('#loadingSpinner').addClass('hidden');
                $('#loadingText').text('');
                isLoading = false;
            }
        });
    }

    function fetchSuggestions(query) {
        if (query.length === 0) {
            $('#suggestionBox').addClass('hidden');
            return;
        }

        $.ajax({
            url: `/api/search`,
            type: 'GET',
            data: { query: query },
            success: function(response) {
                console.log('Suggestions response:', response); // Debugging: Check response format
                $('#suggestionBox').empty();
                
                if (Array.isArray(response) && response.length > 0) {
                    response.forEach(item => {
                        $('#suggestionBox').append(`
                            <div class="suggestion-item px-4 py-2 cursor-pointer hover:bg-gray-100 rounded-lg transition-colors">
                                ${item.product_name}
                            </div>
                        `);
                    });
                    $('#suggestionBox').removeClass('hidden');
                } else {
                    $('#suggestionBox').addClass('hidden');
                }
            },
            error: function(err) {
                console.error('Error fetching suggestions:', err);
            }
        });
    }

    function onScroll() {
        const scrollTop = $(window).scrollTop();

        if (scrollTop > lastScrollTop) {
            // Scrolling down
            if ($(window).scrollTop() + $(window).height() >= $(document).height() - 200) {
                $(window).off('scroll', onScroll); // Turn off scroll event to prevent multiple calls
                fetchProducts(++page, searchQuery); // Fetch next page of products
            }
        } else {
            // Scrolling up
            if (scrollTop === 0) {
                // Reset page number and fetch the first page again
                page = 1;
                fetchProducts(page, searchQuery);
            }
        }
        lastScrollTop = scrollTop;
    }

    $('#suggestionBox').on('click', '.suggestion-item', function() {
        const selectedValue = $(this).text().trim();
        $('#searchInput').val(selectedValue);
        $('#suggestionBox').addClass('hidden');
        searchQuery = selectedValue;
        page = 1;
        fetchProducts(page, searchQuery);
    });

    $('#searchInput').on('input', function() {
        searchQuery = $(this).val().trim();
        page = 1;
        fetchProducts(page, searchQuery);

        if (searchQuery.length > 0) {
            fetchSuggestions(searchQuery);
        } else {
            $('#suggestionBox').addClass('hidden');
        }
    });

    $('#clearSearch').on('click', function() {
        $('#searchInput').val('');
        searchQuery = '';
        $('#productList').empty();
        $('#resultsCount').empty();
        $('#suggestionBox').addClass('hidden');
        fetchProducts(page, searchQuery);
    });

    $(document).mouseup(function(e) {
        if (!$('#suggestionBox').is(e.target) && $('#suggestionBox').has(e.target).length === 0 && !$('#searchInput').is(e.target)) {
            $('#suggestionBox').addClass('hidden');
        }
    });

    fetchProducts(page);

    $(window).on('scroll', onScroll);
});



function openModal(productId, productName, productPrice, productImage, productStocks, productCategory) {
    $('#productName').text(productName);
    $('#productPrice').html(productPrice); // Ensure the formatted price is set
    $('#productImage').attr('src', productImage);
    $('#productStocks').text(`Stocks: ${productStocks}`);
    $('#productCategory').text(`Category: ${productCategory}`);
    $('#Quantity').val(1); // Reset quantity to 1 when opening the modal
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
