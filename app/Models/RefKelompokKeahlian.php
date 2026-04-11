<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;


class RefKelompokKeahlian extends Model
{
    /** @use HasFactory<\Database\Factories\RefKelompokKeahlianFactory> */
    use HasFactory;
    protected $table = 'kelompok_keahlian';

    protected $fillable = [
        'id',
        'nama',
        'kode',
        'deskripsi',
        'fakultas_id'
    ];

    // public function kk()
    // {
    //     return $this->hasMany(RiwayatNip::class, 'status_pegawai_id');
    // }

    protected $casts = [
        'id' => 'string',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (empty($model->{$model->getKeyName()})) {
                $model->{$model->getKeyName()} = (string) Str::uuid();
            }
        });
    }
}
