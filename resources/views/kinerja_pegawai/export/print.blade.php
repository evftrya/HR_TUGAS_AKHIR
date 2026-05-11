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
        }
    </style>
</head>
<body class="bg-gray-50 p-4 sm:p-10 font-sans">
    <div class="max-w-4xl mx-auto bg-white p-8 sm:p-12 shadow-sm print:shadow-none rounded-lg border border-gray-200">
        
        {{-- Header --}}
        <div class="flex items-center justify-between border-b-2 border-gray-800 pb-8 mb-10">
            <div class="flex items-center gap-6">
                <div class="w-16 h-16 bg-blue-600 rounded-lg flex items-center justify-center text-white font-black text-2xl shadow-sm">
                    HR
                </div>
                <div>
                    <h1 class="text-2xl font-black uppercase tracking-tight text-gray-900">Sistem Manajemen SDM</h1>
                    <p class="text-xs text-gray-500 font-bold uppercase tracking-widest">Laporan Rekapitulasi Kinerja Pegawai</p>
                </div>
            </div>
            <div class="text-right">
                <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-1">Tanggal Cetak</p>
                <p class="text-sm font-bold text-gray-800">{{ now()->translatedFormat('d F Y') }}</p>
            </div>
        </div>

        {{-- Profil Pegawai --}}
        <div class="mb-10 grid grid-cols-2 gap-8 bg-gray-50 p-6 rounded-xl border border-gray-100">
            <div class="space-y-1">
                <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">Nama Lengkap</p>
                <p class="text-base font-bold text-gray-900">{{ Auth::user()->nama_lengkap }}</p>
            </div>
            <div class="space-y-1 text-right md:text-left">
                <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">Unit Kerja</p>
                <p class="text-base font-bold text-gray-900">{{ Auth::user()->unit->nama_unit ?? 'Pegawai Institusi' }}</p>
            </div>
        </div>

        {{-- Ringkasan Statistik --}}
        <div class="grid grid-cols-3 gap-6 mb-12">
            <div class="p-6 bg-white rounded-xl border border-gray-200 text-center shadow-sm">
                <p class="text-3xl font-black text-blue-600 mb-1">{{ number_format($summary['total_minutes']) }}</p>
                <p class="text-[9px] font-bold text-gray-400 uppercase tracking-widest">Menit Kerja Disetujui</p>
            </div>
            <div class="p-6 bg-white rounded-xl border border-gray-200 text-center shadow-sm">
                <p class="text-3xl font-black text-emerald-600 mb-1">{{ $summary['avg_achievement'] }}%</p>
                <p class="text-[9px] font-bold text-gray-400 uppercase tracking-widest">Capaian Target KPI</p>
            </div>
            <div class="p-6 bg-white rounded-xl border border-gray-200 text-center shadow-sm">
                <p class="text-3xl font-black text-indigo-600 mb-1">{{ $summary['avg_sla_hours'] }}</p>
                <p class="text-[9px] font-bold text-gray-400 uppercase tracking-widest">Avg. SLA (Jam)</p>
            </div>
        </div>

        {{-- Detail Kegiatan --}}
        <div class="mb-12">
            <h3 class="text-sm font-bold text-gray-800 uppercase tracking-widest mb-6 border-l-4 border-blue-600 pl-4">Daftar Log Kegiatan</h3>
            <div class="border border-gray-200 rounded-lg overflow-hidden">
                <table class="w-full text-left">
                    <thead>
                        <tr class="bg-gray-50 border-b border-gray-200">
                            <th class="px-4 py-3 text-[10px] font-bold text-gray-500 uppercase">Tanggal</th>
                            <th class="px-4 py-3 text-[10px] font-bold text-gray-500 uppercase">Pekerjaan</th>
                            <th class="px-4 py-3 text-[10px] font-bold text-gray-500 uppercase text-center">Output</th>
                            <th class="px-4 py-3 text-[10px] font-bold text-gray-500 uppercase text-center">Waktu</th>
                            <th class="px-4 py-3 text-[10px] font-bold text-gray-500 uppercase text-center">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse($reports as $rep)
                            <tr>
                                <td class="px-4 py-4 text-xs font-medium text-gray-600">{{ $rep->created_at->format('d/m/Y') }}</td>
                                <td class="px-4 py-4 text-xs font-bold text-gray-900 leading-tight">{{ $it->targetHarian->pekerjaan ?? '-' }}</td>
                                <td class="px-4 py-4 text-xs text-gray-700 text-center">{{ $rep->effective_jumlah }}</td>
                                <td class="px-4 py-4 text-xs text-gray-700 text-center font-bold">{{ $rep->effective_waktu_minutes }} Min</td>
                                <td class="px-4 py-4 text-center">
                                    <span class="text-[9px] font-black uppercase px-2.5 py-1 rounded-full border {{ $rep->status === 'approved' ? 'bg-green-50 text-green-700 border-green-200' : ($rep->status === 'rejected' ? 'bg-red-50 text-red-700 border-red-200' : 'bg-amber-50 text-amber-700 border-amber-200') }}">
                                        {{ $rep->status }}
                                    </span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-4 py-10 text-center text-xs text-gray-400 italic">Belum ada aktivitas yang dicatat.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <div class="mt-20 flex justify-end">
            <div class="text-center w-72 border-t-2 border-gray-900 pt-6">
                <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-16">Mengetahui, Atasan Langsung</p>
                <p class="text-sm font-black text-gray-900">( ............................................ )</p>
                <p class="text-[10px] text-gray-400 font-bold uppercase tracking-widest mt-2">NIP / Tanda Tangan & Cap Unit</p>
            </div>
        </div>

        {{-- Actions --}}
        <div class="mt-12 pt-8 border-t border-gray-100 flex items-center justify-between no-print">
            <p class="text-[11px] text-gray-400 font-medium italic">* Gunakan kertas ukuran A4 untuk hasil cetak terbaik.</p>
            <div class="flex gap-3">
                <a href="{{ route('manage.target-kinerja.harian.list') }}" class="px-6 py-2.5 bg-white border border-gray-300 text-gray-700 text-xs font-bold rounded-md hover:bg-gray-50 transition shadow-sm">
                    KEMBALI
                </a>
                <button onclick="window.print()" class="px-8 py-2.5 bg-blue-600 text-white text-xs font-bold rounded-md hover:bg-blue-700 transition shadow-md inline-flex items-center gap-2">
                    <i class="fa-solid fa-print"></i> CETAK LAPORAN
                </button>
            </div>
        </div>
    </div>
</body>
</html>
