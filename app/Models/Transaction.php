<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    protected $table = 'member_transactions';

    protected $fillable = [
        'transaction_id',
        'member_id',
        'type',
        'savings_type',
        'loan_id',
        'amount',
        'payment_method',
        'payment_proof',
        'status',
        'approved_at'
    ];

    protected $casts = [
        'approved_at' => 'datetime',
    ];

    protected $appends = ['savings_type_name'];

    // Define the savings types that match the columns in Savings model
    public static function getSavingsTypes()
    {
        return [
            'share_capital' => [
                'name' => 'Modal Syer',
                'column' => 'share_capital'
            ],
            'subscription_capital' => [
                'name' => 'Modal Yuran',
                'column' => 'subscription_capital'
            ],
            'member_deposit' => [
                'name' => 'Deposit Ahli',
                'column' => 'member_deposit'
            ],
            'welfare_fund' => [
                'name' => 'Tabung Kebajikan',
                'column' => 'welfare_fund'
            ],
            'fixed_savings' => [
                'name' => 'Simpanan Tetap',
                'column' => 'fixed_savings'
            ]
        ];
    }

    public function member()
    {
        return $this->belongsTo(Member::class);
    }

    public function savings()
    {
        return $this->belongsTo(Savings::class, 'member_id', 'no_anggota');
    }

    public function loan()
    {
        return $this->belongsTo(Loan::class);
    }

    public function approver()
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    // Get the display name of the savings type
    public function getSavingsTypeName()
    {
        $types = self::getSavingsTypes();
        return isset($types[$this->savings_type]) ? $types[$this->savings_type]['name'] : $this->savings_type;
    }

    // Get the corresponding column name in the savings table
    public function getSavingsColumn()
    {
        $types = self::getSavingsTypes();
        return isset($types[$this->savings_type]) ? $types[$this->savings_type]['column'] : null;
    }

    // Accessor for savings type name
    public function getSavingsTypeNameAttribute()
    {
        return $this->getSavingsTypeName();
    }

    // Accessor for savings column
    public function getSavingsColumnAttribute()
    {
        return $this->getSavingsColumn();
    }
} 