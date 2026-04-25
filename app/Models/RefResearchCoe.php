<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class RefResearchCoe extends Model
{
    /** @use HasFactory<\Database\Factories\RefResearchCoeFactory> */
    use HasFactory;

    protected $table = 'ref_research_coes';

    protected $primaryKey = 'id';

    public $incrementing = false;

    protected $keyType = 'string';

    public $timestamps = true;

    protected $fillable = ['nama', 'kode'];

    protected $casts = [
        'id' => 'string',
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

    public function coe()
    {
        return $this->hasMany(Coe::class, 'ref_research_id');
    }
}
