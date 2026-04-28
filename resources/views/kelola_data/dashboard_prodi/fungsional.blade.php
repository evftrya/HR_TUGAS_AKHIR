@extends('kelola_data.base')

@section('header-base')
    <script src="https://cdn.jsdelivr.net/npm/chart.js" defer></script>
    <style>
        /* No custom styles needed - using existing design system */
    </style>
@endsection

@section('page-name')
    <div
        class="flex flex-col md:flex-row items-center gap-[11.749480247497559px] self-stretch px-1 pt-[14.686850547790527px] pb-[13.952507972717285px]">
        <div class="flex w-full flex-col gap-[2.9373700618743896px] grow">
            <div class="flex items-center gap-[5.874740123748779px] self-stretch">
                <span class="font-medium text-2xl leading-[20.56159019470215px] text-[#101828]">Dashboard Jabatan
                    Fungsional</span>
            </div>
            <span class="font-normal text-[10.280795097351074px] leading-[14.686850547790527px] text-[#1f2028]">
                Statistik jabatan fungsional akademik dosen per program studi
            </span>
        </div>
        <div class="flex items-center w-full justify-end gap-[11.749480247497559px]">
            <button onclick="printTable()" class="flex rounded-[5.874740123748779px]">
                <div
                    class="flex justify-center items-center gap-[5.874740123748779px] bg-gray-600 px-[11.749480247497559px] py-[7.343425273895264px] rounded-[5.874740123748779px] border border-gray-600 hover:bg-gray-700 transition">
                    <i class="bi bi-printer text-sm text-white"></i>
                    <span class="font-medium text-[10.28px] leading-[14.68px] text-white">Print</span>
                </div>
            </button>
            <button onclick="exportToCSV()" class="flex rounded-[5.874740123748779px]">
                <div
                    class="flex justify-center items-center gap-[5.874740123748779px] bg-green-600 px-[11.749480247497559px] py-[7.343425273895264px] rounded-[5.874740123748779px] border border-green-600 hover:bg-green-700 transition">
                    <i class="bi bi-file-earmark-excel text-sm text-white"></i>
                    <span class="font-medium text-[10.28px] leading-[14.68px] text-white">Export CSV</span>
                </div>
            </button>
        </div>
    </div>
@endsection

