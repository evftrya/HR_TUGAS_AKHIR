<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class riwayatJenjangPendidikan extends Model
{
    /** @use HasFactory<\Database\Factories\RiwayatJenjangPendidikanFactory> */
    use HasFactory;
    protected $table = 'riwayat_jenjang_pendidikans';
    protected $fillable = [
        'users_id',
        'jenjang_pendidikan_id',
        'bidang_pendidikan',
        'jurusan',
        'nama_kampus',
        'tahun_lulus',
        'nilai',
        'alamat_kampus',
        'gelar',
        'singkatan_gelar',
        'ijazah',
    ];

    protected $casts = [
        'id' => 'string',
        'users_id' => 'string',
        'jenjang_pendidikan_id' => 'string',
    ];

    public function pegawai()
    {
        return $this->belongsTo(User::class, 'users_id');
    }

    public function refJenjangPendidikan()
    {
        return $this->belongsTo(refJenjangPendidikan::class, 'jenjang_pendidikan_id','id');
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (empty($model->{$model->getKeyName()})) {
                $model->{$model->getKeyName()} = (string) Str::uuid();
            }
        });
    }

    /**
     * Create a new factory instance for the model.
     */
    protected static function newFactory()
    {
        return \Database\Factories\RiwayatJenjangPendidikanFactory::new();
    }


}
