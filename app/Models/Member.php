<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Member extends Model
{
    protected $table = 'member_register';
    
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
        'guest_id'
    ];

    public function workingInfo()
    {
        return $this->hasOne(WorkingInfo::class, 'no_anggota', 'id');
    }

    public function savings()
    {
        return $this->hasOne(Savings::class, 'no_anggota', 'id');
    }

    public function familyMembers()
    {
        return $this->hasMany(Family::class, 'no_anggota', 'id');
    }
}


