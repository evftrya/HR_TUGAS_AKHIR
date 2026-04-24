@php
    $active_sidebar = 'Daftar Pemetaan';
@endphp

@extends('kelola_data.base')

@section('header-base')
    <script src="https://balkan.app/js/OrgChart.js"></script>
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
    <div class="flex flex-col md:flex-row items-center gap-[11.749480247497559px] self-stretch px-1 pt-[14.686850547790527px] pb-[13.952507972717285px]">
        <div class="flex w-full flex-col gap-[2.9373700618743896px] grow">
            <div class="flex items-center gap-[5.874740123748779px] self-stretch">
                <span class="font-medium text-2xl leading-[20.56159019470215px] text-[#101828]">Daftar Pemetaan</span>
            </div>
            <span class="font-normal text-[10.280795097351074px] leading-[14.686850547790527px] text-[#1f2028]">
                Anda dapat melihat semua formasi yang terdaftar di sistem disini
            </span>
        </div>
        <div class="flex items-center w-full justify-end gap-[11.749480247497559px]">
            <x-print-tb target_id="PemetaanTable"></x-print-tb>
            <x-export-csv-tb target_id="PemetaanTable"></x-export-csv-tb>

            <a href="{{ route('manage.pengawakan.new') }}" class="flex rounded-[5.874740123748779px]">
                <div class="flex route_pop_up justify-center items-center gap-[5.874740123748779px] bg-[#0070ff] px-[11.749480247497559px] py-[7.343425273895264px] rounded-[5.874740123748779px] border border-[#0070ff] hover:bg-[#005fe0] transition">
                    <i class="bi bi-plus text-sm text-white"></i>
                    <span class="font-medium text-[10.28px] leading-[14.68px] text-white">Tambah</span>
                </div>
            </a>
        </div>
    </div>
@endsection

