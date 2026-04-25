@php
    $active_sidebar = 'Daftar COE';

    // Data Dummy COE
    $coes = collect([
        (object)[
            'id' => 1,
            'nama_coe' => 'Artificial Intelligence & Data Science',
            'kode_coe' => 'COE-AI-01',
            'research_coe' => 'Machine Learning',
            'jumlah_dosen' => 12,
        ],
        (object)[
            'id' => 2,
            'nama_coe' => 'Cyber Security & Forensic',
            'kode_coe' => 'COE-CS-02',
            'research_coe' => 'Network Security',
            'jumlah_dosen' => 8,
        ],
        (object)[
            'id' => 3,
            'nama_coe' => 'Renewable Energy Systems',
            'kode_coe' => 'COE-RE-03',
            'research_coe' => 'Solar Technology',
            'jumlah_dosen' => 5,
        ],(object)[
            'id' => 3,
            'nama_coe' => 'Renewable Energy Systems',
            'kode_coe' => 'COE-RE-03',
            'research_coe' => 'Solar Technology',
            'jumlah_dosen' => 3,
        ],
    ]);
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
    <div class="flex flex-col md:flex-row items-center gap-[11.749480247497559px] self-stretch px-1 pt-[14.686850547790527px] pb-[13.952507972717285px]">
        <div class="flex w-full flex-col gap-[2.9373700618743896px] grow">
            <div class="flex items-center gap-[5.874740123748779px] self-stretch">
                <span class="font-medium text-2xl leading-[20.56159019470215px] text-[#101828]">Daftar COE</span>
            </div>
            <span class="font-normal text-[10.280795097351074px] leading-[14.686850547790527px] text-[#1f2028]">
                Manajemen data Center of Excellence (COE) dan dosen yang tergabung
            </span>
        </div>
        <div class="flex items-center w-full justify-end gap-[11.749480247497559px]">
            <x-print-tb target_id="COETable"></x-print-tb>
            <x-export-csv-tb target_id="COETable"></x-export-csv-tb>

            <a href="#" class="flex rounded-[5.874740123748779px]">
                <div class="flex justify-center items-center gap-[5.874740123748779px] bg-[#0070ff] px-[11.749480247497559px] py-[7.343425273895264px] rounded-[5.874740123748779px] border border-[#0070ff] hover:bg-[#005fe0] transition">
                    <i class="bi bi-plus text-sm text-white"></i>
                    <span class="font-medium text-[10.28px] leading-[14.68px] text-white">Tambah COE</span>
                </div>
            </a>
        </div>
    </div>
@endsection

@section('content-base')
    <div class="flex flex-grow-0 flex-col gap-2 max-w-100 bg-white p-4 rounded-xl shadow-sm border border-slate-200 mt-2">
        <x-tb id="COETable" search_status=true>
            <x-slot:table_header>
                <x-tb-td nama="nama_coe" sorting=true>Nama COE</x-tb-td>
                <x-tb-td nama="kode_coe" sorting=true>Kode COE</x-tb-td>
                <x-tb-td nama="research_coe" type="select" sorting=true>Research COE</x-tb-td>
                <x-tb-td nama="dosen_terdaftar" sorting=true>Dosen Terdaftar</x-tb-td>
                <x-tb-td nama="action">Action</x-tb-td>
            </x-slot:table_header>

            <x-slot:table_column>
                @foreach ($coes as $coe)
                    <x-tb-cl>
                        {{-- Nama COE --}}
                        <x-tb-cl-fill>
                            <span class="font-medium text-slate-800">{{ htmlspecialchars($coe->nama_coe) }}</span>
                        </x-tb-cl-fill>

                        {{-- Kode COE --}}
                        <x-tb-cl-fill>
                            <span class="px-2 py-1 bg-slate-100 text-slate-600 rounded font-mono text-xs">
                                {{ htmlspecialchars($coe->kode_coe) }}
                            </span>
                        </x-tb-cl-fill>

                        {{-- Research COE --}}
                        <x-tb-cl-fill>
                            {{ htmlspecialchars($coe->research_coe) }}
                        </x-tb-cl-fill>

                        {{-- Dosen Terdaftar (Icon Setelah Angka) --}}
                        <x-tb-cl-fill>
                            <div class="flex items-center gap-1.5">
                                {{-- <span class="font-semibold text-slate-700">
                                </span> --}}
                                    {{ (int) $coe->jumlah_dosen }}
                                <i class="bi bi-people-fill text-slate-400"></i>
                            </div>
                        </x-tb-cl-fill>

                        {{-- Action --}}
                        <x-tb-cl-fill>
                            <div class="flex items-center justify-center gap-3">
                                <div class="dropdown">
                                    <button class="btn btn-light btn-sm rounded-lg border border-slate-200 px-2" data-bs-toggle="dropdown">
                                        <i class="bi bi-list"></i>
                                    </button>
                                    <ul class="dropdown-menu shadow-lg border-0 rounded-xl overflow-hidden">
                                        <li>
                                            <a href="#" class="dropdown-item py-2 hover:bg-blue-500 hover:text-white">
                                                Lihat Dosen Terdaftar
                                            </a>
                                        </li>
                                        <hr class="dropdown-divider">
                                        <li>
                                            <a href="#" class="dropdown-item py-2 hover:bg-blue-500 hover:text-white">
                                                Ubah Data
                                            </a>
                                        </li>
                                        <li>
                                            <button type="button" class="dropdown-item py-2 text-red-600 hover:bg-red-500 hover:text-white">
                                                Hapus
                                            </button>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </x-tb-cl-fill>
                    </x-tb-cl>
                @endforeach
            </x-slot:table_column>
        </x-tb>

        {{-- Action Form Kosong --}}
        <form action="#" method="POST" class="hidden">
            @csrf
            <input type="hidden" name="id">
        </form>
    </div>
@endsection

@push('script-under-base')
    <script>
        // Placeholder script
    </script>
@endpush
