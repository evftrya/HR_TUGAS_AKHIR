@php
    $active_sidebar = 'Daftar Studi Lanjut';
@endphp

@extends('kelola_data.base')

@section('page-name')
    <div class="flex flex-col md:flex-row items-center gap-[11.749480247497559px] self-stretch px-1 pt-[14.686850547790527px] pb-[13.952507972717285px]">
        <div class="flex w-full flex-col gap-[2.9373700618743896px] grow">
            <div class="flex items-center gap-[5.874740123748779px] self-stretch">
                <span class="font-medium text-2xl leading-[20.56159019470215px] text-[#101828]">Detail Studi Lanjut</span>
            </div>
            <span class="font-normal text-[10.280795097351074px] leading-[14.686850547790527px] text-[#1f2028]">
                Informasi lengkap studi lanjut pegawai
            </span>
        </div>
    </div>
@endsection

@section('content-base')
<div class="container mx-auto px-4 py-6">
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Detail Studi Lanjut</h1>
    </div>

    <div class="bg-white rounded-lg shadow-md border border-gray-200 p-6">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label class="block text-sm font-medium text-gray-500 mb-1">Nama Pegawai</label>
                <p class="text-base text-gray-900">{{ $studiLanjut->user->nama_lengkap ?? 'N/A' }}</p>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-500 mb-1">NIP</label>
                <p class="text-base text-gray-900">{{ $studiLanjut->user->nip ?? 'N/A' }}</p>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-500 mb-1">Jenjang</label>
                <p class="text-base text-gray-900">{{ $studiLanjut->jenjang }}</p>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-500 mb-1">Program Studi</label>
                <p class="text-base text-gray-900">{{ $studiLanjut->program_studi }}</p>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-500 mb-1">Universitas</label>
                <p class="text-base text-gray-900">{{ $studiLanjut->universitas }}</p>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-500 mb-1">Negara</label>
                <p class="text-base text-gray-900">{{ $studiLanjut->negara }}</p>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-500 mb-1">Status</label>
                <p class="text-base">
                    @if($studiLanjut->status == 'Sedang Berjalan')
                        <span class="px-3 py-1 text-sm rounded-full bg-blue-100 text-blue-800">{{ $studiLanjut->status }}</span>
                    @elseif($studiLanjut->status == 'Selesai')
                        <span class="px-3 py-1 text-sm rounded-full bg-green-100 text-green-800">{{ $studiLanjut->status }}</span>
                    @else
                        <span class="px-3 py-1 text-sm rounded-full bg-yellow-100 text-yellow-800">{{ $studiLanjut->status }}</span>
                    @endif
                </p>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-500 mb-1">Tanggal Mulai</label>
                <p class="text-base text-gray-900">{{ \Carbon\Carbon::parse($studiLanjut->tanggal_mulai)->format('d F Y') }}</p>
            </div>

            @if($studiLanjut->tanggal_selesai)
            <div>
                <label class="block text-sm font-medium text-gray-500 mb-1">Tanggal Selesai</label>
                <p class="text-base text-gray-900">{{ \Carbon\Carbon::parse($studiLanjut->tanggal_selesai)->format('d F Y') }}</p>
            </div>
            @endif

            @if($studiLanjut->sumber_dana)
            <div class="md:col-span-2">
                <label class="block text-sm font-medium text-gray-500 mb-1">Sumber Dana</label>
                <p class="text-base text-gray-900">{{ $studiLanjut->sumber_dana }}</p>
            </div>
            @endif

            @if($studiLanjut->keterangan)
            <div class="md:col-span-2">
                <label class="block text-sm font-medium text-gray-500 mb-1">Keterangan</label>
                <p class="text-base text-gray-900">{{ $studiLanjut->keterangan }}</p>
            </div>
            @endif
        </div>

        <div class="flex gap-4 mt-6 pt-6 border-t border-gray-200">
            <a href="{{ route('manage.studi-lanjut.edit', $studiLanjut->id) }}" class="bg-blue-500 hover:bg-blue-600 text-white px-6 py-2 rounded-lg transition duration-200">
                Edit
            </a>
            <a href="{{ route('manage.studi-lanjut.list') }}" class="bg-gray-500 hover:bg-gray-600 text-white px-6 py-2 rounded-lg transition duration-200">
                Kembali
            </a>
            <form action="{{ route('manage.studi-lanjut.destroy', $studiLanjut->id) }}" method="POST" class="inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data ini?')">
                @csrf
                @method('DELETE')
                <button type="submit" class="bg-red-500 hover:bg-red-600 text-white px-6 py-2 rounded-lg transition duration-200">
                    Hapus
                </button>
            </form>
        </div>
    </div>
@endsection
