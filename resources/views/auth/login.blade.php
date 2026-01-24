@include('layouts.navigation')

<x-guest-layout>
    <div class="flex flex-col md:flex-row">
        <!-- Left: Hero branding panel -->
        <div class="flex items-center justify-center min-w-0 p-10 md:flex-1">
            <div class="max-w-full text-left">
                <h1 class="text-[64px] md:text-[128px] leading-none font-extrabold text-[1C2762] dark:text-gray-100">SDM</h1>
                <p class="mt-4 text-[20px] md:text-[36px] font-thin text-[1C2762] dark:text-gray-400">Sistem Informasi Manajemen Data Pegawai</p>
            </div>
        </div>

        <!-- Right: Login card -->
        <div class="flex items-center justify-center min-w-0 p-10 md:flex-1">
            <div class="w-full max-w-md p-8 bg-white shadow-lg dark:bg-gray-800 rounded-xl">

                <!-- Session Status -->
                <x-auth-session-status class="mb-4" :status="session('status')" />

                <form method="POST" action="{{ route('login') }}">
                    @csrf
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">

                    <x-itxt fill="mb-4" type="email" lbl="Email Institusi" plc="john@telkomuniversity.ac.id" nm="email_institusi"
                        max="100" fill="flex-grow"></x-itxt>
                    <x-itxt type="password" lbl="Password" nm="password"
                        max="15" fill="flex-grow"></x-itxt>

                    <!-- Remember Me -->
                    <div class="block mt-4">
                        <label for="remember_me" class="inline-flex items-center">
                            <input id="remember_me" type="checkbox"
                                class="text-indigo-600 border-gray-300 rounded shadow-sm dark:bg-gray-900 dark:border-gray-700 focus:ring-indigo-500 dark:focus:ring-indigo-600 dark:focus:ring-offset-gray-800"
                                name="remember">
                            <span class="text-sm text-gray-600 ms-2 dark:text-gray-400">
                                Remember me
                            </span>
                        </label>
                    </div>

                    <!-- Actions -->
                    <div class="flex items-center justify-between mt-6">
                        @if (Route::has('password.request'))
                        <a class="text-sm text-indigo-600 underline hover:text-indigo-800 dark:text-indigo-400 dark:hover:text-indigo-200 focus:outline-none"
                            href="{{ route('password.request') }}">
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