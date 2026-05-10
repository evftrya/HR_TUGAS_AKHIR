@php
    $active_sidebar = 'Kelompok Keahlian';
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
                <span class="font-medium text-2xl leading-[20.56159019470215px] text-[#101828]">Tambah Kelompok Keahlian</span>
            </div>
        </div>
    </div>
@endsection

@section('content-base')
    <x-form route="{{ route('manage.kelompok-keahlian.store') }}" cancelRoute="{{ route('manage.kelompok-keahlian.list') }}" id="kelompok-keahlian-input">
        <div class="flex flex-col gap-8 w-full max-w-100 mx-auto rounded-md border p-3">
            <h2 class="text-lg font-semibold text-black text-center">Data Kelompok Keahlian</h2>

            <div class="grid md:grid-cols-2 gap-8">
                <div class="flex flex-col gap-4">
                    <x-itxt lbl="Nama Kelompok Keahlian" plc="Contoh: Jaringan Komputer" nm="nama_kk" required></x-itxt>
                </div>

                <div class="flex flex-col gap-4">
                    <x-itxt lbl="Sub Kelompok (Opsional)" plc="Contoh: Network Security" nm="sub_kk"></x-itxt>
                </div>
            </div>
        </div>
    </x-form>
@endsection