@section('content-base')
    {{-- Chart & Summary Combined --}}
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
        <div class="bg-white rounded-lg shadow p-5 border border-gray-200">
            <h4 class="text-md font-semibold text-gray-800 mb-4">Distribusi Jabatan Fungsional</h4>
            <div class="flex justify-center">
                <canvas id="fungsionalChart" style="max-height: 280px;"></canvas>
            </div>
        </div>
        <div class="bg-white rounded-lg shadow p-5 border border-gray-200">
            <h4 class="text-md font-semibold text-gray-800 mb-4">Statistik Jabatan Fungsional</h4>
            <div class="space-y-2">
                <div class="flex items-center justify-between p-2 bg-gray-50 rounded border border-gray-200">
                    <div class="flex items-center gap-2">
                        <div class="w-3 h-3 bg-gray-500 rounded"></div>
                        <span class="text-xs font-medium text-gray-700">NJAD</span>
                    </div>
                    <div class="text-sm font-bold text-gray-900">{{ $totals['njad'] }}</div>
                </div>
                <div class="flex items-center justify-between p-2 bg-gray-50 rounded border border-gray-200">
                    <div class="flex items-center gap-2">
                        <div class="w-3 h-3 bg-yellow-500 rounded"></div>
                        <span class="text-xs font-medium text-gray-700">Asisten Ahli</span>
                    </div>
                    <div class="text-sm font-bold text-gray-900">{{ $totals['aa'] }}</div>
                </div>
                <div class="flex items-center justify-between p-2 bg-gray-50 rounded border border-gray-200">
                    <div class="flex items-center gap-2">
                        <div class="w-3 h-3 bg-blue-500 rounded"></div>
                        <span class="text-xs font-medium text-gray-700">Lektor</span>
                    </div>
                    <div class="text-sm font-bold text-gray-900">{{ $totals['l'] }}</div>
                </div>
                <div class="flex items-center justify-between p-2 bg-gray-50 rounded border border-gray-200">
                    <div class="flex items-center gap-2">
                        <div class="w-3 h-3 bg-purple-500 rounded"></div>
                        <span class="text-xs font-medium text-gray-700">Lektor Kepala</span>
                    </div>
                    <div class="text-sm font-bold text-gray-900">{{ $totals['lk'] }}</div>
                </div>
                <div class="flex items-center justify-between p-2 bg-gray-50 rounded border border-gray-200">
                    <div class="flex items-center gap-2">
                        <div class="w-3 h-3 bg-red-500 rounded"></div>
                        <span class="text-xs font-medium text-gray-700">Guru Besar</span>
                    </div>
                    <div class="text-sm font-bold text-gray-900">{{ $totals['gb'] }}</div>
                </div>
                <div class="grid grid-cols-2 gap-2 mt-3">
                    <div class="p-3 bg-yellow-50 rounded-lg border border-yellow-200">
                        <div class="text-xs text-yellow-700 font-medium">LLKGB</div>
                        <div class="text-xl font-bold text-yellow-900">{{ number_format($totals['llkgb'] * 100, 1) }}%</div>
                        <div class="text-xs text-yellow-600">{{ $totals['l'] + $totals['lk'] + $totals['gb'] }} dosen</div>
                    </div>
                    <div class="p-3 bg-green-50 rounded-lg border border-green-200">
                        <div class="text-xs text-green-700 font-medium">JFA</div>
                        <div class="text-xl font-bold text-green-900">{{ number_format($totals['jfa'] * 100, 1) }}%</div>
                        <div class="text-xs text-green-600">
                            {{ $totals['aa'] + $totals['l'] + $totals['lk'] + $totals['gb'] }} dosen</div>
                    </div>
                </div>
                <div class="flex items-center justify-between p-3 bg-gray-100 rounded-lg border border-gray-300 mt-2">
                    <div class="flex items-center gap-2">
                        <div class="p-2 bg-gray-600 rounded-lg">
                            <i class="bi bi-people-fill text-lg text-white"></i>
                        </div>
                        <span class="text-sm font-semibold text-gray-900">Total Dosen</span>
                    </div>
                    <span class="text-2xl font-bold text-gray-900">{{ $totals['total_dosen'] }}</span>
                </div>
            </div>
        </div>
    </div>

    {{-- Data Table --}}
    <div class="overflow-x-auto bg-white rounded-lg shadow">
        <div class="flex justify-between items-center p-4 border-b">
            <h3 class="text-lg font-semibold text-gray-800">Rekapitulasi Jabatan Fungsional per Program Studi</h3>
        </div>

        <table id="fungsionalTable" class="min-w-full divide-y divide-gray-200 text-sm">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-3 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider border">No.
                    </th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider border">Prodi
                    </th>
                    <th class="px-3 py-3 text-center text-xs font-medium text-gray-700 uppercase tracking-wider border">
                        Total</th>
                    <th class="px-3 py-3 text-center text-xs font-medium text-gray-700 uppercase tracking-wider border">NJAD
                    </th>
                    <th class="px-3 py-3 text-center text-xs font-medium text-gray-700 uppercase tracking-wider border">AA
                    </th>
                    <th class="px-3 py-3 text-center text-xs font-medium text-gray-700 uppercase tracking-wider border">L
                    </th>
                    <th class="px-3 py-3 text-center text-xs font-medium text-gray-700 uppercase tracking-wider border">LK
                    </th>
                    <th class="px-3 py-3 text-center text-xs font-medium text-gray-700 uppercase tracking-wider border">GB
                    </th>
                    <th class="px-3 py-3 text-center text-xs font-medium text-gray-700 uppercase tracking-wider border">
                        LLKGB</th>
                    <th class="px-3 py-3 text-center text-xs font-medium text-gray-700 uppercase tracking-wider border">JFA
                    </th>
                    <th class="px-3 py-3 text-center text-xs font-medium text-gray-700 uppercase tracking-wider border">Aksi
                    </th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse ($prodiStats as $index => $stat)
                    <tr class="hover:bg-gray-50">
                        <td class="px-3 py-3 text-center border">{{ $index + 1 }}</td>
                        <td class="px-4 py-3 text-left border">
                            <div class="font-medium text-gray-900">{{ $stat['nama_prodi'] }}</div>
                            <div class="text-xs text-gray-500">{{ $stat['fakultas'] }}</div>
                        </td>
                        <td class="px-3 py-3 text-center border font-semibold">{{ $stat['total_dosen'] }}</td>
                        <td class="px-3 py-3 text-center border">{{ $stat['njad'] }}</td>
                        <td class="px-3 py-3 text-center border">
                            <span class="px-2 py-1 bg-yellow-100 text-yellow-800 rounded">{{ $stat['aa'] }}</span>
                        </td>
                        <td class="px-3 py-3 text-center border">
                            <span class="px-2 py-1 bg-blue-100 text-blue-800 rounded">{{ $stat['l'] }}</span>
                        </td>
                        <td class="px-3 py-3 text-center border">
                            <span class="px-2 py-1 bg-purple-100 text-purple-800 rounded">{{ $stat['lk'] }}</span>
                        </td>
                        <td class="px-3 py-3 text-center border">
                            <span class="px-2 py-1 bg-red-100 text-red-800 rounded">{{ $stat['gb'] }}</span>
                        </td>
                        <td class="px-3 py-3 text-center border">
                            <span class="font-semibold text-gray-700">{{ number_format($stat['llkgb'] * 100, 2) }}%</span>
                        </td>
                        <td class="px-3 py-3 text-center border">
                            <span class="font-semibold text-gray-700">{{ number_format($stat['jfa'] * 100, 2) }}%</span>
                        </td>
                        <td class="px-3 py-3 text-center border">
                            @if (
                                $stat['total_dosen'] == 0 ||
                                    ($stat['njad'] == 0 && $stat['aa'] == 0 && $stat['l'] == 0 && $stat['lk'] == 0 && $stat['gb'] == 0))
                                <button
                                    onclick="openEditModal('{{ $stat['id'] }}', '{{ $stat['nama_prodi'] }}', {{ $stat['njad'] }}, {{ $stat['aa'] }}, {{ $stat['l'] }}, {{ $stat['lk'] }}, {{ $stat['gb'] }}, {{ $stat['total_dosen'] }})"
                                    class="px-3 py-1.5 bg-blue-600 text-white text-xs font-medium rounded hover:bg-blue-700 transition">
                                    <i class="bi bi-pencil-square"></i> Edit
                                </button>
                            @else
                                <span class="text-xs text-gray-400 italic">Auto</span>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="11" class="px-6 py-8 text-center text-gray-500">
                            Belum ada data program studi
                        </td>
                    </tr>
                @endforelse

                @if ($prodiStats->count() > 0)
                    <tr class="bg-gray-100 font-bold border-t-2 border-gray-300">
                        <td colspan="2" class="px-4 py-3 text-center border">TOTAL</td>
                        <td class="px-3 py-3 text-center border">{{ $totals['total_dosen'] }}</td>
                        <td class="px-3 py-3 text-center border">{{ $totals['njad'] }}</td>
                        <td class="px-3 py-3 text-center border">{{ $totals['aa'] }}</td>
                        <td class="px-3 py-3 text-center border">{{ $totals['l'] }}</td>
                        <td class="px-3 py-3 text-center border">{{ $totals['lk'] }}</td>
                        <td class="px-3 py-3 text-center border">{{ $totals['gb'] }}</td>
                        <td class="px-3 py-3 text-center border">{{ number_format($totals['llkgb'] * 100, 2) }}%</td>
                        <td class="px-3 py-3 text-center border">{{ number_format($totals['jfa'] * 100, 2) }}%</td>
                        <td class="px-3 py-3 text-center border">-</td>
                    </tr>
                @endif
            </tbody>
        </table>
    </div>

    {{-- Keterangan --}}
    <div class="mt-4 p-4 bg-white rounded-lg shadow-sm border border-gray-200">
        <h4 class="text-sm font-bold text-gray-900 mb-3 flex items-center gap-2">
            <i class="bi bi-info-circle-fill text-green-600"></i>
            Keterangan Jabatan Fungsional
        </h4>
        <div class="grid grid-cols-2 gap-2 text-xs text-gray-700">
            <div class="bg-gray-50 p-2 rounded border border-gray-200">
                <strong>NJAD:</strong> Non-JFA Dosen
            </div>
            <div class="bg-gray-50 p-2 rounded border border-gray-200">
                <strong>AA:</strong> Asisten Ahli
            </div>
            <div class="bg-gray-50 p-2 rounded border border-gray-200">
                <strong>L:</strong> Lektor
            </div>
            <div class="bg-gray-50 p-2 rounded border border-gray-200">
                <strong>LK:</strong> Lektor Kepala
            </div>
            <div class="bg-gray-50 p-2 rounded border border-gray-200">
                <strong>GB:</strong> Guru Besar
            </div>
            <div class="bg-gray-50 p-2 rounded border border-gray-200">
                <strong>LLKGB:</strong> Proporsi L + LK + GB
            </div>
            <div class="bg-gray-50 p-2 rounded border border-gray-200 col-span-2">
                <strong>JFA:</strong> Proporsi Dosen dengan Jabatan Fungsional Akademik
            </div>
        </div>
        <div class="mt-3 space-y-2">
            <div class="bg-gray-50 p-2 rounded border border-gray-200">
                <strong>Rumus LLKGB:</strong> <code class="text-xs bg-gray-100 px-2 py-1 rounded">= ((L + LK + GB) ÷ Total
                    Dosen) × 100%</code>
            </div>
            <div class="bg-gray-50 p-2 rounded border border-gray-200">
                <strong>Rumus JFA:</strong> <code class="text-xs bg-gray-100 px-2 py-1 rounded">= ((AA + L + LK + GB) ÷
                    Total Dosen) × 100%</code>
            </div>
        </div>
    </div>

    {{-- Modal Edit Data --}}
    <div id="editModal" class="fixed inset-0 z-50 hidden flex items-center justify-center">
        <div id="editModalBackdrop" class="absolute inset-0 bg-black bg-opacity-50"></div>
        <div class="relative bg-white rounded-lg shadow-xl w-full max-w-2xl mx-4 overflow-hidden z-10">
            <!-- Header -->
            <div class="bg-green-600 px-6 py-4">
                <h2 class="text-xl font-semibold text-white">Edit Data Jabatan Fungsional</h2>
                <p id="modalProdiName" class="text-sm text-green-100 mt-1"></p>
            </div>

            <!-- Body -->
            <div class="p-6">
                <form id="editForm">
                    <input type="hidden" id="prodiId">

                    <div class="bg-yellow-50 border-l-4 border-yellow-400 p-3 mb-4">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <i class="bi bi-exclamation-triangle-fill text-yellow-400"></i>
                            </div>
                            <div class="ml-3">
                                <p class="text-xs text-yellow-700">
                                    Data ini akan menimpa perhitungan otomatis. Pastikan total NJAD + AA + L + LK + GB =
                                    Total Dosen
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="grid grid-cols-3 gap-3 mb-4">
                        <div>
                            <label for="editNJAD" class="block text-sm font-medium text-gray-700 mb-1">
                                NJAD <span class="text-red-500">*</span>
                            </label>
                            <input type="number" id="editNJAD" min="0" required
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-green-600 focus:border-green-600">
                        </div>
                        <div>
                            <label for="editAA" class="block text-sm font-medium text-gray-700 mb-1">
                                AA <span class="text-red-500">*</span>
                            </label>
                            <input type="number" id="editAA" min="0" required
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-green-600 focus:border-green-600">
                        </div>
                        <div>
                            <label for="editL" class="block text-sm font-medium text-gray-700 mb-1">
                                L <span class="text-red-500">*</span>
                            </label>
                            <input type="number" id="editL" min="0" required
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-green-600 focus:border-green-600">
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-3">
                        <div>
                            <label for="editLK" class="block text-sm font-medium text-gray-700 mb-1">
                                LK <span class="text-red-500">*</span>
                            </label>
                            <input type="number" id="editLK" min="0" required
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-green-600 focus:border-green-600">
                        </div>
                        <div>
                            <label for="editGB" class="block text-sm font-medium text-gray-700 mb-1">
                                GB <span class="text-red-500">*</span>
                            </label>
                            <input type="number" id="editGB" min="0" required
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-green-600 focus:border-green-600">
                        </div>
                    </div>

                    <div class="mt-4 p-3 bg-gray-50 rounded border border-gray-200">
                        <div class="text-xs text-gray-600">
                            <strong>Total Dosen saat ini:</strong> <span id="currentTotal" class="font-semibold"></span>
                        </div>
                    </div>

                    <!-- Tombol -->
                    <div class="flex justify-end gap-3 mt-6">
                        <button type="button" onclick="closeEditModal()"
                            class="px-4 py-2 border border-gray-300 text-gray-700 rounded-md hover:bg-gray-50 transition">
                            Batal
                        </button>
                        <button type="submit"
                            class="px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700 transition">
                            <i class="bi bi-save"></i> Simpan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        // Initialize Pie Chart
        document.addEventListener('DOMContentLoaded', function() {
            const ctx = document.getElementById('fungsionalChart').getContext('2d');
            const totals = @json($totals);

            new Chart(ctx, {
                type: 'pie',
                data: {
                    labels: ['NJAD', 'Asisten Ahli', 'Lektor', 'Lektor Kepala', 'Guru Besar'],
                    datasets: [{
                        data: [totals.njad, totals.aa, totals.l, totals.lk, totals.gb],
                        backgroundColor: [
                            'rgb(107, 114, 128)', // gray-500
                            'rgb(234, 179, 8)', // yellow-500
                            'rgb(59, 130, 246)', // blue-500
                            'rgb(168, 85, 247)', // purple-500
                            'rgb(239, 68, 68)' // red-500
                        ],
                        borderColor: 'rgb(255, 255, 255)',
                        borderWidth: 2
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: true,
                    plugins: {
                        legend: {
                            position: 'bottom',
                            labels: {
                                padding: 15,
                                font: {
                                    size: 11
                                }
                            }
                        },
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    let label = context.label || '';
                                    if (label) {
                                        label += ': ';
                                    }
                                    label += context.parsed + ' dosen';
                                    const percentage = totals.total_dosen > 0 ?
                                        ((context.parsed / totals.total_dosen) * 100).toFixed(2) :
                                        0;
                                    label += ' (' + percentage + '%)';
                                    return label;
                                }
                            }
                        }
                    }
                }
            });
        });

        function printTable() {
            var printContents = document.getElementById('fungsionalTable').outerHTML;
            var printWindow = window.open('', '', 'height=600,width=800');

            printWindow.document.write('<html><head><title>Dashboard Jabatan Fungsional</title>');
            printWindow.document.write('<style>table { border-collapse: collapse; width: 100%; font-size: 10px; }');
            printWindow.document.write('th, td { border: 1px solid #000; padding: 4px; text-align: center; }');
            printWindow.document.write('th { background-color: #f0f0f0; font-weight: bold; }</style></head><body>');
            printWindow.document.write(
                '<h2 style="text-align: center;">Dashboard Jabatan Fungsional Dosen per Program Studi</h2>');
            printWindow.document.write('<h3 style="text-align: center;">Telkom University Surabaya</h3>');
            printWindow.document.write(printContents);
            printWindow.document.write('</body></html>');

            printWindow.document.close();
            printWindow.print();
        }

        function exportToCSV() {
            const prodiStats = @json($prodiStats);
            let csv = [];

            csv.push(['No', 'Prodi', 'Fakultas', 'Total', 'NJAD', 'AA', 'L', 'LK', 'GB', 'LLKGB', 'JFA'].join(','));

            prodiStats.forEach((stat, index) => {
                csv.push([
                    index + 1,
                    `"${stat.nama_prodi}"`,
                    `"${stat.fakultas}"`,
                    stat.total_dosen,
                    stat.njad,
                    stat.aa,
                    stat.l,
                    stat.lk,
                    stat.gb,
                    (stat.llkgb * 100).toFixed(2) + '%',
                    (stat.jfa * 100).toFixed(2) + '%'
                ].join(','));
            });

            const totals = @json($totals);
            csv.push([
                'TOTAL', '', '',
                totals.total_dosen,
                totals.njad,
                totals.aa,
                totals.l,
                totals.lk,
                totals.gb,
                (totals.llkgb * 100).toFixed(2) + '%',
                (totals.jfa * 100).toFixed(2) + '%'
            ].join(','));

            var csvFile = new Blob([csv.join('\n')], {
                type: 'text/csv;charset=utf-8;'
            });
            var downloadLink = document.createElement('a');
            downloadLink.download = 'dashboard_fungsional_' + new Date().toISOString().slice(0, 10) + '.csv';
            downloadLink.href = window.URL.createObjectURL(csvFile);
            downloadLink.style.display = 'none';
            document.body.appendChild(downloadLink);
            downloadLink.click();
            document.body.removeChild(downloadLink);
        }

        // Modal functions
        function openEditModal(prodiId, prodiName, njad, aa, l, lk, gb, totalDosen) {
            document.getElementById('prodiId').value = prodiId;
            document.getElementById('modalProdiName').textContent = prodiName;
            document.getElementById('editNJAD').value = njad;
            document.getElementById('editAA').value = aa;
            document.getElementById('editL').value = l;
            document.getElementById('editLK').value = lk;
            document.getElementById('editGB').value = gb;
            document.getElementById('currentTotal').textContent = totalDosen + ' dosen';

            document.getElementById('editModal').classList.remove('hidden');
            document.body.style.overflow = 'hidden';
        }

        function closeEditModal() {
            document.getElementById('editModal').classList.add('hidden');
            document.body.style.overflow = '';
        }

        // Form submit handler
        document.getElementById('editForm').addEventListener('submit', function(e) {
            e.preventDefault();

            const prodiId = document.getElementById('prodiId').value;
            const njad = parseInt(document.getElementById('editNJAD').value);
            const aa = parseInt(document.getElementById('editAA').value);
            const l = parseInt(document.getElementById('editL').value);
            const lk = parseInt(document.getElementById('editLK').value);
            const gb = parseInt(document.getElementById('editGB').value);

            // Fetch existing cache data first, then update
            fetch(`/manage/prodi/${prodiId}/get-cached-stats`)
                .then(response => response.json())
                .then(cachedData => {
                    const data = {
                        s2: cachedData.s2 || 0,
                        s3: cachedData.s3 || 0,
                        njad: njad,
                        aa: aa,
                        l: l,
                        lk: lk,
                        gb: gb,
                        tetap: cachedData.tetap || 0,
                        calon_tetap: cachedData.calon_tetap || 0,
                        profesional: cachedData.profesional || 0,
                        perbantuan: cachedData.perbantuan || 0
                    };

                    // Send AJAX request to update
                    return fetch(`/manage/prodi/${prodiId}/update-stats`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify(data)
                    });
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        alert('Data berhasil diperbarui');
                        closeEditModal();
                        location.reload();
                    } else {
                        alert('Error: ' + data.message);
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Terjadi kesalahan saat menyimpan data');
                });
        });

        // Close modal on backdrop click
        document.getElementById('editModalBackdrop')?.addEventListener('click', closeEditModal);

        // Close modal on ESC key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                closeEditModal();
            }
        });
    </script>
@endsection
