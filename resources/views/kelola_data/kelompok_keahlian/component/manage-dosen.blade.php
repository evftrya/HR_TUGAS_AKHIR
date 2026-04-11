<div class="max-w-[1400px] mx-auto p-6">
    <header class="mb-10 flex flex-col md:flex-row md:items-center justify-between gap-6 border-b border-gray-100 pb-8">
        <div>
            <h1 class="text-4xl font-bold tracking-tight text-black">Registry Keahlian</h1>
            <p class="text-gray-400 mt-2 text-lg font-medium">Pemetaan kepakaran dosen berdasarkan hirarki kompetensi.
            </p>
        </div>
        <div class="flex items-center gap-3">
            <button id="btn-toggle-panel"
                class="flex items-center gap-3 px-8 py-3 bg-black text-white rounded-full text-sm font-bold hover:bg-gray-800 transition-all shadow-xl active:scale-95">
                <span id="text-toggle-panel">Tutup Panel Plotting</span>
            </button>
        </div>
    </header>

    <div class="flex flex-col lg:flex-row gap-10">
        <aside id="sidebar-panel" class="lg:w-3/12 transition-all duration-500">
            <div class="bg-white rounded-[2.5rem] border border-gray-200 shadow-sm p-8 space-y-8 sticky top-6">
                <div>
                    <h2 class="text-2xl font-bold text-black tracking-tight">Plotting Dosen</h2>
                    <div class="mt-1 h-1 w-12 bg-blue-600 rounded-full"></div>
                </div>
                <div class="space-y-6">
                    <x-form route="{{ route('manage.kelompok-keahlian.dosen-with-kk.store') }}" id="pegawai-input">
                        {{-- <x-islc lbl="Dosen" nm="dosen_id" id="select-dosen">
                            <option value="" disabled selected>Pilih Dosen...</option>
                        </x-islc> --}}
                        {{-- <x-islc lbl="Sub Kelompok Keahlian" nm="sub_kk_id" id="select-subkk">
                            <option value="" disabled selected>Pilih Sub-KK...</option>
                        </x-islc> --}}
                        <div>
                            <label class="block text-sm font-bold mb-2 text-gray-700">Nama Dosen</label>
                            <select id="select-dosen" name="dosen_id"
                                class="w-full p-4 bg-gray-50 border border-gray-200 rounded-2xl outline-none focus:ring-2 focus:ring-blue-500 transition-all">
                                <option value="" disabled selected>Pilih Dosen...</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-bold mb-2 text-gray-700">Tujuan Sub-KK</label>
                            <select id="select-subkk" name="sub_kk_id"
                                class="w-full p-4 bg-gray-50 border border-gray-200 rounded-2xl outline-none focus:ring-2 focus:ring-blue-500 transition-all">
                                <option value="" disabled selected>Pilih Sub-KK...</option>
                            </select>
                        </div>
                    </x-form>
                    {{-- <button
                        class="w-full bg-[#0071E3] text-white py-4 rounded-2xl font-bold shadow-lg hover:bg-blue-600 transition-all active:scale-95">
                        Konfirmasi Plotting
                    </button> --}}
                </div>
            </div>
        </aside>

        <main id="main-content" class="w-full lg:w-9/12 transition-all duration-700">
            <div class="relative mb-10 group">
                <input type="text" id="search-input" placeholder="Cari nama dosen, prodi, atau spesialisasi..."
                    class="w-full pl-16 pr-8 py-6 bg-white border border-gray-200 rounded-[1.5rem] outline-none focus:ring-4 focus:ring-blue-50 focus:border-[#0071E3] transition-all text-xl shadow-sm font-medium">
            </div>

            <div id="registry-container" class="space-y-8"></div>
        </main>
    </div>
</div>

<template id="tmpl-fakultas">
    <section class="bg-white rounded-3xl border border-gray-100 shadow-sm overflow-hidden mb-6">
        <div
            class="fak-header p-8 flex items-center justify-between cursor-pointer hover:bg-gray-50 transition-colors group">
            <div class="flex items-center gap-6">
                <div class="bar-status w-2 h-10 bg-black rounded-sm group-hover:bg-[#0071E3] transition-colors"></div>
                <h3 class="fak-name text-2xl font-black text-black tracking-tight"></h3>
            </div>
            <div class="bg-gray-100 p-2.5 rounded-full text-gray-400">
                <svg class="icon-arrow w-5 h-5 transition-transform duration-500" fill="none" stroke="currentColor"
                    viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7"></path>
                </svg>
            </div>
        </div>
        <div class="fak-body px-8 pb-8 space-y-6 hidden"></div>
    </section>
