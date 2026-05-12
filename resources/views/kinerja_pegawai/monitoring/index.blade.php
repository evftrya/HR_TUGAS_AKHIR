@php
    $active_sidebar = 'Dashboard';
@endphp

@extends('kinerja_pegawai.base')

@section('page-name', 'Monitoring Aktivitas Pegawai')

@section('content-base')
<div class="mb-4">
    <p class="text-sm text-gray-500 italic">Zero Activity Tracker - Pantau kedisiplinan pelaporan harian ({{ \Carbon\Carbon::parse($today)->translatedFormat('d F Y') }}).</p>
</div>
<div class="w-full max-w-7xl mx-auto p-4 sm:p-6 lg:p-8 bg-white rounded-lg shadow-sm border border-gray-100">
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-8">
        
        {{-- Already Reported --}}
        <div class="flex flex-col bg-gray-50 rounded-xl border border-gray-200 overflow-hidden min-h-[400px]">
            <div class="p-4 border-b border-gray-200 bg-white flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-lg bg-green-100 flex items-center justify-center text-green-600 border border-green-200">
                        <i class="fa-solid fa-user-check text-lg"></i>
                    </div>
                    <h3 class="text-lg font-bold text-gray-700">Sudah Lapor</h3>
                </div>
                <span class="px-3 py-1 rounded-full bg-green-600 text-white text-[10px] font-black uppercase tracking-wider">
                    {{ $activeUsers->count() }} Orang
                </span>
            </div>

            <div class="p-6 flex-1 overflow-y-auto max-h-[500px]">
                @if($activeUsers->isEmpty())
                    <div class="flex flex-col items-center justify-center py-20 opacity-40">
                        <i class="fa-solid fa-users text-4xl mb-2 text-gray-300"></i>
                        <p class="text-xs text-gray-500 italic font-medium">Belum ada pegawai yang melapor hari ini.</p>
                    </div>
                @else
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        @foreach($activeUsers as $user)
                            <div class="flex items-center gap-3 p-3 rounded-xl border border-gray-200 bg-white shadow-sm hover:shadow-md transition-shadow">
                                <div class="w-8 h-8 rounded-full bg-green-50 flex items-center justify-center text-green-600 font-bold text-xs border border-green-100">
                                    {{ strtoupper(substr($user->nama_lengkap, 0, 1)) }}
                                </div>
                                <div class="overflow-hidden">
                                    <p class="text-[11px] font-bold text-gray-800 truncate">{{ $user->nama_lengkap }}</p>
                                    <p class="text-[9px] text-gray-400 truncate uppercase font-semibold">{{ $user->unit?->nama_unit ?? 'General' }}</p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>

        {{-- Haven't Reported Yet --}}
        <div class="flex flex-col bg-gray-50 rounded-xl border border-gray-200 overflow-hidden min-h-[400px]">
            <div class="p-4 border-b border-gray-200 bg-white flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-lg bg-red-100 flex items-center justify-center text-red-600 border border-red-200">
                        <i class="fa-solid fa-user-clock text-lg"></i>
                    </div>
                    <h3 class="text-lg font-bold text-gray-700">Belum Lapor</h3>
                </div>
                <span class="px-3 py-1 rounded-full bg-red-600 text-white text-[10px] font-black uppercase tracking-wider">
                    {{ $inactiveUsers->count() }} Orang
                </span>
            </div>

            <div class="p-6 flex-1 overflow-y-auto max-h-[500px]">
                @if($inactiveUsers->isEmpty())
                    <div class="flex flex-col items-center justify-center py-20">
                        <i class="fa-solid fa-face-smile text-4xl text-green-400 mb-2"></i>
                        <p class="text-sm font-bold text-green-600 uppercase">Semua sudah melapor!</p>
                    </div>
                @else
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        @foreach($inactiveUsers as $user)
                            <div class="flex items-center justify-between p-3 rounded-xl border border-gray-200 bg-white shadow-sm hover:border-red-200 transition-colors group">
                                <div class="flex items-center gap-3 overflow-hidden">
                                    <div class="w-8 h-8 rounded-full bg-gray-50 flex items-center justify-center text-gray-400 font-bold border border-gray-100 text-xs">
                                        {{ strtoupper(substr($user->nama_lengkap, 0, 1)) }}
                                    </div>
                                    <div class="overflow-hidden">
                                        <p class="text-[11px] font-bold text-gray-800 truncate">{{ $user->nama_lengkap }}</p>
                                        <p class="text-[9px] text-gray-400 truncate uppercase font-semibold">{{ $user->unit?->nama_unit ?? 'General' }}</p>
                                    </div>
                                </div>
                                
                                <a href="https://wa.me/{{ $user->telepon ? preg_replace('/[^0-9]/', '', $user->telepon) : '#' }}" target="_blank"
                                    class="inline-flex items-center justify-center w-7 h-7 rounded-lg bg-green-50 text-green-600 hover:bg-green-600 hover:text-white transition-all border border-green-100 flex-shrink-0"
                                    title="Kirim Pengingat WA">
                                    <i class="fa-brands fa-whatsapp text-xs"></i>
                                </a>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>
    </div>

    <div class="p-4 bg-blue-50 rounded-xl border border-blue-100 flex gap-3">
        <i class="fa-solid fa-circle-info text-blue-400 mt-1"></i>
        <p class="text-xs text-blue-700 leading-relaxed font-medium">
            Halaman ini memonitor kedisiplinan pelaporan pegawai secara real-time. Anda dapat mengirimkan pengingat melalui tombol WhatsApp pada daftar pegawai yang belum melakukan pelaporan hari ini.
        </p>
    </div>
</div>
@endsection
