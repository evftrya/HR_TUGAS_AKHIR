<div class="max-w-6xl mt-5 mx-auto my-12 px-4 font-sans antialiased text-slate-800">
    <div class="bg-white border border-slate-200 rounded-2xl shadow-xl overflow-hidden">

        <div class="p-10 bg-gradient-to-r from-blue-50 to-white border-b border-slate-100">
            <h1 class="text-3xl font-bold text-slate-900">Halo, Rekan Penguji 👋</h1>
            <p class="mt-3 text-lg text-slate-600 leading-relaxed max-w-3xl">
                Terima kasih banyak atas waktu dan bantuan berharga Anda dalam mencoba fitur-fitur baru kami. 
                Kontribusi Anda sangat menentukan kenyamanan kita bersama dalam bekerja menggunakan sistem ini.
            </p>

            <div class="mt-6 flex flex-wrap items-center gap-4">
                <div class="flex items-center gap-2 px-4 py-2 bg-blue-100 text-blue-700 rounded-full text-sm font-semibold shadow-sm">
                    <span class="flex h-2 w-2 rounded-full bg-blue-500 animate-ping"></span>
                    Panduan Urutan Pengujian
                </div>
                <p class="text-sm text-slate-500 italic font-medium">
                    * Untuk kategori <b>"Tamu"</b>, silakan mencoba sebelum Anda masuk (login) ke akun Anda.
                </p>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50 border-b border-slate-200">
                        <th class="p-6 text-xs font-bold uppercase tracking-widest text-slate-400">Urutan</th>
                        <th class="p-6 text-xs font-bold uppercase tracking-widest text-slate-500 text-center">Tindakan</th>
                        <th class="p-6 text-xs font-bold uppercase tracking-widest text-slate-500">Kategori & Siapa yang Mencoba</th>
                        <th class="p-6 text-xs font-bold uppercase tracking-widest text-slate-500">Kegiatan yang Perlu Dicoba</th>
                    </tr>
                </thead>
                <tbody id="content-table-body" class="divide-y divide-slate-100">
                </tbody>
            </table>
        </div>

        <div class="p-6 bg-slate-50 border-t border-slate-100 text-center text-slate-500 text-sm italic font-medium">
            "Klik tombol biru yang bergerak lembut untuk mulai mencoba masing-masing kegiatan."
        </div>
    </div>
</div>

<style>
    @keyframes pulse-soft {
        0% { transform: scale(1); box-shadow: 0 0 0 0 rgba(37, 99, 235, 0.5); }
        70% { transform: scale(1.05); box-shadow: 0 0 0 12px rgba(37, 99, 235, 0); }
        100% { transform: scale(1); box-shadow: 0 0 0 0 rgba(37, 99, 235, 0); }
    }
    .animate-kerjakan {
        animation: pulse-soft 2s infinite;
    }
</style>

