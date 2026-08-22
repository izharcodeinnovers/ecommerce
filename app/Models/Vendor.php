<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Vendor extends Model
{
    protected $fillable = [
        'user_id',
        'store_name',
        'slug',
        'status',
        'commission_rate',
        'verified_at',
    ];

    protected function casts(): array
    {
        return [
            'commission_rate' => 'decimal:2',
            'verified_at' => 'datetime',
        ];
    }

    /**
     * @return BelongsTo<User, $this>
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * @return HasOne<VendorProfile, $this>
     */
    public function profile(): HasOne
    {
        return $this->hasOne(VendorProfile::class);
    }

    /**
     * @return HasMany<VendorDocument, $this>
     */
    public function documents(): HasMany
    {
        return $this->hasMany(VendorDocument::class);
    }

    /**
     * @return HasMany<VendorBankAccount, $this>
     */
    public function bankAccounts(): HasMany
    {
        return $this->hasMany(VendorBankAccount::class);
    }

    /**
     * @return HasMany<VendorStaff, $this>
     */
    public function staff(): HasMany
    {
        return $this->hasMany(VendorStaff::class);
    }

    /**
     * @return HasMany<Product, $this>
     */
    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }

    /**
     * @return HasMany<OrderItem, $this>
     */
    public function orderItems(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    /**
     * @return HasMany<Shipment, $this>
     */
    public function shipments(): HasMany
    {
        return $this->hasMany(Shipment::class);
    }

    /**
     * @return HasMany<VendorReview, $this>
     */
    public function reviews(): HasMany
    {
        return $this->hasMany(VendorReview::class);
    }

    /**
     * @return HasMany<VendorCommission, $this>
     */
    public function commissions(): HasMany
    {
        return $this->hasMany(VendorCommission::class);
    }

    /**
     * @return HasMany<VendorSettlement, $this>
     */
    public function settlements(): HasMany
    {
        return $this->hasMany(VendorSettlement::class);
    }

    /**
     * @return HasMany<Ticket, $this>
     */
    public function tickets(): HasMany
    {
        return $this->hasMany(Ticket::class);
    }
}
