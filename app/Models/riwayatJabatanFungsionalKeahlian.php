<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;


class riwayatJabatanFungsionalKeahlian extends Model
{
    /** @use HasFactory<\Database\Factories\RiwayatJabatanFungsionalTpaFactory> */
    use HasFactory;

    protected $table = 'riwayat_jabatan_fungsional_keahlians';
    protected $fillable = [
        'ref_jfk_id',
        'tpa_id',
        'tmt_mulai',
        'tmt_selesai',
        // 'sk_llkdikti_id',
        'sk_pengakuan_ypt_id',
    ];

    protected $casts = [
        'ref_jfk_id' => 'boolean',
        'tpa_id' => 'string',
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

    /**
     * Create a new factory instance for the model.
     */
    protected static function newFactory()
    {
        return \Database\Factories\RiwayatJabatanFungsionalKeahlianFactory::new();
    }
}
