<?php

namespace App\Console\Commands;

use App\Course;
use App\Mail\courseStartMail;
use App\Order;
use App\User;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class StartCourseMail extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'startMail:courses';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send mail to enrolled users befor the course start date';

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
        $courses = Course::whereDate('start_date', '=', Carbon::now()->addDays(1)->format('Y-m-d'))->get();
        if (count($courses) != 0) {
            foreach ($courses as $course) {
                $orders = Order::where('course_id', '=', $course->id)->where('status', '=', 1)->get();
                foreach ($orders as $order) {
                    $user = User::where('id', '=', $order->user_id)->where('status', '=', 1)->first();
                    if ($user->email) {
                        Mail::to($user->email)->send(new courseStartMail($user, $course));
                    }
                }
            }
        }
    }
}
