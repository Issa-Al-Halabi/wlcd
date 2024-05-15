<?php


namespace App\Http\Controllers\Api;

use App\Announcement;
use App\Appointment;
use App\Assignment;
use App\Attandance;
use App\BBL;
use App\BundleCourse;
use App\Course;
use App\CourseChapter;
use App\CourseClass;
use App\CourseProgress;
use App\Googlemeet;
use App\Http\Controllers\Controller;
use App\Order;
use App\ReviewHelpful;
use App\ReviewRating;
use App\RelatedCourse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Helpers\Is_wishlist;
use App\JitsiMeeting;
use App\Meeting;
use App\PreviousPaper;
use App\PrivateCourse;
use App\Question;
use App\QuizTopic;
use App\Setting;
use App\WatchCourse;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;

class CourseController extends Controller
{
    //
    public function course(Request $request)
    {
        
        $course = Course::where('status', 1)
            ->with('include')
            ->with('whatlearns')
            ->with('review')
            ->get();

        $course = $course->map(function ($c) use ($course) {
            $c['in_wishlist'] = Is_wishlist::in_wishlist($c->id);
            return $c;
        });

        return response()->json(['course' => $course], 200);
    }

    public function courseLessons(Request $request)
    {
        $course = Course::where('status', 1)->where('id', $request->course_id)->first();

        $chapters = CourseChapter::where('status', 1)->where('course_id', $course->id)
            ->with([
                'courseclass' => function ($query) {
                    $query->where('status', 1);
                },
            ])
            ->get();

        return response()->json(['chapters' => $chapters], 200);
    }

