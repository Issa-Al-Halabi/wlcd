<?php

namespace App\Http\Controllers\WebApi;

use App\About;
use App\Http\Controllers\Controller;
use App\BundleCourse;
use App\Course;
use App\CourseProgress;
use App\Helpers\Is_wishlist;
use App\Http\Traits\SendNotification;
use App\Order;
use App\ReviewRating;
use App\User;
use Illuminate\Support\Facades\Hash;
use App\Wishlist;
use App\Blog;
use App\Currency;
use App\NewNotification;
use App\Slider;
use App\SliderFacts;
use App\FaqStudent;
use App\Categories;
use App\SubCategory;
use App\Testimonial;
use App\CategorySlider;
use App\Country;
use App\State;
use App\City;
use App\CourseLanguage;
use App\Terms;
use App\Contact;
use App\Contactreason;
use App\Question;
use App\QuizAnswer;
use App\Followers;
use App\Flashsale;
use App\Setting;
use App\Videosetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class MainController extends Controller
{
    //------------INSTRUCTORS----------------

    public function homeInstructors(Request $request)
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

        $instructors = User::select('id', 'fname', 'lname', 'mobile', 'email', 'user_img', 'role', 'detail')
            ->where('status', 1)
            ->whereIn('role', ['instructor', 'admin'])
            ->withCount([
                'courses' => function ($query) {
                    $query->where('status', 1);
                },
                'courseOrders' => function ($query) {
                    $query->where('status', 1);
                },
                'followers',
            ])
            ->orderBy('courses_count', 'desc')
            ->take(8)
            ->get();

        foreach ($instructors as $instructor) {
            Followers::where('user_id', $instructor->id)->where('follower_id', Auth::guard('api')->id())->first() ? $instructor->following_status = 1 : $instructor->following_status = 0;
        }



        return response()->json(['instructors' => $instructors], 200);
    }

    public function allInstructors(Request $request)
    {
        App::setlocale($request->lang);

        $instructors = User::select('id', 'fname', 'lname', 'mobile', 'email', 'user_img', 'role', 'detail')
            ->where('status', 1)
            ->whereIn('role', ['instructor', 'admin'])
            ->withCount([
                'courses' => function ($query) {
                    $query->where('status', 1);
                },
                'courseOrders' => function ($query) {
                    $query->where('status', 1);
                },
                'followers',
            ])
            ->orderBy('courses_count', 'desc')
            ->get();

        foreach ($instructors as $instructor) {
            Followers::where('user_id', $instructor->id)->where('follower_id', Auth::guard('api')->id())->first() ? $instructor->following_status = 1 : $instructor->following_status = 0;
        }

        return response()->json(['instructors' => $instructors], 200);
    }

    public function instructor(Request $request)
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

        $instructor = User::select(
            'id',
            'fname',
            'lname',
            'dob',
            'mobile',
            'email',
            'address',
            'user_img',
            'role',
            'detail',
            'address',
            'city_id',
            'state_id',
            'country_id',
            'gender',
            'created_at',
            'practical_experience',
            'basic_skills',
            'professional_summary',
            'scientific_background',
            'courses'
        )
            ->where('status', 1)
            ->where('id', $request->id)
            ->withCount([
                'courses' => function ($query) {
                    $query->where('status', 1);
                },
                'courseOrders' => function ($query) {
                    $query->where('status', 1);
                },
                'followers',
            ])
            ->first();

        Followers::where('user_id', $instructor->id)->where('follower_id', Auth::guard('api')->id())->first() ? $instructor->following_status = 1 : $instructor->following_status = 0;


        $course = Course::select([
            'id', 'user_id', 'category_id', 'subcategory_id', 'childcategory_id', 'language_id', 'title',
            'price', 'discount_price', 'featured', 'slug', 'status', 'preview_image', 'type', 'level_tags'
        ])
            ->where('status', 1)
            ->where('user_id', $instructor->id)
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


        return response()->json(['instructor' => $instructor, 'courses' => $course], 200);
    }

    public function courseInstructor(Request $request)
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

        $course = Course::where('id', $request->course_id)->first(['id', 'user_id']);

        $instructor = User::select(
            'id',
            'fname',
            'lname',
            'dob',
            'mobile',
            'email',
            'address',
            'user_img',
            'role',
            'detail',
            'address',
            'city_id',
            'state_id',
            'country_id',
            'gender',
            'created_at',
            'practical_experience',
            'basic_skills',
            'professional_summary',
            'scientific_background',
            'courses'
        )
            ->where('status', 1)
            ->where('id', $course->user_id)
            ->withCount([
                'courses' => function ($query) {
                    $query->where('status', 1);
                },
                'courseOrders' => function ($query) {
                    $query->where('status', 1);
                },
                'followers',
            ])
            ->first();

        Followers::where('user_id', $instructor->id)->where('follower_id', Auth::guard('api')->id())->first() ? $instructor->following_status = 1 : $instructor->following_status = 0;



        return response()->json(['instructor' => $instructor], 200);
    }

    //------------SLIDER----------------

    function homeSliders(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'secret' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['Secret Key is required'], 402);
        }

        $key = DB::table('api_keys')
            ->where('secret_key', '=', $request->secret)
            ->first();

        if (!$key) {
            return response()->json(['Invalid Secret Key !'], 400);
        }

        App::setlocale($request->lang);

        $slider = Slider::where('status', '1')
            ->orderBy('position', 'ASC')
            ->get();
        $sliderfacts = SliderFacts::get();

        return response()->json(['slider' => $slider, 'sliderfacts' => $sliderfacts], 200);
    }

    //-----------CATEGORY----------------

    function homeCategories(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'secret' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['Secret Key is required'], 402);
        }

        $key = DB::table('api_keys')
            ->where('secret_key', '=', $request->secret)
            ->first();

        if (!$key) {
            return response()->json(['Invalid Secret Key !'], 400);
        }
        App::setlocale($request->lang);

        $category = Categories::where('status', 1)
            ->withCount(['courses' => function ($query) {
                $query->where('status', 1);
            },])
            ->orderBy('position', 'asc')
            ->get();

        $subcategory = SubCategory::where('status', 1)->get();

        $featured_cate = Categories::where('status', 1)
            ->withCount(['courses' => function ($query) {
                $query->where('status', 1);
            },])
            ->orderBy('position', 'asc')
            ->where('featured', 1)
            ->get();

        return response()->json(['category' => $category, 'subcategory' => $subcategory,  'featured_cate' => $featured_cate,], 200);
    }

    //----------ALL CATEGORY--------------

    function homeAllCategories(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'secret' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['Secret Key is required'], 402);
        }

        $key = DB::table('api_keys')
            ->where('secret_key', '=', $request->secret)
            ->first();

        if (!$key) {
            return response()->json(['Invalid Secret Key !'], 400);
        }

        App::setlocale($request->lang);

        $category = Categories::where('status', 1)
            ->withCount(['courses' => function ($query) {
                $query->where('status', 1);
            },])
            ->orderBy('position', 'asc')
            ->get();

        $all_categories = [];

        foreach ($category as $cate) {
            $cate_subcategory = SubCategory::where('status', 1)
                ->where('category_id', $cate->id)
                ->get();

            $all_categories[] = [
                'id' => $cate->id,
                'title' => array_map(function ($lang) {
                    return trim(preg_replace("/\r\n|\r|\n/", '', strip_tags(html_entity_decode($lang))));
                }, $cate->getTranslations('title')),
                'icon'          => $cate->icon,
                'slug'          => $cate->slug,
                'status'        => $cate->status,
                'featured'      => $cate->featured,
                'image'         => $cate->cat_image,
                'imagepath'     => url('images/category/' . $cate->cat_image),
                'position'      => $cate->position,
                'created_at'    => $cate->created_at,
                'updated_at'    => $cate->updated_at,
                'courses_count' => $cate->courses_count,
                'subcategory'   => $cate_subcategory,
            ];
        }

        $category_slider = CategorySlider::first();

        $category_slider1 = [];

        if (isset($category_slider)) {
            foreach ($category_slider->category_id as $cats) {
                $catee = Categories::withCount(['courses' => function ($query) {
                    $query->where('status', 1);
                },])->find($cats);

                if (isset($catee)) {
                    $category_slider1[] = [
                        'id' => $catee->id,
                        'title' => array_map(function ($lang) {
                            return trim(preg_replace("/\r\n|\r|\n/", '', strip_tags(html_entity_decode($lang))));
                        }, $catee->getTranslations('title')),
                        'courses_count' => $catee->courses_count,

                    ];
                }
            }

            //Display only first category course

            // find first category from the @array $category_slider

            $firstcat = Categories::whereHas('courses', function ($q) {
                return $q->where('status', '=', '1');
            })
                ->whereHas('courses.user')
                ->with(['courses', 'courses.user'])
                ->find($category_slider->category_id[0]);

            if (isset($firstcat)) {
                foreach ($firstcat->courses as $course) {
                    $category_slider_courses[] = [
                        'id' => $course->id,

                        'title' => array_map(function ($lang) {
                            return trim(preg_replace("/\r\n|\r|\n/", '', strip_tags(html_entity_decode($lang))));
                        }, $course->getTranslations('title')),
                        'level_tags' => $course->level_tags,
                        'short_detail' => array_map(function ($lang) {
                            return trim(preg_replace("/\r\n|\r|\n/", '', strip_tags(html_entity_decode($lang))));
                        }, $course->getTranslations('short_detail')),
                        'price' => $course->price,
                        'discount_price' => $course->discount_price,
                        'featured' => $course->featured,
                        'status' => $course->status,
                        'preview_image' => $course->preview_image,
                        'imagepath' => url('images/course/' . $course->preview_image),
                        'total_rating_percent' => course_rating($course->id)->getData()->total_rating_percent,
                        'total_rating' => course_rating($course->id)->getData()->total_rating,
                        'in_wishlist' => Is_wishlist::in_wishlist($course->id),
                        'instructor' => [
                            'id' => $course->user->id,
                            'name' => $course->user->fname . ' ' . $course->user->lname,
                            'image' => url('/images/user_img/' . $course->user->user_img),
                        ],
                    ];
                }

                $category_slider1[0]['course'] = $category_slider_courses;
            }
        }

        return response()->json(['allcategory' => $all_categories, 'category_slider' => $category_slider1], 200);
    }

    //------------TESTIMONIAL-----------------

    function homeTestimonials(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'secret' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['Secret Key is required'], 402);
        }

        $key = DB::table('api_keys')
            ->where('secret_key', '=', $request->secret)
            ->first();

        if (!$key) {
            return response()->json(['Invalid Secret Key !'], 400);
        }
        App::setlocale($request->lang);

        $testimonials = Testimonial::where('status', 1)->get();

        // $testimonial_result = [];

        foreach ($testimonials as $testimonial) {
            $testimonial->details = strip_tags($testimonial->details);
        }

        return response()->json(['testimonial' => $testimonials], 200);
    }
    //------------SETTINGS-----------------

    function homeSetting(Request $request)
    {
        App::setlocale($request->lang);

        $validator = Validator::make($request->all(), [
            'secret' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['Secret Key is required'], 402);
        }

        $key = DB::table('api_keys')
            ->where('secret_key', '=', $request->secret)
            ->first();

        if (!$key) {
            return response()->json(['Invalid Secret Key !'], 400);
        }

        $settings = Setting::first();

        $currency2 = Currency::where('default', '1')->first();

        $currency = [
            'id' => $currency2->id,
            'icon' => $currency2->symbol,
            'currency' => $currency2->code,
            'default' => $currency2->default,
            'created_at' => $currency2->created_at,
            'updated_at' => $currency2->updated_at,
            'name' => $currency2->name,
            'format' => $currency2->format,
            'exchange_rate' => $currency2->default == 1 ? 1 : $currency2->exchange_rate,
        ];

        return response()->json(['settings' => $settings, 'currency' => $currency], 200);
    }
    //------------iNTRO VIDEO-----------------

    function videoSetting(Request $request)
    {
        
        App::setlocale($request->lang);

        $validator = Validator::make($request->all(), [
            'secret' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['Secret Key is required'], 402);
        }

        $key = DB::table('api_keys')
            ->where('secret_key', '=', $request->secret)
            ->first();

        if (!$key) {
            return response()->json(['Invalid Secret Key !'], 400);
        }

        $video = Videosetting::first();

        return response()->json(['video' => $video], 200);
    }

    //------------CONTACT US-----------------

    public function contactus(Request $request)
    {
        $this->validate($request, [
            'fname'   => 'required',
            'email'   => 'required',
            'mobile'  => 'required',
            'message' => 'required',
            'reason_id' => 'exists:contactreasons,id',
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

        App::setlocale($request->lang);

        $created_contact = Contact::create([
            'fname' => $request->fname,
            'email' => $request->email,
            'mobile' => $request->mobile,
            'message' => $request->message,
            'reason_id' => $request->reason_id,
            'created_at' => \Carbon\Carbon::now()->toDateTimeString(),
            'updated_at' => \Carbon\Carbon::now()->toDateTimeString(),
        ]);

        return response()->json(['contact' => $created_contact], 200);
    }

    public function contactReasons(Request $request)
    {
        App::setlocale($request->lang);

        $validator = Validator::make($request->all(), [
            'secret' => 'required',
        ]);
        if ($validator->fails()) {
            $errors = $validator->errors();
            if ($errors->first('secret')) {
                return response()->json(['message' => $errors->first('secret'), 'status' => 'fail'], 400);
            }
        }

        $key = DB::table('api_keys')->where('secret_key', '=', $request->secret)->first();
        if (!$key) {
            return response()->json(['Invalid Secret Key !']);
        }

        $data =  Contactreason::where('status', '1')->get(['id', 'reason']);

        return response()->json([
            'reasons' => $data,
        ], 200);
    }

    public function contactDetails(Request $request)
    {
        App::setlocale($request->lang);

        $validator = Validator::make($request->all(), [
            'secret' => 'required',
        ]);
        if ($validator->fails()) {
            $errors = $validator->errors();
            if ($errors->first('secret')) {
                return response()->json(['message' => $errors->first('secret'), 'status' => 'fail'], 400);
            }
        }

        $key = DB::table('api_keys')->where('secret_key', '=', $request->secret)->first();
        if (!$key) {
            return response()->json(['Invalid Secret Key !']);
        }

        $setting = Setting::first(['default_address', 'wel_email', 'default_phone']);

        return response()->json([
            'data' => $setting,
        ], 200);
    }
    //--------------BLOG-----------------------
    public function blog(Request $request)
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
        $blog = Blog::where('status', 1)->get();

        $blog_result = [];

        foreach ($blog as $data) {
            $blog_result[] = [
                'id' => $data->id,
                'user' => $data->user_id,
                'date' => $data->date,
                'image' => $data->image,
                'heading' => preg_replace("/\r\n|\r|\n/", '', strip_tags(html_entity_decode($data->heading))),
                'detail' => preg_replace("/\r\n|\r|\n/", '', strip_tags(html_entity_decode($data->detail))),
                'text' => $data->text,
                'approved' => $data->approved,
                'status' => $data->status,
                'created_at' => $data->created_at,
                'updated_at' => $data->updated_at,
            ];
        }

        return response()->json(['blog' => $blog_result], 200);
    }
    //----------HOMEBLOG---------------

    public function home_blog(Request $request)
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

        $blog = Blog::where('status', 1)
            ->orderBy('id', 'DESC')->take(5)->get();

        return response()->json(['blog' => $blog], 200);
    }
    //---------BLOGDETAILS------------------

    public function blogdetail(Request $request)
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

        $blog  = Blog::findorfail($request->id);
        return response()->json(['blog' => $blog], 200);
    }

    //------------WISH LIST-----------------

    public function addToWishlist(Request $request)
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

    public function removeWishlist(Request $request)
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

        $auth = Auth::guard('api')->user();

        $wishlist = Wishlist::where('course_id', $request->course_id)
            ->where('user_id', $auth->id)
            ->delete();

        if ($wishlist == 1) {
            return response()->json(['done'], 200);
        } else {
            return response()->json(['error'], 401);
        }
    }

    //--------------FAQ-----------------
    public function faq(Request $request)
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

        $faq = FaqStudent::where('status', 1)->get();
        return response()->json(['faq' => $faq], 200);
    }
    // ---------policy--------------------

    public function terms(Request $request)
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

        $terms_policy = Terms::get()->toArray();

        return response()->json(['terms_policy' => $terms_policy], 200);
    }
    // ------------FLASHDEALS------------
    public function deals(Request $request)
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

        $deals = Flashsale::get()->toArray();

        return response()->json(['deals' => $deals], 200);
    }
    // ---------FOLLOW--------------

    public function follow(Request $request)
    {
        App::setlocale($request->lang);

        $validator = Validator::make($request->all(), [
            'secret'      => 'required',
            'user_id'     => 'required',
            // 'follower_id' => 'required',
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
        if ($request->user_id != $request->follower_id) {

            $follower = Followers::create([
                'user_id'     => $request->user_id,
                'follower_id' => Auth::id(),
                'created_at'  => \Carbon\Carbon::now()->toDateTimeString(),
            ]);
            return response()->json(['success']);
        } else {
            return response()->json(['Unauthorized Action']);
        }
    }

    //  ---------UNFOLLOW--------------
    public function unfollow(Request $request)
    {
        App::setlocale($request->lang);

        $validator = Validator::make($request->all(), [
            'secret'      => 'required',
            'user_id'     => 'required',
            // 'follower_id' => 'required',
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
        $follower = Followers::where('user_id', $request->user_id)->where('follower_id', Auth::id())->delete();
        return response()->json(['success']);
    }

    //------------NOTiIFICATIONS-----------------

    public function userNotifications(Request $request)
    {
        App::setlocale($request->lang);

        $validator = Validator::make($request->all(), [
            'secret' => 'required',
        ]);
        if ($validator->fails()) {
            $errors = $validator->errors();
            if ($errors->first('secret')) {
                return response()->json(['message' => $errors->first('secret'), 'status' => 'fail'], 400);
            }
        }

        $key = DB::table('api_keys')->where('secret_key', '=', $request->secret)->first();
        if (!$key) {
            return response()->json(['Invalid Secret Key !']);
        }

        $user = User::where('id', Auth::id())->first();

        $notifications = $user->newNotifications()->orderBy('created_at', 'desc')->get();
        foreach ($notifications as $notification) {
            $notification->status = $notification->pivot->status;
        }
        $notifications->makeHidden(['pivot']);
        return response()->json([
            'notifications' => $notifications,
        ], 200);
    }

    public function unreadNotificationsCount(Request $request)
    {
        App::setlocale($request->lang);

        $validator = Validator::make($request->all(), [
            'secret' => 'required',
        ]);
        if ($validator->fails()) {
            $errors = $validator->errors();
            if ($errors->first('secret')) {
                return response()->json(['message' => $errors->first('secret'), 'status' => 'fail'], 400);
            }
        }

        $key = DB::table('api_keys')->where('secret_key', '=', $request->secret)->first();
        if (!$key) {
            return response()->json(['Invalid Secret Key !']);
        }

        $user = User::where('id', Auth::id())->first();

        $notifications = $user->newNotifications()->where('status', 0)->orderBy('created_at', 'desc')->count();

        return response()->json([
            'notifications_count' => $notifications,
        ], 200);
    }

    public function editNotificationsStatus(Request $request)
    {
        App::setlocale($request->lang);

        $validator = Validator::make($request->all(), [
            'secret' => 'required',
        ]);
        if ($validator->fails()) {
            $errors = $validator->errors();
            if ($errors->first('secret')) {
                return response()->json(['message' => $errors->first('secret'), 'status' => 'fail'], 400);
            }
        }

        $key = DB::table('api_keys')->where('secret_key', '=', $request->secret)->first();
        if (!$key) {
            return response()->json(['Invalid Secret Key !']);
        }

        DB::table('notification_user')->where('user_id', '=',  Auth::id())->update(['status' => 1]);


        return response()->json([
            'message' => 'All notifications have been read.',
        ], 200);
    }

    public function deleteNotification(Request $request)
    {
        App::setlocale($request->lang);

        $validator = Validator::make($request->all(), [
            'secret' => 'required',
            'id' => 'required|exists:new_notifications,id',
        ]);

        if ($validator->fails()) {
            $errors = $validator->errors();
            if ($errors->first('secret')) {
                return response()->json(['message' => $errors->first('secret'), 'status' => 'fail']);
            }
            if ($errors->first('id')) {
                return response()->json(['message' => $errors->first('id'), 'status' => 'fail']);
            }
        }

        $key = DB::table('api_keys')->where('secret_key', '=', $request->secret)->first();
        if (!$key) {
            return response()->json(['Invalid Secret Key !']);
        }

        $notification = NewNotification::where('id', $request->id)->first();

        DB::table('notification_user')->where('notification_id', '=',  $request->id)->where('user_id', '=',  Auth::id())->delete();

        return response()->json([
            'message' => 'Notification has been deleted successfully.',
        ], 200);
    }

    public function bulkDeleteNotification(Request $request)
    {
        App::setlocale($request->lang);

        $validator = Validator::make($request->all(), [
            'secret' => 'required',
        ]);
        if ($validator->fails()) {
            $errors = $validator->errors();
            if ($errors->first('secret')) {
                return response()->json(['message' => $errors->first('secret'), 'status' => 'fail'], 400);
            }
        }

        $key = DB::table('api_keys')->where('secret_key', '=', $request->secret)->first();
        if (!$key) {
            return response()->json(['Invalid Secret Key !']);
        }

        $user = User::where('id', Auth::id())->first();

        $notifications = $user->newNotifications;
        foreach ($notifications as $notification) {
            DB::table('notification_user')->where('notification_id', '=',  $notification->id)->where('user_id', '=',  Auth::id())->delete();
        }

        return response()->json([
            'message' => 'Notifications have been deleted successfully.',
        ], 200);
    }
    //------------USER PROFILE-----------------

    public function userprofile(Request $request)
    {
        App::setlocale($request->lang);

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

        $user = User::where('id', Auth::user()->id)
            ->with(['country:id,name,nicename', 'state:id,name,country_id', 'city:id,name,state_id'])
            ->first();
        $code = Auth::user()->token();


        // calcollate quiz percentage
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

        $user->quiz_total = $quiz_total;

        $course_ids = Order::where('user_id', Auth::guard('api')->id())->where('status', 1)->where('course_id', '!=', NULL)->pluck('course_id')->toArray();
        $user->course_enrolled_count = Order::where('user_id', Auth::guard('api')->id())->where('status', 1)->where('course_id', '!=', NULL)->count();
        $bundle_courses              = Order::where('refunded', '0')->where('status', '=', 1)->where('user_id', Auth::guard('api')->id())->where('bundle_course_id', '!=', NULL)->get();
        foreach ($bundle_courses as $bundle) {
            foreach ($bundle->bundle_course_id as $id) {
                if (!in_array($id, $course_ids)) {
                    $user->course_enrolled_count += 1;
                }
            }
        }

        $total_completed = CourseProgress::where('user_id', Auth::guard('api')->id())->get();

        $total_progess = 0;

        foreach ($total_completed as $progress) {
            if (count($progress->all_chapter_id) ==  count($progress->mark_chapter_id)) {
                $total_progess =  $total_progess += 1;
            }
        }

        $user->completed_course_count = $total_progess;

        return response()->json(['user' => $user, 'code' => $code->id], 200);
    }

    public function updateprofile(Request $request)
    {
        App::setlocale($request->lang);

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
            'fname' => 'required',
            'lname' => 'required',
            'email' => 'required|email',
            'mobile' => 'required',
            // 'current_password' => 'required',
        ]);
        $input = $request->all();

        // if (Hash::check($request->current_password, $auth->password)) {
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
            'mobile'   => isset($input['mobile']) ? $input['mobile'] : $auth->mobile,
            'dob'      => isset($input['dob']) ? $input['dob'] : $auth->dob,
            'user_img' => isset($input['user_img']) ? $input['user_img'] : $auth->user_img,
            'address'  => isset($input['address']) ? $input['address'] : $auth->address,
            'detail'   => isset($input['detail']) ? $input['detail'] : $auth->detail,
            'country_id' => isset($input['country_id']) ? $input['country_id'] : $auth->country_id,
            'state_id'   => isset($input['state_id']) ? $input['state_id'] : $auth->state_id,
            'city_id'    => isset($input['city_id']) ? $input['city_id'] : $auth->city_id,
        ]);

        $auth->save();
        return response()->json(['auth' => $auth], 200);
        // } else {
        //     return response()->json('error: password doesnt match', 400);
        // }
    }

    public function aboutus(Request $request)
    {
        App::setlocale($request->lang);

        $about = About::first();
        return response()->json(['about' => $about], 200);
    }

    public function reportCourse(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title'     => 'required',
            'email'     => 'nullable|email',
            'course_id' => 'required|exists:courses,id',
            'detail'    => 'required',
        ]);

        App::setlocale($request->lang);

        DB::table('course_reports')->insert(
            array(
                'course_id' => $request->course_id,
                'user_id'   => Auth::User()->id,
                'title'     => $request->title,
                'email'     => $request->email,
                'detail'    => $request->detail,
                'created_at'  => \Carbon\Carbon::now()->toDateTimeString(),
            )
        );

        return response()->json(['success']);
    }

    public function reportQuestion(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id'        => 'required|exists:questions,id',
            'title'     => 'required',
            'email'     => 'nullable|email',
            'detail'    => 'required',
        ]);

        App::setlocale($request->lang);
        $question = Question::where('id', $request->id)->first();
        DB::table('question_reports')->insert(
            array(
                'course_id'   => $question->course_id,
                'user_id'     => Auth::User()->id,
                'question_id' => $request->id,
                'title'       => $request->title,
                'email'       => $request->email,
                'detail'      => $request->detail,
                'created_at'  => \Carbon\Carbon::now()->toDateTimeString(),
            )
        );

        return response()->json(['success']);
    }

    public function reportReview(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id'        => 'required|exists:review_ratings,id',
            'title'     => 'required',
            'email'     => 'nullable|email',
            'detail'    => 'required',
        ]);

        App::setlocale($request->lang);
        $review = ReviewRating::where('id', $request->id)->first();

        DB::table('report_reviews')->insert(
            array(
                'course_id'  => $review->id,
                'user_id'    => Auth::User()->id,
                'review_id'  => $request->id,
                'title'      => $request->title,
                'email'      => $request->email,
                'detail'     => $request->detail,
                'created_at' => \Carbon\Carbon::now()->toDateTimeString(),
            )
        );

        return response()->json(['success']);
    }

    public function CourseLanguages(Request $request)
    {
        App::setlocale($request->lang);

        $languages = CourseLanguage::where('status', 1)->get(['id', 'name']);

        return response()->json(['languages' => $languages], 200);
    }

    public function countries(Request $request)
    {
        App::setlocale($request->lang);

        $countries = Country::get(['id', 'name', 'nicename', 'country_id']);

        return response()->json(['countries' => $countries], 200);
    }

    public function states(Request $request)
    {
        App::setlocale($request->lang);

        $states = State::where('country_id', $request->country_id)->get(['id', 'name', 'country_id', 'state_id']);

        return response()->json(['states' => $states], 200);
    }

    public function cities(Request $request)
    {
        App::setlocale($request->lang);

        $cities = City::where('state_id', $request->state_id)->get(['id', 'name', 'state_id']);

        return response()->json(['cities' => $cities], 200);
    }
}
