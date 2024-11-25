<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Management System</title>

    <script src="https://cdn.tailwindcss.com"></script>

</head>
<style>
    body {
        background-image: url('{{ asset('assets/store.jpg') }}');
        background-repeat: no-repeat;
        background-size: cover;
        background-blend-mode: multiply;
        background-color: rgba(0, 0, 0, 0.5);
    }
</style>

<body class="bg-white-100">
    <nav class="bg-blue-800">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-16">
                <div class="flex items-center">
                    <a href="{{ url('/') }}" class="text-white font-bold text-xl">Product Management</a>
                </div>
                <div class="hidden md:block">
                    <div class="ml-10 flex items-baseline space-x-4">
                        <a href="{{ route('categories.index') }}"
                            class="text-gray-100 hover:bg-indigo-800 hover:text-white px-3 py-2 rounded-md text-sm font-medium">Categories</a>
                        <a href="{{ route('products.index') }}"
                            class="text-gray-100 hover:bg-indigo-800 hover:text-white px-3 py-2 rounded-md text-sm font-medium">Products</a>
                        <a href="{{ route('inventory-logs.index') }}"
                            class="text-gray-100 hover:bg-indigo-800 hover:text-white px-3 py-2 rounded-md text-sm font-medium">Inventory
                            Logs</a>
                    </div>
                </div>
                <div class="-mr-2 flex md:hidden">
                    <button type="button"
                        class="bg-gray-800 inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-white hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-gray-800 focus:ring-white"
                        aria-controls="mobile-menu" aria-expanded="false">
                        <span class="sr-only">Open main menu</span>
                        <svg class="block h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>

        <div class="md:hidden" id="mobile-menu">
            <div class="px-2 pt-2 pb-3 space-y-1 sm:px-3">
                <a href="{{ route('categories.index') }}"
                    class="text-gray-300 hover:bg-gray-700 hover:text-white block px-3 py-2 rounded-md text-base font-medium">Categories</a>
                <a href="{{ route('products.index') }}"
                    class="text-gray-300 hover:bg-gray-700 hover:text-white block px-3 py-2 rounded-md text-base font-medium">Products</a>
                <a href="{{ route('inventory-logs.index') }}"
                    class="text-gray-300 hover:bg-gray-700 hover:text-white block px-3 py-2 rounded-md text-base font-medium">Inventory
                    Logs</a>
            </div>
        </div>
    </nav>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-8">
        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                <span class="block sm:inline">{{ session('success') }}</span>
            </div>
        @endif

        @if(session('error'))
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                <span class="block sm:inline">{{ session('error') }}</span>
            </div>
        @endif

        @yield('content')
    </div>

    <footer class="fixed bottom-0 left-0 w-full bg-blue-800 text-white py-4 text-center">

        Product Management System ©2024.
    </footer>


    <script>
         document.querySelector('button[aria-controls="mobile-menu"]').addEventListener('click', function () {
            const mobileMenu = document.getElementById('mobile-menu');
            mobileMenu.classList.toggle('hidden');
        });
    </script>
</body>

</html>