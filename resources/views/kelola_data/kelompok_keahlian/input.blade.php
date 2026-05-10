@php
    $active_sidebar = 'Tambah Kelompok Keahlian';
@endphp
@extends('kelola_data.base')

@section('header-base')
    <style>
        .max-w-100 {
            max-width: 100% !important;
        }

        .nav-active {
            background-color: #0070ff;

            span {
                color: white;
            }
        }
    </style>
@endsection

@section('page-name')
    <div
        class="flex flex-col md:flex-row items-center gap-[11.749480247497559px] self-stretch px-1 pt-[14.686850547790527px] pb-[13.952507972717285px]">
        <div class="flex w-full flex-col gap-[2.9373700618743896px] grow">
            <div class="flex items-center gap-[5.874740123748779px] self-stretch">
                <span class="font-medium text-2xl leading-[20.56159019470215px] text-[#101828]">
                    Tambah Kelompok Keahlian Baru
                </span>
            </div>
        </div>
    </div>
@endsection

@section('content-base')
    <x-form route="{{ route('manage.kelompok-keahlian.store') }}" id="kelompok-keahlian-input">
        <div class="grid gap-8">
            <div class="flex flex-col gap-4">

                {{-- Fakultas --}}
                <x-islc lbl="Fakultas" nm="fakultas_id" :req="true" class="select-fakultas">
                    <option value="" disabled selected>Pilih Fakultas</option>
                    {{-- Tambahkan loop data fakultas di sini --}}
                </x-islc>

                {{-- Nama KK --}}
                <x-itxt lbl="Nama KK" nm="nama" plc="Masukkan nama lengkap KK..." :req="true"></x-itxt>

                {{-- Kode KK --}}
                <x-itxt lbl="Kode KK" nm="kode" plc="Contoh: KK-01" :req="true"></x-itxt>

                {{-- Deskripsi Visi --}}
                {{-- Menggunakan HTML native karena tidak ada contoh component textarea (seperti x-txtarea) di template awal --}}
                <div class="flex flex-col gap-1 w-full">
                    <label class="block text-sm font-semibold text-[#344054]">
                        Deskripsi Visi <span class="text-red-500">*</span>
                    </label>
                    <textarea name="deskripsi" placeholder="Jelaskan fokus keahlian..."
                        class="w-full p-4 bg-white border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition-all h-32"
                        required>{{ old('deskripsi') }}</textarea>
                </div>

            </div>
        </div>
    </x-form>
@endsection
