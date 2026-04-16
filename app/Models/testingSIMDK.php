<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TestingSIMDK extends Model
{
    // testing_s_i_m_d_k_s
    // use HasFactory;
    
    protected $table = 'testing_s_i_m_d_k_s';
    protected $fillable = [
        'test_statuses',
        'users_id',
    ];
    
    public $incrementing = true;

    protected $casts = [
        'users_id' => 'string',  
        'test_statuses' => 'array',
    ];
}
