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
    <x-form route="{{ route('manage.jfa.ref.new') }}" id="form-jfa">
        <div class="grid gap-8">
            <div class="flex flex-col gap-4">

                <div class="flex flex-col gap-1">
                    <x-itxt lbl="Singkatan Jabatan" nm="singkatan_jabatan" plc="Contoh: AA" max="20" 
                        value="{{ old('singkatan_jabatan') }}" :req="true" />
                    @error('singkatan_jabatan') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>

                <div class="flex flex-col gap-1">
                    <x-itxt lbl="Nama Jabatan" nm="nama_jabatan" plc="Contoh: Asisten Ahli" max="150" 
                        value="{{ old('nama_jabatan') }}" :req="true" />
                    @error('nama_jabatan') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>

                <div class="flex flex-col gap-1">
                    <x-itxt lbl="Minimal Kum" type="number" nm="minimal_kum" plc="Masukkan Angka Minimal Kum" 
                        value="{{ old('minimal_kum') }}" :req="true" />
                    @error('minimal_kum') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>

            </div>
        </div>
    </x-form>
@endsection