<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://unpkg.com/infinite-scroll@4/dist/infinite-scroll.pkgd.min.js"></script>

<div class="mx-auto max-w-screen-xl px-4 py-8 sm:px-6 sm:py-12 lg:px-8">
    <header>
        <h2 class="text-xl font-bold text-gray-900 sm:text-3xl">Browse Products</h2>
        <p class="mt-4 max-w-md text-gray-500">
            Lorem ipsum, dolor sit amet consectetur adipisicing elit. Itaque praesentium cumque iure dicta incidunt est
            ipsam, officia dolor fugit natus?
        </p>
    </header>

    <ul class="mt-4 grid gap-4 sm:grid-cols-2 lg:grid-cols-4" id="productList">
        <!-- Products will be dynamically added here -->
    </ul>

    <!-- Loading Spinner -->
    <div id="loadingSpinner" class="fixed top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 hidden">
        <svg class="animate-spin h-10 w-10 text-gray-800" xmlns="http://www.w3.org/2000/svg" fill="none"
            viewBox="0 0 24 24">
            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
            <path class="opacity-75" fill="currentColor"
                d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A8.004 8.004 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
            </path>
        </svg>
    </div>
</div>

<!-- Modal Structure -->
<div id="productModal" class="fixed inset-0 z-50 hidden overflow-y-auto">
    <div class="fixed inset-0 w-full h-full bg-black opacity-50" onclick="closeModal()"></div>
    <div class="flex items-center min-h-screen px-4 py-8">
        <div class="relative w-full max-w-lg p-8 mx-auto bg-white rounded-md shadow-lg">
            <div class="flex justify-end">
                <button class="text-gray-600 hover:text-gray-700" onclick="closeModal()">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
            <div id="modalContent" class="mt-4">
                <img id="productImage" class="w-full h-64 object-cover" src="" alt="Product Image">
                <h3 class="text-lg font-medium text-gray-900 mt-4" id="productName"></h3>
                <p class="mt-2 text-gray-600" id="productPrice"></p>
                <div class="mt-4">
                    <label for="quantity" class="block text-sm font-medium text-gray-700">Quantity</label>
                    <div class="flex items-center rounded border border-gray-200">
                        <button type="button"
                            class="size-10 leading-10 text-gray-600 transition hover:opacity-75"
                            onclick="decreaseQuantity()">
                            &minus;
                        </button>
                        <input type="number" id="Quantity" value="1"
                            class="h-10 w-16 border-transparent text-center sm:text-sm" />
                        <button type="button"
                            class="size-10 leading-10 text-gray-600 transition hover:opacity-75"
                            onclick="increaseQuantity()">
                            &plus;
                        </button>
                    </div>
                </div>
                <button class="mt-4 block w-full rounded bg-yellow-400 p-4 text-sm font-medium transition hover:scale-105">
                    Add to Cart
                </button>
            </div>
        </div>
    </div>
</div>

<div id="loadingSpinner" class="fixed top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 hidden">
    <svg class="animate-spin h-10 w-10 text-gray-800" xmlns="http://www.w3.org/2000/svg" fill="none"
        viewBox="0 0 24 24">
        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
        <path class="opacity-75" fill="currentColor"
            d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A8.004 8.004 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
        </path>
    </svg>
</div>
<!-- Link to your external JavaScript file -->
<script src="{{ asset('js/products.js') }}"></script>