@php
    $active_sidebar = 'Daftar Formasi';
@endphp
@extends('kelola_data.base')
@section('header-base')
    {{-- <script src="https://cdn.tailwindcss.com"></script> --}}

    <!-- OrgChart.js -->
    <script src="https://balkan.app/js/OrgChart.js"></script>
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
            <div class="flex items-center gap-[5.874740123748779px] self-stretch"><span
                    class="font-medium text-2xl leading-[20.56159019470215px] text-[#101828]">Daftar Jabatan Fungsional
                    Akademik (JFA)</span>
            </div><span class="font-normal text-[10.280795097351074px] leading-[14.686850547790527px] text-[#1f2028]">Anda
                dapat melihat semua JFA yang terdaftar di sistem disini</span>
        </div>
        <div class="flex items-center w-full justify-end gap-[11.749480247497559px]">


            <x-print-tb target_id="formasiTable"></x-print-tb>
            <x-export-csv-tb target_id="formasiTable"></x-export-csv-tb>

            <a href="{{ route('manage.formasi.new') }}" class="flex rounded-[5.874740123748779px]">
                <div
                    class="flex justify-center items-center gap-[5.874740123748779px] bg-[#0070ff] px-[11.749480247497559px] py-[7.343425273895264px] rounded-[5.874740123748779px] border border-[#0070ff] hover:bg-[#005fe0] transition">
                    <i class="bi bi-plus text-sm text-white"></i>
                    <span class="font-medium text-[10.28px] leading-[14.68px] text-white">Tambah</span>
                </div>
            </a>
        </div>

    </div>
@endsection
@section('content-base')
    <x-modal-view :footer="false" :head="false" id="formasi-update" title="Formasi Details">
        <div class="flex flex-col gap-3 px-8 py-8">
            <!-- Header -->
            <div class="flex items-center gap-5">
                <span class="font-semibold text-xl text-[#101828]">Data Formasi</span>
                <button onclick="window.location=''" id="ubah-data-button"
                    class="flex items-center justify-center gap-1 bg-[#0070ff] text-white font-medium text-xs px-3 py-1 rounded border border-[#0070ff] hover:bg-[#005bd4] transition-all">
                    Ubah Data
                </button>
            </div>

            <!-- Data Grid -->
            <div class="flex gap-12 w-full">
                <div class="flex flex-col gap-2 w-1/2">
                    <span class="font-light text-sm text-black">Level</span>
                    <span class="font-light text-sm text-black">Nama Formasi</span>
                    <span class="font-light text-sm text-black">Bagian</span>
                    <span class="font-light text-sm text-black">Atasan</span>
                    <span class="font-light text-sm text-black">Kuota</span>
                </div>
                <div class="flex flex-col gap-2 w-1/2">
                    <span class="font-normal text-sm text-black" id="level">Directur</span>
                    <span class="font-normal text-sm text-black" id="nama_formasi">Directur</span>
                    <span class="font-normal text-sm text-black" id="bagian">Directur</span>
                    <span class="font-normal text-sm text-black" id="atasan">Directur</span>
                    <span class="font-normal text-sm text-black" id="kuota">1</span>
                </div>
            </div>
        </div>


    </x-modal-view>
    <div class="flex flex-grow-0 flex-col gap-2 max-w-100">


        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
        <x-tb id="formasiTable">
            
            <x-slot:table_header>
                <x-tb-td type="select" nama="level" sorting=true>Nama Dosen</x-tb-td>
                <x-tb-td nama="nama_formasi" sorting=true>JFA</x-tb-td>
                <x-tb-td type="select" nama="tipe_bagian" sorting=true>SK LLKDIKTI</x-tb-td>
                <x-tb-td type="select" nama="bagian" sorting=true>SK YPT</x-tb-td>
                <x-tb-td type="select" nama="atasan" sorting=true>TMT Mulai</x-tb-td>
                <x-tb-td nama="kuota" sorting=true>TMT Selesai</x-tb-td>
                <x-tb-td nama="action">Action</x-tb-td>
                {{-- <x-tb-td nama="email_pribadi"></x-tb-td> --}}
            </x-slot:table_header>

            <x-slot:table_column>
                @forelse ($jfas as $jfa)
                    {{-- {{ dd($formation) }} --}}
                    <x-tb-cl id="">
                        <x-tb-cl-fill>{{ $jfa->dosen->pegawai->nama_lengkap }}</x-tb-cl-fill>
                        <x-tb-cl-fill>{{ $jfa->jfa->nama_jabatan }}</x-tb-cl-fill>
                        <x-tb-cl-fill>{{ $jfa->sk_dikti->no_sk }}</x-tb-cl-fill>
                        <x-tb-cl-fill>{{ $jfa->sk_ypt->no_sk }}</x-tb-cl-fill>
                        <x-tb-cl-fill>{{ date('d/m/Y', strtotime($jfa->tmt_mulai)) }}</x-tb-cl-fill>
                        <x-tb-cl-fill>{{ $jfa->tmt_selesai == null ? 'Belum Berakhir' : date('d/m/Y', strtotime($jfa->tmt_selesai)) }}</x-tb-cl-fill>
                        <x-tb-cl-fill>
                            <div class="flex items-center justify-center gap-3">
                                <div class="dropdown shadow-xl">
                                    <button class="" data-bs-toggle="dropdown">
                                        <i class="bi bi-list"></i>
                                    </button>
                                    <ul class="dropdown-menu">
                                        <li>
                                            <a href="{{ route('manage.pengawakan.update', ['idPemetaan' => 'ghjkl']) }}"
                                                class="dropdown-item hover:bg-blue-500 hover:text-white" href="#">
                                                Ubah Data
                                            </a>
                                        </li>
                                        <li>
                                            <a href=""
                                                class="dropdown-item hover:bg-blue-500 hover:text-white" href="#">
                                                Upgrade JFA
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </x-tb-cl-fill>
                    </x-tb-cl>
                @empty
                    <p>No Data</p>
                @endforelse
            </x-slot:table_column>
        </x-tb>





    </div>
@endsection
