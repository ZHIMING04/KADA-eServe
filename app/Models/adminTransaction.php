<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class adminTransaction extends Model
{
    use HasFactory;

    protected $table = 'transactions';

    protected $fillable = [
        'member_id',
        'type',
        'savings_type',
        'loan_id',
        'amount'
    ];

    // Define relationships
    public function member()
    {
        return $this->belongsTo(Member::class, 'member_id');
    }

    public function loan()
    {
        return $this->belongsTo(Loan::class, 'loan_id');
    }

    // Define savings types that match the columns in Savings model
    public static function getSavingsTypes()
    {
        return [
            'share_capital' => 'Modal Syer',
            'subscription_capital' => 'Modal Yuran',
            'member_deposit' => 'Deposit Ahli',
            'welfare_fund' => 'Tabung Kebajikan',
            'fixed_savings' => 'Simpanan Tetap'
        ];
    }

    // Get the display name of the savings type
    public function getSavingsTypeName()
    {
        $types = self::getSavingsTypes();
        return $types[$this->savings_type] ?? $this->savings_type;
    }
}
