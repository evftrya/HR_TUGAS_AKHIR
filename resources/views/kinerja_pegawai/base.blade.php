@extends('layouts.base-1')

@section('sidebar-menu')
    @include('kinerja_pegawai.sidebar')
@endsection

@push('script-add')
    @php
        $isMasquerading = session()->has('original_admin_id');
        $isAdminSDM = false;
        if (!$isMasquerading && auth()->check()) {
            if (auth()->user()->is_admin) {
                $isAdminSDM = true;
            }
        }
        $currentRole = auth()->check() ? (auth()->user()->role ?? 'Pegawai') : 'Pegawai';
    @endphp

    @if($isAdminSDM || $isMasquerading)
        <div class="fixed bottom-6 right-6 z-50">
            @if($isMasquerading)
                <a href="{{ route('manage.leave-impersonate') }}" 
                   class="flex items-center gap-2 px-4 py-3 bg-red-600 hover:bg-red-700 text-white rounded-full shadow-lg transition-transform transform hover:scale-105 font-medium text-sm">
                    <i class="fas fa-user-times"></i>
                    Keluar Mode {{ ucfirst($currentRole) }}
                </a>
            @else
                <div class="relative group">
                    <button class="flex items-center gap-2 px-4 py-3 bg-blue-600 hover:bg-blue-700 text-white rounded-full shadow-lg transition-transform transform hover:scale-105 font-medium text-sm focus:outline-none"
                            id="roleSwitcherBtn">
                        <i class="fas fa-user-tag"></i>
                        Ganti Mode Role
                    </button>
                    
                    <!-- Dropdown Menu -->
                    <div class="absolute bottom-full right-0 mb-3 w-56 bg-white border border-gray-200 rounded-lg shadow-xl opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-300 transform translate-y-2 group-hover:translate-y-0"
                         style="transform-origin: bottom right;">
                        <div class="p-2 space-y-1">
                            <div class="px-3 py-2 text-xs font-semibold text-gray-500 uppercase tracking-wider border-b border-gray-100 mb-1">
                                Pilih Mode Penyamaran
                            </div>
                            <a href="#" class="block px-3 py-2 text-sm text-gray-700 hover:bg-gray-100 rounded-md transition-colors font-medium">
                                <i class="fas fa-user-cog w-5 text-center text-gray-500"></i> Mode Admin SDM
                            </a>
                            <a href="{{ route('manage.switch-role', 'pegawai') }}" class="block px-3 py-2 text-sm text-gray-700 hover:bg-blue-50 hover:text-blue-700 rounded-md transition-colors">
                                <i class="fas fa-user w-5 text-center text-blue-500"></i> Mode Pegawai
                            </a>
                            <a href="{{ route('manage.switch-role', 'atasan') }}" class="block px-3 py-2 text-sm text-gray-700 hover:bg-blue-50 hover:text-blue-700 rounded-md transition-colors">
                                <i class="fas fa-user-tie w-5 text-center text-green-500"></i> Mode Atasan
                            </a>
                            <a href="{{ route('manage.switch-role', 'pimpinan') }}" class="block px-3 py-2 text-sm text-gray-700 hover:bg-blue-50 hover:text-blue-700 rounded-md transition-colors">
                                <i class="fas fa-user-shield w-5 text-center text-purple-500"></i> Mode Pimpinan
                            </a>
                        </div>
                    </div>
                </div>
            @endif
        </div>

        <script>
            // Optional: Click outside to close or toggle for mobile support
            document.addEventListener('DOMContentLoaded', function() {
                const btn = document.getElementById('roleSwitcherBtn');
                if (btn) {
                    btn.addEventListener('click', function(e) {
                        e.preventDefault();
                        const menu = this.nextElementSibling;
                        menu.classList.toggle('opacity-0');
                        menu.classList.toggle('invisible');
                        menu.classList.toggle('translate-y-2');
                    });
                }
            });
        </script>
    @endif

    @stack('script-under-base')
@endpush
