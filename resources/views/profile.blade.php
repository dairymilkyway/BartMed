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
                        <button type="button" id="updateProfileBtn"
                            class="py-3.5 px-7 text-base font-medium text-indigo-100 focus:outline-none bg-[#202142] rounded-lg border border-indigo-200 hover:bg-indigo-900 focus:z-10 focus:ring-4 focus:ring-indigo-200">
                            Update Your Profile
                        </button>
                        <input type="file" id="profile_picture" name="profile_picture" style="display: none;">
                        <button type="button" id="changeProfilePicBtn" class="py-3.5 px-7 text-base font-medium text-indigo-100 focus:outline-none bg-[#202142] rounded-lg border border-indigo-200 hover:bg-indigo-900 focus:z-10 focus:ring-4 focus:ring-indigo-200">
                            Change Your Profile Picture
                        </button>
                        <button type="button" id="deactivateAccountBtn"
                        class="py-3.5 px-7 text-base font-medium text-red-100 focus:outline-none bg-red-500 rounded-lg border border-red-200 hover:bg-red-600 focus:z-10 focus:ring-4 focus:ring-red-200">
                        Deactivate Account
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
<!-- Change Profile Picture Modal -->
<div id="changeProfilePicModal" class="hidden fixed z-10 inset-0 overflow-y-auto">
    <div class="flex items-center justify-center min-h-screen">
        <div class="bg-white rounded-lg shadow-lg overflow-hidden w-full max-w-md">
            <div class="px-4 py-3 border-b border-gray-200">
                <h3 class="text-lg leading-6 font-medium text-gray-900">Change Profile Picture</h3>
            </div>
            <div class="p-6">
                <form id="changeProfilePicForm" enctype="multipart/form-data">
                    <div class="mb-4">
                        <label for="profile_picture" class="block text-sm font-medium text-gray-700">Choose Image</label>
                        <input type="file" id="profile_picture" name="profile_picture" accept="image/*" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                    </div>
                    <div class="flex justify-end">
                        <button type="button" id="cancelChangePicBtn" class="mr-2 py-2 px-4 bg-gray-500 text-white rounded-md">Cancel</button>
                        <button type="submit" id="submitChangePicBtn" class="py-2 px-4 bg-indigo-600 text-white rounded-md">Upload</button>
                    </div>
                    <!-- Deactivate Account Button -->
                    <button type="button" id="deactivateAccountBtn"
                    class="py-3.5 px-7 text-base font-medium text-red-100 focus:outline-none bg-red-500 rounded-lg border border-red-600 hover:bg-red-600 focus:z-10 focus:ring-4 focus:ring-red-200">
                    Deactivate Account
                </button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Update Profile Modal -->
<div id="updateProfileModal" class="hidden fixed z-10 inset-0 overflow-y-auto">
    <div class="flex items-center justify-center min-h-screen">
        <div class="bg-white rounded-lg shadow-lg overflow-hidden w-full max-w-md">
            <div class="px-4 py-3 border-b border-gray-200">
                <h3 class="text-lg leading-6 font-medium text-gray-900">Update Profile</h3>
            </div>
            <div class="p-6">
                <form id="updateProfileForm">
                    <div class="mb-4">
                        <label for="update_first_name"
                            class="block text-sm font-medium text-gray-700">First name</label>
                        <input type="text" id="update_first_name" name="first_name"
                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                    </div>
                    <div class="mb-4">
                        <label for="update_last_name"
                            class="block text-sm font-medium text-gray-700">Last name</label>
                        <input type="text" id="update_last_name" name="last_name"
                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                    </div>
                    <div class="mb-4">
                        <label for="update_email" class="block text-sm font-medium text-gray-700">Email</label>
                        <input type="email" id="update_email" name="email"
                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                    </div>
                    <div class="mb-4">
                        <label for="update_address"
                            class="block text-sm font-medium text-gray-700">Address</label>
                        <input type="text" id="update_address" name="address"
                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                    </div>
                    <div class="mb-4">
                        <label for="update_number" class="block text-sm font-medium text-gray-700">Number</label>
                        <input type="text" id="update_number" name="number"
                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                    </div>
                    <div class="flex justify-end">
                        <button type="button" id="cancelUpdateBtn"
                            class="mr-2 py-2 px-4 bg-gray-500 text-white rounded-md">Cancel</button>
                        <button type="submit"
                            class="py-2 px-4 bg-indigo-600 text-white rounded-md">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- Deactivate Account Modal -->
<div id="deactivateAccountModal" class="hidden fixed z-10 inset-0 overflow-y-auto">
    <div class="flex items-center justify-center min-h-screen">
        <div class="bg-white rounded-lg shadow-lg overflow-hidden w-full max-w-md">
            <div class="px-4 py-3 border-b border-gray-200">
                <h3 class="text-lg leading-6 font-medium text-gray-900">Deactivate Account</h3>
            </div>
            <div class="p-6">
                <p class="mb-4">Are you sure you want to deactivate your account? This action cannot be undone.</p>
                <div class="flex justify-end">
                    <button type="button" id="cancelDeactivateBtn" class="mr-2 py-2 px-4 bg-gray-500 text-white rounded-md">Cancel</button>
                    <button type="button" id="confirmDeactivateBtn" class="py-2 px-4 bg-red-600 text-white rounded-md">Deactivate</button>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
