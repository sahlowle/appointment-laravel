<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class ZoomApi
{
    /*
    |--------------------------------------------------------------------------
    | Create Charge Payment
    |--------------------------------------------------------------------------
    */

    public static function CreateMeeting($data)
    {
        $body = self::getSettings($data);

        $url = "https://api.zoom.us/v2/users/me/meetings";

        $bearerLive = "eyJhbGciOiJIUzI1NiJ9.eyJhdWQiOm51bGwsImlzcyI6IlhtSndSZmhBUnNTdHlhWm5hUDZUQVEiLCJleHAiOjE2NzQ4NTAxMDMsImlhdCI6MTY3NDI0NTMwNH0.hOum56PqbYDLXZaXduMGvwfMZFYjsvNmGOM1c4w95z8";
        
        $response = Http::withHeaders([
            'content-type' => 'application/json',
        ])->withToken($bearerLive)->post($url,$body);

        return $response->object();
 
    }

    /*
    |--------------------------------------------------------------------------
    | get Settings
    |--------------------------------------------------------------------------
    */
    public static function getSettings($data)
    {
        $setting = [];

        $setting = 
         [
            'topic' => $data['topic'],
            'type' => 2,
            'start_time' => $data['start_time'],
            'duration' => $data['duration'],
            'timezone' => $data['timezone'],
            'agenda' => 'test',
            'recurrence' => 
            [
              'type' => 1,
              'repeat_interval' => 1,
            ],
            'settings' => 
             [
              'host_video' => 'true',
              'participant_video' => 'true',
              'join_before_host' => 'False',
              'mute_upon_entry' => 'False',
              'watermark' => 'true',
              'audio' => 'voip',
              'auto_recording' => 'cloud',
             ],
        ];

        return $setting;
    }
}
