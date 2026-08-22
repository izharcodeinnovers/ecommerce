<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class VendorPayout extends Model
{
    protected $fillable = [
        'settlement_id',
        'payout_reference',
        'amount',
        'status',
    ];

    protected function casts(): array
    {
        return [
            'amount' => 'decimal:4',
        ];
    }

    /**
     * @return BelongsTo<VendorSettlement, $this>
     */
    public function settlement(): BelongsTo
    {
        return $this->belongsTo(VendorSettlement::class, 'settlement_id');
    }
}
