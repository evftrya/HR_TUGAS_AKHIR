@php
    $active_sidebar = 'KM & Sasaran Mutu';
@endphp

@extends('kinerja_pegawai.base')

@section('page-name')
    <div class="flex flex-col md:flex-row items-center gap-[11.75px] self-stretch px-1 pt-[14.68px] pb-[13.95px]">
        <div class="flex w-full flex-col gap-[2.93px] grow">
            <div class="flex items-center gap-[5.87px] self-stretch">
                <span class="font-medium text-2xl leading-[20.56px] text-[#101828]">Laporan KM & Sasaran Mutu</span>
            </div>
            <span class="font-normal text-[10.28px] leading-[14.68px] text-[#1f2028]">Monitoring capaian indikator dan log pengerjaan harian</span>
        </div>
    </div>
@endsection

@section('content-base')
    <div class="flex flex-col gap-6">
        @if(session('success'))<div class="mb-4 p-3 bg-green-100 text-green-700 rounded-xl text-sm font-bold">{{ session('success') }}</div>@endif
        
        {{-- Tabel 1: Daftar Indikator KM & Sasaran Mutu --}}
        <div class="bg-white rounded-[32px] border border-gray-100 shadow-sm overflow-hidden">
            <div class="p-6 border-b border-gray-50 flex items-center justify-between bg-gray-50/30">
                <h3 class="font-bold text-gray-800 flex items-center gap-2">
                    <i class="fa-solid fa-layer-group text-blue-600"></i>
                    Daftar Indikator KM & Sasaran Mutu
                </h3>
                {{-- Global Filter --}}
                <form method="GET" class="flex items-center gap-2">
                    <select name="user_id" class="text-[10px] font-bold border-gray-200 rounded-lg px-2 py-1 focus:ring-blue-500">
                        <option value="">Semua Pegawai</option>
                        @foreach ($allUsers as $user)
                            <option value="{{ $user->id }}" {{ request('user_id') == $user->id ? 'selected' : '' }}>{{ $user->nama_lengkap }}</option>
                        @endforeach
                    </select>
                    <button type="submit" class="p-1.5 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                        <i class="fa-solid fa-filter text-[10px]"></i>
                    </button>
                </form>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead>
                        <tr class="bg-gray-50/50 border-b border-gray-100">
                            <th class="px-6 py-4 text-[10px] font-black text-gray-400 uppercase tracking-widest">Indikator</th>
                            <th class="px-6 py-4 text-[10px] font-black text-gray-400 uppercase tracking-widest">Unit</th>
                            <th class="px-6 py-4 text-[10px] font-black text-gray-400 uppercase tracking-widest text-center">TW I</th>
                            <th class="px-6 py-4 text-[10px] font-black text-gray-400 uppercase tracking-widest text-center">TW II</th>
                            <th class="px-6 py-4 text-[10px] font-black text-gray-400 uppercase tracking-widest text-center">TW III</th>
                            <th class="px-6 py-4 text-[10px] font-black text-gray-400 uppercase tracking-widest text-center">TW IV</th>
                            <th class="px-6 py-4 text-[10px] font-black text-gray-400 uppercase tracking-widest text-center">Progress</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50">
                        @foreach($targetKinerjaList as $target)
                            @php
                                $totalTarget = $target->tw1_target + $target->tw2_target + $target->tw3_target + $target->tw4_target;
                                $realisasi = 0;
                                foreach($target->targetHarian as $harian) {
                                    $realisasi += $harian->pelaporan()->where('status', 'approved')->sum('approved_jumlah');
                                }
                                $progress = $totalTarget > 0 ? min(round(($realisasi / $totalTarget) * 100, 1), 100) : 0;
                            @endphp
                            <tr class="hover:bg-gray-50/30 transition-colors">
                                <td class="px-6 py-4">
                                    <p class="text-sm font-bold text-gray-800 leading-tight">{{ $target->nama_kpi }}</p>
                                    <span class="text-[9px] font-black px-2 py-0.5 rounded bg-gray-100 text-gray-500 uppercase">{{ $target->jenis ?? 'KM' }}</span>
                                </td>
                                <td class="px-6 py-4 text-xs font-medium text-gray-600">{{ $target->unit->nama_unit ?? '-' }}</td>
                                <td class="px-6 py-4 text-center text-xs font-bold text-gray-700">{{ number_format($target->tw1_target) }}</td>
                                <td class="px-6 py-4 text-center text-xs font-bold text-gray-700">{{ number_format($target->tw2_target) }}</td>
                                <td class="px-6 py-4 text-center text-xs font-bold text-gray-700">{{ number_format($target->tw3_target) }}</td>
                                <td class="px-6 py-4 text-center text-xs font-bold text-gray-700">{{ number_format($target->tw4_target) }}</td>
                                <td class="px-6 py-4">
                                    <div class="flex flex-col items-center gap-1">
                                        <span class="text-[10px] font-black text-blue-600">{{ $progress }}%</span>
                                        <div class="w-16 h-1.5 bg-gray-100 rounded-full overflow-hidden">
                                            <div class="h-full bg-blue-500" style="width: {{ $progress }}%"></div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Tabel 2: Log Kinerja Harian Terkini --}}
        <div class="bg-white rounded-[32px] border border-gray-100 shadow-sm overflow-hidden">
            <div class="p-6 border-b border-gray-50 bg-gray-50/30">
                <h3 class="font-bold text-gray-800 flex items-center gap-2">
                    <i class="fa-solid fa-clock-rotate-left text-indigo-600"></i>
                    Log Kinerja Harian Terkini
                </h3>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead>
                        <tr class="bg-gray-50/50 border-b border-gray-100">
                            <th class="px-6 py-4 text-[10px] font-black text-gray-400 uppercase tracking-widest">Pekerjaan</th>
                            <th class="px-6 py-4 text-[10px] font-black text-gray-400 uppercase tracking-widest">Realisasi</th>
                            <th class="px-6 py-4 text-[10px] font-black text-gray-400 uppercase tracking-widest text-center">Capaian</th>
                            <th class="px-6 py-4 text-[10px] font-black text-gray-400 uppercase tracking-widest text-center">Waktu</th>
                            <th class="px-6 py-4 text-[10px] font-black text-gray-400 uppercase tracking-widest text-center">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50">
                        @forelse($pelaporanItems as $it)
                            <tr class="hover:bg-gray-50/30 transition-colors">
                                <td class="px-6 py-4">
                                    <p class="text-sm font-bold text-gray-800 leading-tight">{{ $it->targetHarian->pekerjaan ?? '-' }}</p>
                                    <p class="text-[9px] text-gray-400 font-medium">By: {{ $it->pembuat_laporan->nama_lengkap ?? 'Unknown' }}</p>
                                </td>
                                <td class="px-6 py-4 text-xs text-gray-600">{{ Str::limit($it->realisasi, 50) }}</td>
                                <td class="px-6 py-4 text-center text-xs font-black text-gray-700">{{ $it->approved_jumlah ?? $it->realisasi_jumlah }}</td>
                                <td class="px-6 py-4 text-center text-xs font-medium text-gray-500">{{ $it->approved_waktu_minutes ?? $it->realisasi_waktu_minutes }} Min</td>
                                <td class="px-6 py-4 text-center">
                                    <span class="px-2 py-0.5 rounded-full text-[9px] font-black uppercase
                                        {{ $it->status == 'approved' ? 'bg-green-50 text-green-700' : ($it->status == 'rejected' ? 'bg-red-50 text-red-700' : 'bg-yellow-50 text-yellow-700') }}">
                                        {{ $it->status ?? 'pending' }}
                                    </span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-12 text-center">
                                    <p class="text-sm font-bold text-gray-400 italic">Belum ada log kinerja harian.</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="p-4 border-t border-gray-50">
                {{ $pelaporanItems->links() }}
            </div>
        </div>
    </div>
@endsection
