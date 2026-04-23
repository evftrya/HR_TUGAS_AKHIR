@php
    $active_sidebar = 'Target Kinerja';
@endphp

@extends('kinerja_pegawai.base')

@section('header-base')
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <style>
        [x-cloak] {
            display: none !important;
        }
    </style>
@endsection

@section('page-name')
    <div class="flex items-center justify-between">
        <div>
            <h2 class="text-2xl font-medium">Edit Target Kinerja</h2>
            <p class="text-sm text-gray-600">Ubah data target kinerja</p>
        </div>
    </div>
@endsection

@section('content-base')
    <div class="bg-white p-4 rounded-lg shadow max-w-2xl">
        <form action="{{ route('manage.target-kinerja.update', $targetKinerja->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-4">
                <div class="flex items-center gap-1 mb-1">
                    <label class="block text-sm font-medium">Nama KPI</label>
                    <div x-data="{ open: false }" class="relative inline-block">
                        <i @click="open = !open" @click.outside="open = false"
                            class="fa-solid fa-circle-exclamation text-blue-500 cursor-pointer text-sm"></i>
                        <div x-show="open" x-cloak x-transition
                            class="absolute z-10 w-64 p-3 mt-2 text-sm text-white bg-gray-800 rounded-lg shadow-xl -left-1">
                            Nama target kinerja utama yang ingin dicapai.
                        </div>
                    </div>
                </div>
                <input type="text" name="nama_kpi" value="{{ old('nama_kpi', $targetKinerja->nama_kpi) }}"
                    class="w-full border rounded px-3 py-2 text-sm" placeholder="Contoh: Meningkatkan Publikasi Ilmiah"
                    required>
                @error('nama_kpi')
                    <div class="text-red-600 text-sm">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-4">
                <div class="flex items-center gap-1 mb-1">
                    <label class="block text-sm font-medium">Responsibility</label>
                    <div x-data="{ open: false }" class="relative inline-block">
                        <i @click="open = !open" @click.outside="open = false"
                            class="fa-solid fa-circle-exclamation text-blue-500 cursor-pointer text-sm"></i>
                        <div x-show="open" x-cloak x-transition
                            class="absolute z-10 w-64 p-3 mt-2 text-sm text-white bg-gray-800 rounded-lg shadow-xl -left-1">
                            Pihak atau personil yang bertanggung jawab secara teknis.
                        </div>
                    </div>
                </div>
                <input type="text" name="responsibility"
                    value="{{ old('responsibility', $targetKinerja->responsibility) }}"
                    class="w-full border rounded px-3 py-2 text-sm" placeholder="Nama Bagian atau Individu">
            </div>

            <div class="mb-4">
                <div class="flex items-center gap-1 mb-1">
                    <label class="block text-sm font-medium">Satuan</label>
                    <div x-data="{ open: false }" class="relative inline-block">
                        <i @click="open = !open" @click.outside="open = false"
                            class="fa-solid fa-circle-exclamation text-blue-500 cursor-pointer text-sm"></i>
                        <div x-show="open" x-cloak x-transition
                            class="absolute z-10 w-64 p-3 mt-2 text-sm text-white bg-gray-800 rounded-lg shadow-xl -left-1">
                            Satuan ukuran hasil akhir (misal: dokumen, laporan, orang).
                        </div>
                    </div>
                </div>
                <input type="text" name="satuan" value="{{ old('satuan', $targetKinerja->satuan) }}"
                    class="w-full border rounded px-3 py-2 text-sm" placeholder="Contoh: Dokumen, Laporan, atau Persentase">
            </div>

            <div class="mb-4">
                <div class="flex items-center gap-1 mb-1">
                    <label class="block text-sm font-medium">Bobot</label>
                    <div x-data="{ open: false }" class="relative inline-block">
                        <i @click="open = !open" @click.outside="open = false"
                            class="fa-solid fa-circle-exclamation text-blue-500 cursor-pointer text-sm"></i>
                        <div x-show="open" x-cloak x-transition
                            class="absolute z-10 w-64 p-3 mt-2 text-sm text-white bg-gray-800 rounded-lg shadow-xl -left-1">
                            Nilai prioritas target dalam perhitungan total kinerja.
                        </div>
                    </div>
                </div>
                <input type="number" name="bobot" value="{{ old('bobot', $targetKinerja->bobot) }}"
                    class="w-full border rounded px-3 py-2 text-sm" placeholder="Antara 0 - 100">
                @error('bobot')
                    <div class="text-red-600 text-sm">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-4">
                <div class="flex items-center gap-1 mb-1">
                    <label class="block text-sm font-medium">Target (%)</label>
                    <div x-data="{ open: false }" class="relative inline-block">
                        <i @click="open = !open" @click.outside="open = false"
                            class="fa-solid fa-circle-exclamation text-blue-500 cursor-pointer text-sm"></i>
                        <div x-show="open" x-cloak x-transition
                            class="absolute z-10 w-64 p-3 mt-2 text-sm text-white bg-gray-800 rounded-lg shadow-xl -left-1">
                            Persentase capaian yang diharapkan (0-100).
                        </div>
                    </div>
                </div>
                <input type="number" name="target_percent"
                    value="{{ old('target_percent', $targetKinerja->target_percent) }}"
                    class="w-full border rounded px-3 py-2 text-sm" placeholder="Contoh: 100">
            </div>

            <div class="mb-4">
                <div class="flex items-center gap-1 mb-1">
                    <label class="block text-sm font-medium">Status</label>
                    <div x-data="{ open: false }" class="relative inline-block">
                        <i @click="open = !open" @click.outside="open = false"
                            class="fa-solid fa-circle-exclamation text-blue-500 cursor-pointer text-sm"></i>
                        <div x-show="open" x-cloak x-transition
                            class="absolute z-10 w-64 p-3 mt-2 text-sm text-white bg-gray-800 rounded-lg shadow-xl -left-1">
                            Level atau cakupan dari target kinerja ini.
                        </div>
                    </div>
                </div>
                <select name="status" class="w-full border rounded px-3 py-2 text-sm">
                    <option value="">-- Pilih Status --</option>
                    <option value="institusi" {{ old('status', $targetKinerja->status) == 'institusi' ? 'selected' : '' }}>
                        Institusi</option>
                    <option value="unit" {{ old('status', $targetKinerja->status) == 'unit' ? 'selected' : '' }}>Unit
                    </option>
                    <option value="pribadi" {{ old('status', $targetKinerja->status) == 'pribadi' ? 'selected' : '' }}>
                        Pribadi</option>
                </select>
            </div>

            <div class="mb-4">
                <div class="flex items-center gap-1 mb-1">
                    <label class="block text-sm font-medium">Unit Penanggung Jawab</label>
                    <div x-data="{ open: false }" class="relative inline-block">
                        <i @click="open = !open" @click.outside="open = false"
                            class="fa-solid fa-circle-exclamation text-blue-500 cursor-pointer text-sm"></i>
                        <div x-show="open" x-cloak x-transition
                            class="absolute z-10 w-64 p-3 mt-2 text-sm text-white bg-gray-800 rounded-lg shadow-xl -left-1/2">
                            Unit kerja yang mengkoordinasi pencapaian target ini.
                        </div>
                    </div>
                </div>
                <input type="text" name="unit_penanggung_jawab"
                    value="{{ old('unit_penanggung_jawab', $targetKinerja->unit_penanggung_jawab) }}"
                    class="w-full border rounded px-3 py-2 text-sm" placeholder="Contoh: Prodi Informatika">
            </div>

            <div class="mb-4">
                <div class="flex items-center gap-1 mb-1">
                    <label class="block text-sm font-medium">Tahun</label>
                    <div x-data="{ open: false }" class="relative inline-block">
                        <i @click="open = !open" @click.outside="open = false"
                            class="fa-solid fa-circle-exclamation text-blue-500 cursor-pointer text-sm"></i>
                        <div x-show="open" x-cloak x-transition
                            class="absolute z-10 w-64 p-3 mt-2 text-sm text-white bg-gray-800 rounded-lg shadow-xl -left-1">
                            Tahun anggaran atau periode pelaksanaan.
                        </div>
                    </div>
                </div>
                <input type="number" name="tahun" value="{{ old('tahun', $targetKinerja->tahun) }}"
                    class="w-full border rounded px-3 py-2 text-sm" placeholder="Contoh: 2025" min="2000" max="2100">
            </div>

            <div class="mb-4">
                <div class="flex items-center gap-1 mb-1">
                    <label class="block text-sm font-medium">Periode (opsional)</label>
                    <div x-data="{ open: false }" class="relative inline-block">
                        <i @click="open = !open" @click.outside="open = false"
                            class="fa-solid fa-circle-exclamation text-blue-500 cursor-pointer text-sm"></i>
                        <div x-show="open" x-cloak x-transition
                            class="absolute z-10 w-64 p-3 mt-2 text-sm text-white bg-gray-800 rounded-lg shadow-xl -left-1/2">
                            Keterangan tambahan waktu (misal: Kuartal 1, Semester 1).
                        </div>
                    </div>
                </div>
                <input type="text" name="periode" value="{{ old('periode', $targetKinerja->periode) }}"
                    class="w-full border rounded px-3 py-2 text-sm" placeholder="Contoh: 2025 Q4">
            </div>

            <div class="grid grid-cols-2 gap-4 mb-4">
                <div>
                    <div class="flex items-center gap-1 mb-1">
                        <label class="block text-sm font-medium">Start</label>
                        <div x-data="{ open: false }" class="relative inline-block">
                            <i @click="open = !open" @click.outside="open = false"
                                class="fa-solid fa-circle-exclamation text-blue-500 cursor-pointer text-sm"></i>
                            <div x-show="open" x-cloak x-transition
                                class="absolute z-10 w-64 p-3 mt-2 text-sm text-white bg-gray-800 rounded-lg shadow-xl -left-1">
                                Tanggal mulai pelaksanaan target.
                            </div>
                        </div>
                    </div>
                    <input type="date" name="start" value="{{ old('start', $targetKinerja->start) }}"
                        class="w-full border rounded px-3 py-2 text-sm" required>
                    @error('start')
                        <div class="text-red-600 text-sm">{{ $message }}</div>
                    @enderror
                </div>
                <div>
                    <div class="flex items-center gap-1 mb-1">
                        <label class="block text-sm font-medium">End</label>
                        <div x-data="{ open: false }" class="relative inline-block">
                            <i @click="open = !open" @click.outside="open = false"
                                class="fa-solid fa-circle-exclamation text-blue-500 cursor-pointer text-sm"></i>
                            <div x-show="open" x-cloak x-transition
                                class="absolute z-10 w-64 p-3 mt-2 text-sm text-white bg-gray-800 rounded-lg shadow-xl -left-1">
                                Batas akhir penyelesaian target.
                            </div>
                        </div>
                    </div>
                    <input type="date" name="end" value="{{ old('end', $targetKinerja->end) }}"
                        class="w-full border rounded px-3 py-2 text-sm" required>
                    @error('end')
                        <div class="text-red-600 text-sm">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="mb-4">
                <div class="flex items-center gap-1 mb-1">
                    <label class="block text-sm font-medium">Keterangan</label>
                    <div x-data="{ open: false }" class="relative inline-block">
                        <i @click="open = !open" @click.outside="open = false"
                            class="fa-solid fa-circle-exclamation text-blue-500 cursor-pointer text-sm"></i>
                        <div x-show="open" x-cloak x-transition
                            class="absolute z-10 w-64 p-3 mt-2 text-sm text-white bg-gray-800 rounded-lg shadow-xl -left-1/2">
                            Deskripsi atau penjelasan detail mengenai target kinerja.
                        </div>
                    </div>
                </div>
                <textarea name="keterangan" class="w-full border rounded px-3 py-2 text-sm"
                    placeholder="Tambahkan informasi tambahan mengenai target ini...">{{ old('keterangan', $targetKinerja->keterangan) }}</textarea>
            </div>

            <div class="mb-4">
                <label class="inline-flex items-center">
                    <input type="checkbox" name="is_active" value="1" {{ $targetKinerja->is_active ? 'checked' : '' }}
                        class="form-checkbox">
                    <span class="ml-2">Active</span>
                </label>
            </div>

            <div class="flex gap-2">
                <button type="submit"
                    class="inline-flex items-center gap-1 px-4 py-2 bg-blue-600 text-white text-xs font-medium rounded hover:bg-blue-700 transition"><i
                        class="bi bi-save"></i> Simpan</button>
                <a href="{{ route('manage.target-kinerja.list') }}"
                    class="px-4 py-2 bg-gray-300 rounded text-gray-700">Batal</a>
            </div>
        </form>
    </div>
@endsection
