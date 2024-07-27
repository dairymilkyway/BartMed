@extends('layouts.header')

@section('title', 'Welcome')

@section('content')
    <div class="min-h-screen bg-gray-100">
        <!-- Hero Section -->
        <div class="relative bg-cover bg-center h-screen" style="background-image: url('https://images.pexels.com/photos/159211/headache-pain-pills-medication-159211.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=1');">
            <!-- Gradient Overlay -->
            <div class="absolute inset-0 bg-gradient-to-r from-black via-transparent to-black opacity-60"></div>
            <div class="absolute inset-0 flex items-center justify-center text-center">
                <div class="text-white px-6 md:px-12">
                    <h1 class="text-4xl md:text-6xl font-bold leading-tight mb-4 animate__animated animate__fadeIn animate__delay-1s text-shadow-lg">BartMed Pharmacy</h1>
                    <p class="text-lg md:text-2xl mb-8 md:mb-12 opacity-90 animate__animated animate__fadeIn animate__delay-2s text-shadow-md">
                        Your trusted partner in health and wellness. We offer a wide range of medications and health solutions to keep you at your best. Join our community and experience exceptional care and service.
                    </p>
                    <div class="space-x-4">
                        <button class="loginModalOpen bg-teal-600 hover:bg-teal-700 text-white py-3 px-6 rounded-full text-lg font-semibold transition duration-300 transform hover:scale-110 hover:shadow-lg animate__animated animate__fadeIn animate__delay-3s">Login</button>
                        <button class="registerModalOpen bg-teal-600 hover:bg-teal-700 text-white py-3 px-6 rounded-full text-lg font-semibold transition duration-300 transform hover:scale-110 hover:shadow-lg animate__animated animate__fadeIn animate__delay-4s">Register</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('layouts.logregmodals')
@endsection

<style>
    /* Custom Text Shadows */
    .text-shadow-lg {
        text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.7);
    }
    .text-shadow-md {
        text-shadow: 1px 1px 3px rgba(0, 0, 0, 0.5);
    }
</style>
