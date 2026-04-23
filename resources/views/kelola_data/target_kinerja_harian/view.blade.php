@php
    $active_sidebar = 'Target Kinerja';
@endphp

@extends('kinerja_pegawai.base')

@section('header-base')
    <style>
        .detail-card {
            background: #ffffff;
            border-radius: 16px;
            border: 1px solid #f2f2f7;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
        }
    </style>
@endsection

@section('page-name')
    <div class="flex flex-col md:flex-row items-center gap-[11.75px] self-stretch px-1 pt-[14.68px] pb-[13.95px]">
        <div class="flex w-full flex-col gap-[2.93px] grow">
            <div class="flex items-center gap-[5.87px] self-stretch">
                <span class="font-medium text-2xl leading-[20.56px] text-[#101828]">Detail Target Harian</span>
            </div>
            <span class="font-normal text-[10.28px] leading-[14.68px] text-[#1f2028]">{{ $item->pekerjaan }}</span>
        </div>
    </div>
@endsection

@section('content-base')
    <div class="w-full">
        <div class="detail-card p-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-x-8 gap-y-6">
                <div class="md:col-span-2 border-b border-gray-100 pb-2 mb-2">
                    <h3 class="text-lg font-bold text-gray-800">Informasi Target Harian</h3>
                </div>

                <div class="space-y-1">
                    <p class="text-xs font-bold text-gray-400 uppercase tracking-widest">Pekerjaan</p>
                    <p class="text-sm font-semibold text-gray-800">{{ $item->pekerjaan }}</p>
                </div>

                <div class="space-y-1">
                    <p class="text-xs font-bold text-gray-400 uppercase tracking-widest">Induk KPI</p>
                    <p class="text-sm font-semibold text-gray-800">{{ $item->targetKinerja->nama_kpi ?? '-' }}</p>
                </div>

                <div class="space-y-1">
                    <p class="text-xs font-bold text-gray-400 uppercase tracking-widest">Jumlah / Target Output</p>
                    <p class="text-sm font-black text-gray-900">{{ $item->jumlah ?? '-' }}</p>
                </div>

                <div class="space-y-1">
                    <p class="text-xs font-bold text-gray-400 uppercase tracking-widest">Waktu Pengerjaan</p>
                    <p class="text-sm font-black text-gray-900">{{ $item->waktu_minutes ?? '-' }} <span class="text-[10px] font-bold text-gray-400 uppercase">menit</span></p>
                </div>

                <div class="space-y-1">
                    <p class="text-xs font-bold text-gray-400 uppercase tracking-widest">Waktu Mulai</p>
                    <p class="text-sm font-semibold text-gray-700">{{ $item->start ? \Carbon\Carbon::parse($item->start)->format('d F Y - H:i') : '-' }}</p>
                </div>

                <div class="space-y-1">
                    <p class="text-xs font-bold text-gray-400 uppercase tracking-widest">Waktu Selesai</p>
                    <p class="text-sm font-semibold text-gray-700">{{ $item->end ? \Carbon\Carbon::parse($item->end)->format('d F Y - H:i') : '-' }}</p>
                </div>
            </div>

            <div class="flex items-center gap-3 pt-8">
                <a href="{{ route('manage.target-kinerja.harian.isi', $item->id) }}"
                    class="inline-flex items-center gap-2 px-6 py-2.5 bg-emerald-600 text-white text-xs font-bold rounded-xl hover:bg-emerald-700 active:scale-95 transition-all shadow-sm">
                    <i class="fa-solid fa-journal-plus"></i> 
                    Isi Laporan Pekerjaan
                </a>
                <a href="{{ route('manage.target-kinerja.harian.list') }}"
                    class="px-6 py-2.5 bg-white border border-gray-200 text-gray-600 text-xs font-bold rounded-xl hover:bg-gray-50 transition-all">
                    Kembali ke Daftar
                </a>
            </div>
        </div>
    </div>
@endsection
