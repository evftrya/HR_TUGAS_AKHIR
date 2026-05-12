@php
    $isAdmin = auth()->user()->is_admin;
    $role = auth()->user()->role;
@endphp

@extends('kinerja_pegawai.base')

@section('page-name', (isset($role) && $role === 'pegawai' && !$isAdmin) ? 'Riwayat Presensi Pribadi' : 'Presensi dan Jam Kerja Pegawai')

@section('content-base')
<div class="mb-4">
    <p class="text-sm text-gray-500 italic">
        @if(isset($role) && $role === 'pegawai' && !$isAdmin)
            Monitoring kehadiran and riwayat jam kerja Anda.
        @else
            Monitoring kehadiran and akumulasi jam kerja seluruh pegawai.
        @endif
    </p>
</div>
<div class="w-full max-w-7xl mx-auto p-4 sm:p-6 lg:p-8 bg-white rounded-lg shadow-sm border border-gray-100">
    
    {{-- Statistics Summary --}}
    @if(isset($role) && $role === 'pegawai' && !$isAdmin)
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <div class="bg-gray-50 p-6 rounded-xl border border-gray-200">
            <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-1">Jam Kerja Saya</p>
            <p class="text-3xl font-bold text-blue-600">{{ $summary['avg_jam_kerja'] }} <span class="text-sm font-semibold text-gray-400 uppercase">Jam</span></p>
        </div>
        <div class="bg-gray-50 p-6 rounded-xl border border-gray-200">
            <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-1">Rata-Rata Kehadiran</p>
            <p class="text-3xl font-bold text-green-600">{{ $summary['avg_kehadiran'] }}%</p>
        </div>
        <div class="bg-gray-50 p-6 rounded-xl border border-gray-200">
            <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-1">Masalah Tap Pulang</p>
            <p class="text-3xl font-bold text-red-600">{{ $summary['masalah_tap'] }}</p>
        </div>
    </div>
    @else
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <div class="bg-gray-50 p-6 rounded-xl border border-gray-200">
            <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-1">Total Pegawai</p>
            <p class="text-3xl font-bold text-gray-800">{{ $summary['total_pegawai'] }}</p>
        </div>
        <div class="bg-gray-50 p-6 rounded-xl border border-gray-200">
            <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-1">Avg. Jam Kerja</p>
            <p class="text-3xl font-bold text-blue-600">{{ $summary['avg_jam_kerja'] }} <span class="text-sm font-semibold text-gray-400 uppercase">Jam</span></p>
        </div>
        <div class="bg-gray-50 p-6 rounded-xl border border-gray-200">
            <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-1">Avg. Kehadiran</p>
            <p class="text-3xl font-bold text-green-600">{{ $summary['avg_kehadiran'] }}%</p>
        </div>
        <div class="bg-gray-50 p-6 rounded-xl border border-gray-200">
            <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-1">Masalah Tap</p>
            <p class="text-3xl font-bold text-red-600">{{ $summary['masalah_tap'] }}</p>
        </div>
    </div>
    @endif

    {{-- Filter Header --}}
    <div class="flex flex-col md:flex-row md:items-center justify-between mb-6 gap-4 border-b border-gray-100 pb-6">
        <h3 class="text-lg font-semibold text-gray-700">Data Presensi Bulanan</h3>
        <form action="{{ route('manage.presensi.index') }}" method="GET" class="flex flex-wrap items-center gap-2">
            <select name="month" class="text-sm border-gray-300 rounded-md shadow-sm focus:ring-blue-500">
                @foreach (range(1, 12) as $m)
                    <option value="{{ $m }}" {{ request('month', date('n')) == $m ? 'selected' : '' }}>
                        {{ date('F', mktime(0, 0, 0, $m, 1)) }}
                    </option>
                @endforeach
            </select>
            <select name="year" class="text-sm border-gray-300 rounded-md shadow-sm focus:ring-blue-500">
                @foreach (range(date('Y'), date('Y') - 2) as $y)
                    <option value="{{ $y }}" {{ request('year', date('Y')) == $y ? 'selected' : '' }}>{{ $y }}</option>
                @endforeach
            </select>
            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium py-2 px-4 rounded-md transition duration-150 inline-flex items-center gap-2">
                <i class="fa-solid fa-filter text-xs"></i> Filter
            </button>
        </form>
    </div>

    <div class="overflow-x-auto border border-gray-200 rounded-lg">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    @if(!(isset($role) && $role === 'pegawai' && !$isAdmin))
                        <th class="px-6 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider text-left">Pegawai</th>
                    @endif
                    <th class="px-6 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider text-left">Periode</th>
                    <th class="px-6 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider text-center">Jam Kerja</th>
                    <th class="px-6 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider text-center">Kehadiran</th>
                    <th class="px-6 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider text-center">Tepat Waktu</th>
                    <th class="px-6 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider text-center">Masalah Tap</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @foreach ($items as $item)
                    <tr class="hover:bg-gray-50 transition-colors">
                        @if(!(isset($role) && $role === 'pegawai' && !$isAdmin))
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center gap-3">
                                    <div class="w-9 h-9 rounded-full bg-blue-50 flex items-center justify-center text-blue-600 font-bold text-xs border border-blue-100">
                                        {{ substr($item->fullname, 0, 1) }}
                                    </div>
                                    <div>
                                        <p class="text-sm font-bold text-gray-900">{{ $item->fullname }}</p>
                                        <p class="text-[10px] text-gray-400 font-semibold uppercase">{{ $item->employee_id }}</p>
                                    </div>
                                </div>
                            </td>
                        @endif
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700 font-medium">
                            {{ date('F', mktime(0, 0, 0, $item->month, 1)) }} {{ $item->year }}
                        </td>
                        <td class="px-6 py-4 text-center whitespace-nowrap">
                            <span class="text-sm font-bold text-gray-900">{{ $item->jam_kerja }}</span>
                            <span class="text-[10px] text-gray-400 font-bold uppercase ml-0.5">Jam</span>
                        </td>
                        <td class="px-6 py-4 text-center whitespace-nowrap">
                            <div class="flex flex-col items-center gap-1">
                                <span class="text-sm font-bold text-green-600">{{ $item->kehadiran }}%</span>
                                <div class="w-16 bg-gray-100 h-1 rounded-full overflow-hidden">
                                    <div class="bg-green-500 h-full" style="width: {{ $item->kehadiran }}%"></div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 text-center whitespace-nowrap">
                            <span class="px-3 py-1 rounded-full bg-gray-100 text-gray-800 font-bold text-[10px] border border-gray-200">
                                {{ $item->tepat_waktu }}x
                            </span>
                        </td>
                        <td class="px-6 py-4 text-center whitespace-nowrap">
                            @if($item->tidak_tap_pulang > 0)
                                <span class="px-3 py-1 rounded-full bg-red-100 text-red-700 font-bold text-[10px] border border-red-200">
                                    {{ $item->tidak_tap_pulang }} Masalah
                                </span>
                            @else
                                <span class="text-gray-300 text-xs font-medium">—</span>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    @if($items->hasPages())
        <div class="mt-6">
            {{ $items->links() }}
        </div>
    @endif
</div>
@endsection
