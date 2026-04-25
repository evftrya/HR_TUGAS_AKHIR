@php
    $active_sidebar = 'Tambah Pemetaan CoE';
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
                    Tambah Pemetaan Dosen CoE
                </span>
            </div>
        </div>
    </div>
@endsection

@section('content-base')
    <x-form route="" id="form-pemetaan-coe">
        <div class="grid gap-8">
            <div class="flex flex-col gap-4">

                {{-- Dosen --}}
                <x-islc lbl="Dosen" nm="users_id">
                    <option value="" disabled selected>-- Pilih Dosen --</option>
                    <option value="1">Dummy Dosen 1</option>
                    <option value="2">Dummy Dosen 2</option>
                </x-islc>

                {{-- CoE --}}
                <x-islc lbl="Center of Excellence (CoE)" nm="coe_id">
                    <option value="" disabled selected>-- Pilih CoE --</option>
                    <option value="1">Dummy CoE 1</option>
                    <option value="2">Dummy CoE 2</option>
                </x-islc>

                {{-- TMT Mulai --}}
                <x-itxt
                    lbl="TMT Mulai"
                    type="date"
                    nm="tmt_mulai">
                </x-itxt>

                {{-- TMT Selesai --}}
                <x-itxt
                    lbl="TMT Selesai (Opsional)"
                    type="date"
                    nm="tmt_selesai"
                    :req="false">
                </x-itxt>

            </div>
        </div>
    </x-form>
@endsection
