@php
    $active_sidebar = 'Target Kinerja';
@endphp

@extends('kinerja_pegawai.base')

@section('page-name', 'Isi Laporan Pekerjaan')

@section('content-base')
<div class="mb-4">
    <p class="text-sm text-gray-500 italic">{{ $target->pekerjaan }}</p>
</div>
<div class="w-full max-w-7xl mx-auto p-4 sm:p-6 lg:p-8 bg-white rounded-lg shadow-sm border border-gray-100">
    <form action="{{ route('manage.target-kinerja.harian.submit-report', $target->id) }}" method="POST" class="space-y-8">
        @csrf

        {{-- Section 1: Narasi Realisasi --}}
        <div class="bg-gray-50 p-6 rounded-xl border border-gray-200">
            <h3 class="text-lg font-semibold text-gray-700 mb-4 border-l-4 border-blue-600 pl-4 uppercase tracking-tight">Realisasi Pekerjaan</h3>
            <div>
                <label class="block text-sm font-medium text-gray-600 mb-2">Deskripsi Realisasi</label>
                <textarea name="realisasi" rows="5" required
                    class="w-full text-sm text-gray-900 border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"
                    placeholder="Uraikan hasil pengerjaan Anda secara detail...">{{ old('realisasi') }}</textarea>
                <p class="text-[10px] text-gray-400 italic mt-2">* Wajib diisi sebagai bahan pertimbangan validasi atasan.</p>
            </div>
        </div>

        {{-- Section 2: Angka Realisasi --}}
        <div class="bg-gray-50 p-6 rounded-xl border border-gray-200">
            <h3 class="text-lg font-semibold text-gray-700 mb-6 border-l-4 border-emerald-600 pl-4 uppercase tracking-tight">Data Capaian & Waktu</h3>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div>
                    <label class="block text-sm font-medium text-gray-600 mb-2">Jumlah Capaian (Qty)</label>
                    <input type="number" name="realisasi_jumlah" value="{{ old('realisasi_jumlah', 1) }}" required
                        class="w-full text-sm text-gray-900 border-gray-300 rounded-md shadow-sm focus:ring-blue-500">
                    <span class="text-[10px] text-gray-400 italic">Contoh: 1 (Satu Berkas)</span>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-600 mb-2">Pencapaian (%)</label>
                    <input type="number" name="pencapaian_percent" value="{{ old('pencapaian_percent', 100) }}" required
                        class="w-full text-sm text-gray-900 border-gray-300 rounded-md shadow-sm focus:ring-blue-500"
                        min="0" max="100">
                    <span class="text-[10px] text-gray-400 italic">Progress pengerjaan tugas.</span>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-600 mb-2">Waktu Pengerjaan (Menit)</label>
                    <input type="number" name="waktu_pengerjaan" value="{{ old('waktu_pengerjaan', $target->waktu_minutes) }}" required
                        class="w-full text-sm text-gray-900 border-gray-300 rounded-md shadow-sm focus:ring-blue-500"
                        placeholder="Contoh: 60">
                    <span class="text-[10px] text-gray-400 italic">Klaim durasi yang Anda habiskan.</span>
                </div>
            </div>
        </div>

        {{-- Section 3: Evidence --}}
        <div class="bg-gray-50 p-6 rounded-xl border border-gray-200">
            <h3 class="text-lg font-semibold text-gray-700 mb-4 border-l-4 border-amber-600 pl-4 uppercase tracking-tight">Bukti Pengerjaan (Evidence)</h3>
            <div>
                <label class="block text-sm font-medium text-gray-600 mb-2">Link Evidence / Bukti</label>
                <input type="text" name="evidence" value="{{ old('evidence') }}"
                    class="w-full text-sm text-gray-900 border-gray-300 rounded-md shadow-sm focus:ring-blue-500"
                    placeholder="https://drive.google.com/...">
                <p class="text-[10px] text-gray-400 italic mt-2">* Lampirkan link dokumen, foto, atau folder pekerjaan di cloud storage.</p>
            </div>
        </div>

        {{-- hidden field for backward compatibility if needed --}}
        <input type="hidden" name="realisasi_waktu_minutes" value="{{ old('waktu_pengerjaan', $target->waktu_minutes) }}">

        {{-- Form Actions --}}
        <div class="flex justify-end gap-3 pt-8 border-t border-gray-100">
            <a href="{{ route('manage.target-kinerja.harian.list') }}" 
                class="bg-white border border-gray-300 text-gray-700 hover:bg-gray-50 text-sm font-medium py-2.5 px-6 rounded-md transition duration-150">
                Batalkan
            </a>
            <button type="submit" 
                class="bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium py-2.5 px-10 rounded-md transition duration-150 shadow-sm">
                Kirim Laporan Kinerja
            </button>
        </div>
    </form>
</div>
@endsection
