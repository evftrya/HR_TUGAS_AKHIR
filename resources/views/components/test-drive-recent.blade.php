<div class="max-w-6xl mt-5 mx-auto my-12 px-4 font-sans antialiased text-slate-800">
    <div class="bg-white border border-slate-200 rounded-2xl shadow-xl overflow-hidden">

        <div class="p-10 bg-gradient-to-r from-blue-50 to-white border-b border-slate-100">
            <h1 class="text-3xl font-bold text-slate-900">Halo, Rekan Penguji 👋</h1>
            <p class="mt-3 text-lg text-slate-600 leading-relaxed max-w-3xl">
                Silakan klik tombol biru beranimasi untuk langsung menuju halaman fitur yang akan diuji. Terima kasih
                atas bantuan Anda!
            </p>

            <div class="mt-6 flex flex-wrap items-center gap-4">
                <div
                    class="flex items-center gap-2 px-4 py-2 bg-blue-100 text-blue-700 rounded-full text-sm font-semibold shadow-sm">
                    <span class="flex h-2 w-2 rounded-full bg-blue-500 animate-ping"></span>
                    Sistem Navigasi Otomatis Aktif
                </div>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead>
                    <tr class="bg-slate-50 border-b border-slate-200">
                        <th class="p-6 text-xs font-bold uppercase tracking-widest text-slate-400">Urutan</th>
                        <th class="p-6 text-xs font-bold uppercase tracking-widest text-slate-500">Kategori & Peran</th>
                        <th class="p-6 text-xs font-bold uppercase tracking-widest text-slate-500">Kegiatan Pengujian
                        </th>
                        <th class="p-6 text-xs font-bold uppercase tracking-widest text-slate-500 text-center">Tindakan
                        </th>
                    </tr>
                </thead>
                <tbody id="content-table-body" class="divide-y divide-slate-100">
                </tbody>
            </table>
        </div>
    </div>
</div>

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

