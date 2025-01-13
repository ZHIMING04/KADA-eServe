<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Loan extends Model
{
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
        'interest_rate',
        'monthly_repayment',
        'monthly_gross_salary',
        'monthly_net_salary',
        'loan_period',
        'status'
    ];

    public const STATUS_PENDING = 'pending';
    public const STATUS_APPROVED = 'approved';
    public const STATUS_REJECTED = 'rejected';
} 