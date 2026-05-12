@php
    $active_sidebar = 'Tambah Sub Kelompok Keahlian';
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
                    Tambah Sub-Kelompok Keahlian Baru
                </span>
            </div>
        </div>
    </div>
@endsection

@section('content-base')
    <x-form route="{{ route('manage.kelompok-keahlian.sub.store') }}" id="sub-kk-input">
        <div class="grid gap-8">
            <div class="flex flex-col gap-4">

                {{-- Kelompok Keahlian Induk --}}
                <x-islc lbl="Kelompok Keahlian" nm="kk_id" :req="true" class="select-kk">
                    <option value="" disabled selected>Pilih KK Induk</option>
                    @forelse ($kk as $data)
                    <option value="{{ $data['id'] }}" {{ $data['id']==old('kk_id', request('kk_id')) ? 'Selected' : '' }}>{{$data['nama']}}</option>

                    @empty
                    <option value="" disabled selected>Belum Ada Kelompok Keahlian Terdaftar</option>
                    @endforelse
                    {{-- Tambahkan loop data KK Induk di sini --}}
                </x-islc>

                {{-- Nama Spesialisasi --}}
                <x-itxt lbl="Nama Spesialisasi" nm="nama" max="200" plc="Masukkan nama sub-kk..." :req="true"></x-itxt>

                {{-- Kode Sub-KK --}}
                <x-itxt lbl="Kode Sub-KK" nm="kode" max="50" plc="Contoh: SKK-01" :req="true"></x-itxt>

                {{-- Deskripsi Teknis --}}
                <div class="flex flex-col gap-1 w-full">
                    <label class="block text-sm font-semibold text-[#344054]">
                        Deskripsi Teknis <span class="text-red-500">*</span>
                    </label>
                    <textarea name="deskripsi" placeholder="Detail keahlian..."
                        class="w-full p-4 bg-white border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition-all h-32"
                        required>{{ old('deskripsi') }}</textarea>
                </div>

            </div>
        </div>
    </x-form>
@endsection
