@php
    $active_sidebar = 'Laporan Efektivitas';
@endphp

@extends('kinerja_pegawai.base')

@section('page-name', 'Laporan Efektivitas Individual')

@section('content-base')
<div class="mb-4">
    <p class="text-sm text-gray-500 italic">Analisis beban kerja dan validasi pengerjaan harian.</p>
</div>
<div class="w-full max-w-7xl mx-auto p-4 sm:p-6 lg:p-8 bg-white rounded-lg shadow-sm border border-gray-100">
    {{-- Summary Cards --}}
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
        <div class="bg-blue-600 p-8 rounded-2xl text-white shadow-lg flex items-center justify-between relative overflow-hidden">
            <div class="relative z-10">
                <p class="text-xs font-bold uppercase tracking-widest text-blue-100">Efektivitas Bulanan (Avg)</p>
                <h3 class="text-4xl font-extrabold mt-1">{{ round($efektivitasBulanan * 100, 1) }}%</h3>
                <div class="mt-2 inline-flex items-center px-3 py-1 rounded-full bg-white/20 text-[10px] font-bold uppercase">
                    {{ $statusBulanan }}
                </div>
            </div>
            <i class="fa-solid fa-chart-pie text-7xl text-white/10 absolute -right-2 -bottom-2"></i>
        </div>
        
        <div class="bg-gray-50 p-8 rounded-2xl border border-gray-200 flex items-center justify-between">
            <div>
                <p class="text-xs font-bold uppercase tracking-widest text-gray-400">Total Hari Melapor</p>
                <h3 class="text-4xl font-extrabold text-gray-800 mt-1">{{ $items->count() }} <span class="text-lg text-gray-400 font-medium">Hari</span></h3>
            </div>
            <div class="w-14 h-14 rounded-full bg-blue-100 flex items-center justify-center text-blue-600 shadow-inner">
                <i class="fa-solid fa-calendar-check text-xl"></i>
            </div>
        </div>
    </div>

    {{-- Main Table --}}
    <div class="bg-gray-50 rounded-2xl border border-gray-200 overflow-hidden shadow-sm">
        <div class="p-5 border-b border-gray-200 bg-white flex items-center justify-between">
            <h3 class="text-lg font-bold text-gray-700">Riwayat Efektivitas Harian</h3>
            <span class="text-xs text-gray-400 italic">Standard: 450 Menit / Hari</span>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full text-left border-collapse">
                <thead class="bg-gray-50 border-b border-gray-200">
                    <tr>
                        <th class="px-6 py-4 text-xs font-semibold text-gray-500 uppercase tracking-wider">Tanggal</th>
                        <th class="px-6 py-4 text-xs font-semibold text-gray-500 uppercase tracking-wider text-center">Input (Min)</th>
                        <th class="px-6 py-4 text-xs font-semibold text-gray-500 uppercase tracking-wider text-center">Validasi (Min)</th>
                        <th class="px-6 py-4 text-xs font-semibold text-gray-500 uppercase tracking-wider text-center">Efektivitas (%)</th>
                        <th class="px-6 py-4 text-xs font-semibold text-gray-500 uppercase tracking-wider text-center">Status</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-100">
                    @forelse($items as $item)
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center gap-3">
                                    <div class="w-9 h-9 rounded-lg bg-gray-100 flex flex-col items-center justify-center text-gray-500 border border-gray-200">
                                        <span class="text-xs font-black leading-none">{{ date('d', strtotime($item->tanggal)) }}</span>
                                        <span class="text-[8px] font-bold uppercase leading-tight">{{ date('M', strtotime($item->tanggal)) }}</span>
                                    </div>
                                    <span class="text-sm font-bold text-gray-700">{{ date('l, d F Y', strtotime($item->tanggal)) }}</span>
                                </div>
                            </td>
                            <td class="px-6 py-4 text-center text-sm font-medium text-gray-600">
                                {{ number_format($item->total_input) }}
                            </td>
                            <td class="px-6 py-4 text-center text-sm font-bold text-gray-900">
                                {{ number_format($item->total_validasi) }}
                            </td>
                            <td class="px-6 py-4 text-center">
                                <div class="flex flex-col items-center gap-1.5">
                                    <span class="text-sm font-black text-blue-600">{{ $item->efektivitas_percent }}%</span>
                                    <div class="w-24 h-1.5 bg-gray-100 rounded-full overflow-hidden border border-gray-50">
                                        <div class="h-full bg-blue-500" style="width: {{ min($item->efektivitas_percent, 100) }}%"></div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 text-center">
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-[10px] font-black uppercase tracking-tight {{ $item->badge_color }}">
                                    {{ $item->status_efektivitas }}
                                </span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-12 text-center text-gray-400 italic text-sm">
                                <i class="fa-solid fa-folder-open text-3xl mb-2 block"></i>
                                Belum ada data laporan yang disetujui.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- Legend --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mt-8">
        <div class="p-4 bg-green-50 rounded-xl border border-green-100">
            <h4 class="text-xs font-bold text-green-800 uppercase mb-1">Status: Optimal</h4>
            <p class="text-[10px] text-green-700 leading-relaxed">Efektivitas 75% - 100%. Beban kerja seimbang dan produktif.</p>
        </div>
        <div class="p-4 bg-yellow-50 rounded-xl border border-yellow-100">
            <h4 class="text-xs font-bold text-yellow-800 uppercase mb-1">Status: Kurang</h4>
            <p class="text-[10px] text-yellow-700 leading-relaxed">Efektivitas < 75%. Perlu tinjau kembali produktivitas harian.</p>
        </div>
        <div class="p-4 bg-red-50 rounded-xl border border-red-100">
            <h4 class="text-xs font-bold text-red-800 uppercase mb-1">Status: Overload</h4>
            <p class="text-[10px] text-red-700 leading-relaxed">Efektivitas > 100%. Hati-hati potensi burnout pegawai.</p>
        </div>
    </div>
</div>
@endsection
