@php
    $active_sidebar = 'Target Kinerja';
@endphp

@extends('kinerja_pegawai.base')

@section('header-base')
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    <style>
        [x-cloak] {
            display: none !important;
        }
        .form-card {
            background: #ffffff;
            border-radius: 24px;
            border: 1px solid #f2f2f7;
            box-shadow: 0 4px 20px -5px rgba(0, 0, 0, 0.05);
        }
        .evidence-thumb {
            aspect-ratio: 1 / 1;
            object-fit: cover;
            border-radius: 12px;
            cursor: pointer;
            transition: all 0.3s ease;
        }
        .evidence-thumb:hover {
            transform: scale(1.05);
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
        }
    </style>
@endsection

@section('page-name')
    <div class="flex items-center justify-between px-1">
        <div>
            <h2 class="text-2xl font-bold text-[#101828]">Verifikasi Bukti Pengerjaan</h2>
            <p class="text-sm text-gray-500">Tinjau laporan dan bukti fisik sebelum memberikan approval</p>
        </div>
    </div>
@endsection

@section('content-base')
    <div class="w-full" x-data="{ 
        showModal: false, 
        modalSrc: '', 
        isImage: true,
        openPreview(src, isImg) {
            this.modalSrc = src;
            this.isImage = isImg;
            this.showModal = true;
        }
    }">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            
            {{-- Left Side: Details & Form --}}
            <div class="lg:col-span-2 space-y-6">
                
                {{-- Detail Laporan --}}
                <div class="form-card p-8">
                    <div class="flex items-center gap-3 mb-6">
                        <div class="w-10 h-10 rounded-full bg-blue-50 flex items-center justify-center text-blue-600">
                            <i class="fa-solid fa-file-invoice"></i>
                        </div>
                        <h3 class="text-lg font-bold text-gray-800">Detail Laporan Pekerjaan</h3>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        <div class="space-y-1">
                            <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">Pekerjaan / Target Harian</p>
                            <p class="text-sm font-semibold text-gray-800">{{ $item->targetHarian->pekerjaan ?? '-' }}</p>
                        </div>

                        <div class="space-y-1">
                            <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">Pelapor</p>
                            <div class="flex items-center gap-2">
                                <div class="w-6 h-6 rounded-full bg-gray-100 flex items-center justify-center text-[10px] font-bold text-gray-500">
                                    {{ strtoupper(substr($item->pelapor?->nama_lengkap ?? '?', 0, 1)) }}
                                </div>
                                <p class="text-sm font-semibold text-gray-800">{{ $item->pelapor?->nama_lengkap ?? '-' }}</p>
                            </div>
                        </div>

                        <div class="md:col-span-2 space-y-2">
                            <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">Deskripsi Realisasi</p>
                            <div class="bg-gray-50 p-5 rounded-2xl border border-gray-100">
                                <p class="text-sm text-gray-700 leading-relaxed italic">"{{ $item->realisasi ?? 'Tidak ada deskripsi realisasi.' }}"</p>
                            </div>
                        </div>

                        <div class="flex items-center gap-10">
                            <div class="space-y-1">
                                <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">Jumlah Selesai</p>
                                <p class="text-xl font-black text-gray-900">{{ $item->effective_jumlah ?? '-' }}</p>
                            </div>
                            <div class="space-y-1">
                                <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">Durasi Kerja</p>
                                <p class="text-xl font-black text-gray-900">{{ $item->effective_waktu_minutes ?? '-' }} <span class="text-xs font-bold text-gray-400 uppercase">Menit</span></p>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Approval Form --}}
                <form action="{{ route('manage.target-kinerja.harian.reports.approve', $item->id) }}" method="POST" class="space-y-6">
                    @csrf
                    <div class="form-card p-8 border-t-4 border-t-blue-600">
                        <div class="flex items-center gap-3 mb-8">
                            <div class="w-10 h-10 rounded-full bg-emerald-50 flex items-center justify-center text-emerald-600">
                                <i class="fa-solid fa-clipboard-check"></i>
                            </div>
                            <h3 class="text-lg font-bold text-gray-800">Panel Keputusan Verifikator</h3>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                            <div class="space-y-2">
                                <label class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">Setujui Jumlah Output</label>
                                <input type="number" name="approved_jumlah" value="{{ old('approved_jumlah', $item->approved_jumlah ?? $item->realisasi_jumlah) }}"
                                    class="w-full border-gray-100 bg-gray-50 focus:bg-white focus:border-blue-500 focus:ring-blue-500 rounded-2xl px-5 py-3 text-sm transition-all font-bold">
                            </div>

                            <div class="space-y-2">
                                <label class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">Setujui Waktu (Menit)</label>
                                <input type="number" name="approved_waktu_minutes" value="{{ old('approved_waktu_minutes', $item->approved_waktu_minutes ?? $item->realisasi_waktu_minutes) }}"
                                    class="w-full border-gray-100 bg-gray-50 focus:bg-white focus:border-blue-500 focus:ring-blue-500 rounded-2xl px-5 py-3 text-sm transition-all font-bold">
                            </div>

                            <div class="md:col-span-2 space-y-2">
                                <label class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">Keputusan Status</label>
                                <div class="grid grid-cols-3 gap-3">
                                    <label class="relative flex flex-col items-center p-4 border rounded-2xl cursor-pointer hover:bg-gray-50 transition-all {{ ($item->status === 'in_progress') ? 'border-blue-500 bg-blue-50' : 'border-gray-100' }}">
                                        <input type="radio" name="assignment_status" value="in_progress" class="absolute opacity-0" {{ ($item->status === 'in_progress') ? 'checked' : '' }}>
                                        <i class="fa-solid fa-spinner text-blue-500 mb-1"></i>
                                        <span class="text-[10px] font-bold uppercase">In Progress</span>
                                    </label>
                                    <label class="relative flex flex-col items-center p-4 border rounded-2xl cursor-pointer hover:bg-gray-50 transition-all {{ ($item->status === 'completed' || $item->status === 'approved') ? 'border-emerald-500 bg-emerald-50' : 'border-gray-100' }}">
                                        <input type="radio" name="assignment_status" value="completed" class="absolute opacity-0" {{ ($item->status === 'completed' || $item->status === 'approved') ? 'checked' : '' }}>
                                        <i class="fa-solid fa-check-double text-emerald-500 mb-1"></i>
                                        <span class="text-[10px] font-bold uppercase">Approved</span>
                                    </label>
                                    <label class="relative flex flex-col items-center p-4 border rounded-2xl cursor-pointer hover:bg-gray-50 transition-all {{ ($item->status === 'cancelled' || $item->status === 'rejected') ? 'border-red-500 bg-red-50' : 'border-gray-100' }}">
                                        <input type="radio" name="assignment_status" value="cancelled" class="absolute opacity-0" {{ ($item->status === 'cancelled' || $item->status === 'rejected') ? 'checked' : '' }}>
                                        <i class="fa-solid fa-ban text-red-500 mb-1"></i>
                                        <span class="text-[10px] font-bold uppercase">Rejected</span>
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="flex items-center gap-3 mt-10">
                            <button type="submit"
                                class="flex-1 inline-flex items-center justify-center gap-2 px-8 py-4 bg-blue-600 text-white text-sm font-black rounded-2xl hover:bg-blue-700 shadow-lg shadow-blue-200 active:scale-95 transition-all">
                                <i class="fa-solid fa-paper-plane"></i>
                                SIMPAN VERIFIKASI
                            </button>
                            <a href="{{ route('manage.target-kinerja.harian.reports') }}"
                                class="px-8 py-4 bg-white border border-gray-200 text-gray-500 text-sm font-bold rounded-2xl hover:bg-gray-50 transition-all">
                                KEMBALI
                            </a>
                        </div>
                    </div>
                </form>
            </div>

            {{-- Right Side: Evidence Gallery (Fitur 2D7) --}}
            <div class="space-y-6">
                <div class="form-card p-6 sticky top-6">
                    <div class="flex items-center gap-2 mb-6">
                        <i class="fa-solid fa-images text-blue-500"></i>
                        <h3 class="text-sm font-bold text-gray-800 uppercase tracking-widest">Evidence Gallery</h3>
                    </div>

                    @php
                        // Deteksi tipe file evidence
                        $evidence = $item->evidence;
                        $isImage = false;
                        $isPdf = false;
                        
                        if ($evidence) {
                            $extension = strtolower(pathinfo($evidence, PATHINFO_EXTENSION));
                            // Jika link external tanpa extension, kita cek manual atau asumsikan link
                            if (in_array($extension, ['jpg', 'jpeg', 'png', 'gif', 'webp', 'svg'])) {
                                $isImage = true;
                            } elseif ($extension === 'pdf') {
                                $isPdf = true;
                            }
                        }
                    @endphp

                    <div class="bg-gray-50 rounded-3xl p-4 border border-gray-100 min-h-[300px] flex flex-col items-center justify-center">
                        @if($evidence)
                            <div class="grid grid-cols-1 gap-4 w-full">
                                @if($isImage)
                                    <div class="relative group">
                                        <img src="{{ $evidence }}" alt="Bukti Pekerjaan" 
                                            class="evidence-thumb w-full shadow-sm"
                                            @click="openPreview('{{ $evidence }}', true)">
                                        <div class="absolute inset-0 flex items-center justify-center bg-black/40 opacity-0 group-hover:opacity-100 transition-opacity rounded-xl pointer-events-none">
                                            <i class="fa-solid fa-magnifying-glass-plus text-white text-2xl"></i>
                                        </div>
                                    </div>
                                @elseif($isPdf)
                                    <div @click="openPreview('{{ $evidence }}', false)" 
                                        class="flex flex-col items-center justify-center p-8 bg-white rounded-2xl border border-red-100 hover:shadow-md transition-all cursor-pointer group">
                                        <i class="fa-solid fa-file-pdf text-5xl text-red-500 mb-4 group-hover:scale-110 transition-transform"></i>
                                        <span class="text-xs font-bold text-gray-400 uppercase">Dokumen PDF</span>
                                        <p class="text-[10px] text-blue-500 mt-2 font-bold underline">Klik untuk Preview</p>
                                    </div>
                                @else
                                    <a href="{{ $evidence }}" target="_blank"
                                        class="flex flex-col items-center justify-center p-8 bg-white rounded-2xl border border-gray-100 hover:shadow-md transition-all cursor-pointer group">
                                        <i class="fa-solid fa-link text-5xl text-blue-500 mb-4 group-hover:scale-110 transition-transform"></i>
                                        <span class="text-xs font-bold text-gray-400 uppercase">Tautan Eksternal</span>
                                        <p class="text-[10px] text-gray-400 mt-2 text-center break-all px-4">{{ Str::limit($evidence, 50) }}</p>
                                    </a>
                                @endif
                            </div>
                            
                            <div class="mt-6 w-full text-center">
                                <p class="text-[10px] text-gray-400 font-bold uppercase tracking-tighter mb-4">Quick View Panel</p>
                                <a href="{{ $evidence }}" target="_blank" 
                                    class="inline-flex items-center gap-2 text-[11px] font-black text-blue-600 hover:text-blue-800 uppercase tracking-widest">
                                    <i class="fa-solid fa-download"></i> Unduh File Asli
                                </a>
                            </div>
                        @else
                            <div class="text-center p-10">
                                <div class="w-16 h-16 rounded-full bg-gray-100 flex items-center justify-center mx-auto mb-4 text-gray-300">
                                    <i class="fa-solid fa-box-open text-2xl"></i>
                                </div>
                                <p class="text-xs font-bold text-gray-400 uppercase">Tidak ada bukti fisik</p>
                                <p class="text-[10px] text-gray-300 mt-1">Pegawai tidak melampirkan file atau tautan pada laporan ini.</p>
                            </div>
                        @endif
                    </div>
                    
                    <div class="mt-8 p-4 bg-blue-50 rounded-2xl border border-blue-100">
                        <div class="flex gap-3">
                            <i class="fa-solid fa-circle-info text-blue-400 mt-0.5"></i>
                            <div class="space-y-1">
                                <p class="text-[10px] font-black text-blue-800 uppercase">Tips Verifikasi</p>
                                <p class="text-[10px] text-blue-600 leading-relaxed font-medium">Pastikan output pada bukti sesuai dengan deskripsi realisasi yang dilaporkan oleh pegawai.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- ── Quick View Modal (Lightbox) ──────────────── --}}
        <div x-show="showModal" 
            x-cloak
            class="fixed inset-0 z-[100] flex items-center justify-center p-4 sm:p-10"
            x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100"
            x-transition:leave="transition ease-in duration-200"
            x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0">
            
            {{-- Backdrop --}}
            <div class="absolute inset-0 bg-black/90 backdrop-blur-sm" @click="showModal = false"></div>
            
            {{-- Content --}}
            <div class="relative max-w-5xl w-full h-full flex flex-col items-center justify-center"
                x-transition:enter="transition ease-out duration-300 scale-95"
                x-transition:enter-start="opacity-0 scale-90"
                x-transition:enter-end="opacity-100 scale-100">
                
                <button @click="showModal = false" class="absolute -top-12 right-0 text-white hover:text-gray-300 transition-colors">
                    <i class="fa-solid fa-xmark text-3xl"></i>
                </button>

                <template x-if="isImage">
                    <img :src="modalSrc" class="max-w-full max-h-full rounded-2xl shadow-2xl object-contain">
                </template>
                
                <template x-if="!isImage">
                    <iframe :src="modalSrc" class="w-full h-full rounded-2xl bg-white shadow-2xl"></iframe>
                </template>

                <div class="mt-6 flex items-center gap-4">
                    <a :href="modalSrc" target="_blank" class="px-6 py-2 bg-white/10 hover:bg-white/20 text-white text-xs font-bold rounded-full border border-white/20 transition-all">
                        BUKA DI TAB BARU
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection
