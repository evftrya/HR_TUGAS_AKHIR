<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;


class sertifikasi_owner extends Model
{
    /** @use HasFactory<\Database\Factories\SertifikasiOwnerFactory> */
    use HasFactory;
    protected $keyType = 'string';
    public $incrementing = false;

    protected $table = 'sertifikasi_owners';

    protected $fillable = [
        'dosen_id',
        'sertifikasi_id',
    ];

    protected $casts = [
        'id' => 'string',
        'dosen_id' => 'string',
        'sertifikasi_id' =>'string',

    ];

    public function dosen()
    {
        return $this->belongsTo(Dosen::class, 'dosen_id','id');
    }

    public function sertifikasi()
    {
        return $this->belongsTo(SertifikasiDosen::class, 'sertifikasi_id','id');
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

}
