@php
    $active_sidebar = 'Dashboard';
@endphp

@extends('kinerja_pegawai.base')

@section('page-name')
    <div class="flex flex-col gap-[3px] px-1 pt-3 pb-2">
        <span class="font-semibold text-2xl text-[#101828]">Monitoring Aktivitas Pegawai</span>
        <span class="text-xs text-gray-400">Zero Activity Tracker - Pantau kedisiplinan pelaporan harian ({{ \Carbon\Carbon::parse($today)->translatedFormat('d F Y') }})</span>
    </div>
@endsection

@section('content-base')
    <div class="w-full space-y-6">
        
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            
            {{-- ── Left: Already Reported (Green) ──────────────── --}}
            <div class="bg-white rounded-3xl border border-gray-100 shadow-sm overflow-hidden flex flex-col min-h-[400px]">
                <div class="p-6 border-b border-gray-50 flex items-center justify-between bg-emerald-50/30">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-full bg-emerald-100 flex items-center justify-center text-emerald-600 shadow-sm shadow-emerald-100">
                            <i class="fa-solid fa-user-check"></i>
                        </div>
                        <div>
                            <h3 class="text-base font-black text-gray-900 leading-tight">Pegawai Sudah Lapor</h3>
                            <p class="text-[10px] font-bold text-emerald-600 uppercase tracking-widest mt-0.5">Disiplin & Produktif</p>
                        </div>
                    </div>
                    <div>
                        <span class="px-3 py-1 rounded-full bg-emerald-600 text-white text-[10px] font-black uppercase">
                            {{ $activeUsers->count() }} Orang
                        </span>
                    </div>
                </div>

                <div class="p-6 flex-1 overflow-y-auto max-h-[500px]">
                    @if($activeUsers->isEmpty())
                        <div class="py-20 text-center">
                            <p class="text-xs text-gray-400">Belum ada pegawai yang melapor hari ini.</p>
                        </div>
                    @else
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            @foreach($activeUsers as $user)
                                <div class="flex items-center gap-3 p-3 rounded-2xl border border-gray-50 bg-emerald-50/10">
                                    <div class="w-8 h-8 rounded-full bg-emerald-100 flex items-center justify-center text-emerald-600 font-bold text-[10px]">
                                        {{ strtoupper(substr($user->nama_lengkap, 0, 1)) }}
                                    </div>
                                    <div class="overflow-hidden">
                                        <p class="text-[10px] font-bold text-gray-900 truncate" title="{{ $user->nama_lengkap }}">{{ $user->nama_lengkap }}</p>
                                        <p class="text-[8px] text-gray-400 truncate uppercase">{{ $user->unit?->nama_unit ?? 'General' }}</p>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>

            {{-- ── Right: Haven't Reported Yet (Red) ───────────── --}}
            <div class="bg-white rounded-3xl border border-gray-100 shadow-sm overflow-hidden flex flex-col min-h-[400px]">
                <div class="p-6 border-b border-gray-50 flex items-center justify-between bg-red-50/30">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-full bg-red-100 flex items-center justify-center text-red-600 shadow-sm shadow-red-100">
                            <i class="fa-solid fa-user-clock"></i>
                        </div>
                        <div>
                            <h3 class="text-base font-black text-gray-900 leading-tight">Pegawai Belum Lapor</h3>
                            <p class="text-[10px] font-bold text-red-600 uppercase tracking-widest mt-0.5">Perlu Tindak Lanjut</p>
                        </div>
                    </div>
                    <div>
                        <span class="px-3 py-1 rounded-full bg-red-600 text-white text-[10px] font-black uppercase">
                            {{ $inactiveUsers->count() }} Orang
                        </span>
                    </div>
                </div>

                <div class="p-6 flex-1 overflow-y-auto max-h-[500px]">
                    @if($inactiveUsers->isEmpty())
                        <div class="py-20 text-center text-emerald-500 font-bold text-sm">
                            <i class="fa-solid fa-face-smile-wink mr-2 text-3xl block mb-2"></i> Mantap! Semua sudah lapor.
                        </div>
                    @else
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            @foreach($inactiveUsers as $user)
                                <div class="flex items-center justify-between p-3 rounded-2xl border border-red-50 bg-red-50/10 group hover:bg-white hover:shadow-md transition-all">
                                    <div class="flex items-center gap-3 overflow-hidden">
                                        <div class="w-8 h-8 rounded-full bg-white flex items-center justify-center text-gray-300 font-bold border border-gray-100">
                                            {{ strtoupper(substr($user->nama_lengkap, 0, 1)) }}
                                        </div>
                                        <div class="overflow-hidden">
                                            <p class="text-[10px] font-bold text-gray-900 truncate" title="{{ $user->nama_lengkap }}">{{ $user->nama_lengkap }}</p>
                                            <p class="text-[8px] text-gray-400 truncate uppercase">{{ $user->unit?->nama_unit ?? 'General' }}</p>
                                        </div>
                                    </div>
                                    
                                    <a href="https://wa.me/{{ $user->telepon ? preg_replace('/[^0-9]/', '', $user->telepon) : '#' }}" target="_blank"
                                        class="inline-flex items-center justify-center w-7 h-7 rounded-lg bg-emerald-50 text-emerald-600 hover:bg-emerald-600 hover:text-white transition-all border border-emerald-100 flex-shrink-0"
                                        title="Ingatkan via WhatsApp">
                                        <i class="fa-brands fa-whatsapp text-xs"></i>
                                    </a>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>

        </div>

        {{-- Info Footer --}}
        <div class="bg-blue-50 rounded-2xl p-4 border border-blue-100">
            <div class="flex items-start gap-3">
                <i class="fa-solid fa-lightbulb text-blue-400 mt-0.5"></i>
                <p class="text-[10px] text-blue-700 leading-relaxed font-medium">
                    Halaman ini memonitor seluruh pegawai non-admin yang bertugas hari ini. Klik ikon WhatsApp di sisi kanan daftar "Belum Lapor" untuk mengirimkan pengingat otomatis kepada pegawai yang bersangkutan.
                </p>
            </div>
        </div>

    </div>
@endsection
