<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;

class Member extends Model
{
    use HasFactory;
    use Notifiable;
    protected $table = 'member_register';
    protected $primaryKey = 'id';
    
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
        'guest_id',
        'status'
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

    public function user()
    {
        return $this->belongsTo(User::class, 'guest_id', 'id');
    }
}


