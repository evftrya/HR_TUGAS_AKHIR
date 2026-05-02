@php
    $active_sidebar = 'Target Kinerja';
@endphp

@extends('kinerja_pegawai.base')

@section('page-name')
    <div class="flex flex-col md:flex-row items-center gap-[11.75px] self-stretch px-1 pt-[14.68px] pb-[13.95px]">
        <div class="flex w-full flex-col gap-[2.93px] grow">
            <div class="flex items-center gap-[5.87px] self-stretch">
                <span class="font-medium text-2xl leading-[20.56px] text-[#101828]">Daftar Laporan Pekerjaan</span>
            </div>
            <span class="font-normal text-[10.28px] leading-[14.68px] text-[#1f2028]">Daftar laporan untuk approval</span>
        </div>
    </div>
@endsection

@section('content-base')
    <div class="flex flex-grow-0 flex-col gap-2 max-w-100">
        {{-- SECTION TITLE --}}
        <div class="px-1 mb-4">
            <h3 class="font-bold text-gray-900 tracking-tight text-lg">Monitoring Kecepatan Verifikasi (SLA)</h3>
            <p class="text-xs text-gray-500">Statistik pemrosesan laporan pada bulan {{ now()->translatedFormat('F Y') }}</p>
        </div>

        {{-- WIDGET SLA - FITUR 2G1 (INFORMATIVE VERSION) --}}
        <div class="mb-8 grid grid-cols-1 md:grid-cols-3 gap-5">
            <!-- Card 1: Main SLA Average -->
            <div class="bg-white rounded-3xl border border-gray-100 shadow-sm p-6 flex flex-col justify-between group hover:shadow-md transition-all border-b-4 {{ $slaStats['avg_hours'] <= 48 ? 'border-b-green-500' : 'border-b-red-500' }}">
                <div class="flex items-center justify-between mb-4">
                    <div class="p-3 {{ $slaStats['avg_hours'] <= 48 ? 'bg-green-50 text-green-600' : 'bg-red-50 text-red-600' }} rounded-2xl flex-shrink-0">
                        <i class="fa-solid fa-bolt-lightning fa-lg"></i>
                    </div>
                    <span class="text-[10px] font-bold {{ $slaStats['avg_hours'] <= 48 ? 'text-green-600 bg-green-50' : 'text-red-600 bg-red-50' }} px-2 py-1 rounded-full uppercase tracking-tight">
                        {{ $slaStats['avg_hours'] <= 48 ? 'Responsif' : 'Lambat' }}
                    </span>
                </div>
                <div>
                    <p class="text-3xl font-black {{ $slaStats['avg_hours'] <= 48 ? 'text-green-600' : 'text-red-600' }}">
                        @if($slaStats['avg_hours'] >= 24)
                            {{ round($slaStats['avg_hours'] / 24, 1) }} <span class="text-sm font-bold uppercase">Hari</span>
                        @else
                            {{ $slaStats['avg_hours'] }} <span class="text-sm font-bold uppercase">Jam</span>
                        @endif
                    </p>
                    <p class="text-xs font-bold text-gray-500 uppercase tracking-widest mt-1">Rata-rata SLA</p>
                    <p class="text-[10px] text-gray-400 mt-2 font-medium">Target Benchmark: < 48 Jam</p>
                </div>
            </div>

            <!-- Card 2: Status Breakdown -->
            <div class="bg-white rounded-3xl border border-gray-100 shadow-sm p-6 flex flex-col justify-between group hover:shadow-md transition-all">
                <div class="flex items-center gap-3 mb-4 text-gray-400">
                    <i class="fa-solid fa-chart-pie text-lg"></i>
                    <span class="text-[10px] font-bold uppercase tracking-widest">Aktivitas Bulan Ini</span>
                </div>
                <div class="space-y-3">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-2">
                            <div class="w-2 h-2 rounded-full bg-green-500"></div>
                            <span class="text-xs font-medium text-gray-600">Disetujui</span>
                        </div>
                        <span class="text-xs font-bold text-gray-900">{{ $slaStats['approved_count'] }}</span>
                    </div>
                    <div class="w-full bg-gray-100 h-1.5 rounded-full overflow-hidden">
                        @php $approvedPct = $slaStats['total_processed'] > 0 ? ($slaStats['approved_count'] / $slaStats['total_processed']) * 100 : 0; @endphp
                        <div class="bg-green-500 h-full" style="width: {{ $approvedPct }}%"></div>
                    </div>
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-2">
                            <div class="w-2 h-2 rounded-full bg-red-500"></div>
                            <span class="text-xs font-medium text-gray-600">Ditolak</span>
                        </div>
                        <span class="text-xs font-bold text-gray-900">{{ $slaStats['rejected_count'] }}</span>
                    </div>
                    <div class="w-full bg-gray-100 h-1.5 rounded-full overflow-hidden">
                        @php $rejectedPct = $slaStats['total_processed'] > 0 ? ($slaStats['rejected_count'] / $slaStats['total_processed']) * 100 : 0; @endphp
                        <div class="bg-red-500 h-full" style="width: {{ $rejectedPct }}%"></div>
                    </div>
                </div>
            </div>

            <!-- Card 3: Workload -->
            <div class="bg-white rounded-3xl border border-gray-100 shadow-sm p-6 flex flex-col justify-between group hover:shadow-md transition-all">
                <div class="flex items-center gap-3 mb-4 text-gray-400">
                    <i class="fa-solid fa-layer-group text-lg"></i>
                    <span class="text-[10px] font-bold uppercase tracking-widest">Beban Kerja</span>
                </div>
                <div class="flex items-end justify-between">
                    <div>
                        <p class="text-3xl font-black text-gray-900">{{ $slaStats['pending_count'] }}</p>
                        <p class="text-xs font-bold text-yellow-600 uppercase tracking-widest mt-1">Pending Approval</p>
                    </div>
                    <div class="text-right">
                        <p class="text-xl font-black text-gray-700">{{ $slaStats['total_processed'] }}</p>
                        <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">Total Selesai</p>
                    </div>
                </div>
            </div>
        </div>

        @if(session('success'))<div class="mb-4 p-3 bg-green-100 text-green-700 rounded">{{ session('success') }}</div>@endif
        <x-tb id="pelaporanTable" :search_status="true">
            <x-slot:table_header>
                {{-- <x-tb-td nama="no" sorting=false>No</x-tb-td> --}}
                <x-tb-td nama="target_harian" sorting=true>Target Harian</x-tb-td>
                <x-tb-td nama="realisasi" sorting=false>Realisasi</x-tb-td>
                <x-tb-td nama="realisasi_jumlah" sorting=true>Realisasi Jumlah</x-tb-td>
                <x-tb-td nama="realisasi_waktu" sorting=true>Realisasi Waktu</x-tb-td>
                <x-tb-td nama="status" sorting=true>Status Approval</x-tb-td>
                <x-tb-td nama="action" sorting=false>Action</x-tb-td>
            </x-slot:table_header>
            <x-slot:table_column>
                @foreach($items as $i => $it)
                    <x-tb-cl id="{{ $it->id }}">
                        {{-- <x-tb-cl-fill>{{ $i+1 }}</x-tb-cl-fill> --}}
                        <x-tb-cl-fill>{{ $it->targetHarian->pekerjaan ?? '-' }}</x-tb-cl-fill>
                        <x-tb-cl-fill>{{ Str::limit($it->realisasi, 60) }}</x-tb-cl-fill>
                        <x-tb-cl-fill>{{ $it->effective_jumlah ?? '-' }}</x-tb-cl-fill>
                        <x-tb-cl-fill>{{ $it->effective_waktu_minutes ?? '-' }}</x-tb-cl-fill>
                            <x-tb-cl-fill>{{ ucfirst($it->status ?? 'pending') }}</x-tb-cl-fill>
                        <x-tb-cl-fill>
                            <div class="flex items-center justify-center gap-3">
                                <a href="{{ route('manage.target-kinerja.harian.reports.approval', $it->id) }}" class="flex items-center justify-center w-7 h-7 rounded-md border border-[#d0d5dd] bg-white hover:bg-[#f9fafb] transition duration-150 ease-in-out text-blue-600" title="Open">
                                    <i class="bi bi-eye"></i>
                                </a>
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
