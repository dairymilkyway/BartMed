@include('layouts.headercus')
<section class="py-24 relative">
        <div class="w-full max-w-7xl mx-auto px-4 md:px-8">
            <h2 class="font-manrope font-extrabold text-3xl lead-10 text-black mb-9">Order History</h2>

            <div class="flex sm:flex-col lg:flex-row sm:items-center justify-between">
                <ul class="flex max-sm:flex-col sm:items-center gap-x-14 gap-y-3">
                    <li
                        class="font-medium text-lg leading-8 cursor-pointer text-indigo-600 transition-all duration-500 hover:text-indigo-600">
                        All Order</li>
                    <li
                        class="font-medium text-lg leading-8 cursor-pointer text-black transition-all duration-500 hover:text-indigo-600">
                        Delivered</li>
                    <li
                        class="font-medium text-lg leading-8 cursor-pointer text-black transition-all duration-500 hover:text-indigo-600">
                        Cancelled</li>
                </ul>
                <div class="flex max-sm:flex-col items-center justify-end gap-2 max-lg:mt-5">
                    <div class="flex rounded-full py-3 px-4 border border-gray-300 relative">
                    </div>
                </div>
            </div>
            <div class="mt-7 border border-gray-300 pt-9">
                <div class="flex max-md:flex-col items-center justify-between px-3 md:px-11">
                    <div class="data">
                        <p class="font-medium text-lg leading-8 text-black whitespace-nowrap">Order : #10234987</p>
                        <p class="font-medium text-lg leading-8 text-black mt-3 whitespace-nowrap">Order Payment : 18th
                            march 2021</p>
                    <p class="font-medium text-lg leading-8 text-black mt-3 whitespace-nowrap"> <span class="text-black-500">Total
                            Price: </span> &nbsp;$200.00</p>
                    </div>
                    <div class="flex items-center gap-3 max-md:mt-5">
                        <button
                            class="rounded-full px-7 py-3 bg-red-600 text-gray-900 border border-gray-300 font-semibold text-sm shadow-sm shadow-transparent transition-all duration-500 hover:shadow-red-200 hover:bg-red-50 hover:border-red-400">
                        Cancel 
                        </button>
                        <button
                            class="rounded-full px-7 py-3 bg-green-600 shadow-sm shadow-transparent text-white font-semibold text-sm transition-all duration-500 hover:shadow-green-400 hover:bg-green-700">    
                            Delivered
                        </button>

                    </div>
                </div>
                <svg class="my-9 w-full" xmlns="http://www.w3.org/2000/svg" width="1216" height="2" viewBox="0 0 1216 2"
                    fill="none">
                    <path d="M0 1H1216" stroke="#D1D5DB" />
                </svg>

                <div class="flex max-lg:flex-col items-center gap-8 lg:gap-24 px-3 md:px-11">
                    <div class="grid grid-cols-4 w-full">
                        <div class="col-span-4 sm:col-span-1">
                            <img src="https://pagedone.io/asset/uploads/1705474774.png" alt="" class="max-sm:mx-auto">
                        </div>
                        <div
                            class="col-span-4 sm:col-span-3 max-sm:mt-4 sm:pl-8 flex flex-col justify-center max-sm:items-center">
                            <h6 class="font-manrope font-semibold text-2xl leading-9 text-black mb-3 whitespace-nowrap">
                                Decoration Flower
                                port</h6>
                            <p class="font-normal text-lg leading-8 text-gray-500 mb-8 whitespace-nowrap">By: Dust
                                Studios</p>
                            <div class="flex items-center max-sm:flex-col gap-x-10 gap-y-3">
                                <span class="font-normal text-lg leading-8 text-gray-500 whitespace-nowrap">Quantity:
                                    1</span>
                                <p class="font-semibold text-xl leading-8 text-black whitespace-nowrap">Price $80.00</p>
                            </div>
                        </div>
                    </div>
                    <div class="flex items-center justify-around w-full  sm:pl-28 lg:pl-0">
                        <div class="flex flex-col justify-center items-start max-sm:items-center">
                            <p class="font-normal text-lg text-gray-500 leading-8 mb-2 text-left whitespace-nowrap">
                                Status</p>
                            <p class="font-semibold text-lg leading-8 text-green-500 text-left whitespace-nowrap">
                                Delivered</p>
                        </div>
                    </div>

                </div>

                <svg class="my-9 w-full" xmlns="http://www.w3.org/2000/svg" width="1216" height="2" viewBox="0 0 1216 2"
                    fill="none">
                    <path d="M0 1H1216" stroke="#D1D5DB" />
                </svg>

                </div>
            </div>
        </div>
    </section>
                                            