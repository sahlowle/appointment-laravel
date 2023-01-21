<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Meeting extends Model
{
    use HasFactory;

    protected $guarded = [
        'id'
    ];

    protected $dates = ['meet_date'];

    protected $casts = [
        'meet_date' => 'datetime:Y-m-d  H:i:s',
        'is_sent' => 'boolean',
    ];


    protected $appends = [
        'time_from'
    ];
    

    public function scopeUpcoming($query)
    {
        return $query->whereDate('meet_date', '>=',now());

    }

    public function scopePast($query)
    {
        return $query->whereDate('meet_date', '<',now());

    }


    /*
    |--------------------------------------------------------------------------
    | Make Time From Attribute
    |--------------------------------------------------------------------------
    */
    public function getTimeFromAttribute()
    {
        return $this->meet_date->format('H:i');
    }

    /**
     * Get the Appointment that owns the Meeting
     *
     */
    public function appointment()
    {
        return $this->belongsTo(Appointment::class);
    }

    /**
     * Get the User that owns the Meeting
     *
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    
}
