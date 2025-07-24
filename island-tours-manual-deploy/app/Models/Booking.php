<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    public $timestamps = false;

    protected $primaryKey = 'id';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'id',
        'user_id',
        'date',
        'status',
        'full_name',
        'email',
        'phone',
        'address',
        'adult_qty',
        'child_qty',
        'pwd_senior_qty',
        'student_qty',
        'lights_show_qty',
        'exclusive_show_qty',
        'total_amount'
    ];

    // Add this:
    protected $casts = [
        'date' => 'date',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function bookingIds()
    {
        return $this->hasMany(BookingId::class, 'booking_id', 'id');
    }    

    public function bookingPackages()
    {
        return $this->hasMany(BookingPackage::class, 'booking_id', 'id');
    }
}
