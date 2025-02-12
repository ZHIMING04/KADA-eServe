<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Resignation extends Model
{
    use HasFactory;

    protected $table = 'resignations';

    protected $fillable = [
        'member_id',
        'reason1',
        'reason2',
        'reason3',
        'reason4',
        'reason5',
        'status',
        'is_active'
    ];

    protected $casts = [
        'submission_date' => 'datetime',
        'processed_at' => 'datetime'
    ];

    public function member(): BelongsTo
    {
        return $this->belongsTo(Member::class, 'member_id');
    }

    public function processedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'processed_by');
    }
}