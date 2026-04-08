@php
    $active_sidebar = 'Sertifikasi Dosen';
    // Link dummy yang Anda berikan
    $url_pdf_dummy = "https://darmadi.staff.unri.ac.id/files/2015/11/MAMALIA.pdf";
@endphp

@extends('kelola_data.base')

@section('header-base')
    <style>
        .max-w-100 {
            max-width: 100% !important;
        }
    </style>
@endsection

@section('page-name')
    <div class="flex flex-col md:flex-row items-center gap-[11.749480247497559px] self-stretch px-1 pt-[14.686850547790527px] pb-[13.952507972717285px]">
        <div class="flex w-full flex-col gap-[2.9373700618743896px] grow">
            <div class="flex items-center gap-[5.874740123748779px] self-stretch">
                <span class="font-medium text-2xl leading-[20.56159019470215px] text-[#101828]">
                    Detail Sertifikasi Dosen
                </span>
            </div>
        </div>
        <div class="flex items-center w-full justify-end gap-[11.749480247497559px]">
            <a href="{{ route('manage.sertifikasi-dosen.edit', $sertifikasi->id) }}"
                class="flex rounded-[5.874740123748779px]">
                <div class="flex justify-center items-center gap-[5.874740123748779px] bg-[#f59e0b] px-[11.749480247497559px] py-[7.343425273895264px] rounded-[5.874740123748779px] border border-[#f59e0b] hover:bg-[#d97706] transition">
                    <i class="bi bi-pencil text-sm text-white"></i>
                    <span class="font-medium text-[10.28px] leading-[14.68px] text-white">Edit</span>
                </div>
            </a>
        </div>
    </div>
@endsection

@section('content-base')
    <div class="flex flex-col gap-8 w-full max-w-100 mx-auto">
        <div class="flex flex-col gap-8 rounded-md border p-6 bg-white">
            <h2 class="text-lg font-semibold text-black border-b pb-3">Informasi Sertifikasi Dosen</h2>

            <div class="grid md:grid-cols-2 gap-6">
                <div class="flex flex-col gap-2">
                    <span class="text-sm text-gray-500">Nama Dosen</span>
                    <span class="text-base font-medium text-gray-900">{{ $sertifikasi->dosen->pegawai->nama_lengkap ?? '-' }}</span>
                </div>

                <div class="flex flex-col gap-2">
                    <span class="text-sm text-gray-500">NIDN</span>
                    <span class="text-base font-medium text-gray-900">{{ $sertifikasi->dosen->nidn ?? '-' }}</span>
                </div>

                <div class="flex flex-col gap-2">
                    <span class="text-sm text-gray-500">Program Studi</span>
                    <span class="text-base font-medium text-gray-900">{{ $sertifikasi->dosen->prodi->position_name ?? '-' }}</span>
                </div>

                <div class="flex flex-col gap-2">
                    <span class="text-sm text-gray-500">Nomor Registrasi</span>
                    <span class="text-base font-medium text-gray-900">{{ $sertifikasi->nomor_registrasi ?? '-' }}</span>
                </div>

                {{-- <div class="flex flex-col gap-2">
                    <span class="text-sm text-gray-500">No SK</span>
                    <span class="text-base font-medium text-gray-900">{{ $sertifikasi->no_sk ?? '-' }}</span>
                </div> --}}

                <div class="flex flex-col gap-2">
                    <span class="text-sm text-gray-500">Tanggal Berlaku</span>
                    <span class="text-base font-medium text-gray-900">{{ $sertifikasi->tmt_mulai ??  '-' }} s/d {{ $sertifikasi->tmt_akhir ??  '-' }}</span>
                </div>

                <div class="flex flex-col gap-2">
                    <span class="text-sm text-gray-500">Tanggal Mulai Berlaku</span>
                    <span class="text-base font-medium text-gray-900">{{ $sertifikasi->tgl_sertifikasi ??  '-' }}</span>
                </div>
            </div>
        </div>

        <div class="flex flex-col gap-4 rounded-md border p-6 bg-white">
            <div class="flex justify-between items-center border-b pb-3">
                <h2 class="text-lg font-semibold text-black">Preview Dokumen Sertifikasi</h2>
                <a href="{{ route('manage.sertifikasi-dosen.file', ['id_serdos' => $sertifikasi->id]) }}" target="_blank" class="text-blue-600 hover:underline text-sm flex items-center gap-1">
                    <i class="bi bi-box-arrow-up-right"></i> Buka di Tab Baru
                </a>
            </div>
            
            <div class="w-full bg-gray-100 rounded-lg overflow-hidden border" style="height: 600px;">
                <iframe 
                    src="{{ route('manage.sertifikasi-dosen.file', ['id_serdos' => $sertifikasi->id]) }}#toolbar=0" 
                    width="100%" 
                    height="100%" 
                    style="border: none;">
                    <p>Browser Anda tidak mendukung preview PDF. <a href="{{ route('manage.sertifikasi-dosen.file', ['id_serdos' => $sertifikasi->id]) }}">Klik di sini untuk mengunduh.</a></p>
                </iframe>
            </div>
        </div>

        <div class="flex justify-end gap-4">
            <a href="{{ route('manage.sertifikasi-dosen.list') }}"
                class="px-4 py-2 bg-gray-300 text-gray-700 rounded hover:bg-gray-400">
                Kembali
            </a>
        </div>
    </div>
@endsection