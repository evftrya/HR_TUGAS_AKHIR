<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Tpa extends Model
{
    use HasFactory;

    protected $table = 'tpas';
    protected $keyType = 'string';
    public $incrementing = false;



    protected $fillable = [
        'users_id',
        'nitk',
        'bagian_id'
    ];

    protected $casts = [
        'id' => 'string',
    ];
    // Relationships
    public function pegawai()
    {
        return $this->belongsTo(User::class,'users_id', 'id');
    }

    public function bagian()
    {
        return $this->belongsTo(Work_Position::class, 'bagian_id', 'id');
    }

    public function jfk_aktif()
    {
        return $this->hasMany(RiwayatJabatanFungsionalKeahlian::class, 'tpa_id', 'id')
            ->whereNull('tmt_selesai')->orderBy('tmt_mulai', 'desc');
    }

    // public function riwayatJabatanFungsional()
    // {
    //     return $this->hasMany(RiwayatJabatanFungsionalTpa::class);
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

