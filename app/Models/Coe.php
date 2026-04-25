<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Coe extends Model
{
    use HasFactory;

    protected $table = 'coe';

    protected $primaryKey = 'id';

    public $incrementing = false;

    protected $keyType = 'string';

    public $timestamps = true;

    protected $fillable = ['nama_coe', 'kode_coe', 'is_active', 'ref_research_id'];

    protected $casts = [
        'id' => 'string',
        'ref_research_id' => 'string',
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

    public function research()
    {
        return $this->belongsTo(RefResearchCoe::class, 'ref_research_id', 'id');
    }

    public function dosenCoe()
    {
        return $this->hasMany(DosenHasCOE::class, 'coe_id', 'id');
    }
}
