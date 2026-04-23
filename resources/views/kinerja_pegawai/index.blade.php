@extends('kinerja_pegawai.base')

@section('header-base')
    <style>
        .max-w-100 { max-width: 100% !important; }
    </style>
@endsection

@section('page-name')
    <div class="flex flex-col gap-[3px] px-1 pt-3 pb-2">
        <span class="font-semibold text-2xl text-[#101828]">Dashboard Kinerja Pegawai</span>
        <span class="text-xs text-gray-400">Ringkasan target, capaian, dan laporan pekerjaan</span>
    </div>
@endsection

@section('content-base')

    {{-- ── Stat Cards ────────────────────────────────── --}}
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-5 mb-6">

        {{-- KPI Strategis --}}
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6 flex items-center gap-4 group hover:shadow-md transition-all">
            <div class="p-4 bg-blue-50 rounded-2xl text-blue-600 group-hover:bg-blue-600 group-hover:text-white transition-colors flex-shrink-0">
                <i class="fa-solid fa-bullseye fa-xl"></i>
            </div>
            <div>
                <p class="text-3xl font-black text-gray-900">{{ $totalTarget }}</p>
                <p class="text-xs font-bold text-gray-400 uppercase tracking-widest mt-0.5">KPI Strategis Aktif</p>
                <a href="{{ route('manage.target-kinerja.list') }}" class="text-[11px] font-bold text-blue-600 hover:underline mt-1 inline-block">Kelola Target →</a>
            </div>
        </div>

        {{-- Target Harian --}}
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6 flex items-center gap-4 group hover:shadow-md transition-all">
            <div class="p-4 bg-green-50 rounded-2xl text-green-600 group-hover:bg-green-600 group-hover:text-white transition-colors flex-shrink-0">
                <i class="fa-solid fa-calendar-day fa-xl"></i>
            </div>
            <div>
                <p class="text-3xl font-black text-gray-900">{{ $totalHarian }}</p>
                <p class="text-xs font-bold text-gray-400 uppercase tracking-widest mt-0.5">Target Harian Aktif</p>
                <a href="{{ route('manage.target-kinerja.harian.list') }}" class="text-[11px] font-bold text-green-600 hover:underline mt-1 inline-block">Lihat Daftar →</a>
            </div>
        </div>

        {{-- Approval Pending --}}
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6 flex items-center gap-4 group hover:shadow-md transition-all">
            <div class="p-4 bg-yellow-50 rounded-2xl text-yellow-600 group-hover:bg-yellow-500 group-hover:text-white transition-colors flex-shrink-0">
                <i class="fa-solid fa-check-double fa-xl"></i>
            </div>
            <div>
                <p class="text-3xl font-black text-gray-900">{{ $laporanPending }}</p>
                <p class="text-xs font-bold text-gray-400 uppercase tracking-widest mt-0.5">Laporan Menunggu Approval</p>
                <a href="{{ route('manage.target-kinerja.harian.reports') }}" class="text-[11px] font-bold text-yellow-600 hover:underline mt-1 inline-block">Buka Verifikasi →</a>
            </div>
        </div>
    </div>

    {{-- ── Tabel Laporan Terkini ─────────────────────── --}}
    <div class="flex flex-grow-0 flex-col gap-2 max-w-100 mt-2">
        <div class="px-1 mb-2">
            <h3 class="font-bold text-gray-900 tracking-tight text-lg">Laporan Pekerjaan Terkini</h3>
            <p class="text-xs text-gray-500">10 laporan masuk terakhir</p>
        </div>
        
        <x-tb id="dashboardTerkiniTable" :search_status="false">
            <x-slot:table_header>
                <x-tb-td nama="pegawai" sorting="true">Pegawai</x-tb-td>
                <x-tb-td nama="target" sorting="true">Target Harian</x-tb-td>
                <x-tb-td nama="tanggal" sorting="true">Tanggal</x-tb-td>
                <x-tb-td nama="status" sorting="true">Status</x-tb-td>
                <x-tb-td nama="aksi">Aksi</x-tb-td>
            </x-slot:table_header>
            <x-slot:table_column>
                @foreach ($laporanTerkini as $laporan)
                    <x-tb-cl id="{{ $laporan->id }}">
                        <x-tb-cl-fill>
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 rounded-xl bg-blue-50 flex items-center justify-center text-blue-600 font-black text-xs border border-blue-100 shrink-0">
                                    {{ substr($laporan->pelapor?->nama_lengkap ?? '?', 0, 1) }}
                                </div>
                                <span class="font-semibold text-gray-900 text-xs">
                                    {{ $laporan->pelapor?->nama_lengkap ?? 'Tidak diketahui' }}
                                </span>
                            </div>
                        </x-tb-cl-fill>
                        <x-tb-cl-fill>
                            <span class="text-xs text-gray-600 font-medium">
                                {{ $laporan->targetHarian?->pekerjaan ?? '-' }}
                            </span>
                        </x-tb-cl-fill>
                        <x-tb-cl-fill>
                            <span class="text-xs text-gray-500">
                                {{ $laporan->created_at?->format('d M Y') ?? '-' }}
                            </span>
                        </x-tb-cl-fill>
                        <x-tb-cl-fill>
                            @php
                                $statusMap = [
                                    'pending'  => ['bg-yellow-50 text-yellow-700 border-yellow-100', 'Menunggu'],
                                    'approved' => ['bg-green-50 text-green-700 border-green-100', 'Disetujui'],
                                    'rejected' => ['bg-red-50 text-red-700 border-red-100', 'Ditolak'],
                                ];
                                [$cls, $label] = $statusMap[$laporan->status] ?? ['bg-gray-100 text-gray-600 border-gray-200', ucfirst($laporan->status)];
                            @endphp
                            <span class="inline-flex items-center gap-1 px-2 py-1 rounded-full text-[10px] font-black uppercase border {{ $cls }}">
                                <span class="w-1.5 h-1.5 rounded-full bg-current opacity-70"></span>
                                {{ $label }}
                            </span>
                        </x-tb-cl-fill>
                        <x-tb-cl-fill>
                            <div class="flex items-center justify-center">
                                @if ($laporan->status === 'pending')
                                    <a href="{{ route('manage.target-kinerja.harian.reports.approval', $laporan->id) }}"
                                       class="text-xs font-bold text-blue-600 hover:text-blue-800 hover:underline">
                                        Review
                                    </a>
                                @else
                                    <span class="text-xs text-gray-300">—</span>
                                @endif
                            </div>
                        </x-tb-cl-fill>
                    </x-tb-cl>
                @endforeach
            </x-slot:table_column>
        </x-tb>
        
        <div class="mt-2 text-right">
            <a href="{{ route('manage.target-kinerja.harian.reports') }}" class="text-xs font-black text-blue-600 hover:underline tracking-tight">LIHAT SEMUA →</a>
        </div>
    </div>

@endsection
