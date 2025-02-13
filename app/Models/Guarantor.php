<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Guarantor extends Model
{
    protected $fillable = [
        'loan_id',
        'name',
        'no_pf',
        'phone',
        'address',
        'relationship',
        'guarantor_order'
    ];

    public function loan()
    {
        return $this->belongsTo(Loan::class, 'loan_id', 'loan_id');
    }

    public function getRelationshipInMalay()
    {
        $relationships = [
            'parent' => 'Ibu/Bapa',
            'spouse' => 'Suami/Isteri',
            'sibling' => 'Adik-beradik',
            'relative' => 'Saudara',
            'friend' => 'Rakan'
        ];

        return $relationships[$this->relationship] ?? ucfirst($this->relationship);
    }
} 