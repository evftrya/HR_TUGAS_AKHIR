@extends('kinerja_pegawai.base')

@section('header-base')
    <style>
        .detail-card {
            background: #ffffff;
            border-radius: 24px;
            border: 1px solid #f2f2f7;
            box-shadow: 0 4px 20px -5px rgba(0, 0, 0, 0.05);
        }
        .progress-circle-container {
            position: relative;
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }
        .progress-circle {
            transition: stroke-dashoffset 0.8s ease-in-out;
        }
    </style>
@endsection

@section('page-name')
    <div class="flex flex-col gap-[3px] px-1 pt-3 pb-2">
        <span class="font-semibold text-2xl text-[#101828]">Detail Progres KPI</span>
        <span class="text-xs text-gray-400">Monitoring capaian target kinerja strategis</span>
    </div>
@endsection

@section('content-base')
    <div class="w-full flex flex-col gap-6">
        
        {{-- ── Widget Summary ────────────────────────── --}}
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            
            {{-- KPI Progress Circular Bar --}}
            <div class="detail-card p-6 flex items-center gap-8 md:col-span-2">
                <div class="progress-circle-container w-32 h-32 flex-shrink-0">
                    <svg class="w-full h-full transform -rotate-90">
                        <!-- Gray Background Circle -->
                        <circle cx="64" cy="64" r="58" stroke="currentColor" stroke-width="10" fill="transparent" class="text-gray-100" />
                        <!-- Colored Progress Circle -->
                        @php
                            $circumference = 2 * M_PI * 58;
                            $offset = $circumference - ($circumference * $percentage / 100);
                            $colorClass = $percentage < 50 ? 'text-red-500' : ($percentage <= 75 ? 'text-yellow-500' : 'text-green-500');
                        @endphp
                        <circle cx="64" cy="64" r="58" stroke="currentColor" stroke-width="10" fill="transparent"
                            stroke-dasharray="{{ $circumference }}"
                            stroke-dashoffset="{{ $offset }}"
                            stroke-linecap="round"
                            class="progress-circle {{ $colorClass }}" />
                    </svg>
                    <div class="absolute inset-0 flex flex-col items-center justify-center">
                        <span class="text-2xl font-black {{ $colorClass }}">{{ $percentage }}%</span>
                        <span class="text-[8px] font-bold text-gray-400 uppercase tracking-tighter">Capaian</span>
                    </div>
                </div>
                
                <div class="flex flex-col justify-center gap-1">
                    <h3 class="text-lg font-black text-gray-900 leading-tight">{{ $target->nama_kpi }}</h3>
                    <p class="text-sm text-gray-500">{{ $target->keterangan }}</p>
                    <div class="flex items-center gap-4 mt-3">
                        <div class="flex flex-col">
                            <span class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">Realisasi</span>
                            <span class="text-base font-black text-gray-900">{{ number_format($totalRealisasi) }} <span class="text-xs font-bold text-gray-400">{{ $target->satuan }}</span></span>
                        </div>
                        <div class="w-px h-8 bg-gray-100"></div>
                        <div class="flex flex-col">
                            <span class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">Target</span>
                            <span class="text-base font-black text-gray-900">{{ number_format($target->target_percent) }} <span class="text-xs font-bold text-gray-400">{{ $target->satuan }}</span></span>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Status & Info Widget --}}
            <div class="detail-card p-6 flex flex-col justify-between">
                <div>
                    <span class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-2 block">Status KPI</span>
                    @if($target->is_active)
                        <div class="flex items-center gap-2 text-emerald-600 font-bold">
                            <i class="fa-solid fa-circle-check"></i>
                            <span class="text-sm">Aktif & Berjalan</span>
                        </div>
                    @else
                        <div class="flex items-center gap-2 text-gray-400 font-bold">
                            <i class="fa-solid fa-circle-xmark"></i>
                            <span class="text-sm">Non-Aktif</span>
                        </div>
                    @endif
                </div>
                <div class="mt-4 pt-4 border-t border-gray-50">
                    <span class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-1 block">Tahun Periode</span>
                    <span class="text-xl font-black text-gray-900">{{ $target->tahun }}</span>
                </div>
            </div>
        </div>

        {{-- ── Detail Information ────────────────────── --}}
        <div class="detail-card p-8">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
                <div class="space-y-1">
                    <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">Responsibility</p>
                    <p class="text-sm font-semibold text-gray-800">{{ $target->responsibility ?? '-' }}</p>
                </div>

                <div class="space-y-1">
                    <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">Satuan Ukur</p>
                    <p class="text-sm font-semibold text-gray-800">{{ $target->satuan ?? '-' }}</p>
                </div>

                <div class="space-y-1">
                    <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">Bobot KPI</p>
                    <p class="text-sm font-black text-gray-900">{{ $target->bobot }}</p>
                </div>

                <div class="space-y-1">
                    <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">Penanggung Jawab</p>
                    <p class="text-sm font-semibold text-gray-800">{{ $target->unit_penanggung_jawab ?? '-' }}</p>
                </div>
                
                <div class="lg:col-span-2 space-y-1">
                    <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">Periode Pelaksanaan</p>
                    <p class="text-sm font-semibold text-gray-800">{{ \Carbon\Carbon::parse($target->start)->format('d M Y') }} - {{ \Carbon\Carbon::parse($target->end)->format('d M Y') }}</p>
                </div>

                <div class="lg:col-span-2 space-y-1">
                    <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">Status / Lingkup</p>
                    <span class="inline-flex items-center px-3 py-1 rounded-full bg-blue-50 text-blue-700 border border-blue-100 text-[10px] font-black uppercase">
                        {{ $target->status ?? '-' }}
                    </span>
                </div>
            </div>

            <div class="flex items-center gap-3 pt-10 mt-10 border-t border-gray-50">
                <a href="{{ route('manage.target-kinerja.index') }}"
                    class="px-6 py-2.5 bg-white border border-gray-200 text-gray-600 text-xs font-bold rounded-xl hover:bg-gray-50 transition-all flex items-center gap-2">
                    <i class="fa-solid fa-arrow-left"></i>
                    Kembali ke Dashboard
                </a>
            </div>
        </div>

    </div>
@endsection
