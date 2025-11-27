@php
    $active_sidebar = 'Kelompok Keahlian';
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
@endsection

@section('page-name')
    <div class="flex flex-col md:flex-row items-center gap-[11.749480247497559px] self-stretch px-1 pt-[14.686850547790527px] pb-[13.952507972717285px]">
        <div class="flex w-full flex-col gap-[2.9373700618743896px] grow">
            <div class="flex items-center gap-[5.874740123748779px] self-stretch">
                <span class="font-medium text-2xl leading-[20.56159019470215px] text-[#101828]">Detail Kelompok Keahlian</span>
            </div>
        </div>
        <div class="flex items-center justify-end gap-[11.749480247497559px]">
            <a href="{{ route('manage.kelompok-keahlian.edit', $kelompokKeahlian->id) }}" class="flex rounded-[5.874740123748779px]">
                <div class="flex justify-center items-center gap-[5.874740123748779px] bg-[#f59e0b] px-[11.749480247497559px] py-[7.343425273895264px] rounded-[5.874740123748779px] border border-[#f59e0b] hover:bg-[#d97706] transition">
                    <i class="bi bi-pencil text-sm text-white"></i>
                    <span class="font-medium text-[10.28px] leading-[14.68px] text-white">Edit</span>
                </div>
            </a>
        </div>
    </div>
@endsection

@section('content-base')
    <div class="flex flex-grow-0 flex-col gap-2 max-w-100">
        <div class="flex flex-col gap-8 rounded-md border p-6 bg-white">
            <h2 class="text-lg font-semibold text-black border-b pb-3">Informasi Kelompok Keahlian</h2>

            <div class="grid md:grid-cols-2 gap-6 w-full">
                <div class="flex flex-col gap-2">
                    <span class="text-sm text-gray-500">Nama Kelompok Keahlian</span>
                    <span class="text-base font-medium text-gray-900">{{ $kelompokKeahlian->nama_kk }}</span>
                </div>

                <div class="flex flex-col gap-2">
                    <span class="text-sm text-gray-500">Sub Kelompok</span>
                    <span class="text-base font-medium text-gray-900">{{ $kelompokKeahlian->sub_kk ?? '-' }}</span>
                </div>
            </div>
        </div>

        <div class="flex flex-col gap-4 rounded-md border p-6 bg-white">
            <h2 class="text-lg font-semibold text-black border-b pb-3">Daftar Dosen ({{ $kelompokKeahlian->dosen->count() }})</h2>

            <!-- Form Tambah Dosen ke KK -->
            <form action="{{ route('manage.kelompok-keahlian.assignDosen', $kelompokKeahlian->id) }}" method="POST" class="mb-4 flex flex-col md:flex-row gap-2 items-start md:items-end">
                @csrf
                <div>
                    <label for="dosen_id" class="block text-sm font-medium text-gray-700 mb-1">Tambah Dosen ke KK</label>
                    <select name="dosen_id[]" id="dosen_id" class="border rounded px-3 py-2 min-w-[220px]" multiple required>
                        @foreach($allDosen as $dosen)
                            <option value="{{ $dosen->id }}">{{ $dosen->pegawai->nama_lengkap ?? '-' }} ({{ $dosen->nidn }})</option>
                        @endforeach
                    </select>
                </div>
                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 flex items-center gap-2">
                    <i class="bi bi-plus"></i> Tambah
                </button>
            </form>

            <x-tb id="dosenTable">
                <x-slot:table_header>
                    {{-- <x-tb-td nama="no">No</x-tb-td> --}}
                    <x-tb-td nama="nama">Nama</x-tb-td>
                    <x-tb-td nama="nidn">NIDN</x-tb-td>
                    <x-tb-td nama="email">Email</x-tb-td>
                    <x-tb-td nama="action">Aksi</x-tb-td>
                </x-slot:table_header>
                <x-slot:table_column>
                    @forelse($kelompokKeahlian->dosen as $index => $dosen)
                        <x-tb-cl id="{{ $dosen->id }}">
                            {{-- <x-tb-cl-fill>{{ $index + 1 }}</x-tb-cl-fill> --}}
                            <x-tb-cl-fill>{{ $dosen->pegawai->nama_lengkap ?? '-' }}</x-tb-cl-fill>
                            <x-tb-cl-fill>{{ $dosen->nidn }}</x-tb-cl-fill>
                            <x-tb-cl-fill>{{ $dosen->pegawai->email_institusi ?? '-' }}</x-tb-cl-fill>
                            <x-tb-cl-fill>
                                <div class="flex items-center justify-center gap-3">
                                    <form action="{{ route('manage.kelompok-keahlian.nonaktifkan', $kelompokKeahlian->id) }}" method="POST" class="inline">
                                        @csrf
                                        <input type="hidden" name="dosen_id" value="{{ $dosen->id }}">
                                        <button type="submit"
                                            onclick="return confirm('Yakin ingin menonaktifkan dosen ini?')"
                                            data-bs-container="body"
                                            data-bs-toggle="popover"
                                            data-bs-placement="top"
                                            data-bs-trigger="hover"
                                            data-bs-content="Nonaktifkan Dosen"
                                            class="flex items-center justify-center w-7 h-7 rounded-md border border-[#d0d5dd] bg-white hover:bg-red-50 transition duration-150 ease-in-out">
                                            <i class="bi bi-x-circle text-red-600 text-[14px]"></i>
                                        </button>
                                    </form>
                                </div>
                            </x-tb-cl-fill>
                        </x-tb-cl>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-4 text-center text-sm text-gray-500">
                                Belum ada dosen yang terdaftar di kelompok keahlian ini
                            </td>
                        </tr>
                    @endforelse
                </x-slot:table_column>
            </x-tb>

            @if(isset($nonaktifDosen) && count($nonaktifDosen) > 0)
            <div class="mt-8">
                <h3 class="text-base font-semibold text-black mb-2">Dosen Nonaktif di KK Ini</h3>
                <table class="min-w-full divide-y divide-gray-200 text-sm">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">Nama</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">NIDN</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">Email</th>
                            <th class="px-6 py-3 text-center text-xs font-medium text-gray-700 uppercase tracking-wider">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($nonaktifDosen as $dosen)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $dosen->pegawai->nama_lengkap ?? '-' }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $dosen->nidn }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $dosen->pegawai->email_institusi ?? '-' }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-center">
                                <form action="{{ route('manage.kelompok-keahlian.assignDosen', $kelompokKeahlian->id) }}" method="POST" class="inline">
                                    @csrf
                                    <input type="hidden" name="dosen_id[]" value="{{ $dosen->id }}">
                                    <button type="submit" class="text-green-600 hover:text-green-800" onclick="return confirm('Aktifkan dosen ini ke KK?')">
                                        <i class="bi bi-check-circle"></i> Aktifkan
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @endif
        </div>

        <div class="flex justify-end gap-4">
            <a href="{{ route('manage.kelompok-keahlian.list') }}" class="px-4 py-2 bg-gray-300 text-gray-700 rounded hover:bg-gray-400">
                Kembali
            </a>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const popoverTriggerList = document.querySelectorAll('[data-bs-toggle="popover"]');
            [...popoverTriggerList].map(el => new bootstrap.Popover(el));
        });
    </script>
@endsection
