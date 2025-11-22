<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Emergency_contact extends Model
{
    /** @use HasFactory<\Database\Factories\EmergencyContactFactory> */
    use HasFactory;
    public $incrementing = false;
    protected $model = \App\Models\Emergency_contact::class;
    protected $keyType = 'string';
    protected $fillable = [
        'users_id',
        'nama_lengkap',
        'status_hubungan',
        'telepon',
        'alamat',
        'email',
    ];
    protected static function newFactory()
    {
        return \Database\Factories\EmergencyContactFactory::new();
    }
    // public function user()
    // {
    //     return $this->belongsTo(User::class, 'users_id');
    // }

    public function user_data()
    {
        return $this->belongsTo(User::class,'users_id','id');
    }
    public static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (empty($model->id)) {
                $model->id = (string) \Illuminate\Support\Str::uuid();
            }
        });
    }
    
}
