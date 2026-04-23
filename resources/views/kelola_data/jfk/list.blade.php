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
                    Keahlian (JFK)</span>
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
                <x-tb-td type="select" nama="tmt_start" sorting=true>TMT Mulai</x-tb-td>
                <x-tb-td type="select" nama="tmt_end" sorting=true>TMT Selesai</x-tb-td>
                <x-tb-td type="select" nama="bagian" sorting=true>SK YPT atau Amandemen</x-tb-td>
                <x-tb-td nama="action" sorting=true>Action</x-tb-td>
                {{-- <x-tb-td nama="email_pribadi"></x-tb-td> --}}
            </x-slot:table_header>

            <x-slot:table_column>
                @forelse ($jfks as $jfk)
                    @if ($jfk->tmt_selesai == null)
                        <x-tb-cl id="">
                            <x-tb-cl-fill>
                                {{ $jfk->data_tpa->pegawai->nama_lengkap }}
                            </x-tb-cl-fill>
                            <x-tb-cl-fill>
                                <div class="flex justify-center">
                                    {{ $jfk->data_jfk->nama_jfk }}
                                </div>
                                {{-- {{ dd($jfk, $jfk->data_jfk) }} --}}
                            </x-tb-cl-fill>
                            <x-tb-cl-fill>
                                <div class="flex justify-center">
                                    {{ $jfk->tmt_mulai }}
                                </div>
                            </x-tb-cl-fill>
                            <x-tb-cl-fill >
                                <div class="flex justify-center">

                                    @if($jfk->tmt_selesai==null)
                                    <p class="text-gray-500 text-sm">
                                        Belum diset
                                    </p>
                                    @else
                                    {{ $jfk->tmt_selesai }}
                                    @endif
                                </div>
                            </x-tb-cl-fill>
                            <x-tb-cl-fill>
                                <div class="flex justify-center">
<<<<<<< HEAD
                                    {{-- {{ dd($jfk,$jfk->sk_ypt) }} --}}
                                    @if ($jfk->sk_pengakuan_ypt_id == null)
                                        <div class="flex flex-col text-sm">
                                            Belum ada SK <a href="{{ route('manage.jfk.new', ['tpa_id' => $jfk->id]) }}"
                                                class="text-blue-600">petakan sekarang</a>
                                        </div>
                                    @else
                                        {{-- {{ DD($jfk) }} --}}
                                        <a href="{{ route('manage.sk.view', ['id_sk_or_sk_number' => $jfk->sk_ypt->id]) }}"
                                            class="group inline-flex items-center gap-2 px-3 py-1.5 bg-slate-50 border border-slate-200 text-slate-700 rounded-lg transition-all duration-200 hover:bg-blue-50 hover:border-blue-300 hover:text-blue-600 hover:shadow-sm">

                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                class="w-4 h-4 text-slate-400 group-hover:text-blue-500" fill="none"
                                                viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                            </svg>

                                            <span class="text-sm font-medium tracking-wide">
                                                {{ $jfk->sk_ypt->no_sk }}
                                            </span>

                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                class="w-3 h-3 opacity-0 -translate-x-2 transition-all duration-200 group-hover:opacity-100 group-hover:translate-x-0"
                                                fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M14 5l7 7m0 0l-7 7m7-7H3" />
                                            </svg>
=======
                                    @if($jfk->tmt_selesai == null)
                                        <p class="text-md text-gray-600 flex flex-col"><span class="opacity-45">Belum ada</span> <a href="" class="opacity-70 text-blue-700">set sekarang</a></p>
                                    @else
                                    {{ $jfk->tmt_selesai }}
                                    @endif
                                </div>
                            </x-tb-cl-fill>
                            <x-tb-cl-fill>
                                <div class="flex justify-center">
                                    @if ($jfk->sk_pengakuan_ypt_id == null)
                                        <p class="text-md text-gray-700 flex flex-col"> <span class="opacity-45">Belum ada SK </span><a href="" class="text-blue-700 opacity-70">set sekarang</a></p>
                                    @else
                                        <a href="{{ route('manage.sk.view', ['id_sk_or_sk_number' => $jfk->sk_ypt->id]) }}"
                                            target="_blank" class="text-primary"
                                            style="cursor: pointer;">
                                            <i class="fas fa-external-link-alt mr-1"></i> {{ $jfk->sk_ypt->no_sk }}
>>>>>>> 32d3235c15150efd01081dea67e2995fe133a3d4
                                        </a>
                                    @endif
                                </div>
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
                                                    <button class="dropdown-item hover:bg-blue-500 hover:text-white"
                                                        onclick="open_modal_ypt('{{ $jfk->data_tpa->pegawai->active_nip->first()->nip . '_(' . $jfk->data_jfk->nama_jfk . ')' }}','{{ $jfk->id }}')"
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
