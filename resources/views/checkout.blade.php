@extends('layouts.headercus')

@section('content')
<div class="grid sm:px-10 lg:grid-cols-2 lg:px-20 xl:px-32">
  <div class="px-4 pt-8">
    <p class="text-xl font-medium">Order Summary</p>
    <p class="text-gray-400">Check your items. And select a suitable shipping method.</p>
    <div id="cartItems" class="mt-8 space-y-3 rounded-lg border bg-white px-2 py-4 sm:px-6">
        <!-- Cart items will be injected here by jQuery -->
    </div>

    <!-- Shipping Methods -->
    <p class="mt-8 text-lg font-medium">Shipping Methods</p>
    <form class="mt-5 grid gap-6">
      <div class="relative">
        <input class="peer hidden" id="radio_1" type="radio" name="shipping" value="standard" checked />
        <span class="peer-checked:border-gray-700 absolute right-4 top-1/2 box-content block h-3 w-3 -translate-y-1/2 rounded-full border-8 border-gray-300 bg-white"></span>
        <label class="peer-checked:border-2 peer-checked:border-gray-700 peer-checked:bg-gray-50 flex cursor-pointer select-none rounded-lg border border-gray-300 p-4" for="radio_1">
          <img class="w-14 object-contain" src="https://upload.wikimedia.org/wikipedia/commons/thumb/0/01/J%26T_Express_logo.svg/2560px-J%26T_Express_logo.svg.png" alt="" />
          <div class="ml-5">
            <span class="mt-2 font-semibold">J&T Express</span>
            <p class="text-slate-500 text-sm leading-6">Delivery: 6-8 Days</p>
          </div>
        </label>
      </div>
      <div class="relative">
        <input class="peer hidden" id="radio_2" type="radio" name="shipping" value="express" />
        <span class="peer-checked:border-gray-700 absolute right-4 top-1/2 box-content block h-3 w-3 -translate-y-1/2 rounded-full border-8 border-gray-300 bg-white"></span>
        <label class="peer-checked:border-2 peer-checked:border-gray-700 peer-checked:bg-gray-50 flex cursor-pointer select-none rounded-lg border border-gray-300 p-4" for="radio_2">
          <img class="w-14 object-contain" src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRAgaA0lRW4T0yvGlanlhtOJXE7nFL_QzLOiQ&s" alt="" />
          <div class="ml-5">
            <span class="mt-2 font-semibold">LBC Express</span>
            <p class="text-slate-500 text-sm leading-6">Delivery: 2-4 Days</p>
          </div>
        </label>
      </div>
    </form>

  </div>

  <div class="mt-10 bg-gray-50 px-4 pt-8 lg:mt-0">
    <p class="text-xl font-medium">Payment Details</p>
    <p class="text-gray-400">Complete your order by providing your payment details.</p>
    <div class="">
      <label for="email" class="mt-4 mb-2 block text-sm font-medium">Email</label>
      <div class="relative">
        <input type="text" id="email" name="email" class="w-full rounded-md border border-gray-200 px-4 py-3 pl-11 text-sm shadow-sm outline-none focus:z-10 focus:border-blue-500 focus:ring-blue-500" placeholder="your.email@gmail.com" readonly />
        <div class="pointer-events-none absolute inset-y-0 left-0 inline-flex items-center px-3">
          <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207" />
          </svg>
        </div>
      </div>

      <label for="card-holder" class="mt-4 mb-2 block text-sm font-medium">Billing Name</label>
      <div class="relative">
        <input type="text" id="card-holder" name="card-holder" class="w-full rounded-md border border-gray-200 px-4 py-3 pl-11 text-sm uppercase shadow-sm outline-none focus:z-10 focus:border-blue-500 focus:ring-blue-500" placeholder="Your full name here" readonly/>
        <div class="pointer-events-none absolute inset-y-0 left-0 inline-flex items-center px-3">
          <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M15 9h3.75M15 12h3.75M15 15h3.75M4.5 19.5h15a2.25 2.25 0 002.25-2.25V6.75A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25v10.5A2.25 2.25 0 004.5 19.5zm6-10.125a1.875 1.875 0 11-3.75 0 1.875 1.875 0 013.75 0zm1.294 6.336a6.721 6.721 0 01-3.17.789 6.721 6.721 0 01-3.168-.789 3.376 3.376 0 016.338 0z" />
          </svg>
        </div>
      </div>

      <label for="payment-method" class="mt-4 mb-2 block text-sm font-medium">Payment Method</label>
      <select id="payment-method" name="payment-method" class="w-full rounded-md border border-gray-200 px-4 py-3 text-sm shadow-sm outline-none focus:z-10 focus:border-blue-500 focus:ring-blue-500">
        <option value="credit-card">Credit Card</option>
        <option value="paypal">PayPal</option>
        <option value="bank-transfer">Bank Transfer</option>
      </select>

      <label for="billing-address" class="mt-4 mb-2 block text-sm font-medium">Billing Address</label>
      <div class="flex flex-col sm:flex-row">
        <div class="relative flex-shrink-0 sm:w-full">
          <input type="text" id="billing-address" name="billing-address" class="w-full rounded-md border border-gray-200 px-4 py-3 pl-11 text-sm shadow-sm outline-none focus:z-10 focus:border-blue-500 focus:ring-blue-500" placeholder="Street Address" readonly/>
          <div class="pointer-events-none absolute inset-y-0 left-0 inline-flex items-center px-3">
          </div>
        </div>
      </div>

      <!-- Total -->
      <div class="mt-6 border-t border-b py-2">
        <div class="flex items-center justify-between">
            <p class="text-sm font-medium text-gray-900">Subtotal</p>
            <p id="totalAmount" class="font-semibold text-gray-900">$00.00</p>
        </div>
        <div class="flex items-center justify-between">
            <p class="text-sm font-medium text-gray-900">Shipping</p>
            <p id="shippingAmount" class="font-semibold text-gray-900">$0.00</p>
        </div>
      </div>
      <p class="mt-6 flex items-center justify-between">
          <span class="text-sm font-medium text-gray-900">Total</span>
          <span id="total" class="text-2xl font-semibold text-gray-900">$0.00</span>
      </p>
    </div>
    <button id="placeOrderButton" class="mt-4 mb-8 w-full rounded-md bg-gray-900 px-6 py-3 font-medium text-white">Place Order</button>
  </div>
</div>
@endsection
 