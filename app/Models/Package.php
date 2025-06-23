<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Package extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'price',
        'discount_price',
        'type',
        'active',
        'price_label',
        'requires_id'
    ];
    

    /**
     * Get the available dates for this package.
     */
    public function availableDates(): HasMany
    {
        return $this->hasMany(AvailableDate::class);
    }
}
