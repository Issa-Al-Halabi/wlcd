<?php

namespace App\Http\Controllers\WebApi;

use App\Helpers\Is_wishlist;
use App\Http\Controllers\Controller;
use App\Http\Traits\SendNotification;
use Illuminate\Http\Request;
use App\{
    Announcement,
    Answer,
    Assignment,
    BundleCourse,
    Cart,
    Course,
    CourseChapter,
    CourseProgress,
    Googlemeet,
    NewNotification,
    Order,
    PreviousPaper,
    PrivateCourse,
    Question,
    Quiz,
    QuizAnswer,
    QuizTopic,
    ReviewHelpful,
    ReviewRating,
    RelatedCourse,
    User,
    Wishlist,
};
use Illuminate\Support\Facades\{
    App,
    Auth,
    DB,
    Validator,
};

class CourseController extends Controller
{
    use SendNotification;

    public function recentCourses(Request $request)
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

        App::setlocale($request->lang);

        $course = Course::select([
            'id', 'user_id', 'category_id', 'subcategory_id', 'childcategory_id', 'language_id', 'title',
            'price', 'discount_price', 'featured', 'slug', 'status', 'preview_image','thumble_preview_image', 'type', 'level_tags'
        ])
            ->where('status', 1)
            ->with([
                'language' => function ($query) {
                    $query->where('status', 1)->select('id', 'name');
                },
                'user' => function ($query) {
                    $query->where('status', 1)->select('id', 'fname', 'lname', 'user_img');
                },
            ])
            ->withCount([
                'chapter' => function ($query) {
                    $query->where('status', 1);
                },
                'order' => function ($query) {
                    $query->where('status', 1);
                },
            ])
            ->withSum('courseclass', 'duration')
            ->orderByDesc('id')
            ->take(8)
            ->get();

        foreach ($course as $result) {


            $enrolled_status = Order::where('refunded', '0')->where('status', '=', 1)->where('course_id', $result->id)->where('user_id', Auth::guard('api')->id())->first();
            $bundles = Order::where('user_id',  Auth::guard('api')->id())->where('bundle_id', '!=', NULL)->get();

            $bundle_status = array();


            foreach ($bundles as $b) {
                $bundle = BundleCourse::where('id', $b->bundle_id)->first();
                array_push($bundle_status, $bundle->course_id);
            }

            $bundle_status = array_values(array_filter($bundle_status));

            $bundle_status = array_flatten($bundle_status);

            if (isset($enrolled_status) || in_array($result->id, $bundle_status)) {
                $result->enrolled_status = true;
            } else {
                $result->enrolled_status = false;
            }

            $bundle_count = Order::where('bundle_course_id', 'like',  '%"' . $result->id . '"%')->where('status', '=', 1)->count();
            $result->order_count += $bundle_count;

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

        return response()->json(['recentcourses' => $course], 200);
    }

