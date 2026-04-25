@php
    $active_sidebar = 'Daftar Grub Research COE';
@endphp

@extends('kelola_data.base')

@section('header-base')
    <style>
        .max-w-100 {
            max-width: 100% !important;
        }
    </style>
@endsection

@section('page-name')
    <div
        class="flex flex-col md:flex-row items-center gap-[11.749480247497559px] self-stretch px-1 pt-[14.686850547790527px] pb-[13.952507972717285px]">
        <div class="flex w-full flex-col gap-[2.9373700618743896px] grow">
            <div class="flex items-center gap-[5.874740123748779px] self-stretch">
                <span class="font-medium text-2xl leading-[20.56159019470215px] text-[#101828]">Daftar Grub Research
                    COE</span>
            </div>
            <span class="font-normal text-[10.280795097351074px] leading-[14.686850547790527px] text-[#1f2028]">
                Menampilkan data grub research CoE
            </span>
        </div>
        <div class="flex items-center w-full justify-end gap-[11.749480247497559px]">
            <x-print-tb target_id="PemetaanTable"></x-print-tb>
            <x-export-csv-tb target_id="PemetaanTable"></x-export-csv-tb>

            <a href="{{ route('manage.coe.ref-reserach.new') }}" class="flex rounded-[5.874740123748779px]">
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
    <div
        class="flex flex-grow-0 flex-1 max-h-fit flex-col gap-2 max-w-100 bg-white p-4 rounded-xl shadow-sm border border-slate-200 mt-2">
        <x-tb id="PemetaanTable" search_status=true>
            <x-slot:table_header>
                <x-tb-td nama="nama" sorting=true>Nama</x-tb-td>
                <x-tb-td nama="kode" sorting=true>Kode</x-tb-td>
                <x-tb-td nama="coe" sorting=true>COE Terdaftar</x-tb-td>
                <x-tb-td nama="dosen" sorting=true>Dosen Aktif</x-tb-td>
                <x-tb-td nama="action">Action</x-tb-td>
            </x-slot:table_header>

            <x-slot:table_column>
                @foreach ($data as $item)
                    <x-tb-cl>
                        {{-- Data Nama --}}
                        <x-tb-cl-fill>
                            {!! htmlspecialchars($item->nama) !!}
                        </x-tb-cl-fill>

                        {{-- Data Kode --}}
                        <x-tb-cl-fill>
                            {{ htmlspecialchars($item->kode) }}
                        </x-tb-cl-fill>

                        <x-tb-cl-fill>
                            <div class="flex justify-center text-sm">

                                {{ $item->coe_count }}
                            </div>
                        </x-tb-cl-fill>

                        <x-tb-cl-fill>
                            <div class="flex justify-center text-sm">
                                {{ $item->dosen_aktif_count }}
                            </div>
                        </x-tb-cl-fill>

                        {{-- Action --}}
                        <x-tb-cl-fill>
                            <div class="flex items-center justify-center gap-3">
                                <div class="dropdown">
                                    <button class="btn btn-light btn-sm rounded-lg border border-slate-200 px-2"
                                        data-bs-toggle="dropdown">
                                        <i class="bi bi-list"></i>
                                    </button>
                                    <ul class="dropdown-menu shadow-lg border-0 rounded-xl overflow-hidden">
                                        <li>
                                            <a href="{{ route('manage.coe.index', ['research_coe' => $item->nama])}}"
                                                class="dropdown-item py-2 hover:bg-blue-500 hover:text-white" target="_blank" rel="noopener noreferrer">

                                                Lihat COE Terdaftar
                                            </a>
                                        </li>
                                        <li>
                                            <a href="{{ route('manage.coe.dosen.list',['research_group'=>$item->nama]) }}" class="dropdown-item py-2 hover:bg-blue-500 hover:text-white" target="_blank" rel="noopener noreferrer">
                                                Lihat Dosen COE Terdaftar
                                            </a>
                                        </li>
                                        <hr class="dropdown-divider">
                                        <li>
                                            <a href="{{ route('manage.coe.ref-reserach.edit', ['id_ref' => $item->id]) }}"
                                                class="dropdown-item py-2 hover:bg-blue-500 hover:text-white">
                                                Ubah Data
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
@endsection

@push('script-under-base')
    <script>
        // Script kosong untuk testing UI
    </script>
@endpush
