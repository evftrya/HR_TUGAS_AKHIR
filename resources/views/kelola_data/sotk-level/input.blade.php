@php
    $active_sidebar = 'Tambah Level Baru';
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
                    Tambah Level Baru
                </span>
            </div>
        </div>
    </div>
@endsection
@section('content-base')
    <x-modal-view :footer="false" :head="false" id="level-update" title="Level Details">
        <div class="flex flex-col gap-3 px-8 py-8">
            <!-- Header -->
            <div class="flex items-center gap-5">
                <span class="font-semibold text-xl text-[#101828]">Data Level</span>
                <button onclick="window.location=''" id="ubah-data-button"
                    class="flex items-center justify-center gap-1 bg-[#0070ff] text-white font-medium text-xs px-3 py-1 rounded border border-[#0070ff] hover:bg-[#005bd4] transition-all">
                    Ubah Data
                </button>
            </div>

            <!-- Data Grid -->
            <div class="flex gap-12 w-full">
                <div class="flex flex-col gap-2 w-1/2">
                    <span class="font-light text-sm text-black">Nama Level</span>
                    <span class="font-light text-sm text-black">Singkatan</span>
                    <span class="font-light text-sm text-black">Atasan</span>
                </div>
                <div class="flex flex-col gap-2 w-1/2">
                    <span class="font-normal text-sm text-black" id="nama-level">Directur</span>
                    <span class="font-normal text-sm text-black" id="singkatan">DIR</span>
                    <span class="font-normal text-sm text-black" id="atasan">1</span>
                </div>
            </div>
        </div>


    </x-modal-view>
    <x-form route="{{ route('manage.level.create') }}" id="level-input">
        <div class="grid gap-8 ">
            <!-- Kolom Kiri -->
            <div class="flex flex-col gap-4">
                <x-itxt lbl="Nama Level" plc="Direktur" nm='nama_level' max="30"></x-itxt>
                <x-itxt lbl="Singkatan Level" plc="DIR" nm='singkatan_level' max="12"></x-itxt>
                <x-islc lbl="Atasan Level" nm='atasan_level'>
                    @forelse($levels as $level)
                        <option value="{{ $level->id }}">{{ $level->nama_level }}</option>
                    @empty
                        <option value="-" disabled>-- No Data --</option>
                    @endforelse
                </x-islc>
            </div>
        </div>
    </x-form>
@endsection
