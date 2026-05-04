<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Kinerja Pegawai - {{ Auth::user()->nama_lengkap }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @media print {
            .no-print { display: none; }
            body { background-color: white; padding: 0; }
            .print-border { border: 1px solid #e5e7eb; }
        }
    </style>
</head>
<body class="bg-gray-50 p-8 font-sans">
    <div class="max-w-4xl mx-auto bg-white p-10 shadow-lg print:shadow-none print:max-w-full rounded-2xl border border-gray-100">
        
        {{-- Header --}}
        <div class="flex items-center justify-between border-b-2 border-gray-900 pb-6 mb-8">
            <div class="flex items-center gap-4">
                <div class="w-16 h-16 bg-blue-600 rounded-xl flex items-center justify-center text-white font-black text-2xl">
                    HR
                </div>
                <div>
                    <h1 class="text-xl font-black uppercase tracking-tighter">Sistem Manajemen SDM</h1>
                    <p class="text-xs text-gray-500 font-bold uppercase tracking-widest">Laporan Kinerja Pegawai Terpadu</p>
                </div>
            </div>
            <div class="text-right">
                <p class="text-xs font-bold text-gray-400 uppercase">Tanggal Cetak</p>
                <p class="text-sm font-black">{{ now()->translatedFormat('d F Y') }}</p>
            </div>
        </div>

        {{-- Profil Pegawai --}}
        <div class="mb-8 grid grid-cols-2 gap-4">
            <div class="space-y-1">
                <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">Nama Pegawai</p>
                <p class="text-base font-black text-gray-900">{{ Auth::user()->nama_lengkap }}</p>
            </div>
            <div class="space-y-1">
                <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">NIP / ID</p>
                <p class="text-base font-black text-gray-900">{{ Auth::user()->id }}</p>
            </div>
        </div>

        {{-- Ringkasan Statistik (Fitur 2F2) --}}
        <div class="grid grid-cols-3 gap-6 mb-10">
            <div class="p-6 bg-blue-50 rounded-3xl border border-blue-100 text-center">
                <p class="text-2xl font-black text-blue-700">{{ $summary['total_minutes'] }}</p>
                <p class="text-[10px] font-bold text-blue-500 uppercase tracking-widest">Menit Kerja Disetujui</p>
            </div>
            <div class="p-6 bg-emerald-50 rounded-3xl border border-emerald-100 text-center">
                <p class="text-2xl font-black text-emerald-700">{{ $summary['avg_achievement'] }}%</p>
                <p class="text-[10px] font-bold text-emerald-500 uppercase tracking-widest">Capaian Target KPI</p>
            </div>
            <div class="p-6 bg-purple-50 rounded-3xl border border-purple-100 text-center">
                <p class="text-2xl font-black text-purple-700">{{ $summary['avg_sla_hours'] }} <span class="text-xs">Jam</span></p>
                <p class="text-[10px] font-bold text-purple-500 uppercase tracking-widest">Rata-rata SLA Verifikasi</p>
            </div>
        </div>

        {{-- Detail Kegiatan --}}
        <div class="mb-10">
            <h3 class="text-sm font-black text-gray-900 uppercase tracking-widest mb-4 border-l-4 border-blue-600 pl-3">Daftar Detail Kegiatan</h3>
            <table class="w-full border-collapse">
                <thead>
                    <tr class="bg-gray-100 border-y border-gray-200">
                        <th class="px-4 py-3 text-left text-[10px] font-bold text-gray-500 uppercase">Tanggal</th>
                        <th class="px-4 py-3 text-left text-[10px] font-bold text-gray-500 uppercase">Pekerjaan</th>
                        <th class="px-4 py-3 text-left text-[10px] font-bold text-gray-500 uppercase">Jumlah</th>
                        <th class="px-4 py-3 text-left text-[10px] font-bold text-gray-500 uppercase">Waktu</th>
                        <th class="px-4 py-3 text-left text-[10px] font-bold text-gray-500 uppercase">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @foreach($reports as $rep)
                        <tr>
                            <td class="px-4 py-3 text-xs text-gray-600">{{ $rep->created_at->format('d/m/y') }}</td>
                            <td class="px-4 py-3 text-xs font-bold text-gray-900">{{ $rep->targetHarian->pekerjaan ?? '-' }}</td>
                            <td class="px-4 py-3 text-xs text-gray-600">{{ $rep->effective_jumlah }}</td>
                            <td class="px-4 py-3 text-xs text-gray-600">{{ $rep->effective_waktu_minutes }} Min</td>
                            <td class="px-4 py-3">
                                <span class="text-[9px] font-black uppercase px-2 py-0.5 rounded-full {{ $rep->status === 'approved' ? 'bg-green-50 text-green-700' : ($rep->status === 'rejected' ? 'bg-red-50 text-red-700' : 'bg-yellow-50 text-yellow-700') }}">
                                    {{ $rep->status }}
                                </span>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="mt-20 flex justify-end">
            <div class="text-center w-64 border-t border-gray-900 pt-4">
                <p class="text-xs font-bold text-gray-400 uppercase mb-12">Mengetahui, Atasan Langsung</p>
                <p class="text-sm font-black text-gray-900">( ................................ )</p>
                <p class="text-[10px] text-gray-400">Tanda tangan & Cap Basah</p>
            </div>
        </div>

        {{-- Actions --}}
        <div class="mt-10 pt-6 border-t border-gray-100 flex items-center justify-between no-print">
            <p class="text-xs text-gray-400">Gunakan tombol cetak untuk menyimpan sebagai PDF</p>
            <div class="flex gap-3">
                <button onclick="window.print()" class="px-6 py-2 bg-blue-600 text-white text-xs font-black rounded-xl hover:bg-blue-700 transition">
                    CETAK LAPORAN
                </button>
                <a href="{{ route('manage.target-kinerja.harian.list') }}" class="px-6 py-2 bg-white border border-gray-200 text-gray-500 text-xs font-bold rounded-xl hover:bg-gray-50 transition">
                    KEMBALI
                </a>
            </div>
        </div>
    </div>
</body>
</html>