@section('content-base')
    <div class="flex items-center gap-2 border-slate-200 pb-2">
        <a href="{{ route('manage.pengawakan.list', ['is_active' => 'Aktif', 'button_aktif' => 'ba']) }}"
            class="route_pop_up {{ request('button_aktif') == 'ba' ? 'bg-blue-600 text-white shadow-sm' : '' }} active:scale-95 transition-all border-blue-600 border hover:bg-blue-950 hover:text-white duration-300 flex justify-center items-center gap-[6.2px] py-2 px-5 rounded-lg">
            <span class="font-semibold text-xs">Pemetaan yang sedang aktif saat ini</span>
        </a>
        <a href="{{ route('manage.pengawakan.list', ['sort' => 'bagian', 'order' => 'desc', 'button_aktif' => 'bb']) }}"
            class="route_pop_up {{ request('button_aktif') == 'bb' ? 'bg-blue-600 text-white shadow-sm' : '' }} active:scale-95 transition-all hover:bg-blue-950 hover:text-white duration-300 flex justify-center items-center gap-[6.2px] py-2 px-5 rounded-lg">
            <span class="font-semibold text-xs">Data Pemetaan Sesuai Bagian</span>
        </a>
        <a href="{{ route('manage.pengawakan.list', ['button_aktif' => 'bc']) }}"
            class="route_pop_up {{ request('button_aktif') == 'bc' ? 'bg-blue-600 text-white shadow-sm' : '' }} active:scale-95 transition-all duration-300 flex justify-center items-center gap-[6.2px] py-2 px-5 rounded-lg">
            <span class="font-semibold text-xs">Semua</span>
        </a>
    </div>

    <div class="flex flex-grow-0 flex-col gap-2 max-w-100 bg-white p-4 rounded-xl shadow-sm border border-slate-200 mt-2">
        <x-tb id="PemetaanTable" search_status=true>
            <x-slot:table_header>
                <x-tb-td nama="nama" sorting=true>Nama Pegawai</x-tb-td>
                <x-tb-td type="select" nama="formasi" sorting=true>Formasi</x-tb-td>
                <x-tb-td nama="tmt_mulai" sorting=true>TMT Mulai</x-tb-td>
                <x-tb-td nama="tmt_selesai" sorting=true>TMT Selesai</x-tb-td>
                <x-tb-td type="select" nama="is_active" sorting=true>Status</x-tb-td>
                <x-tb-td nama="sk" sorting=true>Nomor SK</x-tb-td>
                <x-tb-td nama="bagian" type="select" sorting=true>Bagian</x-tb-td>
                <x-tb-td nama="action">Action</x-tb-td>
            </x-slot:table_header>

            <x-slot:table_column>
                @foreach ($pemetaans as $pemetaan)
                    <x-tb-cl :cls="($pemetaan->status == 'tidak' || ($pemetaan->tmt_selesai && $pemetaan->tmt_selesai < now())) ? 'opacity-45' : ''">
                        {{-- Nama Pegawai --}}
                        <x-tb-cl-fill>{{ htmlspecialchars($pemetaan->users->nama_lengkap) }}</x-tb-cl-fill>

                        {{-- Formasi --}}
                        <x-tb-cl-fill>{{ htmlspecialchars($pemetaan->formasi->nama_formasi) }}</x-tb-cl-fill>

                        {{-- TMT Mulai --}}
                        <x-tb-cl-fill>{{ date('Y/m/d', strtotime($pemetaan->tmt_mulai)) }}</x-tb-cl-fill>

                        {{-- TMT Selesai --}}
                        <x-tb-cl-fill>
                            @if ($pemetaan->tmt_selesai == null)
                                <p class="text-sm text-orange-400 font-medium">Belum di set</p>
                            @else
                                {{ date('Y/m/d', strtotime($pemetaan->tmt_selesai)) }}
                            @endif
                        </x-tb-cl-fill>

                        {{-- Status --}}
                        <x-tb-cl-fill>
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $pemetaan->status == 'aktif' ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                                {{ $pemetaan->status == 'aktif' ? 'Aktif' : 'Tidak' }}
                            </span>
                        </x-tb-cl-fill>

                        {{-- Nomor SK --}}
                        <x-tb-cl-fill>
                            <a href="{{ route('manage.sk.view', ['id_sk_or_sk_number' => str_replace('/', '|', $pemetaan->sk_ypt->no_sk)]) }}"
                                class="px-3 py-1 text-xs font-semibold bg-blue-100 text-blue-700 rounded-full flex items-center gap-2 border border-transparent transition-all duration-200 hover:bg-white hover:border-blue-500 hover:scale-105 active:scale-100">
                                <i class="fa-solid fa-file"></i>
                                {{ htmlspecialchars($pemetaan->sk_ypt->no_sk) }}
                            </a>
                        </x-tb-cl-fill>

                        {{-- Bagian --}}
                        <x-tb-cl-fill>{{ $pemetaan->formasi->bagian->position_name }}</x-tb-cl-fill>

                        {{-- Action --}}
                        <x-tb-cl-fill>
                            <div class="flex items-center justify-center gap-3">
                                <div class="dropdown">
                                    <button class="btn btn-light btn-sm rounded-lg border border-slate-200 px-2" data-bs-toggle="dropdown">
                                        <i class="bi bi-list"></i>
                                    </button>
                                    <ul class="dropdown-menu shadow-lg border-0 rounded-xl overflow-hidden">
                                        <li>
                                            <a href="{{ route('manage.pengawakan.update', ['idPemetaan' => $pemetaan->id]) }}"
                                                class="dropdown-item py-2 hover:bg-blue-500 hover:text-white">
                                                Ubah Data
                                            </a>
                                        </li>
                                        <li>
                                            <button onclick="End_validation('{{ $pemetaan->id }}')"
                                                class="dropdown-item py-2 hover:bg-blue-500 hover:text-white">
                                                Selesaikan Masa Jabatan
                                            </button>
                                        </li>
                                        <li>
                                            <a href="{{ route('profile.history.pemetaan', ['id_user' => $pemetaan->users_id]) }}"
                                                class="dropdown-item py-2 hover:bg-blue-500 hover:text-white">
                                                History Pemetaan Karyawan
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

        <form action="{{ route('manage.pengawakan.selesaikan-jabatan') }}" method="POST" class="end-pemetaan hidden">
            @csrf
            <input type="hidden" name="id" class="id_pengawakan">
        </form>
    </div>
@endsection

@push('script-under-base')
    @include('kelola_data.pegawai.js.alert-success-from-controller')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const popoverTriggerList = document.querySelectorAll('[data-bs-toggle="popover"]');
            [...popoverTriggerList].map(el => new bootstrap.Popover(el));
        });

        function End_validation(idPemetaan) {
            Swal.fire({
                title: "Apakah Anda yakin?",
                text: "Anda akan menyelesaikan masa jabatan untuk pemetaan ini!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Ya, Selesaikan!",
                cancelButtonText: "Batal"
            }).then((result) => {
                if (result.isConfirmed) {
                    const form = document.querySelector('.end-pemetaan');
                    form.querySelector('.id_pengawakan').value = idPemetaan;
                    form.submit();
                }
            });
        }
    </script>
@endpush
