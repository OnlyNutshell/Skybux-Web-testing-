

<!-- navbar home -->
<nav class="sticky top-0 z-50 h-17.5 w-full
            px-6 md:px-16 lg:px-24 xl:px-32
            flex items-center bg-[#0C4A6E] transition-all">
        
    <a href="#" class="flex items-center text-white">
        <img width="70" height="30" src="{{ asset('img/image.png') }}" alt="Skybux-icon.png">
    </a>

    <div class="flex items-center justify-between w-full ml-15">
        <ul class="text-white text-sm font-semibold  md:flex hidden items-center gap-10">
            <li><a class="border-b-2 border-transparent hover:text-sky-400 hover:border-sky-400 transition-colors duration-200 pb-2" href="#">Beranda</a></li>
            <li><a class="border-b-2 border-transparent hover:text-sky-400 hover:border-sky-400 transition-colors duration-200 pb-2" href="#">Beli Robux</a></li>
            <li><a class="border-b-2 border-transparent hover:text-sky-400 hover:border-sky-400 transition-colors duration-200 pb-2" href="#">Cara Order</a></li>
            <li><a class="border-b-2 border-transparent hover:text-sky-400 hover:border-sky-400 transition-colors duration-200 pb-2" href="#">FAQ</a></li>
            <li><a class="border-b-2 border-transparent hover:text-sky-400 hover:border-sky-400 transition-colors duration-200 pb-2" href="#">Hubungi Kami</a></li>
    </ul>
    
    <button type="button" class="hidden cursor-pointer md:flex items-center gap-2 rounded-full bg-white px-5 py-2.5 text-sm font-semibold text-slate-700 shadow-sm border border-slate-200 hover:bg-[#0C4A6E]/10 hover:text-white hover:border-white active:scale-95 transition-all duration-200">
    <i data-lucide="shopping-cart" class="w-4 h-4"></i>Cart</button>
    
    <button aria-label="menu-btn" type="button" class="menu-btn inline-block md:hidden active:scale-90 transition">
        <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 30 30" fill="#fff">
            <path d="M3 7a1 1 0 1 0 0 2h24a1 1 0 1 0 0-2zm0 7a1 1 0 1 0 0 2h24a1 1 0 1 0 0-2zm0 7a1 1 0 1 0 0 2h24a1 1 0 1 0 0-2z"/>
        </svg>
    </button>
    </div>

    <div class="mobile-menu absolute top-17.5 left-0 w-full bg-linear-to-r from-indigo-700 to-violet-500 p-6 hidden md:hidden">
        <ul class="flex flex-col space-y-4 text-white text-lg">
            <li><a href="#" class="text-sm">Beranda</a></li>
            <li><a href="#" class="text-sm">Beli Robux</a></li>
            <li><a href="#" class="text-sm">Cara Order</a></li>
            <li><a href="#" class="text-sm">FAQ</a></li>
            <li><a href="#" class="text-sm">Hubungi Kami</a></li>
        </ul>
        <button type="button" class="bg-white text-gray-700 mt-6 inline md:hidden text-sm hover:opacity-90 active:scale-95 transition-all w-40 h-11 rounded-full">
        Get started
        </button>
    </div>
</nav>

<script>
    const menuButtons = document.querySelectorAll('.menu-btn');
    const mobileMenus = document.querySelectorAll('.mobile-menu');

    menuButtons.forEach((btn, index) => {
        btn.addEventListener('click', () => {
            mobileMenus[index].classList.toggle('hidden');
        });
    });

</script>