<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Model untuk tabel akumulasi_kinerja.
 * Menyimpan rekap kinerja pegawai per bulan.
 */
class AkumulasiKinerja extends Model
{
    protected $table = 'akumulasi_kinerja';

    /**
     * Non-incrementing ID (UUID)
     */
    public $incrementing = false;
    protected $keyType = 'string';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'employee_id',
        'fullname',
        'year',
        'month',
        'jam_kerja',
        'kehadiran',
        'tepat_waktu',
        'tidak_tap_pulang',
        'user_id',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'jam_kerja' => 'decimal:2',
        'kehadiran' => 'integer',
        'month'     => 'integer',
        'year'      => 'integer',
        'tepat_waktu' => 'integer',
        'tidak_tap_pulang' => 'integer',
    ];

    /**
     * Relasi ke User (Pegawai).
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Scope: filter berdasarkan bulan dan tahun.
     */
    public function scopePeriode($query, int $month, int $year)
    {
        return $query->where('month', $month)->where('year', $year);
    }
}
