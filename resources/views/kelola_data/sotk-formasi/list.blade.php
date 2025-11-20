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
                    class="font-medium text-2xl leading-[20.56159019470215px] text-[#101828]">Daftar Formasi</span>
            </div><span class="font-normal text-[10.280795097351074px] leading-[14.686850547790527px] text-[#1f2028]">Anda
                dapat melihat semua formasi yang terdaftar di sistem disini</span>
        </div>
        <div class="flex items-center w-full justify-end gap-[11.749480247497559px]">


            <x-print-tb target_id="formasiTable"></x-print-tb>
            <x-export-csv-tb target_id="formasiTable"></x-export-csv-tb>

            <button class="flex rounded-[5.874740123748779px]">
                <div
                    class="flex justify-center items-center gap-[5.874740123748779px] bg-[#0070ff] px-[11.749480247497559px] py-[7.343425273895264px] rounded-[5.874740123748779px] border border-[#0070ff] hover:bg-[#005fe0] transition">
                    <i class="bi bi-plus text-sm text-white"></i>
                    <span class="font-medium text-[10.28px] leading-[14.68px] text-white">Tambah</span>
                </div>
            </button>
        </div>

    </div>
@endsection
@section('content-base')
    <div class="flex flex-grow-0 flex-col gap-2 max-w-100">


        <x-tb id="formasiTable">
            <x-slot:table_header>
                <x-tb-td type="select" nama="level" sorting=true>Level</x-tb-td>
                <x-tb-td nama="nama_formasi" sorting=true>Nama Formasi</x-tb-td>
                <x-tb-td type="select" nama="tipe_bagian" sorting=true>Tipe Bagian</x-tb-td>
                <x-tb-td type="select" nama="bagian" sorting=true>Bagian</x-tb-td>
                <x-tb-td type="select" nama="atasan" sorting=true>Atasan</x-tb-td>
                <x-tb-td nama="kuota" sorting=true>Kuota</x-tb-td>
                <x-tb-td nama="email_pribadi" >Action</x-tb-td>
            </x-slot:table_header>

            <x-slot:table_column>
                @forelse ($formations as $formation)
                {{-- {{ dd($formation) }} --}}
                    <x-tb-cl id="{{ $formation->id }}">
                        <x-tb-cl-fill>{{ $formation->level_id->singkatan_level }}</x-tb-cl-fill>
                        <x-tb-cl-fill><p class="text-wrap">{{ $formation->nama_formasi }}</p></x-tb-cl-fill>
                        <x-tb-cl-fill>
                            {{ $formation->bagian->type_work_position }}
                        </x-tb-cl-fill>
                        <x-tb-cl-fill>

                            {{ $formation->bagian->singkatan }}
                        </x-tb-cl-fill>
                        <x-tb-cl-fill>
                            <p class="text-wrap">{{ $formation->atasan_formation ? $formation->atasan_formation->nama_formasi : '-' }}</p>
                        </x-tb-cl-fill>
                        <x-tb-cl-fill>{{ $formation->kuota }}</x-tb-cl-fill>
                        <x-tb-cl-fill>
                            <div class="flex items-center justify-center gap-3">
                                <button
                                    class="px-3 py-1.5 border border-[#0070ff] text-[#0070ff] rounded-md text-xs font-medium hover:bg-[#0070ff] hover:text-white transition">
                                    View Details
                                </button>
                                <div class="dropdown">
                                    <button class="btn btn-light btn-sm" data-bs-toggle="dropdown">
                                        ⋮
                                    </button>
                                    <ul class="dropdown-menu">
                                        <li>
                                            <a href="{{ route('manage.formasi.update',['idFormasi'=>$formation->id]) }}" class="dropdown-item hover:bg-blue-500 hover:text-white" href="#">
                                                Ubah Data
                                            </a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item hover:bg-blue-500 hover:text-white" href="#">
                                                Karyawan Aktif
                                            </a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item hover:bg-blue-500 hover:text-white" href="#">
                                                History Karyawan
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







    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const popoverTriggerList = document.querySelectorAll('[data-bs-toggle="popover"]');
            [...popoverTriggerList].map(el => new bootstrap.Popover(el));
        });
    </script>
@endsection
