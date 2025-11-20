<nav id="mainNavbar"
    class="fixed top-0 left-0 w-full flex justify-between items-center py-2 px-10 z-50 transition-all duration-300 ease-in-out bg-transparent">

    <a href="{{ route('user.home') }}">
        <img src="{{ asset('images/LogoBaby.png') }}" alt="Baby Story Logo"
            class="w-20 md:w-24 h-auto hover:opacity-90 transition">
    </a>

    <div class="flex items-center gap-8">
        <ul class="hidden md:flex gap-8 font-bold text-xs md:text-sm tracking-wide uppercase drop-shadow-sm">
            <li>
                <a href="#beranda" id="link-beranda"
                    class="nav-link text-[#80CEF4] hover:text-pink-400 transition duration-300">
                    Beranda
                </a>
            </li>
            <li>
                <a href="#kategori" id="link-kategori"
                    class="nav-link text-[#80CEF4] hover:text-pink-400 transition duration-300">
                    Kategori
                </a>
            </li>
            <li>
                <a href="#syarat" id="link-syarat"
                    class="nav-link text-[#80CEF4] hover:text-pink-400 transition duration-300">
                    Syarat & Ketentuan
                </a>
            </li>
            <li>
                <a href="#layanan" id="link-layanan"
                    class="nav-link text-[#80CEF4] hover:text-pink-400 transition duration-300">
                    Layanan Komunikasi
                </a>
            </li>
        </ul>

        @if(Auth::guard('admin')->check())
            <a href="{{ route('admin.dashboard') }}"
                class="px-4 py-1.5 border-2 border-[#80CEF4] text-[#80CEF4] rounded-full font-bold text-xs md:text-sm 
                          hover:bg-pink-400 hover:text-white hover:border-pink-400 transition duration-300 shadow-md bg-white/10 backdrop-blur-sm">
                Dashboard
            </a>
        @else
            <a href="{{ route('admin.login') }}"
                class="px-4 py-1.5 border-2 border-[#80CEF4] text-[#80CEF4] rounded-full font-bold text-xs md:text-sm 
                          hover:bg-pink-400 hover:text-white hover:border-pink-400 transition duration-300 shadow-md bg-white/10 backdrop-blur-sm">
                Login
            </a>
        @endif
    </div>
</nav>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const navbar = document.getElementById('mainNavbar');
        const navLinks = document.querySelectorAll('.nav-link');
        const sections = document.querySelectorAll('section'); 

        function updateActiveMenu() {
            if (window.scrollY > 50) {
                navbar.classList.remove('bg-transparent', 'py-2');
                navbar.classList.add('bg-white/95', 'backdrop-blur-md', 'shadow-md', 'py-1');
            } else {
                navbar.classList.add('bg-transparent', 'py-2');
                navbar.classList.remove('bg-white/95', 'backdrop-blur-md', 'shadow-md', 'py-1');
            }

            let currentSection = '';

            if ((window.innerHeight + window.scrollY) >= document.body.offsetHeight - 10) {
                currentSection = 'layanan';
            } else {
                sections.forEach(section => {
                    const sectionTop = section.offsetTop;
                    const sectionHeight = section.clientHeight;
                    
                    if (pageYOffset >= (sectionTop - 300)) { 
                        currentSection = section.getAttribute('id');
                    }
                });
            }

            navLinks.forEach(link => {
                link.classList.remove('text-pink-400');
                link.classList.add('text-[#80CEF4]');
                
                if (link.getAttribute('href').includes(currentSection)) {
                    link.classList.remove('text-[#80CEF4]');
                    link.classList.add('text-pink-400');
                }
            });
        }

        window.addEventListener('scroll', updateActiveMenu);
        
        updateActiveMenu();
    });
</script>