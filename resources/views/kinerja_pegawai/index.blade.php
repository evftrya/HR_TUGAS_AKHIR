@extends('kinerja_pegawai.base')

@section('header-base')
    <style>
        .max-w-100 { max-width: 100% !important; }
        .chart-container { position: relative; height: 350px; width: 100%; margin-top: 20px; }
    </style>
    {{-- WAJIB: Chart.js --}}
    <script src="https://cdn.jsdelivr.net/npm/chart.js" defer></script>
@endsection

@section('page-name')
    <div class="flex flex-col gap-[3px] px-1 pt-3 pb-2">
        <span class="font-semibold text-2xl text-[#101828]">Dashboard Kinerja Pegawai</span>
        <span class="text-xs text-gray-400">Ringkasan target, capaian, dan laporan pekerjaan</span>
    </div>
@endsection

@section('content-base')

    {{-- ── Achievement & Wall of Fame (Fitur 2A5) ─────── --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-6">
        {{-- My Badges --}}
        <div class="lg:col-span-1 bg-white rounded-3xl border border-gray-100 shadow-sm p-6">
            <div class="flex items-center gap-2 mb-6">
                <i class="fa-solid fa-award text-blue-500"></i>
                <h3 class="text-xs font-bold text-gray-800 uppercase tracking-widest">Lencana Saya</h3>
            </div>
            
            <div class="flex flex-col gap-4">
                @if($badges['reliable'])
                    <div class="flex items-center gap-3 p-3 bg-amber-50 rounded-2xl border border-amber-100 group transition-all hover:shadow-md"
                        title="The Reliable: Memiliki 10 laporan 'Approved' berturut-turut tanpa penolakan.">
                        <div class="w-10 h-10 rounded-full bg-amber-100 flex items-center justify-center text-amber-600 border-2 border-amber-400 flex-shrink-0">
                            <i class="fa-solid fa-medal text-lg"></i>
                        </div>
                        <div>
                            <p class="text-[10px] font-black text-amber-800 uppercase">The Reliable</p>
                            <p class="text-[9px] text-amber-600 font-medium leading-tight">Kualitas Laporan Terbaik</p>
                        </div>
                    </div>
                @endif

                @if($badges['speedy'])
                    <div class="flex items-center gap-3 p-3 bg-blue-50 rounded-2xl border border-blue-100 group transition-all hover:shadow-md"
                        title="Speedy Submitter: Rata-rata waktu input laporan dilakukan sebelum jam 17:00.">
                        <div class="w-10 h-10 rounded-full bg-blue-100 flex items-center justify-center text-blue-600 border-2 border-blue-400 flex-shrink-0">
                            <i class="fa-solid fa-bolt-lightning text-lg"></i>
                        </div>
                        <div>
                            <p class="text-[10px] font-black text-blue-800 uppercase">Speedy Submitter</p>
                            <p class="text-[9px] text-blue-600 font-medium leading-tight">Responsivitas Tinggi</p>
                        </div>
                    </div>
                @endif

                @if(!$badges['reliable'] && !$badges['speedy'])
                    <div class="flex flex-col items-center justify-center py-4 bg-gray-50 rounded-2xl border border-gray-100 border-dashed">
                        <p class="text-[10px] font-bold text-gray-400 uppercase">Belum Ada Lencana</p>
                        <p class="text-[8px] text-gray-300 mt-1">Lapor rutin untuk koleksi lencana!</p>
                    </div>
                @endif
            </div>
        </div>

        {{-- Recent Achievements (Wall of Fame) --}}
        <div class="lg:col-span-2 bg-white rounded-3xl border border-gray-100 shadow-sm p-6">
            <div class="flex items-center gap-2 mb-6">
                <i class="fa-solid fa-trophy text-yellow-500"></i>
                <h3 class="text-xs font-bold text-gray-800 uppercase tracking-widest">Pencapaian Terbaru Pegawai</h3>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                @foreach($recentAchievements as $ach)
                    <div class="flex items-center gap-3 p-3 rounded-2xl border border-gray-50 bg-gray-50/30">
                        <div class="w-8 h-8 rounded-full bg-blue-100 flex items-center justify-center text-blue-600 font-bold text-[10px]">
                            {{ strtoupper(substr($ach['user']->nama_lengkap, 0, 1)) }}
                        </div>
                        <div class="flex-1">
                            <p class="text-[10px] font-bold text-gray-900 truncate">{{ $ach['user']->nama_lengkap }}</p>
                            <div class="flex gap-1 mt-1">
                                @if($ach['badges']['reliable'])
                                    <i class="fa-solid fa-medal text-[10px] text-amber-500" title="The Reliable"></i>
                                @endif
                                @if($ach['badges']['speedy'])
                                    <i class="fa-solid fa-bolt-lightning text-[10px] text-blue-500" title="Speedy Submitter"></i>
                                @endif
                            </div>
                        </div>
                        <div class="text-[8px] font-bold text-gray-400 uppercase bg-white px-2 py-1 rounded-full border border-gray-100">
                            Baru Saja
                        </div>
                    </div>
                @endforeach

                @if(empty($recentAchievements))
                    <div class="col-span-full py-8 text-center bg-gray-50 rounded-2xl border border-gray-100 border-dashed">
                        <p class="text-[10px] text-gray-400 font-medium">Belum ada pegawai yang meraih lencana baru-baru ini.</p>
                    </div>
                @endif
            </div>
        </div>
    </div>

    {{-- ── Stat Cards ────────────────────────────────── --}}
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-5 mb-6">
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6 flex items-center gap-4 group hover:shadow-md transition-all">
            <div class="p-4 bg-blue-50 rounded-2xl text-blue-600 group-hover:bg-blue-600 group-hover:text-white transition-colors flex-shrink-0">
                <i class="fa-solid fa-bullseye fa-xl"></i>
            </div>
            <div>
                <p class="text-3xl font-black text-gray-900">{{ $totalTarget }}</p>
                <p class="text-xs font-bold text-gray-400 uppercase tracking-widest mt-0.5">KPI Strategis Aktif</p>
            </div>
        </div>

        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6 flex items-center gap-4 group hover:shadow-md transition-all">
            <div class="p-4 bg-green-50 rounded-2xl text-green-600 group-hover:bg-green-600 group-hover:text-white transition-colors flex-shrink-0">
                <i class="fa-solid fa-calendar-day fa-xl"></i>
            </div>
            <div>
                <p class="text-3xl font-black text-gray-900">{{ $totalHarian }}</p>
                <p class="text-xs font-bold text-gray-400 uppercase tracking-widest mt-0.5">Target Harian Aktif</p>
            </div>
        </div>

        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6 flex items-center gap-4 group hover:shadow-md transition-all">
            <div class="p-4 bg-yellow-50 rounded-2xl text-yellow-600 group-hover:bg-yellow-500 group-hover:text-white transition-colors flex-shrink-0">
                <i class="fa-solid fa-check-double fa-xl"></i>
            </div>
            <div>
                <p class="text-3xl font-black text-gray-900">{{ $laporanPending }}</p>
                <p class="text-xs font-bold text-gray-400 uppercase tracking-widest mt-0.5">Approval Pending</p>
            </div>
        </div>
    </div>

    {{-- ── Productivity Line Chart ──────────────────── --}}
    <div class="bg-white rounded-3xl border border-gray-100 shadow-sm p-8 mb-6">
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-6 mb-8">
            <div>
                <h3 class="font-bold text-gray-900 tracking-tight text-xl">Productivity Pulse (90 Days)</h3>
                <p class="text-sm text-gray-500 mt-1">Tren akumulasi output jam kerja seluruh pegawai</p>
            </div>

            <div class="flex flex-wrap gap-4">
                <div class="px-4 py-3 bg-gray-50 rounded-2xl border border-gray-100 text-center min-w-[100px]">
                    <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-1">90-Day Trend</p>
                    <div class="flex items-center justify-center gap-1.5">
                        @if($stats['trend'] >= 0)
                            <i class="fa-solid fa-arrow-trend-up text-green-500 text-xs"></i>
                            <p class="text-base font-black text-green-600">+{{ $stats['trend'] }}%</p>
                        @else
                            <i class="fa-solid fa-arrow-trend-down text-red-500 text-xs"></i>
                            <p class="text-base font-black text-red-600">{{ $stats['trend'] }}%</p>
                        @endif
                    </div>
                </div>
                <div class="px-4 py-3 bg-gray-50 rounded-2xl border border-gray-100 text-center min-w-[100px]">
                    <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-1">Total Output</p>
                    <p class="text-base font-black text-gray-900">{{ number_format($stats['total_hours']) }}h</p>
                </div>
                <div class="px-4 py-3 bg-gray-50 rounded-2xl border border-gray-100 text-center min-w-[100px]">
                    <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-1">Avg/Day</p>
                    <p class="text-base font-black text-gray-900">{{ $stats['avg_daily'] }}h</p>
                </div>
            </div>
        </div>

        <div class="chart-container">
            <canvas id="productivityLineChart"></canvas>
        </div>
    </div>

    {{-- ── Tabel Laporan Terkini ─────────────────────── --}}
    <div class="flex flex-grow-0 flex-col gap-2 max-w-100 mt-2">
        <div class="px-1 mb-2">
            <h3 class="font-bold text-gray-900 tracking-tight text-lg">Laporan Pekerjaan Terkini</h3>
            <p class="text-xs text-gray-500">10 laporan masuk terakhir</p>
        </div>

        <x-tb id="dashboardTerkiniTable" :search_status="false">
            <x-slot:table_header>
                <x-tb-td nama="pegawai">Pegawai</x-tb-td>
                <x-tb-td nama="target">Target Harian</x-tb-td>
                <x-tb-td nama="tanggal">Tanggal</x-tb-td>
                <x-tb-td nama="status">Status</x-tb-td>
                <x-tb-td nama="aksi">Aksi</x-tb-td>
            </x-slot:table_header>
            <x-slot:table_column>
                @foreach ($laporanTerkini as $laporan)
                    <x-tb-cl id="{{ $laporan->id }}">
                        <x-tb-cl-fill>
                            <span class="font-semibold text-gray-900 text-xs">{{ $laporan->pelapor?->nama_lengkap ?? '-' }}</span>
                        </x-tb-cl-fill>
                        <x-tb-cl-fill>
                            <span class="text-xs text-gray-600">{{ $laporan->targetHarian?->pekerjaan ?? '-' }}</span>
                        </x-tb-cl-fill>
                        <x-tb-cl-fill>
                            <span class="text-xs text-gray-500">{{ $laporan->created_at?->format('d M Y') }}</span>
                        </x-tb-cl-fill>
                        <x-tb-cl-fill>
                            <span class="px-2 py-1 rounded-full text-[10px] font-black uppercase border {{ $laporan->status == 'approved' ? 'bg-green-50 text-green-700' : 'bg-yellow-50 text-yellow-700' }}">
                                {{ $laporan->status }}
                            </span>
                        </x-tb-cl-fill>
                        <x-tb-cl-fill>
                             @if ($laporan->status === 'pending')
                                <a href="{{ route('manage.target-kinerja.harian.reports.approval', $laporan->id) }}" class="text-xs font-bold text-blue-600">Review</a>
                             @endif
                        </x-tb-cl-fill>
                    </x-tb-cl>
                @endforeach
            </x-slot:table_column>
        </x-tb>
    </div>

    {{-- LOGIKA CHART JS --}}
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const data = @json($heatmapData);

            const labels = data.map(i => {
                const d = new Date(i.x);
                return `${d.getDate()} ${d.toLocaleString('default', { month: 'short' })}`;
            });
            const values = data.map(i => i.y);
            const contributors = data.map(i => i.contributors);
            const topNames = data.map(i => i.top_names);

            const ctx = document.getElementById('productivityLineChart').getContext('2d');

            // Background Gradient
            const gradient = ctx.createLinearGradient(0, 0, 0, 300);
            gradient.addColorStop(0, 'rgba(37, 99, 235, 0.2)');
            gradient.addColorStop(1, 'rgba(37, 99, 235, 0)');

            new Chart(ctx, {
                type: 'line',
                data: {
                    labels: labels,
                    datasets: [{
                        data: values,
                        borderColor: '#2563eb',
                        borderWidth: 3,
                        backgroundColor: gradient,
                        fill: true,
                        tension: 0.4,
                        pointRadius: 0,
                        pointHoverRadius: 6,
                        pointHoverBackgroundColor: '#2563eb',
                        pointHoverBorderColor: '#fff',
                        pointHoverBorderWidth: 2,
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { display: false },
                        tooltip: {
                            backgroundColor: '#fff',
                            titleColor: '#111827',
                            bodyColor: '#4b5563',
                            borderColor: '#e5e7eb',
                            borderWidth: 1,
                            padding: 16,
                            cornerRadius: 12,
                            displayColors: false,
                            callbacks: {
                                title: (ctx) => data[ctx[0].dataIndex].x,
                                label: (ctx) => {
                                    const i = ctx.dataIndex;
                                    return [
                                        `Output: ${values[i]} Jam`,
                                        `Pegawai: ${contributors[i]} Orang`,
                                        `Top: ${topNames[i]}`
                                    ];
                                }
                            }
                        }
                    },
                    scales: {
                        x: {
                            grid: { display: false },
                            ticks: { maxTicksLimit: 10, font: { size: 10 }, color: '#9ca3af' }
                        },
                        y: {
                            beginAtZero: true,
                            grid: { color: '#f3f4f6', drawBorder: false },
                            ticks: { font: { size: 10 }, color: '#9ca3af', callback: v => v + 'h' }
                        }
                    },
                    interaction: { intersect: false, mode: 'index' }
                }
            });
        });
    </script>
@endsection
