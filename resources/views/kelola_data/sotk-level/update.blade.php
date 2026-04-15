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
                    Update Data Level
                </span>
            </div>
        </div>
    </div>
@endsection
@section('content-base')
    <x-form route="{{ route('manage.level.update-data',['idLevel'=>$idLevel]) }}" id="level-input">
        <div class="grid gap-8 ">
            <!-- Kolom Kiri -->
            <div class="flex flex-col gap-4">
                <x-itxt lbl="Nama Level" plc="Direktur" nm='nama_level' val="{{ $level_target->nama_level }}"
                    max="30"></x-itxt>
                <x-itxt lbl="Singkatan Level" plc="DIR" nm='singkatan_level' max="12"
                    val="{{ $level_target->singkatan_level }}"></x-itxt>
                <x-itxt type="number" lbl="Urutan Level" nm="urut" val="{{ $level_target->urut }}"></x-itxt>
                <x-islc lbl="Atasan Level" nm='atasan_level'>
                    @forelse($levels as $level)
                        <option value="{{ $level->id }}" {{ old('atasan_level', optional($level_target)->atasan_level) == $level->id ? 'selected' : '' }}>{{ $level->nama_level }}</option>
                    @empty
                        <option value="-" disabled>-- No Data --</option>
                    @endforelse
                </x-islc>
            </div>
        </div>
    </x-form>
@endsection
