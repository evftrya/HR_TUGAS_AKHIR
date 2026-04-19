@php
    $active_sidebar = 'Jenjang Pendidikan';
@endphp

@extends('kelola_data.base')

@section('page-name')
    <x-page-freeze></x-page-freeze>
    <div class="flex flex-col md:flex-row items-center gap-[11.75px] self-stretch px-1 pt-[14.68px] pb-[13.95px]">
        <div class="flex w-full flex-col gap-[2.93px] grow">
            <div class="flex items-center gap-[5.87px] self-stretch">
                <span class="font-medium text-2xl leading-[20.56px] text-[#101828]">Master Jenjang Pendidikan</span>
            </div>
            <span class="font-normal text-[10.28px] leading-[14.68px] text-[#1f2028]">
                Kelola data jenjang pendidikan mulai dari tingkat hingga urutan akademik
            </span>
        </div>
        <div class="flex items-center w-full justify-end gap-[11.75px]">
            <a class="flex bg-[#0070ff] px-[11.75px] py-[7.34px] rounded-[5.87px] text-white text-xs gap-1 hover:bg-[#005fe0] transition"
                href ="{{ route('manage.jfa.ref.new') }}">
                <i class="bi bi-plus text-sm"></i>
                <span class="font-medium text-[10.28px]">Tambah Referensi JFA</span>
            </a>
        </div>
    </div>
@endsection

@section('content-base')
    <div class="w-full">
        <x-tb id="JenjangTable">
            <x-slot:table_header>
                <x-tb-td nama="kode">Kode Jenjang</x-tb-td>
                <x-tb-td nama="tingkat">Nama Jabatan</x-tb-td>
                <x-tb-td nama="urut">Kum</x-tb-td>
                <x-tb-td>Action</x-tb-td>
            </x-slot:table_header>

            <x-slot:table_column>
                @foreach ($data as $d)
                    <x-tb-cl id="{{ $d['id'] }}" idTargetModal="modal-detail-jenjang">
                        <x-tb-cl-fill id="col-kode">{{ $d['kode'] }}</x-tb-cl-fill>
                        <x-tb-cl-fill id="col-tingkat">{{ $d['nama_jabatan'] }}</x-tb-cl-fill>
                        <x-tb-cl-fill id="col-urut">{{ $d['kum'] }}</x-tb-cl-fill>
                        <x-tb-cl-fill>
                            <a href="{{ route('manage.jfa.ref.edit', ['id' => $d['id']]) }}"
                                class="px-3 py-1 border border-[#0070ff] text-[#0070ff] rounded-md text-[10px] hover:bg-[#0070ff] hover:text-white transition">Ubah</a>
                        </x-tb-cl-fill>
                    </x-tb-cl>
                @endforeach
            </x-slot:table_column>
        </x-tb>
    </div>
@endsection

@push('script-under-base')
@endpush
