<nav x-data="{ open: false }" class="bg-white border-b border-gray-100">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('welcome') }}">
                        {{-- <x-application-mark class="block h-9 w-auto" /> --}}
                    </a>
                </div>
            </div>

            <div class="hidden sm:flex sm:items-center sm:ms-6">
                <a href="{{ route('login') }}" class="text-gray-500 hover:text-gray-700 focus:outline-none focus:text-gray-700 transition ease-in-out duration-150 px-3 py-2 text-sm font-medium rounded-md">Ingresar</a>
                <a href="{{ route('register') }}" class="text-gray-500 hover:text-gray-700 focus:outline-none focus:text-gray-700 transition ease-in-out duration-150 px-3 py-2 text-sm font-medium rounded-md">Registrarse</a>
            </div>
        </div>
    </div>
</nav>
