<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use App\Course;
use App\Order;
use Validator;
use DB;
use App\BankTransfer;
use App\Currency;
use App\Cart;
use App\Wishlist;
use Mail;
use App\Mail\SendOrderMail;
use App\Notifications\UserEnroll;
use App\User;
use Notification;
use Carbon\Carbon;
use App\InstructorSetting;
use App\PendingPayout;
use App\Coupon;
use Illuminate\Support\Facades\Hash;
use App\Mail\AdminMailOnOrder;
use TwilioMsg;
use App\Setting;
use App\Notifications\AdminOrder;
use App\Mail\GiftOrder;
use App\ManualPayment;
use App\Http\Traits\SendNotification;
use App\NewNotification;

class PaymentController extends Controller
{
    use SendNotification;

    public function paystore(Request $request)
    {

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

        $auth = Auth::user();

        $currency = Currency::where('default', '=', '1')->first();

        $carts = Cart::where('user_id', $auth->id)->get();

        if ($file = $request->file('proof')) {
            $name = time() . '_' . $file->getClientOriginalName();
            $name = str_replace(" ", "_", $name);
            $file->move('images/order', $name);
            $input['proof'] = $name;
        } else {
            $name = null;
        }


        if ($request->pay_status == 1) {

            foreach ($carts as $cart) {


                if ($cart->offer_price != 0) {
                    $pay_amount =  $cart->offer_price;
                } else {
                    $pay_amount =  $cart->price;
                }

                if ($cart->disamount != 0 || $cart->disamount != NULL) {

                    $cpn_discount =  $cart->disamount;
                } else {

                    $cpn_discount =  '';
                }


                $lastOrder = Order::orderBy('created_at', 'desc')->where('order_id', '!=', null)->first();

                if (!$lastOrder) {
                    // We get here if there is no order at all
                    // If there is no number set it to 0, which will be 1 at the end.
                    $number = 0;
                } else {
                    $number = substr($lastOrder->order_id, 3);
                }

                if ($cart->type == 1) {
                    $bundle_id = $cart->bundle_id;
                    $course_id = NULL;
                    $duration = NULL;
                    $instructor_payout = 0;
                    $instructor_id = $cart->bundle->user_id;

                    if ($cart->bundle->duration_type == "m") {

                        if ($cart->bundle->duration != NULL && $cart->bundle->duration != '') {
                            $days = $cart->bundle->duration * 30;
                            $todayDate = date('Y-m-d');
                            $expireDate = date("Y-m-d", strtotime("$todayDate +$days days"));
                        } else {
                            $todayDate = NULL;
                            $expireDate = NULL;
                        }
                    } else {

                        if ($cart->bundle->duration != NULL && $cart->bundle->duration != '') {
                            $days = $cart->bundle->duration;
                            $todayDate = date('Y-m-d');
                            $expireDate = date("Y-m-d", strtotime("$todayDate +$days days"));
                        } else {
                            $todayDate = NULL;
                            $expireDate = NULL;
                        }
                    }
                } else {

                    if ($cart->courses->duration_type == "m") {

                        if ($cart->courses->duration != NULL && $cart->courses->duration != '') {
                            $days = $cart->courses->duration * 30;
                            $todayDate = date('Y-m-d');
                            $expireDate = date("Y-m-d", strtotime("$todayDate +$days days"));
                        } else {

                            $todayDate = NULL;
                            $expireDate = NULL;
                        }
                    } else {

                        if ($cart->courses->duration != NULL && $cart->courses->duration != '') {
                            $days = $cart->courses->duration;
                            $todayDate = date('Y-m-d');
                            $expireDate = date("Y-m-d", strtotime("$todayDate +$days days"));
                        } else {
                            $todayDate = NULL;
                            $expireDate = NULL;
                        }
                    }


                    $setting = InstructorSetting::first();


                    if ($cart->courses->instructor_revenue != NULL) {

                        $x_amount = $pay_amount * $cart->courses->instructor_revenue;
                        $instructor_payout = $x_amount / 100;
                    } else {


                        if (isset($setting)) {
                            if ($cart->courses->user->role == "instructor") {
                                $x_amount = $pay_amount * $setting->instructor_revenue;
                                $instructor_payout = $x_amount / 100;
                            } else {
                                $instructor_payout = 0;
                            }
                        } else {
                            $instructor_payout = 0;
                        }
                    }



                    $bundle_id = NULL;
                    $course_id = $cart->course_id;
                    $duration = $cart->courses->duration;
                    $instructor_id = $cart->courses->user_id;
                }


                if ($request->payment_method == 'paypal') {

                    $saleId = $request->sale_id;
                } else {

                    $saleId = NULL;
                }

                if ($request->payment_method == 'bank_transfer') {

                    $transaction_id = str_random(32);
                    $status =  '0';
                } else {
                    $manual_payment = ManualPayment::where('name', $request->payment_method)->first();
                    if (isset($manual_payment) && $manual_payment != NULL) {
                        $status = '0';
                    } else {
                        $status =  '1';
                    }

                    $transaction_id = $request->transaction_id;
                }

                $created_order = Order::create(
                    [
                        'course_id' => $course_id,
                        'user_id' => $auth->id,
                        'instructor_id' => $instructor_id,
                        'order_id' => '#' . sprintf("%08d", intval($number) + 1),
                        'transaction_id' => $transaction_id,
                        'payment_method' => $request->payment_method,
                        'total_amount' => $pay_amount,
                        'coupon_discount' => $cpn_discount,
                        'currency' => $currency->currency,
                        'currency_icon' => $currency->icon,
                        'duration' => $duration,
                        'enroll_start' => $todayDate,
                        'enroll_expire' => $expireDate,
                        'bundle_id' => $bundle_id,
                        'sale_id' => $saleId,
                        'status' => $status,
                        'proof' => $name,
                        'created_at'  => \Carbon\Carbon::now()->toDateTimeString(),
                    ]
                );



                if ($cart->type == 1) {
                    Cart::where('user_id', $auth->id)->where('bundle_id', $cart->bundle_id)->delete();
                } else {
                    Wishlist::where('user_id', $auth->id)->where('course_id', $cart->course_id)->delete();
                    Cart::where('user_id', $auth->id)->where('course_id', $cart->course_id)->delete();
                }


                if ($instructor_payout != 0) {
                    if ($created_order) {
                        if ($cart->type == 0) {
                            if ($cart->courses->user->role == "instructor") {

                                $created_payout = PendingPayout::create(
                                    [
                                        'user_id' => $cart->courses->user_id,
                                        'course_id' => $cart->course_id,
                                        'order_id' => $created_order->id,
                                        'transaction_id' => $request->transaction_id,
                                        'total_amount' => $pay_amount,
                                        'currency' => $currency->currency,
                                        'currency_icon' => $currency->icon,
                                        'instructor_revenue' => $instructor_payout,
                                        'created_at'  => \Carbon\Carbon::now()->toDateTimeString(),
                                        'updated_at'  => \Carbon\Carbon::now()->toDateTimeString(),
                                    ]
                                );
                            }
                        }
                    }
                }


                // if ($created_order) {
                //     try {
                //         /*sending email*/
                //         $x = 'You are successfully enrolled in a course';
                //         $order = $created_order;
                //         Mail::to(Auth::User()->email)->send(new SendOrderMail($x, $order));
                //     } catch (\Swift_TransportException $e) {
                //     }
                // }

                // if ($cart->type == 0) {

                //     if ($created_order) {
                //         // Notification when user enroll
                //         $cor = Course::where('id', $cart->course_id)->first();

                //         $course = [
                //             'title' => $cor->title,
                //             'image' => $cor->preview_image,
                //         ];

                //         $enroll = Order::where('course_id', $cart->course_id)->get();

                //         if (!$enroll->isEmpty()) {
                //             foreach ($enroll as $enrol) {
                //                 $user = User::where('id', $enrol->user_id)->get();
                //                 Notification::send($user, new UserEnroll($course));
                //             }
                //         }
                //     }
                // }
            }

            return response()->json('Payment Successfull !', 200);
        } else {

            return response()->json('Payment Failed !', 401);
        }


        return response()->json('Payment Failed !', 401);
    }

