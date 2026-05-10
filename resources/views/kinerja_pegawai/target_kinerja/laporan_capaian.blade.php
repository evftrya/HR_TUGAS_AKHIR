@php
    $active_sidebar = 'Laporan Capaian TW';
@endphp

@extends('kinerja_pegawai.base')

@section('page-name')
    <div class="flex items-center justify-between px-1">
        <div>
            <h2 class="text-2xl font-bold text-[#101828]">Laporan Capaian Triwulan</h2>
            <p class="text-sm text-gray-500">Monitoring realisasi KM & Sasaran Mutu</p>
        </div>
    </div>
@endsection

@section('content-base')
    <div class="w-full space-y-6">
        <div class="bg-white rounded-3xl border border-gray-100 shadow-sm overflow-hidden">
            <div class="p-6 border-b border-gray-50 flex items-center justify-between bg-gray-50/50">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-2xl bg-indigo-600 flex items-center justify-center text-white shadow-lg shadow-indigo-200">
                        <i class="fa-solid fa-bullseye"></i>
                    </div>
                    <h3 class="font-bold text-gray-800">Capaian Indikator (KM & SM)</h3>
                </div>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-gray-50/50">
                            <th class="px-6 py-4 text-[10px] font-black text-gray-400 uppercase tracking-widest">Indikator</th>
                            <th class="px-4 py-4 text-[10px] font-black text-gray-400 uppercase tracking-widest text-center">TW I</th>
                            <th class="px-4 py-4 text-[10px] font-black text-gray-400 uppercase tracking-widest text-center">TW II</th>
                            <th class="px-4 py-4 text-[10px] font-black text-gray-400 uppercase tracking-widest text-center">TW III</th>
                            <th class="px-4 py-4 text-[10px] font-black text-gray-400 uppercase tracking-widest text-center">TW IV</th>
                            <th class="px-6 py-4 text-[10px] font-black text-gray-400 uppercase tracking-widest text-center">Total Target</th>
                            <th class="px-6 py-4 text-[10px] font-black text-gray-400 uppercase tracking-widest text-center">Realisasi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50">
                        @forelse($items as $item)
                            <tr class="hover:bg-gray-50/50 transition-colors">
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
                                    <p class="text-[9px] text-gray-400 font-medium">B: {{ number_format($item->tw1_bobot) }}</p>
                                </td>
                                <td class="px-4 py-4 text-center">
                                    <p class="text-xs font-bold text-gray-700">{{ number_format($item->tw2_target) }}</p>
                                    <p class="text-[9px] text-gray-400 font-medium">B: {{ number_format($item->tw2_bobot) }}</p>
                                </td>
                                <td class="px-4 py-4 text-center">
                                    <p class="text-xs font-bold text-gray-700">{{ number_format($item->tw3_target) }}</p>
                                    <p class="text-[9px] text-gray-400 font-medium">B: {{ number_format($item->tw3_bobot) }}</p>
                                </td>
                                <td class="px-4 py-4 text-center">
                                    <p class="text-xs font-bold text-gray-700">{{ number_format($item->tw4_target) }}</p>
                                    <p class="text-[9px] text-gray-400 font-medium">B: {{ number_format($item->tw4_bobot) }}</p>
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <span class="text-sm font-black text-gray-900">{{ number_format($item->tw1_target + $item->tw2_target + $item->tw3_target + $item->tw4_target) }}</span>
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <div class="flex flex-col items-center gap-1">
                                        <span class="text-sm font-black text-emerald-600">{{ number_format($item->total_realisasi) }}</span>
                                        @php
                                            $totalTarget = $item->tw1_target + $item->tw2_target + $item->tw3_target + $item->tw4_target;
                                            $capaianPercent = $totalTarget > 0 ? ($item->total_realisasi / $totalTarget * 100) : 0;
                                        @endphp
                                        <span class="text-[9px] font-bold px-2 py-0.5 rounded bg-emerald-50 text-emerald-700">{{ round($capaianPercent, 1) }}%</span>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="px-6 py-12 text-center">
                                    <p class="text-sm font-bold text-gray-400">Data capaian belum tersedia.</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
