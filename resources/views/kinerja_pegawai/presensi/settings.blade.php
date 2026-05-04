@extends('kinerja_pegawai.base')

@section('page-name')
    <div class="flex flex-col gap-[3px] px-1 pt-3 pb-2">
        <span class="font-semibold text-2xl text-[#101828]">Pengaturan Presensi</span>
        <span class="text-xs text-gray-400">Konfigurasi batas waktu dan parameter kehadiran pegawai</span>
    </div>
@endsection

@section('content-base')
    <div class="max-w-2xl">
        @if(session('success'))
            <div class="mb-4 p-4 bg-emerald-50 border border-emerald-100 text-emerald-700 rounded-2xl flex items-center gap-3">
                <i class="fa-solid fa-circle-check text-lg"></i>
                <span class="text-sm font-bold">{{ session('success') }}</span>
            </div>
        @endif

        <div class="bg-white rounded-3xl border border-gray-100 shadow-sm overflow-hidden">
            <div class="p-8 border-b border-gray-50 flex items-center gap-4">
                <div class="w-12 h-12 rounded-full bg-blue-50 flex items-center justify-center text-blue-600">
                    <i class="fa-solid fa-clock text-xl"></i>
                </div>
                <div>
                    <h3 class="text-lg font-bold text-gray-900">Parameter Jam Masuk</h3>
                    <p class="text-xs text-gray-400">Tentukan batas toleransi jam masuk kantor</p>
                </div>
            </div>

            <form action="{{ route('manage.presensi.settings.update') }}" method="POST" class="p-8 space-y-6">
                @csrf
                <div class="space-y-2">
                    <label class="text-[10px] font-bold text-gray-400 uppercase tracking-widest block">Maksimal Jam Masuk (HH:mm)</label>
                    <div class="relative max-w-[200px]">
                        <input type="time" name="max_check_in_time" value="{{ old('max_check_in_time', $maxCheckIn) }}"
                            class="w-full border-gray-100 bg-gray-50 focus:bg-white focus:border-blue-500 focus:ring-blue-500 rounded-2xl px-5 py-4 text-xl transition-all font-black text-gray-900">
                    </div>
                    @error('max_check_in_time')
                        <p class="text-xs text-red-500 font-bold mt-1">{{ $message }}</p>
                    @enderror
                    <p class="text-[10px] text-gray-400 leading-relaxed italic mt-2">
                        * Pegawai yang melakukan presensi melewati jam ini akan otomatis tercatat sebagai "Terlambat" pada laporan bulanan.
                    </p>
                </div>

                <div class="pt-6 border-t border-gray-50">
                    <button type="submit"
                        class="w-full sm:w-auto inline-flex items-center justify-center gap-2 px-10 py-4 bg-blue-600 text-white text-sm font-black rounded-2xl hover:bg-blue-700 shadow-lg shadow-blue-100 active:scale-95 transition-all">
                        <i class="fa-solid fa-floppy-disk"></i>
                        SIMPAN PENGATURAN
                    </button>
                </div>
            </form>
        </div>

        <div class="mt-8 bg-blue-50 rounded-2xl p-5 border border-blue-100 flex gap-4">
            <i class="fa-solid fa-circle-info text-blue-400 mt-1"></i>
            <div class="space-y-1">
                <p class="text-[11px] font-black text-blue-900 uppercase">Informasi Akses</p>
                <p class="text-[10px] text-blue-700 leading-relaxed font-medium">
                    Halaman pengaturan ini hanya dapat diakses oleh administrator sistem. Perubahan pada parameter ini akan langsung berdampak pada kalkulasi laporan keterlambatan di seluruh sistem.
                </p>
            </div>
        </div>
    </div>
@endsection
