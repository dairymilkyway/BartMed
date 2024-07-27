<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <title>@yield('title', 'Pharmacy')</title>
    @vite('resources/css/app.css')
</head>
<body class="bg-gray-100 font-sans leading-normal tracking-normal">
    <header class="bg-white">
    <div class="mx-auto max-w-screen-xl px-4 sm:px-6 lg:px-8">
                        <div class="flex h-16 items-center justify-between">
                            <div class="flex-1 md:flex md:items-center md:gap-12">
                            <a class="block text-teal-600 text-5xl" href="{{route('home')}}">
                <span class="sr-only">Home</span>
                <i class="fa-solid fa-pills"></i>
            </a>
                    </a>
                </div>

                <div class="md:flex md:items-center md:gap-12">
                    <nav aria-label="Global" class="hidden md:block">
                        <ul class="flex items-center gap-6 text-sm">
                        <li><a class="text-gray-500 transition hover:text-gray-500/75" href="{{route('home')}}"><i class="fa-solid fa-house"></i> Home</a></li>
      <li><a class="text-gray-500 transition hover:text-gray-500/75" href="{{route('home')}}"><i class="fa-solid fa-bandage"></i> Brands</a></li>
      <li><a class="text-gray-500 transition hover:text-gray-500/75" href="{{route('home')}}"><i class="fa-solid fa-bandage"></i> Products</a></li>
                        </ul>
                    </nav>
                    <div class="flex items-center gap-4">
  <div class="sm:flex sm:gap-4">
    <button class="loginModalOpen rounded-md bg-teal-600 text-white px-5 py-2.5 text-sm font-medium hover:bg-teal-700 transition duration-300">Login</button>
    <div class="hidden sm:flex">
      <button class="registerModalOpen rounded-md bg-teal-600 text-white px-5 py-2.5 text-sm font-medium hover:bg-teal-700 transition duration-300">Register</button>
    </div>
  </div>
</div>

                        <div class="block md:hidden">
                            <button class="rounded bg-gray-100 p-2 text-gray-600 transition hover:text-gray-600/75">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16" />
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <main>
        @yield('content')
    </main>
@include('layouts.logregmodals')
    <script src="{{ mix('js/app.js') }}"></script>
    <script src="layouts/cart.js"></script>
</body>
</html>
