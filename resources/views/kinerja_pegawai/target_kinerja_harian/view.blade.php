@php
    $active_sidebar = 'Target Kinerja';
@endphp

@extends('kinerja_pegawai.base')

@section('page-name', 'Detail Target Harian')

@section('content-base')
<div class="mb-4">
    <p class="text-sm text-gray-500 italic">{{ $item->pekerjaan }}</p>
</div>
<div class="w-full max-w-7xl mx-auto p-4 sm:p-6 lg:p-8 bg-white rounded-lg shadow-sm border border-gray-100">
    <div class="grid grid-cols-1 md:grid-cols-2 gap-10 mb-10">
        {{-- Section 1: Informasi Target --}}
        <div>
            <h3 class="text-lg font-semibold text-gray-700 mb-6 border-l-4 border-blue-600 pl-4 uppercase tracking-tight">Detail Penugasan</h3>
            <div class="space-y-4">
                <div class="flex justify-between border-b border-gray-50 pb-2">
                    <span class="text-sm font-medium text-gray-500">Nama Pekerjaan</span>
                    <span class="text-sm font-bold text-gray-800 text-right">{{ $item->pekerjaan }}</span>
                </div>
                <div class="flex justify-between border-b border-gray-50 pb-2">
                    <span class="text-sm font-medium text-gray-500">Induk Master KPI</span>
                    <span class="text-sm font-semibold text-blue-600 text-right">{{ $item->targetKinerja->nama_kpi ?? '-' }}</span>
                </div>
                <div class="flex justify-between border-b border-gray-50 pb-2">
                    <span class="text-sm font-medium text-gray-500">Target Output</span>
                    <span class="text-sm font-black text-gray-900">{{ $item->jumlah ?? '-' }} Item</span>
                </div>
                <div class="flex justify-between border-b border-gray-50 pb-2">
                    <span class="text-sm font-medium text-gray-500">Alokasi Waktu</span>
                    <span class="text-sm font-black text-gray-900">{{ $item->waktu_minutes ?? '-' }} Menit</span>
                </div>
                <div class="flex justify-between border-b border-gray-50 pb-2">
                    <span class="text-sm font-medium text-gray-500">Tipe Tugas</span>
                    <span class="px-2 py-0.5 rounded bg-blue-50 text-blue-700 text-[10px] font-black uppercase border border-blue-100">{{ $item->kontrak_type }}</span>
                </div>
            </div>
        </div>

        {{-- Section 2: Jadwal Pelaksanaan --}}
        <div>
            <h3 class="text-lg font-semibold text-gray-700 mb-6 border-l-4 border-amber-600 pl-4 uppercase tracking-tight">Jadwal Pelaksanaan</h3>
            <div class="bg-gray-50 p-6 rounded-xl border border-gray-200 shadow-sm space-y-6">
                <div class="flex items-center gap-4">
                    <div class="w-10 h-10 rounded-full bg-white flex items-center justify-center text-amber-600 shadow-sm border border-amber-100">
                        <i class="fa-solid fa-calendar-plus"></i>
                    </div>
                    <div>
                        <p class="text-[10px] font-bold text-gray-400 uppercase">Waktu Mulai</p>
                        <p class="text-sm font-bold text-gray-800">{{ $item->start ? \Carbon\Carbon::parse($item->start)->format('l, d F Y - H:i') : '-' }}</p>
                    </div>
                </div>
                <div class="flex items-center gap-4">
                    <div class="w-10 h-10 rounded-full bg-white flex items-center justify-center text-red-600 shadow-sm border border-red-100">
                        <i class="fa-solid fa-calendar-check"></i>
                    </div>
                    <div>
                        <p class="text-[10px] font-bold text-gray-400 uppercase">Waktu Selesai</p>
                        <p class="text-sm font-bold text-gray-800">{{ $item->end ? \Carbon\Carbon::parse($item->end)->format('l, d F Y - H:i') : '-' }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Footer Actions --}}
    <div class="flex items-center gap-3 pt-8 border-t border-gray-100">
        <a href="{{ route('manage.target-kinerja.harian.isi', $item->id) }}"
            class="bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium py-2 px-6 rounded-md transition duration-150 shadow-sm inline-flex items-center gap-2">
            <i class="fa-solid fa-file-pen text-xs"></i> Isi Laporan Pekerjaan
        </a>
        <a href="{{ route('manage.target-kinerja.harian.list') }}"
            class="bg-white border border-gray-300 text-gray-700 hover:bg-gray-50 text-sm font-medium py-2 px-6 rounded-md transition duration-150">
            Kembali ke Daftar
        </a>
    </div>
</div>
@endsection
