<?php

namespace App\Observers;

use App\Models\Meeting;
use App\Services\ZoomApi;

class MeetingObserver
{
    /**
     * Handle the Meeting "created" event.
     *
     * @param  \App\Models\Meeting  $meeting
     * @return void
     */
    public function created(Meeting $meeting)
    {
        $data = [
            'topic' => $meeting->appointment->event_name,
            'start_time' => $meeting->meet_date->format('Y-m-d\TH:i:s'),
            'duration' => $meeting->appointment->duration,
            'timezone' => $meeting->time_zone,
        ];

        $res = ZoomApi::CreateMeeting($data);

        $meeting->meet_link = $res->join_url;

        $meeting->save();
    }

    /**
     * Handle the Meeting "updated" event.
     *
     * @param  \App\Models\Meeting  $meeting
     * @return void
     */
    public function updated(Meeting $meeting)
    {
        //
    }

    /**
     * Handle the Meeting "deleted" event.
     *
     * @param  \App\Models\Meeting  $meeting
     * @return void
     */
    public function deleted(Meeting $meeting)
    {
        //
    }

    /**
     * Handle the Meeting "restored" event.
     *
     * @param  \App\Models\Meeting  $meeting
     * @return void
     */
    public function restored(Meeting $meeting)
    {
        //
    }

    /**
     * Handle the Meeting "force deleted" event.
     *
     * @param  \App\Models\Meeting  $meeting
     * @return void
     */
    public function forceDeleted(Meeting $meeting)
    {
        //
    }
}
