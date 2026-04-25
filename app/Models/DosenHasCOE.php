<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class DosenHasCOE extends Model
{
    /** @use HasFactory<\Database\Factories\DosenHasCOEFactory> */
    use HasFactory;

    protected $table = 'dosen_has_c_o_e_s';

    protected $primaryKey = 'id';

    public $incrementing = false;

    protected $keyType = 'string';

    public $timestamps = true;

    protected $fillable = ['dosen_id', 'coe_id', 'id', 'tmt_mulai', 'tmt_selesai'];

    protected $casts = [
        'id' => 'string',
        'dosen_id' => 'string',
        'coe_id' => 'string',
        'tmt_selesai' => 'date',
        'tmt_mulai' => 'date',
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

    public function dosen()
    {
        return $this->belongsTo(Dosen::class, 'dosen_id', 'id');
    }

    public function coe()
    {
        return $this->belongsTo(Coe::class, 'coe_id', 'id');
    }
}
