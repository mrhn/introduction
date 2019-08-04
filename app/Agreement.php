<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @property string $customer_id
 * @property string $amount
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

}
