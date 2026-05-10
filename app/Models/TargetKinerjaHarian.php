<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TargetKinerjaHarian extends Model
{
    protected $table = 'target_kinerja_harian';

    protected $fillable = [
        'pekerjaan',
        'kontrak_type',
        'target_kinerja_id',
        'result',
        'jumlah',
        'waktu_minutes',
        'is_active',
        'bobot',
        'start',
        'end',
        'user_id',
        'satuan',
        'target',
        'waktu',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function targetKinerja()
    {
        return $this->belongsTo(TargetKinerja::class, 'target_kinerja_id');
    }

    public function indukKpi()
    {
        return $this->belongsToMany(TargetKinerja::class, 'induk_target_kinerja', 'target_kinerja_harian_id', 'target_kinerja_id');
    }

    public function pegawai()
    {
        return $this->belongsToMany(\App\Models\User::class, 'target_kinerja_harian_pegawai', 'target_kinerja_harian_id', 'user_id')
            ->withPivot('tanggal_mulai', 'tanggal_selesai', 'status', 'catatan')
            ->withTimestamps();
    }

    public function pelaporan()
    {
        return $this->hasMany(PelaporanPekerjaan::class, 'target_harian_id');
    }
}
