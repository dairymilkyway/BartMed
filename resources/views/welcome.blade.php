@extends('layouts.header')

@section('title', 'Welcome')

@section('content')
    <div class="min-h-screen bg-gray-100">
        <!-- Hero Section -->
        <div class="relative bg-cover bg-center h-96" style="background-image: url('https://images.pexels.com/photos/159211/headache-pain-pills-medication-159211.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=1');">
            <div class="absolute inset-0 bg-black bg-opacity-50 flex items-center justify-center">
                <div class="text-center">
                    <h1 class="text-5xl font-bold text-white">BartMed Pharmacy</h1>
                    <p class="text-xl text-gray-300 mt-4">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum</p>
                    <button class="loginModalOpen mt-8 inline-block bg-teal-600 text-white py-3 px-6 rounded-full text-lg font-semibold hover:bg-teal-700 transition duration-300">Login</button>
                    <button class="registerModalOpen mt-8 inline-block bg-teal-600 text-white py-3 px-6 rounded-full text-lg font-semibold hover:bg-teal-700 transition duration-300">Register</button>
                </div>
            </div>
        </div>

        <!-- Services Section -->
        <div class="mt-12 grid grid-cols-1 md:grid-cols-3 gap-6">
  <a href="" class="block p-6 bg-white shadow-lg rounded-lg text-center transform transition duration-500 hover:scale-105">
    <img src="https://c8.alamy.com/comp/B8NJ0R/a-selection-of-branded-bottled-and-boxed-vitamins-painkillers-and-B8NJ0R.jpg" alt="Consultation" class="w-24 h-24 mx-auto mb-4 rounded-full border-4 border-teal-600">
    <h3 class="text-xl font-semibold text-gray-800">Brands</h3>
    <p class="text-gray-600 mt-2">Talk to our expert pharmacists for advice and consultation.</p>
  </a>
  <a href="#" class="block p-6 bg-white shadow-lg rounded-lg text-center transform transition duration-500 hover:scale-105">
    <img src="https://images.pexels.com/photos/22020984/pexels-photo-22020984/free-photo-of-close-up-of-capsules-with-powder.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=1" alt="Products" class="w-24 h-24 mx-auto mb-4 rounded-full border-4 border-teal-600">
    <h3 class="text-xl font-semibold text-gray-800">Products</h3>
    <p class="text-gray-600 mt-2">Wide range of pharmaceutical products to meet your needs.</p>
  </a>
  <a href="#" class="block p-6 bg-white shadow-lg rounded-lg text-center transform transition duration-500 hover:scale-105">
    <img src="https://media.istockphoto.com/id/1331044109/vector/us-we.jpg?s=612x612&w=0&k=20&c=jbVJSJNzOdfv1vRSVRga7lLAm9yp2dPiKATs7DfH8Nc=" alt="About Us" class="w-24 h-24 mx-auto mb-4 rounded-full border-4 border-teal-600">
    <h3 class="text-xl font-semibold text-gray-800">About Us</h3>
    <p class="text-gray-600 mt-2">Fast and reliable delivery service for your convenience.</p>
  </a>
</div>

@include('layouts.logregmodals')
</div>



@endsection
