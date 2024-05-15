<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Order;
use DB;
use App\Setting;
use App\Course;
use App\User;
use App\CourseProgress;
use App\CourseChapter;
use Auth;
use Redirect;
use PDF;
use App\Currency;
use App\BundleCourse;
use Session;
use Crypt;
use App\RefundCourse;
use App\RefundPolicy;
use Illuminate\Support\Facades\Log;
use App\InvoiceDesign;
use Rap2hpoutre\FastExcel\FastExcel;
use Spatie\Permission\Models\Role;
use App\Http\Traits\SendNotification;
use App\NewNotification;
use App\Mail\EnrollCourseMail;
use Illuminate\Support\Facades\Mail;


class OrderController extends Controller
{
    use SendNotification;

    public function __construct()
    {
        $this->middleware('permission:orders.manage', ['only' => ['index', 'enrollUser', 'create', 'store', 'destroy', 'vieworder', 'status', 'order_report']]);
    }

    public function index()
    {
        $refunds = RefundCourse::get();
        $orders = Order::whereHas('courses')
            ->orWhereHas('bundle')
            ->orderBy('id', 'DESC')
            ->get();
        return view('admin.order.show', compact('orders', 'refunds'));
    }

    public function enrollUser($user_id)
    {
        Log::debug('<==enrollUser');

        if (!isset($user_id)) {
            return redirect('order/create');
        }
        $users = User::all();
        $selectedUser = User::findOrFail($user_id);
        Log::debug('Fetching user course details: ' . $selectedUser);
        $orders = Order::where('user_id', $user_id)->get();

        $enrolledCourses = [];
        $enrolledBundles = [];

        $enrolledCourseIds = [];
        $enrolledBundleIds = [];

        foreach ($orders as $order) {
            if ($order->course_id !== null) {
                array_push($enrolledCourseIds, $order->course_id);
                array_push($enrolledCourses, $order->courses);
            } else {
                array_push($enrolledBundleIds, $order->bundle_id);
                array_push($enrolledBundles, $order->bundle);
            }
        }

        $courses = Course::all()->whereNotIn('id', $enrolledCourseIds);
        $bundles = BundleCourse::all()->whereNotIn('id', $enrolledBundleIds);

        Log::debug('==>enrollUser');

        return view('admin.order.create', compact('users', 'courses', 'bundles', 'enrolledCourses', 'enrolledBundles', 'selectedUser'));
    }

    public function create()
    {
        $users = User::all();

        if (Auth::user()->role == 'admin') {
            $courses = Course::get();
            $bundles = BundleCourse::get();
        } else {
            $courses = Course::where('user_id', Auth::user()->id)->get();
            $bundles = BundleCourse::where('user_id', Auth::user()->id)->get();
        }

        return view('admin.order.create', compact('users', 'courses', 'bundles'));
    }

