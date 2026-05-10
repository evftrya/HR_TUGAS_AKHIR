@php
    $active_sidebar = 'Kontrak Manajemen (KM) & Sasaran Mutu (SM)';
@endphp

@extends('kinerja_pegawai.base')

@section('header-base')
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
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
            <h2 class="text-2xl font-bold text-[#101828]">Tambah Kontrak Manajemen (KM) & Sasaran Mutu (SM)</h2>
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
                            <label class="block text-sm font-semibold text-gray-700">Responsibility (Indikator)</label>
                            <div x-data="{ open: false }" class="relative inline-block">
                                <i @click="open = !open" @click.outside="open = false"
                                    class="fa-solid fa-circle-exclamation text-blue-500 cursor-pointer text-sm"></i>
                                <div x-show="open" x-cloak x-transition
                                    class="absolute z-10 w-64 p-3 mt-2 text-sm text-white bg-gray-800 rounded-lg shadow-xl -left-1">
                                    Nama indikator kinerja utama yang ingin dicapai.
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
                            <label class="block text-sm font-semibold text-gray-700">Unit</label>
                        </div>
                        <select name="responsibility_id" class="w-full border-gray-200 focus:border-blue-500 focus:ring-blue-500 rounded-xl px-4 py-2.5 text-sm transition-all">
                            <option value="">-- Pilih Unit --</option>
                            @foreach(\App\Models\Unit::orderBy('nama_unit')->get() as $unit)
                                <option value="{{ $unit->id }}" {{ old('responsibility_id') == $unit->id ? 'selected' : '' }}>{{ $unit->nama_unit }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="space-y-1">
                        <div class="flex items-center gap-1">
                            <label class="block text-sm font-semibold text-gray-700">Satuan</label>
                        </div>
                        <select name="satuan" class="w-full border-gray-200 focus:border-blue-500 focus:ring-blue-500 rounded-xl px-4 py-2.5 text-sm transition-all">
                            <option value="">-- Pilih Satuan --</option>
                            <option value="%" {{ old('satuan') == '%' ? 'selected' : '' }}>%</option>
                            <option value="Orang" {{ old('satuan') == 'Orang' ? 'selected' : '' }}>Orang</option>
                            <option value="Jumlah" {{ old('satuan') == 'Jumlah' ? 'selected' : '' }}>Jumlah</option>
                            <option value="Skor" {{ old('satuan') == 'Skor' ? 'selected' : '' }}>Skor</option>
                        </select>
                    </div>

                    <div class="space-y-1">
                        <div class="flex items-center gap-1">
                            <label class="block text-sm font-semibold text-gray-700">Jenis Indikator</label>
                        </div>
                        <select name="jenis" class="w-full border-gray-200 focus:border-blue-500 focus:ring-blue-500 rounded-xl px-4 py-2.5 text-sm transition-all">
                            <option value="">-- Pilih Jenis --</option>
                            <option value="Kontrak Manajemen" {{ old('jenis') == 'Kontrak Manajemen' ? 'selected' : '' }}>Kontrak Manajemen</option>
                            <option value="Sasaran Mutu" {{ old('jenis') == 'Sasaran Mutu' ? 'selected' : '' }}>Sasaran Mutu</option>
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
                        <input type="number" name="tahun" value="{{ old('tahun', date('Y')) }}"
                            class="w-full border-gray-200 focus:border-blue-500 focus:ring-blue-500 rounded-xl px-4 py-2.5 text-sm transition-all"
                            placeholder="Contoh: 2025" min="2000" max="2100">
                    </div>

                    {{-- Triwulan Targets Section --}}
                    <div class="md:col-span-2 border-b border-gray-100 pb-2 mt-4 mb-2">
                        <h3 class="text-lg font-bold text-gray-800">Target & Bobot Triwulan (KM & SM)</h3>
                        <p class="text-xs text-gray-500 italic">Isi 0 jika tidak ada target pada triwulan tersebut.</p>
                    </div>

                    <div class="md:col-span-2 grid grid-cols-2 md:grid-cols-4 gap-4">
                        @foreach(['tw1' => 'TW I', 'tw2' => 'TW II', 'tw3' => 'TW III', 'tw4' => 'TW IV'] as $key => $label)
                            <div class="p-4 bg-gray-50 rounded-2xl border border-gray-100 space-y-3">
                                <p class="text-xs font-bold text-blue-600 uppercase">{{ $label }}</p>
                                <div class="space-y-1">
                                    <label class="text-[10px] font-bold text-gray-400 uppercase">Target</label>
                                    <input type="number" step="0.01" name="{{ $key }}_target" value="{{ old($key.'_target', 0) }}"
                                        class="w-full border-gray-200 focus:border-blue-500 rounded-lg px-3 py-1.5 text-xs">
                                </div>
                                <div class="space-y-1">
                                    <label class="text-[10px] font-bold text-gray-400 uppercase">Bobot</label>
                                    <input type="number" step="0.01" name="{{ $key }}_bobot" value="{{ old($key.'_bobot', 0) }}"
                                        class="w-full border-gray-200 focus:border-blue-500 rounded-lg px-3 py-1.5 text-xs">
                                </div>
                            </div>
                        @endforeach
                    </div>

                    {{-- Removed Redundant Fields --}}

                    {{-- Description --}}
                    <div class="md:col-span-2 space-y-1 mt-4">
                        <div class="flex items-center gap-1">
                            <label class="block text-sm font-semibold text-gray-700">Keterangan</label>
                            <div x-data="{ open: false }" class="relative inline-block">
                                <i @click="open = !open" @click.outside="open = false"
                                    class="fa-solid fa-circle-exclamation text-blue-500 cursor-pointer text-sm"></i>
                                <div x-show="open" x-cloak x-transition
                                    class="absolute z-10 w-64 p-3 mt-2 text-sm text-white bg-gray-800 rounded-lg shadow-xl -left-1">
                                    Deskripsi atau penjelasan detail mengenai KM & SM.
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
                            <span class="ml-3 text-sm font-medium text-gray-700 group-hover:text-blue-600 transition-colors">Aktifkan KM & SM Ini</span>
                        </label>
                    </div>
                </div>
            </div>

            {{-- Form Actions --}}
            <div class="flex items-center gap-3 pt-4 pb-8">
                <button type="submit"
                    class="inline-flex items-center gap-2 px-6 py-3 bg-blue-600 text-white text-sm font-bold rounded-xl hover:bg-blue-700 hover:shadow-lg active:scale-95 transition-all">
                    <i class="fa-solid fa-save"></i>
                    Simpan KM & SM
                </button>
                <a href="{{ route('manage.target-kinerja.list') }}"
                    class="px-6 py-3 bg-white border border-gray-200 text-gray-600 text-sm font-bold rounded-xl hover:bg-gray-50 transition-all">
                    Batalkan
                </a>
            </div>
        </form>
    </div>
@endsection
