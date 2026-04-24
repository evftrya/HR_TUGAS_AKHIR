@php
    use App\Helpers\PhoneHelper;
    $active_sidebar = 'History Kelompok Keahlian';
@endphp

@extends('kelola_data.base-profile')

@section('title-the-page')
    {{ $active_sidebar }}
@endsection

@section('content-profile')
    <div class="relative mx-auto px-4 py-12 font-sans rounded-2xl shadow-xl overflow-hidden" style="background: #5063BF;">

        {{-- Pattern Background --}}
        <div class="pattern-batik-kawung-dark absolute inset-0 opacity-5 pointer-events-none"
            style="background-image: url('data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHdpZHRoPSI2MCIgaGVpZ2h0PSI2MCI+PHBhdGggZD0iTTMwIDBjMTYuNTY5IDAgMzAgMTMuNDMxIDMwIDMwcy0xMy40MzEgMzAtMzAgMzBTMCA0Ni41NjkgMCAzMCAxMy40MzEgMCAzMCAwek0wIDMwYzAgMTEuMDU2IDguOTQ0IDIwIDIwIDIwczIwLTguOTQ0IDIwLTIwUzMxLjA1NiAxMCAyMCAxMCAwIDE4Ljk0NCAwIDMwek0zMCA2MGMxMS4wNTYgMCAyMC04Ljk0NCAyMC0yMHMtOC45NDQtMjAtMjAtMjBTMTAgMjguOTQ0IDEwIDQwczguOTQ0IDIwIDIwIDIwek0zMCAwQzE4Ljk0NCAwIDEwIDguOTQ0IDEwIDIwczguOTQ0IDIwIDIwIDIwIDIwLTguOTQ0IDIwLTIwUzQxLjA1NiAwIDMwIDB6IiBmaWxsPSIjMDAwIiBmaWxsLW9wYWNpdHk9Ii4xIi8+PC9zdmc+');">
        </div>

        <div class="relative z-10">
            <div class="mb-16 text-center text-white">
                <h3 class="text-3xl font-black tracking-tight">Timeline Penempatan</h3>
                <p class="mt-2 text-blue-100/80">Riwayat Perubahan Kelompok Keahlian</p>
            </div>

            <div class="relative">
                {{-- Garis Tengah Statis --}}
                <div class="absolute bottom-0 left-8 top-0 w-1 -translate-x-1/2 rounded bg-white/20 md:left-1/2"></div>

                <div class="space-y-12">
                    @forelse ($history as $riwayat)
                        <div class="relative w-full md:flex {{ $loop->iteration % 2 == 1 ? 'md:justify-end' : 'md:justify-start' }}">

                            {{-- Penanda Titik (Dot) --}}
                            <div class="absolute left-8 top-10 z-20 h-6 w-6 -translate-x-1/2 rounded-full border-4 border-[#5063BF] {{ $riwayat->is_active == 1 ? 'bg-green-400 shadow-[0_0_10px_#4ade80]' : 'bg-slate-400' }} md:left-1/2"></div>

                            <div class="ml-16 w-[calc(100%-5rem)] md:ml-0 md:w-[45%]">
                                <div class="bg-white rounded-2xl p-6 shadow-2xl overflow-hidden relative">

                                    {{-- Status Badge --}}
                                    <div class="flex justify-between items-center mb-6">
                                        <div class="flex items-center gap-2">
                                            <div class="h-2 w-2 rounded-full {{ $riwayat->is_active == 1 ? 'bg-green-500 animate-pulse' : 'bg-slate-400' }}"></div>
                                            <span class="text-[11px] font-bold uppercase tracking-widest {{ $riwayat->is_active == 1 ? 'text-green-600' : 'text-slate-500' }}">
                                                {{ $riwayat->is_active == 1 ? 'Aktif Sekarang' : 'Riwayat Lama' }}
                                            </span>
                                        </div>
                                        <span class="text-[10px] text-slate-400 font-mono">{{ \Carbon\Carbon::parse($riwayat->created_at)->format('d/m/Y') }}</span>
                                    </div>

                                    {{-- Hirarki yang Jelas --}}
                                    <div class="space-y-4">

                                        {{-- 1. FAKULTAS (Top Level) --}}
                                        <div class="flex gap-3">
                                            <div class="flex flex-col items-center">
                                                <div class="w-2 h-2 rounded-full bg-slate-200"></div>
                                                <div class="w-0.5 h-full bg-slate-100"></div>
                                            </div>
                                            <div>
                                                <p class="text-[9px] font-bold text-slate-400 uppercase tracking-tighter">Fakultas</p>
                                                <p class="text-sm font-medium text-slate-600">{{ $riwayat->subKK->KK->fakultas->position_name }}</p>
                                            </div>
                                        </div>

                                        {{-- 2. KELOMPOK KEAHLIAN (Mid Level) --}}
                                        <div class="flex gap-3 ml-1">
                                            <div class="flex flex-col items-center">
                                                <div class="w-2 h-2 rounded-full bg-blue-400"></div>
                                                <div class="w-0.5 h-full bg-blue-50"></div>
                                            </div>
                                            <div>
                                                <p class="text-[9px] font-bold text-blue-400 uppercase tracking-tighter">Kelompok Keahlian</p>
                                                <p class="text-md font-bold text-slate-800">{{ $riwayat->subKK->KK->nama }}</p>
                                            </div>
                                        </div>

                                        {{-- 3. SUB KK (Target Level - Paling Menonjol) --}}
                                        <div class="flex gap-3 ml-2 p-3 bg-orange-50 rounded-lg border-l-4 border-orange-500">
                                            <div class="flex flex-col items-center justify-center">
                                                <div class="w-2 h-2 rounded-full bg-orange-500"></div>
                                            </div>
                                            <div>
                                                <p class="text-[9px] font-bold text-orange-600 uppercase tracking-tighter">Sub-KK</p>
                                                <p class="text-lg font-black text-slate-900">{{ $riwayat->subKK->nama }}</p>
                                            </div>
                                        </div>

                                    </div>

                                    {{-- Dekorasi Panah Kecil --}}
                                    <div class="absolute top-10 w-4 h-4 bg-white rotate-45 hidden md:block
                                        {{ $loop->iteration % 2 == 1 ? '-left-2' : '-right-2' }}">
                                    </div>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-20 text-white/50 italic">
                            Belum ada riwayat pemetaan.
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
@endsection