    public function store(Request $request)
    {
        if (!isset($request->course_id) && !isset($request->bundle_id)) {
            Session::flash('delete', trans('flash.CourseRequired'));

            return redirect('order/create');
        }

        $subscription_status = null;

        if (isset($request->bundle_id)) {
            $selectedBundle = BundleCourse::findOrFail($request->bundle_id);
            if ($selectedBundle->is_subscription_enabled) {
                $subscription_status = 'active';
            }

            $bundle = BundleCourse::where('id', $request->bundle_id)->first();

            $created_bundle = Order::create([
                'bundle_id' => $request->bundle_id,
                'user_id' => $request->user_id,
                'instructor_id' => $bundle->user_id,
                'subscription_status' => $subscription_status,
                'payment_method' => 'Admin Enroll',
                'created_at' => \Carbon\Carbon::now()->toDateTimeString(),
            ]);

            foreach ($bundle->course_id as $id) {
                $progress = CourseProgress::where('course_id', '=', $id)->where('user_id', $request->user_id)->first();
                $cor = Course::where('id', '=', $id)->first();

                if (!isset($progress)) {
                    $chapter = CourseChapter::where('course_id', $id)->get();

                    $chapter_id = array();

                    foreach ($chapter as $c) {
                        array_push($chapter_id, "$c->id");
                    }

                    $created_progress = CourseProgress::create(
                        [
                            'course_id' => $id,
                            'user_id' => $request->user_id,
                            'mark_chapter_id' => [],
                            'all_chapter_id' => $chapter_id,
                            'created_at'  => \Carbon\Carbon::now()->toDateTimeString(),
                            'updated_at'  => \Carbon\Carbon::now()->toDateTimeString(),
                        ]
                    );
                }

                $user = User::where('id', $request->user_id)->first();
                $body = 'Your application to join the course: ' . $cor->title . ', has been accepted.';
                $notification = NewNotification::create(['body' => $body,]);
                $notification->users()->attach(['user_id' => $user->id]);
                if (isset($user->device_token)) {
                    $this->send_notification($user->device_token, 'Course Enrollment', $body);
                }
            }

            Log::debug('order created successful' . $created_bundle);
        }

        if (isset($request->course_id)) {
            $course = Course::where('id', $request->course_id)->first();

            $created_course = Order::create([
                'course_id' => $request->course_id,
                'user_id' => $request->user_id,
                'instructor_id' => $course->user_id,
                'payment_method' => 'Admin Enroll',
                'created_at' => \Carbon\Carbon::now()->toDateTimeString(),
            ]);

            $progress = CourseProgress::where('course_id', '=', $request->course_id)->where('user_id', $request->user_id)->first();

            if (!isset($progress)) {
                $chapter = CourseChapter::where('course_id', $request->course_id)->get();

                $chapter_id = array();

                foreach ($chapter as $c) {
                    array_push($chapter_id, "$c->id");
                }

                $created_progress = CourseProgress::create(
                    [
                        'course_id' => $request->course_id,
                        'user_id' => $request->user_id,
                        'mark_chapter_id' => [],
                        'all_chapter_id' => $chapter_id,
                        'created_at'  => \Carbon\Carbon::now()->toDateTimeString(),
                        'updated_at'  => \Carbon\Carbon::now()->toDateTimeString(),
                    ]
                );
            }

            Log::debug('order created successful' . $created_course);
            $user = User::where('id', $created_course->user_id)->first();
            $body = 'Your application to join the course: ' . $course->title . ', has been accepted.';
            $notification = NewNotification::create(['body' => $body,]);
            $notification->users()->attach(['user_id' => $user->id]);
            if (isset($user->device_token)) {
                $this->send_notification($user->device_token, 'Course Enrollment', $body);
            }
            
            // Mail::to($user->email)->send(new EnrollCourseMail($user, $course));

        }

        Session::flash('success', trans('flash.EnrolledSuccessfully'));



        return redirect('order');
    }

    public function destroy($id)
    {
        DB::table('orders')
            ->where('id', $id)
            ->delete();
        DB::table('pending_payouts')
            ->where('order_id', $id)
            ->delete();
        return back();
    }

    public function vieworder($id)
    {
        $setting = Setting::first();
        $show = Order::where('id', $id)->first();

        $bundle_order = BundleCourse::where('id', $show->bundle_id)->first();
        return view('admin.order.view', compact('show', 'setting', 'bundle_order'));
    }

    public function purchasehistory()
    {
        $course = Course::get();
        if (Auth::check()) {
            $orders = Order::where('refunded', '0')
                ->where('user_id', Auth::user()->id)
                ->get();

            $refunds = RefundCourse::where('user_id', Auth::user()->id)->get();

            return view('front.purchase_history.purchase', compact('orders', 'course', 'refunds'));
        }
        return Redirect::route('login')
            ->withInput()
            ->with('delete', trans('flash.PleaseLogin'));
    }

    public function invoice($id)
    {
        $course = Course::all();
        $Bundle = BundleCourse::all();
        $orders = Order::where('id', $id)->first();

        $bundle_order = BundleCourse::where('id', $orders->bundle_id)->first();

        $invoice = InvoiceDesign::first();

        if (Auth::check()) {
            return view('front.purchase_history.invoice', compact('orders', 'course', 'Bundle', 'bundle_order', 'invoice'));
        }

        return Redirect::route('login')
            ->withInput()
            ->with('delete', trans('flash.PleaseLogin'));
    }

    public function pdfdownload($id)
    {
        $course = Course::all();
        $orders = Order::where('id', $id)->first();

        $bundle_order = BundleCourse::where('id', $orders->bundle_id)->first();

        $invoice = InvoiceDesign::first();

        $stylesheet = file_get_contents('css/bootstrap.min.css');

        $pdf = PDF::loadView(
            'front.purchase_history.download',
            compact('orders', 'course', 'bundle_order', 'invoice'),
            [],
            [
                'title' => 'Invoice',
                'orientation' => 'L',
            ],
        );

        return $pdf->download('invoice.pdf');
        // return $pdf->stream();
    }

