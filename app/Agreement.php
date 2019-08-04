<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * @property float $unit_price
 * @property string $type
 *
 * @package App
 */
class Agreement extends Model
{
    const TYPE_WEEKLY = 'weekly';
    const TYPE_MONTHLY = 'monthly';

    protected $fillable = [
        'unit_price', 'type',
    ];

    protected $casts = [
        'unit_price' => 'decimal:2',
    ];

    public function invoiceInterval(): Carbon
    {
        $date = Carbon::now();

        if ($this->type === static::TYPE_WEEKLY) {
            return $date->subWeek();
        }

        return $date->subMonth();
    }
}
