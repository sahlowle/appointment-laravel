<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;

class Appointment extends Model
{
    use Sluggable;

    protected $guarded = [
        'id'
    ];

    protected $appends = [
        'duration_name','url','start_date','end_date'
    ];
    
    /*
    |--------------------------------------------------------------------------
    | Make Duration Name Attribute
    |--------------------------------------------------------------------------
    */
    public function getDurationNameAttribute()
    {
        $dt = "Minutes";

        if ($this->duration_type == 2) {
            $dt = "Hours";
        }

        return $this->duration." ".$dt;
    }

    /*
    |--------------------------------------------------------------------------
    | Make Start Date  Attribute
    |--------------------------------------------------------------------------
    */
    public function getStartDateAttribute()
    {
        $arr = explode("|",$this->date_available);

        return $arr[0];
    }
    /*
    |--------------------------------------------------------------------------
    | Make End Date Attribute
    |--------------------------------------------------------------------------
    */
    public function getEndDateAttribute()
    {
        $arr = explode("|",$this->date_available);

        return $arr[1];
    }

    /*
    |--------------------------------------------------------------------------
    | Make Url Attribute
    |--------------------------------------------------------------------------
    */
    public function getUrlAttribute()
    {
        $username = "";
        $url = "http://localhost:3000/";

        if (auth()->check()) {
            $username = auth()->user()->username;
        }

        return $url . $username ."/". $this->slug;
    }



    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'event_name'
            ]
        ];
    }
    
}
