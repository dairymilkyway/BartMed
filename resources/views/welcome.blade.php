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
                    <button id="loginModalOpen" class="mt-8 inline-block bg-teal-600 text-white py-3 px-6 rounded-full text-lg font-semibold hover:bg-teal-700 transition duration-300">Login</button>
                    <button id="registerModalOpen" class="mt-8 inline-block bg-teal-600 text-white py-3 px-6 rounded-full text-lg font-semibold hover:bg-teal-700 transition duration-300">Register</button>
                </div>
            </div>
        </div>

        <!-- Services Section -->
        <div class="mt-12 grid grid-cols-1 md:grid-cols-3 gap-6">
  <a href="#" class="block p-6 bg-white shadow-lg rounded-lg text-center transform transition duration-500 hover:scale-105">
    <img src="https://source.unsplash.com/100x100/?consultation" alt="Consultation" class="w-24 h-24 mx-auto mb-4 rounded-full border-4 border-teal-600">
    <h3 class="text-xl font-semibold text-gray-800">Brands</h3>
    <p class="text-gray-600 mt-2">Talk to our expert pharmacists for advice and consultation.</p>
  </a>
  <a href="#" class="block p-6 bg-white shadow-lg rounded-lg text-center transform transition duration-500 hover:scale-105">
    <img src="https://source.unsplash.com/100x100/?medicine" alt="Products" class="w-24 h-24 mx-auto mb-4 rounded-full border-4 border-teal-600">
    <h3 class="text-xl font-semibold text-gray-800">Products</h3>
    <p class="text-gray-600 mt-2">Wide range of pharmaceutical products to meet your needs.</p>
  </a>
  <a href="#" class="block p-6 bg-white shadow-lg rounded-lg text-center transform transition duration-500 hover:scale-105">
    <img src="https://source.unsplash.com/100x100/?delivery" alt="Delivery" class="w-24 h-24 mx-auto mb-4 rounded-full border-4 border-teal-600">
    <h3 class="text-xl font-semibold text-gray-800">Delivery</h3>
    <p class="text-gray-600 mt-2">Fast and reliable delivery service for your convenience.</p>
  </a>
</div>

<!-- Login Modal -->
<div id="loginModal" class="fixed inset-0 z-50 hidden overflow-y-auto flex items-center justify-center">
    <div class="bg-white p-6 rounded-lg shadow-lg mx-auto max-w-3xl w-full md:w-auto" style="width: 1080px; max-width: 90vw; max-height: 90vh; overflow: hidden;">
        <button id="closeLoginModal" class="absolute top-0 right-0 m-4 text-gray-600 hover:text-gray-800">&times;</button>
        <div style="max-height: 90vh; overflow: hidden;">
            <div style="width: 100%; height: 100%; display: flex; flex-direction: column; justify-content: center; align-items: center;">
                <div style="max-width: 90vw; max-height: calc(90vh - 100px); overflow-y: auto;">
                    <div style="width: 1080px;"> <!-- Adjust content width here -->
                        @include('login') <!-- Assuming login.blade.php exists -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Register Modal -->
<div id="registerModal" class="fixed inset-0 z-50 hidden overflow-y-auto flex items-center justify-center">
    <div class="bg-white p-2 rounded-lg shadow-lg mx-auto max-w-3xl w-full md:w-auto" style="width: 90vw; max-width: 1080px; max-height: 90vh;">
        <button id="closeRegisterModal" class="absolute top-0 right-0 m-2 text-gray-600 hover:text-gray-800">&times;</button>
        <div style="max-height: calc(90vh - 2rem); overflow-y: auto; width: 100%;">
            <div style="width: 100%; display: flex; flex-direction: column; justify-content: center; align-items: center;">
                <div style="max-width: 100%; max-height: 100%; padding: 2px; box-sizing: border-box; font-size: 10px;">
                    @include('register') <!-- Assuming register.blade.php exists -->
                </div>
            </div>
        </div>
    </div>
</div>
</div>

    <script>
    function showModal(modalId) {
        var modal = document.getElementById(modalId);
        modal.classList.remove('hidden');
        modal.classList.add('flex', 'animate-pop-in', 'shadow-lg');
        document.body.classList.add('overflow-hidden'); // Disable scrolling on body
    }

    function hideModal(modalId) {
        var modal = document.getElementById(modalId);
        modal.classList.remove('flex', 'animate-pop-in', 'shadow-lg');
        modal.classList.add('hidden');
        document.body.classList.remove('overflow-hidden'); // Enable scrolling on body
    }

    document.getElementById('loginModalOpen').addEventListener('click', function() {
        showModal('loginModal');
    });

    document.getElementById('registerModalOpen').addEventListener('click', function() {
        showModal('registerModal');
    });

    document.getElementById('closeLoginModal').addEventListener('click', function() {
        hideModal('loginModal');
    });

    document.getElementById('closeRegisterModal').addEventListener('click', function() {
        hideModal('registerModal');
    });

    // Close modals by clicking outside
    document.addEventListener('click', function(event) {
        if (event.target === document.getElementById('loginModal')) {
            hideModal('loginModal');
        }
        if (event.target === document.getElementById('registerModal')) {
            hideModal('registerModal');
        }
    });

    // Optional: Add animation classes to simulate modal pop-in
    document.addEventListener('DOMContentLoaded', function() {
        var animatePopIn = document.createElement('style');
        animatePopIn.innerHTML = `
            @keyframes popIn {
                from {
                    opacity: 0;
                    transform: scale(0.8);
                }
                to {
                    opacity: 1;
                    transform: scale(1);
                }
            }

            .animate-pop-in {
                animation: popIn 0.3s ease forwards;
            }
        `;
        document.head.appendChild(animatePopIn);
    });
</script>


@endsection
