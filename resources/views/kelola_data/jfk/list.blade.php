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

            <a href="{{ route('manage.jfk.new') }}" class="flex rounded-[5.874740123748779px]">
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

    <x-modal-new-sk-ypt keperluan="JFK" route_khusus='/manage/jfk/fill-sk-ypt'></x-modal-new-sk-ypt>
    <div class="flex flex-grow-0 flex-col gap-2 max-w-100">
        <x-tb id="formasiTable">
            <x-slot:table_header>
                <x-tb-td type="select" nama="level" sorting=true>Nama Staff</x-tb-td>
                <x-tb-td nama="nama_formasi" sorting=true>JFK</x-tb-td>
                <x-tb-td type="select" nama="tipe_bagian" sorting=true>TMT Mulai</x-tb-td>
                <x-tb-td type="select" nama="bagian" sorting=true>SK YPT</x-tb-td>
                <x-tb-td nama="action" sorting=true>Action</x-tb-td>
                {{-- <x-tb-td nama="email_pribadi"></x-tb-td> --}}
            </x-slot:table_header>

            <x-slot:table_column>
                @forelse ($jfks as $jfk)
                    @if ($jfk->tmt_selesai == null)
                        {{-- {{ dd($jfk) }} --}}
                        {{-- {{ dd($formation) }} --}}
                        <x-tb-cl id="">
                            <x-tb-cl-fill>
                                {{ $jfk->data_tpa->pegawai->nama_lengkap }}
                            </x-tb-cl-fill>
                            <x-tb-cl-fill>
                                {{-- {{ dd($jfk, $jfk->data_jfk) }} --}}
                                {{ $jfk->data_jfk->nama_jfk }}
                            </x-tb-cl-fill>
                            <x-tb-cl-fill>
                                {{ $jfk->tmt_mulai }}
                            </x-tb-cl-fill>
                            <x-tb-cl-fill>
                                {{-- {{ dd($jfk,$jfk->sk_ypt) }} --}}
                                @if ($jfk->sk_pengakuan_ypt_id == null)
                                    Belum ada SK
                                @else
                                    {{ $jfk->sk_ypt->no_sk }}
                                @endif
                            </x-tb-cl-fill>
                            <x-tb-cl-fill>
                                <div class="flex items-center justify-center gap-3">
                                    <div class="dropdown">
                                        <button class="btn btn-light btn-sm" data-bs-toggle="dropdown">
                                            ⋮
                                        </button>
                                        <ul class="dropdown-menu">
                                            <li>
                                                {{-- {{ dd($jfk->id) }} --}}
                                                <a href="{{ route('manage.jfk.update', ['id_jfk' => $jfk->id]) }}"
                                                    class="dropdown-item hover:bg-blue-500 hover:text-white" href="#">
                                                    Ubah Data
                                                </a>
                                            </li>
                                            <li>
                                                <a class="dropdown-item hover:bg-blue-500 hover:text-white" href="#">
                                                    Upgrade JFK
                                                </a>
                                            </li>
                                            @if ($jfk->sk_pengakuan_ypt_id == null)
                                                <li>
                                                    <button
                                                        class="dropdown-item hover:bg-blue-500 hover:text-white"
                                                        onclick="open_modal_ypt('{{ $jfk->data_tpa->pegawai->active_nip->first()->nip.'_('. $jfk->data_jfk->nama_jfk.')' }}','{{ $jfk->id }}')"
                                                        data-bs-toggle="modal" data-bs-target="#upload-sk-ypt">
                                                        Isi SK YPT
                                                </button>
                                                </li>
                                            @endif
                                        </ul>
                                    </div>
                                </div>
                            </x-tb-cl-fill>
                        </x-tb-cl>
                    @endif
                @empty
                    <p>No Data</p>
                @endforelse
            </x-slot:table_column>
        </x-tb>
    </div>
@endsection
