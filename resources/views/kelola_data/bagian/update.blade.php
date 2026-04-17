@php
    $active_sidebar = 'Tambah Bagian';
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
                    Edit Bagian Kerja
                </span>
            </div>
        </div>
    </div>
@endsection

@section('content-base')
    <x-form route="{{ route('manage.bagian.update', ['id_wp'=>request('id_wp')]) }}" id="bagian-input">
        <div class="grid gap-8">
            <div class="flex flex-col gap-4">
                {{-- Nama Bagian --}}
                <x-itxt lbl="Nama Bagian" nm="position_name" plc="Masukkan nama bagian (contoh: Administrasi)"
                    :req="true" val="{{ $wp->position_name }}"></x-itxt>
                <x-itxt lbl="Singkatan Bagian" nm="kode" max="20" plc="Contoh: KEU,BAU, DTI, dsb." :req="true" val="{{ $wp->kode }}"></x-itxt>


                {{-- Tipe Bagian --}}
                <x-islc lbl="Tipe Bagian" nm="type_work_position" :req="true">
                    <option value="" disabled selected>-- Pilih Tipe Bagian --</option>
                    <option value="Bagian" @selected(old('type_work_position', $wp->type_work_position) == 'Bagian')>Bagian</option>
                    <option value="Direktorat" @selected(old('type_work_position', $wp->type_work_position) == 'Direktorat')>Direktorat</option>
                    {{-- <option value="Program Studi" @selected(old('type_work_position') == 'Program Studi')>Program Studi</option> --}}
                    <option value="Fakultas" @selected(old('type_work_position', $wp->type_work_position) == 'Fakultas')>Fakultas</option>
                </x-islc>

                {{-- Tipe Pekerja --}}
                <x-islc lbl="Tipe Pekerja yang Biasa Bekerja Disini" nm="type_pekerja" :req="true">
                    <option value="" disabled selected>-- Pilih Tipe Pekerja --</option>
                    <option value="Dosen" @selected(old('type_pekerja', $wp->type_pekerja) == 'Dosen')>Dosen</option>
                    <option value="Tpa" @selected(old('type_pekerja', $wp->type_pekerja) == 'Tpa')>TPA</option>
                    <option value="Both" @selected(old('type_pekerja', $wp->type_pekerja) == 'Keduanya')>Keduanya</option>
                </x-islc>
            </div>
        </div>
    </x-form>
@endsection
