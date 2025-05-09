<!-- Logo and ToggleNav Icon -->
<a href="/" class="flex items-center space-x-3 rtl:space-x-reverse">
    <img src="{{ asset('img/jvdlogo.png') }}" class="w-16 md:w-24" alt="JVD Logo" />
</a>

<!-- Toggle Navigation (Hamburger Icon) -->
<a id="toggleNav" class="md:hidden cursor-pointer">
    <i class="fas fa-bars"></i>
</a>

<!-- Overlay (Will appear when navMenu is open) -->
<div id="overlay" class="fixed inset-0 bg-gray-900 opacity-50 hidden z-40"></div>

<!-- Navigation Menu (Always present, animated visibility) -->
<div id="navMenu" class="fixed top-0 right-0 w-1/2 min-w-[300px] h-full bg-white rounded-lg shadow-lg transform translate-x-full transition-transform duration-300 ease-in-out z-50 overflow-y-auto p-4">
    <div class="relative text-center uppercase p-4">

        <!-- Dropdown Menu Items -->
        <button id="hideNav" type="button" class="mt-4 transition-transform duration-300 ease-in-out transform w-full text-lg text-white bg-gradient-to-r from-blue-500 via-blue-600 to-blue-700 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-blue-300 dark:focus:ring-blue-800 font-medium rounded-lg text-sm px-5 py-2.5 text-center ">
            Go Back <i class="fa-solid fa-arrow-right ml-2"></i>
        </button>

        <a href="#home" class="block p-4 text-gray-700 hover:bg-gray-200">Home</a>
        <a href="#careers" class="block p-4 text-gray-700 hover:bg-gray-200">Careers</a>
        <a href="#about" class="block p-4 text-gray-700 hover:bg-gray-200">About</a>
        <a href="#blogs" class="block p-4 text-gray-700 hover:bg-gray-200">Blog</a>
        <a href="#services" class="block p-4 text-gray-700 hover:bg-gray-200">Services</a>
        <a href="#contact" class="block p-4 text-gray-700 hover:bg-gray-200">Contact</a>
        <a href="{{ route('login')}}" class="block p-4 text-gray-700 hover:bg-gray-200">Login</a>
        <a href="{{ route('register')}}" class="block p-4 text-gray-700 hover:bg-gray-200">Register</a>
    </div>
</div>

<!-- Normal Navigation Menu (Visible on larger screens) -->
<ul class="flex flex-row gap-10 hidden md:flex uppercase text-sm text-gray-500 font-medium">
    <li class="hover:underline underline-offset-8 hover:text-blue-600 hover:decoration-2 hover:decoration-blue-600 hover:scale-110 transition">
        <a href="/#home">Home</a>
    </li>
    <li class="hover:underline underline-offset-8 hover:text-blue-600 hover:decoration-2 hover:decoration-blue-600 hover:scale-110 transition">
        <a href="/#careers">Careers</a>
    </li>
    <li class="hover:underline underline-offset-8 hover:text-blue-600 hover:decoration-2 hover:decoration-blue-600 hover:scale-110 transition">
        <a href="/#about">About</a>
    </li>
    <li class="hover:underline underline-offset-8 hover:text-blue-600 hover:decoration-2 hover:decoration-blue-600 hover:scale-110 transition">
        <a href="/#blogs">Blog</a>
    </li>
    <li class="hover:underline underline-offset-8 hover:text-blue-600 hover:decoration-2 hover:decoration-blue-600 hover:scale-110 transition">
        <a href="/#services">Services</a>
    </li>
    <li class="hover:underline underline-offset-8 hover:text-blue-600 hover:decoration-2 hover:decoration-blue-600 hover:scale-110 transition">
        <a href="/#contact">Contact</a>
    </li>
</ul>

<a href="{{ route('login')}}" class="hidden md:block font-light transition-transform duration-300 ease-in-out transform hover:scale-110 text-lg text-white bg-gradient-to-r from-blue-500 via-blue-600 to-blue-700 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-blue-300 dark:focus:ring-blue-800 rounded-lg text-sm px-5 py-2.5 text-center ">Sign In</a>


<script>
    function toggleMenu() {
        const menu = document.getElementById('navMenu');
        const overlay = document.getElementById('overlay');

        const isVisible = !menu.classList.contains('translate-x-full');

        if (isVisible) {
            menu.classList.add('translate-x-full'); 
            overlay.classList.add('hidden');        
        } else {
            menu.classList.remove('translate-x-full'); 
            overlay.classList.remove('hidden');        
        }
    }

    document.getElementById('toggleNav').addEventListener('click', toggleMenu);
    document.getElementById('overlay').addEventListener('click', toggleMenu);
    
    document.getElementById('hideNav').addEventListener('click', toggleMenu);

    document.addEventListener("DOMContentLoaded", function () {
        document.querySelectorAll("a[href^='/#'], a[href^='#']").forEach(anchor => {
            anchor.addEventListener("click", function (e) {
                e.preventDefault();

                const targetId = this.getAttribute("href").replace("/#", "").replace("#", "");
                const targetElement = document.getElementById(targetId);

                if (targetElement) {
                    // If the target element exists, scroll smoothly (means we're already on the landing page)
                    smoothScroll(targetElement, 1000);
                } else {
                    // If not on the landing page, redirect to it with a hash
                    window.location.href = "/#" + targetId;
                }
            });
        });

        function smoothScroll(target, duration) {
            const startPosition = window.scrollY;
            const targetPosition = target.offsetTop - 0;
            const startTime = performance.now();

            function animation(currentTime) {
                const elapsedTime = currentTime - startTime;
                const progress = Math.min(elapsedTime / duration, 1);
                const easeInOutCubic = progress < 0.5
                    ? 4 * progress * progress * progress
                    : (progress - 1) * (2 * progress - 2) * (2 * progress - 2) + 1;

                window.scrollTo(0, startPosition + (targetPosition - startPosition) * easeInOutCubic);

                if (elapsedTime < duration) {
                    requestAnimationFrame(animation);
                }
            }

            requestAnimationFrame(animation);
        }

        // Handle scrolling when landing page is loaded with a hash (e.g., /#about)
        if (window.location.hash) {
            const targetId = window.location.hash.replace("#", "");
            const targetElement = document.getElementById(targetId);
            if (targetElement) {
                setTimeout(() => smoothScroll(targetElement, 1000), 1000);
                
            }
        }
    });

</script>

<style>
    #navMenu {
        transition: transform 0.3s ease-in-out;
    }
</style>
