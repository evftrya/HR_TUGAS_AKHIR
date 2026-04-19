@php
    $active_sidebar = 'Jabatan Fungsional';
@endphp

@extends('kelola_data.base')

@section('page-name')
    <x-page-freeze></x-page-freeze>
    <div class="flex flex-col md:flex-row items-center gap-[11.75px] self-stretch px-1 pt-[14.68px] pb-[13.95px]">
        <div class="flex w-full flex-col gap-[2.93px] grow">
            <div class="flex items-center gap-[5.87px] self-stretch">
                <span class="font-medium text-2xl leading-[20.56px] text-[#101828]">Master Jabatan Fungsional (JFA)</span>
            </div>
            <span class="font-normal text-[10.28px] leading-[14.68px] text-[#1f2028]">
                Kelola jabatan fungsional akademik dan angka kredit (Kum) yang dibutuhkan
            </span>
        </div>
        <div class="flex items-center w-full justify-end gap-[11.75px]">
            <button class="flex bg-[#0070ff] px-[11.75px] py-[7.34px] rounded-[5.87px] text-white text-xs gap-1 hover:bg-[#005fe0] transition"
                onclick="window.location='{{ route('manage.jfa.new') }}'">
                <i class="bi bi-plus text-sm"></i>
                <span class="font-medium text-[10.28px]">Tambah JFA</span>
            </button>
        </div>
    </div>
@endsection

@section('content-base')
    <div class="mb-4 p-4 bg-blue-50 border-l-4 border-[#0070ff] rounded-r-md">
        <h3 class="font-semibold text-[#1c2762] text-sm mb-1 italic">Keterangan Master Data JFA:</h3>
        <ul class="text-[11px] text-gray-700 list-disc ml-5">
            <li><strong>Nama Jabatan:</strong> Nama lengkap jabatan (misal: Asisten Ahli).</li>
            <li><strong>Kode JFA:</strong> Singkatan dari nama jabatan akademik.</li>
            <li><strong>Kum:</strong> Angka kredit minimal yang dibutuhkan untuk jabatan tersebut.</li>
        </ul>
    </div>

    <x-modal-view :footer="false" :head="false" id="modal-detail-jfa" title="Detail JFA">
        <div class="flex flex-col gap-3 px-8 py-8">
            <div class="flex items-center gap-5">
                <span class="font-semibold text-xl text-[#101828]">Data Jabatan Fungsional</span>
                <button id="btn-edit-jfa" class="bg-[#0070ff] text-white font-medium text-xs px-3 py-1 rounded border border-[#0070ff] hover:bg-[#005bd4] transition">
                    Ubah Data
                </button>
            </div>
            <div class="flex gap-12 w-full mt-4">
                <div class="flex flex-col gap-2 w-1/2 text-sm font-light text-black">
                    <span>Nama Jabatan</span>
                    <span>Kode JFA</span>
                    <span>Kum Minimal</span>
                </div>
                <div class="flex flex-col gap-2 w-1/2 text-sm font-normal text-black">
                    <span id="det-jfa-nama">-</span>
                    <span id="det-jfa-kode">-</span>
                    <span id="det-jfa-kum">-</span>
                </div>
            </div>
        </div>
    </x-modal-view>

    <div class="w-full">
        <x-tb id="JfaTable">
            <x-slot:table_header>
                <x-tb-td nama="nama">Nama Jabatan</x-tb-td>
                <x-tb-td nama="kode">Kode JFA</x-tb-td>
                <x-tb-td sorting="true" nama="kum">Kum</x-tb-td>
                <x-tb-td>Action</x-tb-td>
            </x-slot:table_header>

            <x-slot:table_column>
                @php
                    $dummies = [
                        ['id' => 10, 'nama' => 'Asisten Ahli', 'kode' => 'AA', 'kum' => 150],
                        ['id' => 11, 'nama' => 'Lektor', 'kode' => 'L', 'kum' => 200],
                        ['id' => 12, 'nama' => 'Lektor Kepala', 'kode' => 'LK', 'kum' => 400],
                    ];
                @endphp
                @foreach ($dummies as $d)
                    <x-tb-cl id="{{ $d['id'] }}" idTargetModal="modal-detail-jfa">
                        <x-tb-cl-fill id="col-jfa-nama">{{ $d['nama'] }}</x-tb-cl-fill>
                        <x-tb-cl-fill id="col-jfa-kode">{{ $d['kode'] }}</x-tb-cl-fill>
                        <x-tb-cl-fill id="col-jfa-kum">{{ $d['kum'] }}</x-tb-cl-fill>
                        <x-tb-cl-fill>
                            <a href="{{ route('manage.jfa.update', $d['id']) }}" class="px-3 py-1 border border-[#0070ff] text-[#0070ff] rounded-md text-[10px] hover:bg-[#0070ff] hover:text-white transition">Ubah</a>
                        </x-tb-cl-fill>
                    </x-tb-cl>
                @endforeach
            </x-slot:table_column>
        </x-tb>
    </div>

    <script>
        document.addEventListener('click', function(e) {
            const row = e.target.closest('.x-tb-cl');
            if (row && !e.target.closest('a')) {
                const modal = document.querySelector('#modal-detail-jfa');
                const id = row.getAttribute('id');

                modal.querySelector('#det-jfa-nama').textContent = row.querySelector('#col-jfa-nama').textContent;
                modal.querySelector('#det-jfa-kode').textContent = row.querySelector('#col-jfa-kode').textContent;
                modal.querySelector('#det-jfa-kum').textContent = row.querySelector('#col-jfa-kum').textContent;
                
                modal.querySelector('#btn-edit-jfa').setAttribute('onclick', `window.location.href='/manage/jfa/update/${id}'`);
            }
        });
    </script>
@endsection