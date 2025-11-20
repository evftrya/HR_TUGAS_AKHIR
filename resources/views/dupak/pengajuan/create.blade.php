@extends('layouts.app')

@section('content')
<x-dupak.sidebar></x-dupak.sidebar>

<div class="mt-16 md:ml-64 sm:ml-12 lg:ml-64">
    <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
        <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900">
                <h1 class="mb-3 text-2xl font-semibold">Formulir Pengajuan DUPAK</h1>
                <h2 class="text-xl">Daftar Usulan Penetapan Angka Kredit</h2>

                <form method="POST" action="{{ route('dupak.pengajuan.store') }}" class="space-y-6">
                    @csrf

                    <!-- Basic Information -->
                    <div class="p-4 rounded-lg bg-gray-50">
                        <h2 class="mb-4 text-lg font-medium text-gray-900">Informasi Dasar</h2>
                        <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                            <div>
                                <label for="nidn" class="block text-sm font-medium text-gray-700">NIDN</label>
                                <input type="text" name="nidn" id="nidn" value="{{ $nidn ?? "NIDN Tidak Ditemukan" }}"
                                    class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 bg-gray-200"
                                    readonly>
                                <small class="text-gray-400">Diambil dari data anda terkini</small>
                            </div>


                        </div>
                    </div>

                    <!-- Current Functional Position -->
                    <div class="p-4 rounded-lg bg-gray-50">
                        <h2 class="mb-4 text-lg font-medium text-gray-900">Status Jabatan Fungsional Akademik</h2>
                        <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                            <div>
                                <label for="current_position" class="block text-sm font-medium text-gray-700">Jabatan Fungsional Saat Ini</label>
                                <input type="text" name="current_position" id="current_position" value="{{ $jabatan_fungsional ?? 'Belum ada' }}"
                                    class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 bg-gray-200"
                                    readonly>
                                <small class="text-gray-400">Diambil dari data anda terkini</small>
                            </div>

                            <div>
                                <label for="target_position" class="block text-sm font-medium text-gray-700">Jabatan Fungsional Yang Dituju</label>
                                <!-- input yang disabled sama seperti diatas tapi isinya adalah $jfa_tujuan -->
                                <input type="text" name="target_position" id="target_position" value="{{ $jfa_tujuan ?? 'Belum ada' }}"
                                    class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 bg-gray-200"
                                    readonly>
                            </div>

                            <!-- <div>
                                <label for="start_date" class="block text-sm font-medium text-gray-700">Periode Awal</label>
                                <input type="date" name="start_date" id="start_date"
                                    class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                    required>
                            </div>

                            <div>
                                <label for="end_date" class="block text-sm font-medium text-gray-700">Periode Akhir</label>
                                <input type="date" name="end_date" id="end_date"
                                    class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                    required>
                            </div> -->

                            <!-- <div>
                                <label for="period" class="block text-sm font-medium text-gray-700">Pengajuan Berdasarkan Semester</label>
                                <select name="period" id="period" class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                    <option value="">Jenis Pengajuan Semester</option>
                                    <option value="2024-1">Ganjil</option>
                                    <option value="2024-2">Genap</option>
                                    <option value="2024-2">Ganjil & Genap</option>
                                </select>
                            </div> -->
                        </div>
                    </div>

                    <!-- Unsur Utama -->
                    <div class="flex justify-end pt-6">
                        <a href="{{ route('dupak.pengajuan.index') }}" class="px-4 py-2 mr-4 text-white bg-gray-500 rounded-md hover:bg-gray-600">
                            Batal
                        </a>
                        <button type="submit" class="px-4 py-2 text-white bg-indigo-600 rounded-md hover:bg-indigo-700">
                            Simpan Pengajuan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection