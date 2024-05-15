<?php

namespace App\Http\Controllers;

use App\admin;
use App\Allcountry;
use Illuminate\Http\Request;
use Auth;
use App\Order;
use App\Charts\UserChart;
use App\User;
use App\Course;
use App\FaqStudent;
use App\Page;
use App\Blog;
use App\Testimonial;
use App\Meeting;
use App\BBL;
use App\JitsiMeeting;
use App\Googlemeet;
use App\Categories;
use App\RefundPolicy;
use App\Charts\UserDistributionChart;
use App\CompletedPayout;
use Illuminate\Support\Facades\Http;
use Session;
use App\Charts\OrderChart;
use App\Charts\AdminRevenueChart;
use App\Country;
use DB;
use Storage;
use App\Coupon;
use App\CourseClass;
use App\CourseProgress;
use App\FavCategory;
use App\FavSubcategory;
use App\Followers;
use App\SubCategory;
use Carbon\Carbon;
use Spatie\Permission\Models\Role;


class AdminController extends Controller
{
    public function __construct()
    {
        return $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {


        if (Auth::User()->role == "admin") {

            $userss = User::where('role', 'user')->count();
            $adminss = User::where('role', 'admin')->count();

            $baseURL = env('APP_URL');
            $baseURL = substr($baseURL, 0, -1);

            $daily_visits = DB::table('shetabit_visits')->where('url', $baseURL)->whereDate('created_at', carbon::today())->count();
            $monthly_visits = DB::table('shetabit_visits')->where('url', $baseURL)->whereMonth('created_at', Carbon::now()->month)->count();
            $online_count = visitor()->onlineVisitors(User::class)->count();

            $usergraph = array(
                User::whereDate('created_at', '=', Carbon::now()->subdays(1))->count(),
                User::whereDate('created_at', '=', Carbon::now()->subdays(2))->count(),
                User::whereDate('created_at', '=', Carbon::now()->subdays(3))->count(),
                User::whereDate('created_at', '=', Carbon::now()->subdays(4))->count(),
                User::whereDate('created_at', '=', Carbon::now()->subdays(5))->count(),
                User::whereDate('created_at', '=', Carbon::now()->subdays(6))->count(),
                User::whereDate('created_at', '=', Carbon::now()->subdays(7))->count(),
            );


            $courses = Course::count();
            $coursegraph = array(
                Course::whereDate('created_at', '=', Carbon::now()->subdays(1))->count(),
                Course::whereDate('created_at', '=', Carbon::now()->subdays(2))->count(),
                Course::whereDate('created_at', '=', Carbon::now()->subdays(3))->count(),
                Course::whereDate('created_at', '=', Carbon::now()->subdays(4))->count(),
                Course::whereDate('created_at', '=', Carbon::now()->subdays(5))->count(),
                Course::whereDate('created_at', '=', Carbon::now()->subdays(6))->count(),
                Course::whereDate('created_at', '=', Carbon::now()->subdays(7))->count(),
            );
            $categories = Course::count();
            $categorygraph = array(
                Categories::whereDate('created_at', '=', Carbon::now()->subdays(1))->count(),
                Categories::whereDate('created_at', '=', Carbon::now()->subdays(2))->count(),
                Categories::whereDate('created_at', '=', Carbon::now()->subdays(3))->count(),
                Categories::whereDate('created_at', '=', Carbon::now()->subdays(4))->count(),
                Categories::whereDate('created_at', '=', Carbon::now()->subdays(5))->count(),
                Categories::whereDate('created_at', '=', Carbon::now()->subdays(6))->count(),
                Categories::whereDate('created_at', '=', Carbon::now()->subdays(7))->count(),
            );
            $orders = Order::count();
            $ordergraph = array(
                Order::whereDate('created_at', '=', Carbon::now()->subdays(1))->count(),
                Order::whereDate('created_at', '=', Carbon::now()->subdays(2))->count(),
                Order::whereDate('created_at', '=', Carbon::now()->subdays(3))->count(),
                Order::whereDate('created_at', '=', Carbon::now()->subdays(4))->count(),
                Order::whereDate('created_at', '=', Carbon::now()->subdays(5))->count(),
                Order::whereDate('created_at', '=', Carbon::now()->subdays(6))->count(),
                Order::whereDate('created_at', '=', Carbon::now()->subdays(7))->count(),
            );
            $refund = RefundPolicy::count();
            $refundgraph = array(
                RefundPolicy::whereDate('created_at', '=', Carbon::now()->subdays(1))->count(),
                RefundPolicy::whereDate('created_at', '=', Carbon::now()->subdays(2))->count(),
                RefundPolicy::whereDate('created_at', '=', Carbon::now()->subdays(3))->count(),
                RefundPolicy::whereDate('created_at', '=', Carbon::now()->subdays(4))->count(),
                RefundPolicy::whereDate('created_at', '=', Carbon::now()->subdays(5))->count(),
                RefundPolicy::whereDate('created_at', '=', Carbon::now()->subdays(6))->count(),
                RefundPolicy::whereDate('created_at', '=', Carbon::now()->subdays(7))->count(),
            );
            $coupon = Coupon::count();
            $coupongraph = array(
                Coupon::whereDate('created_at', '=', Carbon::now()->subdays(1))->count(),
                Coupon::whereDate('created_at', '=', Carbon::now()->subdays(2))->count(),
                Coupon::whereDate('created_at', '=', Carbon::now()->subdays(3))->count(),
                Coupon::whereDate('created_at', '=', Carbon::now()->subdays(4))->count(),
                Coupon::whereDate('created_at', '=', Carbon::now()->subdays(5))->count(),
                Coupon::whereDate('created_at', '=', Carbon::now()->subdays(6))->count(),
                Coupon::whereDate('created_at', '=', Carbon::now()->subdays(7))->count(),
            );
            $zoom = Meeting::count();
            $zoomgraph = array(
                Meeting::whereDate('created_at', '=', Carbon::now()->subdays(1))->count(),
                Meeting::whereDate('created_at', '=', Carbon::now()->subdays(2))->count(),
                Meeting::whereDate('created_at', '=', Carbon::now()->subdays(3))->count(),
                Meeting::whereDate('created_at', '=', Carbon::now()->subdays(4))->count(),
                Meeting::whereDate('created_at', '=', Carbon::now()->subdays(5))->count(),
                Meeting::whereDate('created_at', '=', Carbon::now()->subdays(6))->count(),
                Meeting::whereDate('created_at', '=', Carbon::now()->subdays(7))->count(),
            );
            $bbl = BBL::count();
            $bblgraph = array(
                BBL::whereDate('created_at', '=', Carbon::now()->subdays(1))->count(),
                BBL::whereDate('created_at', '=', Carbon::now()->subdays(2))->count(),
                BBL::whereDate('created_at', '=', Carbon::now()->subdays(3))->count(),
                BBL::whereDate('created_at', '=', Carbon::now()->subdays(4))->count(),
                BBL::whereDate('created_at', '=', Carbon::now()->subdays(5))->count(),
                BBL::whereDate('created_at', '=', Carbon::now()->subdays(6))->count(),
                BBL::whereDate('created_at', '=', Carbon::now()->subdays(7))->count(),
            );
            $jitsi = JitsiMeeting::count();
            $jitsigraph = array(
                JitsiMeeting::whereDate('created_at', '=', Carbon::now()->subdays(1))->count(),
                JitsiMeeting::whereDate('created_at', '=', Carbon::now()->subdays(2))->count(),
                JitsiMeeting::whereDate('created_at', '=', Carbon::now()->subdays(3))->count(),
                JitsiMeeting::whereDate('created_at', '=', Carbon::now()->subdays(4))->count(),
                JitsiMeeting::whereDate('created_at', '=', Carbon::now()->subdays(5))->count(),
                JitsiMeeting::whereDate('created_at', '=', Carbon::now()->subdays(6))->count(),
                JitsiMeeting::whereDate('created_at', '=', Carbon::now()->subdays(7))->count(),
            );
            $googlemeet = Googlemeet::count();
            $googlemeetgraph = array(
                Googlemeet::whereDate('created_at', '=', Carbon::now()->subdays(1))->count(),
                Googlemeet::whereDate('created_at', '=', Carbon::now()->subdays(2))->count(),
                Googlemeet::whereDate('created_at', '=', Carbon::now()->subdays(3))->count(),
                Googlemeet::whereDate('created_at', '=', Carbon::now()->subdays(4))->count(),
                Googlemeet::whereDate('created_at', '=', Carbon::now()->subdays(5))->count(),
                Googlemeet::whereDate('created_at', '=', Carbon::now()->subdays(6))->count(),
                Googlemeet::whereDate('created_at', '=', Carbon::now()->subdays(7))->count(),
            );
            $faq = FaqStudent::count();
            $faqgraph = array(
                FaqStudent::whereDate('created_at', '=', Carbon::now()->subdays(1))->count(),
                FaqStudent::whereDate('created_at', '=', Carbon::now()->subdays(2))->count(),
                FaqStudent::whereDate('created_at', '=', Carbon::now()->subdays(3))->count(),
                FaqStudent::whereDate('created_at', '=', Carbon::now()->subdays(4))->count(),
                FaqStudent::whereDate('created_at', '=', Carbon::now()->subdays(5))->count(),
                FaqStudent::whereDate('created_at', '=', Carbon::now()->subdays(6))->count(),
                FaqStudent::whereDate('created_at', '=', Carbon::now()->subdays(7))->count(),
            );
            $pages = Page::count();
            $pagegraph = array(
                Page::whereDate('created_at', '=', Carbon::now()->subdays(1))->count(),
                Page::whereDate('created_at', '=', Carbon::now()->subdays(2))->count(),
                Page::whereDate('created_at', '=', Carbon::now()->subdays(3))->count(),
                Page::whereDate('created_at', '=', Carbon::now()->subdays(4))->count(),
                Page::whereDate('created_at', '=', Carbon::now()->subdays(5))->count(),
                Page::whereDate('created_at', '=', Carbon::now()->subdays(6))->count(),
                Page::whereDate('created_at', '=', Carbon::now()->subdays(7))->count(),
            );
            $blogs = Blog::count();
            $bloggraph = array(
                Blog::whereDate('created_at', '=', Carbon::now()->subdays(1))->count(),
                Blog::whereDate('created_at', '=', Carbon::now()->subdays(2))->count(),
                Blog::whereDate('created_at', '=', Carbon::now()->subdays(3))->count(),
                Blog::whereDate('created_at', '=', Carbon::now()->subdays(4))->count(),
                Blog::whereDate('created_at', '=', Carbon::now()->subdays(5))->count(),
                Blog::whereDate('created_at', '=', Carbon::now()->subdays(6))->count(),
                Blog::whereDate('created_at', '=', Carbon::now()->subdays(7))->count(),
            );
            $testimonial = Testimonial::count();
            $testimonialgraph = array(
                Testimonial::whereDate('created_at', '=', Carbon::now()->subdays(1))->count(),
                Testimonial::whereDate('created_at', '=', Carbon::now()->subdays(2))->count(),
                Testimonial::whereDate('created_at', '=', Carbon::now()->subdays(3))->count(),
                Testimonial::whereDate('created_at', '=', Carbon::now()->subdays(4))->count(),
                Testimonial::whereDate('created_at', '=', Carbon::now()->subdays(5))->count(),
                Testimonial::whereDate('created_at', '=', Carbon::now()->subdays(6))->count(),
                Testimonial::whereDate('created_at', '=', Carbon::now()->subdays(7))->count(),
            );
            $follower = Followers::count();
            $followergraph = array(
                Followers::whereDate('created_at', '=', Carbon::now()->subdays(1))->count(),
                Followers::whereDate('created_at', '=', Carbon::now()->subdays(2))->count(),
                Followers::whereDate('created_at', '=', Carbon::now()->subdays(3))->count(),
                Followers::whereDate('created_at', '=', Carbon::now()->subdays(4))->count(),
                Followers::whereDate('created_at', '=', Carbon::now()->subdays(5))->count(),
                Followers::whereDate('created_at', '=', Carbon::now()->subdays(6))->count(),
                Followers::whereDate('created_at', '=', Carbon::now()->subdays(7))->count(),
            );

            $instructor = User::where('role', '=', 'instructor')->count();
            $instructorgraph = array(
                User::where('role', '=', 'instructor')->whereDate('created_at', '=', Carbon::now()->subdays(1))->count(),
                User::where('role', '=', 'instructor')->whereDate('created_at', '=', Carbon::now()->subdays(2))->count(),
                User::where('role', '=', 'instructor')->whereDate('created_at', '=', Carbon::now()->subdays(3))->count(),
                User::where('role', '=', 'instructor')->whereDate('created_at', '=', Carbon::now()->subdays(4))->count(),
                User::where('role', '=', 'instructor')->whereDate('created_at', '=', Carbon::now()->subdays(5))->count(),
                User::where('role', '=', 'instructor')->whereDate('created_at', '=', Carbon::now()->subdays(6))->count(),
                User::where('role', '=', 'instructor')->whereDate('created_at', '=', Carbon::now()->subdays(7))->count(),
            );
            $topuser = User::where('role', '=', 'user')->orderBy('id', 'DESC')->take(5)->get();
            $topinstructor = User::where('role', '=', 'instructor')->orderBy('id', 'DESC')->take(5)->get();
            $topcourses = Course::orderBy('id', 'DESC')->take(5)->get();

            $coursesToSort = Course::get(['id', 'title', 'short_detail', 'preview_image']);

            //  Most purchased courses
            foreach ($coursesToSort as $course) {
                $course->order_count = $course->order->count();
            }
            $topOrderedCourses = $coursesToSort->sortByDesc(function ($course) {
                return $course->order_count;
            });
            $topOrderedCourses = $topOrderedCourses->take(5);


            //  Most viewed courses
            foreach ($coursesToSort as $course) {
                $course->progress_count = $course->progress->count();
            }
            $topviewedCourses = $coursesToSort->sortByDesc(function ($course) {
                return $course->progress_count;
            });
            $topviewedCourses = $topviewedCourses->take(5);


            //  top countris
            $countries = Allcountry::get();
            foreach ($countries as $contry) {
                $contry->users_count = $contry->users->count();
            }

            $countries = $countries->sortByDesc(function ($country) {
                return $country->users_count;
            });

            $topCountries = $countries->filter(function ($model) {
                return $model->users_count != 0;
            });
            $topCountriesCount = $topCountries->count();

            $country_names = [];
            $country_counts = [];
            foreach ($topCountries as $value) {
                array_push($country_names, $value->nicename);
                array_push($country_counts, $value->users_count);
            }


            // Total minutes viewed
            $progresses = CourseProgress::get();
            $TotalMinutesViewed = 0;

            foreach ($progresses as $progress) {
                $chapters = $progress->mark_chapter_id;
                foreach ($chapters as $chapter) {
                    $classes = CourseClass::where('coursechapter_id', $chapter)->get('duration');
                    foreach ($classes as $class) {
                        $TotalMinutesViewed = $TotalMinutesViewed + (float)$class->duration;
                    }
                }
            }

            $toporder = Order::orderBy('id', 'DESC')->take(5)->get();
            $admin = User::where('role', '=', 'admin')->count();
            $admins = User::where('role', '=', 'admin')->count();
            $instructors = User::where('role', '=', 'instructor')->count();
            $users = User::where('role', '=', 'user')->count();
            $admincharts = ([$admins, $instructors, $users]);
            $users =  User::select(DB::raw("COUNT(*) as count"))
                ->whereYear('created_at', date('Y'))
                ->groupBy(DB::raw("Month(created_at)"))
                ->pluck('count');

            $months = User::select(DB::raw("Month(created_at) as month"))
                ->whereYear('created_at', date('Y'))
                ->groupBy(DB::raw("Month(created_at)"))
                ->pluck('month');

            $datas = [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0];
            foreach ($months as $index => $month) {
                $datas[$month - 1] = $users[$index];
            }
            $users =    Order::select(DB::raw("COUNT(*) as count"))
                ->whereYear('created_at', date('Y'))
                ->groupBy(DB::raw("Month(created_at)"))
                ->pluck('count');

            $months =   Order::select(DB::raw("Month(created_at) as month"))
                ->whereYear('created_at', date('Y'))
                ->groupBy(DB::raw("Month(created_at)"))
                ->pluck('month');

            $datas1 = [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0];
            foreach ($months as $index => $month) {
                $datas1[$month - 1] = $users[$index];
            }


            return view('admin.dashboard', compact(
                'userss',
                'adminss',
                'daily_visits',
                'monthly_visits',
                'online_count',
                'usergraph',
                'categories',
                'categorygraph',
                'courses',
                'coursegraph',
                'country_names',
                'country_counts',
                'orders',
                'ordergraph',
                'refund',
                'refundgraph',
                'coupon',
                'coupongraph',
                'zoom',
                'zoomgraph',
                'bbl',
                'bblgraph',
                'jitsi',
                'jitsigraph',
                'googlemeet',
                'googlemeetgraph',
                'faq',
                'faqgraph',
                'pages',
                'pagegraph',
                'blogs',
                'bloggraph',
                'testimonial',
                'testimonialgraph',
                'instructor',
                'instructorgraph',
                'topuser',
                'topinstructor',
                'topcourses',
                'topOrderedCourses',
                'topviewedCourses',
                'TotalMinutesViewed',
                'toporder',
                'admincharts',
                'datas',
                'datas1',
                'followergraph',
                'follower'
            ));
        } elseif (Auth::User()->role == "instructor") {

            return view('instructor.dashboard');
        } else {
            abort(403, 'User does not have right permissions.');
        }
    }




    public function changedomain(Request $request)
    {

        $request->validate([
            'domain' => 'required'
        ]);

        $code = file_exists(storage_path() . '/app/keys/license.json') && file_get_contents(storage_path() . '/app/keys/license.json') != null ? file_get_contents(storage_path() . '/app/keys/license.json') : '';

        $code = json_decode($code);

        if ($code == '') {
            return back()->withInput()->withErrors(['domain' => 'Purchase code not found please contact support !']);
        }

        $d = $request->domain;
        $domain = str_replace("www.", "", $d);
        $domain = str_replace("http://", "", $domain);
        $domain = str_replace("https://", "", $domain);
        $alldata = ['app_id' => "25613271", 'ip' => $request->ip(), 'domain' => $domain, 'code' => $code->code];
        $data = $this->make_request($alldata);

        if ($data['status'] == 1) {
            $put = 1;
            file_put_contents(public_path() . '/config.txt', $put);

            Session::flash('success', 'Domain permission changed successfully !');

            return redirect('/');
        } elseif ($data['msg'] == 'Already Register') {
            return back()->withInput()->withErrors(['domain' => 'User is already registered !']);
        } else {
            return back()->withInput()->withErrors(['domain' => $data['msg']]);
        }
    }

    public function make_request($alldata)
    {
        $response = Http::post('https://mediacity.co.in/purchase/public/api/verifycode', [
            'app_id' => $alldata['app_id'],
            'ip' => $alldata['ip'],
            'code' => $alldata['code'],
            'domain' => $alldata['domain']
        ]);

        $result = $response->json();

        if ($response->successful()) {
            if ($result['status'] == '1') {

                $lic_json = array(

                    'name'     => request()->user_id,
                    'code'     => $alldata['code'],
                    'type'     => __('envato'),
                    'domain'   => $alldata['domain'],
                    'lic_type' => __('regular'),
                    'token'    => $result['token']

                );

                $file = json_encode($lic_json);

                $filename =  'license.json';

                Storage::disk('local')->put('/keys/' . $filename, $file);

                return array(
                    'msg' => $result['message'],
                    'status' => '1'
                );
            } else {
                $message = $result['message'];

                return array(
                    'msg' => $message,
                    'status' => '0'
                );
            }
        } else {
            $message = "Failed to validate";

            return array(
                'msg' => $message,
                'status' => '0'
            );
        }
    }
}
