@php
    $active_sidebar = 'Tambah Pangkat Baru';
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
                    Ubah Pangkat Golongan
                </span>
            </div>
        </div>
    </div>
@endsection
@section('content-base')
    {{-- Sesuaikan nama route-nya jika berbeda di file web.php kamu --}}
    <x-form route="{{ route('manage.pangkat-golongan.ref.update-data') }}" id="ref-pangkat-update">
        <div class="grid gap-8 ">
            <div class="flex flex-col gap-4">
                <x-itxt fill="hidden" lbl="xyx" nm='id' max="20" val="{{ $rpg->id }}"></x-itxt>
                <x-itxt lbl="Nama Pangkat" plc="Contoh: Pembina Utama" nm='pangkat' max="50" val="{{ $rpg->pangkat }}"></x-itxt>
                <x-itxt lbl="Golongan Pangkat" plc="Contoh: IV/e" nm='golongan' max="10" val="{{ $rpg->golongan }}"></x-itxt>
            </div>
        </div>
    </x-form>
@endsection
