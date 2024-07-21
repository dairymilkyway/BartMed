$(document).ready(function() {
    const productListApi = $('#productList'); // For AJAX API results
    const resultsCount = $('#resultsCount');
    let page = 1;
    let isLoading = false;

    // Fetch products from /home API
    function fetchApiProducts(page, reset = false) {
        if (isLoading) return;
        isLoading = true;

        $.ajax({
            url: `/api/home?page=${page}`,
            type: 'GET',
            beforeSend: function() {
                $('#loadingSpinner').removeClass('hidden');
            },
            success: function(response) {
                $('#loadingSpinner').addClass('hidden');

                if (reset || page === 1) {
                    productListApi.empty();
                }

                if (response.data && response.data.length) {
                    response.data.forEach(product => {
                        const apiProductHtml = `
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
                        `;
                        productListApi.append(apiProductHtml);
                    });

                    const displayedCount = productListApi.find('a').length;
                    const totalResults = response.total;
                    resultsCount.text(`Showing ${displayedCount} of ${totalResults} results`);

                    if (response.next_page_url) {
                        $(window).on('scroll', onScroll);
                    } else {
                        $(window).off('scroll', onScroll);
                        productListApi.append('<p class="text-gray-500 text-center mt-4">End of Product Results</p>');
                    }
                } else {
                    productListApi.append('<p class="text-gray-500 text-center mt-4">No products found.</p>');
                }

                isLoading = false;
            },
            error: function(err) {
                console.error('Error fetching products from backend:', err);
                $('#loadingSpinner').addClass('hidden');
                isLoading = false;
            }
        });
    }

    // Handle scrolling to fetch more products and reset when at top
    function onScroll() {
        const scrollTop = $(window).scrollTop();
        const windowHeight = $(window).height();
        const documentHeight = $(document).height();

        if (scrollTop + windowHeight >= documentHeight - 200 && !isLoading) { // Scrolling down near bottom
            page++;
            fetchApiProducts(page);
        } else if (scrollTop === 0 && !isLoading) { // Scrolling to top of the page
            page = 1;
            fetchApiProducts(page, true);
        }
    }

    $(window).on('scroll', onScroll);

    // Initialize by fetching the first page of products
    fetchApiProducts(page);

    // Clear products list and re-fetch products on clear button click
    const clearProductsButton = document.getElementById('clearProducts');
    clearProductsButton.addEventListener('click', () => {
        page = 1;
        productListApi.empty();
        fetchApiProducts(page);
    });

    // Update products on Algolia search clear
    $(document).on('algoliaSearchCleared', function() {
        page = 1;
        fetchApiProducts(page);
    });
});


function openModal(productId, productName, productPrice, productImage, productStocks, productCategory) {
    $('#productName').text(productName);
    $('#productPrice').html(productPrice); // Ensure the formatted price is set
    $('#productImage').attr('src', productImage);
    $('#productStocks').text(`Stocks: ${productStocks}`);
    $('#productCategory').text(`Category: ${productCategory}`);
    $('#Quantity').val(1); // Reset quantity to 1 when opening the modal
    $('#productId').text(productId);
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

function escapeHTML(str) {
    return str.replace(/&/g, "&amp;")
              .replace(/</g, "&lt;")
              .replace(/>/g, "&gt;")
              .replace(/"/g, "&quot;")
              .replace(/'/g, "&#39;");
}
// simulation lang to pang add ng items
// document.addEventListener('DOMContentLoaded', function() {

//     setInterval(addToCart, 2000);
// });
