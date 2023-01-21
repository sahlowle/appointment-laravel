<?php

namespace App\Console\Commands;

use App\Mail\RemindMeeting;
use App\Models\Meeting;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class ReminderMeeting extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'reminder:meeting';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Remind Done Successfully';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $data = Meeting::with('user')->whereDate('meet_date','<=',Carbon::today())->get();

        foreach ($data as $key => $meeting) {

            date_default_timezone_set($meeting->time_zone);

            if ($meeting->meet_date->diffInMinutes(Carbon::now()) <= 60 && $meeting->is_sent == false ) {
                
                Mail::to($meeting->email)->send(new RemindMeeting($meeting));
                Mail::to($meeting->user->email)->send(new RemindMeeting($meeting));

                $meeting->update(['is_sent'=>true]);

            }

        }
    }
}