    public function apiinvoicepdfdownload($id)
    {
        $course = Course::all();
        $orders = Order::where('id', $id)->first();

        if ($orders->bundle_id != null) {
            $bundle_order = BundleCourse::where('id', $orders->bundle_id)->first();
        } else {
            $bundle_order = null;
        }

        $invoice = InvoiceDesign::first();

        $stylesheet = file_get_contents('css/bootstrap.min.css');

        $pdf = PDF::loadView(
            'front.purchase_history.download',
            compact('orders', 'course', 'bundle_order', 'invoice'),
            [],
            [
                'title' => 'Invoice',
                'orientation' => 'L',
            ],
        );

        return $pdf->download('invoice.pdf');
    }

    public function refundview($id)
    {
        $ids = Crypt::decrypt($id);
        $order = Order::where('id', $ids)->first();

        $cor = $order->course_id;

        $course = Course::where('id', $cor)->first();

        $policy = RefundPolicy::where('id', $course->refund_policy_id)->first();

        if (Auth::check()) {
            return view('front.purchase_history.refund', compact('order', 'policy'));
        }

        return Redirect::route('login')
            ->withInput()
            ->with('delete', trans('flash.PleaseLogin'));
    }

    public function refundrequest(Request $request, $id)
    {
        // return $request;

        $ids = Crypt::decrypt($id);
        $order = Order::where('id', $ids)->first();

        $currency = Currency::where('default', '=', '1')->first();

        if ($request->refund_mode == 'bank') {
            $user_bank_id = $request->bank_id;
            $payment_method = 'BankTransfer';
        } else {
            $user_bank_id = null;
            $payment_method = $order->payment_method;
        }

        $created_refund = RefundCourse::create([
            'user_id' => Auth::user()->id,
            'course_id' => $order->course_id,
            'order_id' => $order->id,
            'instructor_id' => $order->instructor_id,
            'payment_method' => $payment_method,
            'total_amount' => $order->total_amount,
            'status' => 0,
            'reason' => $request->reason,
            'detail' => $request->detail,
            'currency' => $order['currency'],
            'currency_icon' => $order->currency_icon,
            'bank_id' => $user_bank_id,
            'created_at' => \Carbon\Carbon::now()->toDateTimeString(),
            'updated_at' => \Carbon\Carbon::now()->toDateTimeString(),
        ]);

        $created_refund->ref_id = 'REF' . $created_refund->id . $created_refund->order_id;
        $created_refund->save();

        return redirect('all/purchase')->with('success', trans('flash.RequestSuccessfully'));
    }

    public function confirmation()
    {
        return view('front.purchase_history.confirmation');
    }

    public function status(Request $request)
    {
        $order = Order::find($request->id);
        $order->status = $request->status;
        $order->save();

        if ($order->status == 1) {
            $cor = Course::where('id', $order->course_id)->first();
            $user = User::where('id', $order->user_id)->first();
            $body = 'Your application to join the course: ' . $cor->title . ', has been accepted.';
            $notification = NewNotification::create(['body' => $body]);
            $notification->users()->attach(['user_id' => $user->id]);
            if (isset($user->device_token)) {
                $this->send_notification($user->device_token, 'Course Enrollment', $body);
            }

            $progress = CourseProgress::where('course_id', '=', $order->course_id)->where('user_id', $order->user_id)->first();

            if (!isset($progress)) {
                $chapter = CourseChapter::where('course_id', $order->course_id)->get();

                $chapter_id = array();

                foreach ($chapter as $c) {
                    array_push($chapter_id, "$c->id");
                }

                $created_progress = CourseProgress::create(
                    [
                        'course_id' => $order->course_id,
                        'user_id' => $order->user_id,
                        'mark_chapter_id' => [],
                        'all_chapter_id' => $chapter_id,
                        'created_at'  => \Carbon\Carbon::now()->toDateTimeString(),
                        'updated_at'  => \Carbon\Carbon::now()->toDateTimeString(),
                    ]
                );
            }
            
            // Mail::to($user->email)->send(new EnrollCourseMail($user, $cor));

        }

        return response()->json($request->all());
        return redirect('page');
    }

