@php
    $active_sidebar = 'Target Kinerja';
@endphp

@extends('kinerja_pegawai.base')

@section('header-base')
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
@endsection

@section('page-name', 'Verifikasi Laporan Kinerja')

@section('content-base')
<div class="mb-4">
    <p class="text-sm text-gray-500 italic">Tinjau realisasi pekerjaan dan tentukan hasil validasi.</p>
</div>
<div class="w-full max-w-7xl mx-auto p-4 sm:p-6 lg:p-8 bg-white rounded-lg shadow-sm border border-gray-100" x-data="{ 
    showModal: false, 
    modalSrc: '{{ $item->evidence }}', 
    isImage: {{ in_array(strtolower(pathinfo($item->evidence, PATHINFO_EXTENSION)), ['jpg', 'jpeg', 'png', 'webp', 'svg']) ? 'true' : 'false' }}
}">
    
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-10">
        
        {{-- Left: Report Details --}}
        <div class="lg:col-span-2 space-y-8">
            {{-- Employee Info --}}
            <div class="bg-gray-50 p-6 rounded-xl border border-gray-200">
                <h3 class="text-lg font-semibold text-gray-700 mb-6 border-l-4 border-blue-600 pl-4 uppercase tracking-tight">Informasi Pelapor</h3>
                <div class="flex items-center gap-5">
                    <div class="w-16 h-14 rounded-2xl bg-white flex items-center justify-center text-blue-600 font-black text-xl shadow-sm border border-blue-100">
                        {{ strtoupper(substr($item->pelapor?->nama_lengkap ?? '?', 0, 1)) }}
                    </div>
                    <div>
                        <p class="text-lg font-bold text-gray-900 leading-none">{{ $item->pelapor?->nama_lengkap ?? '-' }}</p>
                        <p class="text-xs text-gray-500 font-medium mt-1">{{ $item->pelapor?->unit?->nama_unit ?? 'Pegawai Institusi' }}</p>
                    </div>
                </div>
            </div>

            {{-- Realization Narrative --}}
            <div class="bg-white p-6 rounded-xl border border-gray-100 shadow-sm">
                <h3 class="text-lg font-semibold text-gray-700 mb-4 border-l-4 border-emerald-600 pl-4 uppercase tracking-tight">Narasi Realisasi</h3>
                <div class="p-5 bg-gray-50 rounded-lg border border-gray-100 text-sm text-gray-700 leading-relaxed italic">
                    "{{ $item->realisasi ?? 'Tidak ada narasi realisasi.' }}"
                </div>
            </div>

            {{-- Evidence Preview --}}
            @if($item->evidence)
            <div class="bg-white p-6 rounded-xl border border-gray-100 shadow-sm">
                <h3 class="text-lg font-semibold text-gray-700 mb-4 border-l-4 border-amber-600 pl-4 uppercase tracking-tight">Bukti Pengerjaan (Evidence)</h3>
                <div class="flex items-center gap-4 p-4 bg-gray-50 rounded-xl border border-gray-100">
                    <div class="w-12 h-12 bg-white rounded-lg flex items-center justify-center text-blue-500 shadow-sm">
                        <i class="fa-solid fa-file-invoice text-xl"></i>
                    </div>
                    <div class="flex-grow overflow-hidden">
                        <p class="text-xs font-bold text-gray-800 truncate">{{ $item->evidence }}</p>
                        <p class="text-[10px] text-gray-400 uppercase font-medium">Link Lampiran Pekerjaan</p>
                    </div>
                    <button @click="showModal = true" class="bg-white border border-gray-300 text-gray-700 hover:bg-gray-100 px-4 py-2 rounded-md text-xs font-bold transition-all shadow-sm">
                        PREVIEW
                    </button>
                    <a href="{{ $item->evidence }}" target="_blank" class="bg-blue-600 text-white hover:bg-blue-700 px-4 py-2 rounded-md text-xs font-bold transition-all shadow-sm">
                        OPEN
                    </a>
                </div>
            </div>
            @endif
        </div>

        {{-- Right: Approval Form --}}
        <div class="lg:col-span-1">
            <div class="sticky top-8 bg-gray-50 p-6 rounded-2xl border border-gray-200 shadow-lg">
                <h3 class="text-lg font-bold text-gray-800 mb-6 flex items-center gap-2">
                    <i class="fa-solid fa-stamp text-blue-600"></i> Form Verifikasi
                </h3>

                <form action="{{ route('manage.target-kinerja.harian.reports.approve', $item->id) }}" method="POST" class="space-y-6">
                    @csrf
                    
                    <div class="space-y-2">
                        <label class="text-[10px] font-bold text-gray-400 uppercase tracking-widest block">Status Keputusan</label>
                        <select name="assignment_status" class="w-full text-sm font-bold border-gray-200 rounded-xl py-3 focus:ring-blue-500" required>
                            <option value="completed" {{ $item->status === 'approved' ? 'selected' : '' }}>SETUJUI (COMPLETED)</option>
                            <option value="pending" {{ $item->status === 'pending' ? 'selected' : '' }}>TANGGUHKAN (PENDING)</option>
                            <option value="cancelled">TOLAK (CANCELLED)</option>
                        </select>
                    </div>

                    <div class="space-y-2">
                        <label class="text-[10px] font-bold text-gray-400 uppercase tracking-widest block">Validasi Waktu (Menit)</label>
                        <input type="number" name="waktu_validasi_atasan" value="{{ $item->waktu_pengerjaan }}" required
                            class="w-full text-lg font-black border-gray-200 rounded-xl py-3 focus:ring-blue-500 text-center"
                            placeholder="Contoh: 60">
                        <p class="text-[10px] text-gray-400 italic text-center">* Estimasi waktu wajar menurut atasan.</p>
                    </div>

                    <div class="space-y-2">
                        <label class="text-[10px] font-bold text-gray-400 uppercase tracking-widest block">Catatan Verifikasi</label>
                        <textarea name="atasan_note" rows="3" class="w-full text-sm border-gray-200 rounded-xl p-3 focus:ring-blue-500" placeholder="Berikan arahan atau alasan penolakan..."></textarea>
                    </div>

                    <div class="pt-4">
                        <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-4 rounded-xl shadow-lg shadow-blue-100 transition-all active:scale-95 uppercase tracking-widest">
                            Simpan Verifikasi
                        </button>
                        <a href="{{ route('manage.target-kinerja.harian.reports') }}" class="block text-center text-xs font-bold text-gray-400 hover:text-gray-600 mt-4 transition-colors">
                            KEMBALI KE DAFTAR
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- MODAL PREVIEW --}}
    <div x-show="showModal" x-cloak class="fixed inset-0 z-[100] flex items-center justify-center p-10 bg-black/90 backdrop-blur-sm" @keydown.escape.window="showModal = false">
        <button @click="showModal = false" class="absolute top-10 right-10 text-white text-3xl hover:scale-110 transition-transform">
            <i class="fa-solid fa-xmark"></i>
        </button>
        <div class="w-full h-full max-w-5xl flex items-center justify-center">
            <template x-if="isImage">
                <img :src="modalSrc" class="max-w-full max-h-full rounded-xl shadow-2xl object-contain border-4 border-white/10">
            </template>
            <template x-if="!isImage">
                <iframe :src="modalSrc" class="w-full h-full rounded-xl bg-white shadow-2xl"></iframe>
            </template>
        </div>
    </div>
</div>
@endsection
