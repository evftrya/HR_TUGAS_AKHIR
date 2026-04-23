@php
    $active_sidebar = 'Target Kinerja';
@endphp

@extends('kinerja_pegawai.base')

@section('header-base')
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <style>
        [x-cloak] {
            display: none !important;
        }
        .form-card {
            background: #ffffff;
            border-radius: 16px;
            border: 1px solid #f2f2f7;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
        }
    </style>
@endsection

@section('page-name')
    <div class="flex items-center justify-between px-1">
        <div>
            <h2 class="text-2xl font-bold text-[#101828]">Approval Laporan</h2>
            <p class="text-sm text-gray-500">Review dan berikan persetujuan untuk laporan pekerjaan</p>
        </div>
    </div>
@endsection

@section('content-base')
    <div class="w-full">
        <div class="space-y-6">
            {{-- Review Details Card --}}
            <div class="form-card p-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-x-8 gap-y-6">
                    <div class="md:col-span-2 border-b border-gray-100 pb-2 mb-2">
                        <h3 class="text-lg font-bold text-gray-800">Detail Laporan</h3>
                    </div>

                    <div class="space-y-1">
                        <p class="text-xs font-bold text-gray-400 uppercase tracking-widest">Target Harian</p>
                        <p class="text-sm font-semibold text-gray-800">{{ $item->targetHarian->pekerjaan ?? '-' }}</p>
                    </div>

                    <div class="space-y-1">
                        <p class="text-xs font-bold text-gray-400 uppercase tracking-widest">Target Pribadi</p>
                        <div>
                            @php $tk = $item->targetHarian->targetKinerja ?? null; @endphp
                            @if($tk && $tk->status === 'pribadi')
                                <span class="inline-flex items-center px-2 py-0.5 rounded-full bg-amber-50 text-amber-700 border border-amber-100 text-[10px] font-black uppercase">Ya</span>
                                <div class="text-xs text-gray-500 mt-1 italic">Penanggung:
                                    {{ $tk->pegawai && $tk->pegawai->isNotEmpty() ? $tk->pegawai->pluck('nama_lengkap')->join(', ') : '-' }}
                                </div>
                            @else
                                <span class="inline-flex items-center px-2 py-0.5 rounded-full bg-gray-50 text-gray-500 border border-gray-100 text-[10px] font-black uppercase">Tidak</span>
                            @endif
                        </div>
                    </div>

                    <div class="md:col-span-2 space-y-1 bg-gray-50 p-4 rounded-xl border border-gray-100">
                        <p class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-1">Realisasi Pekerjaan</p>
                        <p class="text-sm text-gray-700 leading-relaxed">{{ $item->realisasi ?? '-' }}</p>
                    </div>

                    <div class="space-y-1">
                        <p class="text-xs font-bold text-gray-400 uppercase tracking-widest">Realisasi Jumlah (Efektif)</p>
                        <p class="text-sm font-black text-gray-900">{{ $item->effective_jumlah ?? '-' }}</p>
                        @if($item->approved_jumlah !== null && $item->approved_jumlah != $item->realisasi_jumlah)
                            <p class="text-[10px] text-gray-400 italic">(Original: {{ $item->realisasi_jumlah ?? '-' }})</p>
                        @endif
                    </div>

                    <div class="space-y-1">
                        <p class="text-xs font-bold text-gray-400 uppercase tracking-widest">Realisasi Waktu (Efektif)</p>
                        <p class="text-sm font-black text-gray-900">{{ $item->effective_waktu_minutes ?? '-' }} <span class="text-[10px] font-bold text-gray-400 uppercase">menit</span></p>
                        @if($item->approved_waktu_minutes !== null && $item->approved_waktu_minutes != $item->realisasi_waktu_minutes)
                            <p class="text-[10px] text-gray-400 italic">(Original: {{ $item->realisasi_waktu_minutes ?? '-' }})</p>
                        @endif
                    </div>
                </div>
            </div>

            {{-- Approval Form Card --}}
            <form action="{{ route('manage.target-kinerja.harian.reports.approve', $item->id) }}" method="POST" class="space-y-6">
                @csrf
                <div class="form-card p-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-x-8 gap-y-6">
                        <div class="md:col-span-2 border-b border-gray-100 pb-2 mb-2">
                            <h3 class="text-lg font-bold text-gray-800">Review & Keputusan</h3>
                        </div>

                        <div class="space-y-1">
                            <div class="flex items-center gap-1">
                                <label class="block text-sm font-semibold text-gray-700">Approved Jumlah</label>
                                <div x-data="{ open: false }" class="relative inline-block">
                                    <i @click="open = !open" @click.outside="open = false"
                                        class="fa-solid fa-circle-exclamation text-blue-500 cursor-pointer text-sm"></i>
                                    <div x-show="open" x-cloak x-transition
                                        class="absolute z-10 w-64 p-3 mt-2 text-sm text-white bg-gray-800 rounded-lg shadow-xl -left-1">
                                        Jumlah output yang diakui/disetujui oleh verifikator.
                                    </div>
                                </div>
                            </div>
                            <input type="number" name="approved_jumlah" value="{{ old('approved_jumlah', $item->approved_jumlah) }}" 
                                class="w-full border-gray-200 focus:border-blue-500 focus:ring-blue-500 rounded-xl px-4 py-2.5 text-sm transition-all">
                        </div>

                        <div class="space-y-1">
                            <div class="flex items-center gap-1">
                                <label class="block text-sm font-semibold text-gray-700">Approved Waktu (menit)</label>
                                <div x-data="{ open: false }" class="relative inline-block">
                                    <i @click="open = !open" @click.outside="open = false"
                                        class="fa-solid fa-circle-exclamation text-blue-500 cursor-pointer text-sm"></i>
                                    <div x-show="open" x-cloak x-transition
                                        class="absolute z-10 w-64 p-3 mt-2 text-sm text-white bg-gray-800 rounded-lg shadow-xl -left-1">
                                        Total menit kerja yang diakui untuk laporan ini.
                                    </div>
                                </div>
                            </div>
                            <input type="number" name="approved_waktu_minutes" value="{{ old('approved_waktu_minutes', $item->approved_waktu_minutes) }}" 
                                class="w-full border-gray-200 focus:border-blue-500 focus:ring-blue-500 rounded-xl px-4 py-2.5 text-sm transition-all">
                        </div>

                        <div class="space-y-1">
                            <div class="flex items-center gap-1">
                                <label class="block text-sm font-semibold text-gray-700">Pencapaian (%)</label>
                                <div x-data="{ open: false }" class="relative inline-block">
                                    <i @click="open = !open" @click.outside="open = false"
                                        class="fa-solid fa-circle-exclamation text-blue-500 cursor-pointer text-sm"></i>
                                    <div x-show="open" x-cloak x-transition
                                        class="absolute z-10 w-64 p-3 mt-2 text-sm text-white bg-gray-800 rounded-lg shadow-xl -left-1">
                                        Persentase keberhasilan dari target yang direncanakan.
                                    </div>
                                </div>
                            </div>
                            <input type="number" name="pencapaian_percent" value="{{ old('pencapaian_percent', $item->pencapaian_percent) }}" 
                                class="w-full border-gray-200 focus:border-blue-500 focus:ring-blue-500 rounded-xl px-4 py-2.5 text-sm transition-all">
                        </div>

                        <div class="space-y-1">
                            <div class="flex items-center gap-1">
                                <label class="block text-sm font-semibold text-gray-700">Evidence (Link)</label>
                                <div x-data="{ open: false }" class="relative inline-block">
                                    <i @click="open = !open" @click.outside="open = false"
                                        class="fa-solid fa-circle-exclamation text-blue-500 cursor-pointer text-sm"></i>
                                    <div x-show="open" x-cloak x-transition
                                        class="absolute z-10 w-64 p-3 mt-2 text-sm text-white bg-gray-800 rounded-lg shadow-xl -left-1">
                                        Tautan bukti pengerjaan (Google Drive, Dokumen, dll).
                                    </div>
                                </div>
                            </div>
                            <input type="text" name="evidence" value="{{ old('evidence', $item->evidence) }}" 
                                class="w-full border-gray-200 focus:border-blue-500 focus:ring-blue-500 rounded-xl px-4 py-2.5 text-sm transition-all" placeholder="https://...">
                        </div>

                        <div class="md:col-span-2 space-y-1">
                            <div class="flex items-center gap-1">
                                <label class="block text-sm font-semibold text-gray-700">Set Status Penugasan</label>
                                <div x-data="{ open: false }" class="relative inline-block">
                                    <i @click="open = !open" @click.outside="open = false"
                                        class="fa-solid fa-circle-exclamation text-blue-500 cursor-pointer text-sm"></i>
                                    <div x-show="open" x-cloak x-transition
                                        class="absolute z-10 w-64 p-3 mt-2 text-sm text-white bg-gray-800 rounded-lg shadow-xl -left-1">
                                        Status terbaru untuk penugasan terkait laporan ini.
                                    </div>
                                </div>
                            </div>
                            <select name="assignment_status" class="w-full border-gray-200 focus:border-blue-500 focus:ring-blue-500 rounded-xl px-4 py-2.5 text-sm transition-all">
                                <option value="in_progress" {{ ((old('assignment_status') ?? $item->status) === 'in_progress') ? 'selected' : '' }}>In Progress</option>
                                <option value="completed" {{ ((old('assignment_status') ?? $item->status) === 'completed') ? 'selected' : '' }}>Approved / Completed</option>
                                <option value="cancelled" {{ ((old('assignment_status') ?? $item->status) === 'cancelled') ? 'selected' : '' }}>Cancelled</option>
                            </select>
                            <p class="text-[10px] text-gray-400 mt-1 italic">Mengubah status ini akan memperbarui status assignment pada target terkait untuk pengirim laporan.</p>
                        </div>
                    </div>
                </div>

                {{-- Form Actions --}}
                <div class="flex items-center gap-3 pt-4 pb-8">
                    <button type="submit"
                        class="inline-flex items-center gap-2 px-6 py-3 bg-emerald-600 text-white text-sm font-bold rounded-xl hover:bg-emerald-700 hover:shadow-lg active:scale-95 transition-all">
                        <i class="fa-solid fa-check-circle"></i> 
                        Setujui Laporan
                    </button>
                    <a href="{{ route('manage.target-kinerja.harian.reports') }}"
                        class="px-6 py-3 bg-white border border-gray-200 text-gray-600 text-sm font-bold rounded-xl hover:bg-gray-50 transition-all">
                        Kembali
                    </a>
                </div>
            </form>
        </div>
    </div>
@endsection
