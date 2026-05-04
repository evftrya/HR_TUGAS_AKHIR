@php
    $active_sidebar = 'Target Kinerja';
@endphp

@extends('kinerja_pegawai.base')

@section('page-name')
    <div class="flex flex-col md:flex-row items-center gap-[11.75px] self-stretch px-1 pt-[14.68px] pb-[13.95px]">
        <div class="flex w-full flex-col gap-[2.93px] grow">
            <div class="flex items-center gap-[5.87px] self-stretch">
                <span class="font-medium text-2xl leading-[20.56px] text-[#101828]">Daftar Target Harian</span>
            </div>
            <span class="font-normal text-[10.28px] leading-[14.68px] text-[#1f2028]">Daftar set target harian dan progres capaian</span>
        </div>
        <div class="flex items-center w-full justify-end gap-[11.75px]">
            <a href="{{ route('manage.laporan.print') }}" target="_blank" class="flex rounded-[5.87px]">
                <div class="flex justify-center items-center gap-[5.87px] bg-red-600 px-[11.75px] py-[7.34px] rounded-[5.87px] border border-red-600 hover:bg-red-700 transition">
                    <i class="fa-solid fa-file-pdf text-sm text-white"></i>
                    <span class="font-medium text-[10.28px] leading-[14.68px] text-white">Cetak PDF</span>
                </div>
            </a>
            <a href="{{ route('manage.laporan.export') }}" class="flex rounded-[5.87px]">
                <div class="flex justify-center items-center gap-[5.87px] bg-emerald-600 px-[11.75px] py-[7.34px] rounded-[5.87px] border border-emerald-600 hover:bg-emerald-700 transition">
                    <i class="fa-solid fa-file-excel text-sm text-white"></i>
                    <span class="font-medium text-[10.28px] leading-[14.68px] text-white">Export Excel</span>
                </div>
            </a>
            <a href="{{ route('manage.target-kinerja.harian.input') }}" class="flex rounded-[5.87px]">
                <div class="flex justify-center items-center gap-[5.87px] bg-[#0070ff] px-[11.75px] py-[7.34px] rounded-[5.87px] border border-[#0070ff] hover:bg-[#005fe0] transition">
                    <i class="bi bi-plus text-sm text-white"></i>
                    <span class="font-medium text-[10.28px] leading-[14.68px] text-white">Tambah</span>
                </div>
            </a>
        </div>
    </div>
@endsection

@section('content-base')
    <div class="flex flex-grow-0 flex-col gap-2 max-w-100">
        {{-- ── Top 5 Leaderboard ────────────────────────── --}}
        <div class="px-1 mb-4">
            <h3 class="font-bold text-gray-900 tracking-tight text-lg">Top 5 Kinerja Bulan Ini</h3>
            <p class="text-xs text-gray-500">Pegawai dengan kontribusi waktu terbaik pada bulan {{ now()->translatedFormat('F Y') }}</p>
        </div>

        <div class="bg-white rounded-3xl border border-gray-100 shadow-sm p-6 mb-8">
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-4">
                @foreach($leaderboard as $index => $row)
                    <div class="relative flex flex-col items-center p-4 rounded-2xl border border-gray-50 bg-gray-50/50 hover:bg-white hover:shadow-md transition-all group">
                        <div class="absolute top-2 left-3">
                            @if($index == 0)
                                <i class="fa-solid fa-trophy text-yellow-400 text-xl"></i>
                            @elseif($index == 1)
                                <i class="fa-solid fa-medal text-gray-400 text-xl"></i>
                            @elseif($index == 2)
                                <i class="fa-solid fa-medal text-amber-600 text-xl"></i>
                            @else
                                <span class="text-sm font-bold text-gray-300">#{{ $index + 1 }}</span>
                            @endif
                        </div>
                        
                        <div class="w-12 h-12 rounded-full bg-blue-100 flex items-center justify-center text-blue-600 font-bold text-lg mb-3 group-hover:bg-blue-600 group-hover:text-white transition-colors">
                            {{ strtoupper(substr($row->pelapor?->nama_lengkap ?? '?', 0, 1)) }}
                        </div>
                        
                        <p class="text-xs font-bold text-gray-900 text-center line-clamp-1 mb-1">{{ $row->pelapor?->nama_lengkap ?? '-' }}</p>
                        <div class="flex flex-col items-center">
                            <p class="text-[10px] font-black text-blue-600 uppercase tracking-widest">
                                {{ round($row->total_minutes / 60, 1) }} Jam
                            </p>
                            <p class="text-[8px] text-gray-400 font-bold uppercase">{{ $row->total_minutes }} Menit</p>
                        </div>
                    </div>
                @endforeach
                
                @if($leaderboard->isEmpty())
                    <div class="col-span-full py-8 text-center">
                        <p class="text-sm text-gray-400">Belum ada data kinerja bulan ini</p>
                    </div>
                @endif
            </div>
        </div>

        @if(session('success'))<div class="mb-4 p-3 bg-green-100 text-green-700 rounded">{{ session('success') }}</div>@endif
        <x-tb id="targetHarianTable" :search_status="true">
            <x-slot:table_header>
                <x-tb-td nama="pekerjaan" sorting=true>Pekerjaan</x-tb-td>
                <x-tb-td nama="target_kinerja" sorting=true>Target Kinerja</x-tb-td>
                <x-tb-td nama="jumlah" sorting=true>Jumlah</x-tb-td>
                <x-tb-td nama="waktu" sorting=true>Waktu (menit)</x-tb-td>
                <x-tb-td nama="start" sorting=true>Start</x-tb-td>
                <x-tb-td nama="end" sorting=true>End</x-tb-td>
                <x-tb-td nama="action" sorting=false>Action</x-tb-td>
            </x-slot:table_header>
            <x-slot:table_column>
                @foreach($items as $i => $it)
                    <x-tb-cl id="{{ $it->id }}">
                        <x-tb-cl-fill>{{ $it->pekerjaan }}</x-tb-cl-fill>
                        <x-tb-cl-fill>
                            @if($it->targetKinerja)
                                <a href="{{ route('manage.target-kinerja.detail', $it->targetKinerja->id) }}" class="text-blue-600 font-bold hover:underline">
                                    {{ $it->targetKinerja->nama_kpi }}
                                </a>
                            @else
                                -
                            @endif
                        </x-tb-cl-fill>
                        <x-tb-cl-fill>{{ $it->jumlah ?? '-' }}</x-tb-cl-fill>
                        <x-tb-cl-fill>{{ $it->waktu_minutes ?? '-' }}</x-tb-cl-fill>
                        <x-tb-cl-fill>{{ $it->start ? \Carbon\Carbon::parse($it->start)->format('d/m/Y H:i') : '-' }}</x-tb-cl-fill>
                        <x-tb-cl-fill>{{ $it->end ? \Carbon\Carbon::parse($it->end)->format('d/m/Y H:i') : '-' }}</x-tb-cl-fill>
                        <x-tb-cl-fill>
                            <div class="flex items-center justify-center gap-3">
                                <a href="{{ route('manage.target-kinerja.harian.view', $it->id) }}" class="flex items-center justify-center w-7 h-7 rounded-md border border-[#d0d5dd] bg-white hover:bg-[#f9fafb] transition duration-150 ease-in-out text-blue-600" title="View">
                                    <i class="bi bi-eye"></i>
                                </a>
                                <a href="{{ route('manage.target-kinerja.harian.isi', $it->id) }}" class="flex items-center justify-center w-7 h-7 rounded-md border border-[#d0d5dd] bg-white hover:bg-[#f9fafb] transition duration-150 ease-in-out text-green-600" title="Isi Laporan">
                                    <i class="bi bi-journal-plus"></i>
                                </a>
                                <a href="{{ route('manage.target-kinerja.harian.assign', $it->id) }}" class="flex items-center justify-center w-7 h-7 rounded-md border border-[#d0d5dd] bg-white hover:bg-[#f9fafb] transition duration-150 ease-in-out text-indigo-600" title="Assign Pegawai">
                                    <i class="bi bi-person-plus"></i>
                                </a>
                                <form action="{{ route('manage.target-kinerja.harian.destroy', $it->id) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button onclick="return confirm('Hapus?')" class="flex items-center justify-center w-7 h-7 rounded-md border border-[#d0d5dd] bg-white hover:bg-[#f9fafb] transition duration-150 ease-in-out text-red-600" title="Hapus">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </x-tb-cl-fill>
                    </x-tb-cl>
                @endforeach
            </x-slot:table_column>
        </x-tb>
        <div class="mt-4">
            {{ $items->links() }}
        </div>
    </div>
@endsection
