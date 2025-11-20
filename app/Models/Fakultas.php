<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Fakultas extends Model
{
    use HasFactory;

    protected $table = 'work_positions';
    protected $primaryKey = 'id';
    protected $keyType = 'string';
    public $incrementing = false;
    public $timestamps = false;


    protected $casts = [
        'id' => 'string',
    ];
    protected $fillable = ['kode', 'nama_fakultas'];

    public static function alll()
    {
        return self::where('type_work_position', 'Fakultas')->orderBy('position_name', 'asc')->get();
    }

    // Relationships
    public function prodi()
    {
        return $this->hasMany(Prodi::class);
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