</template>

<template id="tmpl-kk">
    <div class="bg-gray-50 rounded-2xl p-6 border border-gray-100 shadow-xs mb-4">
        <div class="kk-header cursor-pointer flex justify-between items-center group">
            <div>
                <h4 class="kk-name text-xl font-bold text-black group-hover:text-blue-600 transition-colors"></h4>
                <span
                    class="kk-code text-[10px] font-black text-gray-400 tracking-widest uppercase mt-1 inline-block bg-white px-2 py-0.5 rounded shadow-xs border border-gray-100"></span>
            </div>
            <svg class="icon-kk-arrow w-5 h-5 text-gray-400 transition-transform duration-300" fill="none"
                stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7"></path>
            </svg>
        </div>
        <div class="kk-body space-y-6 mt-6 hidden"></div>
    </div>
</template>

<template id="tmpl-sub">
    <div class="bg-white rounded-2xl p-6 border border-gray-100 shadow-sm">
        <div
            class="sub-header flex justify-between items-center mb-6 pb-4 border-b border-gray-50 cursor-pointer group">
            <div>
                <p class="sub-name font-bold text-gray-800 text-base group-hover:text-blue-500 transition-colors"></p>
                <p class="sub-code text-[10px] font-bold text-[#0071E3] uppercase tracking-wide"></p>
            </div>
            <svg class="icon-sub-arrow w-4 h-4 text-gray-300 transition-transform duration-300" fill="none"
                stroke="currentColor" viewBox="0 0 24 24">
                <path d="M19 9l-7 7-7-7" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" />
            </svg>
        </div>
        <div class="sub-body grid gap-4 grid-cols-1 md:grid-cols-2 xl:grid-cols-3 hidden"></div>
    </div>
</template>

<template id="tmpl-dosen">
    <div
        class="flex flex-col items-center text-center p-5 bg-gray-50/50 rounded-2xl border border-transparent hover:border-blue-100 transition-all hover:shadow-md">
        <img class="dosen-foto w-16 h-16 rounded-2xl object-cover border-2 border-white shadow-sm mb-3">
        <span class="dosen-nama text-sm font-bold text-gray-800 leading-tight"></span>
        <span class="dosen-prodi text-[10px] text-gray-400 font-medium mt-1 uppercase tracking-wider"></span>

        <a href=""
            class="btn-lepas-plotting mt-4 text-[10px] font-bold text-red-500 hover:text-red-700 transition-colors border border-red-100 px-3 py-1 rounded-full hover:bg-red-50">
            Lepas Plotting
        </a>
    </div>
</template>

