<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Bank extends Model
{
    protected $primaryKey = 'bank_id';
    
    protected $fillable = [
        'bank_name',
        'bank_account'
    ];

    public function loans()
    {
        return $this->hasMany(Loan::class, 'bank_id');
    }
} 