    public function fileImportExport()
    {
        if (Auth::User()->role == 'admin') {
            $orders = Order::whereHas('courses')
                ->with(['courses:id,title'])
                ->where('proof', '!=', null)
                ->get();
        } else {
            $orders = Order::whereHas('courses')
                ->with(['courses:id,title'])
                ->where('proof', '!=', null)
                ->where('instructor_id', '=', Auth::User()->id)
                ->get();
        }

        // dd($orders);

        $filename = now()->format('d-m-Y') . '.xlsx';
        $down = (new FastExcel($orders))->export($filename, function ($order) {
            if ($order->payment_method == '' || $order->payment_method == null) {
                $order->payment_method = 'none';
            }
            if ($order->transaction_id == '' || $order->transaction_id == null) {
                $order->transaction_id = 'none';
            }
            if ($order->total_amount == '' || $order->total_amount == null) {
                $order->total_amount = 'Free';
            }

            return [
                // 'Id' =>,
                'Course Name' => $order->courses->title,
                'User Name' => $order->user->fname . ' ' . $order->user->lname,
                'Order Id' => $order->order_id,
                'Payment Method' => $order->payment_method,
                'Transaction Id' => $order->transaction_id,
                // 'Currency Icon' => $order->currency_icon,
                'Amount' => $order->total_amount,
            ];
        });

        $file = file_get_contents(public_path() . '/' . $filename);
        ob_end_clean();

        $response = response($file, 200, [
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ]);

        // unlink(public_path().'/'.$filename);
        return $response;
    }

    public function order_report()
    {
        $order_total = [
            Order::where('instructor_id', Auth::user()->id)
                ->whereMonth('created_at', '01')
                ->whereYear('created_at', date('Y'))
                ->sum('total_amount'),
            Order::where('instructor_id', Auth::user()->id)
                ->whereMonth('created_at', '02')
                ->whereYear('created_at', date('Y'))
                ->sum('total_amount'),
            Order::where('instructor_id', Auth::user()->id)
                ->whereMonth('created_at', '03')
                ->whereYear('created_at', date('Y'))
                ->sum('total_amount'),
            Order::where('instructor_id', Auth::user()->id)
                ->whereMonth('created_at', '04')
                ->whereYear('created_at', date('Y'))
                ->sum('total_amount'),
            Order::where('instructor_id', Auth::user()->id)
                ->whereMonth('created_at', '05')
                ->whereYear('created_at', date('Y'))
                ->sum('total_amount'),
            Order::where('instructor_id', Auth::user()->id)
                ->whereMonth('created_at', '06')
                ->whereYear('created_at', date('Y'))
                ->sum('total_amount'),
            Order::where('instructor_id', Auth::user()->id)
                ->whereMonth('created_at', '07')
                ->whereYear('created_at', date('Y'))
                ->sum('total_amount'),
            Order::where('instructor_id', Auth::user()->id)
                ->whereMonth('created_at', '08')
                ->whereYear('created_at', date('Y'))
                ->sum('total_amount'),
            Order::where('instructor_id', Auth::user()->id)
                ->whereMonth('created_at', '09')
                ->whereYear('created_at', date('Y'))
                ->sum('total_amount'),
            Order::where('instructor_id', Auth::user()->id)
                ->whereMonth('created_at', '10')
                ->whereYear('created_at', date('Y'))
                ->sum('total_amount'),
            Order::where('instructor_id', Auth::user()->id)
                ->whereMonth('created_at', '11')
                ->whereYear('created_at', date('Y'))
                ->sum('total_amount'),
            Order::where('instructor_id', Auth::user()->id)
                ->whereMonth('created_at', '12')
                ->whereYear('created_at', date('Y'))
                ->sum('total_amount'),
        ];
        $order_data = Order::select(DB::raw('DATE_FORMAT(created_at, "%M") as month'), DB::raw('count(*) as count'), DB::raw('SUM(total_amount) as total_amount'))
            ->whereYear('created_at', date('Y'))
            ->where('refunded', 0)
            ->where('instructor_id', Auth::user()->id)
            ->groupBy(DB::raw('Month(created_at)'))
            ->groupBy(DB::raw('YEAR(created_at)'))
            ->get();
        return view('admin.report.ordertotal', compact('order_total', 'order_data'));
    }
}
