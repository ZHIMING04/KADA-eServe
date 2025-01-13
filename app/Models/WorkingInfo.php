<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WorkingInfo extends Model
{
    protected $table = 'working_info';
    
    protected $fillable = [
        'jawatan',
        'gred',
        'no_pf',
        'salary',
        'no_anggota'
    ];

    public function member()
    {
        return $this->belongsTo(Member::class, 'no_anggota');
    }
} 