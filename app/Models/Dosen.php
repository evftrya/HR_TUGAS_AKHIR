<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Dosen extends Model
{
    use HasFactory;

    protected $connection = 'mysql';

    public $incrementing = false;

    protected $keyType = 'string';

    protected $table = 'dosens';

    protected $casts = [
        'id' => 'string',
        'users_id' => 'string',
        'nidn' => 'string',
        'nuptk' => 'string',
        'prodi_id' => 'string',
    ];

    protected $fillable = [
        'nidn',
        'nuptk',
        'users_id',
        'prodi_id',
    ];

    // Relationships
    public function pegawai()
    {
        return $this->belongsTo(User::class, 'users_id', 'id');
    }

    public function pegawai_aktif()
    {
        return $this->belongsTo(User::class, 'users_id', 'id')
            ->where('is_active', 1);
    }

    public function serdos()
    {
        // hasOne(NamaModel, foreign_key, local_key)
        return $this->hasOne(SertifikasiDosen::class, 'dosen_id', 'id');
    }

    // public function prodi()
    // {
    //     return $this->belongsTo(Work_Position::class);
    // }

    public function prodi()
    {
        return $this->belongsTo(Work_Position::class, 'prodi_id', 'id');
    }

    public function HasKK()
    {
        return $this->hasMany(DosenHasKK::class, 'dosen_id', 'id')
            ->where('is_active', 1);
    }

    public function coe()
    {
        return $this->belongsToMany(Coe::class, 'dosen_has_coe', 'dosen_id', 'coe_id');
    }

    public function riwayat_jfa()
    {
        return $this->hasMany(RiwayatJabatanFungsionalAkademik::class, 'dosen_id', 'id');
    }

    public function jfa_aktif()
    {
        return $this->hasMany(RiwayatJabatanFungsionalAkademik::class, 'dosen_id', 'id')
            ->whereNull('tmt_selesai')->orderBy('tmt_mulai', 'desc');
    }

    public function pangkat_golongan_aktif()
    {
        return $this->hasMany(RiwayatPangkatGolongan::class, 'dosen_id', 'id')
            ->whereNull('tmt_selesai')->orderBy('tmt_mulai', 'desc');
    }

    public function sertifikasi()
    {
        return $this->hasOne(SertifikasiDosen::class);
    }

    public function kelompokKeahlian()
    {
        return $this->hasMany(DosenHasKK::class, 'dosen_id', 'id')
            ->where(function ($query) {
                $query->Where('is_active', '=', 1);
            });
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
