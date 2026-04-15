<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class RiwayatPangkatGolongan extends Model
{
    /** @use HasFactory<\Database\Factories\RiwayatPangkatGolonganFactory> */
    use HasFactory;

    protected $table = 'riwayat_pangkat_golongans';

    protected $fillable = [
        'pangkat_golongan_id',
        'dosen_id',
        'tmt_mulai',
        'sk_llkdikti_id',
    ];

    protected $casts = [
        'id' => 'string',
        'dosen_id' => 'string',
        'pangkat_golongan_id' => 'string',
        'sk_llkdikti_id'=>'string',
        'tmt_mulai' => 'date',
        'tmt_selesai' => 'date',
    ];

    public function dosen()
    {
        return $this->belongsTo(Dosen::class, 'dosen_id');
    }

    public function refPangkatGolongan()
    {
        return $this->belongsTo(RefPangkatGolongan::class, 'pangkat_golongan_id');
    }

    public function skLlDikti()
    {
        return $this->belongsTo(Sk::class, 'sk_llkdikti_id', 'id');
    }

    // public function skPengakuanYpt()
    // {
    //     return $this->belongsTo(Sk::class, 'sk_pengakuan_ypt', 'id');
    // }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (empty($model->{$model->getKeyName()})) {
                $model->{$model->getKeyName()} = (string) Str::uuid();
            }
        });
    }

    // public $timestamps = true;

    // public $incrementing = false;

    /**
     * Create a new factory instance for the model.
     */
    protected static function newFactory()
    {
        return \Database\Factories\RiwayatPangkatGolonganFactory::new();
    }
}
