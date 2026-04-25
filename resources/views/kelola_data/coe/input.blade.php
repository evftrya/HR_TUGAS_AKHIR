@php
    $active_sidebar = 'Tambah CoE';
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
                    Tambah Center of Excellence (CoE) Baru
                </span>
            </div>
        </div>
    </div>
@endsection

@section('content-base')
    <x-form route="" id="form-coe-input">
        <div class="grid gap-8">
            <div class="flex flex-col gap-4">

                {{-- Nama CoE --}}
                <x-itxt
                    lbl="Nama CoE"
                    nm="nama_coe"
                    plc="Masukkan nama center of excellence..."
                    max="200">
                </x-itxt>

                {{-- Kode CoE --}}
                <x-itxt
                    lbl="Kode CoE"
                    nm="kode_coe"
                    plc="Masukkan kode CoE..."
                    max="50">
                </x-itxt>

                {{-- Ref Research ID --}}
                <x-islc lbl="Referensi Research" nm="ref_research_id">
                    <option value="" disabled selected>-- Pilih Data --</option>
                    {{-- Loop data research di sini nanti --}}
                </x-islc>

                {{-- Is Active --}}
                <x-islc lbl="Status Aktif" nm="is_active">
                    <option value="" disabled selected>-- Pilih Status --</option>
                    <option value="1">Aktif</option>
                    <option value="0">Tidak Aktif</option>
                </x-islc>

            </div>
        </div>
    </x-form>
@endsection