<script>
    // Kamu tinggal masukkan link halamannya di bagian 'route'
    const activityData = [
        { id: 1, cat: "MASUK SISTEM", desc: "Mencoba masuk sebagai tamu (sebelum login)", role: "Tamu", route: "ahref_kamu_di_sini" },
        { id: 2, cat: "STATUS KERJA", desc: "Menambahkan jenis status baru bagi pegawai", role: "Admin", route: "ahref_kamu_di_sini" },
        { id: 3, cat: "STATUS KERJA", desc: "Melihat daftar semua status pegawai", role: "Admin", route: "ahref_kamu_di_sini" },
        { id: 4, cat: "STATUS KERJA", desc: "Mengubah atau memperbarui data status", role: "Admin", route: "ahref_kamu_di_sini" },
        { id: 5, cat: "UNIT KERJA", desc: "Menambahkan unit atau bagian kerja baru", role: "Admin", route: "ahref_kamu_di_sini" },
        { id: 6, cat: "UNIT KERJA", desc: "Melihat daftar unit kerja yang sudah ada", role: "Admin", route: "ahref_kamu_di_sini" },
        { id: 7, cat: "UNIT KERJA", desc: "Mengubah informasi pada unit kerja", role: "Admin", route: "ahref_kamu_di_sini" },
        { id: 8, cat: "FAKULTAS", desc: "Menambahkan informasi fakultas baru", role: "Admin", route: "ahref_kamu_di_sini" },
        { id: 9, cat: "FAKULTAS", desc: "Melihat semua daftar fakultas", role: "Admin", route: "ahref_kamu_di_sini" },
        { id: 10, cat: "FAKULTAS", desc: "Mengubah atau memperbarui data fakultas", role: "Admin", route: "ahref_kamu_di_sini" },
        { id: 11, cat: "PRODI", desc: "Menambahkan program studi baru", role: "Admin", route: "ahref_kamu_di_sini" },
        { id: 12, cat: "PRODI", desc: "Melihat daftar program studi", role: "Admin", route: "ahref_kamu_di_sini" },
        { id: 13, cat: "PRODI", desc: "Mengubah informasi program studi", role: "Admin", route: "ahref_kamu_di_sini" },
        { id: 14, cat: "LEVEL AKSES", desc: "Membuat tingkatan izin akses baru", role: "Admin", route: "ahref_kamu_di_sini" },
        { id: 15, cat: "LEVEL AKSES", desc: "Mengubah pengaturan tingkatan izin", role: "Admin", route: "ahref_kamu_di_sini" },
        { id: 16, cat: "LEVEL AKSES", desc: "Melihat semua tingkatan izin yang ada", role: "Admin", route: "ahref_kamu_di_sini" },
        { id: 17, cat: "LEVEL AKSES", desc: "Melihat detail salah satu tingkatan izin", role: "Admin", route: "ahref_kamu_di_sini" },
        { id: 18, cat: "FORMASI", desc: "Menambahkan rencana penempatan baru", role: "Admin", route: "ahref_kamu_di_sini" },
        { id: 19, cat: "FORMASI", desc: "Melihat daftar semua rencana penempatan", role: "Admin", route: "ahref_kamu_di_sini" },
        { id: 20, cat: "FORMASI", desc: "Melihat rincian satu rencana penempatan", role: "Admin", route: "ahref_kamu_di_sini" },
        { id: 21, cat: "FORMASI", desc: "Mengubah data rencana penempatan", role: "Admin", route: "ahref_kamu_di_sini" },
        { id: 22, cat: "DATA PEGAWAI", desc: "Mendaftarkan rekan pegawai baru ke sistem", role: "Admin", route: "ahref_kamu_di_sini" },
        { id: 23, cat: "DATA PEGAWAI", desc: "Melihat daftar rekan pegawai yang aktif", role: "Admin", route: "ahref_kamu_di_sini" },
        { id: 24, cat: "DATA PEGAWAI", desc: "Memberikan akses admin kepada rekan", role: "Kaur SDM", route: "ahref_kamu_di_sini" },
        { id: 25, cat: "DATA PEGAWAI", desc: "Memperbarui data profil rekan pegawai", role: "Admin", route: "ahref_kamu_di_sini" },
        { id: 26, cat: "DATA PEGAWAI", desc: "Mengatur pegawai yang sudah tidak aktif", role: "Admin", route: "ahref_kamu_di_sini" },
        { id: 27, cat: "DATA PEGAWAI", desc: "Melihat daftar pegawai per unit kerja", role: "Admin & Pimpinan", route: "ahref_kamu_di_sini" },
        { id: 29, cat: "KONTAK DARURAT", desc: "Menambahkan nomor telepon darurat", role: "Admin & Pegawai", route: "ahref_kamu_di_sini" },
        { id: 30, cat: "KONTAK DARURAT", desc: "Melihat daftar nomor darurat", role: "Admin & Pegawai", route: "ahref_kamu_di_sini" },
        { id: 31, cat: "KONTAK DARURAT", desc: "Memperbarui nomor telepon darurat", role: "Admin & Pegawai", route: "ahref_kamu_di_sini" },
        { id: 32, cat: "IDENTITAS NIP", desc: "Menambahkan nomor induk baru", role: "Admin", route: "ahref_kamu_di_sini" },
        { id: 33, cat: "IDENTITAS NIP", desc: "Melihat riwayat perubahan nomor induk", role: "Admin & Pemilik Data", route: "ahref_kamu_di_sini" },
        { id: 34, cat: "IDENTITAS NIP", desc: "Melihat nomor induk yang aktif sekarang", role: "Admin & Pemilik Data", route: "ahref_kamu_di_sini" },
        { id: 35, cat: "IDENTITAS NIP", desc: "Mengubah atau memperbarui nomor induk", role: "Admin", route: "ahref_kamu_di_sini" },
        { id: 36, cat: "KELUAR", desc: "Selesai dan keluar dari aplikasi", role: "Pegawai", route: "ahref_kamu_di_sini" }
    ];

    activityData.sort((a, b) => a.id - b.id);

    const tableBody = document.getElementById('content-table-body');

    activityData.forEach(item => {
        const row = `
            <tr class="hover:bg-blue-50/50 transition-colors group">
                <td class="p-6 text-sm font-bold text-slate-300">#${item.id}</td>
                <td class="p-6 text-center">
                    <a href="${item.route}" class="animate-kerjakan inline-block bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-8 rounded-full shadow-lg transition-all active:scale-95 text-xs tracking-widest uppercase">
                        Kerjakan
                    </a>
                </td>
                <td class="p-6">
                    <span class="text-sm font-bold text-slate-800 tracking-tight uppercase">${item.cat}</span>
                    <br>
                    <span class="inline-flex mt-1 text-[10px] font-bold text-blue-500 uppercase tracking-tighter">
                        Oleh: ${item.role}
                    </span>
                </td>
                <td class="p-6 text-sm text-slate-600 font-medium leading-relaxed">
                    ${item.desc}
                </td>
            </tr>
        `;
        tableBody.innerHTML += row;
    });
</script>