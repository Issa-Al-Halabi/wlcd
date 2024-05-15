<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Auth;
use App\Course;
use Session;
use App\User;
use App\Http\Traits\SendNotification;
use App\NewNotification;

class EnrollmentController extends Controller
{
    use SendNotification;

    public function enroll(Request $request, $id)
    {
        $course = Course::where('id', $id)->first();

        DB::table('orders')->insert(
            array(
                'user_id' => Auth::User()->id,
                'instructor_id' => $course->user_id,
                'course_id' => $id,
                'total_amount' => 'Free',
                'created_at'  => \Carbon\Carbon::now()->toDateTimeString(),
            )
        );

        $admins = User::where('role', 'admin')->where('status', 1)->get();
        $instructor = User::where('id', $course->user_id)->where('status', 1)->first();
        $unique_instructor = 1;
        foreach ($admins as $admin) {
            if (isset($instructor)) {
                if ($instructor->id == $admin->id) {
                    $unique_instructor = 0;
                }
            }
            $body = 'A new enrollment request has been added to course: ' . $course->title;
            $notification = NewNotification::create(['body' => $body]);
            $notification->users()->attach(['user_id' => $admin->id]);
            if (isset($admin->device_token)) {
                $this->send_notification($admin->device_token, 'Course Enrollment', $body);
            }
        }
        if ($unique_instructor == 1 && isset($instructor)) {
            $body = 'A new enrollment request has been added to course: ' . $course->title;
            $notification = NewNotification::create(['body' => $body]);
            $notification->users()->attach(['user_id' => $instructor->id]);
            if (isset($admin->device_token)) {
                $this->send_notification($admin->device_token, 'Course Enrollment', $body);
            }
        }


        return back()->with('success', trans('flash.EnrolledSuccessfully'));
    }

    public function buynow(Request $request)
    {
        $user_check = User::where('id', $request->user_id)->first();
        $course = Course::where('id', $request->course_id)->first();

        // $course = Course::all();
        $cart = Course::where('id', $request->course_id)->first();

        $price_total = 0;
        $offer_total = 0;
        $cpn_discount = 0;


        if ($course->discount_price != 0) {
            $offer_total = $offer_total + $course->discount_price;
        } else {
            $offer_total = $offer_total + $course->price;
        }



        $price_total = $price_total + $course->price;




        //for offer percent
        $offer_amount  = $price_total - ($offer_total);
        $value         =  $offer_amount / $price_total;
        $offer_percent = $value * 100;

        $offer_percent = $request->offer_percent;


        $cart_total = $offer_total;

        $one_course = 1;

        Session::put('one_order_course', $course->id);

        Session::put('one_order_user', $user_check->id);

        return view('front.checkout', compact('course', 'cart', 'price_total', 'offer_total', 'offer_percent', 'cart_total', 'one_course'));
    }


    public function freeenroll(Request $request, $price)
    {

        $txn_id = uniqid();

        $payment_method = 'Free Enroll';

        $checkout = new OrderStoreController;

        return $checkout->orderstore($txn_id, $payment_method);
    }
}
