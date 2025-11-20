<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Support\Str;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * Non-incrementing ID (UUID)
     */
    public $incrementing = false;
    protected $keyType = 'string';

    /**
     * Fillable attributes
     */
    protected $fillable = [
        'nama_lengkap',
        'telepon',
        'emergency_contact_phone',
        'alamat',
        'nik',
        'email_institusi',
        'jenis_kelamin',
        'tempat_lahir',
        'tgl_lahir',
        'tgl_bergabung',
        'email_pribadi',
        'email_verified_at',
        'username',
        'password',
        'is_admin',
        'remember_token',
    ];

    /**
     * Hidden attributes
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attribute casting definitions for the model.
     *
     * @var array<string,string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'is_admin' => 'boolean',
        'id' => 'string',
    ];

    /**
     * Relationships
     */
    public function dosen()
    {
        return $this->hasOne(Dosen::class, 'users_id');
    }

    public function riwayatNip()
    {
        return $this->hasMany(RiwayatNip::class, 'users_id');
    }

    public function riwayatJenjangPendidikan()
    {
        return $this->hasMany(riwayatJenjangPendidikan::class, 'users_id');
    }

    public function tpa()
    {
        return $this->hasOne(Tpa::class, 'users_id');
    }

    public function bagian()
    {
        return $this->hasOne(RefBagian::class, 'id', 'bagian_id');
    }

    /**
     * Auto-generate UUID when creating new User
     */
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
