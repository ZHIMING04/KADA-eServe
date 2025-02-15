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
        return $this->hasMany(Resignation::class, 'member_id');
    }

    public function latestResignation()
    {
        return $this->hasOne(Resignation::class, 'member_id')->latest();
    }

    public function isActive()
    {
        // Get the latest member record using guest_id
        $latestMember = Member::where('guest_id', $this->guest_id)
            ->latest()
            ->first();

        // Check the status of the latest record
        return $latestMember && $latestMember->status === 'approved';
    }

    public function hasActiveResignation()
    {
        return $this->resignations()
            ->latest()
            ->where('is_active', true)
            ->whereIn('status', ['pending', 'approved'])
            ->exists();
    }

    public function getResignationWarningMessage()
    {
        $latestResignation = $this->resignations()
            ->latest()
            ->where('is_active', true)
            ->whereIn('status', ['pending', 'approved'])
            ->first();

        if (!$latestResignation) {
            return null;
        }

        return $latestResignation->status === 'pending'
            ? 'Permohonan anda sedang diproses. Sila tunggu sehingga keputusan dimaklumkan.'
            : 'Anda tidak boleh memohon pinjaman atau menambah simpanan kerana permohonan berhenti anda telah diluluskan.';
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


