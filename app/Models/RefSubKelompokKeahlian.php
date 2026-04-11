<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;


class RefSubKelompokKeahlian extends Model
{
    /** @use HasFactory<\Database\Factories\RefSubKelompokKeahlianFactory> */
    use HasFactory;

    public $incrementing = false;
    protected $keyType = 'string';

    protected $table = 'ref_sub_kelompok_keahlians';

    protected $fillable = [
        'nama',
        'kode',
        'deskripsi',
        'kk_id',
        'id'
    ];

    // public function kk()
    // {
    //     return $this->hasMany(RiwayatNip::class, 'status_pegawai_id');
    // }

    protected $casts = [
        'id' => 'string',
        'kk_id' => 'string',
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
