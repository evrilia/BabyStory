<header class="flex justify-between items-center bg-white shadow px-4 py-3 sticky top-0 z-40">
    {{-- Tombol Toggle Sidebar untuk Mobile --}}
    <button id="sidebarToggle" class="md:hidden text-gray-700 text-2xl mr-2">
        ☰
    </button>

    {{-- Judul Halaman --}}
    <div class="text-gray-700 font-semibold text-lg">
        @yield('page_title', 'Dashboard')
    </div>

    {{-- Bagian Kanan --}}
    <div class="flex items-center gap-5">
        {{-- Search --}}
        <form action="{{ route('admin.products.index') }}" method="GET" class="hidden sm:flex items-center relative">
            <input type="text" name="search" placeholder="Search..." value="{{ request('search') }}"
                class="border rounded-full px-4 py-2 w-48 md:w-64 focus:ring-2 focus:ring-pink-300 outline-none transition-all duration-300">
            <button type="submit" class="absolute right-3 text-gray-400">
                <i class="fa fa-search"></i>
            </button>
        </form>


        {{-- Notifikasi --}}
        <div class="relative cursor-pointer" id="notificationBell">
            {{-- Logo lonceng --}}
            <img src="{{ asset('images/notifications.png') }}" alt="Notifikasi" class="w-6 h-6 object-contain">

            {{-- Titik merah (muncul hanya jika ada notifikasi baru) --}}
            @if (!empty($hasNotifications) && $hasNotifications)
                <span class="absolute top-0 right-0 w-2.5 h-2.5 bg-red-500 rounded-full border border-white"></span>
            @endif

            {{-- Dropdown daftar notifikasi --}}
            <div id="notificationDropdown"
                class="absolute right-0 mt-2 w-64 bg-white shadow-lg rounded-lg hidden z-50 border border-gray-100">
                <div class="px-4 py-2 border-b text-gray-700 font-semibold">Notifikasi</div>
                <ul class="max-h-60 overflow-y-auto">
                    @forelse ($notifications ?? [] as $notif)
                        <li
                            class="px-4 py-2 border-b text-sm {{ $notif->is_read ? 'text-gray-500' : 'text-gray-800 font-medium' }}">
                            {{ $notif->title }}
                            <div class="text-xs text-gray-400">{{ $notif->created_at->diffForHumans() }}</div>
                        </li>
                    @empty
                        <li class="px-4 py-3 text-sm text-gray-500 text-center">Tidak ada notifikasi</li>
                    @endforelse
                </ul>
            </div>
        </div>

        <script>
            document.addEventListener('DOMContentLoaded', () => {
                const bell = document.getElementById('notificationBell');
                const dropdown = document.getElementById('notificationDropdown');

                bell.addEventListener('click', () => {
                    dropdown.classList.toggle('hidden');
                });

                document.addEventListener('click', (e) => {
                    if (!bell.contains(e.target)) {
                        dropdown.classList.add('hidden');
                    }
                });
            });
        </script>

        {{-- Dropdown Admin --}}
        <div class="relative" id="adminDropdownWrapper">
            <button id="adminDropdownButton"
                class="border rounded-full px-4 py-1 flex items-center bg-gray-50 hover:bg-gray-100 transition focus:outline-none">
                <span>Admin</span>
                <i class="fa fa-chevron-down ml-2 text-xs"></i>
            </button>

            {{-- Isi Dropdown --}}
            <div id="adminDropdown"
                class="absolute right-0 mt-2 w-44 bg-white shadow-lg rounded-lg hidden z-50 border border-gray-100">
                <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50">Profil</a>
                <a href="{{ route('admin.change-password.form') }}"
                    class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50">Ubah Password</a>
                <form action="{{ route('admin.logout') }}" method="POST">
                    @csrf
                    <button type="submit"
                        class="w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-50">Keluar</button>
                </form>
            </div>
        </div>

        <script>
            document.addEventListener('DOMContentLoaded', () => {
                const button = document.getElementById('adminDropdownButton');
                const dropdown = document.getElementById('adminDropdown');
                const wrapper = document.getElementById('adminDropdownWrapper');

                button.addEventListener('click', () => {
                    dropdown.classList.toggle('hidden');
                });

                document.addEventListener('click', (e) => {
                    if (!wrapper.contains(e.target)) {
                        dropdown.classList.add('hidden');
                    }
                });
            });
        </script>
    </div>
</header>
