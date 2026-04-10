<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Model untuk tabel target_kinerja (KONTRAK_MANAJEMEN di ERD).
 * Menyimpan template KPI global yang kemudian didistribusikan
 * ke unit melalui tabel kontrak_unit.
 */
class TargetKinerja extends Model
{
    protected $table = 'target_kinerja';

    protected $fillable = [
        // nama_kpi sesuai ERD (sebelumnya: nama)
        'nama_kpi',
        'keterangan',
        'bobot',        // decimal sesuai ERD
        'satuan',
        'tahun',        // year sesuai ERD
        'is_active',
        'responsibility',
        'target_percent',
        'status',
        'unit_penanggung_jawab',
        'periode',      // tetap ada untuk backward compat
        'start',
        'end',
    ];

    protected $casts = [
        'bobot' => 'decimal:2',
        'is_active' => 'boolean',
    ];

    /**
     * Pegawai yang ditugaskan langsung pada KPI ini (pivot lama).
     */
    public function pegawai()
    {
        return $this->belongsToMany(User::class, 'target_kinerja_pegawai', 'target_kinerja_id', 'user_id')
            ->withPivot('tanggal_mulai', 'tanggal_selesai', 'status', 'catatan')
            ->withTimestamps();
    }

    /**
     * Distribusi KPI ini ke unit-unit (KONTRAK_UNIT sesuai ERD).
     */
    public function kontrakUnit()
    {
        return $this->hasMany(KontrakUnit::class, 'km_id');
    }

    /**
     * Unit-unit yang menerima KPI ini (many-to-many via kontrak_unit).
     */
    public function units()
    {
        return $this->belongsToMany(Unit::class, 'kontrak_unit', 'km_id', 'unit_id')
            ->withPivot('target_angka')
            ->withTimestamps();
    }
}
