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
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
    <link href="{{ asset('css/sb-admin-2.min.css') }}" rel="stylesheet">
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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/apexcharts/3.40.0/apexcharts.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.min.js"></script>

    <!-- Calendar -->
    <link href="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.css" rel="stylesheet">
    <script defer src="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.js"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
    <script src="https://html2canvas.hertzen.com/dist/html2canvas.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

</head>
<body class="bg-gray-100 antialiased scroll-smooth">
    @include('components.others.noscript')
    @include('components.others.loading-screen')
    @include('components.others.term-modal')

    <div class="flex h-auto w-full min-h-screen">
        <div id="mobileOverlay" class="fixed inset-0 bg-black bg-opacity-50 hidden md:hidden z-40"></div>
        <!-- Sidebar -->
        <div id="sidebar" class="fixed bg-white text-gray-500 w-60 h-full min-h-screen flex flex-col shadow-md transform transition-all duration-300 md:translate-x-0 -translate-x-full z-40">
            @include('components.admin.sidebar')
        </div>

        <!-- Main Content -->
        <div id="main-content" class="flex-1 md:px-4 md:pt-4 md:ml-60 transition-all duration-300 flex flex-col justify-between overflow-x-auto">
            <!-- Navbar Main -->
            <nav class="bg-white md:px-10 px-4 py-2 rounded-t-lg flex justify-between items-center sticky top-0 border-b-2 border-gray-100 z-20">
                @include('components.admin.navbar')
            </nav>

            <!-- Main Content with Header and Content -->
            <div class="flex-1">
                <!-- Header Main -->
                <header class="bg-white px-4 md:px-10 py-2 shadow-md rounded-b-lg">
                    <div class="breadcrumbs">
                        @livewire('other.breadcrumbs')
                    </div>
                </header>

                <!-- Content Main -->
                <article class="py-4 px-4 md:px-0">
                    @yield('content')
                </article>
            </div>

            <!-- Footer Main -->
            <footer class="px-10 py-4 mt-auto hidden md:flex justify-end">
                @include('components.admin.footer')
            </footer>

        </div>
    </div>
    <script src="{{ asset('assets/js/chart.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    @include('components.others.toast-notification')
</body>
</html>
