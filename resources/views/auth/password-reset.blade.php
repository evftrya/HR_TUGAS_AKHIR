<x-guest-layout>
    <div class="w-full max-w-full text-[20px] sm:text-[21px] lg:text-[22px] leading-relaxed">
        <div class="grid grid-cols-1 gap-6">

            {{-- Form Ubah Password --}}
            <section class="lg:col-span-2 space-y-8">
                <div
                    class="rounded-2xl border border-gray-200 bg-white p-6 shadow-md dark:border-gray-800 dark:bg-gray-900">
                    <div class="mb-6 flex items-center justify-between">
                        <h3 class="text-xl font-semibold tracking-wide text-gray-900 dark:text-gray-100">Reset Password
                        </h3>
                    </div>

                    {{-- Flash sukses --}}
                    @if (session('status'))
                        <div
                            class="mb-4 rounded-xl border border-emerald-200 bg-emerald-50 p-4 text-emerald-800 dark:border-emerald-900/40 dark:bg-emerald-950/40 dark:text-emerald-200">
                            {{ session('status') }}
                        </div>
                    @endif

                    {{-- Error validasi --}}
                    @if ($errors->any())
                        <div
                            class="mb-4 rounded-xl border border-red-200 bg-red-50 p-4 text-red-800 dark:border-red-900/40 dark:bg-red-950/40 dark:text-red-200">
                            <div class="font-semibold mb-1">Periksa lagi data yang diisi:</div>
                            <ul class="list-disc ms-5 text-base">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    {{-- NOTE: action diisi sesuai route handler di controller --}}
                    <form method="POST" action="{{ route('forget-password.reset') }}" class="space-y-6" novalidate>
                        @csrf
                        {{-- Password Baru --}}
                        <div>
                            <label for="password" class="block text-base text-gray-600 dark:text-gray-300">Password
                                Baru</label>
                            <div class="mt-1 input-with-toggle">
                                <input id="password" name="new-password" value="{{ old('new-password') ?? '' }}"
                                    type="password" required minlength="8" autocomplete="new-password"
                                    class="block w-full rounded-xl border
                       @error('new-password') border-red-500 focus:ring-red-500 focus:border-red-500
                       @else border-gray-300 focus:ring-blue-500 focus:border-blue-500 @enderror
                       bg-white px-4 py-3 text-lg text-gray-900 placeholder-gray-400 shadow-sm
                       dark:border-gray-700 dark:bg-gray-900 dark:text-gray-100"
                                    placeholder="Minimal 8 karakter"
                                    title="Minimal 8 karakter, disarankan kombinasi huruf besar, kecil, angka, dan simbol.">
                                <button type="button" class="pw-toggle-btn" data-target="new-password"
                                    aria-label="Tampilkan password baru" title="Tampilkan / sembunyikan password">
                                    <svg class="eye-open" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                                        fill="none" stroke="currentColor" stroke-width="1.5">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M2.5 12s4-7.5 9.5-7.5S21.5 12 21.5 12s-4 7.5-9.5 7.5S2.5 12 2.5 12z" />
                                        <circle cx="12" cy="12" r="3" stroke-linecap="round"
                                            stroke-linejoin="round" />
                                    </svg>
                                    <svg class="eye-closed hidden" xmlns="http://www.w3.org/2000/svg"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 3l18 18" />
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M10.58 10.58A3 3 0 0 0 13.42 13.42" />
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M2.5 12s4-7.5 9.5-7.5c1.78 0 3.38.44 4.78 1.18M21.5 12s-1.84 3.45-4.5 5.25" />
                                    </svg>
                                </button>
                            </div>
                            <p class="mt-2 text-sm text-gray-500 dark:text-gray-400">
                                Disarankan gunakan huruf besar, kecil, angka, dan simbol.
                            </p>
                            @error('new-password')
                                <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Konfirmasi Password --}}
                        <div>
                            <label for="password_confirmation"
                                class="block text-base text-gray-600 dark:text-gray-300">Ulangi Password Baru</label>
                            <div class="mt-1 input-with-toggle">
                                <input id="password_confirmation" name="password_confirmation"
                                    value="{{ old('password_confirmation') ?? '' }}" type="password" required
                                    autocomplete="new-password"
                                    class="block w-full rounded-xl border
                                    @error('password_confirmation') border-red-500 focus:ring-red-500 focus:border-red-500
                                    @else border-gray-300 focus:ring-blue-500 focus:border-blue-500 @enderror
                                    bg-white px-4 py-3 text-lg text-gray-900 placeholder-gray-400 shadow-sm
                                    dark:border-gray-700 dark:bg-gray-900 dark:text-gray-100"
                                    placeholder="Ketik ulang password baru">
                                <button type="button" class="pw-toggle-btn" data-target="password_confirmation"
                                    aria-label="Tampilkan konfirmasi password" title="Tampilkan / sembunyikan password">
                                    <svg class="eye-open" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                                        fill="none" stroke="currentColor" stroke-width="1.5">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M2.5 12s4-7.5 9.5-7.5S21.5 12 21.5 12s-4 7.5-9.5 7.5S2.5 12 2.5 12z" />
                                        <circle cx="12" cy="12" r="3" stroke-linecap="round"
                                            stroke-linejoin="round" />
                                    </svg>
                                    <svg class="eye-closed hidden" xmlns="http://www.w3.org/2000/svg"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 3l18 18" />
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M10.58 10.58A3 3 0 0 0 13.42 13.42" />
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M2.5 12s4-7.5 9.5-7.5c1.78 0 3.38.44 4.78 1.18M21.5 12s-1.84 3.45-4.5 5.25" />
                                    </svg>
                                </button>
                            </div>
                            @error('password_confirmation')
                                <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Input disembunyikan agar data tetap terkirim ke backend --}}
                        <input type="hidden" name="email_institusi" value="{{ request('email_institusi') }}">
                        <input type="hidden" name="verified_code" value="{{ request('verified_code') }}">

                        <div class="flex items-center  justify-end gap-3 pt-2">
                            <button type="submit" id="save_button" onclick="form_loading(this)"
                                class="rounded-2xl active:scale-85 bg-black text-white hover:scale-95 px-6 py-2.5 text-base font-semibold  shadow hover:opacity-95 focus:outline-none focus:ring-2 focus:ring-blue-500">
                                Simpan Perubahan
                            </button>
                        </div>
                    </form>

                </div>

                {{-- Catatan --}}
                <div
                    class="rounded-2xl border border-dashed border-gray-200 bg-gray-50 p-6 text-lg text-gray-600 dark:border-gray-800 dark:bg-gray-900/40 dark:text-gray-300">
                    <p>
                        Tip: Jangan gunakan password yang sama di layanan lain. Simpan di pengelola sandi.
                    </p>
                </div>
            </section>
        </div>
    </div>

    {{-- Script toggle password --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // semua tombol toggle
            document.querySelectorAll('.pw-toggle-btn').forEach(function(btn) {
                btn.addEventListener('click', function(e) {
                    const targetId = btn.getAttribute('data-target');
                    const input = document.getElementById(targetId);
                    if (!input) return;

                    // toggle tipe
                    const isPassword = input.type === 'password';
                    input.type = isPassword ? 'text' : 'password';

                    // toggle aria-label untuk aksesibilitas
                    if (isPassword) {
                        btn.setAttribute('aria-label', 'Sembunyikan ' + (targetId.replace('_',
                            ' ')));
                        btn.setAttribute('title', 'Sembunyikan / tampilkan password');
                    } else {
                        btn.setAttribute('aria-label', 'Tampilkan ' + (targetId.replace('_', ' ')));
                        btn.setAttribute('title', 'Tampilkan / sembunyikan password');
                    }

                    // toggle icon (ubah kelas hidden)
                    const eyeOpen = btn.querySelector('.eye-open');
                    const eyeClosed = btn.querySelector('.eye-closed');
                    if (eyeOpen && eyeClosed) {
                        if (isPassword) {
                            eyeOpen.classList.add('hidden');
                            eyeClosed.classList.remove('hidden');
                        } else {
                            eyeOpen.classList.remove('hidden');
                            eyeClosed.classList.add('hidden');
                        }
                    }
                });
            });
        });
    </script>


    @if (session('success'))
        <script>
            document.addEventListener('DOMContentLoaded', () => {
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil',
                    text: @json(session('success')),
                    confirmButtonText: 'OK'
                });
            });
        </script>
    @endif
    <x-js.save_form_pop_up id_button="save_button" />
</x-guest-layout>