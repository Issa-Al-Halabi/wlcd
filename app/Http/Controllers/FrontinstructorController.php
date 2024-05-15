<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Course;


class FrontinstructorController extends Controller
{
    public function index()
    {
        $instructors = User::select('*')->where('role', 'instructor')->where('status', '1')->get();
        return view('front.instructor.index',compact('instructors'));
    }
    public function profile(Request $request, $id)
    {
        $user = User::where('id', $id)->first();
        $instructors = User::select('*')->where('role', 'instructor')->where('status', '1')->where('id', $request->id)->first();
        $courses = Course::where('user_id', $instructors->id)->paginate(5);
        return view('front.instructor.profile',compact('instructors','courses','user'));
    }
}
