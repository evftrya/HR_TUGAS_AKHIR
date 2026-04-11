<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;


class DosenHasKK extends Model
{
    /** @use HasFactory<\Database\Factories\DosenHasKKFactory> */
    use HasFactory;

    protected $table = 'dosen_has_kk';

    protected $fillable = ['dosen_id', 'sub_kk_id'];
    protected $casts = [
        'dosen_id' => 'string',
        'sub_kk_id' => 'string'
    ];

    public function dosen()
    {
        return $this->belongsToMany(Dosen::class, 'dosen_has_kk', 'kk_id', 'dosen_id');
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
