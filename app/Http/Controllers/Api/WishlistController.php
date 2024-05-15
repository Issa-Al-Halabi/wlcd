<?php

namespace App\Http\Controllers\Api;

use App\Course;
use App\CourseProgress;
use App\Helpers\Is_wishlist;
use App\Http\Controllers\Controller;
use App\Order;
use App\ReviewHelpful;
use App\ReviewRating;
use App\Wishlist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class WishlistController extends Controller
{
    
    public function showwishlist(Request $request)
    {
        // $validator = Validator::make($request->all(), [
        //     'secret' => 'required',
        // ]);

        // if ($validator->fails()) {
        //     return response()->json(['Secret Key is required']);
        // }

        // $key = DB::table('api_keys')
        //     ->where('secret_key', '=', $request->secret)
        //     ->first();

        // if (!$key) {
        //     return response()->json(['Invalid Secret Key !']);
        // }

        // $user = Auth::guard('api')->user();

        // $wishlist = Wishlist::where('user_id', $user->id)->orderBy('id', 'desc')->get();

        // $myWishlistCourses_id = [];
        // foreach ($wishlist as $wish) {
        //     array_push($myWishlistCourses_id, $wish->course_id);
        // }

        // $course = Course::where('status', 1)
        //     ->whereIn('id', $myWishlistCourses_id)
        //     ->orderByRaw("FIELD(id, " . implode(',', $myWishlistCourses_id) . ")")
        //     ->with([
        //         'include' => function ($query) {
        //             $query->where('status', 1);
        //         },
        //         'whatlearns' => function ($query) {
        //             $query->where('status', 1);
        //         },
        //         'language' => function ($query) {
        //             $query->where('status', 1);
        //         },
        //         'review' => function ($query) {
        //             $query->with('user:id,fname,lname,user_img');
        //         },
        //         'user'
        //     ])
        //     ->paginate(6);


        // foreach ($course as $result) {

        //     if (isset($result->review)) {
        //         $ratings_var11 = 0;
        //         $review_like = 0;
        //         $review_dislike = 0;

        //         foreach ($result->review as $key => $review) {
        //             $user_count = count([$review]);
        //             $user_sub_total = 0;
        //             $user_learn_t = $review->learn * 5;
        //             $user_price_t = $review->price * 5;
        //             $user_value_t = $review->value * 5;
        //             $user_sub_total = $user_sub_total + $user_learn_t + $user_price_t + $user_value_t;

        //             $user_count = $user_count * 3 * 5;
        //             $rat1 = $user_sub_total / $user_count;
        //             $ratings_var11 = ($rat1 * 100) / 5;

        //             $review_like = ReviewHelpful::where('review_id', $review->id)
        //                 ->where('course_id', $result->id)
        //                 ->where('review_like', 1)
        //                 ->count();

        //             $review_dislike = ReviewHelpful::where('review_id', $review->id)
        //                 ->where('course_id', $result->id)
        //                 ->where('review_dislike', 1)
        //                 ->count();

        //             $review->review_like = $review_like;
        //             $review->review_dislike = $review_dislike;
        //         }
        //     }

        //     $student_enrolled = Order::where('course_id', $result->course_id)->count();
        //     $result->student_enrolled = isset($student_enrolled) ? $student_enrolled : null;
        //     $result->lecture_count = isset($result->chapter) ? count($result->chapter) : 0;

        //     $enrolled_status = Order::where('status', '=', 1)->where('course_id', $result->id)->where('user_id', Auth::guard('api')->id())->first();
        //     $progress = CourseProgress::where('course_id', $result->id)->where('user_id', Auth::guard('api')->id())->first();
        //     if (isset($progress)) {
        //         $result->mark_chapter_id = $progress->mark_chapter_id;
        //         $result->all_chapter_id  = $progress->all_chapter_id;
        //     } else {
        //         $result->mark_chapter_id = null;
        //         $result->all_chapter_id  = null;
        //     }
        //     if (isset($enrolled_status)) {
        //         $result->enrolled_status = true;
        //     } else {
        //         $result->enrolled_status = false;
        //     }

        //     $instructors_student = Order::where('instructor_id', $result->user->id)->count();
        //     $result->user->instructors_student = isset($instructors_student) ? $instructors_student : null;
        //     $result->user->course_count = Course::where('user_id', $result->user->id)->count();


        //     $reviews = ReviewRating::where('course_id', $result->id)
        //         ->where('status', '1')
        //         ->get();
        //     $count = ReviewRating::where('course_id', $result->id)->count();
        //     $learn = 0;
        //     $price = 0;
        //     $value = 0;
        //     $sub_total = 0;
        //     $sub_total = 0;
        //     $course_total_rating = 0;
        //     $total_rating = 0;

        //     if ($count > 0) {
        //         foreach ($reviews as $review) {
        //             $learn = $review->learn * 5;
        //             $price = $review->price * 5;
        //             $value = $review->value * 5;
        //             $sub_total = $sub_total + $learn + $price + $value;
        //         }

        //         $count = $count * 3 * 5;
        //         $rat = $sub_total / $count;
        //         $ratings_var0 = ($rat * 100) / 5;

        //         $course_total_rating = $ratings_var0;
        //     }

        //     $count = $count * 3 * 5;

        //     if ($count != 0) {
        //         $rat = $sub_total / $count;

        //         $ratings_var = ($rat * 100) / 5;

        //         $overallrating = $ratings_var0 / 2 / 10;

        //         $total_rating = round($overallrating, 1);
        //     }

        //     $result->in_wishlist = Is_wishlist::in_wishlist($result->id);
        //     $result->total_rating_percent = round($course_total_rating, 2);
        //     $result->total_rating = $total_rating;
        // }
        // $course->makeHidden('chapter');
        // return response()->json(['course' => $course], 200);
        
        $validator = Validator::make($request->all(), [
            'secret' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['Secret Key is required']);
        }

        $key = DB::table('api_keys')->where('secret_key', '=', $request->secret)->first();

        if (!$key) {
            return response()->json(['Invalid Secret Key !']);
        }

        $user = Auth::guard('api')->user();

        $wishlist = Wishlist::where('user_id', $user->id)

            ->with(['courses' => function ($query) {
                $query->with('user');
            }])->get();

        return response()->json(array('wishlist' => $wishlist), 200);
    }

    public function addtowishlist(Request $request)
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

        $orders = Order::where('user_id', $auth->id)
            ->where('course_id', $request->course_id)
            ->first();

        $wishlist = Wishlist::where('course_id', $request->course_id)
            ->where('user_id', $auth->id)
            ->first();

        if (isset($orders)) {
            return response()->json('You Already purchased this course !', 401);
        } else {
            if (!empty($wishlist)) {
                return response()->json('Course is already in wishlist !', 401);
            } else {
                $wishlist = Wishlist::create([
                    'course_id' => $request->course_id,
                    'user_id' => $auth->id,
                ]);

                return response()->json('Course is added to your wishlist !', 200);
            }
        }
    }

    public function removewishlist(Request $request)
    {
        $this->validate($request, [
            'course_id' => 'required',
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

        $wishlist = Wishlist::where('course_id', $request->course_id)
            ->where('user_id', $auth->id)
            ->delete();

        if ($wishlist == 1) {
            return response()->json(['1'], 200);
        } else {
            return response()->json(['error'], 401);
        }
    }
}
