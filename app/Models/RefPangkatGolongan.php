<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class RefPangkatGolongan extends Model
{
    use HasFactory;

    protected $table = 'ref_pangkat_golongans';

    protected $fillable = ['pangkat', 'golongan'];

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
