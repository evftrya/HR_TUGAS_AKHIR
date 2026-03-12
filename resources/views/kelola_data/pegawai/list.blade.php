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
        }

        .nav-active span {
            color: white;
        }
    </style>
@endsection

@section('page-name')
    <div class="flex flex-col md:flex-row items-center gap-[11.7px] self-stretch px-1 pt-[14.6px] pb-[13.9px]">
        <div class="flex w-full flex-col gap-[2.9px] grow">
            <div class="flex items-center gap-[5.8px] self-stretch">
                <span class="font-medium text-2xl leading-[20.5px] text-[#101828]">
                    Daftar Pegawai {{ $send[0] == 'Semua' ? '' : $send[0] }}
                </span>
            </div>
            <span class="font-normal text-[10.2px] text-[#1f2028]">
                Anda dapat melihat semua pegawai yang terdaftar di sistem disini
            </span>
        </div>
        <div class="flex items-center w-full justify-end gap-[11.7px]">
            <x-export-csv-tb target_id="pegawaiTable"></x-export-csv-tb>
            <a href="{{ route('manage.pegawai.new') }}"
                class="bg-[#0070ff] px-[11.7px] route_pop_up py-[7.3px] rounded-[5.8px] border border-[#0070ff] hover:bg-[#005fe0] transition flex items-center gap-1">
                {{-- class="bg-[#0070ff] px-[11.7px] py-[7.3px] rounded-[5.8px] border border-[#0070ff] hover:bg-[#005fe0] transition flex items-center gap-1"> --}}
                <i class="bi bi-plus text-sm text-white"></i>
                <span class="font-medium text-[10.2px] text-white">Tambah</span>
            </a>
        </div>
    </div>
@endsection

