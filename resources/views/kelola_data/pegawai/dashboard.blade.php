@php
    $active_sidebar = 'Dashboard Pegawai';
@endphp

@extends('kelola_data.base')

@section('header-base')
    <style>
        .max-w-100 {
            max-width: 100% !important;
        }
    </style>
@endsection

@section('page-name')
    <div class="flex flex-col md:flex-row items-center gap-[11.749480247497559px] self-stretch px-1 pt-[14.686850547790527px] pb-[13.952507972717285px]">
        <div class="flex w-full flex-col gap-[2.9373700618743896px] grow">
            <div class="flex items-center gap-[5.874740123748779px] self-stretch">
                <span class="font-medium text-2xl leading-[20.56159019470215px] text-[#101828]">
                    Dashboard Pegawai
                </span>
            </div>
            <span class="font-normal text-[10.280795097351074px] leading-[14.686850547790527px] text-[#1f2028]">
                Ringkasan data pegawai Telkom University Surabaya
            </span>
        </div>
    </div>
@endsection

@section('content-base')
    <div class="flex flex-col gap-6 w-full max-w-100 pb-8">
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div class="bg-indigo-50 rounded-xl p-6 shadow-sm border border-indigo-200 transition-all duration-300 hover:shadow-md hover:-translate-y-1">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-indigo-700 text-sm font-medium">Total Pegawai</p>
                        <h3 class="text-3xl font-bold text-indigo-900 mt-2">{{ $stats['total'] ?? 0 }}</h3>
                    </div>
                    <div class="bg-indigo-100 p-3 rounded-xl border border-indigo-200 flex items-center justify-center">
                        <i class="fas fa-users text-2xl text-indigo-600"></i>
                    </div>
                </div>
            </div>
            
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <a title="Klik untuk mengarahkan ke daftar karyawan yang dimaksud" href="{{ route('manage.pegawai.list', ['destination' => 'Semua', 'aktif' => 'Active']) }}" 
                   class="block bg-blue-50 rounded-xl p-6 shadow-sm border border-blue-200 transition-all duration-300 hover:shadow-md hover:-translate-y-1">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-blue-700 text-sm font-medium">Pegawai Aktif</p>
                            <h3 class="text-3xl font-bold text-blue-900 mt-2">{{ $stats['active'] ?? 0 }} <span class="text-lg font-semibold text-blue-700">(12%)</span></h3>
                        </div>
                        <div class="bg-blue-100 p-3 rounded-xl border border-blue-200 flex items-center justify-center">
                            <i class="fas fa-user-check text-2xl text-blue-600"></i>
                        </div>
                    </div>
                </a>

                <a title="Klik untuk mengarahkan ke daftar karyawan yang dimaksud" href="{{ route('manage.pegawai.list', ['destination' => 'Semua', 'aktif' => 'Nonactive']) }}" 
                   class="block bg-slate-50 rounded-xl p-6 shadow-sm border border-slate-200 transition-all duration-300 hover:shadow-md hover:-translate-y-1">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-slate-700 text-sm font-medium">Pegawai Tidak Aktif</p>
                            <h3 class="text-3xl font-bold text-slate-900 mt-2">{{ $stats['active'] ?? 0 }} <span class="text-lg font-semibold text-slate-700">(30%)</span></h3>
                        </div>
                        <div class="bg-slate-100 p-3 rounded-xl border border-slate-200 flex items-center justify-center">
                            <i class="fas fa-user-xmark text-2xl text-slate-600"></i>
                        </div>
                    </div>
                </a>
            </div>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
            <a title="Klik untuk mengarahkan ke daftar karyawan yang dimaksud" href="{{ route('manage.pegawai.list', ['destination' => 'Active', 'tipe' => 'Dosen']) }}" 
               class="block bg-emerald-50 rounded-xl p-6 shadow-sm border border-emerald-200 transition-all duration-300 hover:shadow-md hover:-translate-y-1">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-emerald-700 text-sm font-medium">Dosen</p>
                        <h3 class="text-3xl font-bold text-emerald-900 mt-2">{{ $stats['dosen'] ?? 0 }}</h3>
                    </div>
                    <div class="bg-emerald-100 p-3 rounded-xl border border-emerald-200 flex items-center justify-center">
                        <i class="fas fa-chalkboard-user text-2xl text-emerald-600"></i>
                    </div>
                </div>
            </a>

            <a title="Klik untuk mengarahkan ke daftar karyawan yang dimaksud" href="{{ route('manage.pegawai.list', ['destination' => 'Active', 'tipe' => 'TPA']) }}"
               class="block bg-purple-50 rounded-xl p-6 shadow-sm border border-purple-200 transition-all duration-300 hover:shadow-md hover:-translate-y-1">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-purple-700 text-sm font-medium truncate" title="Tenaga Pendukung Akademik">Tenaga Pendukung...</p>
                        <h3 class="text-3xl font-bold text-purple-900 mt-2">{{ $stats['tpa'] ?? 0 }}</h3>
                    </div>
                    <div class="bg-purple-100 p-3 rounded-xl border border-purple-200 flex items-center justify-center">
                        <i class="fas fa-user-tie text-2xl text-purple-600"></i>
                    </div>
                </div>
            </a>

            <div class="bg-amber-50 rounded-xl p-6 shadow-sm border border-amber-200 transition-all duration-300 hover:shadow-md hover:-translate-y-1">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-amber-700 text-sm font-medium">Jumlah Admin</p>
                        <h3 class="text-3xl font-bold text-amber-900 mt-2">{{ $stats['tpa'] ?? 0 }}</h3>
                    </div>
                    <div class="bg-amber-100 p-3 rounded-xl border border-amber-200 flex items-center justify-center">
                        <i class="fas fa-user-shield text-2xl text-amber-600"></i>
                    </div>
                </div>
            </div>

            <a title="Klik untuk mengarahkan ke daftar karyawan yang dimaksud" href="{{ route('manage.pegawai.list', ['destination' => 'Active', 'nip' => 'Belum dipetakan klik untuk set']) }}"
               class="block bg-rose-50 rounded-xl p-6 shadow-sm border border-rose-200 transition-all duration-300 hover:shadow-md hover:-translate-y-1">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-rose-700 text-sm font-medium">Belum Input NIP</p>
                        <h3 class="text-3xl font-bold text-rose-900 mt-2">{{ $stats['tpa'] ?? 0 }}</h3>
                    </div>
                    <div class="bg-rose-100 p-3 rounded-xl border border-rose-200 flex items-center justify-center">
                        <i class="fas fa-id-badge text-2xl text-rose-600"></i>
                    </div>
                </div>
            </a>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mt-2">
            <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6">
                <h3 class="text-lg font-semibold text-slate-800 mb-4 border-b pb-2">Distribusi Status Pegawai</h3>
                <div class="flex justify-center">
                    <canvas id="statusChart" height="240" style="max-height: 240px;"></canvas>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6">
                <h3 class="text-lg font-semibold text-slate-800 mb-4 border-b pb-2">Distribusi Jenis Kelamin</h3>
                <div class="flex justify-center">
                    <canvas id="genderChart" height="240" style="max-height: 240px;"></canvas>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden mt-2">
            <div class="flex justify-between items-center p-5 border-b border-slate-200 bg-slate-50/50">
                <h3 class="text-lg font-semibold text-slate-800">Pegawai Terbaru</h3>
                <div class="text-sm font-medium text-slate-500 bg-white px-3 py-1 rounded-full border border-slate-200">
                    Menampilkan 10 data terbaru
                </div>
            </div>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-slate-200 text-sm">
                    <thead class="bg-slate-50">
                        <tr>
                            <th class="px-6 py-4 text-left text-xs font-bold text-slate-600 uppercase tracking-wider">Nama</th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-slate-600 uppercase tracking-wider">Tipe</th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-slate-600 uppercase tracking-wider">Email</th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-slate-600 uppercase tracking-wider">Tanggal Bergabung</th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-slate-600 uppercase tracking-wider">Status</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-slate-100">
                        @forelse($recentEmployees as $employee)
                            <tr class="hover:bg-slate-50 transition-colors">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-semibold text-slate-900">{{ $employee->nama_lengkap }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full 
                                        {{ $employee->tipe_pegawai == 'Dosen' ? 'bg-emerald-100 text-emerald-800 border border-emerald-200' : 'bg-purple-100 text-purple-800 border border-purple-200' }}">
                                        {{ $employee->tipe_pegawai }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-600">
                                    {{ $employee->email_institusi }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-600">
                                    {{ \Carbon\Carbon::parse($employee->tgl_bergabung)->format('d M Y') }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full 
                                        {{ $employee->is_active ? 'bg-blue-100 text-blue-800 border border-blue-200' : 'bg-slate-100 text-slate-800 border border-slate-200' }}">
                                        {{ $employee->is_active ? 'Aktif' : 'Tidak Aktif' }}
                                    </span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-8 text-center text-slate-500 font-medium">
                                    Belum ada data pegawai
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden mt-2">
            <div class="flex justify-between items-center p-5 border-b border-slate-200 bg-slate-50/50">
                <div class="flex items-center gap-3">
                    <div class="bg-rose-100 p-2 rounded-lg text-rose-600">
                        <i class="fas fa-cake-candles"></i>
                    </div>
                    <h3 class="text-lg font-semibold text-slate-800">Pegawai Ulang Tahun Hari Ini</h3>
                </div>
            </div>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-slate-200 text-sm">
                    <thead class="bg-slate-50">
                        <tr>
                            <th class="px-6 py-4 text-left text-xs font-bold text-slate-600 uppercase tracking-wider">Nama</th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-slate-600 uppercase tracking-wider">Umur</th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-slate-600 uppercase tracking-wider">Email</th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-slate-600 uppercase tracking-wider">Tanggal Bergabung</th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-slate-600 uppercase tracking-wider">Status</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-slate-100">
                        @forelse($recentEmployees as $employee)
                            <tr class="hover:bg-rose-50/30 transition-colors">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-semibold text-slate-900">{{ $employee->nama_lengkap }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full 
                                        {{ $employee->tipe_pegawai == 'Dosen' ? 'bg-emerald-100 text-emerald-800 border border-emerald-200' : 'bg-purple-100 text-purple-800 border border-purple-200' }}">
                                        {{ $employee->tipe_pegawai }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-600">
                                    {{ $employee->email_institusi }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-600">
                                    {{ \Carbon\Carbon::parse($employee->tgl_bergabung)->format('d M Y') }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full 
                                        {{ $employee->is_active ? 'bg-blue-100 text-blue-800 border border-blue-200' : 'bg-slate-100 text-slate-800 border border-slate-200' }}">
                                        {{ $employee->is_active ? 'Aktif' : 'Tidak Aktif' }}
                                    </span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-8 text-center text-slate-500 font-medium">
                                    Belum ada data pegawai yang berulang tahun hari ini
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        
    </div>
@endsection

@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        // Set default font family for charts to match Tailwind
        Chart.defaults.font.family = "'Inter', 'Segoe UI', Roboto, Helvetica, Arial, sans-serif";
        Chart.defaults.color = '#64748b'; // slate-500

        // Status Pegawai Chart
        const statusCtx = document.getElementById('statusChart').getContext('2d');
        new Chart(statusCtx, {
            type: 'doughnut',
            data: {
                labels: ['Dosen', 'TPA'],
                datasets: [{
                    data: [{{ $stats['dosen'] ?? 0 }}, {{ $stats['tpa'] ?? 0 }}],
                    backgroundColor: ['#10b981', '#8b5cf6'], // emerald-500, purple-500
                    borderWidth: 0,
                    hoverOffset: 4
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: true,
                cutout: '70%',
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: {
                            padding: 20,
                            usePointStyle: true,
                            pointStyle: 'circle'
                        }
                    }
                }
            }
        });

        // Gender Chart
        const genderCtx = document.getElementById('genderChart').getContext('2d');
        new Chart(genderCtx, {
            type: 'pie',
            data: {
                labels: ['Laki-laki', 'Perempuan'],
                datasets: [{
                    data: [{{ $stats['male'] ?? 0 }}, {{ $stats['female'] ?? 0 }}],
                    backgroundColor: ['#3b82f6', '#ec4899'], // blue-500, pink-500
                    borderWidth: 0,
                    hoverOffset: 4
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: true,
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: {
                            padding: 20,
                            usePointStyle: true,
                            pointStyle: 'circle'
                        }
                    }
                }
            }
        });
    </script>
@endsection