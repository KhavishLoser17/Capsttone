<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title')</title>
    <link rel="icon" href="{{ asset('img/jvdlogo.png') }}" type="image/x-icon">
    @vite(['resources/css/app.css','resources/js/app.js'])
    @livewireStyles
    <wireui:scripts />
    <!-- Alpine JS -->
    <script src="//unpkg.com/alpinejs" defer></script>
    <script src="https://cdn.jsdelivr.net/npm/dayjs@1.10.7/dayjs.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/simple-datatables@latest" type="text/javascript"></script>
    {{-- <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script> --}}

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="https://cdn.jsdelivr.net/npm/fullcalendar@5.10.1/main.min.css" rel="stylesheet">

    <!-- apexcharts -->
    <script src="https://cdn.jsdelivr.net/npm/apexcharts@3.46.0/dist/apexcharts.min.js"></script>

    <!-- sweet alert -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- Toastify -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastify-js/1.11.2/Toastify.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastify-js/1.11.2/Toastify.min.js"></script>

    <!-- Calendar -->
    <link href="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.css" rel="stylesheet">
    <script defer src="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.js"></script>

    <!-- Swiper -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />

</head>
<body class="bg-gray-100 antialiased scroll-smooth">
    @include('components.others.noscript')
    @include('components.others.loading-screen')
    @include('components.others.term-modal')

    <div class="flex min-h-screen scroll-smooth w-full flex-col">
        <nav class="min-h-[10vh] bg-white px-4 md:px-10 flex justify-between items-center sticky top-0 shadow-sm z-20 gap-10">
            @include('components.client.navbar')
        </nav>


            <!-- Content Main -->
            <article class="min-h-[90vh] w-full flex items-center justify-center">
                @yield('content')
            </article>

            <!-- Footer -->

        <footer class="bg-white px-10 py-4 shadow-md text-center">
            @include('components.client.footer')
        </footer>
    </div>
    <script src="{{ asset('assets/js/swiper-bundle.min.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    @include('components.others.toast-notification')
</body>
</html>