    public function purchasehistory(Request $request)
    {

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

        $user = Auth::user();

        $enroll = Order::where('user_id', $user->id)->where('status', 1)->with('courses')->get();

        return response()->json(array('orderhistory' => $enroll), 200);
    }


    public function apikeys(Request $request)
    {

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


        $stripekey =  env('STRIPE_KEY');
        $stripesecret = env('STRIPE_SECRET');

        $paypal_client_id =  env('PAYPAL_CLIENT_ID');
        $paypal_secret = env('PAYPAL_SECRET');
        $paypal_mode =  env('PAYPAL_MODE');

        $instamojo_api_key =  env('IM_API_KEY');
        $instamojo_auth_token = env('IM_AUTH_TOKEN');
        $instamojo_url =  env('IM_URL');

        $razorpay_key =  env('RAZORPAY_KEY');
        $razorpay_secret = env('RAZORPAY_SECRET');

        $paystack_public_key =  env('PAYSTACK_PUBLIC_KEY');
        $paystack_secret = env('PAYSTACK_SECRET_KEY');
        $paystack_pay_url =  env('PAYSTACK_PAYMENT_URL');
        $paystack_merchant_email =  env('PAYSTACK_MERCHANT_EMAIL');

        $paytm_enviroment = env('PAYTM_ENVIRONMENT');
        $paytm_merchant_id =  env('PAYTM_MERCHANT_ID');
        $paytm_merchant_key =  env('PAYTM_MERCHANT_KEY');
        $paytm_merchant_website = env('PAYTM_MERCHANT_WEBSITE');
        $paytm_channel =  env('PAYTM_CHANNEL');
        $paytm_industry_type =  env('PAYTM_INDUSTRY_TYPE');

        $all_keys = [
            'MOLLIE_KEY' => env('MOLLIE_KEY'),
            'SKRILL_MERCHANT_EMAIL' => env('SKRILL_MERCHANT_EMAIL'),
            'SKRILL_API_PASSWORD' => env('SKRILL_API_PASSWORD'),
            'SKRILL_LOGO_URL' => env('SKRILL_LOGO_URL'),
            'RAVE_PUBLIC_KEY' => env('RAVE_PUBLIC_KEY'),
            'RAVE_SECRET_KEY' => env('RAVE_SECRET_KEY'),
            'RAVE_ENVIRONMENT' => env('RAVE_ENVIRONMENT'),
            'RAVE_LOGO' => env('RAVE_LOGO'),
            'RAVE_PREFIX' => env('RAVE_PREFIX'),
            'RAVE_COUNTRY' => env('RAVE_COUNTRY'),
            'RAVE_SECRET_HASH' => env('RAVE_SECRET_HASH'),
            'PAYU_MERCHANT_KEY' => env('PAYU_MERCHANT_KEY'),
            'PAYU_MERCHANT_SALT' => env('PAYU_MERCHANT_SALT'),
            'PAYU_AUTH_HEADER' => env('PAYU_AUTH_HEADER'),
            'PAYU_MONEY_TRUE' => env('PAYU_MONEY_TRUE'),
            'CASHFREE_APP_ID' => env('CASHFREE_APP_ID'),
            'CASHFREE_SECRET_KEY' => env('CASHFREE_SECRET_KEY'),
            'CASHFREE_END_POINT' => env('CASHFREE_END_POINT'),
            'OMISE_PUBLIC_KEY' => env('OMISE_PUBLIC_KEY'),
            'OMISE_SECRET_KEY' => env('OMISE_SECRET_KEY'),
            'OMISE_API_VERSION' => env('OMISE_API_VERSION'),
            'PAYHERE_MERCHANT_ID' => env('PAYHERE_MERCHANT_ID'),
            'PAYHERE_BUISNESS_APP_CODE' => env('PAYHERE_BUISNESS_APP_CODE'),
            'PAYHERE_APP_SECRET' => env('PAYHERE_APP_SECRET'),
            'PAYHERE_MODE' => env('PAYHERE_MODE'),
        ];


        $bank_details = BankTransfer::first();


        return response()->json(array(
            'stripekey' => $stripekey,
            'stripesecret' => $stripesecret,
            'paypal_client_id' => $paypal_client_id,
            'paypal_secret' => $paypal_secret,
            'paypal_mode' => $paypal_mode,
            'instamojo_api_key' => $instamojo_api_key,
            'instamojo_auth_token' => $instamojo_auth_token,
            'instamojo_url' => $instamojo_url,
            'razorpay_key' => $razorpay_key,
            'razorpay_secret' => $razorpay_secret,
            'paystack_public_key' => $paystack_public_key,
            'paystack_secret' => $paystack_secret,
            'paystack_pay_url' => $paystack_pay_url,
            'paystack_merchant_email' => $paystack_merchant_email,
            'paytm_enviroment' => $paytm_enviroment,
            'paytm_merchant_id' => $paytm_merchant_id,
            'paytm_merchant_key' => $paytm_merchant_key,
            'paytm_merchant_website' => $paytm_merchant_website,
            'paytm_channel' => $paytm_channel,
            'paytm_industry_type' => $paytm_industry_type,
            'bank_details' => $bank_details,
            'all_keys' => $all_keys
        ), 200);
    }


