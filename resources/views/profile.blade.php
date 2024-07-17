@extends('layouts.master')
@include('layouts.headercus')

@section('content')
<main class="flex justify-center items-center min-h-screen py-1">
    <div class="w-full max-w-4xl">
        <div class="max-w-2xl mx-auto px-6 pb-8 mt-8 sm:rounded-lg">
            <h2 class="pl-6 text-2xl font-bold sm:text-xl">Public Profile</h2>

            <div class="grid grid-cols-1 gap-6 mt-8">
                <div class="flex flex-col items-center sm:flex-row sm:items-start space-y-5 sm:space-y-0">
                    <img id="profile-pic" class="object-cover w-40 h-40 p-1 rounded-full ring-2 ring-indigo-300 dark:ring-indigo-500"
                        src="https://images.unsplash.com/photo-1438761681033-6461ffad8d80?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxzZWFyY2h8MTB8fGZhY2V8ZW58MHx8MHx8fDA%3D&auto=format&fit=crop&w=500&q=60"
                        alt="Bordered avatar">

                    <div class="flex flex-col space-y-5 sm:ml-8">
                        <button type="button"
                            class="py-3.5 px-7 text-base font-medium text-indigo-100 focus:outline-none bg-[#202142] rounded-lg border border-indigo-200 hover:bg-indigo-900 focus:z-10 focus:ring-4 focus:ring-indigo-200">
                            Update Profile
                        </button>

                    </div>
                </div>

                <div class="mt-8 sm:mt-14 text-[#202142]">
                    <div class="flex flex-col space-y-2 sm:flex-row sm:space-y-0 sm:space-x-4 sm:mb-6">
                        <div class="w-full">
                            <label for="first_name"
                                class="block mb-2 text-sm font-medium text-indigo-900 dark:text-white">Your
                                first name</label>
                            <input type="text" id="first_name"
                                class="bg-indigo-50 border border-indigo-300 text-indigo-900 text-sm rounded-lg focus:ring-indigo-500 focus:border-indigo-500 block w-full p-2.5"
                                placeholder="Your first name" readonly>
                        </div>
                        <div class="w-full">
                            <label for="last_name"
                                class="block mb-2 text-sm font-medium text-indigo-900 dark:text-white">Your
                                last name</label>
                            <input type="text" id="last_name"
                                class="bg-indigo-50 border border-indigo-300 text-indigo-900 text-sm rounded-lg focus:ring-indigo-500 focus:border-indigo-500 block w-full p-2.5"
                                placeholder="Your last name" readonly>
                        </div>
                    </div>
                    <div class="mb-2 sm:mb-6">
                        <label for="email"
                            class="block mb-2 text-sm font-medium text-indigo-900 dark:text-white">Your
                            email</label>
                        <input type="email" id="email"
                            class="bg-indigo-50 border border-indigo-300 text-indigo-900 text-sm rounded-lg focus:ring-indigo-500 focus:border-indigo-500 block w-full p-2.5"
                            placeholder="your.email@mail.com"  readonly>
                    </div>
                    <div class="mb-2 sm:mb-6">
                        <label for="address"
                            class="block mb-2 text-sm font-medium text-indigo-900 dark:text-white">Address</label>
                        <input type="text" id="address"
                            class="bg-indigo-50 border border-indigo-300 text-indigo-900 text-sm rounded-lg focus:ring-indigo-500 focus:border-indigo-500 block w-full p-2.5"
                            placeholder="your address" readonly>
                    </div>
                    <div class="mb-6">
                        <label for="number"
                            class="block mb-2 text-sm font-medium text-indigo-900 dark:text-white">Number</label>
                        <input type="text" id="number"
                            class="bg-indigo-50 border border-indigo-300 text-indigo-900 text-sm rounded-lg focus:ring-indigo-500 focus:border-indigo-500 block w-full p-2.5"
                            placeholder="your number" readonly>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
@endsection
