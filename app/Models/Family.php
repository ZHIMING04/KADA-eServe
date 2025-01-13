<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Family extends Model
{
    protected $table = 'family';
    
    protected $fillable = [
        'relationship',
        'name',
        'ic',
        'no_anggota'
    ];

    public function member()
    {
        return $this->belongsTo(Member::class, 'no_anggota');
    }
} 