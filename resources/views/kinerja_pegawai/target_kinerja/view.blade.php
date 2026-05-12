@php
    $active_sidebar = 'Kontrak Manajemen (KM) & Sasaran Mutu (SM)';
@endphp

@extends('kinerja_pegawai.base')

@section('page-name', 'Detail KM & Sasaran Mutu')

@section('content-base')
<div class="mb-4">
    <p class="text-sm text-gray-500 italic">{{ $targetKinerja->nama_kpi }}</p>
</div>
<div class="w-full max-w-7xl mx-auto p-4 sm:p-6 lg:p-8 bg-white rounded-lg shadow-sm border border-gray-100">
    <div class="grid grid-cols-1 md:grid-cols-2 gap-10 mb-10">
        {{-- Section 1: Informasi Indikator --}}
        <div>
            <h3 class="text-lg font-semibold text-gray-700 mb-6 border-l-4 border-blue-600 pl-4 uppercase tracking-tight">Informasi Dasar</h3>
            <div class="space-y-4">
                <div class="flex justify-between border-b border-gray-50 pb-2">
                    <span class="text-sm font-medium text-gray-500">Nama Indikator</span>
                    <span class="text-sm font-bold text-gray-800 text-right">{{ $targetKinerja->nama_kpi }}</span>
                </div>
                <div class="flex justify-between border-b border-gray-50 pb-2">
                    <span class="text-sm font-medium text-gray-500">Unit Kerja</span>
                    <span class="text-sm font-semibold text-gray-700">{{ $targetKinerja->unit->nama_unit ?? '-' }}</span>
                </div>
                <div class="flex justify-between border-b border-gray-50 pb-2">
                    <span class="text-sm font-medium text-gray-500">Jenis KPI</span>
                    <span class="px-2 py-0.5 rounded bg-indigo-50 text-indigo-700 text-[10px] font-black uppercase border border-indigo-100">{{ $targetKinerja->jenis }}</span>
                </div>
                <div class="flex justify-between border-b border-gray-50 pb-2">
                    <span class="text-sm font-medium text-gray-500">Satuan Ukur</span>
                    <span class="text-sm font-semibold text-gray-700">{{ $targetKinerja->satuan }}</span>
                </div>
                <div class="flex justify-between border-b border-gray-50 pb-2">
                    <span class="text-sm font-medium text-gray-500">Tahun Anggaran</span>
                    <span class="text-sm font-black text-gray-900">{{ $targetKinerja->tahun }}</span>
                </div>
                <div class="flex justify-between border-b border-gray-50 pb-2">
                    <span class="text-sm font-medium text-gray-500">Status Aktif</span>
                    @if($targetKinerja->is_active)
                        <span class="text-xs font-bold text-green-600 uppercase flex items-center gap-1">
                            <i class="fa-solid fa-circle-check"></i> Aktif
                        </span>
                    @else
                        <span class="text-xs font-bold text-gray-400 uppercase flex items-center gap-1">
                            <i class="fa-solid fa-circle-xmark"></i> Non-Aktif
                        </span>
                    @endif
                </div>
            </div>
        </div>

        {{-- Section 2: Triwulan Achievement --}}
        <div>
            <h3 class="text-lg font-semibold text-gray-700 mb-6 border-l-4 border-emerald-600 pl-4 uppercase tracking-tight">Target Triwulan</h3>
            <div class="grid grid-cols-2 gap-4">
                @foreach(['tw1' => 'TW I', 'tw2' => 'TW II', 'tw3' => 'TW III', 'tw4' => 'TW IV'] as $key => $label)
                    <div class="p-4 bg-gray-50 rounded-xl border border-gray-200 shadow-sm">
                        <p class="text-xs font-black text-blue-600 uppercase mb-3">{{ $label }}</p>
                        <div class="space-y-2">
                            <div class="flex justify-between items-center">
                                <span class="text-[10px] text-gray-400 font-bold uppercase">Target</span>
                                <span class="text-sm font-black text-gray-800">{{ number_format($targetKinerja->{$key.'_target'}) }}</span>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="text-[10px] text-gray-400 font-bold uppercase">Bobot</span>
                                <span class="text-sm font-bold text-emerald-600">{{ number_format($targetKinerja->{$key.'_bobot'}) }}%</span>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    {{-- Keterangan --}}
    <div class="bg-gray-50 p-6 rounded-xl border border-gray-200 mb-10">
        <h4 class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-2">Keterangan Tambahan</h4>
        <p class="text-sm text-gray-700 italic leading-relaxed">
            {{ $targetKinerja->keterangan ?? 'Tidak ada keterangan tambahan.' }}
        </p>
    </div>

    {{-- Footer Actions --}}
    <div class="flex items-center gap-3 pt-8 border-t border-gray-100">
        <a href="{{ route('manage.target-kinerja.edit', $targetKinerja->id) }}"
            class="bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium py-2 px-6 rounded-md transition duration-150 shadow-sm inline-flex items-center gap-2">
            <i class="fa-solid fa-pencil text-xs"></i> Edit KM & SM
        </a>
        <a href="{{ route('manage.target-kinerja.list') }}"
            class="bg-white border border-gray-300 text-gray-700 hover:bg-gray-50 text-sm font-medium py-2 px-6 rounded-md transition duration-150">
            Kembali ke Daftar
        </a>
    </div>
</div>
@endsection
