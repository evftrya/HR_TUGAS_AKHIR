@extends('kinerja_pegawai.base')

@section('page-name', 'Pengaturan Presensi')

@section('content-base')
<div class="mb-4">
    <p class="text-sm text-gray-500 italic">Konfigurasi batas waktu dan parameter kehadiran pegawai.</p>
</div>
<div class="w-full max-w-7xl mx-auto p-4 sm:p-6 lg:p-8 bg-white rounded-lg shadow-sm border border-gray-100">
    <div class="max-w-2xl">
        @if(session('success'))
            <div class="mb-6 p-4 bg-green-50 border border-green-200 text-green-700 rounded-lg flex items-center gap-3 text-sm font-medium">
                <i class="fa-solid fa-circle-check text-lg"></i>
                <span>{{ session('success') }}</span>
            </div>
        @endif

        <div class="bg-gray-50 rounded-xl border border-gray-200 overflow-hidden">
            <div class="p-6 border-b border-gray-200 bg-white flex items-center gap-4">
                <div class="w-12 h-12 rounded-lg bg-blue-100 flex items-center justify-center text-blue-600 border border-blue-200">
                    <i class="fa-solid fa-clock text-xl"></i>
                </div>
                <div>
                    <h3 class="text-lg font-bold text-gray-700">Parameter Jam Masuk</h3>
                    <p class="text-xs text-gray-400">Tentukan batas toleransi jam masuk kantor.</p>
                </div>
            </div>

            <form action="{{ route('manage.presensi.settings.update') }}" method="POST" class="p-8 space-y-6">
                @csrf
                <div class="space-y-2">
                    <label class="text-xs font-semibold text-gray-500 uppercase tracking-wider block">Maksimal Jam Masuk (HH:mm)</label>
                    <div class="relative max-w-[200px]">
                        <input type="time" name="max_check_in_time" value="{{ old('max_check_in_time', $maxCheckIn) }}"
                            class="w-full text-sm text-gray-900 border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 py-3 px-4 font-bold">
                    </div>
                    @error('max_check_in_time')
                        <p class="text-xs text-red-600 font-bold mt-1">{{ $message }}</p>
                    @enderror
                    <p class="text-xs text-gray-400 italic mt-3 leading-relaxed">
                        * Pegawai yang melakukan presensi melewati jam ini akan otomatis tercatat sebagai "Terlambat" pada laporan.
                    </p>
                </div>

                <div class="pt-6 border-t border-gray-200 flex justify-end">
                    <button type="submit"
                        class="bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium py-2 px-6 rounded-md transition duration-150 inline-flex items-center gap-2">
                        <i class="fa-solid fa-floppy-disk"></i> Simpan Pengaturan
                    </button>
                </div>
            </form>
        </div>

        <div class="mt-8 p-4 bg-blue-50 rounded-lg border border-blue-100 flex gap-3">
            <i class="fa-solid fa-circle-info text-blue-400 mt-1"></i>
            <div class="space-y-1">
                <p class="text-xs font-bold text-blue-800 uppercase">Informasi Akses</p>
                <p class="text-[11px] text-blue-700 leading-relaxed">
                    Halaman ini hanya dapat diakses oleh administrator. Perubahan parameter akan berdampak langsung pada kalkulasi laporan kedisiplinan di seluruh sistem.
                </p>
            </div>
        </div>
    </div>
</div>
@endsection
