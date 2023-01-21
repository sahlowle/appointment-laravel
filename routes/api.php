<?php

use App\Http\Controllers\Api\AppointmentController;
// use Cviebrock\EloquentSluggable\Services\SlugService;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\MeetingController;
use App\Mail\NewMeeting;
use App\Mail\RemindMeeting;
use App\Models\Meeting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Route;


/*
|--------------------------------------------------------------------------
| Auth Routes
|--------------------------------------------------------------------------
*/
Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout']);



/*
|--------------------------------------------------------------------------
| Sanctum Protected Routes
|--------------------------------------------------------------------------
*/

Route::middleware(['auth:sanctum'])->group(function () {
    // Appointments Routes
    Route::apiResource('appointments', AppointmentController::class)->only([
        'index', 'store'
    ]);
    // Meeting Scheduled Routs
    Route::get('/meetings/scheduled', [MeetingController::class, 'scheduled']);

});

Route::post('/meeting', [MeetingController::class, 'store']);


Route::get('/appointments/{username}/{slug}', [AppointmentController::class, 'getBookData']);




// get authenticated user
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('test-email', function () {

    // return $meeting = Meeting::with('user')->first();
    // $meeting->email ="mis.gxr@gmail.com";
    // $meeting->save();
    // Mail::to($meeting->email)->send(new RemindMeeting($meeting));

    // return "success";
});

// Route::get('check-slug', function () {

//     $slug = SlugService::createSlug(App\Models\Appointment::class, 'slug', request()->event_name);

//     return response()->json(['slug' => $slug]);
// });