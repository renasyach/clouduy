<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Member extends Model
{
    // DB lama tidak punya kolom updated_at
    const UPDATED_AT = null;

    protected $fillable = [
        'nama',
        'nim',
        'tanggung_jawab',
        'foto',
    ];
}
