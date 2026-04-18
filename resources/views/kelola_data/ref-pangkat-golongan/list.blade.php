@php
    $active_sidebar = 'Daftar Pangkat';
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
    <div class="flex flex-col md:flex-row items-center gap-[11.749480247497559px] self-stretch px-1 pt-[14.686850547790527px] pb-[13.952507972717285px]">
        <div class="flex w-full flex-col gap-[2.9373700618743896px] grow">
            <div class="flex items-center gap-[5.874740123748779px] self-stretch">
                <span class="font-medium text-2xl leading-[20.56159019470215px] text-[#101828]">
                    Daftar Pangkat Golongan
                </span>
            </div>
            <span class="font-normal text-[10.280795097351074px] leading-[14.686850547790527px] text-[#1f2028]">
                Anda dapat melihat semua pangkat dan golongan yang terdaftar di sistem disini
            </span>
        </div>
        
        <div class="flex items-center w-full justify-end gap-[11.749480247497559px]">
            <x-print-tb target_id="formasiTable"></x-print-tb>
            <x-export-csv-tb target_id="formasiTable"></x-export-csv-tb>

            <a href="{{ route('manage.pangkat-golongan.ref.new') }}" class="flex rounded-[5.874740123748779px]">
                <div class="flex justify-center items-center gap-[5.874740123748779px] bg-[#0070ff] px-[11.749480247497559px] py-[7.343425273895264px] rounded-[5.874740123748779px] border border-[#0070ff] hover:bg-[#005fe0] transition">
                    <i class="bi bi-plus text-sm text-white"></i>
                    <span class="font-medium text-[10.28px] leading-[14.68px] text-white">Tambah</span>
                </div>
            </a>
        </div>
    </div>
@endsection

@section('content-base')
    <div class="flex flex-grow-0 flex-col gap-2 max-w-100">
        <x-tb id="formasiTable">
            <x-slot:table_header>
                <x-tb-td nama="pangkat" sorting="true">Nama Pangkat</x-tb-td>
                <x-tb-td nama="golongan" sorting="true">Golongan</x-tb-td>
                <x-tb-td>Action</x-tb-td>
            </x-slot:table_header>

            <x-slot:table_column>
                {{-- Sesuaikan $pangkats dengan variabel yang dikirim dari Controller --}}
                @forelse ($data as $pangkat)
                    <x-tb-cl id="{{ $pangkat->id }}">
                        <x-tb-cl-fill>
                            {{ $pangkat->pangkat }}
                        </x-tb-cl-fill>
                        
                        <x-tb-cl-fill>
                            {{ $pangkat->golongan }}
                        </x-tb-cl-fill>
                        
                        <x-tb-cl-fill>
                            <div class="flex items-center justify-center gap-3">
                                <div class="dropdown">
                                    <button class="btn btn-light btn-sm" data-bs-toggle="dropdown">
                                        ⋮
                                    </button>
                                    <ul class="dropdown-menu">
                                        <li>
                                            <a href="{{ route('manage.pangkat-golongan.ref.edit', ['id_rpg' => $pangkat->id]) }}"
                                                class="dropdown-item hover:bg-blue-500 hover:text-white">
                                                Ubah Data
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </x-tb-cl-fill>
                    </x-tb-cl>
                @empty
                    <tr>
                        <td colspan="3" class="text-center py-4">No Data</td>
                    </tr>
                @endforelse
            </x-slot:table_column>
        </x-tb>
    </div>
@endsection