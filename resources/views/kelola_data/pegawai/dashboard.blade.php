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
    <div
        class="flex flex-col md:flex-row items-center gap-[11.749480247497559px] self-stretch px-1 pt-[14.686850547790527px] pb-[13.952507972717285px]">
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
    <div class="flex flex-col gap-6 w-full max-w-100">
        <!-- Statistics Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
            <!-- Total Pegawai -->
            <div class="bg-white rounded-lg p-6 shadow border border-gray-200">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-500 text-sm font-medium">Total Pegawai</p>
                        <h3 class="text-3xl font-bold text-gray-900 mt-2">{{ $stats['total'] ?? 0 }}</h3>
                    </div>
                    <div class="bg-blue-50 p-3 rounded-lg">
                        <i class="fas fa-users text-2xl text-blue-600"></i>
                    </div>
                </div>
            </div>

            <!-- Dosen -->
            <div class="bg-white rounded-lg p-6 shadow border border-gray-200">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-500 text-sm font-medium">Dosen</p>
                        <h3 class="text-3xl font-bold text-gray-900 mt-2">{{ $stats['dosen'] ?? 0 }}</h3>
                    </div>
                    <div class="bg-green-50 p-3 rounded-lg">
                        <i class="fas fa-chalkboard-user text-2xl text-green-600"></i>
                    </div>
                </div>
            </div>

            <!-- TPA -->
            <div class="bg-white rounded-lg p-6 shadow border border-gray-200">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-500 text-sm font-medium">Tenaga Pendukung</p>
                        <h3 class="text-3xl font-bold text-gray-900 mt-2">{{ $stats['tpa'] ?? 0 }}</h3>
                    </div>
                    <div class="bg-purple-50 p-3 rounded-lg">
                        <i class="fas fa-user-tie text-2xl text-purple-600"></i>
                    </div>
                </div>
            </div>

            <!-- Pegawai Aktif -->
            <div class="bg-white rounded-lg p-6 shadow border border-gray-200">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-500 text-sm font-medium">Pegawai Aktif</p>
                        <h3 class="text-3xl font-bold text-gray-900 mt-2">{{ $stats['active'] ?? 0 }}</h3>
                    </div>
                    <div class="bg-orange-50 p-3 rounded-lg">
                        <i class="fas fa-user-check text-2xl text-orange-600"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Charts Row -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <!-- Status Pegawai Chart -->
            <div class="bg-white rounded-lg shadow border border-gray-200 p-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">Distribusi Status Pegawai</h3>
                <canvas id="statusChart" height="200"></canvas>
            </div>

            <!-- Jenis Kelamin Chart -->
            <div class="bg-white rounded-lg shadow border border-gray-200 p-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">Distribusi Jenis Kelamin</h3>
                <canvas id="genderChart" height="200"></canvas>
            </div>
        </div>

        <!-- Recent Activities -->
        <div class="bg-white rounded-lg shadow border border-gray-200">
            <div class="flex justify-between items-center p-4 border-b">
                <h3 class="text-lg font-semibold text-gray-800">Pegawai Terbaru</h3>
                <div class="text-sm text-gray-600">
                    Menampilkan 10 pegawai terbaru
                </div>
            </div>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200 text-sm">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">Nama</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">Tipe</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">Email</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">Tanggal Bergabung</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">Status</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($recentEmployees as $employee)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-medium text-gray-900">{{ $employee->nama_lengkap }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                        {{ $employee->tipe_pegawai == 'Dosen' ? 'bg-green-100 text-green-800' : 'bg-purple-100 text-purple-800' }}">
                                        {{ $employee->tipe_pegawai }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $employee->email_institusi }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ \Carbon\Carbon::parse($employee->tgl_bergabung)->format('d M Y') }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                        {{ $employee->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                        {{ $employee->is_active ? 'Aktif' : 'Tidak Aktif' }}
                                    </span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-8 text-center text-gray-500">
                                    Belum ada data pegawai
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
    // Status Pegawai Chart
    const statusCtx = document.getElementById('statusChart').getContext('2d');
    new Chart(statusCtx, {
        type: 'doughnut',
        data: {
            labels: ['Dosen', 'TPA'],
            datasets: [{
                data: [{{ $stats['dosen'] ?? 0 }}, {{ $stats['tpa'] ?? 0 }}],
                backgroundColor: ['#10b981', '#8b5cf6'],
                borderWidth: 0
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: true,
            plugins: {
                legend: {
                    position: 'bottom',
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
                backgroundColor: ['#3b82f6', '#ec4899'],
                borderWidth: 0
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: true,
            plugins: {
                legend: {
                    position: 'bottom',
                }
            }
        }
    });
</script>
@endsection
