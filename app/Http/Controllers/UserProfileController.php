<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Course;
use App\User;
use App\Country;
use App\State;
use App\City;
use Session;
use Image;
use Auth;
use Hash;
use Redirect;
use App\Order;
use App\CourseProgress;
use App\QuizAnswer;
use Validator;
use App\BBL;
use App\BundleCourse;
use App\Meeting;
use App\JitsiMeeting;
use App\Googlemeet;

class UserProfileController extends Controller
{
    public function userprofilepage($id)
    {
        if (Auth::check()) {
            $course = Course::all();
            $countries = Country::all();
            $states = State::all();
            $cities = City::all();
            $orders = User::where('id', Auth::User()->id)->first();
            return view('front.user_profile.profile', compact('orders', 'course', 'countries', 'states', 'cities'));
        }
        return Redirect::route('login')->withInput()->with('delete', trans('flash.PleaseLogin'));
    }

    public function userprofile(Request $request, $id)
    {
        $user = User::findorfail($id);

        $request->validate([
            'email' => 'required|email|unique:users,email,' . $user->id

        ]);

        $input = $request->all();

        if ($file = $request->file('user_img')) {

            $check_image_files = mime_content_type(@$_FILES["user_img"]["tmp_name"]);
            $valid = 0;
            if ($check_image_files == 'text/plain') {
                $valid = 1;
            }

            $validator = Validator::make(
                [
                    'file' => $request->user_img,
                    'extension' => strtolower($request->user_img->getClientOriginalExtension()),
                ],
                [
                    'file' => 'required',
                    'extension' => 'required|mimes::jpg,jpeg,bmp,png,webp',
                ]
            );

            if ($valid == 1) {
                return back()->withErrors('Invalid file !');
            }

            if ($validator->fails()) {
                return back()->withErrors('Invalid file !');
            }
            if ($user->user_img != "") {
                $content = @file_get_contents(public_path() . '/images/user_img/' . $user->user_img);
                if ($content) {
                    unlink(public_path() . '/images/user_img/' . $user->user_img);
                }
            }
            $name = time() . '_' . $file->getClientOriginalName();
            $name = str_replace(" ", "_", $name);
            $file->move('images/user_img', $name);
            $input['user_img'] = $name;
        }

        if (isset($request->update_pass)) {

            $input['password'] = Hash::make($request->password);
        } else {
            $input['password'] = $user->password;
        }

        $user->update($input);

        Session::flash('success', trans('flash.UpdatedSuccessfully'));
        return back();
    }