    public function enroll(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'secret' => 'required',
            'course_id' => 'required'
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

        $auth = Auth::user();

        $course = Course::where('id', $request->course_id)->first();

        $order = Order::create([
            'user_id' => $auth->id,
            'instructor_id' => $course->user_id,
            'course_id' => $course->id,
            'total_amount' => 'Free',
            'created_at'  => \Carbon\Carbon::now()->toDateTimeString(),
        ]);
        if ($order) {
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
        }

        return response()->json(array('message' => 'User Enrolled', 'status' => 'success'), 200);
    }


    public function giftusercheck(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'secret' => 'required',
            'course_id' => 'required'
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

        $user_check = User::where('email', $request->email)->first();

        if ($user_check == NULL) {
            $password = '123456';

            $user = new User;
            $user->fname = $request->fname;
            $user->lname = $request->lname;
            $user->email = $request->email;
            $user->password = Hash::make($password);
            $user->email_verified_at = \Carbon\Carbon::now()->toDateTimeString();
            $user->save();
        }

        $user_check = User::where('email', $request->email)->first();


        $course = Course::where('id', $request->course_id)->first();



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

        return response()->json(array('course' => $course, 'user' => $user_check), 200);
    }


    public function giftcheckout(Request $request)
    {

        $course = Course::where('id', $request->course_id)->first();

        $user = User::where('id', $request->gift_user_id)->first();


        $gsettings = Setting::first();

        $current_date = Carbon::now();

        $currency = Currency::where('default', '=', '1')->first();


        if ($request->pay_status == '0') {
            $pay_status =  '0';
        } else {
            $pay_status =  1;
        }

        if (isset($request->sale_id)) {
            $saleId = $request->sale_id;
        } else {

            $saleId = NULL;
        }

        if ($file = $request->file('file')) {
            $name = time() . '_' . $file->getClientOriginalName();
            $name = str_replace(" ", "_", $name);
            $file->move('images/order', $name);
            $input['proof'] = $name;
        } else {
            $name = null;
        }



        if ($course->discount_price != 0) {
            $pay_amount =  $course->discount_price;
        } else {
            $pay_amount =  $course->price;
        }


        $cpn_discount =  NULL;



        $lastOrder = Order::orderBy('created_at', 'desc')->where('order_id', '!=', null)->first();

        if (!$lastOrder) {
            // We get here if there is no order at all
            // If there is no number set it to 0, which will be 1 at the end.
            $number = 0;
        } else {
            $number = substr($lastOrder->order_id, 3);
        }



        if ($course->duration_type == "m") {

            if ($course->duration != NULL && $course->duration != '') {
                $days = $course->duration * 30;
                $todayDate = date('Y-m-d');
                $expireDate = date("Y-m-d", strtotime("$todayDate +$days days"));
            } else {
                $todayDate = NULL;
                $expireDate = NULL;
            }
        } else {

            if ($course->duration != NULL && $course->duration != '') {
                $days = $course->duration;
                $todayDate = date('Y-m-d');
                $expireDate = date("Y-m-d", strtotime("$todayDate +$days days"));
            } else {
                $todayDate = NULL;
                $expireDate = NULL;
            }
        }


        $setting = InstructorSetting::first();


        if ($course->instructor_revenue != NULL) {
            $x_amount = $pay_amount * $course->instructor_revenue;
            $instructor_payout = $x_amount / 100;
        } else {

            if (isset($setting)) {
                if ($course->user->role == "instructor") {
                    $x_amount = $pay_amount * $setting->instructor_revenue;
                    $instructor_payout = $x_amount / 100;
                } else {
                    $instructor_payout = 0;
                }
            } else {
                $instructor_payout = 0;
            }
        }



        $bundle_id = NULL;
        $course_id = $course->id;
        $bundle_course_id = NULL;
        $duration = $course->duration;
        $instructor_id = $course->user_id;




        $created_order = Order::create(
            [
                'course_id' => $course->id,
                'user_id' => $user->id,
                'instructor_id' => $instructor_id,
                'order_id' => '#' . sprintf("%08d", intval($number) + 1),
                'transaction_id' => $request->txn_id,
                'payment_method' => $pay_status,
                'total_amount' => $pay_amount,
                'coupon_discount' => $cpn_discount,
                'currency' => $currency->currency,
                'currency_icon' => $currency->icon,
                'duration' => $duration,
                'enroll_start' => $todayDate,
                'enroll_expire' => $expireDate,
                'instructor_revenue' => $instructor_payout,
                'bundle_id' => $bundle_id,
                'bundle_course_id' => $bundle_course_id,
                'sale_id' => $saleId,
                'status' => $pay_status,
                'proof' => $name,
                'created_at'  => \Carbon\Carbon::now()->toDateTimeString(),
            ]
        );



        if ($instructor_payout != 0) {
            if ($created_order) {

                if ($course->user->role == "instructor") {
                    $created_payout = PendingPayout::create(
                        [
                            'user_id' => $course->user_id,
                            'course_id' => $course->id,
                            'order_id' => $created_order->id,
                            'transaction_id' => uniqid(),
                            'total_amount' => $pay_amount,
                            'currency' => $currency->currency,
                            'currency_icon' => $currency->icon,
                            'instructor_revenue' => $instructor_payout,
                            'created_at'  => \Carbon\Carbon::now()->toDateTimeString(),
                            'updated_at'  => \Carbon\Carbon::now()->toDateTimeString(),
                        ]
                    );
                }
            }
        }

        if ($created_order) {
            if ($gsettings->twilio_enable == '1') {

                try {
                    $recipients = $user->mobile;


                    $msg = 'Hey' . ' ' . $user->fname . ' ' .
                        'You\'r successfully enrolled in ' . $course->title .
                        'Thanks' . ' ' . config('app.name');

                    TwilioMsg::sendMessage($msg, $recipients);
                } catch (\Exception $e) {
                }
            }
        }



        if ($created_order) {
            if (env('MAIL_USERNAME') != null) {
                try {

                    /*sending user email*/
                    $x = 'You are successfully enrolled in a course';
                    $order = $created_order;
                    Mail::to($user->email)->send(new SendOrderMail($x, $order));


                    /*sending user email*/
                    $x = 'A Gift for you !!';
                    $order = $created_order;
                    Mail::to($user->email)->send(new GiftOrder($x, $order, $order->id, $course));


                    /*sending admin email*/
                    $x = 'User Enrolled in course ' . $course->title;
                    $order = $created_order;
                    Mail::to($course->user->email)->send(new AdminMailOnOrder($x, $order));
                } catch (\Exception $e) {
                }
            }
        }



        if ($created_order) {
            // Notification when user enroll
            $cor = Course::where('id', $course->id)->first();

            $course = [
                'title' => $cor->title,
                'image' => $cor->preview_image,
            ];



            if ($user->id != NULL) {
                $user = User::where('id', $user->id)->first();
                Notification::send($user, new UserEnroll($course));
            }

            $order_id = $created_order->order_id;
            $url = route('view.order', $created_order->id);

            if ($cor != NULL) {
                $user = User::where('id', $cor->user->id)->first();
                Notification::send($user, new AdminOrder($course, $order_id, $url));
            }
        }



        return response()->json('Payment Successfull !', 200);
    }


