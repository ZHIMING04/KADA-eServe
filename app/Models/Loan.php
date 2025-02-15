<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Loan extends Model
{
    use Notifiable;

    protected $primaryKey = 'loan_id';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'loan_id',
        'member_id',
        'loan_type_id',
        'bank_id',
        'date_apply',
        'loan_amount',
        'loan_total_repayment',
        'loan_balance',
        'interest_rate',
        'monthly_repayment',
        'monthly_gross_salary',
        'monthly_net_salary',
        'loan_period',
        'status',
        'rejection_reason',
        'rejected_at',
        'rejected_by'
    ];

    protected $casts = [
        'date_apply' => 'date',
        'loan_amount' => 'float',
        'loan_total_repayment' => 'float',
        'loan_balance' => 'float',
        'interest_rate' => 'float',
        'monthly_repayment' => 'float',
        'monthly_gross_salary' => 'float',
        'monthly_net_salary' => 'float',
        'rejected_at' => 'datetime'
    ];

    public const STATUS_PENDING = 'pending';
    public const STATUS_APPROVED = 'approved';
    public const STATUS_REJECTED = 'rejected';

    // Define relationships
    public function member()
    {
        return $this->belongsTo(Member::class, 'member_id', 'id');
    }

    public function loanType()
    {
        return $this->belongsTo(LoanType::class, 'loan_type_id', 'loan_type_id');
    }

    public function bank()
    {
        return $this->belongsTo(Bank::class, 'bank_id', 'bank_id');
    }

    public function guarantors()
    {
        return $this->hasMany(Guarantor::class, 'loan_id', 'loan_id');
    }

    public function rejectedBy()
    {
        return $this->belongsTo(User::class, 'rejected_by');
    }

    // Route notifications to the member's email
    public function routeNotificationForMail()
    {
        return $this->member->email;
    }

    // Helper methods
    public function isPending()
    {
        return $this->status === 'pending';
    }

    public function isApproved()
    {
        return $this->status === 'approved';
    }

    public function isRejected()
    {
        return $this->status === 'rejected';
    }
} 