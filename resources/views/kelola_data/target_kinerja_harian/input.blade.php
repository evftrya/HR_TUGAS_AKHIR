@php
    $active_sidebar = 'Target Kinerja';
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
            <h2 class="text-2xl font-bold text-[#101828]">Tambah Target Kinerja Harian</h2>
            <p class="text-sm text-gray-500">Buat target harian baru untuk pemantauan rutin</p>
        </div>
    </div>
@endsection

@section('content-base')
    <div class="w-full">
        <form action="{{ route('manage.target-kinerja.harian.store') }}" method="POST" class="space-y-6">
            @csrf

            <div class="form-card p-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-x-8 gap-y-6">

                    {{-- Basic Information Section --}}
                    <div class="md:col-span-2 border-b border-gray-100 pb-2 mb-2">
                        <h3 class="text-lg font-bold text-gray-800">Informasi Pekerjaan</h3>
                    </div>

                    <div class="space-y-1">
                        <div class="flex items-center gap-1">
                            <label class="block text-sm font-semibold text-gray-700">Pekerjaan</label>
                            <div x-data="{ open: false }" class="relative inline-block">
                                <i @click="open = !open" @click.outside="open = false"
                                    class="fa-solid fa-circle-exclamation text-blue-500 cursor-pointer text-sm"></i>
                                <div x-show="open" x-cloak x-transition
                                    class="absolute z-10 w-64 p-3 mt-2 text-sm text-white bg-gray-800 rounded-lg shadow-xl -left-1">
                                    Deskripsi singkat pekerjaan harian yang dilakukan.
                                </div>
                            </div>
                        </div>
                        <input type="text" name="pekerjaan" value="{{ old('pekerjaan') }}"
                            class="w-full border-gray-200 focus:border-blue-500 focus:ring-blue-500 rounded-xl px-4 py-2.5 text-sm transition-all"
                            placeholder="Contoh: Mengoreksi Berkas Administrasi" required>
                        @error('pekerjaan')
                            <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="space-y-1">
                        <div class="flex items-center gap-1">
                            <label class="block text-sm font-semibold text-gray-700">Induk KPI (Opsional)</label>
                            <div x-data="{ open: false }" class="relative inline-block">
                                <i @click="open = !open" @click.outside="open = false"
                                    class="fa-solid fa-circle-exclamation text-blue-500 cursor-pointer text-sm"></i>
                                <div x-show="open" x-cloak x-transition
                                    class="absolute z-10 w-64 p-3 mt-2 text-sm text-white bg-gray-800 rounded-lg shadow-xl -left-1">
                                    Hubungkan pekerjaan ini dengan target kinerja utama.
                                </div>
                            </div>
                        </div>
                        <select name="target_kinerja_id" class="w-full border-gray-200 focus:border-blue-500 focus:ring-blue-500 rounded-xl px-4 py-2.5 text-sm transition-all">
                            <option value="">-- Tanpa Induk KPI (Opsional) --</option>
                            @foreach ($targets as $t)
                                <option value="{{ $t->id }}">{{ $t->nama_kpi }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="space-y-1">
                        <div class="flex items-center gap-1">
                            <label class="block text-sm font-semibold text-gray-700">Kontrak Type</label>
                            <div x-data="{ open: false }" class="relative inline-block">
                                <i @click="open = !open" @click.outside="open = false"
                                    class="fa-solid fa-circle-exclamation text-blue-500 cursor-pointer text-sm"></i>
                                <div x-show="open" x-cloak x-transition
                                    class="absolute z-10 w-64 p-3 mt-2 text-sm text-white bg-gray-800 rounded-lg shadow-xl -left-1">
                                    Kategori kontrak dari pekerjaan harian ini.
                                </div>
                            </div>
                        </div>
                        <select name="kontrak_type" class="w-full border-gray-200 focus:border-blue-500 focus:ring-blue-500 rounded-xl px-4 py-2.5 text-sm transition-all">
                            <option value="">-- Pilih Kontrak Type --</option>
                            <option value="institusi" {{ old('kontrak_type')=='institusi' ? 'selected' : '' }}>Institusi</option>
                            <option value="unit" {{ old('kontrak_type')=='unit' ? 'selected' : '' }}>Unit</option>
                            <option value="pribadi" {{ old('kontrak_type')=='pribadi' ? 'selected' : '' }}>Pribadi</option>
                        </select>
                    </div>

                    <div class="space-y-1">
                        <div class="flex items-center gap-1">
                            <label class="block text-sm font-semibold text-gray-700">Hasil / Result</label>
                            <div x-data="{ open: false }" class="relative inline-block">
                                <i @click="open = !open" @click.outside="open = false"
                                    class="fa-solid fa-circle-exclamation text-blue-500 cursor-pointer text-sm"></i>
                                <div x-show="open" x-cloak x-transition
                                    class="absolute z-10 w-64 p-3 mt-2 text-sm text-white bg-gray-800 rounded-lg shadow-xl -left-1">
                                    Target hasil akhir yang ingin dicapai.
                                </div>
                            </div>
                        </div>
                        <input type="text" name="result" value="{{ old('result') }}"
                            class="w-full border-gray-200 focus:border-blue-500 focus:ring-blue-500 rounded-xl px-4 py-2.5 text-sm transition-all"
                            placeholder="Contoh: Dokumen laporan selesai">
                    </div>

                    {{-- Targets & Metrics Section --}}
                    <div class="md:col-span-2 border-b border-gray-100 pb-2 mt-4 mb-2">
                        <h3 class="text-lg font-bold text-gray-800">Target & Metrik</h3>
                    </div>

                    <div class="space-y-1">
                        <div class="flex items-center gap-1">
                            <label class="block text-sm font-semibold text-gray-700">Jumlah</label>
                            <div x-data="{ open: false }" class="relative inline-block">
                                <i @click="open = !open" @click.outside="open = false"
                                    class="fa-solid fa-circle-exclamation text-blue-500 cursor-pointer text-sm"></i>
                                <div x-show="open" x-cloak x-transition
                                    class="absolute z-10 w-64 p-3 mt-2 text-sm text-white bg-gray-800 rounded-lg shadow-xl -left-1">
                                    Kuantitas atau volume pekerjaan yang ditargetkan.
                                </div>
                            </div>
                        </div>
                        <input type="number" name="jumlah" value="{{ old('jumlah') }}"
                            class="w-full border-gray-200 focus:border-blue-500 focus:ring-blue-500 rounded-xl px-4 py-2.5 text-sm transition-all"
                            placeholder="Contoh: 10">
                    </div>

                    <div class="space-y-1">
                        <div class="flex items-center gap-1">
                            <label class="block text-sm font-semibold text-gray-700">Waktu (menit)</label>
                            <div x-data="{ open: false }" class="relative inline-block">
                                <i @click="open = !open" @click.outside="open = false"
                                    class="fa-solid fa-circle-exclamation text-blue-500 cursor-pointer text-sm"></i>
                                <div x-show="open" x-cloak x-transition
                                    class="absolute z-10 w-64 p-3 mt-2 text-sm text-white bg-gray-800 rounded-lg shadow-xl -left-1">
                                    Estimasi total waktu pengerjaan dalam menit.
                                </div>
                            </div>
                        </div>
                        <input type="number" name="waktu_minutes" value="{{ old('waktu_minutes') }}"
                            class="w-full border-gray-200 focus:border-blue-500 focus:ring-blue-500 rounded-xl px-4 py-2.5 text-sm transition-all"
                            placeholder="Contoh: 120">
                    </div>

                    <div class="space-y-1">
                        <div class="flex items-center gap-1">
                            <label class="block text-sm font-semibold text-gray-700">Bobot</label>
                            <div x-data="{ open: false }" class="relative inline-block">
                                <i @click="open = !open" @click.outside="open = false"
                                    class="fa-solid fa-circle-exclamation text-blue-500 cursor-pointer text-sm"></i>
                                <div x-show="open" x-cloak x-transition
                                    class="absolute z-10 w-64 p-3 mt-2 text-sm text-white bg-gray-800 rounded-lg shadow-xl -left-1">
                                    Nilai kepentingan relatif pekerjaan ini.
                                </div>
                            </div>
                        </div>
                        <input type="number" name="bobot" value="{{ old('bobot') }}"
                            class="w-full border-gray-200 focus:border-blue-500 focus:ring-blue-500 rounded-xl px-4 py-2.5 text-sm transition-all"
                            placeholder="Contoh: 5">
                    </div>

                    <div class="flex items-center pt-6">
                        <label class="inline-flex items-center cursor-pointer group">
                            <input type="checkbox" id="is_active" name="is_active" value="1" {{ old('is_active') ? 'checked' : 'checked' }}
                                class="w-5 h-5 text-blue-600 border-gray-300 rounded focus:ring-blue-500 transition-all">
                            <span class="ml-3 text-sm font-medium text-gray-700 group-hover:text-blue-600 transition-colors">Aktifkan Target Harian Ini</span>
                        </label>
                    </div>

                    {{-- Schedule Section --}}
                    <div class="md:col-span-2 border-b border-gray-100 pb-2 mt-4 mb-2">
                        <h3 class="text-lg font-bold text-gray-800">Jadwal Pelaksanaan</h3>
                    </div>

                    <div class="space-y-1">
                        <div class="flex items-center gap-1">
                            <label class="block text-sm font-semibold text-gray-700">Mulai</label>
                            <div x-data="{ open: false }" class="relative inline-block">
                                <i @click="open = !open" @click.outside="open = false"
                                    class="fa-solid fa-circle-exclamation text-blue-500 cursor-pointer text-sm"></i>
                                <div x-show="open" x-cloak x-transition
                                    class="absolute z-10 w-64 p-3 mt-2 text-sm text-white bg-gray-800 rounded-lg shadow-xl -left-1">
                                    Waktu pengerjaan dimulai.
                                </div>
                            </div>
                        </div>
                        <input type="datetime-local" name="start" value="{{ old('start') }}"
                            class="w-full border-gray-200 focus:border-blue-500 focus:ring-blue-500 rounded-xl px-4 py-2.5 text-sm transition-all">
                    </div>

                    <div class="space-y-1">
                        <div class="flex items-center gap-1">
                            <label class="block text-sm font-semibold text-gray-700">Selesai</label>
                            <div x-data="{ open: false }" class="relative inline-block">
                                <i @click="open = !open" @click.outside="open = false"
                                    class="fa-solid fa-circle-exclamation text-blue-500 cursor-pointer text-sm"></i>
                                <div x-show="open" x-cloak x-transition
                                    class="absolute z-10 w-64 p-3 mt-2 text-sm text-white bg-gray-800 rounded-lg shadow-xl -left-1">
                                    Estimasi waktu pengerjaan berakhir.
                                </div>
                            </div>
                        </div>
                        <input type="datetime-local" name="end" value="{{ old('end') }}"
                            class="w-full border-gray-200 focus:border-blue-500 focus:ring-blue-500 rounded-xl px-4 py-2.5 text-sm transition-all">
                    </div>
                </div>
            </div>

            {{-- Form Actions --}}
            <div class="flex items-center gap-3 pt-4 pb-8">
                <button type="submit"
                    class="inline-flex items-center gap-2 px-6 py-3 bg-blue-600 text-white text-sm font-bold rounded-xl hover:bg-blue-700 hover:shadow-lg active:scale-95 transition-all">
                    <i class="fa-solid fa-save"></i>
                    Simpan Target Harian
                </button>
                <a href="{{ route('manage.target-kinerja.harian.list') }}"
                    class="px-6 py-3 bg-white border border-gray-200 text-gray-600 text-sm font-bold rounded-xl hover:bg-gray-50 transition-all">
                    Batalkan
                </a>
            </div>
        </form>
    </div>
@endsection