    public function relatedcourse(Request $request)
    {

        $related = RelatedCourse::where('main_course_id', $request->course_id)->get();
        $related_id = [];
        foreach ($related as $related_course) {
            array_push($related_id, $related_course->course_id);
        }

        $course = Course::where('status', 1)->whereIn('id', $related_id)
            ->orderBy('id', 'DESC')
            ->with([
                'include' => function ($query) {
                    $query->where('status', 1);
                },
            ])
            ->with([
                'whatlearns' => function ($query) {
                    $query->where('status', 1);
                },
            ])
            ->with([
                'language' => function ($query) {
                    $query->where('status', 1);
                },
            ])
            ->with('user')
            ->get();


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
                        ->where('course_id', $request->course_id)
                        ->where('review_like', 1)
                        ->count();

                    $review_dislike = ReviewHelpful::where('review_id', $review->id)
                        ->where('course_id', $request->course_id)
                        ->where('review_dislike', 1)
                        ->count();

                    $reviewszz[] = [
                        'id' => $review->id,
                        'user_id' => $review->user_id,
                        'fname' => $review->user->fname,
                        'lname' => $review->user->lname,
                        'userimage' => $review->user->user_img,
                        'imagepath' => url('images/user_img/'),
                        'learn' => $review->learn,
                        'price' => $review->price,
                        'value' => $review->value,
                        'reviews' => $review->review,
                        'created_by' => $review->created_at,
                        'updated_by' => $review->updated_at,
                        'total_rating' => $ratings_var11,
                        'like_count' => $review_like,
                        'dislike_count' => $review_dislike,
                    ];
                }
            }

            $student_enrolled = Order::where('course_id', $result->course_id)->count();
            $result->student_enrolled = isset($student_enrolled) ? $student_enrolled : null;
            $result->lecture_count = isset($result->chapter) ? count($result->chapter) : 0;

            $instructors_student = Order::where('instructor_id', $result->user->id)->count();
            $result->user->instructors_student = isset($instructors_student) ? $instructors_student : null;
            $result->user->course_count = Course::where('user_id', $result->user->id)->count();
        }




        $course = $course->map(function ($c) use ($course) {
            $reviews = ReviewRating::where('course_id', $c->id)
                ->where('status', '1')
                ->get();
            $count = ReviewRating::where('course_id', $c->id)->count();
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

            $c['in_wishlist'] = Is_wishlist::in_wishlist($c->id);
            $c['total_rating_percent'] = round($course_total_rating, 2);
            $c['total_rating'] = $total_rating;
            return $c;
        });

        return response()->json(['course' => $course], 200);
    }

    public function recentcourse(Request $request)
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

        $course = Course::where('status', 1)
            ->orderBy('id', 'DESC')
            ->take(5)
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
                'user',
            ])
            ->get();


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
    public function allRecentcourse(Request $request)
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

        $course = Course::where('status', 1)
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

    public function featuredcourse(Request $request)
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

        $course = Course::where('status', 1)
            ->where('featured', 1)
            ->orderBy('id', 'DESC')
            ->take(5)
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
            ->get();


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
        return response()->json(['featured' => $course], 200);
    }

    public function allfeaturedcourse(Request $request)
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

        $course = Course::where('status', 1)
            ->where('featured', 1)
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
        return response()->json(['allfeatured' => $course], 200);
    }

    public function relatedCourses(Request $request)
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

        $data = RelatedCourse::where('main_course_id', $request->course_id)->where('status', 1)->get();

        $related_courses_id = [];
        foreach ($data as $related) {
            array_push($related_courses_id, $related->course_id);
        }



        $course = Course::where('status', 1)
            ->whereIn('id', $related_courses_id)
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
            ->get();


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

    public function instructorCourses(Request $request)
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

        $course = Course::where('status', 1)
            ->where('user_id', '=', $request->instructor_id)
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
            ->get();


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


    public function bundle(Request $request)
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
    public function courseVrFilter(Request $request)
    {
        $baseURL = env('APP_URL');

        if (isset($request->vr_hole)) {
            $courses = Course::where('vr_hole', '=', $request->vr_hole)
                ->where('status', 1)

                // ->with([
                //     'chapter' => function ($query) {
                //         $query->where('status', 1)->select('id', 'course_id', 'chapter_name');
                //     },
                // ])

                ->with([
                    'courseclass' => function ($query) {
                        $query
                            ->where('status', 1)
                            ->where('type', 'video')
                            ->select('id', 'course_id', 'title', 'url', 'video');
                    },
                ])
                ->get(['id', 'title', 'vr_code', 'vr_hole']);

            if (count($courses) == 0) {
                return response()->json(['message' => 'there is no courses with this VR hole number'], 400);
            }
        } else {

            $courses = Course::where('status', 1)
                ->where('vr_hole', '!=', null)

                ->with([
                    'courseclass' => function ($query) {
                        $query
                            ->where('status', 1)
                            ->where('type', 'video')
                            ->select('id', 'course_id', 'title', 'url', 'video');
                    },
                ])

                ->get(['id', 'title', 'vr_code', 'vr_hole']);
        }


        $vr_courses = [];


        foreach ($courses as $key => $course) {
            // dd($course);
            // $course->makeHidden('requirement')->toArray();

            // foreach ($course->related as $related) {
            //     // foreach ($related->courses as $rCourse) {

            //         if ($related->preview_image != null && $related->preview_image != '' && !starts_with($related->preview_image, 'http')) {
            //             $related->preview_image = $baseURL . 'images/course/' . $related->preview_image;
            //         }
            //         if ($related->video != null && $related->video != '' && !starts_with($related->video, 'http')) {
            //             $related->video = $baseURL . 'video/preview/' . $related->video;
            //         }
            //     // }
            // }

            // if ($course->preview_image != null && $course->preview_image != '' && !starts_with($course->preview_image, 'http')) {
            //     $course->preview_image = $baseURL . 'images/course/' . $course->preview_image;
            // }
            // if ($course->user->user_img != null && $course->user->user_img != '' && !starts_with($course->user->user_img, 'http')) {
            //     $course->user->user_img = $baseURL . 'images/user_img/' . $course->user->user_img;
            // }
            // if ($course->category->cat_image != null && $course->category->cat_image != '' && !starts_with($course->category->cat_image, 'http')) {
            //     $course->category->cat_image = $baseURL . 'images/category/' . $course->category->cat_image;
            // }

            // if ($course->video != null && $course->video != '' && !starts_with($course->video, 'http')) {
            //     $course->video = $baseURL . 'video/preview/' . $course->video;
            // }
            // foreach ($course->chapter as $chapter) {
            //     if ($chapter->file != null && $chapter->file != '' && !starts_with($chapter->file, 'http')) {
            //         $chapter->file = $baseURL . 'files/material/' . $chapter->file;
            //     }
            //     if ($chapter->user->user_img != null && $chapter->user->user_img != '' && !starts_with($chapter->user->user_img, 'http')) {
            //         $chapter->user->user_img = $baseURL . 'images/user_img/' . $chapter->user->user_img;
            //     }
            // }

            // foreach ($course->order as $key => $order) {
            //     if ($order->proof != null && $order->proof != '' && !starts_with($order->proof, 'http')) {
            //         $order->proof = $baseURL . 'images/order/' . $order->proof;
            //     }
            // }

            $vr_courses[$key]['vr_hole'] = $course->vr_hole;
            $vr_courses[$key]['vr_code'] = $course->vr_code;


            foreach ($course->courseclass as $index => $class) {

                if ($class->video != null && $class->video != '' && !starts_with($class->video, 'http')) {
                    $class->video = $baseURL . 'video/class/' . $class->video;
                }
                if ($class->url != null && $class->url != '') {
                    $class->video = $class->url;
                }
                // if ($class->audio != null && $class->audio != '' && !starts_with($class->audio, 'http')) {
                //     $class->audio = $baseURL . 'files/audio/' . $class->audio;
                // }
                // if ($class->pdf != null && $class->pdf != '' && !starts_with($class->pdf, 'http')) {
                //     $class->pdf = $baseURL . 'files/pdf/' . $class->pdf;
                // }
                // if ($class->image != null && $class->image != '' && !starts_with($class->image, 'http')) {
                //     $class->image = $baseURL . 'images/class/' . $class->image;
                // }
                // if ($class->zip != null && $class->zip != '' && !starts_with($class->zip, 'http')) {
                //     $class->zip = $baseURL . 'files/zip/' . $class->zip;
                // }
                // if ($class->file != null && $class->file != '' && !starts_with($class->file, 'http')) {
                //     $class->file = $baseURL . 'files/class/material/' . $class->file;
                // }
                // if ($class->preview_video != null && $class->preview_video != '' && !starts_with($class->preview_video, 'http')) {
                //     $class->preview_video = $baseURL . 'video/class/preview/' . $class->preview_video;
                // }
                // if ($class->user->user_img != null && $class->user->user_img != '' && !starts_with($class->user->user_img, 'http')) {
                //     $class->user->user_img = $baseURL . 'images/user_img/' . $class->user->user_img;
                // }



                $vr_courses[$key]['classes'][$index]['class_title'] = $class->title;
                $vr_courses[$key]['classes'][$index]['video'] = $class->video;
            }
        }


        // $vr_courses = response()->json(['vr_courses' => $vr_courses], 200);
        $vr_courses = str_replace(array('['), '{', htmlspecialchars(json_encode(['vr_courses' => $vr_courses]), ENT_NOQUOTES));
        $vr_courses = str_replace(array(']'), '}', $vr_courses);

        // $data['dara'] = $vr_courses;
        return $vr_courses;

        return response()->json(['data' => $data], 200);
    }
    public function paginationcourse(Request $request)
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

        $paginator = Course::where('status', 1)
            ->with('include')
            ->with('whatlearns')
            ->with('review')
            ->paginate(5);

        $paginator->getCollection()->transform(function ($c) use ($paginator) {
            $c['in_wishlist'] = Is_wishlist::in_wishlist($c->id);
            return $c;
        });

        return response()->json(['course' => $paginator], 200);
    }
    public function review(Request $request)
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

        $review = ReviewRating::where('course_id', $request->course_id)
            ->with('user')
            ->get();

        $review_count = ReviewRating::where('course_id', $request->course_id)->count();

        if ($review) {
            return response()->json(['review' => $review], 200);
        } else {
            return response()->json(['error'], 401);
        }
    }
    public function duration(Request $request)
    {
        $this->validate($request, [
            'chapter_id' => 'required',
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

        $chapter = CourseChapter::where('course_id', $request->chapter_id)->first();

        if ($chapter) {
            $duration = CourseClass::where('coursechapter_id', $chapter->id)->sum('duration');
        } else {
            return response()->json(['Invalid Chapter ID !'], 401);
        }

        if ($chapter) {
            return response()->json(['duration' => $duration], 200);
        } else {
            return response()->json(['error'], 401);
        }
    }
    public function coursedetail(Request $request)
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

        $course = Course::where('status', 1)

            ->with([
                'include' => function ($query) {
                    $query->where('status', 1);
                },
            ])

            ->with([
                'whatlearns' => function ($query) {
                    $query->where('status', 1);
                },
            ])
            ->with([
                'related' => function ($query) {
                    $query->where('status', 1);
                },
            ])

            ->with('review')

            ->with([
                'language' => function ($query) {
                    $query->where('status', 1);
                },
            ])

            ->with('user')

            ->with([
                'order' => function ($query) {
                    $query->where('status', 1);
                },
            ])
            ->with([
                'chapter' => function ($query) {
                    $query->where('status', 1);
                },
            ])

            ->with([
                'courseclass' => function ($query) {
                    $query->where('status', 1);
                },
            ])

            ->with('policy')
            ->get();

        return response()->json(['course' => $course], 200);
    }
    public function detailpage(Request $request)
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

            ->with('category')

            ->with([
                'include' => function ($query) {
                    $query->where('status', 1);
                },
            ])

            ->with([
                'whatlearns' => function ($query) {
                    $query->where('status', 1);
                },
            ])
            ->with([
                'related' => function ($query) {
                    $query->where('status', 1)->with('courses');
                },
            ])
            ->with([
                'language' => function ($query) {
                    $query->where('status', 1);
                },
            ])

            ->with('user')

            ->with([
                'order' => function ($query) {
                    $query->where('status', 1);
                },
            ])
            ->with([
                'chapter' => function ($query) {
                    $query->where('status', 1)->with('user');
                },
            ])

            ->with([
                'courseclass' => function ($query) {
                    $query->where('status', 1)->with('user');
                },
            ])

            ->with('policy')
            ->first();

        if (!$result) {
            return response()->json('404 | Course not found !');
        }

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
                    ->where('course_id', $request->course_id)
                    ->where('review_like', 1)
                    ->count();

                $review_dislike = ReviewHelpful::where('review_id', $review->id)
                    ->where('course_id', $request->course_id)
                    ->where('review_dislike', 1)
                    ->count();

                $reviewszz[] = [
                    'id' => $review->id,
                    'user_id' => $review->user_id,
                    'fname' => $review->user->fname,
                    'lname' => $review->user->lname,
                    'userimage' => $review->user->user_img,
                    'imagepath' => url('images/user_img/'),
                    'learn' => $review->learn,
                    'price' => $review->price,
                    'value' => $review->value,
                    'reviews' => $review->review,
                    'created_by' => $review->created_at,
                    'updated_by' => $review->updated_at,
                    'total_rating' => $ratings_var11,
                    'like_count' => $review_like,
                    'dislike_count' => $review_dislike,
                ];
            }
        }

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

        $student_enrolled = Order::where('course_id', $request->course_id)->count();

        return response()->json([
            'course' => $result->makeHidden(['review']),
            'review' => isset($reviewszz) ? $reviewszz : null,
            'learn' => $total_learn,
            'price' => $total_price,
            'value' => $total_value,
            'total_rating_percent' => $course_total_rating,
            'total_rating' => $total_rating,
            'student_enrolled' => isset($student_enrolled) ? $student_enrolled : null,
        ]);
    }
    public function courseprogress(Request $request)
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

        $course = Course::where('status', 1)
            ->where('id', $request->course_id)
            ->first();

        $progress = CourseProgress::where('course_id', $course->id)
            ->where('user_id', $auth->id)
            ->first();

        return response()->json(['progress' => $progress], 200);
    }

    public function courseprogressupdate(Request $request)
    {
        $this->validate($request, [
            'checked' => 'required',
            'course_id' => 'required',
        ]);

        $course_return = $request->checked;

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
    public function coursereport(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'secret' => 'required',
            'course_id' => 'required',
            'title' => 'required',
            'email' => 'required',
            'detail' => 'required',
        ]);
        if ($validator->fails()) {
            $errors = $validator->errors();
            if ($errors->first('secret')) {
                return response()->json(['message' => $errors->first('secret'), 'status' => 'fail']);
            }
            if ($errors->first('course_id')) {
                return response()->json(['message' => $errors->first('course_id'), 'status' => 'fail']);
            }
            if ($errors->first('detail')) {
                return response()->json(['message' => $errors->first('detail'), 'status' => 'fail']);
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
        $created_report = CourseReport::create([
            'course_id' => $course->id,
            'user_id' => $auth->id,
            'title' => $course->title,
            'email' => $auth->email,
            'detail' => $request->detail,
            'created_at' => \Carbon\Carbon::now()->toDateTimeString(),
        ]);
        return response()->json(['message' => 'Course reported!', 'status' => 'success'], 200);
    }

    public function coursecontent(Request $request, $id)
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

        $result = Course::where('id', '=', $id)
            ->where('status', 1)
            ->first();

        if (!$result) {
            return response()->json('404 | Course not found !');
        }

        $order = Order::where('course_id', $result->id)->get();

        $chapters = CourseChapter::where('course_id', $result->id)
            ->where('status', 1)
            ->with('courseclass')
            ->get();

        $classes = CourseClass::where('course_id', $result->id)
            ->where('status', 1)
            ->get();

        $overview[] = [
            'course_title' => $result->title,
            'short_detail' => strip_tags($result->short_detail),
            'detail' => strip_tags($result->detail),
            'instructor' => $result->user->fname,
            'instructor_email' => $result->user->email,
            'instructor_detail' => strip_tags($result->user->detail),
            'user_enrolled' => count($order),
            'classes' => count($classes),
        ];

        $quiz = [];

        if (isset($result->quiztopic)) {
            foreach ($result->quiztopic as $key => $topic) {
                $questions = [];

                if ($topic->type == null) {
                    foreach ($topic->quizquestion as $key => $data) {
                        if ($data->type == null) {
                            if ($data->answer == 'A') {
                                $correct_answer = $data->a;

                                $options = [$data->b, $data->c, $data->d];
                            } elseif ($data->answer == 'B') {
                                $correct_answer = $data->b;

                                $options = [$data->a, $data->c, $data->d];
                            } elseif ($data->answer == 'C') {
                                $correct_answer = $data->c;

                                $options = [$data->a, $data->b, $data->d];
                            } elseif ($data->answer == 'D') {
                                $correct_answer = $data->d;

                                $options = [$data->a, $data->b, $data->c];
                            }
                        }

                        $all_options = [
                            'A' => $data->a,
                            'B' => $data->b,
                            'C' => $data->c,
                            'D' => $data->d,
                        ];

                        $questions[] = [
                            'id' => $data->id,
                            'course' => $result->title,
                            'topic' => $topic->title,
                            'question' => $data->question,
                            'correct' => $correct_answer,
                            'status' => $data->status,
                            'incorrect_answers' => $options,
                            'all_answers' => $all_options,
                            'correct_answer' => $data->answer,
                        ];
                    }
                } elseif ($topic->type == 1) {
                    foreach ($topic->quizquestion as $key => $data) {
                        $questions[] = [
                            'id' => $data->id,
                            'course' => $result->title,
                            'topic' => $topic->title,
                            'question' => $data->question,
                            'status' => $data->status,
                            'correct' => null,
                            'correct' => null,
                            'status' => $data->status,
                            'incorrect_answers' => null,
                            'correct_answer' => null,
                        ];
                    }
                }

                $startDate = '0';

                if (Auth::guard('api')->check()) {
                    $order = Order::where('course_id', $id)
                        ->where('user_id', '=', Auth::guard('api')->user()->id)
                        ->first();

                    $days = $topic->due_days;
                    $orderDate = optional($order)['created_at'];

                    $bundle = Order::where('user_id', Auth::guard('api')->user()->id)
                        ->where('bundle_id', '!=', null)
                        ->get();

                    $course_id = [];

                    foreach ($bundle as $b) {
                        $bundle = BundleCourse::where('id', $b->bundle_id)->first();
                        array_push($course_id, $bundle->course_id);
                    }

                    $course_id = array_values(array_filter($course_id));
                    $course_id = array_flatten($course_id);

                    if ($orderDate != null) {
                        $startDate = date('Y-m-d', strtotime("$orderDate +$days days"));
                    } elseif (isset($course_id) && in_array($id, $course_id)) {
                        $startDate = date('Y-m-d', strtotime("$bundle->created_at +$days days"));
                    } else {
                        $startDate = '0';
                    }
                }

                $mytime = \Carbon\Carbon::now()->toDateString();

                $quiz[] = [
                    'id' => $topic->id,
                    'course_id' => $result->id,
                    'course' => $result->title,
                    'title' => $topic->title,
                    'description' => $topic->description,
                    'per_question_mark' => $topic->per_q_mark,
                    'status' => $topic->status,
                    'quiz_again' => $topic->quiz_again,
                    'due_days' => $topic->due_days,
                    'type' => $topic->type,
                    'timer' => $topic->timer,
                    'created_by' => $topic->created_at,
                    'updated_by' => $topic->updated_at,
                    'quiz_live_days' => $startDate,
                    'today_date' => $mytime,
                    'questions' => $questions,
                ];
            }
        }

        $announcement = Announcement::where('course_id', $id)
            ->where('status', 1)
            ->get();

        $announcements = [];

        foreach ($announcement as $announc) {
            $announcements[] = [
                'id' => $announc->id,
                'user' => $announc->user->fname,
                'course_id' => $announc->courses->title,
                'detail' => strip_tags($announc->announsment),
                'status' => $announc->status,
                'created_at' => $announc->created_at,
                'updated_at' => $announc->updated_at,
            ];
        }

        $assign = [];

        if (Auth::guard('api')->check()) {
            $user = Auth::guard('api')->user();

            $assignments = Assignment::where('course_id', $id)
                ->where('user_id', Auth::guard('api')->user()->id)
                ->get();

            foreach ($assignments as $assignment) {
                $assign[] = [
                    'id' => $assignment->id,
                    'user' => $assignment->user->fname,
                    'course_id' => $assignment->courses->title,
                    'instructor' => $assignment->instructor->fname,
                    'chapter_id' => $assignment->chapter['chapter_name'],
                    'title' => $assignment->title,
                    'assignment' => $assignment->assignment,
                    'assignment_path' => url('files/assignment/' . $assignment->assignment),
                    'type' => $assignment->type,
                    'detail' => strip_tags($assignment->detail),
                    'rating' => $assignment->rating,
                    'created_at' => $assignment->created_at,
                    'updated_at' => $assignment->updated_at,
                ];
            }
        }

        $appointments = Appointment::where('course_id', $id)->get();

        $appointment = [];

        foreach ($appointments as $appoint) {
            $appointment[] = [
                'id' => $appoint->id,
                'user' => $appoint->user->fname,
                'course_id' => $appoint->courses->title,
                'instructor' => $appoint->instructor->fname,
                'title' => $appoint->title,
                'detail' => strip_tags($appoint->detail),
                'accept' => $appoint->accept,
                'reply' => $appoint->reply,
                'status' => $appoint->status,
                'created_at' => $appoint->created_at,
                'updated_at' => $appoint->updated_at,
            ];
        }

        $questions = Question::where('course_id', $id)->get();

        $question = [];

        foreach ($questions as $ques) {
            $answer = [];
            foreach ($ques->answers as $key => $data) {
                $answer[] = [
                    'course' => $data->courses->title,
                    'user' => $data->user->fname,
                    'instructor' => $data->instructor->fname,
                    'image' => $ques->instructor->user_img,
                    'imagepath' => url('images/user_img/' . $ques->user->user_img),
                    'question' => $data->question->question,
                    'answer' => strip_tags($data->answer),
                    'status' => $data->status,
                ];
            }

            $question[] = [
                'id' => $ques->id,
                'user' => $ques->user->fname,
                'instructor' => $ques->instructor->fname,
                'image' => $ques->instructor->user_img,
                'imagepath' => url('images/user_img/' . $ques->user->user_img),
                'course' => $ques->courses->title,
                'title' => strip_tags($ques->question),
                'status' => $ques->status,
                'created_at' => $ques->created_at,
                'updated_at' => $ques->updated_at,
                'answer' => $answer,
            ];
        }

        $zoom_meeting = Meeting::where('course_id', '=', $id)->get();
        $bigblue_meeting = BBL::where('course_id', '=', $id)->get();
        $google_meet = Googlemeet::where('course_id', '=', $id)->get();
        $jitsi_meeting = JitsiMeeting::where('course_id', '=', $id)->get();

        $previouspapers = PreviousPaper::where('course_id', '=', $id)->get();

        $papers = [];

        foreach ($previouspapers as $data) {
            $papers[] = [
                'id' => $data->id,
                'course' => $data->courses->title,
                'title' => $data->title,
                'file' => $data->file,
                'filepath' => url('files/papers/' . $data->file),
                'detail' => strip_tags($data->detail),
                'status' => $data->status,
                'created_at' => $data->created_at,
                'updated_at' => $data->updated_at,
            ];
        }

        return response()->json(['overview' => $overview, 'quiz' => $quiz, 'announcement' => $announcements, 'assignment' => $assign, 'questions' => $question, 'appointment' => $appointment, 'chapter' => $chapters, 'zoom_meeting' => $zoom_meeting, 'bigblue_meeting' => $bigblue_meeting, 'jitsi_meeting' => $jitsi_meeting, 'google_meet' => $google_meet, 'papers' => $papers], 200);
    }
    public function watchcourse($id)
    {
        if (Auth::guard('api')->check()) {
            $order = Order::where('status', '1')
                ->where('user_id', Auth::guard('api')->User()->id)
                ->where('course_id', $id)
                ->first();

            $courses = Course::where('id', $id)->first();

            $bundle = Order::where('user_id', Auth::guard('api')->User()->id)
                ->where('bundle_id', '!=', null)
                ->get();

            $gsetting = Setting::first();

            //attandance start
            if (!empty($order)) {
                if ($gsetting->attandance_enable == 1) {
                    $date = Carbon::now();
                    //Get date
                    $date->toDateString();

                    $courseAttandance = Attandance::where('course_id', '=', $id)
                        ->where('user_id', Auth::guard('api')->User()->id)
                        ->where('date', '=', $date->toDateString())
                        ->first();

                    if (!$courseAttandance) {
                        $attanded = Attandance::create([
                            'user_id' => Auth::guard('api')->user()->id,
                            'course_id' => $id,
                            'instructor_id' => $courses->user_id,
                            'date' => $date->toDateString(),
                            'order_id' => $id,
                            'created_at' => \Carbon\Carbon::now()->toDateTimeString(),
                            'updated_at' => \Carbon\Carbon::now()->toDateTimeString(),
                        ]);
                    }
                }
            } //attandance end

            $course = Course::findOrFail($id);

            $course_id = [];

            foreach ($bundle as $b) {
                $bundle = BundleCourse::where('id', $b->bundle_id)->first();
                array_push($course_id, $bundle->course_id);
            }

            $course_id = array_values(array_filter($course_id));

            $course_id = array_flatten($course_id);

            if (Auth::guard('api')->User()->role == 'admin') {
                return view('watch', compact('courses'));
            } elseif (Auth::guard('api')->User()->id == $course->user_id) {
                return view('watch', compact('courses'));
            } else {
                if (!empty($order)) {
                    $coursewatch = WatchCourse::where('course_id', '=', $id)
                        ->where('user_id', Auth::guard('api')->User()->id)
                        ->first();

                    if ($gsetting->device_control == 1) {
                        if (!$coursewatch) {
                            $watching = WatchCourse::create([
                                'user_id' => Auth::guard('api')->user()->id,
                                'course_id' => $id,
                                'start_time' => \Carbon\Carbon::now()->toDateTimeString(),
                                'active' => '1',
                                'created_at' => \Carbon\Carbon::now()->toDateTimeString(),
                                'updated_at' => \Carbon\Carbon::now()->toDateTimeString(),
                            ]);

                            return view('watch', compact('courses'));
                        } else {
                            if ($coursewatch->active == 0) {
                                $coursewatch->active = 1;
                                $coursewatch->save();
                                return view('watch', compact('courses'));
                            } else {
                                return response()->json(['message' => 'User Already Watching Course !!', 'status' => 'fail'], 402);
                            }
                        }
                    } else {
                        return view('watch', compact('courses'));
                    }
                } elseif (isset($course_id) && in_array($id, $course_id)) {
                    return view('watch', compact('courses'));
                } else {
                    return response()->json(['message' => 'Unauthorization Action', 'status' => 'fail'], 402);
                }
            }
        }
        return response()->json(['message' => 'Please Login to Continue', 'status' => 'fail'], 401);
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


        $announcements = Announcement::where('status', 1)
            ->where('course_id', $request->course_id)
            ->get();

        return response()->json(['announcements' => $announcements], 200);
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

        $auth = Auth::guard('api')->user();

        $order = Order::where('user_id', '=', $auth->id)->where('course_id', '=', $request->course_id)->where('status', '=', 1)->first();
        if (!isset($order)) {
            return response()->json(['message' => 'Buy the course first'], 403);
        }

        $google_meet = Googlemeet::where('course_id', '=', $request->course_id)->get();


        return response()->json(array('google_meet' => $google_meet), 200);
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

        // App::setlocale($request->lang);

        $PreviousPapers = PreviousPaper::where('status', 1)
            ->where('course_id', $request->course_id)
            ->get();

        return response()->json(['PreviousPapers' => $PreviousPapers], 200);
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

        // App::setlocale($request->lang);


        $result = Course::where('id', $request->course_id)->first();

        $quiz = [];

        $quizz = QuizTopic::where('course_id', $request->course_id)->where('status', 1)
            ->with(['quizquestion'])
            ->withCount(['quizquestion'])->get();

        foreach ($quizz as $key => $topic) {
            $questions = [];

            if ($topic->type == null) {
                foreach ($topic->quizquestion as $key => $data) {
                    if ($data->type == null) {
                        if ($data->answer == 'A') {
                            $correct_answer = $data->a;

                            $options = [$data->b, $data->c, $data->d];
                        } elseif ($data->answer == 'B') {
                            $correct_answer = $data->b;

                            $options = [$data->a, $data->c, $data->d];
                        } elseif ($data->answer == 'C') {
                            $correct_answer = $data->c;

                            $options = [$data->a, $data->b, $data->d];
                        } elseif ($data->answer == 'D') {
                            $correct_answer = $data->d;

                            $options = [$data->a, $data->b, $data->c];
                        }
                    }

                    $all_options = [
                        'A' => $data->a,
                        'B' => $data->b,
                        'C' => $data->c,
                        'D' => $data->d,
                    ];

                    $questions[] = [
                        'id' => $data->id,
                        'course' => $result->title,
                        'topic' => $topic->title,
                        'question' => $data->question,
                        'correct' => $correct_answer,
                        'status' => $data->status,
                        'incorrect_answers' => $options,
                        'all_answers' => $all_options,
                        'correct_answer' => $data->answer,
                    ];
                }
            } elseif ($topic->type == 1) {
                foreach ($topic->quizquestion as $key => $data) {
                    $questions[] = [
                        'id' => $data->id,
                        'course' => $result->title,
                        'topic' => $topic->title,
                        'question' => $data->question,
                        'status' => $data->status,
                        'correct' => null,
                        'correct' => null,
                        'status' => $data->status,
                        'incorrect_answers' => null,
                        'correct_answer' => null,
                    ];
                }
            }

            $startDate = '0';

            if (Auth::guard('api')->check()) {
                $order = Order::where('course_id', $request->course_id)
                    ->where('user_id', '=', Auth::guard('api')->user()->id)
                    ->first();

                $days = $topic->due_days;
                $orderDate = optional($order)['created_at'];

                $bundle = Order::where('user_id', Auth::guard('api')->user()->id)
                    ->where('bundle_id', '!=', null)
                    ->get();

                $course_id = [];

                foreach ($bundle as $b) {
                    $bundle = BundleCourse::where('id', $b->bundle_id)->first();
                    array_push($course_id, $bundle->course_id);
                }

                $course_id = array_values(array_filter($course_id));
                $course_id = array_flatten($course_id);

                if ($orderDate != null) {
                    $startDate = date('Y-m-d', strtotime("$orderDate +$days days"));
                } elseif (isset($course_id) && in_array($request->course_id, $course_id)) {
                    $startDate = date('Y-m-d', strtotime("$bundle->created_at +$days days"));
                } else {
                    $startDate = '0';
                }
            }

            $mytime = \Carbon\Carbon::now()->toDateString();

            $quiz[] = [
                'id' => $topic->id,
                'course_id' => $result->id,
                'course' => $result->title,
                'title' => $topic->title,
                'description' => $topic->description,
                'per_question_mark' => $topic->per_q_mark,
                'status' => $topic->status,
                'quiz_again' => $topic->quiz_again,
                'due_days' => $topic->due_days,
                'type' => $topic->type,
                'timer' => $topic->timer,
                'created_by' => $topic->created_at,
                'updated_by' => $topic->updated_at,
                'quiz_live_days' => $startDate,
                'today_date' => $mytime,
                'questions' => $questions,
            ];
        }

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

        // App::setlocale($request->lang);

        $questions = Question::where('course_id', $request->course_id)->where('status', 1)
            ->with([
                'answers' => function ($query) {
                    $query->where('status', 1)->with('user:id,fname,lname,user_img');
                },
                'user:id,fname,lname,user_img',
            ])
            ->withCount([
                'answers' => function ($query) {
                    $query->where('status', 1);
                },
            ])
            ->get();
        return response()->json(['questions' => $questions], 200);
    }

    public function search(Request $request)
    {
        $validator = Validator::make($request->all(), [

            'keyword' => 'required',
        ]);

        if ($validator->fails()) {

            $errors = $validator->errors();


            if ($errors->first('keyword')) {
                return response()->json(['message' => $errors->first('keyword'), 'status' => 'fail']);
            }
        }


        $course = Course::where('status', 1)
            ->where('title', 'like', "%$request->keyword%")
            ->orderBy('id', 'DESC')
            ->with([
                'include' => function ($query) {
                    $query->where('status', 1);
                },
                'whatlearns' => function ($query) {
                    $query->where('status', 1);
                },
                'language' => function ($query) {
                    $query->where('status', 1);
                },
                'review' => function ($query) {
                    $query->with('user:id,fname,lname,user_img');
                },
                'user',
            ])
            ->get();


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
}
