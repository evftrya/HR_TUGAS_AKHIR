@php
    $active_sidebar = 'Kelompok Keahlian';
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
                <span class="font-medium text-2xl leading-[20.56159019470215px] text-[#101828]">Daftar Pegawai dengan Kelompok Keahlian</span>
            </div>
            <span class="font-normal text-[10.280795097351074px] leading-[14.686850547790527px] text-[#1f2028]">
                Lihat daftar pegawai (dosen) dan kelompok keahlian yang terdaftar
            </span>
        </div>
    </div>
@endsection

@section('content-base')
    <div class="flex flex-grow-0 flex-col gap-2 max-w-100">
        <div class="flex flex-col gap-4 rounded-md border p-6 bg-white">
            <h2 class="text-lg font-semibold text-black border-b pb-3">Daftar Pegawai (Dosen) dan Kelompok Keahlian</h2>

            <x-tb id="dosenKKTable">
                <x-slot:table_header>
                    {{-- <x-tb-td nama="no" sorting=true>No</x-tb-td> --}}
                    <x-tb-td nama="nama_pegawai" sorting=true>Nama Pegawai</x-tb-td>
                    <x-tb-td nama="nidn" sorting=true>NIDN</x-tb-td>
                    <x-tb-td nama="email" sorting=true>Email</x-tb-td>
                    <x-tb-td nama="kelompok_keahlian" sorting=false>Kelompok Keahlian</x-tb-td>
                </x-slot:table_header>
                <x-slot:table_column>
                    @forelse($dosen as $index => $d)
                        <x-tb-cl id="{{ $d->id }}">
                            {{-- <x-tb-cl-fill>{{ $index + 1 }}</x-tb-cl-fill> --}}
                            <x-tb-cl-fill>{{ $d->pegawai->nama_lengkap ?? '-' }}</x-tb-cl-fill>
                            <x-tb-cl-fill>{{ $d->nidn }}</x-tb-cl-fill>
                            <x-tb-cl-fill>{{ $d->pegawai->email_institusi ?? '-' }}</x-tb-cl-fill>
                            <x-tb-cl-fill>
                                @if($d->kelompokKeahlian->isNotEmpty())
                                    <div class="flex flex-wrap gap-1">
                                        @foreach($d->kelompokKeahlian as $kk)
                                            <span class="inline-block bg-blue-100 text-blue-800 px-2 py-1 rounded text-xs font-medium">
                                                {{ $kk->nama_kk }}
                                            </span>
                                        @endforeach
                                    </div>
                                @else
                                    <span class="text-gray-500">-</span>
                                @endif
                            </x-tb-cl-fill>
                        </x-tb-cl>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-8 text-center text-gray-500">
                                Tidak ada data dosen
                            </td>
                        </tr>
                    @endforelse
                </x-slot:table_column>
            </x-tb>
        </div>

        <div class="flex justify-end gap-4">
            <a href="{{ route('manage.kelompok-keahlian.list') }}" class="px-4 py-2 bg-gray-300 text-gray-700 rounded hover:bg-gray-400">
                Kembali
            </a>
        </div>
    </div>
@endsection
