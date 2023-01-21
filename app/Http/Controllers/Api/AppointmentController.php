<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\PostAppointmentRequest;
use App\Models\Appointment;
use App\Models\User;
use Illuminate\Http\Request;

class AppointmentController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Get My Appointment
    |--------------------------------------------------------------------------
    */
    public function index(Request $request)
    {
        $owner_id = $request->user()->id;

        $data =Appointment::whereOwnerId($owner_id)->latest()->get();

        return sendResponse(true,$data,"Appointment Retrieved Successfully",200);
    }

    /*
    |--------------------------------------------------------------------------
    | Create Appointment
    |--------------------------------------------------------------------------
    */
    public function store(PostAppointmentRequest $request)
    {
        $post_data = $request->validated();

        $post_data['owner_id'] = $request->user()->id;

        $data = Appointment::create($post_data);

        return sendResponse(true,$data,"Appointment Created Successfully",200);
    }

    /*
    |--------------------------------------------------------------------------
    | Get Appointment
    |--------------------------------------------------------------------------
    */
    public function getBookData(Request $request,$username,$slug)
    {
        $user = User::whereUsername($username)->first();

        $data = $user->appointments()->whereSlug($slug)->first();

        $data['owner_name'] = $user->name;

        return sendResponse(true,$data,"Appointment Retrieved Successfully",200);
    }
}
