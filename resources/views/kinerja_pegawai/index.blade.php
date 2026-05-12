@php
    $active_sidebar = 'Beranda Kinerja';
@endphp

@extends('kinerja_pegawai.base')

@section('header-base')
    <script src="https://cdn.jsdelivr.net/npm/chart.js" defer></script>
    <style>
        .stats-card {
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }
        .stats-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.05);
        }
    </style>
@endsection

@section('page-name', 'Dashboard Kinerja Pegawai')

@section('content-base')
<div class="w-full max-w-7xl mx-auto space-y-8 pb-10">
    <div class="mb-4">
        <p class="text-sm text-gray-500 italic">Ringkasan target, capaian, dan rekapitulasi laporan pekerjaan.</p>
    </div>
    
    {{-- Key Stats Row --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
        <div class="bg-white p-6 rounded-xl border border-gray-100 shadow-sm stats-card">
            <div class="flex items-center justify-between mb-4">
                <div class="w-10 h-10 rounded-lg bg-blue-50 flex items-center justify-center text-blue-600">
                    <i class="fa-solid fa-bullseye"></i>
                </div>
                <span class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">Master KPI</span>
            </div>
            <p class="text-3xl font-black text-gray-800">{{ $totalTarget }}</p>
            <p class="text-xs text-gray-400 mt-1 font-medium">Indikator Aktif</p>
        </div>

        <div class="bg-white p-6 rounded-xl border border-gray-100 shadow-sm stats-card">
            <div class="flex items-center justify-between mb-4">
                <div class="w-10 h-10 rounded-lg bg-amber-50 flex items-center justify-center text-amber-600">
                    <i class="fa-solid fa-clock-rotate-left"></i>
                </div>
                <span class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">Pending</span>
            </div>
            <p class="text-3xl font-black text-gray-800">{{ $laporanPending }}</p>
            <p class="text-xs text-gray-400 mt-1 font-medium">Laporan Menunggu</p>
        </div>

        <div class="bg-white p-6 rounded-xl border border-gray-100 shadow-sm stats-card">
            <div class="flex items-center justify-between mb-4">
                <div class="w-10 h-10 rounded-lg bg-green-50 flex items-center justify-center text-green-600">
                    <i class="fa-solid fa-check-double"></i>
                </div>
                <span class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">Total Waktu</span>
            </div>
            <p class="text-3xl font-black text-gray-800">{{ $stats['total_hours'] }}</p>
            <p class="text-xs text-gray-400 mt-1 font-medium">Jam Kerja Tervalidasi</p>
        </div>

        <div class="bg-white p-6 rounded-xl border border-gray-100 shadow-sm stats-card">
            <div class="flex items-center justify-between mb-4">
                <div class="w-10 h-10 rounded-lg bg-indigo-50 flex items-center justify-center text-indigo-600">
                    <i class="fa-solid fa-chart-line"></i>
                </div>
                <span class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">Tren</span>
            </div>
            <p class="text-3xl font-black {{ $stats['trend'] >= 0 ? 'text-green-600' : 'text-red-600' }}">
                {{ $stats['trend'] >= 0 ? '+' : '' }}{{ $stats['trend'] }}%
            </p>
            <p class="text-xs text-gray-400 mt-1 font-medium">Vs 90 Hari Lalu</p>
        </div>
    </div>

    {{-- Achievement & Wall of Fame --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        {{-- My Badges --}}
        <div class="lg:col-span-1 bg-white p-6 rounded-xl shadow-sm border border-gray-100">
            <div class="flex items-center gap-2 mb-6">
                <i class="fa-solid fa-award text-blue-500"></i>
                <h3 class="text-lg font-semibold text-gray-700">Lencana Saya</h3>
            </div>
            
            <div class="space-y-4">
                @if($badges['reliable'])
                    <div class="flex items-center gap-4 p-4 bg-amber-50 rounded-xl border border-amber-100 transition-all hover:shadow-md" title="Kualitas Laporan Terbaik">
                        <div class="w-12 h-12 rounded-full bg-amber-100 flex items-center justify-center text-amber-600 border-2 border-amber-400 shrink-0">
                            <i class="fa-solid fa-medal text-xl"></i>
                        </div>
                        <div>
                            <p class="text-xs font-bold text-amber-800 uppercase tracking-tight">The Reliable</p>
                            <p class="text-[10px] text-amber-600 font-medium leading-tight">10+ Laporan Disetujui Beruntun</p>
                        </div>
                    </div>
                @endif

                @if($badges['speedy'])
                    <div class="flex items-center gap-4 p-4 bg-blue-50 rounded-xl border border-blue-100 transition-all hover:shadow-md" title="Responsivitas Tinggi">
                        <div class="w-12 h-12 rounded-full bg-blue-100 flex items-center justify-center text-blue-600 border-2 border-blue-400 shrink-0">
                            <i class="fa-solid fa-bolt-lightning text-xl"></i>
                        </div>
                        <div>
                            <p class="text-xs font-bold text-blue-800 uppercase tracking-tight">Speedy Submitter</p>
                            <p class="text-[10px] text-blue-600 font-medium leading-tight">Input Laporan Selalu Tepat Waktu</p>
                        </div>
                    </div>
                @endif

                @if(!$badges['reliable'] && !$badges['speedy'])
                    <div class="flex flex-col items-center justify-center py-10 bg-gray-50 rounded-xl border border-gray-100 border-dashed text-center">
                        <i class="fa-solid fa-trophy text-3xl text-gray-200 mb-2"></i>
                        <p class="text-xs font-bold text-gray-400 uppercase">Belum Ada Lencana</p>
                        <p class="text-[10px] text-gray-300 mt-1">Lapor rutin untuk meraih prestasi!</p>
                    </div>
                @endif
            </div>
        </div>

        {{-- Recent Achievements (Wall of Fame) --}}
        <div class="lg:col-span-2 bg-white p-6 rounded-xl shadow-sm border border-gray-100">
            <div class="flex items-center gap-2 mb-6">
                <i class="fa-solid fa-fire text-orange-500"></i>
                <h3 class="text-lg font-semibold text-gray-700">Pencapaian Terbaru Pegawai</h3>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                @forelse($recentAchievements as $ach)
                    <div class="flex items-center justify-between p-4 rounded-xl bg-gray-50 border border-gray-100 group transition-all hover:bg-white hover:shadow-sm">
                        <div class="flex items-center gap-3 overflow-hidden">
                            <div class="w-10 h-10 rounded-full bg-indigo-50 flex items-center justify-center text-indigo-600 font-bold text-sm border border-indigo-100 shrink-0">
                                {{ strtoupper(substr($ach['user']->nama_lengkap, 0, 1)) }}
                            </div>
                            <div class="overflow-hidden">
                                <p class="text-xs font-bold text-gray-800 truncate">{{ $ach['user']->nama_lengkap }}</p>
                                <div class="flex gap-1.5 mt-1">
                                    @if($ach['badges']['reliable'])
                                        <i class="fa-solid fa-medal text-[11px] text-amber-500" title="The Reliable"></i>
                                    @endif
                                    @if($ach['badges']['speedy'])
                                        <i class="fa-solid fa-bolt-lightning text-[11px] text-blue-500" title="Speedy Submitter"></i>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="text-[9px] font-black text-gray-400 uppercase bg-white px-2 py-1 rounded-full border border-gray-100 shrink-0">
                            Baru Saja
                        </div>
                    </div>
                @empty
                    <div class="col-span-full py-12 text-center bg-gray-50 rounded-xl border border-gray-100 border-dashed">
                        <p class="text-xs font-medium text-gray-400 italic">Belum ada aktivitas lencana terbaru.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>

    {{-- Chart / Activity Section --}}
    <div class="bg-white p-8 rounded-xl shadow-sm border border-gray-100">
        <div class="flex items-center justify-between mb-8">
            <div>
                <h3 class="text-lg font-semibold text-gray-700">Analisis Beban Kerja (90 Hari Terakhir)</h3>
                <p class="text-xs text-gray-400 mt-1 font-medium italic">Menampilkan akumulasi jam kerja tervalidasi per hari.</p>
            </div>
            <div class="text-right">
                <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">Puncak Aktivitas</p>
                <p class="text-sm font-bold text-gray-800">{{ $stats['peak_day'] }} ({{ $stats['peak_value'] }} Jam)</p>
            </div>
        </div>
        <div class="h-[350px] w-full">
             <canvas id="performanceChart"></canvas>
        </div>
    </div>

</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const ctx = document.getElementById('performanceChart').getContext('2d');
    const heatmapData = @json($heatmapData);

    new Chart(ctx, {
        type: 'line',
        data: {
            labels: heatmapData.map(d => d.x),
            datasets: [{
                label: 'Jam Kerja (Validasi)',
                data: heatmapData.map(d => d.y),
                borderColor: '#2563eb',
                backgroundColor: 'rgba(37, 99, 235, 0.1)',
                borderWidth: 3,
                fill: true,
                tension: 0.4,
                pointRadius: 0,
                pointHoverRadius: 6,
                pointHoverBackgroundColor: '#2563eb',
                pointHoverBorderColor: '#fff',
                pointHoverBorderWidth: 2
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { display: false },
                tooltip: {
                    backgroundColor: '#1e293b',
                    titleFont: { size: 11 },
                    bodyFont: { size: 12 },
                    padding: 12,
                    cornerRadius: 8,
                    callbacks: {
                        label: function(context) {
                            const item = heatmapData[context.dataIndex];
                            return ` Total: ${item.y} Jam (${item.contributors} Pegawai)`;
                        },
                        afterLabel: function(context) {
                            const item = heatmapData[context.dataIndex];
                            return ` Top: ${item.top_names}`;
                        }
                    }
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    grid: { color: '#f1f5f9' },
                    ticks: {
                        font: { size: 10 },
                        color: '#94a3b8'
                    }
                },
                x: {
                    grid: { display: false },
                    ticks: {
                        autoSkip: true,
                        maxTicksLimit: 10,
                        font: { size: 10 },
                        color: '#94a3b8'
                    }
                }
            }
        }
    });
});
</script>
@endsection
