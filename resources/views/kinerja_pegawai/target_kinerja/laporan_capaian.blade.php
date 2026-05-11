@php
    $active_sidebar = 'Laporan Capaian TW';
@endphp

@extends('kinerja_pegawai.base')

@section('page-name', 'Laporan Capaian Triwulan')

@section('content-base')
<div class="mb-4">
    <p class="text-sm text-gray-500 italic">Monitoring realisasi KM & Sasaran Mutu institusi.</p>
</div>
<div class="w-full max-w-7xl mx-auto p-4 sm:p-6 lg:p-8 bg-white rounded-lg shadow-sm border border-gray-100">
    <div class="flex items-center gap-3 mb-6">
        <div class="w-10 h-10 rounded-lg bg-indigo-600 flex items-center justify-center text-white shadow-md">
            <i class="fa-solid fa-bullseye"></i>
        </div>
        <h3 class="text-lg font-bold text-gray-700 uppercase tracking-tight">Capaian Indikator (KM & SM)</h3>
    </div>

    <div class="overflow-x-auto border border-gray-200 rounded-xl shadow-sm">
        <table class="min-w-full text-left border-collapse">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-4 text-xs font-semibold text-gray-500 uppercase tracking-wider">Indikator Kinerja</th>
                    <th class="px-4 py-4 text-xs font-semibold text-gray-500 uppercase tracking-wider text-center">TW I</th>
                    <th class="px-4 py-4 text-xs font-semibold text-gray-500 uppercase tracking-wider text-center">TW II</th>
                    <th class="px-4 py-4 text-xs font-semibold text-gray-500 uppercase tracking-wider text-center">TW III</th>
                    <th class="px-4 py-4 text-xs font-semibold text-gray-500 uppercase tracking-wider text-center">TW IV</th>
                    <th class="px-6 py-4 text-xs font-semibold text-gray-500 uppercase tracking-wider text-center">Target Tahunan</th>
                    <th class="px-6 py-4 text-xs font-semibold text-gray-500 uppercase tracking-wider text-center">Realisasi</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-100">
                @forelse($items as $item)
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="px-6 py-4">
                            <div class="space-y-1">
                                <p class="text-sm font-bold text-gray-800 leading-tight">{{ $item->nama_kpi }}</p>
                                <div class="flex items-center gap-2">
                                    <span class="text-[9px] font-black px-2 py-0.5 rounded bg-gray-100 text-gray-500 uppercase">{{ $item->jenis }}</span>
                                    <span class="text-[9px] font-black px-2 py-0.5 rounded bg-blue-50 text-blue-600 uppercase">{{ $item->satuan }}</span>
                                </div>
                            </div>
                        </td>
                        <td class="px-4 py-4 text-center">
                            <p class="text-xs font-bold text-gray-700">{{ number_format($item->tw1_target) }}</p>
                            <p class="text-[9px] text-gray-400 font-medium uppercase">Bobot: {{ number_format($item->tw1_bobot) }}</p>
                        </td>
                        <td class="px-4 py-4 text-center">
                            <p class="text-xs font-bold text-gray-700">{{ number_format($item->tw2_target) }}</p>
                            <p class="text-[9px] text-gray-400 font-medium uppercase">Bobot: {{ number_format($item->tw2_bobot) }}</p>
                        </td>
                        <td class="px-4 py-4 text-center">
                            <p class="text-xs font-bold text-gray-700">{{ number_format($item->tw3_target) }}</p>
                            <p class="text-[9px] text-gray-400 font-medium uppercase">Bobot: {{ number_format($item->tw3_bobot) }}</p>
                        </td>
                        <td class="px-4 py-4 text-center">
                            <p class="text-xs font-bold text-gray-700">{{ number_format($item->tw4_target) }}</p>
                            <p class="text-[9px] text-gray-400 font-medium uppercase">Bobot: {{ number_format($item->tw4_bobot) }}</p>
                        </td>
                        <td class="px-6 py-4 text-center">
                            <span class="text-sm font-black text-gray-900">{{ number_format($item->tw1_target + $item->tw2_target + $item->tw3_target + $item->tw4_target) }}</span>
                        </td>
                        <td class="px-6 py-4 text-center">
                            <div class="flex flex-col items-center gap-1.5">
                                <span class="text-sm font-black text-emerald-600">{{ number_format($item->total_realisasi) }}</span>
                                @php
                                    $totalTarget = $item->tw1_target + $item->tw2_target + $item->tw3_target + $item->tw4_target;
                                    $capaianPercent = $totalTarget > 0 ? ($item->total_realisasi / $totalTarget * 100) : 0;
                                @endphp
                                <span class="text-[9px] font-bold px-2 py-0.5 rounded bg-emerald-50 text-emerald-700">{{ round($capaianPercent, 1) }}% Capaian</span>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="px-6 py-12 text-center text-gray-400 italic text-sm">
                            <i class="fa-solid fa-database text-3xl mb-2 block"></i>
                            Data capaian kinerja belum tersedia untuk periode ini.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
