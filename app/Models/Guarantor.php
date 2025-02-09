<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Guarantor extends Model
{
    protected $fillable = [
        'loan_id',
        'name',
        'no_pf',
        'ic',
        'guarantor_order'
    ];

    protected $casts = [
        'ic' => 'string'
    ];

    public function loan()
    {
        return $this->belongsTo(Loan::class, 'loan_id', 'loan_id');
    }

}
