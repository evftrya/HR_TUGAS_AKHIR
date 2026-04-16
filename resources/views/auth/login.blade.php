@include('layouts.navigation')

<x-guest-layout>
    <div class="flex flex-col md:flex-row">

        <!-- Left: Hero branding panel -->
        <div class="flex items-center justify-center min-w-0 p-10 md:flex-1">
            <div class="max-w-full text-left">
                <h1 class="text-[64px] md:text-[128px] leading-none font-extrabold text-[1C2762] dark:text-gray-100">
                    SDM
                </h1>
                <p class="mt-4 text-[20px] md:text-[36px] font-thin text-[1C2762] dark:text-gray-400">
                    Sistem Informasi Manajemen Data Pegawai
                </p>
            </div>
        </div>

        <!-- Right: Login card -->
        <div class="flex items-start justify-center min-w-0 p-10 md:flex-1">
            <div class="w-full max-w-md p-8 bg-white shadow-lg dark:bg-gray-800 rounded-xl">

                @if (session()->has('error'))
                    <div class="mb-4 p-3 text-sm text-red-700 bg-red-100 border border-red-300 rounded">
                        <ul class="list-disc pl-5">

                            {{-- @foreach ($errors->all() as $error) --}}
                            {{-- {{ dD($errors->all()) }} --}}
                            <li>
                                {{ session('error') }}
                            </li>
                            {{-- @endforeach --}}
                        </ul>
                    </div>
                @endif
                <!-- Session Status -->
                <x-auth-session-status class="mb-4" :status="session('status')" />

                <!-- Error Validation -->
                @if ($errors->any())
                    <div class="mb-4 p-3 text-sm text-red-700 bg-red-100 border border-red-300 rounded">
                        <ul class="list-disc pl-5">

                            @foreach ($errors->all() as $error)
                                {{-- {{ dD($errors->all()) }} --}}
                                <li>
                                    {!! str_replace(
                                        'email pribadi belum terverifikasi',
                                        'email pribadi belum terverifikasi <a onclick="openPopup()" class="underline text-blue-600">verifikasi sekarang</a>',
                                        $error,
                                    ) !!}
                                </li>
                            @endforeach
                        </ul>
                    </div>
                @endif


                <form method="POST" action="{{ route('login') }}">
                    @csrf

                    <!-- Email -->
                    <x-itxt fill="mb-4" nm="email_institusi" type="email" lbl="Email Institusi"
                        plc="john@telkomuniversity.ac.id" max="100" fill="flex-grow"></x-itxt>

                    @error('email_institusi')
                        <div class="text-sm text-red-600 mt-1">
                            {{ $message }}
                        </div>
                    @enderror


                    <!-- Password -->
                    <x-itxt type="password" lbl="Password" nm="password" max="15" fill="flex-grow"></x-itxt>

                    @error('password')
                        <div class="text-sm text-red-600 mt-1">
                            {{ $message }}
                        </div>
                    @enderror


                    <!-- Remember Me -->
                    <div class="block mt-4">
                        <label for="remember_me" class="inline-flex items-center">
                            <input id="remember_me" type="checkbox"
                                class="text-indigo-600 border-gray-300 rounded shadow-sm dark:bg-gray-900 dark:border-gray-700 focus:ring-indigo-500"
                                name="remember">

                            <span class="text-sm text-gray-600 ms-2 dark:text-gray-400">
                                Remember me
                            </span>
                        </label>
                    </div>


                    <!-- Actions -->
                    <div class="flex items-center justify-between mt-6">

                        @if (Route::has('password.request'))
                            <a class="text-sm text-indigo-600 underline hover:text-indigo-800 dark:text-indigo-400"
                                onclick="forget_password()">
                                {{ __('Forgot your password?') }}
                            </a>
                        @endif


                        <x-primary-button class="px-6 py-2">
                            {{ __('Log in') }}
                        </x-primary-button>

                    </div>

                </form>
            </div>
        </div>

    </div>