    public function allRecentCourses(Request $request)
    {
        App::setlocale($request->lang);

        $course = Course::select([
            'id', 'user_id', 'category_id', 'subcategory_id', 'childcategory_id', 'language_id', 'title',
            'price', 'discount_price', 'featured', 'slug', 'status', 'preview_image','thumble_preview_image', 'type', 'level_tags'
        ])
            ->where('status', 1)
            ->with([
                'language' => function ($query) {
                    $query->where('status', 1)->select('id', 'name');
                },
                'user' => function ($query) {
                    $query->where('status', 1)->select('id', 'fname', 'lname', 'user_img');
                },
            ])
            ->withCount([
                'chapter' => function ($query) {
                    $query->where('status', 1);
                },
                'order' => function ($query) {
                    $query->where('status', 1);
                },
            ])
            ->withSum('courseclass', 'duration')
            ->orderByDesc('id')
            ->get();


        foreach ($course as $result) {

            $enrolled_status = Order::where('refunded', '0')->where('status', '=', 1)->where('course_id', $result->id)->where('user_id', Auth::guard('api')->id())->first();
            $bundles = Order::where('user_id',  Auth::guard('api')->id())->where('bundle_id', '!=', NULL)->get();

            $bundle_status = array();


            foreach ($bundles as $b) {
                $bundle = BundleCourse::where('id', $b->bundle_id)->first();
                array_push($bundle_status, $bundle->course_id);
            }

            $bundle_status = array_values(array_filter($bundle_status));

            $bundle_status = array_flatten($bundle_status);

            if (isset($enrolled_status) || in_array($result->id, $bundle_status)) {
                $result->enrolled_status = true;
            } else {
                $result->enrolled_status = false;
            }

            $bundle_count = Order::where('bundle_course_id', 'like',  '%"' . $result->id . '"%')->where('status', '=', 1)->count();
            $result->order_count += $bundle_count;


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
        return response()->json(['recentcourses' => $course], 200);
    }

    public function featuredCourses(Request $request)
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

        App::setlocale($request->lang);

        $course = Course::select([
            'id', 'user_id', 'category_id', 'subcategory_id', 'childcategory_id', 'language_id', 'title',
            'price', 'discount_price', 'featured', 'slug', 'status', 'preview_image', 'thumble_preview_image', 'type', 'level_tags'
        ])
            ->where('status', 1)
            ->where('featured', 1)
            ->with([
                'language' => function ($query) {
                    $query->where('status', 1)->select('id', 'name');
                },
                'user' => function ($query) {
                    $query->where('status', 1)->select('id', 'fname', 'lname', 'user_img');
                },
            ])
            ->withCount([
                'chapter' => function ($query) {
                    $query->where('status', 1);
                },
                'order' => function ($query) {
                    $query->where('status', 1);
                },
            ])
            ->withSum('courseclass', 'duration')
            ->orderByDesc('id')
            ->take(8)
            ->get();

        foreach ($course as $result) {

            $enrolled_status = Order::where('refunded', '0')->where('status', '=', 1)->where('course_id', $result->id)->where('user_id', Auth::guard('api')->id())->first();
            $bundles = Order::where('user_id',  Auth::guard('api')->id())->where('bundle_id', '!=', NULL)->get();

            $bundle_status = array();


            foreach ($bundles as $b) {
                $bundle = BundleCourse::where('id', $b->bundle_id)->first();
                array_push($bundle_status, $bundle->course_id);
            }

            $bundle_status = array_values(array_filter($bundle_status));

            $bundle_status = array_flatten($bundle_status);

            if (isset($enrolled_status) || in_array($result->id, $bundle_status)) {
                $result->enrolled_status = true;
            } else {
                $result->enrolled_status = false;
            }

            $bundle_count = Order::where('bundle_course_id', 'like',  '%"' . $result->id . '"%')->where('status', '=', 1)->count();
            $result->order_count += $bundle_count;

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

        return response()->json(['featuredcourses' => $course], 200);
    }

    public function allFeaturedCourses(Request $request)
    {
        App::setlocale($request->lang);


        $course = Course::select([
            'id', 'user_id', 'category_id', 'subcategory_id', 'childcategory_id', 'language_id', 'title',
            'price', 'discount_price', 'featured', 'slug', 'status', 'preview_image', 'type', 'level_tags'
        ])
            ->where('status', 1)
            ->where('featured', 1)
            ->with([
                'language' => function ($query) {
                    $query->where('status', 1)->select('id', 'name');
                },
                'user' => function ($query) {
                    $query->where('status', 1)->select('id', 'fname', 'lname', 'user_img');
                },
            ])
            ->withCount([
                'chapter' => function ($query) {
                    $query->where('status', 1);
                },
                'order' => function ($query) {
                    $query->where('status', 1);
                },
            ])
            ->withSum('courseclass', 'duration')
            ->orderByDesc('id')
            ->get();

        foreach ($course as $result) {

            $enrolled_status = Order::where('refunded', '0')->where('status', '=', 1)->where('course_id', $result->id)->where('user_id', Auth::guard('api')->id())->first();
            $bundles = Order::where('user_id',  Auth::guard('api')->id())->where('bundle_id', '!=', NULL)->get();

            $bundle_status = array();


            foreach ($bundles as $b) {
                $bundle = BundleCourse::where('id', $b->bundle_id)->first();
                array_push($bundle_status, $bundle->course_id);
            }

            $bundle_status = array_values(array_filter($bundle_status));

            $bundle_status = array_flatten($bundle_status);

            if (isset($enrolled_status) || in_array($result->id, $bundle_status)) {
                $result->enrolled_status = true;
            } else {
                $result->enrolled_status = false;
            }

            $bundle_count = Order::where('bundle_course_id', 'like',  '%"' . $result->id . '"%')->where('status', '=', 1)->count();
            $result->order_count += $bundle_count;

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

        return response()->json(['featuredcourses' => $course], 200);
    }

    public function bestSellingCourses(Request $request)
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

        App::setlocale($request->lang);

        $course = Course::select([
            'id', 'user_id', 'category_id', 'subcategory_id', 'childcategory_id', 'language_id', 'title',
            'price', 'discount_price', 'featured', 'slug', 'status', 'preview_image', 'type', 'level_tags'
        ])
            ->where('status', 1)
            ->where('type', 1)
            ->with([
                'language' => function ($query) {
                    $query->where('status', 1)->select('id', 'name');
                },
                'user' => function ($query) {
                    $query->where('status', 1)->select('id', 'fname', 'lname', 'user_img');
                },
            ])
            ->withCount([
                'chapter' => function ($query) {
                    $query->where('status', 1);
                },
                'order' => function ($query) {
                    $query->where('status', 1);
                },
            ])
            ->withSum('courseclass', 'duration')
            ->orderBy('order_count', 'desc')
            ->take(8)
            ->get();

        foreach ($course as $result) {

            $enrolled_status = Order::where('refunded', '0')->where('status', '=', 1)->where('course_id', $result->id)->where('user_id', Auth::guard('api')->id())->first();
            $bundles = Order::where('user_id',  Auth::guard('api')->id())->where('bundle_id', '!=', NULL)->get();

            $bundle_status = array();


            foreach ($bundles as $b) {
                $bundle = BundleCourse::where('id', $b->bundle_id)->first();
                array_push($bundle_status, $bundle->course_id);
            }

            $bundle_status = array_values(array_filter($bundle_status));

            $bundle_status = array_flatten($bundle_status);

            if (isset($enrolled_status) || in_array($result->id, $bundle_status)) {
                $result->enrolled_status = true;
            } else {
                $result->enrolled_status = false;
            }

            $bundle_count = Order::where('bundle_course_id', 'like',  '%"' . $result->id . '"%')->where('status', '=', 1)->count();
            $result->order_count += $bundle_count;


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

        return response()->json(['bestselling' => $course], 200);
    }

    public function allBestSellingCourses(Request $request)
    {

        App::setlocale($request->lang);

        $course = Course::select([
            'id', 'user_id', 'category_id', 'subcategory_id', 'childcategory_id', 'language_id', 'title',
            'price', 'discount_price', 'featured', 'slug', 'status', 'preview_image', 'type', 'level_tags'
        ])
            ->where('status', 1)
            ->where('type', 1)
            ->with([
                'language' => function ($query) {
                    $query->where('status', 1)->select('id', 'name');
                },
                'user' => function ($query) {
                    $query->where('status', 1)->select('id', 'fname', 'lname', 'user_img');
                },
            ])
            ->withCount([
                'chapter' => function ($query) {
                    $query->where('status', 1);
                },
                'order' => function ($query) {
                    $query->where('status', 1);
                },
            ])
            ->withSum('courseclass', 'duration')
            ->orderBy('order_count', 'desc')
            ->get();

        foreach ($course as $result) {

            $enrolled_status = Order::where('refunded', '0')->where('status', '=', 1)->where('course_id', $result->id)->where('user_id', Auth::guard('api')->id())->first();
            $bundles = Order::where('user_id',  Auth::guard('api')->id())->where('bundle_id', '!=', NULL)->get();

            $bundle_status = array();


            foreach ($bundles as $b) {
                $bundle = BundleCourse::where('id', $b->bundle_id)->first();
                array_push($bundle_status, $bundle->course_id);
            }

            $bundle_status = array_values(array_filter($bundle_status));

            $bundle_status = array_flatten($bundle_status);

            if (isset($enrolled_status) || in_array($result->id, $bundle_status)) {
                $result->enrolled_status = true;
            } else {
                $result->enrolled_status = false;
            }

            $bundle_count = Order::where('bundle_course_id', 'like',  '%"' . $result->id . '"%')->where('status', '=', 1)->count();
            $result->order_count += $bundle_count;

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

        return response()->json(['allbestselling' => $course], 200);
    }

    public function myCourses(Request $request)
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

        App::setlocale($request->lang);

        $my_orders = Order::where('status', '=', 1)->where('user_id', '=', Auth::guard('api')->id())->get();
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


        $course = Course::select([
            'id', 'user_id', 'category_id', 'subcategory_id', 'childcategory_id', 'language_id', 'title',
            'price', 'discount_price', 'featured', 'slug', 'status', 'preview_image', 'type', 'level_tags'
        ])
            ->whereIn('id', $mycourses_id)
            ->where('status', 1)
            ->with([
                'language' => function ($query) {
                    $query->where('status', 1)->select('id', 'name');
                },
                'user' => function ($query) {
                    $query->where('status', 1)->select('id', 'fname', 'lname', 'user_img');
                },
            ])
            ->withCount([
                'chapter' => function ($query) {
                    $query->where('status', 1);
                },
                'order' => function ($query) {
                    $query->where('status', 1);
                },
            ])
            ->withSum('courseclass', 'duration')
            ->orderByDesc('id')
            ->take(8)
            ->get();

        foreach ($course as $result) {

            // $enrolled_status = Order::where('refunded', '0')->where('status', '=', 1)->where('course_id', $result->id)->where('user_id', Auth::guard('api')->id())->first();
            // $bundles = Order::where('user_id',  Auth::guard('api')->id())->where('bundle_id', '!=', NULL)->get();

            // $bundle_status = array();


            // foreach ($bundles as $b) {
            //     $bundle = BundleCourse::where('id', $b->bundle_id)->first();
            //     array_push($bundle_status, $bundle->course_id);
            // }

            // $bundle_status = array_values(array_filter($bundle_status));

            // $bundle_status = array_flatten($bundle_status);

            // if (isset($enrolled_status) || in_array($result->id, $bundle_status)) {
            $result->enrolled_status = true;
            // } else {
            //     $result->enrolled_status = false;
            // }

            $bundle_count = Order::where('bundle_course_id', 'like',  '%"' . $result->id . '"%')->where('status', '=', 1)->count();
            $result->order_count += $bundle_count;


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

        return response()->json(['mycourses' => $course], 200);
    }

    public function myAllCourses(Request $request)
    {

        App::setlocale($request->lang);

        $my_orders = Order::where('status', '=', 1)->where('user_id', '=', Auth::guard('api')->id())->get();
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


        $course = Course::select([
            'id', 'user_id', 'category_id', 'subcategory_id', 'childcategory_id', 'language_id', 'title',
            'price', 'discount_price', 'featured', 'slug', 'status', 'preview_image', 'type', 'level_tags'
        ])
            ->whereIn('id', $mycourses_id)
            ->where('status', 1)
            ->with([
                'language' => function ($query) {
                    $query->where('status', 1)->select('id', 'name');
                },
                'user' => function ($query) {
                    $query->where('status', 1)->select('id', 'fname', 'lname', 'user_img');
                },
            ])
            ->withCount([
                'chapter' => function ($query) {
                    $query->where('status', 1);
                },
                'order' => function ($query) {
                    $query->where('status', 1);
                },
            ])
            ->withSum('courseclass', 'duration')
            ->orderByDesc('id')
            ->get();

        foreach ($course as $result) {

            // $enrolled_status = Order::where('refunded', '0')->where('status', '=', 1)->where('course_id', $result->id)->where('user_id', Auth::guard('api')->id())->first();
            // $bundles = Order::where('user_id',  Auth::guard('api')->id())->where('bundle_id', '!=', NULL)->get();

            // $bundle_status = array();


            // foreach ($bundles as $b) {
            //     $bundle = BundleCourse::where('id', $b->bundle_id)->first();
            //     array_push($bundle_status, $bundle->course_id);
            // }

            // $bundle_status = array_values(array_filter($bundle_status));

            // $bundle_status = array_flatten($bundle_status);

            // if (isset($enrolled_status) || in_array($result->id, $bundle_status)) {
            $result->enrolled_status = true;
            // } else {
            //     $result->enrolled_status = false;
            // }

            $bundle_count = Order::where('bundle_course_id', 'like',  '%"' . $result->id . '"%')->where('status', '=', 1)->count();
            $result->order_count += $bundle_count;

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

        return response()->json(['myallcourses' => $course], 200);
    }

    public function freeCourses(Request $request)
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

        App::setlocale($request->lang);

        $course = Course::select([
            'id', 'user_id', 'category_id', 'subcategory_id', 'childcategory_id', 'language_id', 'title',
            'price', 'discount_price', 'featured', 'slug', 'status', 'preview_image', 'type', 'level_tags'
        ])
            ->where('status', 1)
            ->where('type', '!=', 1)
            ->with([
                'language' => function ($query) {
                    $query->where('status', 1)->select('id', 'name');
                },
                'user' => function ($query) {
                    $query->where('status', 1)->select('id', 'fname', 'lname', 'user_img');
                },
            ])
            ->withCount([
                'chapter' => function ($query) {
                    $query->where('status', 1);
                },
                'order' => function ($query) {
                    $query->where('status', 1);
                },
            ])->withSum('courseclass', 'duration')
            ->orderByDesc('id')
            ->take(8)
            ->get();


        foreach ($course as $result) {

            $enrolled_status = Order::where('refunded', '0')->where('status', '=', 1)->where('course_id', $result->id)->where('user_id', Auth::guard('api')->id())->first();
            $bundles = Order::where('user_id',  Auth::guard('api')->id())->where('bundle_id', '!=', NULL)->get();

            $bundle_status = array();


            foreach ($bundles as $b) {
                $bundle = BundleCourse::where('id', $b->bundle_id)->first();
                array_push($bundle_status, $bundle->course_id);
            }

            $bundle_status = array_values(array_filter($bundle_status));

            $bundle_status = array_flatten($bundle_status);

            if (isset($enrolled_status) || in_array($result->id, $bundle_status)) {
                $result->enrolled_status = true;
            } else {
                $result->enrolled_status = false;
            }

            $bundle_count = Order::where('bundle_course_id', 'like',  '%"' . $result->id . '"%')->where('status', '=', 1)->count();
            $result->order_count += $bundle_count;


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

        return response()->json(['freecourses' => $course], 200);
    }

    public function allFreeCourses(Request $request)
    {
        App::setlocale($request->lang);


        $course = Course::select([
            'id', 'user_id', 'category_id', 'subcategory_id', 'childcategory_id', 'language_id', 'title',
            'price', 'discount_price', 'featured', 'slug', 'status', 'preview_image', 'type', 'level_tags'
        ])
            ->where('status', 1)
            ->where('type', '!=', 1)
            ->with([
                'language' => function ($query) {
                    $query->where('status', 1)->select('id', 'name');
                },
                'user' => function ($query) {
                    $query->where('status', 1)->select('id', 'fname', 'lname', 'user_img');
                },
            ])
            ->withCount([
                'chapter' => function ($query) {
                    $query->where('status', 1);
                },
                'order' => function ($query) {
                    $query->where('status', 1);
                },
            ])
            ->withSum('courseclass', 'duration')
            ->orderByDesc('id')
            ->get();

        foreach ($course as $result) {

            $enrolled_status = Order::where('refunded', '0')->where('status', '=', 1)->where('course_id', $result->id)->where('user_id', Auth::guard('api')->id())->first();
            $bundles = Order::where('user_id',  Auth::guard('api')->id())->where('bundle_id', '!=', NULL)->get();

            $bundle_status = array();


            foreach ($bundles as $b) {
                $bundle = BundleCourse::where('id', $b->bundle_id)->first();
                array_push($bundle_status, $bundle->course_id);
            }

            $bundle_status = array_values(array_filter($bundle_status));

            $bundle_status = array_flatten($bundle_status);

            if (isset($enrolled_status) || in_array($result->id, $bundle_status)) {
                $result->enrolled_status = true;
            } else {
                $result->enrolled_status = false;
            }

            $bundle_count = Order::where('bundle_course_id', 'like',  '%"' . $result->id . '"%')->where('status', '=', 1)->count();
            $result->order_count += $bundle_count;

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

        return response()->json(['allfreecourses' => $course], 200);
    }
    
    public function recordCourses(Request $request)
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

        App::setlocale($request->lang);

        $course = Course::select([
            'id', 'user_id', 'category_id', 'subcategory_id', 'childcategory_id', 'language_id', 'title',
            'price', 'discount_price', 'featured', 'slug', 'status', 'preview_image', 'type', 'level_tags','course_type'
        ])
            ->where('course_type', 2)
            ->where('status', 1)
            ->with([
                'language' => function ($query) {
                    $query->where('status', 1)->select('id', 'name');
                },
                'user' => function ($query) {
                    $query->where('status', 1)->select('id', 'fname', 'lname', 'user_img');
                },
            ])
            ->withCount([
                'chapter' => function ($query) {
                    $query->where('status', 1);
                },
                'order' => function ($query) {
                    $query->where('status', 1);
                },
            ])->withSum('courseclass', 'duration')
            ->orderByDesc('id')
            ->take(8)
            ->get();


        foreach ($course as $result) {

            $enrolled_status = Order::where('refunded', '0')->where('status', '=', 1)->where('course_id', $result->id)->where('user_id', Auth::guard('api')->id())->first();
            $bundles = Order::where('user_id',  Auth::guard('api')->id())->where('bundle_id', '!=', NULL)->get();

            $bundle_status = array();


            foreach ($bundles as $b) {
                $bundle = BundleCourse::where('id', $b->bundle_id)->first();
                array_push($bundle_status, $bundle->course_id);
            }

            $bundle_status = array_values(array_filter($bundle_status));

            $bundle_status = array_flatten($bundle_status);

            if (isset($enrolled_status) || in_array($result->id, $bundle_status)) {
                $result->enrolled_status = true;
            } else {
                $result->enrolled_status = false;
            }

            $bundle_count = Order::where('bundle_course_id', 'like',  '%"' . $result->id . '"%')->where('status', '=', 1)->count();
            $result->order_count += $bundle_count;


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

        return response()->json(['RecordCourses' => $course], 200);
    }

    public function allRecordCourses(Request $request)
    {
        App::setlocale($request->lang);


        $course = Course::select([
            'id', 'user_id', 'category_id', 'subcategory_id', 'childcategory_id', 'language_id', 'title',
            'price', 'discount_price', 'featured', 'slug', 'status', 'preview_image', 'type', 'level_tags','course_type'
        ])
            ->where('course_type', 2)
            ->where('status', 1)
            ->with([
                'language' => function ($query) {
                    $query->where('status', 1)->select('id', 'name');
                },
                'user' => function ($query) {
                    $query->where('status', 1)->select('id', 'fname', 'lname', 'user_img');
                },
            ])
            ->withCount([
                'chapter' => function ($query) {
                    $query->where('status', 1);
                },
                'order' => function ($query) {
                    $query->where('status', 1);
                },
            ])
            ->withSum('courseclass', 'duration')
            ->orderByDesc('id')
            ->get();

        foreach ($course as $result) {

            $enrolled_status = Order::where('refunded', '0')->where('status', '=', 1)->where('course_id', $result->id)->where('user_id', Auth::guard('api')->id())->first();
            $bundles = Order::where('user_id',  Auth::guard('api')->id())->where('bundle_id', '!=', NULL)->get();

            $bundle_status = array();


            foreach ($bundles as $b) {
                $bundle = BundleCourse::where('id', $b->bundle_id)->first();
                array_push($bundle_status, $bundle->course_id);
            }

            $bundle_status = array_values(array_filter($bundle_status));

            $bundle_status = array_flatten($bundle_status);

            if (isset($enrolled_status) || in_array($result->id, $bundle_status)) {
                $result->enrolled_status = true;
            } else {
                $result->enrolled_status = false;
            }

            $bundle_count = Order::where('bundle_course_id', 'like',  '%"' . $result->id . '"%')->where('status', '=', 1)->count();
            $result->order_count += $bundle_count;

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

        return response()->json(['allRecordCourses' => $course], 200);
    }
    
    public function onlineCourses(Request $request)
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

        App::setlocale($request->lang);

        $course = Course::select([
            'id', 'user_id', 'category_id', 'subcategory_id', 'childcategory_id', 'language_id', 'title',
            'price', 'discount_price', 'featured', 'slug', 'status', 'preview_image', 'type', 'level_tags','course_type'
        ])
            ->where('course_type', 1)
            ->where('status', 1)
            ->with([
                'language' => function ($query) {
                    $query->where('status', 1)->select('id', 'name');
                },
                'user' => function ($query) {
                    $query->where('status', 1)->select('id', 'fname', 'lname', 'user_img');
                },
            ])
            ->withCount([
                'chapter' => function ($query) {
                    $query->where('status', 1);
                },
                'order' => function ($query) {
                    $query->where('status', 1);
                },
            ])->withSum('courseclass', 'duration')
            ->orderByDesc('id')
            ->take(8)
            ->get();
        
        foreach ($course as $result) {

            $enrolled_status = Order::where('refunded', '0')->where('status', '=', 1)->where('course_id', $result->id)->where('user_id', Auth::guard('api')->id())->first();
            $bundles = Order::where('user_id',  Auth::guard('api')->id())->where('bundle_id', '!=', NULL)->get();

            $bundle_status = array();


            foreach ($bundles as $b) {
                $bundle = BundleCourse::where('id', $b->bundle_id)->first();
                array_push($bundle_status, $bundle->course_id);
            }

            $bundle_status = array_values(array_filter($bundle_status));

            $bundle_status = array_flatten($bundle_status);

            if (isset($enrolled_status) || in_array($result->id, $bundle_status)) {
                $result->enrolled_status = true;
            } else {
                $result->enrolled_status = false;
            }

            $bundle_count = Order::where('bundle_course_id', 'like',  '%"' . $result->id . '"%')->where('status', '=', 1)->count();
            $result->order_count += $bundle_count;


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

        return response()->json(['onlineCourses' => $course], 200);
    }

    public function allOnlineCourses(Request $request)
    {
        App::setlocale($request->lang);


        $course = Course::select([
            'id', 'user_id', 'category_id', 'subcategory_id', 'childcategory_id', 'language_id', 'title',
            'price', 'discount_price', 'featured', 'slug', 'status', 'preview_image', 'type', 'level_tags','course_type'
        ])
            ->where('course_type', 1)
            ->where('status', 1)
            ->with([
                'language' => function ($query) {
                    $query->where('status', 1)->select('id', 'name');
                },
                'user' => function ($query) {
                    $query->where('status', 1)->select('id', 'fname', 'lname', 'user_img');
                },
            ])
            ->withCount([
                'chapter' => function ($query) {
                    $query->where('status', 1);
                },
                'order' => function ($query) {
                    $query->where('status', 1);
                },
            ])
            ->withSum('courseclass', 'duration')
            ->orderByDesc('id')
            ->get();

        foreach ($course as $result) {

            $enrolled_status = Order::where('refunded', '0')->where('status', '=', 1)->where('course_id', $result->id)->where('user_id', Auth::guard('api')->id())->first();
            $bundles = Order::where('user_id',  Auth::guard('api')->id())->where('bundle_id', '!=', NULL)->get();

            $bundle_status = array();


            foreach ($bundles as $b) {
                $bundle = BundleCourse::where('id', $b->bundle_id)->first();
                array_push($bundle_status, $bundle->course_id);
            }

            $bundle_status = array_values(array_filter($bundle_status));

            $bundle_status = array_flatten($bundle_status);

            if (isset($enrolled_status) || in_array($result->id, $bundle_status)) {
                $result->enrolled_status = true;
            } else {
                $result->enrolled_status = false;
            }

            $bundle_count = Order::where('bundle_course_id', 'like',  '%"' . $result->id . '"%')->where('status', '=', 1)->count();
            $result->order_count += $bundle_count;

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

        return response()->json(['allOnlineCourses' => $course], 200);
    }

    public function topDiscountedCourses(Request $request)
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


        App::setlocale($request->lang);

        $course = Course::select([
            'id', 'user_id', 'category_id', 'subcategory_id', 'childcategory_id', 'language_id', 'title',
            'price', 'discount_price', 'featured', 'slug', 'status', 'preview_image', 'type', 'level_tags'
        ])
            ->where('status', 1)
            ->where('type', '1')
            ->where('discount_price', '!=', null)
            ->with([
                'language' => function ($query) {
                    $query->where('status', 1)->select('id', 'name');
                },
                'user' => function ($query) {
                    $query->where('status', 1)->select('id', 'fname', 'lname', 'user_img');
                },
            ])
            ->withCount([
                'chapter' => function ($query) {
                    $query->where('status', 1);
                },
                'order' => function ($query) {
                    $query->where('status', 1);
                },
            ])
            ->withSum('courseclass', 'duration')
            ->get();

        foreach ($course as $result) {

            if ($result->price != 0) {
                $result->discount_percentage = (($result->price - $result->discount_price) / $result->price) * 100;
            }

            $enrolled_status = Order::where('refunded', '0')->where('status', '=', 1)->where('course_id', $result->id)->where('user_id', Auth::guard('api')->id())->first();
            $bundles = Order::where('user_id',  Auth::guard('api')->id())->where('bundle_id', '!=', NULL)->get();

            $bundle_status = array();


            foreach ($bundles as $b) {
                $bundle = BundleCourse::where('id', $b->bundle_id)->first();
                array_push($bundle_status, $bundle->course_id);
            }

            $bundle_status = array_values(array_filter($bundle_status));

            $bundle_status = array_flatten($bundle_status);

            if (isset($enrolled_status) || in_array($result->id, $bundle_status)) {
                $result->enrolled_status = true;
            } else {
                $result->enrolled_status = false;
            }

            $bundle_count = Order::where('bundle_course_id', 'like',  '%"' . $result->id . '"%')->where('status', '=', 1)->count();
            $result->order_count += $bundle_count;

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

        $course = $course->sortByDesc('discount_percentage')->take(8);
        $course = $course->values()->all();
        return response()->json(['topDiscountedcourses' => $course], 200);
    }

    public function allTopDiscountedCourses(Request $request)
    {
        App::setlocale($request->lang);

        $course = Course::select([
            'id', 'user_id', 'category_id', 'subcategory_id', 'childcategory_id', 'language_id', 'title',
            'price', 'discount_price', 'featured', 'slug', 'status', 'preview_image', 'type', 'level_tags'
        ])
            ->where('status', 1)
            ->where('type', '1')
            ->where('discount_price', '!=', null)
            ->with([
                'language' => function ($query) {
                    $query->where('status', 1)->select('id', 'name');
                },
                'user' => function ($query) {
                    $query->where('status', 1)->select('id', 'fname', 'lname', 'user_img');
                },
            ])
            ->withCount([
                'chapter' => function ($query) {
                    $query->where('status', 1);
                },
                'order' => function ($query) {
                    $query->where('status', 1);
                },
            ])
            ->withSum('courseclass', 'duration')
            ->get();

        foreach ($course as $result) {

            if ($result->price != 0) {
                $result->discount_percentage = (($result->price - $result->discount_price) / $result->price) * 100;
            }

            $enrolled_status = Order::where('refunded', '0')->where('status', '=', 1)->where('course_id', $result->id)->where('user_id', Auth::guard('api')->id())->first();
            $bundles = Order::where('user_id',  Auth::guard('api')->id())->where('bundle_id', '!=', NULL)->get();

            $bundle_status = array();


            foreach ($bundles as $b) {
                $bundle = BundleCourse::where('id', $b->bundle_id)->first();
                array_push($bundle_status, $bundle->course_id);
            }

            $bundle_status = array_values(array_filter($bundle_status));

            $bundle_status = array_flatten($bundle_status);

            if (isset($enrolled_status) || in_array($result->id, $bundle_status)) {
                $result->enrolled_status = true;
            } else {
                $result->enrolled_status = false;
            }
            $bundle_count = Order::where('bundle_course_id', 'like',  '%"' . $result->id . '"%')->where('status', '=', 1)->count();
            $result->order_count += $bundle_count;

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

        // $course = $course->setCollection($course->sortByDesc('discount_percentage')->values());
        $course = $course->sortByDesc('discount_percentage')->values();
        return response()->json(['topDiscountedcourses' => $course], 200);
    }

    public function bundleDetails(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id'   => 'required|exists:bundle_courses,id',
            'lang' => 'required',
        ]);

        App::setlocale($request->lang);

        $bundle = BundleCourse::where('id', $request->id)->first();

        $cart = Cart::where('user_id', Auth::guard('api')->id())->where('bundle_id', $bundle->id)->first();
        $Purchased = Order::where('user_id', Auth::guard('api')->id())->where('bundle_id', $bundle->id)->first();

        $result = [];

        $courses = Course::select([
            'id', 'user_id', 'category_id', 'subcategory_id', 'childcategory_id', 'language_id', 'title',
            'price', 'discount_price', 'featured', 'slug', 'status', 'preview_image', 'type', 'level_tags', 'short_detail'
        ])
            ->where('status', 1)
            ->whereIn('id', $bundle->course_id)
            ->with([
                'language' => function ($query) {
                    $query->where('status', 1)->select('id', 'name');
                },
                'user' => function ($query) {
                    $query->where('status', 1)->select('id', 'fname', 'lname', 'user_img');
                },
            ])
            ->withCount([
                'chapter' => function ($query) {
                    $query->where('status', 1);
                },
                'order' => function ($query) {
                    $query->where('status', 1);
                },
            ])
            ->withSum('courseclass', 'duration')
            ->orderByDesc('id')
            ->get();

        foreach ($courses as $course) {

            $enrolled_status = Order::where('refunded', '0')->where('status', '=', 1)->where('course_id', $course->id)->where('user_id', Auth::guard('api')->id())->first();
            $bundles = Order::where('user_id',  Auth::guard('api')->id())->where('bundle_id', '!=', NULL)->get();

            $bundle_status = array();


            foreach ($bundles as $b) {
                $bundle = BundleCourse::where('id', $b->bundle_id)->first();
                array_push($bundle_status, $bundle->course_id);
            }

            $bundle_status = array_values(array_filter($bundle_status));

            $bundle_status = array_flatten($bundle_status);

            if (isset($enrolled_status) || in_array($course->id, $bundle_status)) {
                $course->enrolled_status = true;
            } else {
                $course->enrolled_status = false;
            }

            $bundle_count = Order::where('bundle_course_id', 'like',  '%"' . $course->id . '"%')->where('status', '=', 1)->count();
            $course->order_count += $bundle_count;

            $reviews = ReviewRating::where('course_id', $course->id)
                ->where('status', '1')
                ->get();
            $count = ReviewRating::where('course_id', $course->id)->count();
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

            $course->in_wishlist = Is_wishlist::in_wishlist($course->id);
            $course->total_rating_percent = round($course_total_rating, 2);
            $course->total_rating = $total_rating;
        }

        $result[] = [
            'id'         => $bundle->id,
            'user'       => $bundle->user->fname . ' ' . $bundle->user->lname,
            'user_image' => $bundle->user->user_img,
            'user_image_path' => url('images/user_img/' . $bundle->user->user_img),
            'course_id'  => $bundle->course_id,
            'title'      => $bundle->title,
            'detail'     => strip_tags($bundle->detail),
            'price'      => $bundle->price,
            'discount_price' => $bundle->discount_price,
            'type'       => $bundle->type,
            'slug'       => $bundle->slug,
            'status'     => $bundle->status,
            'featured'   => $bundle->featured,
            'preview_image' => $bundle->preview_image,
            'imagepath'  => url('images/bundle/' . $bundle->preview_image),
            'in_cart'    => $cart ? 1 : 0,
            'Purchased'  => $Purchased ? 1 : 0,
            'created_at' => $bundle->created_at,
            'updated_at' => $bundle->updated_at,
            'courses'    => $courses,
        ];

        if (empty($result)) {
            return response()->json(['bundle' => $result], 200);
        }

        return response()->json(['bundle' => $result], 200);
    }

    public function bundleCourses(Request $request)
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

        App::setlocale($request->lang);

        $bundles = BundleCourse::where('status', 1)->take(8)->get();

        $result = [];

        foreach ($bundles as $bundle) {
            $courses_in_bundle = [];

            foreach ($bundle->course_id as $bundles) {
                $course = Course::where('id', $bundles)->first();

                $courses_in_bundle[] = [
                    'id' => $course->id,
                    'user' => $course->user->fname,
                    'title' => $course->title,
                    'short_detail' => $course->short_detail,
                    'image' => $course->preview_image,
                    'img_path' => url('images/course/' . $course->preview_image),
                    'thumbleImage' => $course->thumble_preview_image,
                    'thumble_img_path' => url('images/course/' . $course->thumble_preview_image),
                    'type' => $course->type,
                    'price' => $course->price,
                    'discount_price' => $course->discount_price,
                ];
            }

            $result[] = [
                'id' => $bundle->id,
                'user' => $bundle->user->fname . ' ' . $bundle->user->lname,
                'user_image' => $bundle->user->user_img,
                'user_image_path' => url('images/user_img/' . $bundle->user->user_img),
                'course_id' => $bundle->course_id,
                'title' => $bundle->title,
                'detail' => strip_tags($bundle->detail),
                'price' => $bundle->price,
                'discount_price' => $bundle->discount_price,
                'type' => $bundle->type,
                'slug' => $bundle->slug,
                'status' => $bundle->status,
                'featured' => $bundle->featured,
                'preview_image' => $bundle->preview_image,
                'imagepath' => url('images/bundle/' . $bundle->preview_image),
                'thumble_preview_image' => $bundle->thumble_preview_image,
                'thumbleImagepath' => url('images/bundle/' . $bundle->thumble_preview_image),
                'created_at' => $bundle->created_at,
                'updated_at' => $bundle->updated_at,
                'course' => $courses_in_bundle,
            ];
        }

        if (empty($result)) {
            return response()->json(['bundle' => $result], 200);
        }

        return response()->json(['bundle' => $result], 200);
    }

    public function allBundleCourses(Request $request)
    {
        App::setlocale($request->lang);

        $bundles = BundleCourse::where('status', 1)->get();

        $result = [];

        foreach ($bundles as $bundle) {
            $courses_in_bundle = [];

            foreach ($bundle->course_id as $bundles) {
                $course = Course::where('id', $bundles)->first();

                $courses_in_bundle[] = [
                    'id' => $course->id,
                    'user' => $course->user->fname,
                    'title' => $course->title,
                    'short_detail' => $course->short_detail,
                    'image' => $course->preview_image,
                    'img_path' => url('images/course/' . $course->preview_image),
                    'thumbleImage' => $course->thumble_preview_image,
                    'thumble_img_path' => url('images/course/' . $course->thumble_preview_image),
                    'type' => $course->type,
                    'price' => $course->price,
                    'discount_price' => $course->discount_price,
                ];
            }

            $result[] = [
                'id' => $bundle->id,
                'user' => $bundle->user->fname . ' ' . $bundle->user->lname,
                'user_image' => $bundle->user->user_img,
                'user_image_path' => url('images/user_img/' . $bundle->user->user_img),
                'course_id' => $bundle->course_id,
                'title' => $bundle->title,
                'detail' => strip_tags($bundle->detail),
                'price' => $bundle->price,
                'discount_price' => $bundle->discount_price,
                'type' => $bundle->type,
                'slug' => $bundle->slug,
                'status' => $bundle->status,
                'featured' => $bundle->featured,
                'preview_image' => $bundle->preview_image,
                'imagepath' => url('images/bundle/' . $bundle->preview_image),
                'thumble_preview_image' => $bundle->thumble_preview_image,
                'thumbleImagepath' => url('images/bundle/' . $bundle->thumble_preview_image),
                'created_at' => $bundle->created_at,
                'updated_at' => $bundle->updated_at,
                'course' => $courses_in_bundle,
            ];
        }

        if (empty($result)) {
            return response()->json(['bundle' => $result], 200);
        }

        return response()->json(['bundle' => $result], 200);
    }

    public function courseDetails(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'secret' => 'required',
            'lang' => 'required',
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

        App::setlocale($request->lang);

        if (Auth::guard('api')->check()) {
            $user = Auth::guard('api')->user();

            $private_courses = PrivateCourse::where('status', 1)
                ->where('course_id', '=', $request->course_id)
                ->first();

            if (isset($private_courses)) {
                $user_id = [];
                array_push($user_id, $private_courses->user_id);
                $user_id = array_values(array_filter($user_id));
                $user_id = array_flatten($user_id);

                $user_id;

                if (in_array($user->id, $user_id)) {
                    return response()->json(['Unauthorized Action'], 401);
                }
            }
        }

        $result = Course::where('id', '=', $request->course_id)
            ->where('status', 1)
            ->with(['category', 'subCategory', 'childCategory'])
            ->with([
                'include' => function ($query) {
                    $query->where('status', 1)->select('id', 'course_id', 'icon', 'detail', 'status');
                },
                'whatlearns' => function ($query) {
                    $query->where('status', 1)->select('id', 'course_id', 'detail', 'status');
                },
                'language' => function ($query) {
                    $query->where('status', 1)->select('id', 'name');
                },
                'policy',
            ])
            ->withCount([
                'chapter' => function ($query) {
                    $query->where('status', 1);
                },
                'courseclass' => function ($query) {
                    $query->where('status', 1);
                },
                'order' => function ($query) {
                    $query->where('status', 1);
                },
                'quiztopic' => function ($query) {
                    $query->where('status', 1);
                },
            ])
            ->withSum('courseclass', 'duration')
            ->first();

        if (!$result) {
            return response()->json('404 | Course not found !');
        }

        $enrolled_status = Order::where('refunded', '0')->where('status', '=', 1)->where('course_id', $result->id)->where('user_id', Auth::guard('api')->id())->first();
        $bundles = Order::where('user_id',  Auth::guard('api')->id())->where('bundle_id', '!=', NULL)->get();

        $bundle_status = array();


        foreach ($bundles as $b) {
            $bundle = BundleCourse::where('id', $b->bundle_id)->first();
            array_push($bundle_status, $bundle->course_id);
        }

        $bundle_status = array_values(array_filter($bundle_status));

        $bundle_status = array_flatten($bundle_status);

        if (isset($enrolled_status) || in_array($result->id, $bundle_status)) {
            $result->enrolled_status = true;
        } else {
            $result->enrolled_status = false;
        }

        $bundle_count = Order::where('bundle_course_id', 'like',  '%"' . $result->id . '"%')->where('status', '=', 1)->count();
        $result->order_count += $bundle_count;

        $reviews = ReviewRating::where('course_id', $request->course_id)
            ->where('status', '1')
            ->get();
        $count = ReviewRating::where('course_id', $request->course_id)->count();
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
                $value = $review->price * 5;
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

        //learn
        $learn = 0;
        $total = 0;
        $total_learn = 0;

        if ($count > 0) {
            $count = ReviewRating::where('course_id', $request->course_id)->count();

            foreach ($reviews as $review) {
                $learn = $review->learn * 5;
                $total = $total + $learn;
            }

            $count = $count * 1 * 5;
            $rat = $total / $count;
            $ratings_var1 = ($rat * 100) / 5;

            $total_learn = $ratings_var1;
        }

        //price
        $price = 0;
        $total = 0;
        $total_price = 0;

        if ($count > 0) {
            $count = ReviewRating::where('course_id', $request->course_id)->count();

            foreach ($reviews as $review) {
                $price = $review->price * 5;
                $total = $total + $price;
            }

            $count = $count * 1 * 5;
            $rat = $total / $count;
            $ratings_var2 = ($rat * 100) / 5;

            $total_price = $ratings_var2;
        }

        //value
        $value = 0;
        $total = 0;
        $total_value = 0;

        if ($count > 0) {
            $count = ReviewRating::where('course_id', $request->course_id)->count();

            foreach ($reviews as $review) {
                $value = $review->value * 5;
                $total = $total + $value;
            }

            $count = $count * 1 * 5;
            $rat = $total / $count;
            $ratings_var3 = ($rat * 100) / 5;

            $total_value = $ratings_var3;
        }

        $result->makeHidden(['review', 'instructor_revenue', 'new_course_mail', 'reject_txt', 'involvement_request']);

        $enrollment_status = Order::where('course_id', $request->course_id)->where('user_id', Auth::guard('api')->id())->where('status', 1)->first();

        $cart = Cart::where('user_id', Auth::guard('api')->id())->where('course_id', $result->id)->first();

        $relatedcourse = RelatedCourse::where('status', 1)->where('main_course_id', '=', $request->course_id)->pluck('course_id');

        $related = Course::select([
            'id', 'user_id', 'category_id', 'subcategory_id', 'childcategory_id', 'language_id', 'title',
            'price', 'discount_price', 'featured', 'slug', 'status', 'preview_image','thumble_preview_image', 'type', 'level_tags'
        ])
            ->where('status', 1)
            ->whereIn('id', $relatedcourse)
            ->with([
                'language' => function ($query) {
                    $query->where('status', 1)->select('id', 'name');
                },
                'user' => function ($query) {
                    $query->where('status', 1)->select('id', 'fname', 'lname', 'user_img');
                },
            ])
            ->withCount([
                'chapter' => function ($query) {
                    $query->where('status', 1);
                },
                'order' => function ($query) {
                    $query->where('status', 1);
                },
            ])
            ->withSum('courseclass', 'duration')
            ->orderByDesc('id')
            ->take(8)
            ->get();

        foreach ($related as $relate) {

            $enrolled_status = Order::where('refunded', '0')->where('status', '=', 1)->where('course_id', $relate->id)->where('user_id', Auth::guard('api')->id())->first();
            $bundles = Order::where('user_id',  Auth::guard('api')->id())->where('bundle_id', '!=', NULL)->get();

            $bundle_status = array();


            foreach ($bundles as $b) {
                $bundle = BundleCourse::where('id', $b->bundle_id)->first();
                array_push($bundle_status, $bundle->course_id);
            }

            $bundle_status = array_values(array_filter($bundle_status));

            $bundle_status = array_flatten($bundle_status);

            if (isset($enrolled_status) || in_array($relate->id, $bundle_status)) {
                $relate->enrolled_status = true;
            } else {
                $relate->enrolled_status = false;
            }




            $reviews = ReviewRating::where('course_id', $relate->id)
                ->where('status', '1')
                ->get();
            $count = ReviewRating::where('course_id', $relate->id)->count();
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

            $relate->in_wishlist = Is_wishlist::in_wishlist($relate->id);
            $relate->total_rating_percent = round($course_total_rating, 2);
            $relate->total_rating = $total_rating;
        }


        return response()->json([
            'course' => $result,
            'learn'  => $total_learn,
            'price'  => $total_price,
            'value'  => $total_value,
            'total_rating_percent' => $course_total_rating,
            'total_rating' => $total_rating,
            'enrollment_status' => $enrollment_status ? 1 : 0,
            'in_wishlist'   => Is_wishlist::in_wishlist($result->id),
            'in_cart'       => $cart ? 1 : 0,
            'related' => $related,
        ]);
    }

    public function courseChpaters(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'secret' => 'required',
            'course_id' => 'required|exists:courses,id',

        ]);

        if ($validator->fails()) {
            $errors = $validator->errors();
            if ($errors->first('secret')) {
                return response()->json(['message' => $errors->first('secret'), 'status' => 'fail']);
            }
            if ($errors->first('course_id')) {
                return response()->json(['message' => $errors->first('course_id'), 'status' => 'fail']);
            }
        }

        $key = DB::table('api_keys')
            ->where('secret_key', '=', $request->secret)
            ->first();

        if (!$key) {
            return response()->json(['Invalid Secret Key !']);
        }

        App::setlocale($request->lang);

        $chapters = CourseChapter::where('status', 1)
            ->where('course_id', $request->course_id)
            ->with([
                'courseclass' => function ($query) {
                    $query->where('status', 1);
                },
            ])
            ->withCount([
                'courseclass' => function ($query) {
                    $query->where('status', 1);
                },
            ])
            ->withSum('courseclass', 'duration')
            ->get();

        return response()->json(['chapters' => $chapters], 200);
    }

    public function courseProgress(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'secret' => 'required',
            'course_id' => 'required|exists:courses,id',
        ]);

        if ($validator->fails()) {
            $errors = $validator->errors();
            if ($errors->first('secret')) {
                return response()->json(['message' => $errors->first('secret'), 'status' => 'fail']);
            }
            if ($errors->first('course_id')) {
                return response()->json(['message' => $errors->first('course_id'), 'status' => 'fail']);
            }
        }

        $key = DB::table('api_keys')
            ->where('secret_key', '=', $request->secret)
            ->first();

        if (!$key) {
            return response()->json(['Invalid Secret Key !']);
        }

        App::setlocale($request->lang);


        $auth = Auth::guard('api')->user();

        $order = Order::where('user_id', '=', $auth->id)->where('course_id', '=', $request->course_id)->where('status', '=', 1)->first();
        if (!isset($order)) {
            return response()->json(['message' => 'Buy the course first'], 403);
        }

        $progress = CourseProgress::where('course_id', $request->course_id)
            ->where('user_id', $auth->id)
            ->first();

        return response()->json(['progress' => $progress], 200);
    }

    public function courseprogressupdate(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'secret' => 'required',
            'checked' => 'required',
            'course_id' => 'required|exists:courses,id',
        ]);

