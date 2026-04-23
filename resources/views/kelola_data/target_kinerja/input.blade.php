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
        .form-card {
            background: #ffffff;
            border-radius: 16px;
            border: 1px solid #f2f2f7;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
        }
    </style>
@endsection

@section('page-name')
    <div class="flex items-center justify-between px-1">
        <div>
            <h2 class="text-2xl font-bold text-[#101828]">Tambah Target Kinerja</h2>
            <p class="text-sm text-gray-500">Buat template KPI global baru untuk didistribusikan</p>
        </div>
    </div>
@endsection

@section('content-base')
    <div class="w-full">
        <form action="{{ route('manage.target-kinerja.store') }}" method="POST" class="space-y-6">
            @csrf

            <div class="form-card p-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-x-8 gap-y-6">
                    
                    {{-- Basic Information Section --}}
                    <div class="md:col-span-2 border-b border-gray-100 pb-2 mb-2">
                        <h3 class="text-lg font-bold text-gray-800">Informasi Utama</h3>
                    </div>

                    <div class="space-y-1">
                        <div class="flex items-center gap-1">
                            <label class="block text-sm font-semibold text-gray-700">Nama KPI</label>
                            <div x-data="{ open: false }" class="relative inline-block">
                                <i @click="open = !open" @click.outside="open = false"
                                    class="fa-solid fa-circle-exclamation text-blue-500 cursor-pointer text-sm"></i>
                                <div x-show="open" x-cloak x-transition
                                    class="absolute z-10 w-64 p-3 mt-2 text-sm text-white bg-gray-800 rounded-lg shadow-xl -left-1">
                                    Nama target kinerja utama yang ingin dicapai.
                                </div>
                            </div>
                        </div>
                        <input type="text" name="nama_kpi" value="{{ old('nama_kpi') }}"
                            class="w-full border-gray-200 focus:border-blue-500 focus:ring-blue-500 rounded-xl px-4 py-2.5 text-sm transition-all" 
                            placeholder="Contoh: Meningkatkan Publikasi Ilmiah" required>
                        @error('nama_kpi')
                            <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="space-y-1">
                        <div class="flex items-center gap-1">
                            <label class="block text-sm font-semibold text-gray-700">Responsibility</label>
                            <div x-data="{ open: false }" class="relative inline-block">
                                <i @click="open = !open" @click.outside="open = false"
                                    class="fa-solid fa-circle-exclamation text-blue-500 cursor-pointer text-sm"></i>
                                <div x-show="open" x-cloak x-transition
                                    class="absolute z-10 w-64 p-3 mt-2 text-sm text-white bg-gray-800 rounded-lg shadow-xl -left-1">
                                    Pihak atau personil yang bertanggung jawab secara teknis.
                                </div>
                            </div>
                        </div>
                        <input type="text" name="responsibility" value="{{ old('responsibility') }}"
                            class="w-full border-gray-200 focus:border-blue-500 focus:ring-blue-500 rounded-xl px-4 py-2.5 text-sm transition-all" 
                            placeholder="Nama Bagian atau Individu">
                    </div>

                    <div class="space-y-1">
                        <div class="flex items-center gap-1">
                            <label class="block text-sm font-semibold text-gray-700">Satuan</label>
                            <div x-data="{ open: false }" class="relative inline-block">
                                <i @click="open = !open" @click.outside="open = false"
                                    class="fa-solid fa-circle-exclamation text-blue-500 cursor-pointer text-sm"></i>
                                <div x-show="open" x-cloak x-transition
                                    class="absolute z-10 w-64 p-3 mt-2 text-sm text-white bg-gray-800 rounded-lg shadow-xl -left-1">
                                    Satuan ukuran hasil akhir (misal: dokumen, laporan, orang).
                                </div>
                            </div>
                        </div>
                        <input type="text" name="satuan" value="{{ old('satuan') }}"
                            class="w-full border-gray-200 focus:border-blue-500 focus:ring-blue-500 rounded-xl px-4 py-2.5 text-sm transition-all" 
                            placeholder="Contoh: Dokumen, Laporan, atau Persentase">
                    </div>

                    <div class="space-y-1">
                        <div class="flex items-center gap-1">
                            <label class="block text-sm font-semibold text-gray-700">Unit Penanggung Jawab</label>
                            <div x-data="{ open: false }" class="relative inline-block">
                                <i @click="open = !open" @click.outside="open = false"
                                    class="fa-solid fa-circle-exclamation text-blue-500 cursor-pointer text-sm"></i>
                                <div x-show="open" x-cloak x-transition
                                    class="absolute z-10 w-64 p-3 mt-2 text-sm text-white bg-gray-800 rounded-lg shadow-xl -left-1">
                                    Unit kerja yang mengkoordinasi pencapaian target ini.
                                </div>
                            </div>
                        </div>
                        <input type="text" name="unit_penanggung_jawab" value="{{ old('unit_penanggung_jawab') }}"
                            class="w-full border-gray-200 focus:border-blue-500 focus:ring-blue-500 rounded-xl px-4 py-2.5 text-sm transition-all" 
                            placeholder="Contoh: Prodi Informatika">
                    </div>

                    {{-- Targets Section --}}
                    <div class="md:col-span-2 border-b border-gray-100 pb-2 mt-4 mb-2">
                        <h3 class="text-lg font-bold text-gray-800">Target & Klasifikasi</h3>
                    </div>

                    <div class="space-y-1">
                        <div class="flex items-center gap-1">
                            <label class="block text-sm font-semibold text-gray-700">Bobot</label>
                            <div x-data="{ open: false }" class="relative inline-block">
                                <i @click="open = !open" @click.outside="open = false"
                                    class="fa-solid fa-circle-exclamation text-blue-500 cursor-pointer text-sm"></i>
                                <div x-show="open" x-cloak x-transition
                                    class="absolute z-10 w-64 p-3 mt-2 text-sm text-white bg-gray-800 rounded-lg shadow-xl -left-1">
                                    Nilai prioritas target dalam perhitungan total kinerja (0-100).
                                </div>
                            </div>
                        </div>
                        <input type="number" name="bobot" value="{{ old('bobot', 0) }}"
                            class="w-full border-gray-200 focus:border-blue-500 focus:ring-blue-500 rounded-xl px-4 py-2.5 text-sm transition-all" 
                            placeholder="Antara 0 - 100">
                        @error('bobot')
                            <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="space-y-1">
                        <div class="flex items-center gap-1">
                            <label class="block text-sm font-semibold text-gray-700">Target (%)</label>
                            <div x-data="{ open: false }" class="relative inline-block">
                                <i @click="open = !open" @click.outside="open = false"
                                    class="fa-solid fa-circle-exclamation text-blue-500 cursor-pointer text-sm"></i>
                                <div x-show="open" x-cloak x-transition
                                    class="absolute z-10 w-64 p-3 mt-2 text-sm text-white bg-gray-800 rounded-lg shadow-xl -left-1">
                                    Persentase capaian yang diharapkan (0-100).
                                </div>
                            </div>
                        </div>
                        <input type="number" name="target_percent" value="{{ old('target_percent') }}"
                            class="w-full border-gray-200 focus:border-blue-500 focus:ring-blue-500 rounded-xl px-4 py-2.5 text-sm transition-all" 
                            placeholder="Contoh: 100">
                    </div>

                    <div class="space-y-1">
                        <div class="flex items-center gap-1">
                            <label class="block text-sm font-semibold text-gray-700">Status</label>
                            <div x-data="{ open: false }" class="relative inline-block">
                                <i @click="open = !open" @click.outside="open = false"
                                    class="fa-solid fa-circle-exclamation text-blue-500 cursor-pointer text-sm"></i>
                                <div x-show="open" x-cloak x-transition
                                    class="absolute z-10 w-64 p-3 mt-2 text-sm text-white bg-gray-800 rounded-lg shadow-xl -left-1">
                                    Level atau cakupan dari target kinerja ini.
                                </div>
                            </div>
                        </div>
                        <select name="status" class="w-full border-gray-200 focus:border-blue-500 focus:ring-blue-500 rounded-xl px-4 py-2.5 text-sm transition-all">
                            <option value="">-- Pilih Status --</option>
                            <option value="institusi" {{ old('status') == 'institusi' ? 'selected' : '' }}>Institusi</option>
                            <option value="unit" {{ old('status') == 'unit' ? 'selected' : '' }}>Unit</option>
                            <option value="pribadi" {{ old('status') == 'pribadi' ? 'selected' : '' }}>Pribadi</option>
                        </select>
                    </div>

                    <div class="space-y-1">
                        <div class="flex items-center gap-1">
                            <label class="block text-sm font-semibold text-gray-700">Tahun</label>
                            <div x-data="{ open: false }" class="relative inline-block">
                                <i @click="open = !open" @click.outside="open = false"
                                    class="fa-solid fa-circle-exclamation text-blue-500 cursor-pointer text-sm"></i>
                                <div x-show="open" x-cloak x-transition
                                    class="absolute z-10 w-64 p-3 mt-2 text-sm text-white bg-gray-800 rounded-lg shadow-xl -left-1">
                                    Tahun anggaran atau periode pelaksanaan.
                                </div>
                            </div>
                        </div>
                        <input type="number" name="tahun" value="{{ old('tahun') }}"
                            class="w-full border-gray-200 focus:border-blue-500 focus:ring-blue-500 rounded-xl px-4 py-2.5 text-sm transition-all" 
                            placeholder="Contoh: 2025" min="2000" max="2100">
                    </div>

                    {{-- Period & Dates Section --}}
                    <div class="md:col-span-2 border-b border-gray-100 pb-2 mt-4 mb-2">
                        <h3 class="text-lg font-bold text-gray-800">Waktu Pelaksanaan</h3>
                    </div>

                    <div class="space-y-1">
                        <div class="flex items-center gap-1">
                            <label class="block text-sm font-semibold text-gray-700">Periode (opsional)</label>
                            <div x-data="{ open: false }" class="relative inline-block">
                                <i @click="open = !open" @click.outside="open = false"
                                    class="fa-solid fa-circle-exclamation text-blue-500 cursor-pointer text-sm"></i>
                                <div x-show="open" x-cloak x-transition
                                    class="absolute z-10 w-64 p-3 mt-2 text-sm text-white bg-gray-800 rounded-lg shadow-xl -left-1">
                                    Keterangan tambahan waktu (misal: Kuartal 1, Semester 1).
                                </div>
                            </div>
                        </div>
                        <input type="text" name="periode" value="{{ old('periode') }}"
                            class="w-full border-gray-200 focus:border-blue-500 focus:ring-blue-500 rounded-xl px-4 py-2.5 text-sm transition-all" 
                            placeholder="Contoh: 2025 Q4">
                    </div>

                    <div class="space-y-1">
                        <div class="flex items-center gap-1">
                            <label class="block text-sm font-semibold text-gray-700">Mulai</label>
                            <div x-data="{ open: false }" class="relative inline-block">
                                <i @click="open = !open" @click.outside="open = false"
                                    class="fa-solid fa-circle-exclamation text-blue-500 cursor-pointer text-sm"></i>
                                <div x-show="open" x-cloak x-transition
                                    class="absolute z-10 w-64 p-3 mt-2 text-sm text-white bg-gray-800 rounded-lg shadow-xl -left-1">
                                    Tanggal mulai pelaksanaan target.
                                </div>
                            </div>
                        </div>
                        <input type="date" name="start" value="{{ old('start') }}"
                            class="w-full border-gray-200 focus:border-blue-500 focus:ring-blue-500 rounded-xl px-4 py-2.5 text-sm transition-all"
                            required>
                        @error('start')
                            <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="space-y-1">
                        <div class="flex items-center gap-1">
                            <label class="block text-sm font-semibold text-gray-700">Selesai</label>
                            <div x-data="{ open: false }" class="relative inline-block">
                                <i @click="open = !open" @click.outside="open = false"
                                    class="fa-solid fa-circle-exclamation text-blue-500 cursor-pointer text-sm"></i>
                                <div x-show="open" x-cloak x-transition
                                    class="absolute z-10 w-64 p-3 mt-2 text-sm text-white bg-gray-800 rounded-lg shadow-xl -left-1">
                                    Batas akhir penyelesaian target.
                                </div>
                            </div>
                        </div>
                        <input type="date" name="end" value="{{ old('end') }}"
                            class="w-full border-gray-200 focus:border-blue-500 focus:ring-blue-500 rounded-xl px-4 py-2.5 text-sm transition-all"
                            required>
                        @error('end')
                            <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Description --}}
                    <div class="md:col-span-2 space-y-1 mt-4">
                        <div class="flex items-center gap-1">
                            <label class="block text-sm font-semibold text-gray-700">Keterangan</label>
                            <div x-data="{ open: false }" class="relative inline-block">
                                <i @click="open = !open" @click.outside="open = false"
                                    class="fa-solid fa-circle-exclamation text-blue-500 cursor-pointer text-sm"></i>
                                <div x-show="open" x-cloak x-transition
                                    class="absolute z-10 w-64 p-3 mt-2 text-sm text-white bg-gray-800 rounded-lg shadow-xl -left-1">
                                    Deskripsi atau penjelasan detail mengenai target kinerja.
                                </div>
                            </div>
                        </div>
                        <textarea name="keterangan" rows="4"
                            class="w-full border-gray-200 focus:border-blue-500 focus:ring-blue-500 rounded-xl px-4 py-2.5 text-sm transition-all"
                            placeholder="Tambahkan informasi tambahan mengenai target ini...">{{ old('keterangan') }}</textarea>
                    </div>

                    <div class="md:col-span-2 pt-2">
                        <label class="inline-flex items-center cursor-pointer group">
                            <input type="checkbox" name="is_active" value="1" checked class="w-5 h-5 text-blue-600 border-gray-300 rounded focus:ring-blue-500 transition-all">
                            <span class="ml-3 text-sm font-medium text-gray-700 group-hover:text-blue-600 transition-colors">Aktifkan Target Kinerja Ini</span>
                        </label>
                    </div>
                </div>
            </div>

            {{-- Form Actions --}}
            <div class="flex items-center gap-3 pt-4 pb-8">
                <button type="submit"
                    class="inline-flex items-center gap-2 px-6 py-3 bg-blue-600 text-white text-sm font-bold rounded-xl hover:bg-blue-700 hover:shadow-lg active:scale-95 transition-all">
                    <i class="fa-solid fa-save"></i> 
                    Simpan Target Kinerja
                </button>
                <a href="{{ route('manage.target-kinerja.list') }}"
                    class="px-6 py-3 bg-white border border-gray-200 text-gray-600 text-sm font-bold rounded-xl hover:bg-gray-50 transition-all">
                    Batalkan
                </a>
            </div>
        </form>
    </div>
@endsection
