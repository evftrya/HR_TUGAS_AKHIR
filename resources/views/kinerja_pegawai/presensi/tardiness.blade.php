@php
    $active_sidebar = 'Dashboard';
@endphp

@extends('kinerja_pegawai.base')

@section('page-name', 'Laporan Keterlambatan Pegawai')

@section('content-base')
<div class="mb-4">
    <p class="text-sm text-gray-500 italic">Rekapitulasi ketidakdisiplinan jam masuk periode {{ date('F Y', mktime(0, 0, 0, $month, 1, $year)) }}.</p>
</div>
<div class="w-full max-w-7xl mx-auto p-4 sm:p-6 lg:p-8 bg-white rounded-lg shadow-sm border border-gray-100">
    
    {{-- Filter Header --}}
    <div class="flex flex-col xl:flex-row xl:items-center justify-between mb-8 gap-4 border-b border-gray-100 pb-6">
        <div class="flex flex-col md:flex-row md:items-center gap-4">
            <form method="GET" class="flex flex-wrap items-center gap-2">
                <select name="month" class="text-sm border-gray-300 rounded-md shadow-sm focus:ring-blue-500">
                    @foreach (range(1, 12) as $m)
                        <option value="{{ $m }}" {{ $month == $m ? 'selected' : '' }}>
                            {{ date('F', mktime(0, 0, 0, $m, 1)) }}
                        </option>
                    @endforeach
                </select>
                <select name="year" class="text-sm border-gray-300 rounded-md shadow-sm focus:ring-blue-500">
                    @foreach (range(date('Y'), date('Y') - 2) as $y)
                        <option value="{{ $y }}" {{ $year == $y ? 'selected' : '' }}>{{ $y }}</option>
                    @endforeach
                </select>
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium py-2 px-4 rounded-md transition duration-150 inline-flex items-center gap-2">
                    <i class="fa-solid fa-filter text-xs"></i> Filter
                </button>
            </form>
            
            <div class="px-4 py-2 bg-amber-50 border border-amber-100 rounded-lg flex items-center gap-3">
                <i class="fa-solid fa-clock-rotate-left text-amber-500 text-sm"></i>
                <span class="text-xs font-bold text-amber-700 uppercase tracking-tight">Batas Jam Masuk: {{ $maxTime }}</span>
            </div>
        </div>
    </div>

    <div class="overflow-x-auto border border-gray-200 rounded-lg">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider text-left">Pegawai</th>
                    <th class="px-6 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider text-left">Unit Kerja</th>
                    <th class="px-6 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider text-center">Avg. Jam Masuk</th>
                    <th class="px-6 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider text-center">Total Telat</th>
                    <th class="px-6 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider text-center">Status Disiplin</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @foreach ($report as $row)
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 rounded-full bg-gray-100 flex items-center justify-center text-gray-400 font-bold border border-gray-200 text-[10px]">
                                    {{ substr($row['user']->nama_lengkap, 0, 1) }}
                                </div>
                                <span class="text-sm font-bold text-gray-900">{{ $row['user']->nama_lengkap }}</span>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="text-xs font-semibold text-gray-500 uppercase tracking-tight">
                                {{ $row['user']->unit?->nama_unit ?? 'General' }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-center whitespace-nowrap font-bold text-sm">
                            <span class="{{ ($row['avg_check_in'] > $maxTime) ? 'text-red-600' : 'text-gray-700' }}">
                                {{ $row['avg_check_in'] ?? '—' }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-center whitespace-nowrap">
                            <div class="flex flex-col items-center">
                                <span class="text-lg font-black {{ ($row['tardiness_count'] > 3) ? 'text-red-600' : 'text-gray-900' }}">
                                    {{ $row['tardiness_count'] }}
                                </span>
                                <span class="text-[9px] font-bold text-gray-400 uppercase">Kali</span>
                            </div>
                        </td>
                        <td class="px-6 py-4 text-center whitespace-nowrap">
                            @if($row['tardiness_count'] > 3)
                                <span class="px-3 py-1 rounded-full bg-red-100 text-red-700 text-[9px] font-black uppercase border border-red-200">
                                    Perlu Teguran
                                </span>
                            @elseif($row['tardiness_count'] > 0)
                                <span class="px-3 py-1 rounded-full bg-amber-100 text-amber-700 text-[9px] font-black uppercase border border-amber-200">
                                    Peringatan
                                </span>
                            @else
                                <span class="px-3 py-1 rounded-full bg-green-100 text-green-700 text-[9px] font-black uppercase border border-green-200">
                                    Disiplin
                                </span>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
