@extends('layouts.app')

@section('content')

<div class="mt-16 md:ml-64 sm:ml-12 lg:ml-64">
    <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
        <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900">
                <h1 class="mb-3 text-2xl font-semibold">Formulir Detil Pengajuan DUPAK</h1>
                <h2 class="text-xl">Daftar Usulan Penetapan Angka Kredit</h2>

                <!-- {{ route('dupak.pengajuan.store') }} -->
                <form method="POST" action="" class="space-y-6">
                    @csrf

                    <!-- Basic Information -->

                    <!-- Unsur Utama -->
                    <div class="p-4 rounded-lg bg-gray-50">
                        <h2 class="mb-4 text-2xl font-medium text-gray-900">Unsur Utama</h2>

                        <!-- Pendidikan -->
                        <div class="mb-6">
                            <h3 class="mb-3 font-bold text-xl text-gray-800 text-md ">I. Pendidikan</h3>
                            <div class="space-y-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">A. Pendidikan Formal</label>
                                    <div class="mt-2 space-y-2">
                                        <div class="flex items-center gap-4">
                                            <input type="text" name="education_title" placeholder="Nama Gelar" class="flex-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                            <input type="number" name="education_credit" placeholder="Angka Kredit" class="flex-2 border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                        </div>
                                    </div>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">B. Diklat Prajabatan</label>
                                    <div class="mt-2 space-y-2">
                                        <div class="flex items-center gap-4">
                                            <input type="text" name="education_title" placeholder="Nama Gelar" class="flex-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                            <input type="number" name="education_credit" placeholder="Angka Kredit" class="flex-2 border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Pengajaran -->
                        <div class="mb-6">
                            <h3 class="mb-3 font-bold text-xl text-gray-800 text-md ">II. Pengajaran</h3>
                            <div class="space-y-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">A. Melaksanakan Perkuliahan/Tutorial</label>
                                    <div class="mt-2 space-y-2">
                                        <div class="flex items-center gap-4">
                                            <input type="text" name="teaching_subject" placeholder="Mata Kuliah" class="flex-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                            <input type="number" name="teaching_hours" placeholder="Jumlah Jam" class="w-32 border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                            <input type="number" name="teaching_credit" placeholder="Angka Kredit" class="w-32 border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <x-dupak.text-komponen-kegiatan activityLabel='B. Melaksanakan Bimbingan' />
                        <x-dupak.text-komponen-kegiatan activityLabel='C. Melaksanakan ' />

                        <!-- Penelitian -->
                        <div class="mb-6">
                            <h3 class="mb-3 font-bold text-xl text-gray-800 text-md ">III. Penelitian</h3>
                            <div class="space-y-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Menghasilkan Karya Ilmiah</label>
                                    <div class="mt-2 space-y-2">
                                        <div class="flex items-center gap-4">
                                            <input type="text" name="research_title" placeholder="Judul Penelitian" class="flex-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                            <select name="research_type" class="w-48 border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                                <option value="">Jenis Karya Ilmiah</option>
                                                <option value="journal">Jurnal Internasional</option>
                                                <option value="proceedings">Prosiding</option>
                                                <option value="book">Buku</option>
                                            </select>
                                            <input type="number" name="research_credit" placeholder="Angka Kredit" class="w-32 border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Pengabdian Masyarakat -->
                        <div class="mb-6">
                            <h3 class="mb-3 font-bold text-xl text-gray-800 text-md ">IV. Pengabdian Masyarakat</h3>
                            <div class="space-y-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Menghasilkan Karya Ilmiah</label>
                                    <div class="mt-2 space-y-2">
                                        <div class="flex items-center gap-4">
                                            <input type="text" name="research_title" placeholder="Judul Penelitian" class="flex-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                            <select name="research_type" class="w-48 border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                                <option value="">Jenis Karya Ilmiah</option>
                                                <option value="journal">Jurnal Internasional</option>
                                                <option value="proceedings">Prosiding</option>
                                                <option value="book">Buku</option>
                                            </select>
                                            <input type="number" name="research_credit" placeholder="Angka Kredit" class="w-32 border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Unsur Penunjang -->
                    <div class="p-4 rounded-lg bg-gray-50">
                        <h2 class="mb-4 text-lg font-medium text-gray-900">Unsur Penunjang</h2>
                        <div class="space-y-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Menjadi Anggota dalam Suatu Panitia/Badan pada Perguruan Tinggi</label>
                                <div class="mt-2 space-y-2">
                                    <div class="flex items-center gap-4">
                                        <input type="text" name="committee_name" placeholder="Nama Kepanitiaan" class="flex-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                        <input type="text" name="committee_position" placeholder="Jabatan" class="w-48 border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                        <input type="number" name="committee_credit" placeholder="Angka Kredit" class="w-32 border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

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