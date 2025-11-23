<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class StudiLanjut extends Model
{
    use HasFactory;

    protected $table = 'studi_lanjut';

    protected $fillable = [
        'users_id',
        'jenjang',
        'program_studi',
        'universitas',
        'negara',
        'tanggal_mulai',
        'tanggal_selesai',
        'status',
        'sumber_dana',
        'keterangan',
    ];

    protected $casts = [
        'id' => 'string',
        'users_id' => 'string',
        'tanggal_mulai' => 'date',
        'tanggal_selesai' => 'date',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'users_id');
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
