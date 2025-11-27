@php
    $active_sidebar = 'Daftar Studi Lanjut';
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
                <span class="font-medium text-2xl leading-[20.56159019470215px] text-[#101828]">Studi Lanjut</span>
            </div>
            <span class="font-normal text-[10.280795097351074px] leading-[14.686850547790527px] text-[#1f2028]">
                Kelola data studi lanjut pegawai
            </span>
        </div>
        <div class="flex items-center w-full justify-end gap-[11.749480247497559px]">
            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-2 rounded">
                    {{ session('success') }}
                </div>
            @endif
            <x-print-tb target_id="studiLanjutTable"></x-print-tb>
            <x-export-csv-tb target_id="studiLanjutTable"></x-export-csv-tb>
            <a href="{{ route('manage.studi-lanjut.input') }}" class="flex rounded-[5.874740123748779px]">
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
        <x-tb id="studiLanjutTable">
            <x-slot:table_header>
                <x-tb-td nama="nama_pegawai" sorting=true>Nama Pegawai</x-tb-td>
                <x-tb-td nama="jenjang" sorting=true>Jenjang</x-tb-td>
                <x-tb-td nama="program_studi" sorting=true>Program Studi</x-tb-td>
                <x-tb-td nama="universitas" sorting=true>Universitas</x-tb-td>
                <x-tb-td nama="negara" sorting=true>Negara</x-tb-td>
                <x-tb-td nama="status" sorting=true>Status</x-tb-td>
                <x-tb-td nama="tanggal_mulai" sorting=true>Tanggal Mulai</x-tb-td>
                <x-tb-td nama="action">Action</x-tb-td>
            </x-slot:table_header>

            <x-slot:table_column>
                @foreach($studiLanjut as $index => $item)
                    <x-tb-cl id="{{ $item->id }}">
                        <x-tb-cl-fill>{{ $item->user->nama_lengkap ?? 'N/A' }}</x-tb-cl-fill>
                        <x-tb-cl-fill>{{ $item->jenjang }}</x-tb-cl-fill>
                        <x-tb-cl-fill>{{ $item->program_studi }}</x-tb-cl-fill>
                        <x-tb-cl-fill>{{ $item->universitas }}</x-tb-cl-fill>
                        <x-tb-cl-fill>{{ $item->negara }}</x-tb-cl-fill>
                        <x-tb-cl-fill>
                            @if($item->status == 'Sedang Berjalan')
                                <span class="px-2 py-1 text-xs rounded-full bg-blue-100 text-blue-800">{{ $item->status }}</span>
                            @elseif($item->status == 'Selesai')
                                <span class="px-2 py-1 text-xs rounded-full bg-green-100 text-green-800">{{ $item->status }}</span>
                            @else
                                <span class="px-2 py-1 text-xs rounded-full bg-yellow-100 text-yellow-800">{{ $item->status }}</span>
                            @endif
                        </x-tb-cl-fill>
                        <x-tb-cl-fill>{{ \Carbon\Carbon::parse($item->tanggal_mulai)->format('d M Y') }}</x-tb-cl-fill>
                        <x-tb-cl-fill>
                            <div class="flex gap-2 justify-center">
                                <a href="{{ route('manage.studi-lanjut.view', $item->id) }}" class="text-blue-600 hover:text-blue-800">
                                    <i class="fa-solid fa-eye"></i>
                                </a>
                                <a href="{{ route('manage.studi-lanjut.edit', $item->id) }}" class="text-green-600 hover:text-green-800">
                                    <i class="fa-solid fa-pen-to-square"></i>
                                </a>
                                <form action="{{ route('manage.studi-lanjut.destroy', $item->id) }}" method="POST" class="inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-800">
                                        <i class="fa-solid fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </x-tb-cl-fill>
                    </x-tb-cl>
                @endforeach
            </x-slot:table_column>
        </x-tb>
    </div>
@endsection
