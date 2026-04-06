<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class SertifikasiDosen extends Model
{
    use HasFactory;
    protected $keyType = 'string';
    public $incrementing = false;

    protected $table = 'sertifikasis';

    protected $fillable = [
        'nomor_registrasi',
        'biaya_pelatihan',
        'judul',
        'tipe_sertifikasi',
        'pelaksanaan',
        'tgl_berlaku_sertifikasi',
        'tgl_pelaksana',
        'tgl_sertifikasi',
        'nama_file',
        'path',
    ];

    protected $casts = [
        'id' => 'string',
        'dosen_id' => 'string',
    ];

    // public function dosen()
    // {
    //     return $this->belongsTo(Dosen::class, 'dosen_id');
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
}
