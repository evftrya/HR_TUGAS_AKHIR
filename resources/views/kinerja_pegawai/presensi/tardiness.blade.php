@php
    $active_sidebar = 'Dashboard';
@endphp

@extends('kinerja_pegawai.base')

@section('page-name')
    <div class="flex flex-col md:flex-row items-center gap-[11.75px] self-stretch px-1 pt-[14.68px] pb-[13.95px]">
        <div class="flex w-full flex-col gap-[2.93px] grow">
            <div class="flex items-center gap-[5.87px] self-stretch">
                <span class="font-medium text-2xl leading-[20.56px] text-[#101828]">Laporan Keterlambatan</span>
            </div>
            <span class="font-normal text-[10.28px] leading-[14.68px] text-[#1f2028]">Rekapitulasi ketidakdisiplinan jam masuk pegawai periode {{ date('F Y', mktime(0, 0, 0, $month, 1, $year)) }}</span>
        </div>
    </div>
@endsection

@section('content-base')
    <div class="flex flex-grow-0 flex-col gap-2 max-w-100">
        
        {{-- ── Tardiness Table ────────────────────────── --}}
        <x-tb id="tardinessTable" :search_status="true">
            <x-slot:put_something>
                <div class="flex items-center gap-3 h-full">
                    <form method="GET" class="flex items-center gap-2">
                        <select name="month" class="filter-select min-w-[140px]">
                            @foreach (range(1, 12) as $m)
                                <option value="{{ $m }}" {{ $month == $m ? 'selected' : '' }}>
                                    {{ date('F', mktime(0, 0, 0, $m, 1)) }}
                                </option>
                            @endforeach
                        </select>
                        <select name="year" class="filter-select">
                            @foreach (range(date('Y'), date('Y') - 2) as $y)
                                <option value="{{ $y }}" {{ $year == $y ? 'selected' : '' }}>
                                    {{ $y }}</option>
                            @endforeach
                        </select>
                        <button type="submit" class="filter-btn-primary">
                            <i class="fa-solid fa-filter text-xs"></i>
                            <span>Filter</span>
                        </button>
                    </form>

                    <div class="h-11 px-4 bg-amber-50 border border-amber-100 rounded-[14px] flex items-center gap-3 shadow-sm flex-shrink-0">
                        <i class="fa-solid fa-clock-rotate-left text-amber-500 text-sm"></i>
                        <span class="text-[11px] font-bold text-amber-700 uppercase tracking-tight">Batas Jam Masuk: {{ $maxTime }}</span>
                    </div>
                </div>
            </x-slot:put_something>

            <x-slot:table_header>
                <x-tb-td nama="pegawai" sorting="true">Pegawai</x-tb-td>
                <x-tb-td nama="unit" sorting="true">Unit Kerja</x-tb-td>
                <x-tb-td nama="avg_checkin" sorting="true">Rata-rata Jam Masuk</x-tb-td>
                <x-tb-td nama="total_late" sorting="true">Total Keterlambatan</x-tb-td>
                <x-tb-td nama="status" sorting="false">Status Disiplin</x-tb-td>
            </x-slot:table_header>
            <x-slot:table_column>
                @foreach ($report as $row)
                    <x-tb-cl id="{{ $row['user']->id }}">
                        <x-tb-cl-fill>
                            <div class="flex items-center gap-3 text-left">
                                <div class="w-8 h-8 rounded-full bg-gray-100 flex items-center justify-center text-gray-400 font-bold text-[10px] border border-gray-200">
                                    {{ substr($row['user']->nama_lengkap, 0, 1) }}
                                </div>
                                <span class="font-bold text-gray-900">{{ $row['user']->nama_lengkap }}</span>
                            </div>
                        </x-tb-cl-fill>
                        <x-tb-cl-fill>
                            <span class="text-[10px] font-bold text-gray-500 uppercase">{{ $row['user']->unit?->nama_unit ?? 'General' }}</span>
                        </x-tb-cl-fill>
                        <x-tb-cl-fill>
                            <span class="font-black {{ ($row['avg_check_in'] > $maxTime) ? 'text-red-600' : 'text-gray-900' }}">
                                {{ $row['avg_check_in'] ?? '—' }}
                            </span>
                        </x-tb-cl-fill>
                        <x-tb-cl-fill>
                            <div class="flex items-center gap-2 justify-center">
                                <span class="text-lg font-black {{ ($row['tardiness_count'] > 3) ? 'text-red-600' : 'text-gray-900' }}">
                                    {{ $row['tardiness_count'] }}
                                </span>
                                <span class="text-[9px] font-bold text-gray-400 uppercase">Kali</span>
                            </div>
                        </x-tb-cl-fill>
                        <x-tb-cl-fill>
                            @if($row['tardiness_count'] > 3)
                                <span class="px-2.5 py-1 rounded-full bg-red-50 text-red-700 border border-red-100 text-[9px] font-black uppercase tracking-tighter">
                                    PERLU TEGURAN
                                </span>
                            @elseif($row['tardiness_count'] > 0)
                                <span class="px-2.5 py-1 rounded-full bg-amber-50 text-amber-700 border border-amber-100 text-[9px] font-black uppercase tracking-tighter">
                                    PERINGATAN
                                </span>
                            @else
                                <span class="px-2.5 py-1 rounded-full bg-emerald-50 text-emerald-700 border border-emerald-100 text-[9px] font-black uppercase tracking-tighter">
                                    DISIPLIN
                                </span>
                            @endif
                        </x-tb-cl-fill>
                    </x-tb-cl>
                @endforeach
            </x-slot:table_column>
        </x-tb>

    </div>
@endsection