@section('content-base')
    {{-- Navigasi Halaman --}}
    <div class="mt-4 px-2">
        {{ $users->links() }}
    </div>
    <div class="flex flex-grow-0 flex-col gap-2 max-w-100">
        <div class="flex items-center gap-[3.7px]">
            <a href="{{ route('manage.pegawai.list', ['destination' => 'Active']) }}"
                class="h-[17.5px] route_pop_up {{ $send[0] == 'Active' ? 'bg-[#0070ff] text-white' : '' }} text-[#1c2762] hover:bg-[#1A7BFF] hover:text-gray-100 active:bg-[#0050AA] active:scale-95 active:text-white active:drop-shadow-sm flex justify-center items-center gap-[6.2px] p-[10px] rounded-t-[4px]">
                <span class="font-semibold text-xs ">Active</span>
            </a>
            <a href="{{ route('manage.pegawai.list', ['destination' => 'Semua']) }}"
                class="h-[17.5px] route_pop_up {{ $send[0] == 'Semua' ? 'bg-[#0070ff] text-white' : '' }} text-[#1c2762] hover:bg-[#1A7BFF] hover:text-gray-100 active:bg-[#0050AA] active:scale-95 active:text-white active:drop-shadow-sm flex justify-center items-center gap-[6.2px] p-[10px] rounded-t-[4px]">
                <span class="font-semibold text-xs ">Semua</span>
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
                @php $authId = session('account')['id']; @endphp
                @foreach ($users as $user)
                    @if ($user->id != $authId)
                        {{-- Tag TR murni dengan class yang sama --}}
                        <tr class="x-tb-cl border-b border-gray-100 hover:bg-gray-50 transition">
                            {{-- Nomor urut diatur oleh JS indexFormatter di x-tb --}}
                            <td class="x-tb-cl-fill fill-table-row px-4 py-3 numbering"></td>

                            <td
                                class="x-tb-cl-fill fill-table-row px-4 py-3 whitespace-nowrap align-middle break-words text-wrap">
                                {{ $user->nama_lengkap }}
                            </td>
                            <td
                                class="x-tb-cl-fill fill-table-row px-4 py-3 whitespace-nowrap align-middle break-words text-wrap">
                                {{ $user->jenis_kelamin }}
                            </td>
                            <td
                                class="x-tb-cl-fill fill-table-row px-4 py-3 whitespace-nowrap align-middle break-words text-wrap">
                                {{ $user->nip_aktif ?? '-' }}
                            </td>
                            <td
                                class="x-tb-cl-fill fill-table-row px-4 py-3 whitespace-nowrap align-middle break-words text-wrap">
                                {{ $user->nik }}
                            </td>
                            <td
                                class="x-tb-cl-fill fill-table-row px-4 py-3 whitespace-nowrap align-middle break-words text-wrap">
                                {{ $user->telepon }}
                            </td>
                            <td
                                class="x-tb-cl-fill fill-table-row px-4 py-3 whitespace-nowrap align-middle break-words text-wrap">
                                {{ $user->tipe_pegawai }}
                            </td>
                            <td
                                class="x-tb-cl-fill fill-table-row px-4 py-3 whitespace-nowrap align-middle break-words text-wrap">
                                @if ($user->bagian_kode)
                                    <p class="cursor-pointer hover:font-bold"
                                        title="{{ $user->bagian_tipe . ' - ' . $user->bagian_nama }}">
                                        {{ $user->bagian_kode }}
                                    </p>
                                @else
                                    <p class="text-gray-400 italic">Not Yet Set</p>
                                    <a href="{{ route('manage.pengawakan.new', ['users_id' => $user->id]) }}"
                                        class="text-xs text-blue-500 route_pop_up hover:text-blue-700 hover:underline">
                                        klik untuk set
                                    </a>
                                @endif
                            </td>

                            @if ($send[0] == 'Semua')
                                <td
                                    class="x-tb-cl-fill fill-table-row px-4 py-3 whitespace-nowrap align-middle break-words text-wrap">
                                    <span
                                        class="inline-flex items-center justify-center px-2 py-1 text-xs font-semibold rounded-full {{ $user->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                        {{ $user->is_active ? 'Active' : 'Nonactive' }}
                                    </span>
                                </td>
                            @endif

                            <td
                                class="x-tb-cl-fill fill-table-row px-4 py-3 whitespace-nowrap align-middle break-words text-wrap">
                                <div class="flex items-center justify-center gap-3">
                                    <a href="https://wa.me/62{{ $user->telepon }}" target="_blank"
                                        class="flex items-center justify-center w-7 h-7 rounded-md border border-[#d0d5dd] bg-white hover:bg-[#f9fafb]"
                                        data-bs-toggle="popover" data-bs-trigger="hover"
                                        data-bs-content="Hubungi WhatsApp 📱">
                                        <i class="bi bi-whatsapp text-[#25D366]"></i>
                                    </a>

                                    <a href="{{ route('manage.pegawai.view.personal-info', ['idUser' => $user->id]) }}"
                                        class="px-3 route_pop_up py-1.5 border border-[#0070ff] text-[#0070ff] rounded-md text-xs font-medium hover:bg-[#0070ff] hover:text-white transition">
                                        View Details
                                    </a>

                                    <div class="dropdown">
                                        <button class="btn btn-light btn-sm" data-bs-toggle="dropdown">⋮</button>
                                        <ul class="dropdown-menu">
                                            <li><a class="dropdown-item route_pop_up" href="#">Tambah Pendidikan</a>
                                            </li>
                                            <li><a class="dropdown-item route_pop_up" href="#">Ubah Struktural</a>
                                            </li>
                                            <li><a class="dropdown-item route_pop_up" href="#">Ubah Fungsional</a>
                                            </li>
                                            <li><a class="dropdown-item route_pop_up"
                                                    href="{{ route('manage.pengawakan.new', ['users_id' => $user->id]) }}">Tambah
                                                    Pemetaan Baru</a></li>

                                        </ul>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @endif
                @endforeach
            </x-slot:table_column>
        </x-tb>

        {{-- Navigasi Halaman --}}
        <div class="mt-4 px-2">
            {{ $users->links() }}
        </div>
    </div>
@endsection

@section('script-base')
    @include('kelola_data.pegawai.js.active-and-nonactive-pegawai')
    @include('kelola_data.pegawai.js.alert-success-from-controller')
    @include('components.js.route-pop-up-button')

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const popoverTriggerList = document.querySelectorAll('[data-bs-toggle="popover"]');
            [...popoverTriggerList].map(el => new bootstrap.Popover(el));
        });
    </script>
@endsection
