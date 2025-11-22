@php
    $active_sidebar = 'History Pemetaan Jabatan';
@endphp

@extends('kelola_data.base-profile')

@section('content-profile')
    {{-- <script
    src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
    crossorigin="anonymous"
    defer
  ></script> --}}
    <style>
        /* Scrollbar halus & minimal */
        ::-webkit-scrollbar {
            width: 6px;
        }

        ::-webkit-scrollbar-track {
            background: transparent;
        }

        ::-webkit-scrollbar-thumb {
            background: rgba(148, 163, 184, 0.7);
            border-radius: 999px;
        }
    </style>
    </head>
    <div class="min-h-screen font-sans gap-5 antialiased">
        <div class="pointer-events-none fixed inset-0 -z-10 overflow-hidden">
            <div class="absolute -top-32 left-1/2 h-72 w-72 -translate-x-1/2 rounded-full bg-indigo-600 blur-3xl opacity-40">
            </div>
            <div class="absolute bottom-0 left-0 h-64 w-64 rounded-full bg-indigo-700 blur-3xl opacity-30"></div>
            <div class="absolute bottom-10 right-0 h-72 w-72 rounded-full bg-emerald-600 blur-3xl opacity-30"></div>

        </div>
        <div class="mb-5 md:mb-0 flex items-center justify-between gap-4">
            <h2 class="text-lg md:text-xl text-center min-w-full max-h-fit font-semibold text-black">Jabatan Struktural Yang Sedang Aktif
            </h2>
            <p class="text-white hidden md:flex">
                Urutan kronologis perjalanan desain dari awal hingga saat ini.
            </p>
        </div>
        <main class="flex justify-center pb-5 border-b border-gray-200/70 items-center min-w-full">
            <div class="min-w-full mx-auto flex flex-wrap gap-5 justify-around items-center">
                @for ($i = 0; $i < 2; $i++)
                    <!-- Card 1 - UI/UX Designer -->
                    <div
                        class="card-hover bg-white max-w-64  rounded-3xl overflow-hidden shadow-md transition-all duration-300">
                        <div class="h-32 bg-gradient-to-r from-blue-500 to-indigo-500"></div>
                        <div class="flex flex-col items-center p-6 -mt-16 min-w-40">

                            <!-- UI/UX Icon -->
                            <div
                                class="w-28 h-28 rounded-full bg-gray-200 border-4 border-white shadow-lg flex items-center justify-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-14 h-14 text-gray-500" fill="none"
                                    stroke="currentColor" stroke-width="1.6" viewBox="0 0 24 24">
                                    <path d="M4 6h16M4 12h16M4 18h7" stroke-linecap="round" />
                                </svg>
                            </div>

                            <h2 class="mt-4 text-xl font-semibold text-gray-800">Ayu Pratama</h2>
                            <p class="text-gray-500 text-sm">UI/UX Designer</p>
                            {{-- <p class="text-center text-gray-400 text-xs mt-3">
                                Menghasilkan desain minimalis dan user-friendly.
                            </p> --}}
                        </div>
                    </div>
                @endfor
            </div>
        </main>

        <!-- Main content -->
        <main id="top" class="relative z-10 mx-2 mt-10 max-w-6xl px-0 pb-16">

            <!-- Filter & Legend -->
            <div class="mb-5 flex items-center justify-between gap-4">
                <h2 class="text-lg md:text-xl text-center w-min-full font-semibold text-black">Riwayat Jabatan Struktural
                </h2>
                <p class="text-white hidden md:flex">
                    Urutan kronologis perjalanan desain dari awal hingga saat ini.
                </p>
            </div>
            <section class="mb-6 md:mb-8">
                <div class="flex flex-col items-end justify-between gap-4">
                    <div>
                        <h2 class="text-sm font-semibold text-end text-black mb-1">Filter</h2>
                        <p class="text-xs text-end text-black max-w-md">
                            Gunakan filter kategori untuk fokus pada posisi kerja tertentu dalam riwayat jabatan.
                        </p>
                    </div>
                    <div class="flex flex-wrap gap-2">
                        <button
                            class="history-filter-btn inline-flex items-center gap-1 rounded-full border border-slate-600/80 bg-slate-900/70 px-3 py-1.5 text-[11px] text-slate-200 hover:border-secondary-500/80 data-[active=true]:bg-secondary-600 data-[active=true]:border-secondary-500 data-[active=true]:text-white"
                            data-category="all" data-active="true">
                            Semua
                        </button>
                        <button
                            class="history-filter-btn inline-flex items-center gap-1 rounded-full border border-slate-600/80 bg-slate-900/70 px-3 py-1.5 text-[11px] text-slate-200 hover:border-secondary-500/80"
                            data-category="Bagian">
                            Struktural Bagian
                        </button>
                        <button
                            class="history-filter-btn inline-flex items-center gap-1 rounded-full border border-slate-600/80 bg-slate-900/70 px-3 py-1.5 text-[11px] text-slate-200 hover:border-secondary-500/80"
                            data-category="Program Studi">
                            Struktural Program Studi
                        </button>
                        <button
                            class="history-filter-btn inline-flex items-center gap-1 rounded-full border border-slate-600/80 bg-slate-900/70 px-3 py-1.5 text-[11px] text-slate-200 hover:border-secondary-500/80"
                            data-category="Fakultas">
                            Struktural Fakultas
                        </button>
                    </div>
                </div>
            </section>

            <!-- Timeline -->
            <section id="timeline" class="mb-12 md:mb-16">


                <div class="relative">
                    <!-- Vertical line -->
                    <!-- <div class="absolute left-4 top-0 h-full w-px bg-gradient-to-b from-secondary-500/70 via-slate-700/80 to-transparent md:left-1/2 md:-translate-x-1/2"></div> -->
                    <div
                        class="absolute left-4 top-0 h-full w-px bg-gradient-to-b from-secondary-500/70 via-slate-700/80 to-transparent">
                    </div>

                    <div class="space-y-6">
                        {{-- @for ($i = 0; $i < 4; $i++) --}}
                        @forelse ($user['pengawakans'] as $pemetaan)
                            {{-- <article class="history-item pl-10 mb-5 @if ($pemetaan->tmt_selesai != null) 'opacity-60' @endif  relative " data-category="testing"> --}}
                            <article
                                class="history-item pl-10 mb-5 {{ $pemetaan->tmt_selesai != null ? 'opacity-70' : null }} relative"
                                data-category="{{ $pemetaan->formasi->bagian->type_work_position }}">
                                <div class="mt-4 md:mt-0">

                                    <!-- Bagian Tanggal dengan Icon -->
                                    <div
                                        class="inline-flex items-center gap-2 rounded-full bg-slate-900/80 px-3 py-1 text-white border border-slate-700/80">
                                        <!-- Icon Calendar (Besar) -->


                                        {{ date('F Y', strtotime($pemetaan->tmt_mulai)) }} -
                                        {{ $pemetaan->tmt_selesai == null ? 'Sekarang' : date('F Y', strtotime($pemetaan->tmt_selesai)) }}
                                    </div>

                                    <!-- Jabatan dengan Icon -->
                                    <h3 class="mt-3 text-base font-semibold text-black flex items-center gap-2">
                                        <!-- Icon Briefcase (Lebih Besar dan Bold) -->
                                        {{-- {{ dd($pemetaan->formasi->level_data->icon) }} --}}
                                        <i class="{{ $pemetaan->formasi->level_data->icon }}"></i>

                                        {{ $pemetaan->formasi->nama_formasi }}
                                    </h3>

                                    <p class="mt-1 text-xs text-black">
                                        Menjalankan tugas, fungsi, dan tanggung jawab sesuai jabatan yang ditempati,
                                        termasuk melaksanakan kewajiban kerja, mendukung kelancaran operasional, serta
                                        berkontribusi sesuai peran dalam struktur organisasi tanpa mengubah ruang lingkup
                                        pekerjaan yang telah ditetapkan.
                                    </p>

                                    @if (session('account')['is_admin'] == true)
                                        <div class="flex items-center gap-3 mt-3">
                                            <p class="text-sm font-medium text-gray-800">SK Jabatan:</p>

                                            <button
                                                class="px-3 py-1 text-xs font-semibold bg-blue-100 text-blue-700 rounded-full inline-flex items-center gap-2">
                                                <!-- Icon Document (Besar) -->

                                                <i class="fa-solid fa-file"></i>
                                                SK
                                            </button>
                                        </div>
                                    @endif
                                </div>
                            </article>

                        @empty
                            <p>Belum Ada Riwayat Jabatan</p>
                        @endforelse
                        {{-- @endfor --}}

                    </div>
                </div>
            </section>
        </main>

        <!-- Simple JS -->
        <script>
            function scrollToSection(id) {
                const el = document.getElementById(id);
                if (!el) return;
                window.scrollTo({
                    top: el.offsetTop - 70,
                    behavior: 'smooth'
                });
            }

            // Scroll-to-top button
            const scrollTopBtn = document.getElementById('scroll-to-top');
            if (scrollTopBtn) {
                scrollTopBtn.addEventListener('click', () => {
                    window.scrollTo({
                        top: 0,
                        behavior: 'smooth'
                    });
                });
            }

            // Filter timeline item by category
            const filterButtons = document.querySelectorAll('.history-filter-btn');
            const historyItems = document.querySelectorAll('.history-item');

            filterButtons.forEach(btn => {
                btn.addEventListener('click', () => {
                    const category = btn.getAttribute('data-category');

                    // toggle active state
                    filterButtons.forEach(b => b.setAttribute('data-active', 'false'));
                    btn.setAttribute('data-active', 'true');

                    historyItems.forEach(item => {
                        const itemCat = item.getAttribute('data-category');
                        if (category === 'all' || itemCat === category) {
                            item.classList.remove('opacity-30', 'scale-[0.98]');
                            item.classList.add('transition', 'duration-200');
                        } else {
                            item.classList.add('opacity-30', 'scale-[0.98]');
                        }
                    });
                });
            });
        </script>
    </div>
@endsection
