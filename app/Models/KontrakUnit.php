<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Model untuk tabel KONTRAK_UNIT (ERD).
 * Mewakili distribusi/penjatahan KPI (dari KONTRAK_MANAJEMEN / target_kinerja)
 * ke unit tertentu beserta target angka yang harus dicapai.
 */
class KontrakUnit extends Model
{
    protected $table = 'kontrak_unit';

    protected $fillable = [
        'km_id',
        'unit_id',
        'target_angka',
    ];

    /**
     * KPI induk (KONTRAK_MANAJEMEN = target_kinerja).
     */
    public function kontrakManajemen()
    {
        return $this->belongsTo(TargetKinerja::class, 'km_id');
    }

    /**
     * Unit yang menerima kontrak ini.
     */
    public function unit()
    {
        return $this->belongsTo(Unit::class, 'unit_id');
    }

    /**
     * Pelaporan kinerja yang terhubung ke kontrak unit ini.
     */
    public function pelaporanKinerja()
    {
        return $this->hasMany(PelaporanPekerjaan::class, 'ku_id');
    }
}
