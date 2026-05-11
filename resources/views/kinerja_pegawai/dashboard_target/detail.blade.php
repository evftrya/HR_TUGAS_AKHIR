@extends('kinerja_pegawai.base')

@section('page-name', 'Detail Progres KPI')

@section('content-base')
<div class="mb-4">
    <p class="text-sm text-gray-500 italic">Monitoring capaian target kinerja strategis institusi.</p>
</div>
<div class="w-full max-w-7xl mx-auto p-4 sm:p-6 lg:p-8 bg-white rounded-lg shadow-sm border border-gray-100">
    
    {{-- Header Widget Summary --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 mb-8">
        {{-- KPI Progress --}}
        <div class="lg:col-span-2 bg-gray-50 p-8 rounded-xl border border-gray-200 flex flex-col md:flex-row items-center gap-10">
            {{-- Circular Progress --}}
            <div class="relative w-36 h-36 flex-shrink-0">
                <svg class="w-full h-full transform -rotate-90">
                    <circle cx="72" cy="72" r="64" stroke="currentColor" stroke-width="12" fill="transparent" class="text-gray-200" />
                    @php
                        $circumference = 2 * M_PI * 64;
                        $offset = $circumference - ($circumference * min($percentage, 100) / 100);
                        $colorClass = $percentage < 50 ? 'text-red-500' : ($percentage <= 75 ? 'text-yellow-500' : 'text-green-600');
                    @endphp
                    <circle cx="72" cy="72" r="64" stroke="currentColor" stroke-width="12" fill="transparent"
                        stroke-dasharray="{{ $circumference }}"
                        stroke-dashoffset="{{ $offset }}"
                        stroke-linecap="round"
                        class="transition-all duration-1000 ease-in-out {{ $colorClass }}" />
                </svg>
                <div class="absolute inset-0 flex flex-col items-center justify-center">
                    <span class="text-3xl font-black {{ $colorClass }}">{{ $percentage }}%</span>
                    <span class="text-[9px] font-bold text-gray-400 uppercase tracking-widest">Capaian</span>
                </div>
            </div>
            
            <div class="flex-grow space-y-4 text-center md:text-left">
                <div>
                    <h3 class="text-xl font-bold text-gray-800 leading-tight">{{ $target->nama_kpi }}</h3>
                    <p class="text-sm text-gray-500 mt-1">{{ $target->keterangan }}</p>
                </div>
                <div class="flex items-center justify-center md:justify-start gap-8">
                    <div>
                        <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">Realisasi</p>
                        <p class="text-xl font-black text-gray-900">{{ number_format($totalRealisasi) }} <span class="text-xs font-bold text-gray-400">{{ $target->satuan }}</span></p>
                    </div>
                    <div class="h-10 w-px bg-gray-300"></div>
                    <div>
                        <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">Target</p>
                        <p class="text-xl font-black text-gray-900">{{ number_format($totalTarget) }} <span class="text-xs font-bold text-gray-400">{{ $target->satuan }}</span></p>
                    </div>
                </div>
            </div>
        </div>

        {{-- Status Card --}}
        <div class="bg-gray-50 p-8 rounded-xl border border-gray-200 flex flex-col justify-between">
            <div>
                <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-3">Status Indikator</p>
                @if($target->is_active)
                    <div class="inline-flex items-center gap-2 px-3 py-1 bg-green-100 text-green-700 rounded-full border border-green-200 text-xs font-bold uppercase">
                        <i class="fa-solid fa-circle-check"></i> Aktif & Berjalan
                    </div>
                @else
                    <div class="inline-flex items-center gap-2 px-3 py-1 bg-gray-100 text-gray-500 rounded-full border border-gray-200 text-xs font-bold uppercase">
                        <i class="fa-solid fa-circle-xmark"></i> Non-Aktif
                    </div>
                @endif
            </div>
            <div class="pt-6 border-t border-gray-200 mt-6">
                <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-1">Tahun Anggaran</p>
                <p class="text-3xl font-black text-gray-800">{{ $target->tahun }}</p>
            </div>
        </div>
    </div>

    {{-- Detail Grid --}}
    <div class="bg-white border border-gray-100 rounded-xl p-8 shadow-sm">
        <h3 class="text-lg font-semibold text-gray-700 mb-8 border-l-4 border-blue-600 pl-4 uppercase tracking-tight">Informasi Teknis KPI</h3>
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-y-10 gap-x-8">
            <div class="space-y-1">
                <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">Responsibility Unit</p>
                <p class="text-sm font-semibold text-gray-800">{{ $target->responsibility ?? '-' }}</p>
            </div>

            <div class="space-y-1">
                <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">Satuan Ukur</p>
                <p class="text-sm font-semibold text-gray-800">{{ $target->satuan ?? '-' }}</p>
            </div>

            <div class="space-y-1">
                <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">Bobot Kontrak</p>
                <p class="text-sm font-black text-gray-900">{{ number_format($target->bobot, 2) }}</p>
            </div>

            <div class="space-y-1">
                <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">Unit Penanggung Jawab</p>
                <p class="text-sm font-semibold text-gray-800">{{ $target->unit_penanggung_jawab ?? '-' }}</p>
            </div>
            
            <div class="lg:col-span-2 space-y-1">
                <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">Periode Pelaksanaan</p>
                <p class="text-sm font-semibold text-gray-800 flex items-center gap-2">
                    <i class="fa-solid fa-calendar-day text-blue-500"></i>
                    {{ \Carbon\Carbon::parse($target->start)->format('d M Y') }} — {{ \Carbon\Carbon::parse($target->end)->format('d M Y') }}
                </p>
            </div>

            <div class="lg:col-span-2 space-y-1">
                <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">Lingkup Pelaporan</p>
                <span class="inline-flex items-center px-3 py-1 rounded-full bg-blue-50 text-blue-700 border border-blue-100 text-[10px] font-black uppercase">
                    {{ $target->status ?? 'Institusi' }}
                </span>
            </div>
        </div>

        {{-- Footer Actions --}}
        <div class="mt-12 pt-8 border-t border-gray-100 flex justify-between items-center">
            <a href="{{ route('manage.target-kinerja.index') }}"
                class="bg-white border border-gray-300 text-gray-700 hover:bg-gray-50 text-sm font-medium py-2 px-6 rounded-md transition duration-150 inline-flex items-center gap-2 shadow-sm">
                <i class="fa-solid fa-arrow-left"></i> Kembali ke Dashboard
            </a>
            
            <div class="flex gap-2">
                {{-- Optional Action Buttons --}}
            </div>
        </div>
    </div>

</div>
@endsection
