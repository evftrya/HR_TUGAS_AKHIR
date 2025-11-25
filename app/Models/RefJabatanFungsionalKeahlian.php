<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class refJabatanFungsionalKeahlian extends Model
{
    /** @use HasFactory<\Database\Factories\RefJabatanFungsionalTpaFactory> */
    use HasFactory;
    protected $table = 'ref_jabatan_fungsional_keahlians';
    
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'nama_jabatan',
    ];

    protected $casts = [
        'nama_jabatan' => 'string',
        'id' => 'string',
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
