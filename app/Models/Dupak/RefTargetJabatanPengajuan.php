<?php

namespace App\Models\Dupak;

use App\Models\refJabatanFungsionalAkademik;

class RefTargetJabatanPengajuan extends DupakModel
{
    protected $table = 'ref_target_jabatan_pengajuan';

    protected $fillable = [
        'jfaAsal',
        'jfaTujuan',
        'kumTarget',
        'isActive'
    ];

    public function jabatanAsal()
    {
        return $this->belongsTo(refJabatanFungsionalAkademik::class, 'jfaAsal');
    }

    public function jabatanTujuan()
    {
        return $this->belongsTo(refJabatanFungsionalAkademik::class, 'jfaTujuan');
    }
}