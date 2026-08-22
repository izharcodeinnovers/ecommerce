<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class VendorSettlement extends Model
{
    protected $fillable = [
        'vendor_id',
        'period_start',
        'period_end',
        'payable_amount',
        'status',
    ];

    protected function casts(): array
    {
        return [
            'period_start' => 'date',
            'period_end' => 'date',
            'payable_amount' => 'decimal:4',
        ];
    }

    /**
     * @return BelongsTo<Vendor, $this>
     */
    public function vendor(): BelongsTo
    {
        return $this->belongsTo(Vendor::class);
    }

    /**
     * @return HasMany<VendorPayout, $this>
     */
    public function payouts(): HasMany
    {
        return $this->hasMany(VendorPayout::class, 'settlement_id');
    }
}
