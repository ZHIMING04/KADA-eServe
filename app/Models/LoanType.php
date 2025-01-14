<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LoanType extends Model
{
    protected $primaryKey = 'loan_type_id';
    
    protected $fillable = [
        'loan_type_id',
        'loan_type'
    ];

    public function loans()
    {
        return $this->hasMany(Loan::class, 'loan_type_id');
    }
} 