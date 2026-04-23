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
                <span class="font-medium text-2xl leading-[20.56px] text-[#101828]">Detail Target Kinerja</span>
            </div>
            <span class="font-normal text-[10.28px] leading-[14.68px] text-[#1f2028]">{{ $targetKinerja->nama_kpi }}</span>
        </div>
    </div>
@endsection

@section('content-base')
    <div class="w-full">
        <div class="detail-card p-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-x-8 gap-y-6">
                <div class="md:col-span-2 border-b border-gray-100 pb-2 mb-2">
                    <h3 class="text-lg font-bold text-gray-800">Informasi KPI</h3>
                </div>

                <div class="space-y-1">
                    <p class="text-xs font-bold text-gray-400 uppercase tracking-widest">Nama KPI</p>
                    <p class="text-sm font-semibold text-gray-800">{{ $targetKinerja->nama_kpi }}</p>
                </div>

                <div class="space-y-1">
                    <p class="text-xs font-bold text-gray-400 uppercase tracking-widest">Responsibility</p>
                    <p class="text-sm font-semibold text-gray-800">{{ $targetKinerja->responsibility ?? '-' }}</p>
                </div>

                <div class="space-y-1">
                    <p class="text-xs font-bold text-gray-400 uppercase tracking-widest">Satuan</p>
                    <p class="text-sm font-semibold text-gray-800">{{ $targetKinerja->satuan ?? '-' }}</p>
                </div>

                <div class="space-y-1">
                    <p class="text-xs font-bold text-gray-400 uppercase tracking-widest">Bobot</p>
                    <p class="text-sm font-black text-gray-900">{{ $targetKinerja->bobot }}</p>
                </div>

                <div class="space-y-1">
                    <p class="text-xs font-bold text-gray-400 uppercase tracking-widest">Target Capaian (%)</p>
                    <p class="text-sm font-black text-blue-600">{{ $targetKinerja->target_percent ?? '-' }}%</p>
                </div>

                <div class="space-y-1">
                    <p class="text-xs font-bold text-gray-400 uppercase tracking-widest">Status / Level</p>
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full bg-blue-50 text-blue-700 border border-blue-100 text-[10px] font-black uppercase">
                        {{ $targetKinerja->status ?? '-' }}
                    </span>
                </div>

                <div class="space-y-1">
                    <p class="text-xs font-bold text-gray-400 uppercase tracking-widest">Unit Penanggung Jawab</p>
                    <p class="text-sm font-semibold text-gray-800">{{ $targetKinerja->unit_penanggung_jawab ?? '-' }}</p>
                </div>

                <div class="space-y-1">
                    <p class="text-xs font-bold text-gray-400 uppercase tracking-widest">Periode</p>
                    <p class="text-sm font-semibold text-gray-800">{{ $targetKinerja->periode ?? '-' }}</p>
                </div>

                <div class="md:col-span-2 space-y-1">
                    <p class="text-xs font-bold text-gray-400 uppercase tracking-widest">Keterangan</p>
                    <p class="text-sm text-gray-700 leading-relaxed">{{ $targetKinerja->keterangan ?? '-' }}</p>
                </div>

                <div class="space-y-1">
                    <p class="text-xs font-bold text-gray-400 uppercase tracking-widest">Status Aktif</p>
                    @if($targetKinerja->is_active)
                        <span class="text-emerald-600 font-bold text-sm"><i class="fa-solid fa-circle-check"></i> Aktif</span>
                    @else
                        <span class="text-gray-400 font-bold text-sm"><i class="fa-solid fa-circle-xmark"></i> Non-Aktif</span>
                    @endif
                </div>
            </div>

            <div class="flex items-center gap-3 pt-8">
                <a href="{{ route('manage.target-kinerja.edit', $targetKinerja->id) }}"
                    class="inline-flex items-center gap-2 px-6 py-2.5 bg-blue-600 text-white text-xs font-bold rounded-xl hover:bg-blue-700 active:scale-95 transition-all shadow-sm">
                    <i class="fa-solid fa-pencil"></i> 
                    Edit Target Kinerja
                </a>
                <a href="{{ route('manage.target-kinerja.list') }}"
                    class="px-6 py-2.5 bg-white border border-gray-200 text-gray-600 text-xs font-bold rounded-xl hover:bg-gray-50 transition-all">
                    Kembali ke Daftar
                </a>
            </div>
        </div>
    </div>
@endsection
