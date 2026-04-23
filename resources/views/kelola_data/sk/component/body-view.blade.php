<div class="max-w-7xl mx-auto space-y-10" x-data="{ isEnlarged: false }">

    <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4" x-show="!isEnlarged"
        x-collapse>
        <div>
            <h1 class="text-3xl font-semibold text-gray-900">Detail Surat Keputusan</h1>
            <p class="text-sm text-gray-500 mt-1">Informasi SK dan dokumen yang terlampir</p>
        </div>

        <a href="{{ route('manage.sk.edit', ['id' => $sk->id]) }}"
            class="inline-flex items-center gap-2 px-6 py-3 rounded-xl bg-blue-600 text-white hover:bg-blue-700 transition-all duration-200 shadow-sm hover:shadow-md text-sm font-semibold">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
            </svg>
            Perbarui Data SK
        </a>
    </div>

    <div class="grid gap-10 transition-all duration-500" :class="isEnlarged ? 'grid-cols-1' : 'lg:grid-cols-5'">

        <div class="lg:col-span-2 space-y-8" x-show="!isEnlarged" x-transition:enter="transition ease-out duration-300">

            <div class="bg-white rounded-2xl p-7 shadow-sm border border-gray-100">
                <h2 class="text-sm font-semibold text-blue-600 tracking-wider mb-6 uppercase">
                    Informasi SK
                </h2>

                <div class="grid sm:grid-cols-2 gap-y-7 gap-x-10">
                    <div class="space-y-1">
                        <p class="text-xs text-gray-400 uppercase">KETERANGAN SK</p>
                        <p class="text-lg font-semibold text-gray-900">
                            {{ $sk->keterangan == null ? 'Belum ada' : $sk->keterangan }}

                        </p>
                    </div>

                    <div class="space-y-1 grid sm:grid-cols-1 gap-y-7 gap-x-10">
                        <div class="space-y-1">
                            <p class="text-xs text-gray-400 uppercase">No SK</p>
                            <p class="text-lg font-semibold text-gray-900">
                                {{ $sk->no_sk == null ? 'Belum ada' : $sk->no_sk }}

                            </p>
                        </div>

                        <div class="space-y-1">
                            <p class="text-xs text-gray-400 uppercase">TMT Mulai</p>
                            <p class="text-lg font-semibold text-gray-900">
                                {{ $sk->tmt_mulai == null ? 'Belum ada' : $sk->tmt_mulai }}

                            </p>
                        </div>

                        <div class="space-y-1">
                            <p class="text-xs text-gray-400 uppercase">TMT Selesai</p>
                            <p class="text-lg font-semibold text-gray-900">
                                {{ $sk->tmt_selesai == null ? 'Belum ada' : $sk->tmt_selesai }}
                            </p>
                        </div>

                        @if ($sk->tipe_dokumen == 'SK')
                            <div class="space-y-1">
                                <p class="text-xs text-gray-400 uppercase">Tipe SK</p>
                                <span
                                    class="inline-flex items-center px-3 py-1.5 rounded-full bg-blue-50 text-blue-600 text-sm font-medium">
                                    {{ $sk->tipe_sk }}
                                </span>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            @if (session('account')['is_admin'] == 1)
                <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100">
                    <div class="flex items-center justify-between mb-6">
                        <h2 class="text-sm font-semibold text-blue-600 tracking-wider uppercase">
                            Users Terhubung
                        </h2>
                    </div>

                    <div class="space-y-5">
                        @forelse ($user_terkait as $user)
                            <div class="space-y-3">
                                <div class="flex items-center gap-3 p-3 rounded-xl hover:bg-blue-50 transition">
                                    <div
                                        class="w-10 h-10 rounded-full bg-blue-100 flex items-center justify-center text-blue-600 text-sm font-semibold">
                                        {{ substr($user['user_nama'], 0, 1) }}
                                    </div>
                                    <div>
                                        <p class="text-sm font-medium text-gray-900">{{ $user['user_nama'] }}</p>
                                        <p class="text-xs text-gray-400">Staff</p>
                                    </div>
                                </div>

                                <div class="pl-12 flex flex-wrap gap-2">
                                    @forelse ($user['kategori'] as $terhubung)
                                        <span class="text-xs px-3 py-1 rounded-full bg-gray-100 text-gray-600">
                                            {{ str_replace('_', ' ', $terhubung) }}
                                        </span>
                                    @empty
                                        <span class="text-xs text-gray-400 italic">Belum ada kategori</span>
                                    @endforelse
                                </div>
                            </div>
                        @empty
                            <p class="text-sm text-gray-500 italic">Belum terhubung dengan user manapun</p>
                        @endforelse
                    </div>
                </div>
            @endif
        </div>

        <div :class="isEnlarged ? 'lg:col-span-1' : 'lg:col-span-3'" class="self-start sticky top-10">

            <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100 transition-all duration-500">

                <div class="flex items-center justify-between mb-5">
                    <h2 class="text-sm font-semibold text-blue-600 tracking-wider uppercase">
                        Preview Dokumen
                    </h2>

                    <button @click="isEnlarged = !isEnlarged"
                        class="flex items-center gap-2 px-4 py-2 rounded-xl bg-gray-900 text-white hover:bg-blue-700 transition-colors text-xs font-medium shadow-sm">

                        <span x-show="!isEnlarged" class="flex items-center gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M4 8V4m0 0h4M4 4l5 5m11-1V4m0 0h-4m4 0l-5 5M4 16v4m0 0h4m-4 0l5-5m11 5l-5-5m5 5v-4m0 4h-4" />
                            </svg>
                            Enlarge Preview
                        </span>

                        <span x-show="isEnlarged" class="flex items-center gap-2" x-cloak>
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12" />
                            </svg>
                            Minimize
                        </span>
                    </button>
                </div>

                <div
                    class="w-full rounded-xl overflow-hidden border border-gray-200 bg-gray-100 flex justify-center transition-all duration-500">
                    @if (isset($sk->file_sk))
                        <iframe src="{{ route('manage.sk.file', ['id_sk' => $sk->id]) }}"
                            class="w-full bg-white transition-all duration-500 shadow-inner"
                            :class="isEnlarged ? 'h-[85vh] max-w-full' : 'max-w-[900px] aspect-[210/297]'">
                        </iframe>
                    @else
                        <div class="py-20 text-center">
                            <p class="text-sm text-gray-500 italic">File SK Tidak Ditemukan, silahkan isi file dengan
                                melakukan 'Ubah SK'</p>
                        </div>
                    @endif
                </div>

            </div>

        </div>

    </div>

</div>

@push('script-under-base')
    <style>
        [x-cloak] {
            display: none !important;
        }
    </style>
@endpush
