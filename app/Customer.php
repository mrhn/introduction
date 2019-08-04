<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @property string $name
 * @property Agreement $agreement
 *
 * @package App
 */
class Customer extends Model
{
    protected $fillable = [
        'name',
    ];

    public function getNumberAttribute()
    {
        return 'C'.str_pad($this->id,8,'0',STR_PAD_LEFT);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function agreement()
    {
        return $this->belongsTo(Agreement::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function deliveries()
    {
        return $this->hasMany(Delivery::class);
    }
}
