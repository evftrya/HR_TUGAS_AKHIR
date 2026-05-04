<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    {{-- <script src="https://cdn.tailwindcss.com"></script> --}}
    <style>
        @keyframes subtle-pulse {
            0% {
                transform: scale(1);
                box-shadow: 0 0 0 0 rgba(37, 99, 235, 0.4);
            }

            70% {
                transform: scale(1.05);
                box-shadow: 0 0 0 10px rgba(37, 99, 235, 0);
            }

            100% {
                transform: scale(1);
                box-shadow: 0 0 0 0 rgba(37, 99, 235, 0);
            }
        }

        .animate-attention {
            animation: subtle-pulse 2s infinite;
        }
    </style>
</head>

<body class="bg-slate-50">

    <div class="max-w-6xl mt-5 mx-auto my-12 px-4 font-sans antialiased text-slate-800">
        <div class="bg-white border border-slate-200 rounded-2xl shadow-xl overflow-hidden">

            <div class="p-10 bg-gradient-to-r from-blue-50 to-white border-b border-slate-100">
                <h1 class="text-3xl font-bold text-slate-900">Halo, Rekan Penguji 👋</h1>
                <p class="mt-3 text-lg text-slate-600 leading-relaxed max-w-3xl">
                    Silakan klik tombol biru beranimasi untuk langsung menuju halaman fitur yang akan diuji. Terima
                    kasih
                    atas bantuan Anda!
                </p>

                <div class="mt-6 flex flex-wrap items-center gap-4">
                    <div
                        class="flex items-center gap-2 px-4 py-2 bg-blue-100 text-blue-700 rounded-full text-sm font-semibold shadow-sm">
                        <span class="flex h-2 w-2 rounded-full bg-blue-500 animate-ping"></span>
                        Sistem Navigasi Otomatis Aktif
                    </div>
                </div>

                <!-- Filter Kategori -->
                <div class="mt-8 flex flex-wrap gap-2" id="filter-container">
                    <button onclick="filterCategory('KEPEGAWAIAN')" class="filter-btn px-4 py-2 rounded-full text-sm font-bold bg-slate-800 text-white transition-colors" data-cat="KEPEGAWAIAN">Data Kepegawaian</button>
                    <button onclick="filterCategory('KINERJA PEGAWAI')" class="filter-btn px-4 py-2 rounded-full text-sm font-bold bg-slate-200 text-slate-600 hover:bg-slate-300 transition-colors" data-cat="KINERJA PEGAWAI">Kinerja Pegawai</button>
                    <button onclick="filterCategory('DUPAK DOSEN')" class="filter-btn px-4 py-2 rounded-full text-sm font-bold bg-slate-200 text-slate-600 hover:bg-slate-300 transition-colors" data-cat="DUPAK DOSEN">DUPAK Dosen</button>
                </div>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead>
                        <tr class="bg-slate-50 border-b border-slate-200">
                            <th class="p-6 text-xs font-bold uppercase tracking-widest text-slate-400">Urutan</th>
                            <th class="p-6 text-xs font-bold uppercase tracking-widest text-slate-500">Kategori & Peran
                            </th>
                            <th class="p-6 text-xs font-bold uppercase tracking-widest text-slate-500">Kegiatan
                                Pengujian</th>
                            <th class="p-6 text-xs font-bold uppercase tracking-widest text-slate-500">Catatan</th>
                            <th class="p-6 text-xs font-bold uppercase tracking-widest text-slate-500 text-center">
                                Tindakan</th>
                        </tr>
                    </thead>
                    <tbody id="content-table-body" class="divide-y divide-slate-100">
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script>
        const activityData = [{
                id: 1,
                cat: "LOGIN",
                desc: "Mencoba masuk sebagai Tamu",
                role: "Tamu",
                route: "{{ route('login') }}",
                note: "Gunakan mode incognito"
            },
            {
                id: 2,
                cat: "KEPEGAWAIAN",
                desc: "Menambahkan jenis status pegawai baru",
                role: "Admin",
                route: "{{ route('manage.status-pegawai.list') }}",
                note: ""
            },
            {
                id: 3,
                cat: "KEPEGAWAIAN",
                desc: "Melihat daftar status pegawai",
                role: "Admin",
                route: "{{ route('manage.status-pegawai.list') }}",
                note: ""
            },
            {
                id: 4,
                cat: "KEPEGAWAIAN",
                desc: "Memperbarui data status pegawai",
                role: "Admin",
                route: "{{ route('manage.status-pegawai.list') }}",
                note: ""
            },
            {
                id: 5,
                cat: "BAGIAN KERJA",
                desc: "Menambahkan unit kerja baru",
                role: "Admin",
                route: "{{ route('manage.bagian.new') }}",
                note: "Cek validasi nama unit"
            },
            {
                id: 6,
                cat: "BAGIAN KERJA",
                desc: "Melihat daftar unit kerja yang ada",
                role: "Admin",
                route: "{{ route('manage.bagian.list') }}",
                note: ""
            },
            {
                id: 7,
                cat: "BAGIAN KERJA",
                desc: "Mengubah informasi unit kerja",
                role: "Admin",
                route: "{{ route('manage.bagian.list') }}",
                note: ""
            },
            {
                id: 8,
                cat: "FAKULTAS",
                desc: "Menambahkan data fakultas baru",
                role: "Admin",
                route: "{{ route('manage.fakultas.create') }}",
                note: ""
            },
            {
                id: 9,
                cat: "FAKULTAS",
                desc: "Melihat daftar seluruh fakultas",
                role: "Admin",
                route: "{{ route('manage.fakultas.index') }}",
                note: ""
            },
            {
                id: 10,
                cat: "FAKULTAS",
                desc: "Memperbarui rincian fakultas",
                role: "Admin",
                route: "{{ route('manage.fakultas.index') }}",
                note: ""
            },
            {
                id: 11,
                cat: "PRODI",
                desc: "Menambahkan program studi baru",
                role: "Admin",
                route: "{{ route('manage.prodi.create') }}",
                note: ""
            },
            {
                id: 12,
                cat: "PRODI",
                desc: "Melihat daftar program studi",
                role: "Admin",
                route: "{{ route('manage.prodi.index') }}",
                note: ""
            },
            {
                id: 13,
                cat: "PRODI",
                desc: "Mengubah detail program studi",
                role: "Admin",
                route: "{{ route('manage.prodi.index') }}",
                note: ""
            },
            {
                id: 14,
                cat: "LEVEL",
                desc: "Membuat tingkatan atau level struktur jabatan baru",
                role: "Admin",
                route: "{{ route('manage.level.new') }}",
                note: ""
            },
            {
                id: 15,
                cat: "LEVEL",
                desc: "Mengubah pengaturan tingkatan akses",
                role: "Admin",
                route: "{{ route('manage.level.list') }}",
                note: ""
            },
            {
                id: 18,
                cat: "FORMASI",
                desc: "Menambahkan rencana formasi baru",
                role: "Admin",
                route: "{{ route('manage.formasi.new') }}",
                note: ""
            },
            {
                id: 19,
                cat: "FORMASI",
                desc: "Melihat daftar rencana formasi",
                role: "Admin",
                route: "{{ route('manage.formasi.list') }}",
                note: ""
            },
            {
                id: 20,
                cat: "FORMASI",
                desc: "Melihat rincian formasi kerja",
                role: "Admin",
                route: "{{ route('manage.formasi.list') }}",
                note: ""
            },
            {
                id: 21,
                cat: "FORMASI",
                desc: "Mengubah data formasi kerja",
                role: "Admin",
                route: "{{ route('manage.formasi.list') }}",
                note: ""
            },
            {
                id: 22,
                cat: "PEGAWAI",
                desc: "Mendaftarkan pegawai baru ke sistem",
                role: "Admin",
                route: "{{ route('manage.pegawai.new') }}",
                note: ""
            },
            {
                id: 23,
                cat: "PEGAWAI",
                desc: "Melihat daftar pegawai yang aktif",
                role: "Admin",
                route: "{{ route('manage.pegawai.list', ['destination' => 'Active']) }}",
                note: "Klik tombol 'Active'"
            },
            {
                id: 24,
                cat: "PEGAWAI",
                desc: "Memberikan izin akses Admin",
                role: "Kaur SDM",
                route: "{{ route('manage.pegawai.list', ['destination' => 'Active']) }}",
                note: "klik titik tiga dipaling kanan > pilih 'Jadikan Admin' atau View Details > Berikan Hak Akses Admin "
            },
            {
                id: 25,
                cat: "PEGAWAI",
                desc: "Memperbarui data pribadi pegawai",
                role: "Admin",
                route: "{{ route('manage.pegawai.view.personal-info', ['idUser' => '$id']) }}",
                note: "klik View Details > klik 'ubah data' pada bagian 'Data Personal'"
            },
            {
                id: 26,
                cat: "PEGAWAI",
                desc: "Menonaktifkan status pegawai",
                role: "Admin",
                route: "{{ route('manage.pegawai.list', ['destination' => 'Active']) }}",
                note: ""
            },
            {
                id: 27,
                cat: "PEGAWAI",
                desc: "Melihat pegawai sesuai unit kerja",
                role: "Admin & Pimpinan",
                route: "{{ route('manage.pegawai.list', ['destination' => 'Active']) }}",
                note: ""
            },
            {
                id: 29,
                cat: "KONTAK DARURAT",
                desc: "Menambahkan nomor kontak darurat",
                role: "Admin & Pegawai",
                route: "{{ route('profile.emergency-contacts.list', ['id_User' => '$id']) }}",
                note: ""
            },
            {
                id: 30,
                cat: "KONTAK DARURAT",
                desc: "Melihat informasi kontak darurat",
                role: "Admin & Pegawai",
                route: "{{ route('profile.emergency-contacts.list', ['id_User' => '$id']) }}",
                note: ""
            },
            {
                id: 31,
                cat: "KONTAK DARURAT",
                desc: "Memperbarui nomor kontak darurat",
                role: "Admin & Pegawai",
                route: "{{ route('profile.emergency-contacts.list', ['id_User' => '$id']) }}",
                note: ""
            },
            {
                id: 32,
                cat: "DATA NIP",
                desc: "Menambahkan nomor induk pegawai (NIP)",
                role: "Admin",
                route: "{{ route('manage.riwayat-nip.new') }}",
                note: ""
            },
            {
                id: 33,
                cat: "DATA NIP",
                desc: "Melihat riwayat perubahan NIP",
                role: "Admin & Pemilik Data",
                route: "{{ route('profile.history.nip', ['id_pegawai' => '$id']) }}",
                note: ""
            },
            {
                id: 34,
                cat: "DATA NIP",
                desc: "Melihat nomor NIP saat ini",
                role: "Admin & Pemilik Data",
                route: "{{ route('profile.history.nip', ['id_pegawai' => '$id']) }}",
                note: ""
            },
            {
                id: 35,
                cat: "DATA NIP",
                desc: "Memperbarui nomor NIP",
                role: "Admin",
                route: "{{ route('manage.riwayat-nip.new') }}",
                note: ""
            },
            {
                id: 36,
                cat: "KELUAR",
                desc: "Keluar dari aplikasi (Selesai)",
                role: "Pegawai",
                route: "/logout",
                note: "Sesi akan berakhir"
            },
            // --- KINERJA PEGAWAI TESTS ---
            {
                id: 101,
                cat: "KINERJA PEGAWAI",
                desc: "Melihat dashboard Beranda Kinerja",
                role: "Admin SDM",
                route: "{{ route('manage.target-kinerja.index') }}",
                note: "Pastikan Anda login sebagai Admin SDM"
            },
            {
                id: 103,
                cat: "KINERJA PEGAWAI",
                desc: "Membuat Target Kinerja Baru (KPI)",
                role: "Admin SDM",
                route: "{{ route('manage.target-kinerja.input') }}",
                note: "Isi data KPI dan simpan"
            },
            {
                id: 104,
                cat: "KINERJA PEGAWAI",
                desc: "Membuat Target Harian dan Auto-Assign",
                role: "Pegawai",
                route: "{{ route('manage.target-kinerja.harian.list') }}",
                note: "Nyamar jadi Pegawai dan klik Tambah"
            },
            {
                id: 105,
                cat: "KINERJA PEGAWAI",
                desc: "Melihat riwayat Presensi Personal",
                role: "Pegawai",
                route: "{{ route('manage.presensi.index') }}",
                note: "Nyamar jadi Pegawai"
            },
            {
                id: 106,
                cat: "KINERJA PEGAWAI",
                desc: "Melakukan Approval Laporan Pekerjaan",
                role: "Atasan",
                route: "{{ route('manage.target-kinerja.harian.reports') }}",
                note: "Nyamar jadi Atasan"
            },
            {
                id: 107,
                cat: "KINERJA PEGAWAI",
                desc: "Memantau Leaderboard & SLA Global",
                role: "Pimpinan",
                route: "{{ route('manage.target-kinerja.harian.reports') }}",
                note: "Nyamar jadi Pimpinan, amati widget SLA"
            },
            {
                id: 108,
                cat: "KINERJA PEGAWAI",
                desc: "Mengubah Pengaturan Jam Kerja/Toleransi",
                role: "Admin SDM",
                route: "{{ route('manage.presensi.settings') }}",
                note: "Mode Admin SDM"
            },
            {
                id: 109,
                cat: "KINERJA PEGAWAI",
                desc: "Melihat Laporan Keterlambatan",
                role: "Admin SDM",
                route: "{{ route('manage.presensi.tardiness') }}",
                note: "Melihat siapa saja yang sering telat"
            },
            {
                id: 110,
                cat: "KINERJA PEGAWAI",
                desc: "Melihat Log Monitoring Aktivitas",
                role: "Admin SDM",
                route: "{{ route('manage.monitoring.index') }}",
                note: "Melihat aktivitas pengguna di dalam modul ini"
            },
            {
                id: 111,
                cat: "KINERJA PEGAWAI",
                desc: "Melihat Rekap Performa Tahunan / Makro",
                role: "Pimpinan",
                route: "{{ route('manage.target-kinerja.laporan') }}",
                note: "Nyamar jadi Pimpinan"
            },
            {
                id: 112,
                cat: "KINERJA PEGAWAI",
                desc: "Mengekspor Laporan Harian (PDF/Excel)",
                role: "Admin / Atasan",
                route: "{{ route('manage.target-kinerja.harian.list') }}",
                note: "Klik tombol merah/hijau di pojok kanan atas"
            },
            {
                id: 113,
                cat: "KINERJA PEGAWAI",
                desc: "Assign (Menugaskan) Target KPI ke Pegawai",
                role: "Admin / Atasan",
                route: "{{ route('manage.target-kinerja.list') }}",
                note: "Klik tombol Tambah Orang (Assign) pada salah satu KPI"
            }
        ];

        activityData.sort((a, b) => a.id - b.id);

        function renderTable(data) {
            const tableBody = document.getElementById('content-table-body');
            tableBody.innerHTML = '';
            
            data.forEach(item => {
                const row = `
                <tr class="hover:bg-blue-50/50 transition-colors group">
                    <td class="p-6 text-sm font-bold text-slate-400">#${item.id}</td>
                    <td class="p-6">
                        <span class="text-sm font-bold text-slate-800 tracking-tight uppercase">${item.cat}</span>
                        <br><span class="text-[10px] text-blue-600 font-bold uppercase tracking-wider">${item.role}</span>
                    </td>
                    <td class="p-6">
                        <p class="text-sm text-slate-600 font-medium">${item.desc}</p>
                    </td>
                    <td class="p-6">
                        <p class="text-xs text-slate-500 italic">${item.note ? item.note : ''}</p>
                    </td>
                    <td class="p-6 text-center">
                        <a href="${item.route}" class="animate-attention inline-block bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-8 rounded-full shadow-lg transition-all active:scale-95">
                            <span class="text-xs tracking-widest">CEK SEKARANG</span>
                        </a>
                    </td>
                </tr>
            `;
                tableBody.innerHTML += row;
            });
        }

        function filterCategory(category) {
            // Update button styles
            const buttons = document.querySelectorAll('.filter-btn');
            buttons.forEach(btn => {
                if (btn.getAttribute('data-cat') === category) {
                    btn.classList.remove('bg-slate-200', 'text-slate-600', 'hover:bg-slate-300');
                    btn.classList.add('bg-slate-800', 'text-white');
                } else {
                    btn.classList.remove('bg-slate-800', 'text-white');
                    btn.classList.add('bg-slate-200', 'text-slate-600', 'hover:bg-slate-300');
                }
            });

            // Filter data
            let filteredData = [];
            if (category === 'ALL') {
                filteredData = activityData;
            } else if (category === 'KEPEGAWAIAN') {
                // Kepegawaian mencakup semua tugas selain Kinerja Pegawai dan DUPAK
                filteredData = activityData.filter(item => item.cat !== 'KINERJA PEGAWAI' && item.cat !== 'DUPAK DOSEN');
            } else if (category === 'KINERJA PEGAWAI') {
                filteredData = activityData.filter(item => item.cat === 'KINERJA PEGAWAI');
            } else if (category === 'DUPAK DOSEN') {
                // DUPAK Dosen kosong sesuai permintaan
                filteredData = [];
            }
            
            renderTable(filteredData);
        }

        // Initial render
        filterCategory('KEPEGAWAIAN');
    </script>

</body>

</html>
