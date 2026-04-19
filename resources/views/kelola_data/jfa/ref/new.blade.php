@php
    $active_sidebar = 'Tambah JFA';
@endphp
@extends('kelola_data.base')

@section('page-name')
    <div class="flex flex-col md:flex-row items-center gap-[11.75px] self-stretch px-1 pt-[14.69px] pb-[13.95px]">
        <div class="flex w-full flex-col gap-[2.94px] grow">
            <div class="flex items-center gap-[5.87px] self-stretch">
                <span class="font-medium text-2xl leading-[20.56px] text-[#101828]">
                    Tambah Jabatan Fungsional Akademik
                </span>
            </div>
        </div>
    </div>
@endsection

@section('content-base')
    <x-form route="{{ route('manage.jfa.ref.store') }}" id="form-jfa">
        <div class="grid gap-8">
            <div class="flex flex-col gap-4">

                <div class="flex flex-col gap-1">
                    <x-itxt lbl="Singkatan Jabatan" nm="kode" plc="Contoh: AA" max="20" 
                       :req="true" />
                </div>

                <div class="flex flex-col gap-1">
                    <x-itxt lbl="Nama Jabatan" nm="nama_jabatan" plc="Contoh: Asisten Ahli" max="150" 
                         :req="true" />
                </div>

                <div class="flex flex-col gap-1">
                    <x-itxt lbl="Minimal Kum" type="number" nm="kum" plc="Masukkan Angka Minimal Kum" 
                         :req="true" />
                </div>

            </div>
        </div>
    </x-form>
@endsection