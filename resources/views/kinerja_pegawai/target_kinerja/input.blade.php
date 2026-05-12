@php
    $active_sidebar = 'Kontrak Manajemen (KM) & Sasaran Mutu (SM)';
@endphp

@extends('kinerja_pegawai.base')

@section('header-base')
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
@endsection

@section('page-name', 'Tambah KM & Sasaran Mutu')

@section('content-base')
<div class="mb-4">
    <p class="text-sm text-gray-500 italic">Buat template KPI global baru untuk didistribusikan ke unit kerja.</p>
</div>
<div class="w-full max-w-7xl mx-auto p-4 sm:p-6 lg:p-8 bg-white rounded-lg shadow-sm border border-gray-100">
    <form action="{{ route('manage.target-kinerja.store') }}" method="POST" class="space-y-8">
        @csrf

        {{-- Section 1: Informasi Utama --}}
        <div class="bg-gray-50 p-6 rounded-xl border border-gray-200">
            <h3 class="text-lg font-semibold text-gray-700 mb-6 border-l-4 border-blue-600 pl-4">Informasi Utama</h3>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-600 mb-2">Responsibility (Nama Indikator KPI)</label>
                    <input type="text" name="nama_kpi" value="{{ old('nama_kpi') }}" required
                        class="w-full text-sm text-gray-900 border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 py-2.5"
                        placeholder="Contoh: Meningkatkan Publikasi Internasional Scopus Q1">
                    @error('nama_kpi') <p class="text-xs text-red-600 mt-1 font-bold">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-600 mb-2">Unit Penanggung Jawab</label>
                    <select name="responsibility_id" required class="w-full text-sm text-gray-900 border-gray-300 rounded-md shadow-sm focus:ring-blue-500">
                        <option value="">-- Pilih Unit --</option>
                        @foreach(\App\Models\Unit::orderBy('nama_unit')->get() as $unit)
                            <option value="{{ $unit->id }}" {{ old('responsibility_id') == $unit->id ? 'selected' : '' }}>{{ $unit->nama_unit }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-600 mb-2">Satuan Ukur</label>
                    <select name="satuan" required class="w-full text-sm text-gray-900 border-gray-300 rounded-md shadow-sm focus:ring-blue-500">
                        <option value="">-- Pilih Satuan --</option>
                        <option value="%" {{ old('satuan') == '%' ? 'selected' : '' }}>Persentase (%)</option>
                        <option value="Orang" {{ old('satuan') == 'Orang' ? 'selected' : '' }}>Orang</option>
                        <option value="Jumlah" {{ old('satuan') == 'Jumlah' ? 'selected' : '' }}>Jumlah / Dokumen</option>
                        <option value="Skor" {{ old('satuan') == 'Skor' ? 'selected' : '' }}>Skor / Indeks</option>
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-600 mb-2">Jenis Indikator</label>
                    <select name="jenis" required class="w-full text-sm text-gray-900 border-gray-300 rounded-md shadow-sm focus:ring-blue-500">
                        <option value="">-- Pilih Jenis --</option>
                        <option value="Kontrak Manajemen" {{ old('jenis') == 'Kontrak Manajemen' ? 'selected' : '' }}>Kontrak Manajemen (KM)</option>
                        <option value="Sasaran Mutu" {{ old('jenis') == 'Sasaran Mutu' ? 'selected' : '' }}>Sasaran Mutu (SM)</option>
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-600 mb-2">Tahun Anggaran</label>
                    <input type="number" name="tahun" value="{{ old('tahun', date('Y')) }}" required
                        class="w-full text-sm text-gray-900 border-gray-300 rounded-md shadow-sm focus:ring-blue-500 py-2.5"
                        min="2000" max="2100">
                </div>
            </div>
        </div>

        {{-- Section 2: Target Triwulan --}}
        <div class="bg-gray-50 p-6 rounded-xl border border-gray-200">
            <h3 class="text-lg font-semibold text-gray-700 mb-2 border-l-4 border-emerald-600 pl-4">Target & Bobot Triwulan</h3>
            <p class="text-xs text-gray-400 italic mb-6">Tentukan target pencapaian dan bobot nilai untuk setiap triwulan (isi 0 jika tidak ada).</p>
            
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                @foreach(['tw1' => 'Triwulan I', 'tw2' => 'Triwulan II', 'tw3' => 'Triwulan III', 'tw4' => 'Triwulan IV'] as $key => $label)
                    <div class="bg-white p-4 rounded-lg border border-gray-200 shadow-sm space-y-4">
                        <p class="text-xs font-black text-blue-600 uppercase tracking-widest">{{ $label }}</p>
                        <div class="space-y-1">
                            <label class="text-[10px] font-bold text-gray-400 uppercase">Target Angka</label>
                            <input type="number" step="0.01" name="{{ $key }}_target" value="{{ old($key.'_target', 0) }}"
                                class="w-full text-sm text-gray-900 border-gray-300 rounded-md focus:ring-blue-500">
                        </div>
                        <div class="space-y-1">
                            <label class="text-[10px] font-bold text-gray-400 uppercase">Bobot (%)</label>
                            <input type="number" step="0.01" name="{{ $key }}_bobot" value="{{ old($key.'_bobot', 0) }}"
                                class="w-full text-sm text-gray-900 border-gray-300 rounded-md focus:ring-blue-500">
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        {{-- Section 3: Keterangan --}}
        <div class="space-y-6">
            <div>
                <label class="block text-sm font-medium text-gray-600 mb-2">Keterangan / Deskripsi KPI</label>
                <textarea name="keterangan" rows="4"
                    class="w-full text-sm text-gray-900 border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"
                    placeholder="Tambahkan informasi detail atau kriteria keberhasilan indikator ini...">{{ old('keterangan') }}</textarea>
            </div>

            <div class="flex items-center">
                <input type="checkbox" name="is_active" value="1" id="is_active" checked 
                    class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                <label for="is_active" class="ml-2 block text-sm font-medium text-gray-700">
                    Aktifkan indikator KPI ini segera setelah disimpan
                </label>
            </div>
        </div>

        {{-- Form Actions --}}
        <div class="flex justify-end gap-3 pt-8 border-t border-gray-100">
            <a href="{{ route('manage.target-kinerja.list') }}" 
                class="bg-white border border-gray-300 text-gray-700 hover:bg-gray-50 text-sm font-medium py-2.5 px-6 rounded-md transition duration-150">
                Batalkan
            </a>
            <button type="submit" 
                class="bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium py-2.5 px-8 rounded-md transition duration-150 shadow-sm">
                Simpan KM & Sasaran Mutu
            </button>
        </div>
    </form>
</div>
@endsection
