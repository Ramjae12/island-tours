<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AvailableDate extends Model
{
    use HasFactory;

    protected $fillable = [
        'date',
        'package_id',
        'max_capacity',
        'booked_count',
        'capacity',
        'booked',
        'closed',
    ];

    public function package(): BelongsTo
    {
        return $this->belongsTo(Package::class);
    }
}
