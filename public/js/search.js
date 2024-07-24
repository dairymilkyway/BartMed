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
                suggestionBox.innerHTML = hits.map(hit => {
                    // Get the first image path
                    const firstImagePath = hit.img_path.split(',')[0];

                    return `
                        <li data-id="${hit.id}" class="p-2 cursor-pointer hover:bg-gray-100 flex items-center">
                            <img src="${firstImagePath}" alt="${hit.product_name}" class="w-12 h-12 mr-2 rounded object-cover">
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
                    `;
                }).join('');
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
            const productId = target.getAttribute('data-id');
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
});
