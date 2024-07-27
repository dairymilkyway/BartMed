   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
<div class="flex h-screen flex-col justify-between border-e bg-white">
  <div class="px-6 py-7">
    <div class="block text-teal-600 text-5xl">
      <span class="sr-only">Home</span>
      <i class="fa-solid fa-pills"></i>
    </div>
    

    <ul class="mt-6 space-y-1">
  <li>
    <a
      href="{{route('brand.index')}}"
      class="block rounded-lg bg-gray-100 px-4 py-2 text-sm font-medium text-gray-700"
    >
      Brand
    </a>
  </li>

  <li>
    <a
      href="{{route('product.index')}}"
      class="block rounded-lg bg-gray-100 px-4 py-2 text-sm font-medium text-gray-700"
    >
      Product
    </a>
  </li>

  <li>
    <a
      href="{{route('supplier.index')}}"
      class="block rounded-lg bg-gray-100 px-4 py-2 text-sm font-medium text-gray-700"
    >
      Supplier
    </a>
  </li>

  <li>
    <a
      href="{{route('customer.index')}}"
      class="block rounded-lg bg-gray-100 px-4 py-2 text-sm font-medium text-gray-700"
    >
      Customer
    </a>
  </li>

  <li>
    <a
      href="{{route('order.index')}}"
      class="block rounded-lg bg-gray-100 px-4 py-2 text-sm font-medium text-gray-700"
    >
      Order
    </a>
  </li>

  <li>
    <a
      href="{{route('suppliertransaction.index')}}"
      class="block rounded-lg bg-gray-100 px-4 py-2 text-sm font-medium text-gray-700"
    >
      Supplier Transaction
    </a>
  </li>
  <li>
    <details class="group [&_summary::-webkit-details-marker]:hidden">
      <summary
        class="flex cursor-pointer items-center justify-between rounded-lg px-4 py-2 text-gray-500 hover:bg-gray-100 hover:text-gray-700"
      >
        <span class="text-sm font-medium"> Charts </span>

        <span class="shrink-0 transition duration-300 group-open:-rotate-180">
          <svg
            xmlns="http://www.w3.org/2000/svg"
            class="h-5 w-5"
            viewBox="0 0 20 20"
            fill="currentColor"
          >
            <path
              fill-rule="evenodd"
              d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
              clip-rule="evenodd"
            />
          </svg>
        </span>
      </summary>

      <ul class="mt-2 space-y-1 px-4">
        <li>
          <a
            href="{{route('product.chart')}}"
            class="block rounded-lg px-4 py-2 text-sm font-medium text-gray-500 hover:bg-gray-100 hover:text-gray-700"
          >
            Product Solds
          </a>
        </li>

        <li>
          <a
            href="{{route('customer.chart')}}"
            class="block rounded-lg px-4 py-2 text-sm font-medium text-gray-500 hover:bg-gray-100 hover:text-gray-700"
          >
            Registered Customers
          </a>
        </li>

        <li>
          <a
            href="{{route('brand.chart')}}"
            class="block rounded-lg px-4 py-2 text-sm font-medium text-gray-500 hover:bg-gray-100 hover:text-gray-700"
          >

          Brand Solds
          </a>
        </li>
      </ul>
    </details>
  </li>


    </ul>
  </div>

  <div class="sticky inset-x-0 bottom-0 border-t border-gray-100">
    <div class="p-4 hover:bg-gray-50">
      <form action="#">
        <button
        id="logoutButton"
        type="submit"
        class="w-full flex items-center gap-2 rounded-lg px-4 py-2 text-sm font-medium text-gray-500 hover:bg-gray-100 hover:text-gray-700">
        <i class="fas fa-sign-out-alt"></i>
        Logout
      </button>

      </form>
    </div>

  </div>
</div>
