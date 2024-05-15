<?php

namespace App\Http\Controllers\Api;

use App\BundleCourse;
use App\Course;
use App\CourseProgress;
use App\Helpers\Is_wishlist;
use App\Http\Controllers\Controller;
use App\Http\Traits\SendNotification;
use App\Instructor;
use App\NewNotification;
use App\Order;
use App\ReviewHelpful;
use App\ReviewRating;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    //
    use SendNotification;
    public function userprofile(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'secret' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['Secret Key is required']);
        }

        $key = DB::table('api_keys')
            ->where('secret_key', '=', $request->secret)
            ->first();

        if (!$key) {
            return response()->json(['Invalid Secret Key !']);
        }

        $user = Auth::guard('api')->user();
        $code = $user->token();
        return response()->json(['user' => $user, 'code' => $code->id], 200);
    }

    public function updateprofile(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'secret' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['Secret Key is required']);
        }

        $key = DB::table('api_keys')
            ->where('secret_key', '=', $request->secret)
            ->first();

        if (!$key) {
            return response()->json(['Invalid Secret Key !']);
        }

        $auth = Auth::guard('api')->user();

        $request->validate([
            'email' => 'required',
            'current_password' => 'required',
        ]);
        $input = $request->all();

        if (Hash::check($request->current_password, $auth->password)) {
            if ($file = $request->file('user_img')) {
                if ($auth->user_img != null) {
                    $image_file = @file_get_contents(public_path() . '/images/user_img/' . $auth->user_img);
                    if ($image_file) {
                        unlink(public_path() . '/images/user_img/' . $auth->user_img);
                    }
                }
                $name = time() . '_' . $file->getClientOriginalName();
                $name = str_replace(" ", "_", $name);
                $file->move('images/user_img', $name);
                $input['user_img'] = $name;
            }
            $auth->update([
                'fname' => isset($input['fname']) ? $input['fname'] : $auth->fname,
                'lname' => isset($input['lname']) ? $input['lname'] : $auth->lname,
                'email' => $input['email'],
                'password' => isset($input['password']) ? bcrypt($input['password']) : $auth->password,
                'mobile' => isset($input['mobile']) ? $input['mobile'] : $auth->mobile,
                'dob' => isset($input['dob']) ? $input['dob'] : $auth->dob,
                'user_img' => isset($input['user_img']) ? $input['user_img'] : $auth->user_img,
                'address' => isset($input['address']) ? $input['address'] : $auth->address,
                'detail' => isset($input['detail']) ? $input['detail'] : $auth->detail,
            ]);

            $auth->save();
            return response()->json(['auth' => $auth], 200);
        } else {
            return response()->json('error: password doesnt match', 400);
        }
    }
    public function mycourses(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'secret' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['Secret Key is required']);
        }

        $key = DB::table('api_keys')
            ->where('secret_key', '=', $request->secret)
            ->first();

        if (!$key) {
            return response()->json(['Invalid Secret Key !']);
        }


        $my_orders = Order::where('status', '=', 1)->where('user_id', '=', Auth::guard('api')->id())->get(['id', 'course_id']);
        $mycourses_id = [];
        foreach ($my_orders as $myorder) {
            if ($myorder->course_id != null) {
                array_push($mycourses_id, $myorder->course_id);
            }
            if ($myorder->bundle_id != null) {
                $bundle = BundleCourse::where('id', $myorder->bundle_id)->first();
                foreach ($bundle->course_id as $bCourse_id) {
                    array_push($mycourses_id, $bCourse_id);
                }
            }
        }

        $course = Course::where('status', 1)
            ->whereIn('id', $mycourses_id)
            ->orderBy('id', 'DESC')
            ->with([
                'include' => function ($query) {
                    $query->where('status', 1);
                },
                'whatlearns' => function ($query) {
                    $query->where('status', 1);
                }, 'language' => function ($query) {
                    $query->where('status', 1);
                },
                'review' => function ($query) {
                    $query->with('user:id,fname,lname,user_img');
                },
                'user'
            ])
            ->paginate(6);


        foreach ($course as $result) {

            if (isset($result->review)) {
                $ratings_var11 = 0;
                $review_like = 0;
                $review_dislike = 0;

                foreach ($result->review as $key => $review) {
                    $user_count = count([$review]);
                    $user_sub_total = 0;
                    $user_learn_t = $review->learn * 5;
                    $user_price_t = $review->price * 5;
                    $user_value_t = $review->value * 5;
                    $user_sub_total = $user_sub_total + $user_learn_t + $user_price_t + $user_value_t;

                    $user_count = $user_count * 3 * 5;
                    $rat1 = $user_sub_total / $user_count;
                    $ratings_var11 = ($rat1 * 100) / 5;

                    $review_like = ReviewHelpful::where('review_id', $review->id)
                        ->where('course_id', $result->id)
                        ->where('review_like', 1)
                        ->count();

                    $review_dislike = ReviewHelpful::where('review_id', $review->id)
                        ->where('course_id', $result->id)
                        ->where('review_dislike', 1)
                        ->count();

                    $review->review_like = $review_like;
                    $review->review_dislike = $review_dislike;
                }
            }

            $student_enrolled = Order::where('course_id', $result->course_id)->count();
            $result->student_enrolled = isset($student_enrolled) ? $student_enrolled : null;
            $result->lecture_count = isset($result->chapter) ? count($result->chapter) : 0;

            $enrolled_status = Order::where('status', '=', 1)->where('course_id', $result->id)->where('user_id', Auth::guard('api')->id())->first();
            $progress = CourseProgress::where('course_id', $result->id)->where('user_id', Auth::guard('api')->id())->first();
            if (isset($progress)) {
                $result->mark_chapter_id = $progress->mark_chapter_id;
                $result->all_chapter_id  = $progress->all_chapter_id;
            } else {
                $result->mark_chapter_id = null;
                $result->all_chapter_id  = null;
            }
            if (isset($enrolled_status)) {
                $result->enrolled_status = true;
            } else {
                $result->enrolled_status = false;
            }

            $instructors_student = Order::where('instructor_id', $result->user->id)->count();
            $result->user->instructors_student = isset($instructors_student) ? $instructors_student : null;
            $result->user->course_count = Course::where('user_id', $result->user->id)->count();


            $reviews = ReviewRating::where('course_id', $result->id)
                ->where('status', '1')
                ->get();
            $count = ReviewRating::where('course_id', $result->id)->count();
            $learn = 0;
            $price = 0;
            $value = 0;
            $sub_total = 0;
            $sub_total = 0;
            $course_total_rating = 0;
            $total_rating = 0;

            if ($count > 0) {
                foreach ($reviews as $review) {
                    $learn = $review->learn * 5;
                    $price = $review->price * 5;
                    $value = $review->value * 5;
                    $sub_total = $sub_total + $learn + $price + $value;
                }

                $count = $count * 3 * 5;
                $rat = $sub_total / $count;
                $ratings_var0 = ($rat * 100) / 5;

                $course_total_rating = $ratings_var0;
            }

            $count = $count * 3 * 5;

            if ($count != 0) {
                $rat = $sub_total / $count;

                $ratings_var = ($rat * 100) / 5;

                $overallrating = $ratings_var0 / 2 / 10;

                $total_rating = round($overallrating, 1);
            }

            $result->in_wishlist = Is_wishlist::in_wishlist($result->id);
            $result->total_rating_percent = round($course_total_rating, 2);
            $result->total_rating = $total_rating;
        }
        $course->makeHidden('chapter');
        return response()->json(['course' => $course], 200);
    }
    public function instructorprofile(Request $request)
    {
        $this->validate($request, [
            'instructor_id' => 'required',
        ]);

        $validator = Validator::make($request->all(), [
            'secret' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['Secret Key is required']);
        }

        $key = DB::table('api_keys')
            ->where('secret_key', '=', $request->secret)
            ->first();

        if (!$key) {
            return response()->json(['Invalid Secret Key !']);
        }

        $user = User::where('id', $request->instructor_id)->first();
        $course_count = Course::where('user_id', $user->id)->count();
        $enrolled_user = Order::where('instructor_id', $user->id)->count();
        $course = Course::where('user_id', $user->id)->get();

        if ($user) {
            return response()->json(['user' => $user, 'course' => $course, 'course_count' => $course_count, 'enrolled_user' => $enrolled_user], 200);
        } else {
            return response()->json(['error'], 401);
        }
    }
    public function becomeaninstructor(Request $request)
    {
        $this->validate($request, [
            'fname'  => 'required',
            'lname'  => 'required',
            'email'  => 'required',
            'mobile' => 'required',
            'gender' => 'required',
            'detail' => 'required',
            'file'   => 'required',
            'image'  => 'required',
        ]);

        $validator = Validator::make($request->all(), [
            'secret' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['Secret Key is required']);
        }

        $key = DB::table('api_keys')
            ->where('secret_key', '=', $request->secret)
            ->first();

        if (!$key) {
            return response()->json(['Invalid Secret Key !']);
        }

        $auth = Auth::guard('api')->user();

        $users = Instructor::where('user_id', $auth->id)->get();

        $input = $request->all();


        if (!$users->isEmpty()) {
            return response()->json('Already Requested !', 401);
        } else {
            if ($file = $request->file('image')) {
                $name = time() . '_' . $file->getClientOriginalName();
                $name = str_replace(" ", "_", $name);
                $file->move('images/instructor', $name);
                $input['image'] = $name;
            }

            if ($file = $request->file('file')) {
                $name = time() . '_' . $file->getClientOriginalName();
                $name = str_replace(" ", "_", $name);
                $file->move('files/instructor/', $name);
                $input['file'] = $name;
            }


            $instructor = Instructor::create([
                'user_id' => $auth->id,
                'fname'   => isset($input['fname']) ? $input['fname'] : $auth->fname,
                'lname'   => isset($input['lname']) ? $input['lname'] : $auth->lname,
                'email'   => $input['email'],
                'mobile'  => isset($input['mobile']) ? $input['mobile'] : $auth->mobile,
                'image'   => isset($input['image']) ? $input['image'] : $auth->image,
                'file'    => $input['file'],
                'detail'  => isset($input['detail']) ? $input['detail'] : $auth->detail,
                'gender'  => isset($input['gender']) ? $input['gender'] : $auth->gender,
                'status'  => '0',
            ]);

            if ($instructor) {
                $admins = User::where('role', 'admin')->get();
                foreach ($admins as $admin) {
                    $body = 'A new instructor request has been added.';
                    $notification = NewNotification::create(['body' => $body]);
                    $notification->users()->attach(['user_id' => $admin->user_id]);
                }
            }

            return response()->json(['instructor' => $instructor], 200);
        }
    }
    public function userreview(Request $request)
    {
        $this->validate($request, [
            'course_id' => 'required',
            'learn' => 'required|integer|min:1|max:5|between:1,5',
            'price' => 'required|integer|min:1|max:5|between:1,5',
            'value' => 'required|integer|min:1|max:5|between:1,5',
            'review' => 'required',
        ]);

        $validator = Validator::make($request->all(), [
            'secret' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['Secret Key is required']);
        }

        $key = DB::table('api_keys')
            ->where('secret_key', '=', $request->secret)
            ->first();

        if (!$key) {
            return response()->json(['Invalid Secret Key !']);
        }

        $auth = Auth::guard('api')->user();

        $course = Course::where('id', $request->course_id)->first();

        $orders = Order::where('user_id', Auth::guard('api')->User()->id)
            ->where('course_id', $course->id)
            ->first();

        $review = ReviewRating::where('user_id', Auth::guard('api')->User()->id)
            ->where('course_id', $course->id)
            ->first();

        if (!empty($orders)) {
            if (!empty($review)) {
                return response()->json('Already Reviewed !', 402);
            } else {
                $input = $request->all();

                $review = ReviewRating::create([
                    'user_id' => $auth->id,
                    'course_id' => $input['course_id'],
                    'learn' => $input['learn'],
                    'price' => $input['price'],
                    'value' => $input['value'],
                    'review' => $input['review'],
                    'approved' => '1',
                    'featured' => '0',
                    'status' => '1',
                ]);

                return response()->json(['review' => $review], 200);
            }
        } else {
            return response()->json('Please Purchase course !', 401);
        }
    }
}
