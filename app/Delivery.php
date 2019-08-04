<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Class Delivery
 * @package App
 *
 * @property Customer $customer
 */
class Delivery extends Model
{
    protected $fillable = [
        'delivered_at', 'count',
    ];

    public function scopeWithinAgreement(Builder $query, Carbon $interval): Builder
    {
        return $query->whereDate('delivered_at', '>=', $interval);
    }

    public function scopeNotPayed(Builder $query): Builder
    {
        return $query->where('payed', '!=', 1);
    }

    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }
}