        if ($validator->fails()) {
            $errors = $validator->errors();
            if ($errors->first('secret')) {
                return response()->json(['message' => $errors->first('secret'), 'status' => 'fail']);
            }
            if ($errors->first('course_id')) {
                return response()->json(['message' => $errors->first('course_id'), 'status' => 'fail']);
            }
        }

        $key = DB::table('api_keys')
            ->where('secret_key', '=', $request->secret)
            ->first();

        if (!$key) {
            return response()->json(['Invalid Secret Key !']);
        }
        App::setlocale($request->lang);

        $auth = Auth::guard('api')->user();

        $order = Order::where('user_id', '=', $auth->id)->where('course_id', '=', $request->course_id)->where('status', '=', 1)->first();
        if (!isset($order)) {
            return response()->json(['message' => 'Buy the course first'], 403);
        }

        $course_return = $request->checked;
        $course = Course::where('id', $request->course_id)->first();

        $progress = CourseProgress::where('course_id', $course->id)
            ->where('user_id', $auth->id)
            ->first();

        if (isset($progress)) {
            $chapter = CourseChapter::where('status', 1)
                ->where('course_id', $course->id)
                ->get();

            $chapter_id = [];

            foreach ($chapter as $c) {
                array_push($chapter_id, "$c->id");
            }

            $updated_progress = CourseProgress::where('course_id', $course->id)
                ->where('user_id', '=', $auth->id)
                ->update([
                    'mark_chapter_id' => $course_return,
                    'all_chapter_id' => $chapter_id,
                    'updated_at' => \Carbon\Carbon::now()->toDateTimeString(),
                ]);

            return response()->json(['created_progress' => $updated_progress], 200);
        } else {
            $chapter = CourseChapter::where('status', 1)
                ->where('course_id', $course->id)
                ->get();

            $chapter_id = [];

            foreach ($chapter as $c) {
                array_push($chapter_id, "$c->id");
            }

            $created_progress = CourseProgress::create([
                'course_id' => $course->id,
                'user_id' => $auth->id,
                'mark_chapter_id' => json_decode($course_return, true),
                'all_chapter_id' => $chapter_id,
                'created_at' => \Carbon\Carbon::now()->toDateTimeString(),
                'updated_at' => \Carbon\Carbon::now()->toDateTimeString(),
            ]);

            return response()->json(['created_progress' => $created_progress], 200);
        }
    }

    public function courseGoogleMeetings(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'secret' => 'required',
            'course_id' => 'required|exists:courses,id',
        ]);

        if ($validator->fails()) {
            $errors = $validator->errors();
            if ($errors->first('secret')) {
                return response()->json(['message' => $errors->first('secret'), 'status' => 'fail']);
            }
            if ($errors->first('course_id')) {
                return response()->json(['message' => $errors->first('course_id'), 'status' => 'fail']);
            }
        }

        $key = DB::table('api_keys')->where('secret_key', '=', $request->secret)->first();

        if (!$key) {
            return response()->json(['Invalid Secret Key !']);
        }
        App::setlocale($request->lang);

        $auth = Auth::guard('api')->user();

        $order = Order::where('user_id', '=', $auth->id)->where('course_id', '=', $request->course_id)->where('status', '=', 1)->first();
        if (!isset($order)) {
            return response()->json(['message' => 'Buy the course first'], 403);
        }

        $google_meet = Googlemeet::where('course_id', '=', $request->course_id)->get();


        return response()->json(array('google_meet' => $google_meet), 200);
    }

    public function courseAnnouncements(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'secret' => 'required',
            'course_id' => 'required|exists:courses,id',
        ]);

        if ($validator->fails()) {
            $errors = $validator->errors();
            if ($errors->first('secret')) {
                return response()->json(['message' => $errors->first('secret'), 'status' => 'fail']);
            }
            if ($errors->first('course_id')) {
                return response()->json(['message' => $errors->first('course_id'), 'status' => 'fail']);
            }
        }

        $key = DB::table('api_keys')
            ->where('secret_key', '=', $request->secret)
            ->first();

        if (!$key) {
            return response()->json(['Invalid Secret Key !']);
        }

        App::setlocale($request->lang);

        $announcements = Announcement::where('status', 1)
            ->where('course_id', $request->course_id)
            ->with('user')
            ->get();

        return response()->json(['announcements' => $announcements], 200);
    }

    public function coursePrevPapers(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'secret' => 'required',
            'course_id' => 'required|exists:courses,id',

        ]);

        if ($validator->fails()) {
            $errors = $validator->errors();
            if ($errors->first('secret')) {
                return response()->json(['message' => $errors->first('secret'), 'status' => 'fail']);
            }
            if ($errors->first('course_id')) {
                return response()->json(['message' => $errors->first('course_id'), 'status' => 'fail']);
            }
        }

        $key = DB::table('api_keys')
            ->where('secret_key', '=', $request->secret)
            ->first();

        if (!$key) {
            return response()->json(['Invalid Secret Key !']);
        }

        App::setlocale($request->lang);

        $PreviousPapers = PreviousPaper::where('status', 1)
            ->where('course_id', $request->course_id)
            ->get();

        return response()->json(['PreviousPapers' => $PreviousPapers], 200);
    }

    public function submetAssignment(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'secret'     => 'required',
            'course_id'  => 'required',
            'chapter_id' => 'required',
            'title'      => 'required',
            'file'       => 'required',
        ]);

        if ($validator->fails()) {
            $errors = $validator->errors();
            if ($errors->first('secret')) {
                return response()->json(['message' => $errors->first('secret'), 'status' => 'fail']);
            }
            if ($errors->first('course_id')) {
                return response()->json(['message' => $errors->first('course_id'), 'status' => 'fail']);
            }
            if ($errors->first('chapter_id')) {
                return response()->json(['message' => $errors->first('chapter_id'), 'status' => 'fail']);
            }
            if ($errors->first('title')) {
                return response()->json(['message' => $errors->first('title'), 'status' => 'fail']);
            }
            if ($errors->first('file')) {
                return response()->json(['message' => $errors->first('file'), 'status' => 'fail']);
            }
        }

        $key = DB::table('api_keys')
            ->where('secret_key', '=', $request->secret)
            ->first();
        if (!$key) {
            return response()->json(['Invalid Secret Key !']);
        }
        App::setlocale($request->lang);

        $auth = Auth::guard('api')->user();
        $course = Course::where('id', $request->course_id)->first();
        if ($file = $request->file('file')) {
            $name = time() . '_' . $file->getClientOriginalName();
            $name = str_replace(" ", "_", $name);
            $file->move('files/assignment', $name);
            $input['assignment'] = $name;
        }
        $assignment = Assignment::create([
            'user_id' => $auth->id,
            'instructor_id' => $course->user_id,
            'course_id' => $course->id,
            'chapter_id' => $request->chapter_id,
            'title' => $request->title,
            'assignment' => $name,
            'type' => 0,
        ]);

        if (isset($assignment) && isset($course->user_id)) {
            $body = 'A new assignment has been added to course: ' . $course->title;
            $notification = NewNotification::create(['body' => $body]);
            $notification->users()->attach(['user_id' => $course->user_id]);
            $user = User::where('id', $course->user_id)->first();
            if (isset($user->device_token)) {
                $this->send_notification($user->device_token, 'New Assignment', $body);
            }
        }

        return response()->json(['message' => 'Assignment submitted successfully', 'status' => 'success'], 200);
    }

    public function myAssignments(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'secret' => 'required',
            'course_id' => 'required|exists:courses,id',
        ]);

        if ($validator->fails()) {
            $errors = $validator->errors();
            if ($errors->first('secret')) {
                return response()->json(['message' => $errors->first('secret'), 'status' => 'fail']);
            }
            if ($errors->first('course_id')) {
                return response()->json(['message' => $errors->first('course_id'), 'status' => 'fail']);
            }
        }

        $key = DB::table('api_keys')
            ->where('secret_key', '=', $request->secret)
            ->first();

        if (!$key) {
            return response()->json(['Invalid Secret Key !']);
        }
        App::setlocale($request->lang);

        $auth = Auth::guard('api')->user();

        $assignments = Assignment::where('user_id', $auth->id)
            ->where('course_id', $request->course_id)
            ->get();

        return response()->json(['assignments' => $assignments], 200);
    }

    public function deleteAssignment(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'secret' => 'required',
            'assignment_id' => 'required',
        ]);

        if ($validator->fails()) {
            $errors = $validator->errors();

            if ($errors->first('secret')) {
                return response()->json(['message' => $errors->first('secret'), 'status' => 'fail']);
            }

            if ($errors->first('assignment_id')) {
                return response()->json(['message' => $errors->first('assignment_id'), 'status' => 'fail']);
            }
        }

        $key = DB::table('api_keys')
            ->where('secret_key', '=', $request->secret)
            ->first();

        if (!$key) {
            return response()->json(['Invalid Secret Key !']);
        }

        App::setlocale($request->lang);

        $user = Auth::guard('api')->user();

        Assignment::where('id', $request->assignment_id)
            ->where('user_id', $user->id)
            ->delete();

        return response()->json(['message' => 'Assignment deleted successfully', 'status' => 'success'], 200);
    }

    public function showWishlist(Request $request)
    {
        App::setlocale($request->lang);

        $user = Auth::guard('api')->user();
        $wishlist = Wishlist::where('user_id', $user->id)->orderBy('id', 'desc')->get();

        $myWishlistCourses_id = [];
        foreach ($wishlist as $wish) {
            array_push($myWishlistCourses_id, $wish->course_id);
        }

        $course = Course::select([
            'id', 'user_id', 'category_id', 'subcategory_id', 'childcategory_id', 'language_id', 'title',
            'price', 'discount_price', 'featured', 'slug', 'status', 'preview_image','thumble_preview_image', 'type', 'level_tags'
        ])
            ->where('status', 1)
            ->whereIn('id', $myWishlistCourses_id)
            ->orderByRaw("FIELD(id, " . implode(',', $myWishlistCourses_id) . ")")
            ->with([
                'language' => function ($query) {
                    $query->where('status', 1)->select('id', 'name');
                },
                'user' => function ($query) {
                    $query->where('status', 1)->select('id', 'fname', 'lname', 'user_img');
                },
            ])
            ->withCount([
                'chapter' => function ($query) {
                    $query->where('status', 1);
                },
                'order' => function ($query) {
                    $query->where('status', 1);
                },
            ])
            ->withSum('courseclass', 'duration')
            ->get();



        foreach ($course as $result) {

            $enrolled_status = Order::where('refunded', '0')->where('status', '=', 1)->where('course_id', $result->id)->where('user_id', Auth::guard('api')->id())->first();
            $bundles = Order::where('user_id',  Auth::guard('api')->id())->where('bundle_id', '!=', NULL)->get();

            $bundle_status = array();


            foreach ($bundles as $b) {
                $bundle = BundleCourse::where('id', $b->bundle_id)->first();
                array_push($bundle_status, $bundle->course_id);
            }

            $bundle_status = array_values(array_filter($bundle_status));

            $bundle_status = array_flatten($bundle_status);

            if (isset($enrolled_status) || in_array($result->id, $bundle_status)) {
                $result->enrolled_status = true;
            } else {
                $result->enrolled_status = false;
            }

            $bundle_count = Order::where('bundle_course_id', 'like',  '%"' . $result->id . '"%')->where('status', '=', 1)->count();
            $result->order_count += $bundle_count;

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

        return response()->json(['wishcourses' => $course], 200);
    }

    public function courseReviews(Request $request)
    {
        App::setlocale($request->lang);

        $validator = Validator::make($request->all(), [
            'secret' => 'required',
            'course_id' => 'required|exists:courses,id',
        ]);

        if ($validator->fails()) {
            $errors = $validator->errors();
            if ($errors->first('secret')) {
                return response()->json(['message' => $errors->first('secret'), 'status' => 'fail']);
            }
            if ($errors->first('course_id')) {
                return response()->json(['message' => $errors->first('course_id'), 'status' => 'fail']);
            }
        }

        $key = DB::table('api_keys')
            ->where('secret_key', '=', $request->secret)
            ->first();

        if (!$key) {
            return response()->json(['Invalid Secret Key !']);
        }

        $reviews = ReviewRating::where('course_id', $request->course_id)
            ->with([
                'user' => function ($query) {
                    $query->where('status', 1)->select('id', 'fname', 'lname', 'user_img', 'role', 'email');
                },
            ])
            ->get();

        foreach ($reviews as $review) {
            $review->total_rating =  ($review->price + $review->value + $review->learn) / 3;
            $review->review_like = ReviewHelpful::where('review_id', $review->id)
                ->where('course_id', $request->course_id)
                ->where('review_like', 1)
                ->count();

            $review->review_dislike = ReviewHelpful::where('review_id', $review->id)
                ->where('course_id', $request->course_id)
                ->where('review_dislike', 1)
                ->count();
        }

        if ($reviews) {
            return response()->json(['reviews' => $reviews], 200);
        } else {
            return response()->json(['error'], 401);
        }
    }

    public function submetReview(Request $request)
    {
        App::setlocale($request->lang);

        $validator = Validator::make($request->all(), [
            'secret'    => 'required',
            'course_id' => 'required|exists:courses,id',
            'learn'     => 'required|integer|min:1|max:5|between:1,5',
            'price'     => 'required|integer|min:1|max:5|between:1,5',
            'value'     => 'required|integer|min:1|max:5|between:1,5',
            'review'    => 'required',
        ]);

        if ($validator->fails()) {
            $errors = $validator->errors();
            if ($errors->first('secret')) {
                return response()->json(['message' => $errors->first('secret'), 'status' => 'fail']);
            }
            if ($errors->first('course_id')) {
                return response()->json(['message' => $errors->first('course_id'), 'status' => 'fail']);
            }
            if ($errors->first('learn')) {
                return response()->json(['message' => $errors->first('learn'), 'status' => 'fail']);
            }
            if ($errors->first('price')) {
                return response()->json(['message' => $errors->first('price'), 'status' => 'fail']);
            }
            if ($errors->first('value')) {
                return response()->json(['message' => $errors->first('value'), 'status' => 'fail']);
            }
            if ($errors->first('review')) {
                return response()->json(['message' => $errors->first('review'), 'status' => 'fail']);
            }
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
                    'user_id'   => $auth->id,
                    'course_id' => $input['course_id'],
                    'learn'     => $input['learn'],
                    'price'     => $input['price'],
                    'value'     => $input['value'],
                    'review'    => $input['review'],
                    'approved'  => '1',
                    'featured'  => '0',
                    'status'    => '1',
                ]);

                return response()->json(['review' => $review], 200);
            }
        } else {
            return response()->json('Please Purchase course !', 401);
        }
    }

    public function quizSubmit(Request $request)
    {
        App::setlocale($request->lang);

        $validator = Validator::make($request->all(), [
            'secret' => 'required',
            'course_id' => 'required',
            'question_id' => 'required',
            'topic_id' => 'required',
        ]);
        if ($validator->fails()) {
            $errors = $validator->errors();
            if ($errors->first('secret')) {
                return response()->json(['message' => $errors->first('secret'), 'status' => 'fail'], 400);
            }
            if ($errors->first('course_id')) {
                return response()->json(['message' => $errors->first('course_id'), 'status' => 'fail'], 400);
            }
            if ($errors->first('question_id')) {
                return response()->json(['message' => $errors->first('question_id'), 'status' => 'fail'], 400);
            }
            if ($errors->first('topic_id')) {
                return response()->json(['message' => $errors->first('topic_id'), 'status' => 'fail'], 400);
            }
        }

        $key = DB::table('api_keys')->where('secret_key', '=', $request->secret)->first();
        if (!$key) {
            return response()->json(['Invalid Secret Key !']);
        }

        $auth = Auth::guard('api')->user();
        $course = Course::where('id', $request->course_id)->first();
        $topics = QuizTopic::where('id', $request->topic_id)->first();
        $unique_question = array_unique($request->question_id);
        $quiz_already = QuizAnswer::where('user_id', $auth->id)->where('topic_id', $topics->id)->first();
        if ($quiz_already != null && $topics->quiz_again == 1) {
            QuizAnswer::where('user_id', $auth->id)->where('topic_id', $topics->id)->delete();
        } elseif ($quiz_already != null && $topics->quiz_again == 0) {
            return response()->json(array('message' => 'you did the quiz befor', 'status' => 'error'), 400);
        }
        if ($topics->type == null) {
            for ($i = 0; $i < count($request->answer); $i++) {
                $already_answer = QuizAnswer::where('question_id', $unique_question[$i])->where('topic_id', $topics->id)->where('user_id', Auth::guard('api')->user()->id)->first();
                if ($already_answer == null) {
                    $question = Quiz::where('id', $unique_question[$i])->first();

                    $answers[] = [
                        'user_id' => Auth::guard('api')->user()->id,
                        'user_answer' => $request->answer[$i],
                        'question_id' => $unique_question[$i],
                        'course_id' => $topics->course_id,
                        'topic_id' => $topics->id,
                        'answer' => $question->answer,
                        // 'answer' => $request->canswer[$i],
                        'created_at' => \Carbon\Carbon::now()->toDateTimeString(),
                    ];
                }
            }
            QuizAnswer::insert($answers);
            return response()->json(array('message' => 'Quiz Submitted', 'status' => 'success'), 200);
        } elseif ($topics->type == 1) {
            for ($i = 0; $i < count($request->txt_answer); $i++) {

                $already_answer = QuizAnswer::where('question_id', $unique_question[$i])->where('topic_id', $topics->id)->where('user_id', Auth::guard('api')->user()->id)->first();
                if (!isset($already_answer)) {
                    $answers[] = [
                        'user_id' => Auth::guard('api')->user()->id,
                        'question_id' => $unique_question[$i],
                        'course_id' => $topics->course_id,
                        'topic_id' => $topics->id,
                        'txt_answer' => $request->txt_answer[$i],
                        'type' => '1',
                        'txt_approved' => '0',
                        'created_at' => \Carbon\Carbon::now()->toDateTimeString(),
                    ];
                }
            }
            QuizAnswer::insert($answers);
            return response()->json(array('message' => 'Quiz Submitted', 'status' => 'success'), 200);
        }
    }

    public function quizReports(Request $request, $id)
    {
        App::setlocale($request->lang);

        $auth = Auth::user();
        $questions = Quiz::where('topic_id', $id)->get();
        $count_questions = $questions->count();
        $topics = QuizTopic::where('id', $id)->first();
        $ans = QuizAnswer::where('user_id', $auth->id)
            ->where('topic_id', $id)
            ->get();

        $mark = 0;

        if ($topics->type == null) {
            foreach ($ans as $answer) {
                if ($answer->answer == $answer->user_answer) {
                    $mark++;
                }
            }
        } else {
            foreach ($ans as $answer) {
                if ($answer->txt_approved == 1) {
                    $mark++;
                }
            }
        }

        return response()->json([
            'question_count' => $count_questions,
            'correct_answer' => $mark,
            'per_question_mark' => $topics->per_q_mark,
            'total_marks' => $mark * $topics->per_q_mark,
        ], 200);
    }

    public function courseQuizzes(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'secret' => 'required',
            'course_id' => 'required|exists:courses,id',
        ]);

        if ($validator->fails()) {
            $errors = $validator->errors();
            if ($errors->first('secret')) {
                return response()->json(['message' => $errors->first('secret'), 'status' => 'fail']);
            }
            if ($errors->first('course_id')) {
                return response()->json(['message' => $errors->first('course_id'), 'status' => 'fail']);
            }
        }

        $key = DB::table('api_keys')
            ->where('secret_key', '=', $request->secret)
            ->first();

        if (!$key) {
            return response()->json(['Invalid Secret Key !']);
        }

        App::setlocale($request->lang);

        $quiz = QuizTopic::where('course_id', $request->course_id)->where('status', 1)
            ->withCount([
                'quizquestion' => function ($query) {
                    $query->where('status', 1);
                },
            ])->get();

        foreach ($quiz as $q) {
            $answer_check = QuizAnswer::where('topic_id', $q->id)->where('user_id', Auth::user()->id)->first();
            if (isset($answer_check)) {
                $q->quiz_befor = 1;
            } else {
                $q->quiz_befor = 0;
            }
        }

        return response()->json(['quiz' => $quiz], 200);
    }

    public function getQuiz(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'secret' => 'required',
            'quiz_id' => 'required|exists:quiz_topics,id',
        ]);

        if ($validator->fails()) {
            $errors = $validator->errors();
            if ($errors->first('secret')) {
                return response()->json(['message' => $errors->first('secret'), 'status' => 'fail']);
            }
            if ($errors->first('quiz_id')) {
                return response()->json(['message' => $errors->first('quiz_id'), 'status' => 'fail']);
            }
        }

        $key = DB::table('api_keys')
            ->where('secret_key', '=', $request->secret)
            ->first();

        if (!$key) {
            return response()->json(['Invalid Secret Key !']);
        }

        App::setlocale($request->lang);

        $quiz = QuizTopic::where('id', $request->quiz_id)->where('status', 1)
            ->with(['quizquestion'])
            ->withCount(['quizquestion'])
            ->get();


        return response()->json(['quiz' => $quiz], 200);
    }

    public function courseQuestions(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'secret' => 'required',
            'course_id' => 'required|exists:courses,id',
        ]);

        if ($validator->fails()) {
            $errors = $validator->errors();
            if ($errors->first('secret')) {
                return response()->json(['message' => $errors->first('secret'), 'status' => 'fail']);
            }
            if ($errors->first('course_id')) {
                return response()->json(['message' => $errors->first('course_id'), 'status' => 'fail']);
            }
        }

        $key = DB::table('api_keys')
            ->where('secret_key', '=', $request->secret)
            ->first();

        if (!$key) {
            return response()->json(['Invalid Secret Key !']);
        }

        App::setlocale($request->lang);

        $questions = Question::where('course_id', $request->course_id)->where('status', 1)
            ->with([
                'answers' => function ($query) {
                    $query->where('status', 1)->with('user:id,fname,lname,user_img,role');
                },
                'user:id,fname,lname,user_img,role'
            ])
            ->withCount([
                'answers' => function ($query) {
                    $query->where('status', 1);
                },
            ])
            ->get();

        $questions->each(function ($question) {
            $question->mine = ($question->user_id == Auth::id()) ? 1 : 0;
            $question->answers->each(function ($answer) {
                $answer->mine = ($answer->ans_user_id == Auth::id()) ? 1 : 0;
            });
        });


        return response()->json(['questions' => $questions], 200);
    }

    public function userQuestions(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'secret' => 'required',
            'course_id' => 'required|exists:courses,id',
        ]);

        if ($validator->fails()) {
            $errors = $validator->errors();
            if ($errors->first('secret')) {
                return response()->json(['message' => $errors->first('secret'), 'status' => 'fail']);
            }
            if ($errors->first('course_id')) {
                return response()->json(['message' => $errors->first('course_id'), 'status' => 'fail']);
            }
        }

        $key = DB::table('api_keys')
            ->where('secret_key', '=', $request->secret)
            ->first();

        if (!$key) {
            return response()->json(['Invalid Secret Key !']);
        }

        App::setlocale($request->lang);

        $questions = Question::where('course_id', $request->course_id)->where('status', 1)
            ->where('user_id', Auth::id())
            ->with([
                'answers' => function ($query) {
                    $query->where('status', 1);
                },
            ])
            ->withCount([
                'answers' => function ($query) {
                    $query->where('status', 1);
                },
            ])
            ->get();
        return response()->json(['questions' => $questions], 200);
    }

    public function submetQuestion(Request $request)
    {
        App::setlocale($request->lang);

        $validator = Validator::make($request->all(), [
            'secret' => 'required',
            'course_id' => 'required',
            'question' => 'required',
        ]);

        if ($validator->fails()) {
            $errors = $validator->errors();
            if ($errors->first('secret')) {
                return response()->json(['message' => $errors->first('secret'), 'status' => 'fail']);
            }
            if ($errors->first('course_id')) {
                return response()->json(['message' => $errors->first('course_id'), 'status' => 'fail']);
            }
            if ($errors->first('question')) {
                return response()->json(['message' => $errors->first('question'), 'status' => 'fail']);
            }
        }

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

        $question = Question::create([
            'user_id' => $auth->id,
            'instructor_id' => $course->user_id,
            'course_id' => $course->id,
            'status' => 1,
            'question' => $request->question,
        ]);

        if (isset($question) && isset($course->user_id)) {
            if ($course->user_id != $auth->id) {
                $user = User::where('id', $course->user_id)->first();
                $body = 'A new question has been added to course: ' . $course->title;
                $notification = NewNotification::create(['body' => $body]);
                $notification->users()->attach(['user_id' => $course->user_id]);
                if (isset($user->device_token)) {
                    $this->send_notification($user->device_token, 'New Question', $body);
                }
            }
        }

        return response()->json(['question' => $question], 200);
    }

    public function answer(Request $request)
    {
        App::setlocale($request->lang);

        $validator = Validator::make($request->all(), [
            'course_id' => 'required',
            'question_id' => 'required',
            'answer' => 'required',
        ]);
        if ($validator->fails()) {
            $errors = $validator->errors();
            if ($errors->first('course_id')) {
                return response()->json(['message' => $errors->first('course_id'), 'status' => 'fail']);
            }
            if ($errors->first('question_id')) {
                return response()->json(['message' => $errors->first('question_id'), 'status' => 'fail']);
            }
            if ($errors->first('answer')) {
                return response()->json(['message' => $errors->first('answer'), 'status' => 'fail']);
            }
        }

        $auth = Auth::guard('api')->user();
        $course = Course::where('id', $request->course_id)->first();
        $question = Question::where('id', $request->question_id)->first();

        $answer = Answer::create([
            'ans_user_id' => $auth->id,
            'ques_user_id' => $question->user_id,
            'instructor_id' => $course->user_id,
            'course_id' => $course->id,
            'question_id' => $question->id,
            'status' => 1,
            'answer' => $request->answer,
        ]);

        if (isset($answer) && isset($course->user_id)) {
            if ($course->user_id != $auth->id) {
                $user = User::where('id', $question->user_id)->first();
                $body = 'A new answer has been added to your question on course: ' . $course->title;
                $notification = NewNotification::create(['body' => $body]);
                $notification->users()->attach(['user_id' => $user->id]);
                if (isset($user->device_token)) {
                    $this->send_notification($user->device_token, 'New Answer', $body);
                }
            }
        }

        return response()->json(['message' => 'Answer Submitted', 'status' => 'success'], 200);
    }

    public function deleteQuestion(Request $request, $id)
    {
        App::setlocale($request->lang);

        if (Question::where('id', $id)->exists()) {
            $data = Question::find($id);
            if ($data->user_id == Auth::id()) {

                $data->delete();

                return response()->json([
                    "message" => "records deleted"
                ]);
            } else {
                return response()->json([
                    "message" => "data not found"
                ], 404);
            }
        } else {
            return response()->json([
                "message" => "data not found"
            ], 404);
        }
    }

    public function deleteAnswer(Request $request, $id)
    {
        App::setlocale($request->lang);

        if (Answer::where('id', $id)->exists()) {
            $data = Answer::find($id);
            if ($data->ans_user_id == Auth::id()) {
                $data->delete();

                return response()->json([
                    "message" => "records deleted"
                ]);
            } else {
                return response()->json([
                    "message" => "data not found"
                ], 404);
            }
        } else {
            return response()->json([
                "message" => "data not found"
            ], 404);
        }
    }

    public function filteredCourses(Request $request)
    {
        App::setlocale($request->lang);

        $course = Course::query()->select([
            'id', 'user_id', 'category_id', 'subcategory_id', 'childcategory_id', 'language_id', 'title',
            'price', 'discount_price', 'featured', 'slug', 'status', 'preview_image','thumble_preview_image', 'type', 'level_tags','course_type'
        ])

            ->where('status', 1)
            ->with([
                'language' => function ($query) {
                    $query->where('status', 1)->select('id', 'name');
                },
                'user' => function ($query) {
                    $query->where('status', 1)->select('id', 'fname', 'lname', 'user_img');
                },
            ])
            ->withCount([
                'chapter' => function ($query) {
                    $query->where('status', 1);
                },
                'order' => function ($query) {
                    $query->where('status', 1);
                },
            ])
            ->withSum('courseclass', 'duration')
            ->filter()
            ->get();


        foreach ($course as $result) {

            $enrolled_status = Order::where('refunded', '0')->where('status', '=', 1)->where('course_id', $result->id)->where('user_id', Auth::guard('api')->id())->first();
            $bundles = Order::where('user_id',  Auth::guard('api')->id())->where('bundle_id', '!=', NULL)->get();

            $bundle_status = array();


            foreach ($bundles as $b) {
                $bundle = BundleCourse::where('id', $b->bundle_id)->first();
                array_push($bundle_status, $bundle->course_id);
            }

            $bundle_status = array_values(array_filter($bundle_status));

            $bundle_status = array_flatten($bundle_status);

            if (isset($enrolled_status) || in_array($result->id, $bundle_status)) {
                $result->enrolled_status = true;
            } else {
                $result->enrolled_status = false;
            }

            $bundle_count = Order::where('bundle_course_id', 'like',  '%"' . $result->id . '"%')->where('status', '=', 1)->count();
            $result->order_count += $bundle_count;


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
        
        return response()->json(['filteredcourses' => $course], 200);
    }
}
