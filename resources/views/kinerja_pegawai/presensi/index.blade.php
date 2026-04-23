@extends('kinerja_pegawai.base')

@section('page-name')
    <div class="flex flex-col gap-[3px] px-1 pt-3 pb-2">
        <span class="font-semibold text-2xl text-[#101828]">Presensi dan Jam Kerja</span>
        <span class="text-xs text-gray-400">Monitoring kehadiran dan akumulasi jam kerja pegawai</span>
    </div>
@endsection

@section('content-base')
    {{-- ── Statistics Summary ────────────────────────── --}}
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
        <div class="bg-white p-5 rounded-2xl border border-gray-100 shadow-sm">
            <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1">Total Pegawai</p>
            <p class="text-2xl font-black text-gray-900">{{ $summary['total_pegawai'] }}</p>
        </div>
        <div class="bg-white p-5 rounded-2xl border border-gray-100 shadow-sm">
            <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1">Avg. Jam Kerja</p>
            <p class="text-2xl font-black text-blue-600">{{ $summary['avg_jam_kerja'] }}h</p>
        </div>
        <div class="bg-white p-5 rounded-2xl border border-gray-100 shadow-sm">
            <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1">Avg. Kehadiran</p>
            <p class="text-2xl font-black text-green-600">{{ $summary['avg_kehadiran'] }}%</p>
        </div>
        <div class="bg-white p-5 rounded-2xl border border-gray-100 shadow-sm">
            <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1">Masalah Tap Pulang</p>
            <p class="text-2xl font-black text-red-600">{{ $summary['masalah_tap'] }}</p>
        </div>
    </div>

    {{-- ── Filter & Search ───────────────────────────── --}}
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm mb-6 p-4">
        <form action="{{ route('manage.presensi.index') }}" method="GET" class="flex flex-wrap items-end gap-4">
            <div class="flex-1 min-w-[200px]">
                <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2">Cari Pegawai</label>
                <input type="text" name="search" value="{{ request('search') }}" 
                       placeholder="Nama atau NIK..."
                       class="w-full bg-gray-50 border-gray-200 rounded-xl text-sm focus:ring-blue-500 focus:border-blue-500">
            </div>
            
            <div class="w-32">
                <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2">Bulan</label>
                <select name="month" class="w-full bg-gray-50 border-gray-200 rounded-xl text-sm">
                    @foreach(range(1, 12) as $m)
                        <option value="{{ $m }}" {{ request('month', date('n')) == $m ? 'selected' : '' }}>
                            {{ date('F', mktime(0, 0, 0, $m, 1)) }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="w-24">
                <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2">Tahun</label>
                <select name="year" class="w-full bg-gray-50 border-gray-200 rounded-xl text-sm">
                    @foreach(range(date('Y'), date('Y')-2) as $y)
                        <option value="{{ $y }}" {{ request('year', date('Y')) == $y ? 'selected' : '' }}>{{ $y }}</option>
                    @endforeach
                </select>
            </div>

            <button type="submit" class="bg-blue-600 text-white px-6 py-2.5 rounded-xl font-bold text-sm hover:bg-blue-700 transition-colors">
                Filter
            </button>
        </form>
    </div>

    {{-- ── Data Table ────────────────────────────────── --}}
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse text-sm">
                <thead>
                    <tr class="text-[10px] font-black text-gray-400 uppercase tracking-[0.15em] bg-gray-50/50 border-b border-gray-50">
                        <th class="px-6 py-4">Pegawai</th>
                        <th class="px-6 py-4">Periode</th>
                        <th class="px-6 py-4">Jam Kerja</th>
                        <th class="px-6 py-4">Kehadiran</th>
                        <th class="px-6 py-4">Tepat Waktu</th>
                        <th class="px-6 py-4">Masalah Tap</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @forelse ($items as $item)
                        <tr class="hover:bg-gray-50/50 transition-colors">
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-8 h-8 rounded-full bg-blue-50 flex items-center justify-center text-blue-600 font-black text-[10px] border border-blue-100">
                                        {{ substr($item->fullname, 0, 1) }}
                                    </div>
                                    <div>
                                        <p class="font-bold text-gray-900 leading-tight">{{ $item->fullname }}</p>
                                        <p class="text-[10px] text-gray-400 font-medium">{{ $item->employee_id }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 font-medium text-gray-600">
                                {{ date('F', mktime(0, 0, 0, $item->month, 1)) }} {{ $item->year }}
                            </td>
                            <td class="px-6 py-4">
                                <span class="font-bold text-gray-900">{{ $item->jam_kerja }}</span>
                                <span class="text-[10px] text-gray-400 ml-0.5 font-bold uppercase">Hours</span>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-2">
                                    <div class="w-16 bg-gray-100 h-1.5 rounded-full overflow-hidden">
                                        <div class="bg-green-500 h-full" style="width: {{ $item->kehadiran }}%"></div>
                                    </div>
                                    <span class="font-bold text-gray-700 text-xs">{{ $item->kehadiran }}%</span>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <span class="px-2 py-1 rounded-lg bg-blue-50 text-blue-700 font-bold text-[10px]">
                                    {{ $item->tepat_waktu }}x
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                @if($item->tidak_tap_pulang > 0)
                                    <span class="px-2 py-1 rounded-lg bg-red-50 text-red-700 font-bold text-[10px]">
                                        {{ $item->tidak_tap_pulang }} Masalah
                                    </span>
                                @else
                                    <span class="text-gray-300 text-xs">—</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-12 text-center text-gray-400">
                                <i class="fa-solid fa-clock-rotate-left fa-2x mb-3 block opacity-20"></i>
                                Tidak ada data presensi ditemukan.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        @if($items->hasPages())
            <div class="px-6 py-4 bg-gray-50/30 border-t border-gray-50">
                {{ $items->links() }}
            </div>
        @endif
    </div>
@endsection
