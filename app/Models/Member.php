<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;



class Member extends Model
{
    use HasFactory;

    protected $table = 'member_register'; // Ensure this matches your table name

    protected $fillable = [
        'no_anggota',
        'name',
        'email',
        'ic',
        'phone',
        'address',
        'city',
        'postcode',
        'state',
        'gender',
        'DOB',
        'agama',
        'bangsa',
        'no_pf',
        'salary',
        'office_address',
        'office_city',
        'office_postcode',
        'office_state',
    ];
}


