@php
    $active_sidebar = 'Daftar Pegawai';
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

    {{-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"> --}}
@endsection
@section('page-name')
    <div
        class="flex flex-col md:flex-row items-center gap-[11.749480247497559px] self-stretch px-1 pt-[14.686850547790527px] pb-[13.952507972717285px]">
        <div class="flex w-full flex-col gap-[2.9373700618743896px] grow">
            <div class="flex items-center gap-[5.874740123748779px] self-stretch"><span
                    class="font-medium text-2xl leading-[20.56159019470215px] text-[#101828]">Daftar
                    Pegawai {{ $send[0] == 'All' ? null : $send[0] }}</span>
            </div><span class="font-normal text-[10.280795097351074px] leading-[14.686850547790527px] text-[#1f2028]">Anda
                dapat
                melihat semua pegawai yang terdaftar di sistem disini</span>
        </div>
        <div class="flex items-center w-full justify-end gap-[11.749480247497559px]">

            {{-- <x-print-tb target_id="pegawaiTable"></x-print-tb> --}}
            <x-export-csv-tb target_id="pegawaiTable"></x-export-csv-tb>

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
    <div class="flex flex-grow-0 flex-col gap-2 max-w-100">
        <div class="flex items-center gap-[3.7518811225891113px]">
            <a href="{{ route('manage.pegawai.list', ['destination' => 'Active']) }}"
                class="h-[17.508777618408203px] {{ $send[0] == 'Active' ? 'nav-active' : null }} flex justify-center items-center gap-[6.253134727478027px] p-[6.253134727478027px] rounded-tl-[1.8759405612945557px] rounded-tr-[1.8759405612945557px]">
                <span class="font-semibold text-xs text-center text-[#1c2762]">Active</span>
            </a>
            <a href="{{ route('manage.pegawai.list', ['destination' => 'Semua']) }}"
                class="h-[17.508777618408203px] {{ $send[0] == 'Semua' ? 'nav-active' : null }} flex justify-center items-center gap-[6.253134727478027px] p-[6.253134727478027px]">
                <span class="font-semibold text-xs text-center text-[#1c2762]">Semua</span>
            </a>
        </div>


        <x-tb id="pegawaiTable">
            <x-slot:table_header>
                <x-tb-td nama="nama" sorting=true>Nama Lengkap</x-tb-td>
                <x-tb-td type="select" nama="gender" sorting=true>Gender</x-tb-td>
                <x-tb-td nama="nip" sorting=true>NIP</x-tb-td>
                <x-tb-td nama="nik" sorting=true>NIK</x-tb-td>
                <x-tb-td nama="hp" sorting=true>No. HP</x-tb-td>
                <x-tb-td type="select" nama="tipe" sorting=true>Tipe Pegawai</x-tb-td>
                <x-tb-td type="select" nama="bagian" sorting=true>Prodi/Bagian</x-tb-td>
                @if ($send[0] == 'Semua')
                    <x-tb-td type="select" nama="aktif" sorting=true>Is Active</x-tb-td>
                @endif
                <x-tb-td nama="action" sorting=false>Action</x-tb-td>
            </x-slot:table_header>
            <x-slot:table_column>
                @foreach ($users as $user)
                    {{-- @if ($user->is_active == 1) --}}
                    @if ($user['id'] != session('account')['id'])
                        <x-tb-cl id="$i">
                            <x-tb-cl-fill>
                                {{ $user['nama_lengkap'] }}
                            </x-tb-cl-fill>
                            <x-tb-cl-fill>{{ $user['jenis_kelamin'] }}</x-tb-cl-fill>
                            <x-tb-cl-fill>{{ $user['nip'] }}</x-tb-cl-fill>
                            <x-tb-cl-fill>{{ $user['nik'] }}</x-tb-cl-fill>
                            <x-tb-cl-fill>{{ $user['telepon'] }}</x-tb-cl-fill>
                            <x-tb-cl-fill>{{ $user['tipe_pegawai'] }}</x-tb-cl-fill>
                            {{-- {{ dd($user['bagian']) }} --}}
                            <x-tb-cl-fill>
                                <p class="cursor-pointer hover:font-bold"
                                    title="{{ $user['bagian']['type_work_position'] . ' - ' . $user['bagian']['position_name'] }}">
                                    {{ $user['bagian']['kode'] }}
                                </p>
                            </x-tb-cl-fill>
                            {{-- {{ dd($send) }} --}}
                            @if ($send[0] == 'Semua')
                                <x-tb-cl-fill>
                                    @if ($user['is_active'] == true)
                                        <span
                                            class="inline-flex items-center justify-center px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">
                                            Active
                                        </span>
                                    @else
                                        <span
                                            class="inline-flex items-center justify-center px-2 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-800">
                                            Nonactive
                                        </span>
                                    @endif

                                </x-tb-cl-fill>
                            @endif
                            <x-tb-cl-fill>
                                <div class="flex items-center justify-center gap-3">
                                    <!-- WhatsApp Button -->
                                    <!-- WhatsApp Button dengan Popover -->
                                    <a href="https://wa.me/62{{ $user['telepon'] }}" target="_blank"
                                        data-bs-container="body" data-bs-toggle="popover" data-bs-placement="top"
                                        data-bs-trigger="hover" data-bs-content="Hubungi lewat WhatsApp 📱"
                                        class="flex items-center justify-center w-7 h-7 rounded-md border border-[#d0d5dd] bg-white hover:bg-[#f9fafb] transition duration-150 ease-in-out">
                                        <i class="bi bi-whatsapp text-[#25D366] text-[16px]"></i>
                                    </a>


                                    <a href="{{ route('manage.pegawai.view.personal-info', ['idUser' => $user['id']]) }}"
                                        class="px-3 py-1.5 border border-[#0070ff] text-[#0070ff] rounded-md text-xs font-medium hover:bg-[#0070ff] hover:text-white transition duration-200">
                                        View Details
                                    </a>

                                    <div class="dropdown">
                                        <button class="btn btn-light btn-sm" data-bs-toggle="dropdown">
                                            ⋮
                                        </button>
                                        <ul class="dropdown-menu">
                                            <li><a class="dropdown-item hover:bg-blue-500 hover:text-white"
                                                    href="#">Tambah Pendidikan</a></li>
                                            <li><a class="dropdown-item hover:bg-blue-500 hover:text-white"
                                                    href="#">Ubah Struktural Jabatan</a></li>
                                            <li><a class="dropdown-item hover:bg-blue-500 hover:text-white"
                                                    href="#">Ubah Fungsional Jabatan</a></li>
                                        </ul>
                                    </div>

                                </div>
                            </x-tb-cl-fill>
                        </x-tb-cl>
                    @endif
                    {{-- @endif --}}
                @endforeach
            </x-slot:table_column>
        </x-tb>


    </div>




    @include('kelola_data.pegawai.js.active-and-nonactive-pegawai')
    @include('kelola_data.pegawai.js.alert-success-from-controller')

    {{-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script> --}}

    {{-- <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script> --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const popoverTriggerList = document.querySelectorAll('[data-bs-toggle="popover"]');
            [...popoverTriggerList].map(el => new bootstrap.Popover(el));
        });
    </script>
@endsection
{{-- @section('script')
    <script src="{{ 'js/print-table' }}"></script>
@endsection --}}