</x-guest-layout>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


<script>
    @if (session('message'))
        Swal.fire({
            icon: 'success', // bisa diganti 'info', 'error', dll
            title: 'Info',
            text: "{{ session('message') }}",
            confirmButtonText: 'OK'
        });
    @endif

    function openPopup() {
        Swal.fire({
            title: 'Masukkan Email Institusi',
            html: `
            <div class="text-left space-y-2">
                <label class="text-sm font-semibold">Email Institusi</label>
                <input 
                    id="email" 
                    type="email" 
                    placeholder="something@telkomuniversity.ac.id" 
                    class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                >
            </div>
        `,
            showCancelButton: true,
            confirmButtonText: 'Simpan',
            cancelButtonText: 'Batal',
            focusConfirm: false,
            reverseButtons: true,
            preConfirm: () => {
                const email = document.getElementById('email').value;
                if (!email) {
                    Swal.showValidationMessage('Email tidak boleh kosong');
                    return false;
                }
                // Kirim data email ke blok .then()
                return {
                    email: email
                };
            }
        }).then((result) => {
            // Jika tombol Simpan diklik
            if (result.isConfirmed) {

                // 1. Munculkan Log
                console.log('a');

                // 2. Munculkan Swal Loading Baru (Karena swal sebelumnya sudah tertutup)
                Swal.fire({
                    title: 'Mohon Tunggu',
                    html: 'Sedang memproses data...',
                    allowOutsideClick: false,
                    showConfirmButton: false,
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });

                // 3. Eksekusi Form Submit
                const email = result.value.email;
                const form = document.createElement("form");
                form.method = "GET";
                form.action = "{{ route('verify-email.view') }}";

                const inputEmail = document.createElement("input");
                inputEmail.type = "hidden";
                inputEmail.name = "email_institusi";
                inputEmail.value = email;

                form.appendChild(inputEmail);
                document.body.appendChild(form);
                form.submit();
            }
        });
    }

    function forget_password() {
        Swal.fire({
            title: 'Masukkan Email Institusi',
            html: `
            <div class="text-left space-y-2">
                <label class="text-sm font-semibold">
                    Email Institusi
                </label>
                <input 
                    id="email"
                    type="email"
                    placeholder="something@telkomuniversity.ac.id"
                    class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                >
            </div>
        `,
            showCancelButton: true,
            confirmButtonText: 'Simpan',
            cancelButtonText: 'Batal',
            focusConfirm: false,
            reverseButtons: true,
            preConfirm: () => {
                const email = document.getElementById('email').value;
                if (!email) {
                    Swal.showValidationMessage('Email tidak boleh kosong');
                    return false;
                }
                // Kirim data email ke .then()
                return {
                    email: email
                };
            }
        }).then((result) => {
            if (result.isConfirmed) {
                // 1. Log indikator
                console.log('a');

                // 2. Tampilkan Loading Popup Baru (setelah popup input tutup)
                Swal.fire({
                    title: 'Mohon Tunggu',
                    html: 'Sedang mengirim instruksi reset password...',
                    allowOutsideClick: false,
                    showConfirmButton: false,
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });

                // 3. Buat Form POST secara dinamis
                const email = result.value.email;
                const form = document.createElement("form");
                form.method = "POST";
                form.action = "{{ route('forget-password.send') }}";

                // 4. Tambahkan CSRF Token (Wajib untuk POST di Laravel)
                const csrfToken = document.createElement("input");
                csrfToken.type = "hidden";
                csrfToken.name = "_token";
                csrfToken.value = "{{ csrf_token() }}";
                form.appendChild(csrfToken);

                // 5. Tambahkan Input Email
                const inputEmail = document.createElement("input");
                inputEmail.type = "hidden";
                inputEmail.name = "email_institusi";
                inputEmail.value = email;
                form.appendChild(inputEmail);

                // 6. Eksekusi
                document.body.appendChild(form);
                form.submit();
            }
        });
    }
</script>
