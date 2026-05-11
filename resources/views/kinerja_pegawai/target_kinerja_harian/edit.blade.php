@php
    $active_sidebar = 'Target Kinerja';
@endphp

@extends('kinerja_pegawai.base')

@section('header-base')
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
@endsection

@section('page-name', 'Edit Target Kinerja Individu')

@section('content-base')
<div class="w-full max-w-7xl mx-auto p-4 sm:p-6 lg:p-8 bg-white rounded-lg shadow-sm border border-gray-100">
    <div class="mb-4">
        <p class="text-sm text-gray-500 italic">Perbarui rincian target pekerjaan individu.</p>
    </div>

    <form action="{{ route('manage.target-kinerja.harian.update', $harian->id) }}" method="POST" class="space-y-8">
        @csrf
        @method('PUT')

        {{-- Section 1: Detail Pekerjaan --}}
        <div class="bg-gray-50 p-6 rounded-xl border border-gray-200">
            <h3 class="text-lg font-semibold text-gray-700 mb-6 border-l-4 border-blue-600 pl-4 uppercase tracking-tight">Detail Pekerjaan</h3>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-600 mb-2">Nama Pekerjaan / Tugas</label>
                    <input type="text" name="pekerjaan" value="{{ old('pekerjaan', $harian->pekerjaan) }}" required
                        class="w-full text-sm text-gray-900 border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 py-2.5"
                        placeholder="Contoh: Penyusunan Laporan Keuangan Bulanan">
                    @error('pekerjaan') <p class="text-xs text-red-600 mt-1 font-bold">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-600 mb-2">Induk KM / Sasaran Mutu</label>
                    <select name="target_kinerja_id" required class="w-full text-sm text-gray-900 border-gray-300 rounded-md shadow-sm focus:ring-blue-500">
                        <option value="">-- Pilih Master KPI --</option>
                        @foreach($targets as $t)
                            <option value="{{ $t->id }}" {{ old('target_kinerja_id', $harian->target_kinerja_id) == $t->id ? 'selected' : '' }}>
                                [{{ $t->jenis }}] {{ $t->nama_kpi }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-600 mb-2">Tipe Kontrak</label>
                    <select name="kontrak_type" required class="w-full text-sm text-gray-900 border-gray-300 rounded-md shadow-sm focus:ring-blue-500">
                        <option value="pribadi" {{ old('kontrak_type', $harian->kontrak_type) == 'pribadi' ? 'selected' : '' }}>Tugas Pribadi</option>
                        <option value="tambahan" {{ old('kontrak_type', $harian->kontrak_type) == 'tambahan' ? 'selected' : '' }}>Tugas Tambahan</option>
                    </select>
                </div>
            </div>
        </div>

        {{-- Section 2: Parameter Output --}}
        <div class="bg-gray-50 p-6 rounded-xl border border-gray-200">
            <h3 class="text-lg font-semibold text-gray-700 mb-6 border-l-4 border-emerald-600 pl-4 uppercase tracking-tight">Parameter Output & Waktu</h3>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div>
                    <label class="block text-sm font-medium text-gray-600 mb-2">Satuan Output</label>
                    <input type="text" name="result" value="{{ old('result', $harian->result) }}" required
                        class="w-full text-sm text-gray-900 border-gray-300 rounded-md shadow-sm focus:ring-blue-500 py-2.5"
                        placeholder="Contoh: Dokumen / Berkas">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-600 mb-2">Target Jumlah</label>
                    <input type="number" name="jumlah" value="{{ old('jumlah', $harian->jumlah) }}" required
                        class="w-full text-sm text-gray-900 border-gray-300 rounded-md shadow-sm focus:ring-blue-500 py-2.5">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-600 mb-2">Alokasi Waktu (Menit)</label>
                    <input type="number" name="waktu_minutes" value="{{ old('waktu_minutes', $harian->waktu_minutes) }}" required
                        class="w-full text-sm text-gray-900 border-gray-300 rounded-md shadow-sm focus:ring-blue-500 py-2.5">
                </div>
            </div>
        </div>

        {{-- Section 3: Periode --}}
        <div class="bg-gray-50 p-6 rounded-xl border border-gray-200">
            <h3 class="text-lg font-semibold text-gray-700 mb-6 border-l-4 border-amber-600 pl-4 uppercase tracking-tight">Periode Pelaksanaan</h3>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-medium text-gray-600 mb-2">Waktu Mulai</label>
                    <input type="datetime-local" name="start" value="{{ old('start', $harian->start ? date('Y-m-d\TH:i', strtotime($harian->start)) : '') }}" required
                        class="w-full text-sm text-gray-900 border-gray-300 rounded-md shadow-sm focus:ring-blue-500 py-2.5">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-600 mb-2">Waktu Selesai</label>
                    <input type="datetime-local" name="end" value="{{ old('end', $harian->end ? date('Y-m-d\TH:i', strtotime($harian->end)) : '') }}" required
                        class="w-full text-sm text-gray-900 border-gray-300 rounded-md shadow-sm focus:ring-blue-500 py-2.5">
                </div>
            </div>
        </div>

        {{-- Form Actions --}}
        <div class="flex justify-end gap-3 pt-8 border-t border-gray-100">
            <a href="{{ route('manage.target-kinerja.harian.list') }}" 
                class="bg-white border border-gray-300 text-gray-700 hover:bg-gray-50 text-sm font-medium py-2.5 px-6 rounded-md transition duration-150">
                Batalkan
            </a>
            <button type="submit" 
                class="bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium py-2.5 px-8 rounded-md transition duration-150 shadow-sm">
                Perbarui Target Individu
            </button>
        </div>
    </form>
</div>
@endsection
