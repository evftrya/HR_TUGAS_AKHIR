@php
    $active_sidebar = 'Daftar Sub KK';
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
                <span class="font-medium text-2xl leading-[20.56159019470215px] text-[#101828]">Daftar Sub Kelompok
                    Keahlian</span>
            </div>
            <span class="font-normal text-[10.280795097351074px] leading-[14.686850547790527px] text-[#1f2028]">
                Manajemen data Sub Kelompok Keahlian (Sub-KK) dan pemetaan dosen
            </span>
        </div>
        <div class="flex items-center w-full justify-end gap-[11.749480247497559px]">
            <x-print-tb target_id="SubKKTable"></x-print-tb>
            <x-export-csv-tb target_id="SubKKTable"></x-export-csv-tb>

            <a href="{{ route('manage.kelompok-keahlian.sub.create') }}" class="flex rounded-[5.874740123748779px]">
                <div
                    class="flex justify-center items-center gap-[5.874740123748779px] bg-[#0070ff] px-[11.749480247497559px] py-[7.343425273895264px] rounded-[5.874740123748779px] border border-[#0070ff] hover:bg-[#005fe0] transition">
                    <i class="bi bi-plus text-sm text-white"></i>
                    <span class="font-medium text-[10.28px] leading-[14.68px] text-white">Tambah Sub KK</span>
                </div>
            </a>
        </div>
    </div>
@endsection

@section('content-base')

    <div class="flex flex-grow-0 flex-col gap-2 max-w-100 bg-white p-4 rounded-xl shadow-sm border border-slate-200 mt-2">
        <div class="flex items-center gap-2 border-b border-slate-200 pb-2">
            <a href="{{ route('manage.kelompok-keahlian.sub.list') }}"
                class="route_pop_up {{ (!request()->has('destination')) ? 'bg-blue-600 text-white shadow-sm' : 'bg-slate-50 text-slate-600 hover:bg-slate-100 border border-slate-200' }}
                    active:scale-95 transition-all duration-300 flex justify-center items-center gap-[6.2px] py-2 px-5 rounded-lg">
                <span class="font-semibold text-xs">Hanya Sub KK dengan dosen yang terpetakan</span>
            </a>
            <a href="{{ route('manage.kelompok-keahlian.sub.list', ['destination' => 'all']) }}" onclick="WarningLongTime(this, event)"
                class="{{ (request()->has('destination')) ? 'bg-blue-600 text-white shadow-sm' : 'bg-slate-50 text-slate-600 hover:bg-slate-100 border border-slate-200' }}
                    active:scale-95 transition-all duration-300 flex justify-center items-center gap-[6.2px] py-2 px-5 rounded-lg">
                <span class="font-semibold text-xs">Semua</span>
            </a>
        </div>
        <x-tb id="SubKKTable" search_status=true>
            <x-slot:table_header>
                <x-tb-td nama="nama" sorting=true>Nama Sub KK</x-tb-td>
                <x-tb-td nama="kode" sorting=true>Kode Sub KK</x-tb-td>
                <x-tb-td nama="kk" type="select" sorting=true>Kelompok Keahlian</x-tb-td>
                <x-tb-td nama="deskripsi">Deskripsi</x-tb-td>
                <x-tb-td nama="dosen_dipetakan" sorting=true>Dosen Dipetakan</x-tb-td>
                <x-tb-td nama="action">Action</x-tb-td>
            </x-slot:table_header>

            <x-slot:table_column>
                @foreach ($sub_kk as $subkk)
                    <x-tb-cl>
                        {{-- Nama Sub KK --}}
                        <x-tb-cl-fill>
                            <span class="font-medium text-slate-800">{{ htmlspecialchars($subkk->nama) }}</span>
                        </x-tb-cl-fill>

                        {{-- Kode Sub KK --}}
                        <x-tb-cl-fill>
                            <span class="px-2 py-1 bg-slate-100 text-slate-600 rounded font-mono text-xs">
                                {{ htmlspecialchars($subkk->kode) }}
                            </span>
                        </x-tb-cl-fill>

                        {{-- Kelompok Keahlian (Relasi KK -> nama) --}}
                        <x-tb-cl-fill>
                            {{ $subkk->KK ? $subkk->KK->nama : '-' }}
                        </x-tb-cl-fill>

                        {{-- Deskripsi (Dibatasi tampilannya, jika dihover akan memunculkan tooltip bawaan HTML) --}}
                        <x-tb-cl-fill>
                            <span class="text-sm text-slate-600 truncate max-w-[200px] inline-block cursor-help"
                                title="{{ htmlspecialchars($subkk->deskripsi) }}">
                                {{ htmlspecialchars($subkk->deskripsi) }}
                            </span>
                        </x-tb-cl-fill>

                        {{-- Dosen Dipetakan --}}
                        <x-tb-cl-fill>
                            <div class="flex items-center justify-center gap-1.5">
                                {{ (int) $subkk->dosen_dipetakan_count }}
                                <i class="bi bi-person-lines-fill text-slate-400"></i>
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
                                            <a href="#" class="dropdown-item py-2 hover:bg-blue-500 hover:text-white">
                                                Ubah Data
                                            </a>
                                        </li>
                                        <li>
                                            <a href="#" class="dropdown-item py-2 hover:bg-blue-500 hover:text-white">
                                                Lihat dosen terpetakan
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
        function WarningLongTime(elemen, event){
            event.preventDefault();
            Swal.fire({
            title: 'Yakin ingin melanjutkan?',
            text: 'Proses ini mungkin membutuhkan waktu yang cukup lama.',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'OK',
            cancelButtonText: 'Batal',
            allowOutsideClick: false,
            allowEscapeKey: false
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = elemen.href;
                    Swal.fire({
                        title: 'Mohon Tunggu',
                        text: 'Sedang memproses data, mohon tunggu beberapa detik...',
                        allowOutsideClick: false,
                        allowEscapeKey: false,
                        didOpen: () => {
                            Swal.showLoading();
                        }
                    });
                }
            });
        }
    </script>
@endpush
