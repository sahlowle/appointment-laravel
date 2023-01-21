<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\PostMeetingRequest;
use App\Mail\NewMeeting;
use App\Models\Appointment;
use App\Models\Meeting;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class MeetingController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Get My Meetings
    |--------------------------------------------------------------------------
    */
    public function index(Request $request)
    {
        $user_id = $request->user()->id;

        $data = Meeting::whereUserId($user_id)->latest()->get();

        return sendResponse(true,$data,"Meeting Retrieved Successfully",200);
    }

    /*
    |--------------------------------------------------------------------------
    | Get My Meetings
    |--------------------------------------------------------------------------
    */
    public function scheduled(Request $request)
    {
        $user_id = $request->user()->id;

        $query = Meeting::query();

        $query->whereUserId($user_id);

        $type = $request->type;

        if ($type == "upcoming") {
            $query->upcoming();
        }

        if ($type == "past") {
            $query->past();
        }

       

        $data = $query->with('appointment')->get();

        return sendResponse(true,$data,"Meeting Retrieved Successfully",200);
    }

    /*
    |--------------------------------------------------------------------------
    | Create Meeting
    |--------------------------------------------------------------------------
    */
    public function store(PostMeetingRequest $request)
    {
        
        $username = $request->username;

        $user = User::whereUsername($username)->first();

        $appointment = Appointment::whereOwnerId($user->id)->whereSlug($request->slug)->first();


        $post_data = $request->validated();

        $post_data['user_id'] = $user->id;

        $post_data['appointment_id'] = $appointment->id;

        $post_data['meet_date'] = $request->date('meet_date');

        // return $post_data;

        $data = Meeting::create($post_data);

        // dispatch(new \App\Jobs\SendEmailJob($data->email,$data));

        Mail::to($data->email)->later(now()->addMinutes(1),new NewMeeting($data));
        Mail::to($user->email)->later(now()->addMinutes(1),new NewMeeting($data));

        return sendResponse(true,$data,"Meeting Created Successfully",200);
    }
}
