<div class="w-64 min-h-screen bg-white shadow-md flex flex-col items-center py-6">
    {{-- Logo --}}
    <img src="{{ asset('images/LogoBaby.png') }}" class="w-40 mb-8" alt="Baby Story">

    {{-- Menu Navigasi --}}
    <ul class="space-y-2 w-full text-center font-semibold">
        {{-- Dashboard --}}
        <li>
            <a href="{{ route('admin.dashboard') }}"
                class="block py-2.5 mx-4 rounded-full transition duration-200 
                {{ request()->routeIs('admin.dashboard')
                    ? 'bg-pink-400 text-white shadow-md'
                    : 'text-gray-700 hover:bg-pink-100 hover:text-pink-500' }}">
                Dashboard
            </a>
        </li>

        {{-- Daftar Pesanan --}}
        <li>
            <a href="{{ route('admin.orders.index') }}"
                class="block py-2.5 mx-4 rounded-full transition duration-200 
                {{ request()->routeIs('admin.orders.*')
                    ? 'bg-pink-400 text-white shadow-md'
                    : 'text-gray-700 hover:bg-pink-100 hover:text-pink-500' }}">
                Daftar Pesanan
            </a>
        </li>

        {{-- Kategori --}}
        <li>
            <a href="{{ route('admin.categories.index') }}"
                class="block py-2.5 mx-4 rounded-full transition duration-200 
                {{ request()->routeIs('admin.categories.*')
                    ? 'bg-pink-400 text-white shadow-md'
                    : 'text-gray-700 hover:bg-pink-100 hover:text-pink-500' }}">
                Kategori
            </a>
        </li>

        {{-- Produk --}}
        <li>
            <a href="{{ route('admin.products.index') }}"
                class="block py-2.5 mx-4 rounded-full transition duration-200 
                {{ request()->routeIs('admin.products.*')
                    ? 'bg-pink-400 text-white shadow-md'
                    : 'text-gray-700 hover:bg-pink-100 hover:text-pink-500' }}">
                Produk
            </a>
        </li>

        {{-- Statistik --}}
        <li>
            <a href="{{ route('admin.statistics.index') }}"
                class="block py-2.5 mx-4 rounded-full transition duration-200 
                {{ request()->routeIs('admin.statistics.*')
                    ? 'bg-pink-400 text-white shadow-md'
                    : 'text-gray-700 hover:bg-pink-100 hover:text-pink-500' }}">
                Statistik
            </a>
        </li>
    </ul>
</div>
