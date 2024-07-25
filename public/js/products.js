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
                        // Get the first image path
                        const firstImagePath = product.img_path.split(',')[0];

                        const apiProductHtml = `
                            <a href="#" class="group block overflow-hidden" onclick="openModal(${product.id}, '${product.product_name}', '₱${product.price.toFixed(2)}', '${product.img_path}', ${product.stocks}, '${product.category}')">
                                <img
                                    src="${firstImagePath}"
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



let isReviewsModalOpen = false;
let currentImageIndex = 0;
let imagePaths = [];

// Function to open modal and initialize image paths
function openModal(productId, productName, productPrice, productImage, productStocks, productCategory) {
    closeReviewsModal();
    $('#productName').text(productName);
    $('#productPrice').html(productPrice); // Ensure the formatted price is set
    $('#productStocks').text(`Stocks: ${productStocks}`);
    $('#productCategory').text(`Category: ${productCategory}`);
    $('#Quantity').val(1); // Reset quantity to 1 when opening the modal
    $('#productId').text(productId);

    // Prepare image paths
    imagePaths = productImage.split(',');
    currentImageIndex = 0;

    // Show the first image
    $('#productImage').attr('src', imagePaths[currentImageIndex]);

    // Toggle buttons visibility
    toggleNavigationButtons();

    $('#productModal').removeClass('hidden');
}

// Function to show the previous image
function showPreviousImage() {
    if (imagePaths.length > 1) {
        currentImageIndex = (currentImageIndex - 1 + imagePaths.length) % imagePaths.length;
        $('#productImage').attr('src', imagePaths[currentImageIndex]);
        toggleNavigationButtons();
    }
}

// Function to show the next image
function showNextImage() {
    if (imagePaths.length > 1) {
        currentImageIndex = (currentImageIndex + 1) % imagePaths.length;
        $('#productImage').attr('src', imagePaths[currentImageIndex]);
        toggleNavigationButtons();
    }
}

// Function to toggle navigation buttons based on image count
function toggleNavigationButtons() {
    $('#prevImage').toggle(imagePaths.length > 1);
    $('#nextImage').toggle(imagePaths.length > 1);
}



function closeReviewsModal() {
    $('#reviewsPlaceholder').empty(); // Clear the reviews content
    $('#reviewsModal').addClass('hidden'); // Hide the reviews modal
    isReviewsModalOpen = false;
    $('#viewReviewsButton').text('View Reviews');
}

function fetchProductReviews() {
    const productId = $('#productId').text().trim();

    if (!productId) {
        alert('Product ID is not defined.');
        return;
    }

    if (isReviewsModalOpen) {
        closeReviewsModal();
        return;
    }

    $('#loadingSpinner').removeClass('hidden'); // Show loading spinner

    $.ajax({
        url: `/api/home-reviews/${productId}`,
        method: 'GET',
        success: function(response) {
            $('#loadingSpinner').addClass('hidden'); // Hide loading spinner
            clearReviews(); // Clear any existing reviews before displaying new ones
            if (response && response.reviews && response.reviews.length) {
                let reviewsHtml = '';
                response.reviews.forEach(function(review) {
                    reviewsHtml += `
                    <div class="mb-4">
                        <p><strong>Rating:</strong> ${'⭐'.repeat(review.rating)}</p>
                        <p><strong>Review:</strong> ${review.review}</p>
                        <hr>
                    </div>
                    `;
                });
                $('#reviewsPlaceholder').html(reviewsHtml);
            } else {
                $('#reviewsPlaceholder').html('<p>No reviews found for this product.</p>');
            }
            $('#reviewsModal').removeClass('hidden');
            isReviewsModalOpen = true; // Update the state
            $('#viewReviewsButton').text('Close Reviews'); // Update button text
        },
        error: function(xhr) {
            $('#loadingSpinner').addClass('hidden'); // Hide loading spinner
            console.error('Failed to fetch reviews:', xhr.responseJSON.error);
            alert('Failed to fetch the reviews.');
        }
    });
}

function clearReviews() {
    $('#reviewsPlaceholder').empty(); // Clear reviews content
}

function closeModal() {
  document.getElementById('productModal').classList.add('hidden');
  clearReviews();
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


function updateCartCount() {
    $.ajax({
        url: '/api/cart/cartCount',
        method: 'GET',
        success: function(response) {
            $('#cart-counter').text(response.data);
        },
        error: function(error) {
            console.error('Error fetching cart count:', error);
        }
    });
}
updateCartCount();

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
            
            // Update cart count after successfully adding to cart
            updateCartCount();

            alert('Item added to cart successfully!');
        },
        error: function(err) {
            $('#globalLoadingSpinner').addClass('hidden');
            console.error('Error adding to cart:', err);
            alert('Failed to add item to cart. Please try again later.');
        }
    });
    closeModal(); // Close modal after successful addition
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
