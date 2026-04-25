@php
    use App\Helpers\PhoneHelper;
    use Carbon\Carbon;
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
            style="background-image: url('data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHdpZHRoPSI2MCIgaGVpZ2h0PSI2MCI+PHBhdGggZD0iTTMwIDBjMTYuNTY5IDAgMzAgMTMuNDMxIDMwIDMwcy0xMy40MzEgMzAtMzAgMzBTMCA0Ni41NjkgMCAzMCAxMy40MzEgMCAzMCAwek0wIDMwYzAgMTEuMDU2IDguOTQ0IDIwIDIwIDIwczIwLTguOTQ0IDIwLTIwUzMxLjA1NiAxMCAyMCAxMCAwIDE4Ljk0NCAwIDMwek0zMCA2MGMxMS4wNTYgMCAyMC04Ljk0NCAyMC0yMHMtOC45NDQtMjAtMjAtMjBTMTAgMjguOTQ0IDEwIDQwczguOTQ0IDIwIDIwIDIwek0zMCAwQzE4Ljk0NCAwIDEwIDguOTQ0IDEwIDIwczguOTQ0IDIwIDIwIDIwIDIwLTguOTQ0IDIwLTIwUzQxLjA1NiAxMCAzMCAwWiIgZmlsbD0iIzAwMCIgZmlsbC1vcGFjaXR5PSIuMSIvPjwvc3ZnPg==');">
        </div>

        <div class="relative z-10">
            <div class="mb-16 text-center text-white">
                <h3 class="text-3xl font-black tracking-tight">Timeline Penempatan COE</h3>
                <p class="mt-2 text-blue-100/80">Riwayat Perubahan Center of Excellence</p>
            </div>

            <div class="relative">
                {{-- Garis Tengah Statis --}}
                <div class="absolute bottom-0 left-8 top-0 w-1 -translate-x-1/2 rounded bg-white/20 md:left-1/2"></div>

                <div class="space-y-12">
                    @forelse ($history as $riwayat)
                        @php
                            // Logika penentuan aktif: Jika tmt_selesai >= hari ini
                            $is_active = Carbon::parse($riwayat->tmt_selesai)->isFuture() || Carbon::parse($riwayat->tmt_selesai)->isToday();
                        @endphp
                        <div class="relative w-full md:flex {{ $loop->iteration % 2 == 1 ? 'md:justify-end' : 'md:justify-start' }}">

                            {{-- Penanda Titik (Dot) --}}
                            <div class="absolute left-8 top-10 z-20 h-6 w-6 -translate-x-1/2 rounded-full border-4 border-[#5063BF] {{ $is_active ? 'bg-green-400 shadow-[0_0_10px_#4ade80]' : 'bg-slate-400' }} md:left-1/2"></div>

                            <div class="ml-16 w-[calc(100%-5rem)] md:ml-0 md:w-[45%]">
                                <div class="bg-white rounded-2xl p-6 shadow-2xl overflow-hidden relative">

                                    {{-- Status Badge --}}
                                    <div class="flex justify-between items-center mb-6">
                                        <div class="flex items-center gap-2">
                                            <div class="h-2 w-2 rounded-full {{ $is_active ? 'bg-green-500 animate-pulse' : 'bg-slate-400' }}"></div>
                                            <span class="text-[11px] font-bold uppercase tracking-widest {{ $is_active ? 'text-green-600' : 'text-slate-500' }}">
                                                {{ $is_active ? 'Aktif Sekarang' : 'Riwayat Lama' }}
                                            </span>
                                        </div>
                                        <div class="text-right">
                                            <p class="text-[9px] text-slate-400 font-mono leading-none">PERIODE</p>
                                            <span class="text-[10px] text-slate-500 font-mono">
                                                {{ Carbon::parse($riwayat->tmt_mulai)->format('d/m/Y') }} - {{ Carbon::parse($riwayat->tmt_selesai)->format('d/m/Y') }}
                                            </span>
                                        </div>
                                    </div>

                                    {{-- Hirarki --}}
                                    <div class="space-y-4">

                                        {{-- 1. RESEARCH (Parent 1) --}}
                                        <div class="flex gap-3">
                                            <div class="flex flex-col items-center">
                                                <div class="w-2 h-2 rounded-full bg-slate-200"></div>
                                                <div class="w-0.5 h-full bg-slate-100"></div>
                                            </div>
                                            <div>
                                                <p class="text-[9px] font-bold text-slate-400 uppercase tracking-tighter">Research</p>
                                                <p class="text-sm font-medium text-slate-600">{{ $riwayat->coe->research->nama }}</p>
                                            </div>
                                        </div>

                                        {{-- 2. COE (Parent 2 / Target Level) --}}
                                        <div class="flex gap-3 ml-1 p-3 bg-blue-50 rounded-lg border-l-4 border-blue-500">
                                            <div class="flex flex-col items-center justify-center">
                                                <div class="w-2 h-2 rounded-full bg-blue-500"></div>
                                            </div>
                                            <div>
                                                <p class="text-[9px] font-bold text-blue-600 uppercase tracking-tighter">Center of Excellence</p>
                                                <p class="text-lg font-black text-slate-900">{{ $riwayat->coe->nama_coe }}</p>
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
                            Belum ada riwayat penempatan COE.
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
@endsection
