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
    let searchQuery = '';
    let isSearching = false;

    // Handle search input changes
    searchInput.addEventListener('input', async () => {
        searchQuery = searchInput.value;
        isSearching = searchQuery.length > 0;

        if (isSearching) {
            try {
                const { hits } = await index.search(searchQuery);

                // Update suggestions list
                suggestionBox.innerHTML = hits.map(hit => `
                    <li data-id="${hit.id}" class="p-2 cursor-pointer hover:bg-gray-100 flex items-center">
                        <img src="${hit.img_path}" alt="${hit.product_name}" class="w-12 h-12 mr-2 rounded object-cover">
                        <div>
                            <div class="font-semibold">${hit.product_name}</div>
                            <div class="hidden product-details" 
                                data-product-id="${hit.id}" 
                                data-product-name="${hit.product_name}" 
                                data-product-price="${hit.price.toFixed(2)}"
                                data-product-image="${hit.img_path}"
                                data-product-stocks="${hit.stocks}"
                                data-product-category="${hit.category}">
                            </div>
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
        }
    });

    // Handle suggestion box item selection
    suggestionBox.addEventListener('click', (event) => {
        const target = event.target.closest('li[data-id]');
        if (target) {
            const productId = target.getAttribute('data-id'); // Use data-id attribute
            const productName = target.querySelector('.product-details').getAttribute('data-product-name');
            const productPrice = `₱${target.querySelector('.product-details').getAttribute('data-product-price')}`;
            const productImage = target.querySelector('.product-details').getAttribute('data-product-image');
            const productStocks = target.querySelector('.product-details').getAttribute('data-product-stocks');
            const productCategory = target.querySelector('.product-details').getAttribute('data-product-category');

            openModal(productId, productName, productPrice, productImage, productStocks, productCategory);

            searchQuery = target.querySelector('.font-semibold').textContent;
            searchInput.value = searchQuery;
            suggestionBox.innerHTML = '';
            suggestionBox.classList.add('hidden');
            isSearching = true;
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
        isSearching = false; // Reset search state
    });

    // Modal functions
    window.openModal = function(productId, productName, productPrice, productImage, productStocks, productCategory) {
        $('#productName').text(productName);
        $('#productPrice').html(productPrice); // Ensure the formatted price is set
        $('#productImage').attr('src', productImage);
        $('#productStocks').text(`Stocks: ${productStocks}`);
        $('#productCategory').text(`Category: ${productCategory}`);
        $('#Quantity').val(1); // Reset quantity to 1 when opening the modal
        $('#productId').text(productId);
        $('#productModal').removeClass('hidden');
    };

    window.closeModal = function() {
        document.getElementById('productModal').classList.add('hidden');
    };

    window.decreaseQuantity = function() {
        let quantity = document.getElementById('Quantity').value;
        if (quantity > 1) {
            document.getElementById('Quantity').value = --quantity;
        }
    };

    window.increaseQuantity = function() {
        let quantity = document.getElementById('Quantity').value;
        document.getElementById('Quantity').value = ++quantity;
    };

    // Cart-counter functionality
    let cartCount = 0;

    window.updateCartCounter = function() {
        const counter = document.getElementById('cart-counter');
        counter.textContent = cartCount;
    };

    window.addToCart = function() {
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
    };
});
