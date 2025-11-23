@php
    $active_sidebar = 'Target Kinerja';
@endphp

@extends('kelola_data.base')

@section('page-name')
    <div class="flex flex-col md:flex-row items-center gap-3 self-stretch px-1 pt-4 pb-3">
        <div class="flex w-full flex-col gap-1 grow">
            <div class="flex items-center gap-2">
                <span class="font-medium text-2xl text-[#101828]">Target Kinerja</span>
            </div>
            <span class="font-normal text-sm text-[#1f2028]">Kelola data target kinerja</span>
        </div>
        <div class="flex items-center w-full justify-end gap-3">
            <a href="{{ route('manage.target-kinerja.input') }}" class="flex">
                <div class="flex justify-center items-center gap-2 bg-[#0070ff] px-3 py-2 rounded text-white">
                    <i class="bi bi-plus text-sm"></i>
                    <span class="font-medium text-sm">Tambah</span>
                </div>
            </a>
        </div>
    </div>
@endsection

@section('content-base')
    <div class="flex flex-col gap-2">
        <x-tb id="targetKinerjaTable">
            <x-slot:table_header>
                <x-tb-td nama="no" sorting=true>No</x-tb-td>
                <x-tb-td nama="nama" sorting=true>Nama</x-tb-td>
                <x-tb-td nama="bobot" sorting=true>Bobot</x-tb-td>
                <x-tb-td nama="is_active">Active</x-tb-td>
                <x-tb-td nama="action">Action</x-tb-td>
            </x-slot:table_header>
            <x-slot:table_column>
                @foreach ($targetKinerja as $index => $item)
                    <x-tb-cl id="{{ $item->id }}">
                        <x-tb-cl-fill>{{ $index + 1 }}</x-tb-cl-fill>
                        <x-tb-cl-fill>{{ $item->nama }}</x-tb-cl-fill>
                        <x-tb-cl-fill>{{ $item->bobot }}</x-tb-cl-fill>
                        <x-tb-cl-fill>{{ $item->is_active ? 'Ya' : 'Tidak' }}</x-tb-cl-fill>
                        <x-tb-cl-fill>
                            <div class="flex gap-2">
                                <a href="{{ route('manage.target-kinerja.assign', $item->id) }}" class="text-green-600 hover:text-green-800" title="Assign Pegawai">
                                    <i class="bi bi-person-plus"></i>
                                </a>
                                <a href="{{ route('manage.target-kinerja.view', $item->id) }}" class="text-blue-600 hover:text-blue-800">
                                    <i class="bi bi-eye"></i>
                                </a>
                                <a href="{{ route('manage.target-kinerja.edit', $item->id) }}" class="text-yellow-600 hover:text-yellow-800">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <form action="{{ route('manage.target-kinerja.destroy', $item->id) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-800" onclick="return confirm('Yakin ingin menghapus data ini?')">
                                        <i class="bi bi-trash"></i>
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
