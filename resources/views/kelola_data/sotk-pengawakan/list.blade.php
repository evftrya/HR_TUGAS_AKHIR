@php
    $active_sidebar = 'Daftar Pemetaan';
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
                    class="font-medium text-2xl leading-[20.56159019470215px] text-[#101828]">Daftar Pemetaan</span>
            </div><span class="font-normal text-[10.280795097351074px] leading-[14.686850547790527px] text-[#1f2028]">Anda
                dapat melihat semua formasi yang terdaftar di sistem disini</span>
        </div>
        <div class="flex items-center w-full justify-end gap-[11.749480247497559px]">


            <x-print-tb target_id="PemetaanTable"></x-print-tb>
            <x-export-csv-tb target_id="PemetaanTable"></x-export-csv-tb>

            <a href="{{ route('manage.pengawakan.new') }}" class="flex rounded-[5.874740123748779px]">
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
    <div class="flex flex-grow-0 flex-col gap-2 max-w-100">
        <x-tb id="PemetaanTable">
            <x-slot:table_header>
                <x-tb-td nama="nama" sorting=true>Nama Pegawai</x-tb-td>
                <x-tb-td type="select" nama="gender" sorting=true>Formasi</x-tb-td>
                <x-tb-td nama="tmt_mulai" sorting=true>TMT Mulai</x-tb-td>
                {{-- <x-tb-td nama="tmt_selesai" sorting=true>TMT Selesai</x-tb-td> --}}
                <x-tb-td nama="sk" sorting=true>NO. SK</x-tb-td>
                {{-- <x-tb-td type="select" nama="aktif" sorting=true>Nonaktifkan</x-tb-td> --}}
                <x-tb-td nama="email_pribadi" sorting=true>Action</x-tb-td>
            </x-slot:table_header>

            <x-slot:table_column>
                @foreach ($pemetaans as $pemetaan)
                    <x-tb-cl :cls="$pemetaan->tmt_selesai !== null ? 'opacity-45' : ''">

                        <x-tb-cl @if ($pemetaan->tmt_selesai !== null) cls="opacity-45" @endif>
                            <x-tb-cl-fill><a href="">{{ htmlspecialchars($pemetaan->users->nama_lengkap) }}</a></x-tb-cl-fill>
                            <x-tb-cl-fill>{{ htmlspecialchars($pemetaan->formasi->nama_formasi) }}</x-tb-cl-fill>
                            <x-tb-cl-fill>{{ date('d/m/Y', strtotime($pemetaan->tmt_mulai)) }}</x-tb-cl-fill>
                            {{-- <x-tb-cl-fill :cls="$pemetaan->tmt_selesai === null ? 'text-white' : ''">{{ $pemetaan->tmt_selesai }}</x-tb-cl-fill> --}}
                            <x-tb-cl-fill><a
                                    href="" class="text-wrap">{{ htmlspecialchars($pemetaan->sk_ypt->no_sk) }}</a></x-tb-cl-fill>
                            <x-tb-cl-fill>
                                <div class="flex items-center justify-center gap-3">
                                    <button
                                        class="px-3 py-1.5 border border-[#0070ff] text-[#0070ff] rounded-md text-xs font-medium hover:bg-[#0070ff] hover:text-white transition">
                                        View
                                    </button>
                                    <div class="dropdown shadow-xl">
                                        <button class="btn btn-light btn-sm" data-bs-toggle="dropdown">
                                            ⋮
                                        </button>
                                        <ul class="dropdown-menu">
                                            <li>
                                                <a href="{{ route('manage.pengawakan.update',['idPemetaan' => $pemetaan->id]) }}" class="dropdown-item hover:bg-blue-500 hover:text-white"
                                                    href="#">
                                                    Ubah Data
                                                </a>
                                            </li>
                                            <li>
                                                <a class="dropdown-item hover:bg-blue-500 hover:text-white" href="#">
                                                    Selesaikan Masa Jabatan
                                                </a>
                                            </li>
                                            <li>
                                                <a href="{{ route('profile.history.pemetaan', ['id_user' => $pemetaan->users_id]) }}" class="dropdown-item hover:bg-blue-500 hover:text-white" href="#">
                                                    History Pemetaan Karyawan
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </x-tb-cl-fill>
                        </x-tb-cl>
                @endforeach
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