<script>
    const database = @json($database);

    document.addEventListener('DOMContentLoaded', () => {
        const container = document.getElementById('registry-container');
        const searchInput = document.getElementById('search-input');
        const btnToggle = document.getElementById('btn-toggle-panel');
        const sidebar = document.getElementById('sidebar-panel');
        const mainContent = document.getElementById('main-content');
        const textToggle = document.getElementById('text-toggle-panel');
        const selectDosen = document.getElementById('select-dosen');
        // Letakkan ini di bagian atas script
        const urlLepasPlotting =
            "{{ route('manage.kelompok-keahlian.dosen-with-kk.lepas-dosen', ':DosenHasKK_id') }}";
        // console.log(selectDosen)
        const selectSubKK = document.getElementById('select-subkk');

        function render(query = '') {
            container.innerHTML = '';
            const q = query.toLowerCase().trim();

            database.forEach(fak => {
                const matchedKks = fak.kks.filter(kk => {
                    const kkMatch = kk.name.toLowerCase().includes(q) || kk.code.toLowerCase()
                        .includes(q);
                    const subMatch = kk.subs.some(sub =>
                        sub.name.toLowerCase().includes(q) ||
                        sub.dosens.some(d => d.nama.toLowerCase().includes(q))
                    );
                    return kkMatch || subMatch;
                });

                if (q && !fak.name.toLowerCase().includes(q) && matchedKks.length === 0) return;

                const fakTmpl = document.getElementById('tmpl-fakultas').content.cloneNode(true);
                const fakBody = fakTmpl.querySelector('.fak-body');
                const fakHeader = fakTmpl.querySelector('.fak-header');
                const fakArrow = fakTmpl.querySelector('.icon-arrow');

                fakTmpl.querySelector('.fak-name').textContent = fak.name;

                matchedKks.forEach(kk => {
                    const kkTmpl = document.getElementById('tmpl-kk').content.cloneNode(true);
                    const kkBody = kkTmpl.querySelector('.kk-body');
                    const kkHeader = kkTmpl.querySelector('.kk-header');
                    const kkArrow = kkTmpl.querySelector('.icon-kk-arrow');

                    kkTmpl.querySelector('.kk-name').textContent = kk.name;
                    kkTmpl.querySelector('.kk-code').textContent = kk.code;

                    kk.subs.forEach(sub => {
                        const filteredDosens = q ? sub.dosens.filter(d =>
                            d.nama.toLowerCase().includes(q) ||
                            sub.name.toLowerCase().includes(q) ||
                            kk.name.toLowerCase().includes(q)
                        ) : sub.dosens;

                        if (q && filteredDosens.length === 0 && !sub.name.toLowerCase()
                            .includes(q)) return;

                        const subTmpl = document.getElementById('tmpl-sub').content
                            .cloneNode(true);
                        const subBody = subTmpl.querySelector('.sub-body');
                        const subHeader = subTmpl.querySelector('.sub-header');
                        const subArrow = subTmpl.querySelector('.icon-sub-arrow');

                        subTmpl.querySelector('.sub-name').textContent = sub.name;
                        subTmpl.querySelector('.sub-code').textContent = sub.code;

                        filteredDosens.forEach(dosen => {
                            const dsnTmpl = document.getElementById(
                                'tmpl-dosen').content.cloneNode(true);
                            dsnTmpl.querySelector('.dosen-nama').textContent =
                                dosen.nama;
                            dsnTmpl.querySelector('.dosen-prodi').textContent =
                                dosen.prodi;
                            dsnTmpl.querySelector('.dosen-foto').src = dosen
                                .foto;

                            // Set route berbeda untuk tiap tombol berdasarkan data dosen
                            // Ganti 'dosen.id' sesuai dengan key ID yang kamu kirim dari database
                            const finalUrl = urlLepasPlotting.replace(
                                ':DosenHasKK_id', dosen.id_pemetaan);
                            dsnTmpl.querySelector('.btn-lepas-plotting').href =
                                finalUrl;

                            subBody.appendChild(dsnTmpl);
                        });

                        subHeader.onclick = (e) => {
                            e.stopPropagation();
                            const subIsHidden = subBody.classList.toggle('hidden');
                            subArrow.classList.toggle('rotate-180', !subIsHidden);
                        };

                        if (q) {
                            subBody.classList.remove('hidden');
                            subArrow.classList.add('rotate-180');
                        }

                        kkBody.appendChild(subTmpl);
                    });

                    kkHeader.onclick = (e) => {
                        e.stopPropagation();
                        const kkIsHidden = kkBody.classList.toggle('hidden');
                        kkArrow.classList.toggle('rotate-180', !kkIsHidden);
                    };

                    if (q) {
                        kkBody.classList.remove('hidden');
                        kkArrow.classList.add('rotate-180');
                    }

                    fakBody.appendChild(kkTmpl);
                });

                // LOGIKA AUTO OPEN SEMUA ANAK SAAT FAKULTAS DIKLIK
                fakHeader.onclick = () => {
                    const isHidden = fakBody.classList.toggle('hidden');
                    fakArrow.classList.toggle('rotate-180', !isHidden);
                    fakHeader.querySelector('.bar-status').classList.toggle('bg-[#0071E3]', !
                        isHidden);

                    if (!isHidden) {
                        // Buka semua KK
                        fakBody.querySelectorAll('.kk-body').forEach(kb => kb.classList.remove(
                            'hidden'));
                        fakBody.querySelectorAll('.icon-kk-arrow').forEach(ka => ka.classList.add(
                            'rotate-180'));

                        // Buka semua Sub-KK
                        fakBody.querySelectorAll('.sub-body').forEach(sb => sb.classList.remove(
                            'hidden'));
                        fakBody.querySelectorAll('.icon-sub-arrow').forEach(sa => sa.classList.add(
                            'rotate-180'));
                    }
                };

                if (q) {
                    fakBody.classList.remove('hidden');
                    fakArrow.classList.add('rotate-180');
                }

                container.appendChild(fakTmpl);
            });
        }

        function initDropdowns() {
            const allDosens = [];
            // Mengambil data dari PHP dan memastikan menjadi Array
            const dosen = Object.values(@json($dosen));

            // Melakukan sortir berdasarkan nama_lengkap di dalam pegawai_aktif
            dosen.sort((a, b) => {
                const namaA = a.pegawai_aktif?.nama_lengkap?.toLowerCase() || '';
                const namaB = b.pegawai_aktif?.nama_lengkap?.toLowerCase() || '';
                return namaA.localeCompare(namaB);
            }).forEach(dozen => { // Tambahkan => di sini
                allDosens.push(dozen);
            });

            // console.log(allDosens);
            allDosens.forEach(dosen => {
                console.log(dosen.pegawai_aktif.nama_lengkap, 'nama')
                const opt = document.createElement('option');
                opt.value = dosen.id;
                opt.textContent = dosen.pegawai_aktif.nama_lengkap;
                selectDosen.appendChild(opt);
            });

            database.forEach(fak => {
                const group = document.createElement('optgroup');
                group.label = fak.name;
                fak.kks.forEach(kk => {
                    kk.subs.forEach(sub => {
                        const opt = document.createElement('option');
                        opt.value = sub.id;
                        opt.textContent = `${kk.name} - ${sub.name}`;
                        group.appendChild(opt);
                    });
                });
                selectSubKK.appendChild(group);
            });
        }

        searchInput.addEventListener('input', (e) => render(e.target.value));

        let isPanelVisible = true;
        btnToggle.onclick = () => {
            isPanelVisible = !isPanelVisible;
            sidebar.classList.toggle('hidden', !isPanelVisible);
            sidebar.classList.toggle('w-full', !isPanelVisible);
            sidebar.classList.toggle('w-full lg:w-3/12', !isPanelVisible);
            mainContent.classList.toggle('w-full lg:w-9/12', isPanelVisible);
            mainContent.classList.toggle('w-full', !isPanelVisible);
            textToggle.textContent = isPanelVisible ? 'Tutup Panel Plotting' : 'Buka Panel Plotting';
        };

        initDropdowns();
        render();

        document.addEventListener('click', function(e) {
            // Cek apakah yang diklik adalah tombol Lepas Plotting
            if (e.target.closest('.btn-lepas-plotting')) {
                e.preventDefault(); // Hentikan link agar tidak langsung pindah halaman

                const link = e.target.closest('.btn-lepas-plotting');
                const href = link.getAttribute('href');

                Swal.fire({
                    title: 'Apakah Anda yakin?',
                    text: "Dosen ini akan dilepas dari plotting kelompok keahlian!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#ef4444', // Warna merah (sesuai tema button kamu)
                    cancelButtonColor: '#6b7280',
                    confirmButtonText: 'Ya, Lepaskan!',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Jika user klik "Ya", arahkan ke URL tujuan
                        window.location.href = href;
                    }
                });
            }
        });

        // function konfirmasiLepas(event, element) {
        //     // 1. Tahan link supaya gak langsung pindah
        //     event.preventDefault();

        //     // 2. Ambil URL-nya
        //     const url = element.getAttribute('href');

        //     // 3. Munculkan SweetAlert
        //     Swal.fire({
        //         title: 'Yakin mau dilepas?',
        //         icon: 'warning',
        //         showCancelButton: true,
        //         confirmButtonColor: '#d33',
        //         confirmButtonText: 'Ya, Lepas!',
        //         cancelButtonText: 'Batal'
        //     }).then((result) => {
        //         if (result.isConfirmed) {
        //             // 4. Kalau "Ya", baru pindah halaman
        //             window.location.href = url;
        //         }
        //     });
        // }
    });
</script>
