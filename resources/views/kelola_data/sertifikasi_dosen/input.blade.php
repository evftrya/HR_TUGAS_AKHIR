@php
    $active_sidebar = 'Tambah Sertifikasi';
@endphp

@extends('kelola_data.base')

@section('header-base')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <style>
        .max-w-100 { max-width: 100% !important; }

        /* Typography Scaling */
        label, .text-sm, input, select, textarea, button, .ts-control {
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
        input:focus, select:focus {
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

        <x-form route="{{ route('manage.sertifikasi-dosen.store') }}" id="form-sertifikasi" enctype="multipart/form-data">
            
            <div id="form-grid-container" class="rounded-xl border-2 p-4 md:p-8 bg-white shadow-sm">

                {{-- KOLOM KIRI (DATA PERSONEL & FILE) --}}
                <div class="flex flex-col gap-6">
                    
                    {{-- Section Dosen --}}
                    
                    <div class="p-4 @if(request('dosen_id')) hidden @endif bg-blue-50/50 rounded-xl border border-blue-100 space-y-4">
                        <label class="font-bold text-gray-800 text-lg">Dosen Terlibat</label>
                        <div class="bg-white p-1 rounded-lg border shadow-sm">
                            <select name="dosen_id" class="w-full border-none rounded-lg p-2 focus:ring-0" required>
                                <option value="" disabled {{ old('dosen_id') == '' ? 'selected' : '' }}>-- Pilih Dosen --</option>
                                @foreach ($all_pegawai as $pegawai)
                                    <option value="{{ $pegawai->id }}" {{ old('dosen_id', request('dosen_id')) == $pegawai->id ? 'selected' : '' }}>
                                        {{ $pegawai->pegawai_aktif->nama_lengkap }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    {{-- Section Lampiran --}}
                    <div class="p-4 md:p-6 bg-gray-50 rounded-xl border-2 border-gray-200 flex flex-col gap-4 shadow-inner">
                        <label class="font-bold text-gray-800 text-lg">Lampiran Sertifikat</label>
                        <div class="bg-white p-4 rounded-xl border border-gray-300">
                            <x-itxt lbl="Unggah PDF Sertifikat" :req="true" type="file" nm="file_sertifikat"></x-itxt>
                            <p class="text-[11px] text-gray-500 mt-2 italic">*Pastikan format file berupa PDF (Maks. 2MB)</p>
                        </div>
                    </div>
                </div>

                {{-- KOLOM KANAN (DETAIL SERTIFIKASI) --}}
                <div class="flex flex-col gap-6">
                    <div class="flex flex-col gap-4">
                        <x-itxt lbl="Nomor Registrasi" nm="nomor_registrasi" value="{{ old('nomor_registrasi') }}" :req="true"></x-itxt>
                        <x-itxt lbl="Judul Sertifikasi" nm="judul" value="{{ old('judul') }}" :req="true"></x-itxt>
                    </div>

                    <div class="bg-gray-50 p-4 md:p-6 rounded-xl border-2 border-dashed border-gray-300 grid grid-cols-1 md:grid-cols-2 gap-4">
                        <x-itxt lbl="Tgl Mulai Berlaku" :req="false" type="date" nm="tmt_mulai" value="{{ old('tmt_mulai') }}"></x-itxt>
                        <x-itxt lbl="Tgl Akhir Berlaku" :req="false" type="date" nm="tmt_akhir" value="{{ old('tmt_akhir') }}"></x-itxt>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <x-itxt lbl="Tanggal Terbit Sertifikat" type="date" nm="tgl_sertifikasi" value="{{ old('tgl_sertifikasi') }}" :req="true"></x-itxt>
                    </div>

                    {{-- Tombol Submit di Mobile akan berada di bawah --}}
                    <div class="mt-4 flex justify-end">
                        <button type="submit" class="w-full md:w-auto px-8 py-3 bg-[#0070ff] text-white font-bold rounded-xl hover:bg-[#005bc3] transition-all shadow-md">
                            Simpan Data
                        </button>
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
            if(fileInput) {
                fileInput.addEventListener('change', function() {
                    if(this.files[0] && this.files[0].size > 2 * 1024 * 1024) {
                        Swal.fire('Peringatan', 'Ukuran file terlalu besar! Maksimal 2MB.', 'warning');
                        this.value = "";
                    }
                });
            }
        });
    </script>
@endpush