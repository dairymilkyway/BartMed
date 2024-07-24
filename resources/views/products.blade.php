<div class="mx-auto max-w-screen-xl px-4 py-8 sm:px-6 sm:py-12 lg:px-8">
    <header>
        <h2 class="text-xl font-bold text-gray-900 sm:text-3xl">Browse Products</h2>
        <p class="mt-4 max-w-md text-gray-500">
            <strong>Our prescription medications include the latest treatments for various conditions, from antibiotics and pain relievers to specialized chronic condition meds. Trust our products for their high quality and effectiveness.</strong>
        </p>
    </header>
    <p id="resultsCount" class="text-gray-600 text-center mt-4"></p>
    <ul class="mt-4 grid gap-4 sm:grid-cols-2 lg:grid-cols-4" id="productList">
        <!-- Products will be dynamically added here -->
    </ul>

    <!-- Loading Spinner -->
    <div id="loadingSpinner" class="fixed top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 hidden">
        <svg class="animate-spin h-10 w-10 text-gray-800" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A8.004 8.004 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
        </svg>
    </div>
</div>

<!-- Modal Structure -->
<!-- Add this to your existing modal structure -->
<div id="productModal" class="fixed inset-0 z-50 hidden overflow-y-auto">
    <div class="fixed inset-0 w-full h-full bg-black opacity-50" onclick="closeModal()"></div>
    <div class="flex items-center min-h-screen px-4 py-8">
        <div class="relative w-full max-w-lg p-8 mx-auto bg-white rounded-md shadow-lg">
            <div class="flex justify-end">
                <button class="text-gray-600 hover:text-gray-700" onclick="closeModal()">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
            <div id="modalContent" class="mt-4 flex flex-col items-center relative">
                <!-- Image Navigation Buttons -->
                <button id="prevImage" class="absolute left-4 top-1/2 transform -translate-y-1/2 text-gray-600 hover:text-gray-700 z-10" onclick="showPreviousImage()">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                    </svg>
                </button>
                <button id="nextImage" class="absolute right-4 top-1/2 transform -translate-y-1/2 text-gray-600 hover:text-gray-700 z-10" onclick="showNextImage()">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                </button>
                <img id="productImage" class="w-full h-64 object-cover" src="" alt="Product Image">
                <h3 class="text-lg font-medium text-gray-900 mt-4" id="productName"></h3>
                <p class="mt-2 text-gray-600" id="productPrice"></p>
                <p class="mt-2 text-gray-600" id="productStocks"></p>
                <p class="mt-2 text-gray-600" id="productCategory"></p>
                <p class="mt-2 text-gray-600" id="productIdText">Product ID: <span id="productId"></span></p>
                <div class="mt-4">
                    <label for="quantity" class="block text-sm font-medium text-gray-700">Quantity</label>
                    <div class="flex items-center rounded border border-gray-200">
                        <button type="button" class="size-10 leading-10 text-gray-600 transition hover:opacity-75" onclick="decreaseQuantity()">&minus;</button>
                        <input type="number" id="Quantity" value="1" class="h-10 w-16 border-transparent text-center sm:text-sm" />
                        <button type="button" class="size-10 leading-10 text-gray-600 transition hover:opacity-75" onclick="increaseQuantity()">&plus;</button>
                    </div>
                </div>
                <button class="mt-4 block w-full rounded bg-yellow-400 p-4 text-sm font-medium transition hover:scale-105" onclick="addToCart()">Add to Cart</button>
            </div>
            <div class="mt-6">
                <h3 class="text-lg font-medium text-gray-900">Product Reviews</h3>
                <div id="reviewsPlaceholder" class="mt-2">
                    <!-- Reviews will be dynamically inserted here -->
                </div>
                <button id="viewReviewsButton" class="mt-4 block w-full rounded bg-blue-400 p-4 text-sm font-medium transition hover:scale-105" onclick="fetchProductReviews()">
                    View Reviews
                </button>
            </div>

            <div id="loadingSpinner" class="fixed top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 hidden">
                <svg class="animate-spin h-10 w-10 text-gray-800" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A8.004 8.004 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
            </div>
        </div>
    </div>
</div>

<script src="{{ asset('js/products.js') }}"></script>
<script src="{{ asset('js/cart.js') }}"></script>