    public function stripepay(Request $request)
    {
        $token = $request->token;

        $stripe = new \Stripe\StripeClient(env('STRIPE_SECRET'));

        $user = Auth::user();

        $carts = Cart::where('user_id', $user->id)->get();

        $price_total = 0;
        $offer_total = 0;
        $cpn_discount = 0;


        //cart price after offer
        foreach ($carts as $key => $c) {
            if ($c->offer_price != 0) {
                $offer_total = $offer_total + $c->offer_price;
            } else {
                $offer_total = $offer_total + $c->price;
            }
        }

        //for price total
        foreach ($carts as $key => $c) {

            $price_total = $price_total + $c->price;
        }


        //for coupon discount total
        foreach ($carts as $key => $c) {

            $cpn_discount = $cpn_discount + $c->disamount;
        }


        $cart_total = 0;

        foreach ($carts as $key => $c) {

            if ($cpn_discount != 0) {
                $cart_total = $offer_total - $cpn_discount;
            } else {

                $cart_total = $offer_total;
            }
        }

        $charge = $stripe->charges->create([

            'amount' => $cart_total,
            'currency' => 'usd',
            'source' => $token,
            'description' => 'Enrolling in one time paid courses'

        ]);


        if ($charge['status'] == 'succeeded') {

            $txn_id = $charge['id'];

            $payment_method = 'Stripe';

            $gsettings = Setting::first();

            $currency = Currency::first();


            $carts = Cart::where('user_id', $user->id)->get();

            foreach ($carts as $cart) {

                if ($cart->offer_price != 0) {
                    $pay_amount =  $cart->offer_price;
                } else {
                    $pay_amount =  $cart->price;
                }

                if ($cart->disamount != 0 || $cart->disamount != NULL) {
                    $cpn_discount =  $cart->disamount;
                } else {
                    $cpn_discount =  '';
                }


                $lastOrder = Order::orderBy('created_at', 'desc')->where('order_id', '!=', null)->first();

                if (!$lastOrder) {
                    $number = 0;
                } else {
                    $number = substr($lastOrder->order_id, 3);
                }

                if ($cart->type == 1) {
                    $bundle_id = $cart->bundle_id;
                    $bundle_course_id = $cart->bundle->course_id;
                    $course_id = NULL;
                    $duration = NULL;
                    $instructor_payout = 0;
                    $instructor_id = $cart->bundle->user_id;

                    if ($cart->bundle->duration_type == "m") {

                        if ($cart->bundle->duration != NULL && $cart->bundle->duration != '') {
                            $days = $cart->bundle->duration * 30;
                            $todayDate = date('Y-m-d');
                            $expireDate = date("Y-m-d", strtotime("$todayDate +$days days"));
                        } else {
                            $todayDate = NULL;
                            $expireDate = NULL;
                        }
                    } else {

                        if ($cart->bundle->duration != NULL && $cart->bundle->duration != '') {
                            $days = $cart->bundle->duration;
                            $todayDate = date('Y-m-d');
                            $expireDate = date("Y-m-d", strtotime("$todayDate +$days days"));
                        } else {
                            $todayDate = NULL;
                            $expireDate = NULL;
                        }
                    }
                } else {

                    if ($cart->courses->duration_type == "m") {

                        if ($cart->courses->duration != NULL && $cart->courses->duration != '') {
                            $days = $cart->courses->duration * 30;
                            $todayDate = date('Y-m-d');
                            $expireDate = date("Y-m-d", strtotime("$todayDate +$days days"));
                        } else {
                            $todayDate = NULL;
                            $expireDate = NULL;
                        }
                    } else {

                        if ($cart->courses->duration != NULL && $cart->courses->duration != '') {
                            $days = $cart->courses->duration;
                            $todayDate = date('Y-m-d');
                            $expireDate = date("Y-m-d", strtotime("$todayDate +$days days"));
                        } else {
                            $todayDate = NULL;
                            $expireDate = NULL;
                        }
                    }


                    $setting = InstructorSetting::first();


                    if ($cart->courses->instructor_revenue != NULL) {
                        $x_amount = $pay_amount * $cart->courses->instructor_revenue;
                        $instructor_payout = $x_amount / 100;
                    } else {

                        if (isset($setting)) {
                            if ($cart->courses->user->role == "instructor") {
                                $x_amount = $pay_amount * $setting->instructor_revenue;
                                $instructor_payout = $x_amount / 100;
                            } else {
                                $instructor_payout = 0;
                            }
                        } else {
                            $instructor_payout = 0;
                        }
                    }



                    $bundle_id = NULL;
                    $course_id = $cart->course_id;
                    $bundle_course_id = NULL;
                    $duration = $cart->courses->duration;
                    $instructor_id = $cart->courses->user_id;
                }



                $created_order = Order::create([

                    'course_id' => $course_id,
                    'user_id' => $user->id,
                    'instructor_id' => $instructor_id,
                    'order_id' => '#' . sprintf("%08d", intval($number) + 1),
                    'transaction_id' => $txn_id,
                    'payment_method' => $payment_method,
                    'total_amount' => $pay_amount,
                    'coupon_discount' => $cpn_discount,
                    'currency' => $currency->currency,
                    'currency_icon' => $currency->icon,
                    'duration' => $duration,
                    'enroll_start' => $todayDate,
                    'enroll_expire' => $expireDate,
                    'instructor_revenue' => $instructor_payout,
                    'bundle_id' => $bundle_id,
                    'bundle_course_id' => $bundle_course_id,
                    'sale_id' => NULL,
                    'status' => 1,
                    'proof' => NULL,
                    'created_at'  => now()

                ]);

                Wishlist::where('user_id', $user->id)->where('course_id', $cart->course_id)->delete();

                Cart::where('user_id', $user->id)->delete();


                if ($instructor_payout != 0) {
                    if ($created_order) {
                        if ($cart->type == 0) {
                            if ($cart->courses->user->role == "instructor") {
                                $created_payout = PendingPayout::create(
                                    [
                                        'user_id' => $cart->courses->user_id,
                                        'course_id' => $cart->course_id,
                                        'order_id' => $created_order->id,
                                        'transaction_id' => $txn_id,
                                        'total_amount' => $pay_amount,
                                        'currency' => $currency->currency,
                                        'currency_icon' => $currency->icon,
                                        'instructor_revenue' => $instructor_payout,
                                        'created_at'  => \Carbon\Carbon::now()->toDateTimeString(),
                                        'updated_at'  => \Carbon\Carbon::now()->toDateTimeString(),
                                    ]
                                );
                            }
                        }
                    }
                }

                if ($created_order) {
                    if ($gsettings->twilio_enable == '1') {

                        try {
                            $recipients = $user->mobile;


                            $msg = 'Hey' . ' ' . $user->fname . ' ' .
                                'You\'r successfully enrolled in ' . $cart->courses->title .
                                'Thanks' . ' ' . config('app.name');

                            TwilioMsg::sendMessage($msg, $recipients);
                        } catch (\Exception $e) {
                        }
                    }
                }



                if ($created_order) {
                    if (env('MAIL_USERNAME') != null) {
                        try {

                            /*sending user email*/
                            $x = 'You are successfully enrolled in a course';
                            $order = $created_order;
                            Mail::to(Auth::User()->email)->send(new SendOrderMail($x, $order));


                            /*sending admin email*/
                            $x = 'User Enrolled in course ' . $cart->courses->title;
                            $order = $created_order;
                            Mail::to($cart->courses->user->email)->send(new AdminMailOnOrder($x, $order));
                        } catch (\Exception $e) {
                        }
                    }
                }

                if ($cart->type == 0) {

                    if ($created_order) {
                        // Notification when user enroll
                        $cor = Course::where('id', $cart->course_id)->first();

                        $course = [
                            'title' => $cor->title,
                            'image' => $cor->preview_image,
                        ];

                        $enroll = Order::where('user_id', $user->id)->where('course_id', $cart->course_id)->first();

                        if ($enroll != NULL) {
                            $user = User::where('id', $enroll->user_id)->first();
                            Notification::send($user, new UserEnroll($course));
                        }

                        $order_id = $created_order->order_id;
                        $url = route('view.order', $created_order->id);

                        if ($cor != NULL) {
                            $user = User::where('id', $cor->user_id)->first();
                            Notification::send($user, new AdminOrder($course, $order_id, $url));
                        }
                    }
                }
            }


            return response()->json('Payment Successfull !', 200);
        } else {
            return response()->json('Payment Failed !', 401);
        }
    }
}
