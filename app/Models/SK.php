<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class SK extends Model
{
    /** @use HasFactory<\Database\Factories\SKFactory> */
    use HasFactory;
    protected $table = 'sks';
    protected $fillable = [
        // 'users_id',
        'no_sk',
        'tmt_mulai',
        'file_sk',
        'tipe_sk',
        'keterangan',
        'tipe_dokumen'
    ];

    public $incrementing = false;

    protected $keyType = 'string';

    protected $casts = [
        'id' => 'string',
        'keterangan' => 'string',
    ];

    protected static function newFactory()
    {
        return \Database\Factories\SKFactory::new();
    }

    public static function Sk_Dikti()
    {
        return self::where(function ($query) {
            $query->where('tipe_sk', 'LLDIKTI')
                ->orWhere('tipe_dokumen', 'AMANDEMEN');
        })
            ->orderBy('no_sk', 'asc')
            ->get();
    }

    public static function Sk_Ypt()
    {
        return self::where(function ($query) {
            $query->where('tipe_sk', 'Pengakuan YPT')
                ->orWhere('tipe_dokumen', 'AMANDEMEN');
        })
            ->orderBy('no_sk', 'asc')
            ->get();
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
