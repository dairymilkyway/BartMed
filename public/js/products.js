$(document).ready(function() {
    // Initialize Algolia client
    const algoliasearch = window.algoliasearch;
    if (!algoliasearch) {
        console.error('Algolia JavaScript client not loaded. Check your script tag.');
        return;
    }

    const client = algoliasearch('CE79ZIQBSB', '1f1fcbea58ffa9890a3df44bd9fc0a90');
    const index = client.initIndex('products');

    const searchInput = document.getElementById('searchInput');
    const suggestionBox = document.getElementById('suggestionBox');
    const productListAlgolia = $('#productListAlgolia'); // For Algolia search results
    const productListApi = $('#productList'); // For AJAX API results
    const resultsCount = $('#resultsCount');
    let page = 1;
    let lastScrollTop = 0;
    let isLoading = false;
    let searchQuery = '';
    let isSearching = false;
    let isFetching = false;

    // Fetch products from Algolia or backend based on search query
    function fetchProducts(page, query = '') {
        if (isLoading) return;
        isLoading = true;

        if (query) {
            // Fetch products from Algolia
            index.search(query, { page }).then(({ hits, nbHits }) => {
                console.log('Algolia search hits:', hits); // Debug log

                // Clear the product list if it’s the first page
                if (page === 1) {
                    productListApi.empty();
                }

                if (hits.length) {
                    hits.forEach(hit => {
                        // Use `productListAlgolia` for Algolia results
                        const algoliaProductHtml = `
                            <a href="#" class="group block overflow-hidden" onclick="openModal(${hit.objectID}, '${hit.product_name}', '₱${hit.price.toFixed(2)}', '${hit.img_path}', ${hit.stocks}, '${hit.category}')">
                                <img
                                    src="${hit.img_path}"
                                    alt="${hit.product_name}"
                                    class="h-[250px] w-full object-cover transition duration-500 group-hover:scale-105 sm:h-[300px]"
                                />
                                <div class="relative bg-white pt-3 p-4">
                                    <h1 class="text-xl font-bold text-gray-700 group-hover:underline group-hover:underline-offset-4">
                                        ${hit.product_name}
                                    </h1>
                                    <p class="mt-2">
                                        <span class="sr-only">Regular Price</span>
                                        <span class="tracking-wider text-gray-900">₱${hit.price.toFixed(2)}</span>
                                    </p>
                                    <p class="mt-1 text-gray-600">
                                        Stocks: ${hit.stocks}
                                    </p>
                                    <p class="mt-1 text-gray-600">
                                        Category: ${hit.category}
                                    </p>
                                </div>
                            </a>
                        `;
                        productListAlgolia.append(algoliaProductHtml);
                    });

                    resultsCount.text(`Showing ${hits.length} results`);

                    if (nbHits > hits.length) {
                        $(window).off('scroll', onScroll);
                    } else {
                        $(window).off('scroll', onScroll);
                        productListAlgolia.append('<p class="text-gray-500 text-center mt-4">End of Product Results</p>');
                    }
                } else {
                    productListAlgolia.append('<p class="text-gray-500 text-center mt-4">No products found.</p>');
                }

                isLoading = false;
            }).catch(error => {
                console.error('Error fetching products from Algolia:', error);
                productListAlgolia.append(`<p class="text-gray-500 text-center mt-4">Error fetching products from Algolia: ${error.message}</p>`);
                isLoading = false;
            });
        } else {
            // Fetch products from /home API when no search query
            $.ajax({
                url: `/api/home?page=${page}`,
                type: 'GET',
                beforeSend: function() {
                    $('#loadingSpinner').removeClass('hidden');
                },
                success: function(response) {
                    $('#loadingSpinner').addClass('hidden');

                    if (page === 1) {
                        productListApi.empty();
                    }

                    if (response.data && response.data.length) {
                        response.data.forEach(product => {
                            // Use `productListApi` for AJAX API results
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
    }

    // Handle scrolling to fetch more products
    function onScroll() {
        const scrollTop = $(window).scrollTop();
        const windowHeight = $(window).height();
        const documentHeight = $(document).height();

        if (!isSearching && scrollTop > lastScrollTop) {
            if (scrollTop + windowHeight >= documentHeight - 200) {
                if (!isFetching) {
                    isFetching = true;
                    fetchProducts(++page, searchQuery);
                }
            }
        } else if (scrollTop < lastScrollTop) {
            // Scrolling up
            if (scrollTop + windowHeight < documentHeight - 200) {
                // Reset the results to the first 10 items
                if (page > 1) {
                    page = 1;
                    fetchProducts(page, searchQuery);
                }
            }
        }
        lastScrollTop = scrollTop;
        isFetching = false;
    }

    $(window).on('scroll', onScroll);

    // Initialize product list
    fetchProducts(page);

    // Handle search input changes
    searchInput.addEventListener('input', async () => {
        searchQuery = searchInput.value;
        isSearching = searchQuery.length > 0;

        if (isSearching) {
            try {
                const { hits, nbHits } = await index.search(searchQuery);

                // Update suggestions list
                suggestionBox.innerHTML = hits.map(hit => `
                    <li data-id="${hit.objectID}" class="p-2 cursor-pointer hover:bg-gray-100 flex items-center">
                        <img src="${hit.img_path}" alt="${hit.product_name}" class="w-12 h-12 mr-2 rounded object-cover">
                        <div>
                            <div class="font-semibold">${hit.product_name}</div>
                        </div>
                    </li>
                `).join('');
                suggestionBox.classList.remove('hidden');

    
                
            } catch (error) {
                console.error('Error fetching search results:', error);
                suggestionBox.innerHTML = '<li class="p-2 text-red-500">Error fetching results</li>';
                suggestionBox.classList.remove('hidden');
            }
        } else {
            suggestionBox.innerHTML = '';
            suggestionBox.classList.add('hidden');
            fetchProducts(page); // Fetch non-search products if needed
        }
    });

    // Handle suggestion box item selection
    suggestionBox.addEventListener('click', (event) => {
        const target = event.target.closest('li[data-id]');
        if (target) {
            searchQuery = target.querySelector('.font-semibold').textContent;
            searchInput.value = searchQuery;
            suggestionBox.innerHTML = '';
            suggestionBox.classList.add('hidden');
            page = 1;
            isSearching = true;
            productListAlgolia.empty(); // Clear Algolia results list
            fetchProducts(page, searchQuery); // Fetch products based on selected suggestion
        }
    });

    // Hide suggestion box when clicking outside
    document.addEventListener('click', (event) => {
        if (!searchInput.contains(event.target) && !suggestionBox.contains(event.target)) {
            suggestionBox.innerHTML = '';
            suggestionBox.classList.add('hidden');
        }
    });

    // Handle clear search button click
    const clearSearchButton = document.getElementById('clearSearch');
    clearSearchButton.addEventListener('click', () => {
        searchInput.value = '';
        searchQuery = '';
        suggestionBox.innerHTML = '';
        suggestionBox.classList.add('hidden');
        page = 1;
        isSearching = false; // Reset search state
        productListAlgolia.empty(); // Clear Algolia results list
        fetchProducts(page); // Fetch non-search products
    });
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
