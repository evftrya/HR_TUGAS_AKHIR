@php
    $active_sidebar = 'Tambah Sertifikasi';
@endphp

@extends('kelola_data.base')

@section('header-base')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <style>
        .max-w-100 {
            max-width: 100% !important;
        }

        /* Typography Scaling */
        label,
        .text-sm,
        input,
        select,
        textarea,
        button,
        .ts-control {
            font-size: 1rem !important;
        }

        /* Container Grid Responsive */
        #form-grid-container {
            display: grid;
            gap: 1.5rem;
            grid-template-columns: 1fr;
        }

        @media (min-width: 1024px) {
            #form-grid-container {
                grid-template-columns: repeat(2, minmax(0, 1fr));
            }
        }

        /* Input Focus Style */
        input:focus,
        select:focus {
            outline: none;
            border-color: #0070ff;
            ring: 2px;
            ring-color: rgba(0, 112, 255, 0.2);
        }
    </style>
@endsection

@section('page-name')
    <div class="flex flex-col md:flex-row items-center gap-4 px-1 pt-4 pb-4 text-[#101828]">
        <span class="font-bold text-2xl">Tambah Data Sertifikasi</span>
    </div>
@endsection

@section('content-base')
    <div class="flex flex-col gap-6 w-full max-w-100 mb-10">

        <x-form route="{{ route('manage.sertifikasi-dosen.update', $sertifikasi->id) }}" id="form-sertifikasi"
            enctype="multipart/form-data">

            <div id="form-grid-container" class="rounded-xl border-2 p-4 md:p-8 bg-white shadow-sm">

                {{-- KOLOM KIRI (DATA PERSONEL & FILE) --}}
                <div class="flex flex-col gap-6">

                    {{-- Section Dosen --}}

                    <div
                        class="p-4 @if (request('dosen_id')) hidden @endif bg-blue-50/50 rounded-xl border border-blue-100 space-y-4">
                        <label class="font-bold text-gray-800 text-lg">Dosen Terlibat</label>
                        <div class="bg-white p-1 rounded-lg border shadow-sm">
                            <select name="dosen_id" class="w-full border-none rounded-lg p-2 focus:ring-0" required>
                                <option value="" disabled {{ old('dosen_id') == '' ? 'selected' : '' }}>-- Pilih Dosen
                                    --</option>
                                @foreach ($all_pegawai as $pegawai)
                                    <option value="{{ $pegawai->id }}"
                                        {{ old('dosen_id', request('dosen_id') ?? optional($sertifikasi)->dosen_id) == $pegawai->id ? 'selected' : '' }} >
                                        {{ $pegawai->pegawai_aktif->nama_lengkap }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    {{-- Section Lampiran --}}
                    <div x-data="{ mode: 'view' }"
                        class="p-4 md:p-6 bg-gray-50 rounded-xl border-2 border-gray-200 flex flex-col gap-4 shadow-inner">
                        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
                            <label class="font-bold text-gray-800 text-lg">Lampiran Sertifikat</label>

                            {{-- Toggle Switch --}}
                            <div class="flex bg-white p-1 rounded-lg border border-gray-300 shadow-sm w-fit">
                                <button type="button" @click="mode = 'view'"
                                    :class="mode === 'view' ? 'bg-[#0070ff] text-white shadow-sm' :
                                        'text-gray-500 hover:bg-gray-50'"
                                    class="px-4 py-1.5 text-sm font-semibold rounded-md transition-all">
                                    Lihat File
                                </button>
                                <button type="button" @click="mode = 'upload'"
                                    :class="mode === 'upload' ? 'bg-[#0070ff] text-white shadow-sm' :
                                        'text-gray-500 hover:bg-gray-50'"
                                    class="px-4 py-1.5 text-sm font-semibold rounded-md transition-all">
                                    Ganti File
                                </button>
                            </div>
                        </div>

                        <div
                            class="bg-white p-4 rounded-xl border border-gray-300 min-h-[110px] flex flex-col justify-center">

                            {{-- Tampilan Lihat File (Default) --}}
                            <div x-show="mode === 'view'" x-transition:enter class="w-full">
                                @if (isset($sertifikasi->path) && $sertifikasi->path)
                                    <div
                                        class="flex items-center gap-4 p-3 bg-blue-50/50 border border-blue-100 rounded-lg">
                                        <div class="p-2 bg-blue-100 rounded-lg">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-blue-600"
                                                fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                            </svg>
                                        </div>
                                        <div class="flex flex-col">
                                            <span class="text-sm font-bold text-gray-700">Sertifikat Terunggah</span>
                                            <a href="{{ route('manage.sertifikasi-dosen.file', ['id_serdos' => $sertifikasi->id]) }}"
                                                target="_blank" class="text-xs text-blue-600 hover:underline font-medium">
                                                Klik untuk pratinjau file
                                            </a>
                                        </div>
                                    </div>
                                @else
                                    <div class="text-center py-4">
                                        <p class="text-sm text-gray-400 italic">Belum ada file sertifikat yang tersedia.</p>
                                    </div>
                                @endif
                            </div>

                            {{-- Tampilan Input Upload Baru --}}
                            <div x-show="mode === 'upload'" x-transition:enter class="w-full">
                                <x-itxt lbl="Unggah PDF Baru" :req="false" type="file"
                                    nm="file_sertifikat"></x-itxt>
                                <p class="text-[11px] text-gray-500 mt-2 italic leading-relaxed">
                                    *Mengunggah file baru akan menggantikan sertifikat yang lama secara otomatis setelah
                                    data disimpan.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- KOLOM KANAN (DETAIL SERTIFIKASI) --}}
                <div class="flex flex-col gap-6">
                    <div class="flex flex-col gap-4">
                        <x-itxt lbl="Nomor Registrasi" nm="nomor_registrasi" val="{{ $sertifikasi->nomor_registrasi }}"
                            :req="true"></x-itxt>
                        <x-itxt lbl="Judul Sertifikasi" nm="judul" val="{{ $sertifikasi->judul }}"
                            :req="true"></x-itxt>
                    </div>

                    <div
                        class="bg-gray-50 p-4 md:p-6 rounded-xl border-2 border-dashed border-gray-300 grid grid-cols-1 md:grid-cols-2 gap-4">
                        <x-itxt lbl="Tgl Mulai Berlaku" :req="false" type="date" nm="tmt_mulai"
                            val="{{ \Carbon\Carbon::parse($sertifikasi->tmt_mulai)->format('Y-m-d') }}" ></x-itxt>
                        <x-itxt lbl="Tgl Akhir Berlaku" :req="false" type="date" nm="tmt_akhir"
                            val="{{ \Carbon\Carbon::parse($sertifikasi->tmt_akhir)->format('Y-m-d') }}" ></x-itxt>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <x-itxt lbl="Tanggal Terbit Sertifikat" type="date" nm="tgl_sertifikasi"
                            val="{{ \Carbon\Carbon::parse($sertifikasi->tgl_sertifikasi)->format('Y-m-d') }}" :req="true"></x-itxt>
                    </div>
                </div>

            </div>
        </x-form>
    </div>
@endsection

@push('script-under-base')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Script sederhana untuk validasi ukuran file sebelum upload (Opsional)
            const fileInput = document.querySelector('input[type="file"]');
            if (fileInput) {
                fileInput.addEventListener('change', function() {
                    if (this.files[0] && this.files[0].size > 2 * 1024 * 1024) {
                        Swal.fire('Peringatan', 'Ukuran file terlalu besar! Maksimal 2MB.', 'warning');
                        this.value = "";
                    }
                });
            }
        });
    </script>
@endpush