    public function leaderboard()
    {

        $user = User::where('id', Auth::User()->id)->first();

        $events = [
            'CompletedProfile'      => 20,
            'SocialProfileFacebook'   => 20,
            'SocialProfileTwitter'    => 20,
            'SocialProfileYoutube' => 20,
            'SocialProfileLinkedin' => 20,
        ];

        $CompletedProfile = 0;
        $SocialProfileFacebook = 0;
        $SocialProfileTwitter = 0;
        $SocialProfileYoutube = 0;
        $SocialProfileLinkedin = 0;

        // User filled out address, phone, email, etc.
        if (isset($user->address)) {

            $CompletedProfile = $events['CompletedProfile'];
        }

        // User added his Facebook Profile
        if (isset($user->fb_url)) {
            $SocialProfileFacebook = $events['SocialProfileFacebook'];
        }

        // User added his Twitter profile
        if (isset($user->twitter_url)) {
            $SocialProfileTwitter = $events['SocialProfileTwitter'];
        }

        // User added his Youtube profile
        if (isset($user->youtube_url)) {
            $SocialProfileYoutube = $events['SocialProfileYoutube'];
        }

        // User added his Linkedin profile
        if (isset($user->linkedin_url)) {
            $SocialProfileLinkedin = $events['SocialProfileLinkedin'];
        }


        $social_total = $CompletedProfile + $SocialProfileFacebook + $SocialProfileTwitter + $SocialProfileYoutube + $SocialProfileLinkedin;


        $orderss = Order::where('user_id', Auth::user()->id)->get();
        $total_courses = 0;
        if (count($orderss) > 0) {
            foreach ($orderss as $order) {
                if (isset($order->course_id)) {
                    $total_courses++;
                } elseif (isset($order->bundle_id)) {
                    $bundle = BundleCourse::where('id', $order->bundle_id)->first();
                    $courses = $bundle->course_id;
                    $total_courses += count($courses);
                }
            }
        }

        $total_completed = CourseProgress::where('user_id', Auth::user()->id)->get();


        $total_progess = 0;

        foreach ($total_completed as $progress) {
            if (count($progress->all_chapter_id) ==  count($progress->mark_chapter_id)) {
                $total_progess =  $total_progess += 1;
            }
        }



        $progresses = CourseProgress::where('user_id', Auth::User()->id)->get();

        $total_class = 0;
        $total_mark = 0;

        foreach ($progresses as $progress) {
            $total__class = $progress->all_chapter_id;
            $total__class =  count($total__class);
            $total_class += $total__class;



            $read_class = $progress->mark_chapter_id;
            $read_class =  count($read_class);
            $total_mark += $read_class;
            // $total_mark = $read_class;

        }
        // dd($total_class);

        $total_per = 100;

        if ($total_mark != 0) {
            //   $progres = ($total_class/$total_mark) * 100;
            $progres = ($total_mark / $total_class) * 100;

            $progres = round($progres / 10) * 10;
        } else {
            $progres = 0;
        }



        $ans = QuizAnswer::where('user_id', Auth::user()->id)->where('type', NULL)->get();

        $ans_count = QuizAnswer::where('user_id', Auth::user()->id)->where('type', NULL)->count();

        $mark = 0;
        $ca = 0;
        $correct = collect();

        foreach ($ans as $answer) {
            if ($answer->answer == $answer->user_answer) {
                $mark++;
                $ca++;
            }
        }


        $correct = $mark;



        if ($correct != 0) {
            $quiz_total = ($correct / $ans_count) * 100;

            $quiz_total = round($quiz_total / 10) * 10;
        } else {
            $quiz_total = 0;
        }





        $all_total = (($quiz_total + $progres + $social_total) / 300) * 100;

        $all_total = round($all_total / 10) * 10;

        $all_total_reverse = 100 - $all_total;


        $user_enrolled = Order::where('user_id', Auth::user()->id)->where('course_id', '!=', NULL)->get();


        if (count($user_enrolled) > 0) {
            foreach ($user_enrolled as $enrolled) {

                $bigbluemeeting = BBL::where('course_id', '=', $enrolled->course_id)->where('is_ended', '!=', 1)->where('link_by', '!=', NULL)->count();
                $zoommeeting = Meeting::where('course_id', '=', $enrolled->course_id)->where('link_by', '!=', NULL)->count();

                $jitsimeet = JitsiMeeting::where('course_id', '=', $enrolled->course_id)->where('link_by', '!=', NULL)->count();

                $googlemeet = Googlemeet::where('course_id', '=', $enrolled->course_id)->where('link_by', '!=', NULL)->count();
            }
        } else {

            $bigbluemeeting = 0;
            $zoommeeting = 0;
            $jitsimeet = 0;
            $googlemeet = 0;
        }



        $live_meeting_count = $bigbluemeeting + $zoommeeting + $jitsimeet + $googlemeet;



        return view('front.leaderboard', compact('user', 'social_total', 'total_courses', 'progres', 'quiz_total', 'total_progess', 'all_total', 'all_total_reverse', 'live_meeting_count'));
    }


    public function dashboard()
    {
        $user = User::where('id', Auth::user()->id)->first();
        return view('front.user_profile.dashboard', compact('user'));
    }
}
