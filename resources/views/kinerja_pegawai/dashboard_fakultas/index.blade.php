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
    <div
        class="flex flex-col md:flex-row items-center gap-[11.749480247497559px] self-stretch px-1 pt-[14.686850547790527px] pb-[13.952507972717285px]">
        <div class="flex w-full flex-col gap-[2.9373700618743896px] grow">
            <div class="flex items-center gap-[5.874740123748779px] self-stretch"><span
                    class="font-medium text-2xl leading-[20.56159019470215px] text-[#101828]">Daftar Fakultas</span>
            </div><span class="font-normal text-[10.280795097351074px] leading-[14.686850547790527px] text-[#1f2028]">Anda
                sdapat
                melihat semua fakultas yang terdaftar di sistem disini</span>
        </div>
        <div class="flex items-center w-full justify-end gap-[11.749480247497559px]">

            <button class="flex rounded-[5.874740123748779px]">
                <div
                    class="flex justify-center items-center gap-[5.874740123748779px] bg-[#0070ff] px-[11.749480247497559px] py-[7.343425273895264px] rounded-[5.874740123748779px] border border-[#0070ff] hover:bg-[#005fe0] transition">
                    <i class="bi bi-plus text-sm text-white"></i>
                    <span class="font-medium text-[10.28px] leading-[14.68px] text-white">Tambah</span>
                </div>
            </button>
        </div>

    </div>
@endsection
@section('content-base')
    <div class="flex flex-row sm:flex-col w-full max-w-full justify-evenly items-center mb-10">
        @for ($i = 0; $i <= 3; $i++)
            <div class="flex flex-col justify-center items-center py-2">
                <h1 class="py-12 text-5xl font-semibold text-center w-full">
                    120
                </h1>
                <p class="font-semibold text-center w-full">Fakultas</p>
            </div>

            @if ($i != 3)
                <div class="self-stretch border-l-2 border-gray-500 mx-6"></div>
            @endif
        @endfor
    </div>

    <div class="flex flex-grow-0 flex-col gap-2 max-w-100">
        <x-tb id="fakultasTable">
            <x-slot:put_something>
                <div class="flex items-center gap-2 h-full">
                    <x-print-tb target_id="fakultasTable"></x-print-tb>
                    <x-export-csv-tb target_id="fakultasTable"></x-export-csv-tb>
                </div>
            </x-slot:put_something>
            <x-slot:table_header>
                <x-tb-td nama="nama">No</x-tb-td>
                <x-tb-td nama="gender">Kode</x-tb-td>
                <x-tb-td nama="hp">Nama Fakultas</x-tb-td>
                <x-tb-td nama="tipe">Jumlah Pegawai</x-tb-td>
                <x-tb-td nama="status">Status</x-tb-td>
                <x-tb-td nama="action">Action</x-tb-td>
            </x-slot:table_header>
            <x-slot:table_column>
                @for ($i = 0; $i < 2; $i++)
                    <x-tb-cl id="$i">
                        <x-tb-cl-fill>1</x-tb-cl-fill>
                        <x-tb-cl-fill>FTI {{ $i }}</x-tb-cl-fill>
                        <x-tb-cl-fill>Fakultas Teknik Industri</x-tb-cl-fill>
                        <x-tb-cl-fill>200</x-tb-cl-fill>
                        <x-tb-cl-fill>Aktif</x-tb-cl-fill>
                        <x-tb-cl-fill>
                            <div class="flex items-center justify-center gap-3">
                                <!-- WhatsApp Button -->
                                <!-- WhatsApp Button dengan Popover -->
                                <a href="https://wa.me/628972529100" target="_blank" data-bs-container="body"
                                    data-bs-toggle="popover" data-bs-placement="top" data-bs-trigger="hover"
                                    data-bs-content="Hubungi lewat WhatsApp 📱"
                                    class="flex items-center justify-center w-7 h-7 rounded-md border border-[#d0d5dd] bg-white hover:bg-[#f9fafb] transition duration-150 ease-in-out">
                                    <i class="bi bi-whatsapp text-[#25D366] text-[16px]"></i>
                                </a>

                                <!-- Power Button -->
                                <button
                                    class="flex items-center justify-center w-7 h-7 rounded-md border border-[#d0d5dd] bg-white hover:bg-[#f9fafb] transition">
                                    <i class="fa-solid fa-power-off text-[#10B981] text-[14px]"></i>
                                </button>

                                <!-- View Details Button -->
                                <button
                                    class="px-3 py-1.5 border border-[#0070ff] text-[#0070ff] rounded-md text-xs font-medium hover:bg-[#0070ff] hover:text-white transition duration-200">
                                    View Details
                                </button>
                            </div>
                        </x-tb-cl-fill>
                    </x-tb-cl>
                @endfor
            </x-slot:table_column>
        </x-tb>

    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const popoverTriggerList = document.querySelectorAll('[data-bs-toggle="popover"]');
            [...popoverTriggerList].map(el => new bootstrap.Popover(el));
        });
    </script>
@endsection
