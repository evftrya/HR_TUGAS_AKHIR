@php
    $active_sidebar = 'Daftar Dosen COE';

    // Data Dummy Dosen COE
    $dosen_coes = collect([
        (object)[
            'id' => 1,
            'nama_dosen' => 'Dr. Aris Sudarman',
            'coe' => 'Artificial Intelligence',
            'research_group' => 'Computer Vision',
            'tmt_mulai' => '2023-01-10',
            'tmt_selesai' => null,
        ],
        (object)[
            'id' => 2,
            'nama_dosen' => 'Prof. Siti Rahayu',
            'coe' => 'Cyber Security',
            'research_group' => 'Cryptography',
            'tmt_mulai' => '2022-06-15',
            'tmt_selesai' => '2024-06-15',
        ],
        (object)[
            'id' => 3,
            'nama_dosen' => 'Budi Setiawan, M.T.',
            'coe' => 'Renewable Energy',
            'research_group' => 'Solar Cell Technology',
            'tmt_mulai' => '2024-02-01',
            'tmt_selesai' => null,
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
                <span class="font-medium text-2xl leading-[20.56159019470215px] text-[#101828]">Daftar Dosen COE</span>
            </div>
            <span class="font-normal text-[10.280795097351074px] leading-[14.686850547790527px] text-[#1f2028]">
                Menampilkan daftar dosen yang terdaftar dalam Center of Excellence (COE)
            </span>
        </div>
        <div class="flex items-center w-full justify-end gap-[11.749480247497559px]">
            <x-print-tb target_id="DosenCOETable"></x-print-tb>
            <x-export-csv-tb target_id="DosenCOETable"></x-export-csv-tb>

            <a href="#" class="flex rounded-[5.874740123748779px]">
                <div class="flex justify-center items-center gap-[5.874740123748779px] bg-[#0070ff] px-[11.749480247497559px] py-[7.343425273895264px] rounded-[5.874740123748779px] border border-[#0070ff] hover:bg-[#005fe0] transition">
                    <i class="bi bi-plus text-sm text-white"></i>
                    <span class="font-medium text-[10.28px] leading-[14.68px] text-white">Tambah Dosen</span>
                </div>
            </a>
        </div>
    </div>
@endsection

@section('content-base')
    <div class="flex flex-grow-0 flex-col gap-2 max-w-100 bg-white p-4 rounded-xl shadow-sm border border-slate-200 mt-2">
        <x-tb id="DosenCOETable" search_status=true>
            <x-slot:table_header>
                <x-tb-td nama="nama_dosen" sorting=true>Nama Dosen</x-tb-td>
                <x-tb-td nama="coe" type="select" sorting=true>COE</x-tb-td>
                <x-tb-td nama="research_group" type="select" sorting=true>Research Group</x-tb-td>
                <x-tb-td nama="tmt_mulai" sorting=true>TMT Mulai</x-tb-td>
                <x-tb-td nama="tmt_selesai" sorting=true>TMT Selesai</x-tb-td>
                <x-tb-td nama="action">Action</x-tb-td>
            </x-slot:table_header>

            <x-slot:table_column>
                @foreach ($dosen_coes as $item)
                    <x-tb-cl :cls="($item->tmt_selesai && $item->tmt_selesai < now()) ? 'opacity-45' : ''">
                        {{-- Nama Dosen --}}
                        <x-tb-cl-fill>
                            <span class="font-medium text-slate-800">{{ $item->nama_dosen }}</span>
                        </x-tb-cl-fill>

                        {{-- COE --}}
                        <x-tb-cl-fill>
                            {{ $item->coe }}
                        </x-tb-cl-fill>

                        {{-- Research Group --}}
                        <x-tb-cl-fill>
                            {{ $item->research_group }}
                        </x-tb-cl-fill>

                        {{-- TMT Mulai --}}
                        <x-tb-cl-fill>
                            {{ date('d/m/Y', strtotime($item->tmt_mulai)) }}
                        </x-tb-cl-fill>

                        {{-- TMT Selesai --}}
                        <x-tb-cl-fill>
                            @if ($item->tmt_selesai == null)
                                <span class="text-xs text-green-600 font-medium bg-green-50 px-2 py-0.5 rounded-full border border-green-100">
                                    Aktif
                                </span>
                            @else
                                {{ date('d/m/Y', strtotime($item->tmt_selesai)) }}
                            @endif
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

        {{-- Action Form Kosong --}}
        <form action="#" method="POST" class="hidden">
            @csrf
            <input type="hidden" name="id">
        </form>
    </div>
@endsection

@push('script-under-base')
    <script>
        // Placeholder untuk script JS jika diperlukan nanti
    </script>
@endpush
