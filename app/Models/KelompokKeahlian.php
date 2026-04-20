<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class KelompokKeahlian extends Model
{
    use HasFactory;
    public $incrementing = false;
    protected $keyType = 'string';

    protected $table = 'kelompok_keahlian';

    protected $fillable = ['nama', 'kode', 'deskripsi', 'fakultas_id'];
    protected $casts = [
        'id' => 'string',
        'fakultas_id'=>'string',
        'kode' => 'string'
    ];

    public function dosen()
    {
        return $this->belongsToMany(Dosen::class, 'dosen_has_kk', 'kk_id', 'dosen_id');
    }

    public function sub_kk()
    {
        return $this->hasMany(RefSubKelompokKeahlian::class, 'kk_id', 'id');
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
