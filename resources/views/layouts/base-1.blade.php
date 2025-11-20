@extends('layouts.app')

@section('header')
    {{-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"> --}}
    <style>
        .sidebar {
            /* durasi bisa disesuaikan */
            transition: width 0.3s ease-in-out;
            overflow: hidden;
        }

        /* width normal (14rem = w-56 tailwind) */
        .sidebar.main {
            width: 14rem;
        }

        /* width ketika collapsed */
        .sidebar.main.collapsed {
            width: 70px;
        }

        /* animasi elemen di dalam sidebar */
        .sidebar .sm-hide,
        .sidebar .sm-show {
            transition: opacity 0.3s ease-in-out;
        }

        .sidebar.main.collapsed .sm-hide {
            opacity: 0;
            pointer-events: none;
        }

        .sidebar.main.collapsed .sm-show {
            opacity: 1;
            pointer-events: auto;
        }

        .sidebar.main a.active {
            background-color: #1C2762 !important;
            color: white !important;
        }
    </style>


    @yield('header-base')
@endsection

@section('content')
    {{-- <div id="screen-width">Width: <span id="width-value"></span>px</div> --}}
    <div class="flex max-h-max gap-2 w-full flex-shrink mb-0 bg-gray-100 font-['Poppins']">
        <!-- Sidebar -->
        <aside id="sidebar"
            class="sidebar flex min-h-fit rounded-lg shadow-md flex-shrink-0 hidden hp:hidden sm:hidden main max-w-56 bg-white text-gray-900 transition-all duration-300 ease-in-out md:block drop-shadow-sm overflow-hidden">
            
            {{-- class="sidebar flex min-h-fit rounded-lg shadow-md flex-shrink-0 hidden hp:hidden sm:hidden main w-56 bg-white text-gray-900 transition-all duration-300 ease-in-out md:block drop-shadow-sm overflow-hidden"> --}}

            <header class="flex items-center p-4 flex-row gap-2">
                <!-- Kotak search -->
                <div class="flex items-center w-full max-w-md px-2 py-1 bg-gray-200 rounded-md sm-hide">
                    <!-- Icon -->
                    <svg class="w-4 h-4 text-[#806767] mr-2" viewBox="0 0 24 24" fill="none"
                        xmlns="http://www.w3.org/2000/svg">
                        <path d="M10 4a6 6 0 104.472 10.472l4.528 4.528a1 1 0 001.414-1.414l-4.528-4.528A6 6 0 0010 4z"
                            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                    </svg>

                    <!-- Input -->
                    <input type="text" placeholder="search"
                        class="w-full bg-transparent text-[#806767] text-xs placeholder-[#806767] focus:outline-none focus:ring-0 border-none py-0 px-1" />
                </div>


                <!-- Toggle sidebar -->
                <button class="flex flex-row items-center py-1" onclick="close_sidebar('hide',this)">
                    <i class="fas fa-bars cursor-pointer"></i>
                </button>
            </header>
            @yield('sidebar-menu')
        </aside>

        <!-- Main Content -->
        <div class="flex-grow shadow-lg @yield('padding-wrapper-table') pr-0 p-4 bg-white rounded-lg h-auto" id="wrapper-table">
            <h1 class="text-2xl font-bold mb-4" id="page-name">@yield('page-name')</h1>
            @yield('content-base')
            {{-- <p class="text-gray-700">Semua konten utama ada di sini. Sidebar tetap di dalam container, tidak menimpa.</p> --}}
        </div>
    </div>
@endsection
@section('script')
    <script>
        function close_sidebar(wht, elemen) {
            document.getElementById('sidebar').classList.toggle('collapsed')
            if (wht === 'hide') {
                document.querySelectorAll('.sm-hide').forEach(element => {
                    element.style.display = 'none';
                });

                document.querySelectorAll('.sm-show').forEach(element => {
                    element.style.display = 'flex';
                });

                document.querySelectorAll('.sm-center').forEach(element => {
                    element.classList.add('justify-center');
                    element.querySelector('i').classList.remove('mr-3')

                });
                elemen.setAttribute("onclick", "close_sidebar('show', this)");

                setTimeout(() => {
                    updateWrapperWidthMain();
                }, 250);

            } else {
                document.querySelectorAll('.sm-hide').forEach(element => {
                    element.style.display = 'flex';
                });

                document.querySelectorAll('.sm-show').forEach(element => {
                    element.style.display = 'none';
                });

                document.querySelectorAll('.sm-center').forEach(element => {
                    element.classList.remove('justify-center');
                    element.querySelector('i').classList.add('mr-3')

                });
                elemen.setAttribute("onclick", "close_sidebar('hide', this)");
                setTimeout(() => {
                    updateWrapperWidthMain();
                }, 250);

            }
        }

        function updateWrapperWidthMain() {
            const sidebar = document.getElementById("sidebar");
            const wrapper = document.getElementById("wrapper-table");

            if (sidebar && wrapper) {
                const sidebarWidth = sidebar.offsetWidth;

                wrapper.style.width = `calc(100% - ${sidebarWidth}px)`; // ← pakai backtick
                console.log('object :>>', wrapper.style.width);
            } else {
                console.warn("Sidebar atau wrapper tidak ditemukan!");
            }
        }
    </script>
    @yield('script-base')
@endsection
