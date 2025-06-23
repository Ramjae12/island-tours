<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BookingId extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'booking_id',
        'file_path',
        'person_number',
        'uploaded_at'
    ];

    public function booking()
    {
        return $this->belongsTo(Booking::class, 'booking_id', 'id');
    }
}
