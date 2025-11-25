<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;


class riwayatJabatanFungsionalKeahlian extends Model
{
    /** @use HasFactory<\Database\Factories\RiwayatJabatanFungsionalTpaFactory> */
    use HasFactory;
    protected $connection = 'mysql';


    protected $table = 'riwayat_jabatan_fungsional_keahlians';

    public $incrementing = false;
    protected $keyType = 'string';
    protected $fillable = [
        'ref_jfk_id',
        'tpa_id',
        'tmt_mulai',
        'tmt_selesai',
        // 'sk_llkdikti_id',
        'sk_pengakuan_ypt_id',
    ];

    protected $casts = [
        'ref_jfk_id' => 'string',
        'tpa_id' => 'string',
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
    public function data_jfk()
    {
        return $this->belongsTo(refJabatanFungsionalKeahlian::class, 'ref_jfk_id', 'id');
    }

    public function data_tpa()
    {
        return $this->belongsTo(tpa::class, 'tpa_id', 'id');
    }

    public function sk_ypt()
    {
        return $this->belongsTo(SK::class, 'sk_pengakuan_ypt_id', 'id');
    }

    /**
     * Create a new factory instance for the model.
     */
    protected static function newFactory()
    {
        return \Database\Factories\RiwayatJabatanFungsionalKeahlianFactory::new();
    }
}
