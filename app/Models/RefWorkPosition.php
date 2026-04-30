<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;


class RefWorkPosition extends Model
{
    /** @use HasFactory<\Database\Factories\RefWorkPositionFactory> */
    use HasFactory;

    public $timestamps = true;
    public $incrementing = false;
    protected $keyType = 'string';
    protected $table = 'ref_work_positions';
    protected $primaryKey = 'position_name';
    protected $fillable = [
        'position_name',
        'singkatan',
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
