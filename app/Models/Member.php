<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class Member extends Model
{
    protected $table = 'registered_members';
    
    protected $fillable = [
        'name',
        'email',
        'phone',
        'ic',
        'address',
        'city',
        'poskod',
        'state',
        'gender',
        'gred',
        'salary',

    ];

    
}