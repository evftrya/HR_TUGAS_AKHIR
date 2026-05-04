<?php

namespace App\Http\Controllers;

use App\Models\PelaporanPekerjaan;
use App\Models\TargetKinerja;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class KinerjaExportController extends Controller
{
    private function getExportData()
    {
        $userId = Auth::id();
        
        // 1. Ambil Data Detail
        $reports = PelaporanPekerjaan::with('targetHarian')
            ->where('user_id', $userId)
            ->orderBy('created_at', 'desc')
            ->get();

        // 2. Kalkulasi Ringkasan Statistik
        $totalMinutesApproved = $reports->where('status', 'approved')->sum('approved_waktu_minutes');
        
        $processedReports = $reports->whereIn('status', ['approved', 'rejected']);
        $totalSLALog = 0;
        foreach ($processedReports as $rep) {
            $created = \Carbon\Carbon::parse($rep->created_at);
            $updated = \Carbon\Carbon::parse($rep->updated_at);
            $totalSLALog += $created->diffInMinutes($updated);
        }
        $avgSLA = $processedReports->count() > 0 ? round($totalSLALog / $processedReports->count(), 1) : 0;

        $targets = TargetKinerja::whereHas('pegawai', function($q) use ($userId) {
            $q->where('users.id', $userId);
        })->get();
        
        $totalProgress = 0;
        foreach ($targets as $target) {
            $realisasi = PelaporanPekerjaan::where('user_id', $userId)
                ->where('status', 'approved')
                ->whereHas('targetHarian', function($q) use ($target) {
                    $q->where('target_kinerja_id', $target->id);
                })
                ->sum('approved_jumlah');
            
            $targetAngka = $target->target_percent ?? 100;
            $progress = $targetAngka > 0 ? ($realisasi / $targetAngka) * 100 : 0;
            $totalProgress += min($progress, 100);
        }
        $avgAchievement = $targets->count() > 0 ? round($totalProgress / $targets->count(), 1) : 0;

        return [
            'reports' => $reports,
            'summary' => [
                'total_minutes' => $totalMinutesApproved,
                'avg_sla_hours' => round($avgSLA / 60, 1),
                'avg_achievement' => $avgAchievement
            ]
        ];
    }

    public function export()
    {
        $data = $this->getExportData();
        $reports = $data['reports'];
        $summary = $data['summary'];

        return Excel::download(new class($reports, $summary) implements FromCollection, WithHeadings, WithMapping, WithStyles {
            private $reports;
            private $summary;

            public function __construct($reports, $summary) {
                $this->reports = $reports;
                $this->summary = $summary;
            }

            public function collection() {
                return $this->reports;
            }

            public function headings(): array {
                return [
                    ['RINGKASAN PERFORMA'],
                    ['Total Menit Disetujui', $this->summary['total_minutes'] . ' Menit'],
                    ['Rata-rata SLA Verifikasi', $this->summary['avg_sla_hours'] . ' Jam'],
                    ['Persentase Capaian KPI', $this->summary['avg_achievement'] . '%'],
                    [''],
                    ['DETAIL KEGIATAN'],
                    ['Tanggal', 'Pekerjaan', 'Realisasi', 'Jumlah', 'Waktu (Min)', 'Status']
                ];
            }

            public function map($report): array {
                return [
                    $report->created_at->format('d/m/Y'),
                    $report->targetHarian->pekerjaan ?? '-',
                    $report->realisasi,
                    $report->effective_jumlah,
                    $report->effective_waktu_minutes,
                    ucfirst($report->status)
                ];
            }

            public function styles(Worksheet $sheet) {
                $sheet->getStyle('A1:B4')->getFont()->setBold(true);
                $sheet->getStyle('A6:F7')->getFont()->setBold(true);
                
                $highestRow = $sheet->getHighestRow();
                for ($row = 8; $row <= $highestRow; $row++) {
                    $status = $sheet->getCell('F' . $row)->getValue();
                    if ($status === 'Approved') {
                        $sheet->getStyle('F' . $row)->getFont()->getColor()->setARGB('FF008000');
                    } elseif ($status === 'Rejected') {
                        $sheet->getStyle('F' . $row)->getFont()->getColor()->setARGB('FFFF0000');
                    }
                }
            }
        }, 'Laporan_Kinerja_' . Auth::user()->nama_lengkap . '.xlsx');
    }

    public function exportPrint()
    {
        $data = $this->getExportData();
        return view('kinerja_pegawai.export.print', $data);
    }
}
