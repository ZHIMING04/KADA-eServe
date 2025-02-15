<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Log;

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
        'status',
        'rejection_reason',
        'rejected_at',
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

    public function resignation()
    {
        return $this->hasOne(Resignation::class, 'member_id', 'id');
    }

    public function resignations()
    {
        return $this->hasMany(Resignation::class);
    }

    public function isActive()
    {
        return $this->status === 'approved';
    }

    public function routeNotificationForMail($notification)
    {
        try {
            // Log the email retrieval attempt
            Log::info('Retrieving email for member', [
                'member_id' => $this->id,
                'user_id' => $this->guest_id,
                'email' => $this->user ? $this->user->email : 'No user found'
            ]);

            // Get email from related user
            if ($this->user) {
                return $this->user->email;
            }

            // Fallback to member's email if user relation doesn't exist
            return $this->email;
        } catch (\Exception $e) {
            Log::error('Error getting member email', [
                'member_id' => $this->id,
                'error' => $e->getMessage()
            ]);
            return null;
        }
    }
}


