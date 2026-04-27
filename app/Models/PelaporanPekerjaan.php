<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Model untuk tabel pelaporan_pekerjaan (PELAPORAN_KINERJA di ERD).
 */
class PelaporanPekerjaan extends Model
{
    protected $table = 'pelaporan_pekerjaan';

    protected $fillable = [
        // Kolom ERD PELAPORAN_KINERJA
        'ku_id',            // FK -> kontrak_unit (KONTRAK_UNIT di ERD)
        'user_id',          // FK -> users (pelapor)
        'tanggal',          // date: tanggal pelaporan
        'deskripsi',        // text: deskripsi pekerjaan
        'menit_kerja',      // int: total menit kerja
        'realisasi',        // text: keterangan realisasi
        'evidence',         // file evidence (alias file_evidence ERD)
        'status',           // enum: pending/approved/rejected
        'catatan_atasan',   // text: catatan dari atasan
        'atasan_id',        // FK -> users (atasan yang review)

        // Kolom lama (backward compat)
        'target_harian_id',
        'referensi_set_target_id',
        'realisasi_jumlah',
        'realisasi_waktu_minutes',
        'approved_jumlah',
        'approved_waktu_minutes',
        'pencapaian_percent',
        'created_by',
        'approved_by',
    ];

    protected $casts = [
        'tanggal' => 'date',
        'created_at' => 'date',
    ];

    /**
     * Scope untuk mengambil laporan yang sudah approved dalam 365 hari terakhir.
     */
    public function scopeApprovedInLastYear($query, $userId = null)
    {
        return $query->where('status', 'approved')
            ->when($userId, fn($q) => $q->where('user_id', $userId))
            ->where('created_at', '>=', now()->subDays(365))
            ->selectRaw('DATE(created_at) as date, SUM(approved_waktu_minutes) as total_minutes')
            ->groupBy('date');
    }

    // ── Relasi ERD ──────────────────────────────────────────────────────────

    /**
     * Kontrak unit yang menjadi dasar laporan ini (ERD: ku_id -> KONTRAK_UNIT).
     */
    public function kontrakUnit()
    {
        return $this->belongsTo(KontrakUnit::class, 'ku_id');
    }

    /**
     * User/pegawai yang membuat laporan ini (ERD: user_id -> USERS).
     */
    public function pelapor()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Atasan yang mereview laporan ini (ERD: atasan_id -> USERS).
     */
    public function atasan()
    {
        return $this->belongsTo(User::class, 'atasan_id');
    }

    // ── Relasi Lama (backward compat) ───────────────────────────────────────

    public function targetHarian()
    {
        return $this->belongsTo(TargetKinerjaHarian::class, 'target_harian_id');
    }

    // ── Accessors ───────────────────────────────────────────────────────────

    public function getEffectiveJumlahAttribute()
    {
        return $this->approved_jumlah !== null ? $this->approved_jumlah : $this->realisasi_jumlah;
    }

    public function getEffectiveWaktuMinutesAttribute()
    {
        return $this->approved_waktu_minutes !== null ? $this->approved_waktu_minutes : $this->realisasi_waktu_minutes;
    }
}

