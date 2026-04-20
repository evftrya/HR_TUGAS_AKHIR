<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ref_work_position extends Model
{
    /** @use HasFactory<\Database\Factories\RefWorkPositionFactory> */
    use HasFactory;

    public $timestamps = true;
    public $incrementing = false;
    protected $keyType = 'string';
    protected $table = 'Ref_work_positions';
    protected $primaryKey = 'position_name';
    protected $fillable = [
        'position_name',
        'singkatan',
    ];
}
