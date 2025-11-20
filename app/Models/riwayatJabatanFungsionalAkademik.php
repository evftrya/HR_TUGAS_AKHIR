<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class riwayatJabatanFungsionalAkademik extends Model
{
    /** @use HasFactory<\Database\Factories\RiwayatJabatanFungsionalAkademikFactory> */
    use HasFactory;
    protected $connection = 'mysql';

    protected $table = 'riwayat_jabatan_fungsional_akademiks';
    
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'ref_jfa_id',
        'dosen_id',
        'tmt_mulai',
        'tmt_selesai'
    ];

    protected $casts = [
        'ref_jfk_id' => 'boolean',
        'dosen_id' => 'string',
    ];



    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (empty($model->{$model->getKeyName()})) {
                $model->{$model->getKeyName()} = (string) \Illuminate\Support\Str::uuid();
            }
        });
    }
}
