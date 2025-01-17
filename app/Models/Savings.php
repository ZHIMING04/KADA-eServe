<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Savings extends Model
{
    protected $table = 'savings';
    
    protected $fillable = [
        'entrance_fee',
        'no_anggota',
        'share_capital',
        'subscription_capital',
        'member_deposit',
        'welfare_fund',
        'fixed_savings',
        'total_amount'
    ];

    public function member()
    {
        return $this->belongsTo(Member::class, 'no_anggota', 'id');
    }
} 