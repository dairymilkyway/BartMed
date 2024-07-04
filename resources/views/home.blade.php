@extends('layouts.header')

@section('content')
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
@vite('resources/css/app.css')

<section>
  <div class="mx-auto max-w-screen-xl px-4 py-8 sm:px-6 sm:py-12 lg:px-8">
    <header>
      <h2 class="text-xl font-bold text-gray-900 sm:text-3xl">Browse Products</h2>
      <p class="mt-4 max-w-md text-gray-500">
        Lorem ipsum, dolor sit amet consectetur adipisicing elit. Itaque praesentium cumque iure
        dicta incidunt est ipsam, officia dolor fugit natus?
      </p>
    </header>

    <div class="mt-8 flex items-center justify-between">
      <div class="flex rounded border border-gray-100">
        <button
          class="inline-flex size-10 items-center justify-center border-e text-gray-600 transition hover:bg-gray-50 hover:text-gray-700"
        >
          <svg
            xmlns="http://www.w3.org/2000/svg"
            fill="none"
            viewBox="0 0 24 24"
            stroke-width="1.5"
            stroke="currentColor"
            class="h-5 w-5"
          >
            <path
              stroke-linecap="round"
              stroke-linejoin="round"
              d="M3.75 6A2.25 2.25 0 016 3.75h2.25A2.25 2.25 0 0110.5 6v2.25a2.25 2.25 0 01-2.25 2.25H6a2.25 2.25 0 01-2.25-2.25V6zM3.75 15.75A2.25 2.25 0 016 13.5h2.25a2.25 2.25 0 012.25 2.25V18a2.25 2.25 0 01-2.25 2.25H6A2.25 2.25 0 013.75 18v-2.25zM13.5 6a2.25 2.25 0 012.25-2.25H18A2.25 2.25 0 0120.25 6v2.25A2.25 2.25 0 0118 10.5h-2.25a2.25 2.25 0 01-2.25-2.25V6zM13.5 15.75a2.25 2.25 0 012.25-2.25H18a2.25 2.25 0 012.25 2.25V18A2.25 2.25 0 0118 20.25h-2.25A2.25 2.25 0 0113.5 18v-2.25z"
            />
          </svg>
        </button>

        <button
          class="inline-flex size-10 items-center justify-center text-gray-600 transition hover:bg-gray-50 hover:text-gray-700"
        >
          <svg
            xmlns="http://www.w3.org/2000/svg"
            fill="none"
            viewBox="0 0 24 24"
            stroke-width="1.5"
            stroke="currentColor"
            class="h-5 w-5"
          >
            <path
              stroke-linecap="round"
              stroke-linejoin="round"
              d="M3.75 5.25h16.5m-16.5 4.5h16.5m-16.5 4.5h16.5m-16.5 4.5h16.5"
            />
          </svg>
        </button>
      </div>

      <div>
        <label for="SortBy" class="sr-only">SortBy</label>

        <select id="SortBy" class="h-10 rounded border-gray-300 text-sm">
          <option>Sort By</option>
          <option value="Title, DESC">Title, DESC</option>
          <option value="Title, ASC">Title, ASC</option>
          <option value="Price, DESC">Price, DESC</option>
          <option value="Price, ASC">Price, ASC</option>
        </select>
      </div>
    </div>

    <ul class="mt-4 grid gap-4 sm:grid-cols-2 lg:grid-cols-4">
      <li>
        <a href="#" class="group block overflow-hidden" onclick="openModal('Basic Tee', '£24.00 GBP')">
          <img
            src="data:image/jpeg;base64,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"
            alt="Basic Tee"
            class="h-[350px] w-full object-cover transition duration-500 group-hover:scale-105 sm:h-[450px]"
          />

          <div class="relative bg-white pt-3">
            <h3 class="text-xs text-gray-700 group-hover:underline group-hover:underline-offset-4">
              Basic Tee
            </h3>

            <p class="mt-2">
              <span class="sr-only"> Regular Price </span>
              <span class="tracking-wider text-gray-900"> £24.00 GBP </span>
            </p>
          </div>
        </a>
      </li>
      <!-- Repeat for other products -->
    </ul>
  </div>
</section>

<!-- Modal Structure -->
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
      <div id="modalContent" class="mt-4">
        <h3 class="text-lg font-medium text-gray-900" id="productName"></h3>
        <p class="mt-2 text-gray-600" id="productPrice"></p>
        <div class="mt-4">
          <label for="quantity" class="block text-sm font-medium text-gray-700">Quantity</label>
          <div class="flex items-center rounded border border-gray-200">
            <button type="button" class="size-10 leading-10 text-gray-600 transition hover:opacity-75" onclick="decreaseQuantity()">
              &minus;
            </button>

            <input
              type="number"
              id="Quantity"
              value="1"
              class="h-10 w-16 border-transparent text-center [-moz-appearance:_textfield] sm:text-sm [&::-webkit-inner-spin-button]:m-0 [&::-webkit-inner-spin-button]:appearance-none [&::-webkit-outer-spin-button]:m-0 [&::-webkit-outer-spin-button]:appearance-none"
            />

            <button type="button" class="size-10 leading-10 text-gray-600 transition hover:opacity-75" onclick="increaseQuantity()">
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

<script>
  function openModal(productName, productPrice) {
    document.getElementById('productName').textContent = productName;
    document.getElementById('productPrice').textContent = productPrice;
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
</script>
@endsection
