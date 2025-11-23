@php
    $active_sidebar = 'Kelompok Keahlian';
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
    <div class="flex flex-col md:flex-row items-center gap-[11.749480247497559px] self-stretch px-1 pt-[14.686850547790527px] pb-[13.952507972717285px]">
        <div class="flex w-full flex-col gap-[2.9373700618743896px] grow">
            <div class="flex items-center gap-[5.874740123748779px] self-stretch">
                <span class="font-medium text-2xl leading-[20.56159019470215px] text-[#101828]">Detail Kelompok Keahlian</span>
            </div>
        </div>
        <div class="flex items-center w-full justify-end gap-[11.749480247497559px]">
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
    <div class="flex flex-col gap-8 w-full max-w-100 mx-auto">
        <div class="flex flex-col gap-8 rounded-md border p-6 bg-white">
            <h2 class="text-lg font-semibold text-black border-b pb-3">Informasi Kelompok Keahlian</h2>

            <div class="grid md:grid-cols-2 gap-6">
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
            
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200 text-sm">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">No</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">Nama</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">NIDN</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">Email</th>
                            <th class="px-6 py-3 text-center text-xs font-medium text-gray-700 uppercase tracking-wider">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($kelompokKeahlian->dosen as $index => $dosen)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 whitespace-nowrap">{{ $index + 1 }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $dosen->pegawai->nama_lengkap ?? '-' }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $dosen->nidn }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $dosen->pegawai->email_institusi ?? '-' }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-center">
                                    <form action="{{ route('manage.kelompok-keahlian.nonaktifkan', $kelompokKeahlian->id) }}" method="POST" class="inline">
                                        @csrf
                                        <input type="hidden" name="dosen_id" value="{{ $dosen->id }}">
                                        <button type="submit" class="text-red-600 hover:text-red-800" onclick="return confirm('Yakin ingin menonaktifkan dosen ini?')">
                                            <i class="bi bi-x-circle"></i> Nonaktifkan
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-8 text-center text-gray-500">
                                    Belum ada dosen yang terdaftar di kelompok keahlian ini
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <div class="flex justify-end gap-4">
            <a href="{{ route('manage.kelompok-keahlian.list') }}" class="px-4 py-2 bg-gray-300 text-gray-700 rounded hover:bg-gray-400">
                Kembali
            </a>
        </div>
    </div>
@endsection
