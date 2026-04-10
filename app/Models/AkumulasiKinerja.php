<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Model untuk tabel AKUMULASI_KINERJA (ERD).
 * Menyimpan rekap kinerja per unit per bulan:
 * total menit kerja ter-approve dan persentase capaian terhadap target.
 *
 * Data ini dihitung dari PELAPORAN_KINERJA yang sudah berstatus approved.
 */
class AkumulasiKinerja extends Model
{
    protected $table = 'akumulasi_kinerja';

    protected $fillable = [
        'unit_id',
        'bulan',
        'tahun',
        'total_menit',
        'persentase_capaian',
    ];

    protected $casts = [
        'persentase_capaian' => 'decimal:2',
        'total_menit'        => 'integer',
        'bulan'              => 'integer',
    ];

    /**
     * Unit yang diakumulasi kinerjanya.
     */
    public function unit()
    {
        return $this->belongsTo(Unit::class, 'unit_id');
    }

    /**
     * Scope: filter berdasarkan bulan dan tahun.
     */
    public function scopePeriode($query, int $bulan, int $tahun)
    {
        return $query->where('bulan', $bulan)->where('tahun', $tahun);
    }

    /**
     * Hitung ulang dan simpan akumulasi kinerja untuk unit & periode tertentu.
     * Dipanggil setelah ada approval pelaporan kinerja baru.
     */
    public static function recalculate(int $unitId, int $bulan, int $tahun): self
    {
        // Ambil semua KontrakUnit dari unit ini
        $kuIds = KontrakUnit::where('unit_id', $unitId)->pluck('id');

        // Jumlahkan menit dari pelaporan yang sudah disetujui
        $totalMenit = PelaporanPekerjaan::whereIn('ku_id', $kuIds)
            ->where('status', 'approved')
            ->whereMonth('tanggal', $bulan)
            ->whereYear('tanggal', $tahun)
            ->sum('menit_kerja');

        // Hitung total target angka unit ini
        $totalTarget = KontrakUnit::where('unit_id', $unitId)->sum('target_angka');

        $persentase = 0;
        if ($totalTarget > 0) {
            // Asumsi: target_angka dalam menit juga, bisa disesuaikan per kebutuhan
            $persentase = round(($totalMenit / $totalTarget) * 100, 2);
        }

        return static::updateOrCreate(
            ['unit_id' => $unitId, 'bulan' => $bulan, 'tahun' => $tahun],
            ['total_menit' => $totalMenit, 'persentase_capaian' => $persentase]
        );
    }
}
