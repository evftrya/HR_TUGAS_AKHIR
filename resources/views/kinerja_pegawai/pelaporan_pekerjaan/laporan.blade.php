@php
    $active_sidebar = 'Laporan Efektivitas';
@endphp

@extends('kinerja_pegawai.base')

@section('page-name')
    <div class="flex items-center justify-between px-1">
        <div>
            <h2 class="text-2xl font-bold text-[#101828]">Laporan Efektivitas Individual</h2>
            <p class="text-sm text-gray-500">Analisis beban kerja dan validasi pengerjaan harian</p>
        </div>
    </div>
@endsection

@section('content-base')
    <div class="w-full space-y-6">
        {{-- TUGAS 5: Agregasi Bulanan --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="bg-indigo-600 p-8 rounded-[32px] text-white shadow-xl shadow-indigo-100 flex items-center justify-between overflow-hidden relative">
                <div class="space-y-2 relative z-10">
                    <p class="text-xs font-bold uppercase tracking-widest text-indigo-200">Efektivitas Bulanan (Avg)</p>
                    <h3 class="text-4xl font-black">{{ round($efektivitasBulanan * 100, 1) }}%</h3>
                    <div class="flex items-center gap-2">
                        <span class="px-3 py-1 rounded-full bg-white/20 text-[10px] font-black uppercase">{{ $statusBulanan }}</span>
                    </div>
                </div>
                <i class="fa-solid fa-chart-pie text-8xl text-white/10 absolute -right-4 -bottom-4"></i>
            </div>
            <div class="bg-white p-8 rounded-[32px] border border-gray-100 shadow-sm flex items-center justify-between">
                <div class="space-y-2">
                    <p class="text-xs font-bold uppercase tracking-widest text-gray-400">Total Hari Melapor</p>
                    <h3 class="text-4xl font-black text-gray-800">{{ $items->count() }} <span class="text-lg text-gray-400">Hari</span></h3>
                </div>
                <div class="w-16 h-16 rounded-full bg-blue-50 flex items-center justify-center text-blue-600">
                    <i class="fa-solid fa-calendar-check text-2xl"></i>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-3xl border border-gray-100 shadow-sm overflow-hidden">
            <div class="p-6 border-b border-gray-50 flex items-center justify-between bg-gray-50/50">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-2xl bg-blue-600 flex items-center justify-center text-white shadow-lg shadow-blue-200">
                        <i class="fa-solid fa-chart-line"></i>
                    </div>
                    <h3 class="font-bold text-gray-800">Riwayat Efektivitas Harian</h3>
                </div>
                <div class="text-xs font-bold text-gray-400 uppercase tracking-widest">
                    Standard: 450 Menit / Hari
                </div>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-gray-50/50">
                            <th class="px-6 py-4 text-[10px] font-black text-gray-400 uppercase tracking-widest">Tanggal</th>
                            <th class="px-6 py-4 text-[10px] font-black text-gray-400 uppercase tracking-widest text-center">Input Pegawai (Min)</th>
                            <th class="px-6 py-4 text-[10px] font-black text-gray-400 uppercase tracking-widest text-center">Validasi Atasan (Min)</th>
                            <th class="px-6 py-4 text-[10px] font-black text-gray-400 uppercase tracking-widest text-center">Efektivitas (%)</th>
                            <th class="px-6 py-4 text-[10px] font-black text-gray-400 uppercase tracking-widest text-center">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50">
                        @forelse($items as $item)
                            <tr class="hover:bg-gray-50/50 transition-colors">
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-3">
                                        <div class="w-8 h-8 rounded-lg bg-gray-100 flex flex-col items-center justify-center text-gray-500">
                                            <span class="text-[10px] font-black leading-none">{{ date('d', strtotime($item->tanggal)) }}</span>
                                            <span class="text-[8px] font-bold uppercase leading-none">{{ date('M', strtotime($item->tanggal)) }}</span>
                                        </div>
                                        <span class="text-sm font-bold text-gray-700">{{ date('l, d F Y', strtotime($item->tanggal)) }}</span>
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <span class="text-sm font-medium text-gray-600">{{ number_format($item->total_input) }}</span>
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <span class="text-sm font-black text-gray-900">{{ number_format($item->total_validasi) }}</span>
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <div class="flex flex-col items-center gap-1">
                                        <span class="text-sm font-black text-blue-600">{{ $item->efektivitas_percent }}%</span>
                                        <div class="w-20 h-1.5 bg-gray-100 rounded-full overflow-hidden">
                                            <div class="h-full bg-blue-500" style="width: {{ min($item->efektivitas_percent, 100) }}%"></div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-[10px] font-black uppercase tracking-tighter {{ $item->badge_color }}">
                                        {{ $item->status_efektivitas }}
                                    </span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-12 text-center">
                                    <div class="flex flex-col items-center gap-2">
                                        <i class="fa-solid fa-folder-open text-4xl text-gray-200"></i>
                                        <p class="text-sm font-bold text-gray-400">Belum ada data laporan yang disetujui.</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Info Card --}}
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="bg-green-50 p-6 rounded-3xl border border-green-100">
                <h4 class="text-xs font-black text-green-800 uppercase mb-2">Status: Optimal</h4>
                <p class="text-[10px] text-green-700 leading-relaxed">Efektivitas antara 75% - 100%. Menunjukkan beban kerja yang seimbang dan produktif sesuai standar waktu institusi.</p>
            </div>
            <div class="bg-yellow-50 p-6 rounded-3xl border border-yellow-100">
                <h4 class="text-xs font-black text-yellow-800 uppercase mb-2">Status: Kurang</h4>
                <p class="text-[10px] text-yellow-700 leading-relaxed">Efektivitas di bawah 75%. Disarankan untuk meninjau kembali produktivitas harian atau kecukupan distribusi tugas.</p>
            </div>
            <div class="bg-red-50 p-6 rounded-3xl border border-red-100">
                <h4 class="text-xs font-black text-red-800 uppercase mb-2">Status: Overload</h4>
                <p class="text-[10px] text-red-700 leading-relaxed">Efektivitas di atas 100%. Hati-hati terhadap potensi burnout. Pertimbangkan untuk delegasi tugas atau penyesuaian jadwal.</p>
            </div>
        </div>
    </div>
@endsection
