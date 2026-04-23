@extends('kinerja_pegawai.base')

@section('page-name')
    <div class="flex flex-col md:flex-row items-center gap-[11.75px] self-stretch px-1 pt-[14.68px] pb-[13.95px]">
        <div class="flex w-full flex-col gap-[2.93px] grow">
            <div class="flex items-center gap-[5.87px] self-stretch">
                <span class="font-medium text-2xl leading-[20.56px] text-[#101828]">Presensi dan Jam Kerja</span>
            </div>
            <span class="font-normal text-[10.28px] leading-[14.68px] text-[#1f2028]">Monitoring kehadiran dan akumulasi jam kerja pegawai</span>
        </div>
    </div>
@endsection

@section('content-base')
    {{-- ── Statistics Summary ────────────────────────── --}}
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
        <div class="bg-white p-5 rounded-2xl border border-[#f2f2f7] shadow-sm">
            <p class="text-[10px] font-bold text-gray-400 uppercase tracking-[0.1em] mb-1">Total Pegawai</p>
            <p class="text-2xl font-bold text-[#1d1d1f]">{{ $summary['total_pegawai'] }}</p>
        </div>
        <div class="bg-white p-5 rounded-2xl border border-[#f2f2f7] shadow-sm">
            <p class="text-[10px] font-bold text-gray-400 uppercase tracking-[0.1em] mb-1">Avg. Jam Kerja</p>
            <p class="text-2xl font-bold text-[#007AFF]">{{ $summary['avg_jam_kerja'] }}h</p>
        </div>
        <div class="bg-white p-5 rounded-2xl border border-[#f2f2f7] shadow-sm">
            <p class="text-[10px] font-bold text-gray-400 uppercase tracking-[0.1em] mb-1">Avg. Kehadiran</p>
            <p class="text-2xl font-bold text-[#34c759]">{{ $summary['avg_kehadiran'] }}%</p>
        </div>
        <div class="bg-white p-5 rounded-2xl border border-[#f2f2f7] shadow-sm">
            <p class="text-[10px] font-bold text-gray-400 uppercase tracking-[0.1em] mb-1">Masalah Tap Pulang</p>
            <p class="text-2xl font-bold text-[#ff3b30]">{{ $summary['masalah_tap'] }}</p>
        </div>
    </div>

    {{-- ── Data Table ────────────────────────────────── --}}
    <div class="flex flex-grow-0 flex-col gap-2 max-w-100">
        <x-tb id="presensiTable" :search_status="true">
            <x-slot:put_something>
                <form action="{{ route('manage.presensi.index') }}" method="GET" class="flex items-center gap-2">
                    <select name="month" class="border border-gray-200 rounded-xl px-3 py-[11px] text-sm focus:ring-blue-500 transition-all bg-[#f5f5f7] leading-none">
                        @foreach(range(1, 12) as $m)
                            <option value="{{ $m }}" {{ request('month', date('n')) == $m ? 'selected' : '' }}>
                                {{ date('F', mktime(0, 0, 0, $m, 1)) }}
                            </option>
                        @endforeach
                    </select>
                    <select name="year" class="border border-gray-200 rounded-xl px-3 py-[11px] text-sm focus:ring-blue-500 transition-all bg-[#f5f5f7] leading-none">
                        @foreach(range(date('Y'), date('Y')-2) as $y)
                            <option value="{{ $y }}" {{ request('year', date('Y')) == $y ? 'selected' : '' }}>{{ $y }}</option>
                        @endforeach
                    </select>
                    <button type="submit" class="bg-[#0070ff] text-white px-5 py-[11px] rounded-xl text-sm font-bold hover:bg-[#005fe0] transition-all leading-none">Filter</button>
                </form>
            </x-slot:put_something>

            <x-slot:table_header>
                <x-tb-td nama="pegawai" sorting="true">Pegawai</x-tb-td>
                <x-tb-td nama="periode" sorting="true">Periode</x-tb-td>
                <x-tb-td nama="jam_kerja" sorting="true">Jam Kerja</x-tb-td>
                <x-tb-td nama="kehadiran" sorting="true">Kehadiran</x-tb-td>
                <x-tb-td nama="tepat_waktu" sorting="true">Tepat Waktu</x-tb-td>
                <x-tb-td nama="tidak_tap" sorting="true">Masalah Tap</x-tb-td>
            </x-slot:table_header>
            <x-slot:table_column>
                @foreach ($items as $item)
                    <x-tb-cl id="{{ $item->id }}">
                        <x-tb-cl-fill>
                            <div class="flex items-center gap-3 text-left">
                                <div class="w-9 h-9 rounded-full bg-blue-50 flex items-center justify-center text-blue-600 font-bold text-xs border border-blue-100 shrink-0">
                                    {{ substr($item->fullname, 0, 1) }}
                                </div>
                                <div>
                                    <p class="font-bold text-[#1d1d1f] leading-tight">{{ $item->fullname }}</p>
                                    <p class="text-[11px] text-[#86868b] font-medium">{{ $item->employee_id }}</p>
                                </div>
                            </div>
                        </x-tb-cl-fill>
                        <x-tb-cl-fill>
                            <span class="text-gray-600">
                                {{ date('F', mktime(0, 0, 0, $item->month, 1)) }} {{ $item->year }}
                            </span>
                        </x-tb-cl-fill>
                        <x-tb-cl-fill>
                            <span class="font-bold text-[#1d1d1f]">{{ $item->jam_kerja }}</span>
                            <span class="text-[10px] text-[#86868b] ml-0.5 font-bold uppercase">Jam</span>
                        </x-tb-cl-fill>
                        <x-tb-cl-fill>
                            <div class="flex items-center gap-2">
                                <div class="w-16 bg-[#f5f5f7] h-2 rounded-full overflow-hidden">
                                    <div class="bg-[#34c759] h-full" style="width: {{ $item->kehadiran }}%"></div>
                                </div>
                                <span class="font-bold text-[#1d1d1f] text-xs">{{ $item->kehadiran }}%</span>
                            </div>
                        </x-tb-cl-fill>
                        <x-tb-cl-fill>
                            <span class="px-2.5 py-1 rounded-full bg-[#f5f5f7] text-[#1d1d1f] font-bold text-[11px] border border-[#e5e5ea]">
                                {{ $item->tepat_waktu }}x
                            </span>
                        </x-tb-cl-fill>
                        <x-tb-cl-fill>
                            @if($item->tidak_tap_pulang > 0)
                                <span class="px-2.5 py-1 rounded-full bg-red-50 text-[#ff3b30] font-bold text-[11px] border border-red-100">
                                    {{ $item->tidak_tap_pulang }} Masalah
                                </span>
                            @else
                                <span class="text-[#aeaeb2] text-xs">—</span>
                            @endif
                        </x-tb-cl-fill>
                    </x-tb-cl>
                @endforeach
            </x-slot:table_column>
        </x-tb>

        @if($items->hasPages())
            <div class="mt-4 px-1">
                {{ $items->links() }}
            </div>
        @endif
    </div>
@endsection
