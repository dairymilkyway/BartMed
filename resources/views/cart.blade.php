@extends('layouts.headercus')
@section('content')

<section>
  <div class="mx-auto max-w-screen-xl px-8 py-12 sm:px-12 sm:py-16 lg:px-16">
    <div class="mx-auto max-w-6xl">
      <header class="text-center">
        <h1 class="text-2xl font-bold text-gray-900 sm:text-4xl">Your Cart</h1>
      </header>

      <div class="mt-8">
        <ul class="space-y-6">
          <li class="flex items-center gap-6">
            <img
              src="https://images.unsplash.com/photo-1618354691373-d851c5c3a990?ixlib=rb-1.2.1&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=830&q=80"
              alt=""
              class="w-24 h-24 rounded object-cover"
            />

            <div>
              <h3 class="text-lg text-gray-900">Basic Tee 6-Pack</h3>

              <dl class="mt-1 space-y-1 text-sm text-gray-600">
                <div>
                  <dt class="inline">Size:</dt>
                  <dd class="inline">XXS</dd>
                </div>

                <div>
                  <dt class="inline">Color:</dt>
                  <dd class="inline">White</dd>
                </div>
              </dl>
            </div>

            <div class="flex flex-1 items-center justify-end gap-4">
              <div class="flex items-center gap-2">
                <button type="button" onclick="decrementQuantity('Line1Qty')" class="text-gray-600">
                  <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="h-5 w-5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M20 12H4"/>
                  </svg>
                </button>

                <input
                  type="text"
                  value="1"
                  id="Line1Qty"
                  class="h-10 w-14 rounded border-gray-200 bg-gray-50 p-0 text-center text-sm text-gray-600 focus:outline-none"
                />

                <button type="button" onclick="incrementQuantity('Line1Qty')" class="text-gray-600">
                  <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="h-5 w-5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                  </svg>
                </button>
              </div>

              <button class="text-gray-600 transition hover:text-red-600">
                <span class="sr-only">Remove item</span>

                <svg
                  xmlns="http://www.w3.org/2000/svg"
                  fill="none"
                  viewBox="0 0 24 24"
                  stroke-width="1.5"
                  stroke="currentColor"
                  class="h-6 w-6"
                >
                  <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0"
                  />
                </svg>
              </button>
            </div>
          </li>

          <!-- Repeat similar structure for other items -->

        </ul>

        <div class="mt-8 flex justify-end border-t border-gray-100 pt-8">
          <div class="w-screen max-w-lg space-y-4">
            <dl class="space-y-0.5 text-sm text-gray-700">
              <div class="flex justify-between">
                <dt>Subtotal</dt>
                <dd>$119.00</dd>
              </div>

              <div class="flex justify-between">
                <dt>VAT</dt>
                <dd>$25.00</dd>
              </div>

              <div class="flex justify-between">
                <dt>Discount</dt>
                <dd>- $20.00</dd>
              </div>

              <div class="flex justify-between">
                <dt>Shipping</dt>
                <dd>$8.00</dd>
              </div>

              <div class="flex justify-between !text-base font-medium">
                <dt>Total</dt>
                <dd>$132.00</dd>
              </div>
            </dl>

            <div class="flex justify-end">
              <span
                class="inline-block rounded bg-gray-400 px-5 py-3 text-sm text-white cursor-not-allowed"
              >
                Checkout
              </span>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<script>
  function incrementQuantity(inputId) {
    var input = document.getElementById(inputId);
    var value = parseInt(input.value, 10);
    input.value = isNaN(value) ? 1 : value + 1;
  }

  function decrementQuantity(inputId) {
    var input = document.getElementById(inputId);
    var value = parseInt(input.value, 10);
    if (!isNaN(value) && value > 1) {
      input.value = value - 1;
    }
  }
</script>

@endsection