<script>
    // Tambahkan URL rute Anda di field 'route' di bawah ini
    const activityData = [

        {
            id: 1,
            cat: "LOGIN",
            desc: "Mencoba masuk sebagai Tamu",
            role: "Tamu",
            route: "/login"
        },
        {
            id: 2,
            cat: "KEPEGAWAIAN",
            desc: "Menambahkan jenis status pegawai baru",
            role: "Admin",
            route: "/admin/status/create"
        },
        {
            id: 3,
            cat: "KEPEGAWAIAN",
            desc: "Melihat daftar status pegawai",
            role: "Admin",
            route: "/admin/status"
        },
        {
            id: 4,
            cat: "KEPEGAWAIAN",
            desc: "Memperbarui data status pegawai",
            role: "Admin",
            route: "/admin/status/edit"
        },
        {
            id: 5,
            cat: "BAGIAN KERJA",
            desc: "Menambahkan unit kerja baru",
            role: "Admin",
            route: "/admin/unit/create"
        },
        {
            id: 6,
            cat: "BAGIAN KERJA",
            desc: "Melihat daftar unit kerja yang ada",
            role: "Admin",
            route: "/admin/unit"
        },
        {
            id: 7,
            cat: "BAGIAN KERJA",
            desc: "Mengubah informasi unit kerja",
            role: "Admin",
            route: "/admin/unit/edit"
        },
        {
            id: 8,
            cat: "FAKULTAS",
            desc: "Menambahkan data fakultas baru",
            role: "Admin",
            route: "{{ route('manage.fakultas.create') }}"
        },
        {
            id: 9,
            cat: "FAKULTAS",
            desc: "Melihat daftar seluruh fakultas",
            role: "Admin",
            route: "{{ route('manage.fakultas.index') }}"
        },
        {
            id: 10,
            cat: "FAKULTAS",
            desc: "Memperbarui rincian fakultas",
            role: "Admin",
            route: "{{ route('manage.fakultas.index') }}"
        },
        {
            id: 11,
            cat: "PRODI",
            desc: "Menambahkan program studi baru",
            role: "Admin",
            route: "{{ route('manage.prodi.create') }}"
        },
        {
            id: 12,
            cat: "PRODI",
            desc: "Melihat daftar program studi",
            role: "Admin",
            route: "{{ route('manage.prodi.index') }}"
        },
        {
            id: 13,
            cat: "PRODI",
            desc: "Mengubah detail program studi",
            role: "Admin",
            route: "{{ route('manage.prodi.index') }}"
        },
        {
            id: 14,
            cat: "LEVEL AKSES",
            desc: "Membuat tingkatan akses baru",
            role: "Admin",
            route: "{{ route('manage.level.new') }}"
        },
        {
            id: 15,
            cat: "LEVEL AKSES",
            desc: "Mengubah pengaturan tingkatan akses",
            role: "Admin",
            route: "{{ route('manage.level.list') }}"
        },
        {
            id: 16,
            cat: "LEVEL AKSES",
            desc: "Melihat daftar seluruh tingkatan akses",
            role: "Admin",
            route: "{{ route('manage.level.list') }}"
        },
        {
            id: 17,
            cat: "LEVEL AKSES",
            desc: "Melihat rincian satu tingkat akses",
            role: "Admin",
            route: "{{ route('manage.level.list') }}"
        },
        {
            id: 18,
            cat: "FORMASI",
            desc: "Menambahkan rencana formasi baru",
            role: "Admin",
            route: "{{ route('manage.formasi.new') }}"
        },
        {
            id: 19,
            cat: "FORMASI",
            desc: "Melihat daftar rencana formasi",
            role: "Admin",
            route: "{{ route('manage.formasi.list') }}"
        },
        {
            id: 20,
            cat: "FORMASI",
            desc: "Melihat rincian formasi kerja",
            role: "Admin",
            route: "{{ route('manage.formasi.list') }}"
        },
        {
            id: 21,
            cat: "FORMASI",
            desc: "Mengubah data formasi kerja",
            role: "Admin",
            route: "{{ route('manage.formasi.list') }}"
        },
        {
            id: 22,
            cat: "PEGAWAI",
            desc: "Mendaftarkan pegawai baru ke sistem",
            role: "Admin",
            route: "{{ route('manage.pegawai.new') }}"
        },
        {
            id: 23,
            cat: "PEGAWAI",
            desc: "Melihat daftar pegawai yang aktif",
            role: "Admin",
            route: "{{ route('manage.pegawai.list', ['destination' => 'Active']) }}"
        },
        {
            id: 24,
            cat: "PEGAWAI",
            desc: "Memberikan izin akses Admin",
            role: "Kaur SDM",
            route: "/admin/pegawai/privilege"
        },
        {
            id: 25,
            cat: "PEGAWAI",
            desc: "Memperbarui data pribadi pegawai",
            role: "Admin",
            route: "{{ route('manage.pegawai.view.personal-info', ['idUser' => '$id']) }}"
        },
        {
            id: 26,
            cat: "PEGAWAI",
            desc: "Menonaktifkan status pegawai",
            role: "Admin",
            route: "{{ route('manage.pegawai.list', ['destination' => 'Active']) }}"
        },
        {
            id: 27,
            cat: "PEGAWAI",
            desc: "Melihat pegawai sesuai unit kerja",
            role: "Admin & Pimpinan",
            route: "{{ route('manage.pegawai.list', ['destination' => 'Active']) }}"
        },
        {
            id: 29,
            cat: "KONTAK DARURAT",
            desc: "Menambahkan nomor kontak darurat",
            role: "Admin & Pegawai",
            route: "{{ route('profile.emergency-contacts.list', ['id_User' => '$id']) }}"
        },
        {
            id: 30,
            cat: "KONTAK DARURAT",
            desc: "Melihat informasi kontak darurat",
            role: "Admin & Pegawai",
            route: "{{ route('profile.emergency-contacts.list', ['id_User' => '$id']) }}"
        },
        {
            id: 31,
            cat: "KONTAK DARURAT",
            desc: "Memperbarui nomor kontak darurat",
            role: "Admin & Pegawai",
            route: "{{ route('profile.emergency-contacts.list', ['id_User' => '$id']) }}"
        },
        {
            id: 32,
            cat: "DATA NIP",
            desc: "Menambahkan nomor induk pegawai (NIP)",
            role: "Admin",
            route: "{{ route('manage.riwayat-nip.new') }}"
        },
        {
            id: 33,
            cat: "DATA NIP",
            desc: "Melihat riwayat perubahan NIP",
            role: "Admin & Pemilik Data",
            route: "{{ route('profile.history.nip', ['id_pegawai' => '$id']) }}"
        },
        {
            id: 34,
            cat: "DATA NIP",
            desc: "Melihat nomor NIP saat ini",
            role: "Admin & Pemilik Data",
            route: "{{ route('profile.history.nip', ['id_pegawai' => '$id']) }}"
        },
        {
            id: 35,
            cat: "DATA NIP",
            desc: "Memperbarui nomor NIP",
            role: "Admin",
            route: "{{ route('manage.riwayat-nip.new') }}"
        },
        {
            id: 36,
            cat: "KELUAR",
            desc: "Keluar dari aplikasi (Selesai)",
            role: "Pegawai",
            route: "/logout"
        }

    ];

    activityData.sort((a, b) => a.id - b.id);

    const tableBody = document.getElementById('content-table-body');

    activityData.forEach(item => {
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
                <td class="p-6 text-center">
                    <a href="${item.route}" class="animate-attention inline-block bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-8 rounded-full shadow-lg transition-all active:scale-95">
                        <span class="text-xs tracking-widest">KERJAKAN</span>
                    </a>
                </td>
            </tr>
        `;
        tableBody.innerHTML += row;
    });
</script>
