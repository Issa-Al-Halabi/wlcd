<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Language;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use App\Course;
use App\Googlemeet;
use App\JitsiMeeting;
use App\Meeting;
use App\BBL;
use App\WidgetSetting;
use Auth;
use App\UserBankDetail;
use App\WatchCourse;
use Carbon\Carbon;
use App\ManualPayment;
use App\Attandance;
use App\Currency;
use App\Wallet;
use App\WalletTransactions;
use App\Affiliate;
use App\Institute;
use Modules\Homework\Models\Homework;
use Modules\Homework\Models\SubmitHomework;
use App\CourseProgress;
use PDF;
use Module;
use Modules\Resume\Models\Acedemic;
use Modules\Resume\Models\Personalinfo;
use Modules\Resume\Models\Project;
use Modules\Resume\Models\Workexp;
use Modules\Resume\Models\Postjob;
use Modules\Resume\Models\Applyjob;
use App\Setting;


use Session;

class OtherApiController extends Controller
{
    public function siteLanguage(Request $request)
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

        $language = Language::get();

        return response()->json(array('language' => $language), 200);
    }

    public function search(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'secret' => 'required',
            'searchTerm' => 'required'
        ]);

        if ($validator->fails()) {

            $errors = $validator->errors();

            if ($errors->first('secret')) {
                return response()->json(['message' => $errors->first('secret'), 'status' => 'fail']);
            }
            if ($errors->first('searchTerm')) {
                return response()->json(['message' => $errors->first('searchTerm'), 'status' => 'fail']);
            }
        }

        $key = DB::table('api_keys')->where('secret_key', '=', $request->secret)->first();

        if (!$key) {
            return response()->json(['Invalid Secret Key !']);
        }

        $searchTerm = $request->searchTerm;

        $coursequery = Course::query()->with('user');

        if (isset($searchTerm)) {
            $search_data = collect();

            $lang = app()->getLocale();

            if ($lang == 'ar' || $lang == 'ur') {

                $course_title = $coursequery->where('title->' . app()->getLocale(), 'LIKE', '%' . $searchTerm . '%')->paginate(10);
            } else {

                $course_title = $coursequery->where('title', 'LIKE', "%$searchTerm%")->where('status', '=', 1)->paginate(10);
            }


            if (isset($course_title) && count($course_title) > 0) {

                $search_data->push($course_title);
            }

            $course_tags = $coursequery->where('level_tags', 'LIKE', "%$searchTerm%")->where('status', '=', 1)->paginate(10);

            if (isset($course_tags) && count($course_tags) > 0) {

                $search_data->push($course_tags);
            }

            $search_data = $search_data->flatten();

            $courses = Course::search($searchTerm)->with('user')->paginate(10);

            return response()->json(array('courses' => $courses), 200);
        } else {
            return response()->json(array('message' => 'No searchTerm found', 'status' => 'fail'), 200);
        }
    }

    public function meetings(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'secret' => 'required',
        ]);

        if ($validator->fails()) {

            $errors = $validator->errors();

            if ($errors->first('secret')) {
                return response()->json(['message' => $errors->first('secret'), 'status' => 'fail']);
            }
        }

        $key = DB::table('api_keys')->where('secret_key', '=', $request->secret)->first();

        if (!$key) {
            return response()->json(['Invalid Secret Key !']);
        }

        $zoom_meeting = Meeting::where('course_id', '=', NULL)->get();
        $bigblue_meeting = BBL::where('course_id', '=', NULL)->get();
        $google_meet = Googlemeet::where('course_id', '=', NULL)->get();
        $jitsi_meeting = JitsiMeeting::where('course_id', '=', NULL)->get();



        $array_zoom = array($zoom_meeting);
        $array_jitsi = array($jitsi_meeting);

        foreach (array_merge($array_zoom, $array_jitsi) as $item) {
            $all_categories[] = array(
                $item,
            );
        }



        return response()->json(array('result' => $all_categories, 'zoom_meeting' => $zoom_meeting, 'bigblue_meeting' => $bigblue_meeting, 'jitsi_meeting' => $jitsi_meeting, 'google_meet' => $google_meet), 200);
    }

    public function userbankdetail(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'secret' => 'required',
        ]);

        if ($validator->fails()) {

            $errors = $validator->errors();

            if ($errors->first('secret')) {
                return response()->json(['message' => $errors->first('secret'), 'status' => 'fail']);
            }
        }

        $key = DB::table('api_keys')->where('secret_key', '=', $request->secret)->first();

        if (!$key) {
            return response()->json(['Invalid Secret Key !']);
        }


        $user = Auth::user();
        $banks = UserBankDetail::where('user_id', $user->id)->get();


        return response()->json(array('user_bankdetail' => $banks), 200);
    }

    public function addbankdetail(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'secret' => 'required',
            'bank_name' => 'required',
            'ifcs_code' => 'required',
            'account_number' => 'required',
            'account_holder_name' => 'required',
        ]);

        if ($validator->fails()) {

            $errors = $validator->errors();

            if ($errors->first('secret')) {
                return response()->json(['message' => $errors->first('secret'), 'status' => 'fail']);
            }

            if ($errors->first('bank_name')) {
                return response()->json(['message' => $errors->first('bank_name'), 'status' => 'fail']);
            }

            if ($errors->first('ifcs_code')) {
                return response()->json(['message' => $errors->first('ifcs_code'), 'status' => 'fail']);
            }

            if ($errors->first('account_number')) {
                return response()->json(['message' => $errors->first('account_number'), 'status' => 'fail']);
            }

            if ($errors->first('account_holder_name')) {
                return response()->json(['message' => $errors->first('account_holder_name'), 'status' => 'fail']);
            }
        }

        $key = DB::table('api_keys')->where('secret_key', '=', $request->secret)->first();

        if (!$key) {
            return response()->json(['Invalid Secret Key !']);
        }

        $user = Auth::user();

        $bank = new UserBankDetail;
        $bank->user_id = $user->id;
        $bank->bank_name = $request->bank_name;
        $bank->ifcs_code = $request->ifcs_code;
        $bank->account_number = $request->account_number;
        $bank->account_holder_name = $request->account_holder_name;
        $bank->bank_enable = 1;

        $bank->save();


        return response()->json(array('message' => 'Your bank detail has been added successfully', 'status' => 'success'), 200);
    }

    public function updatebankdetail(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'secret' => 'required',
        ]);

        if ($validator->fails()) {

            $errors = $validator->errors();

            if ($errors->first('secret')) {
                return response()->json(['message' => $errors->first('secret'), 'status' => 'fail']);
            }
        }

        $key = DB::table('api_keys')->where('secret_key', '=', $request->secret)->first();

        if (!$key) {
            return response()->json(['Invalid Secret Key !']);
        }

        $user = Auth::user();

        if (UserBankDetail::where('id', $id)->exists()) {
            $data = UserBankDetail::find($id);

            $data->user_id = isset($request->user_id) ? $request->user_id : $data->user_id;
            $data->bank_name = isset($request->bank_name) ? $request->bank_name : $data->bank_name;
            $data->ifcs_code = isset($request->ifcs_code) ? $request->ifcs_code : $data->ifcs_code;
            $data->account_number = isset($request->account_number) ? $request->account_number : $data->account_number;
            $data->account_holder_name = isset($request->account_holder_name) ? $request->account_holder_name : $data->account_holder_name;

            $data->status = isset($request->bank_enable) ? $request->bank_enable : $data->bank_enable;
            $data->save();

            return response()->json([
                "message" => "updated successfully",
                'record' => $data
            ]);
        } else {
            return response()->json([
                "message" => "data not found"
            ], 404);
        }


        return response()->json(array('message' => 'Your bank detail has been added successfully', 'status' => 'success'), 200);
    }


    public function updatelanguage(Request $request, $id)
    {

        $validator = Validator::make($request->all(), [
            'secret' => 'required',
        ]);

        if ($validator->fails()) {

            $errors = $validator->errors();

            if ($errors->first('secret')) {
                return response()->json(['message' => $errors->first('secret'), 'status' => 'fail']);
            }
        }

        $key = DB::table('api_keys')->where('secret_key', '=', $request->secret)->first();

        if (!$key) {
            return response()->json(['Invalid Secret Key !'], 400);
        }

        if (UserBankDetail::where('id', $id)->exists()) {
            $userBank = UserBankDetail::find($id);

            $userBank->bank_name = isset($request->bank_name) ? $request->bank_name : $userBank->bank_name;
            $userBank->ifcs_code = isset($request->ifcs_code) ? $request->ifcs_code : $userBank->ifcs_code;
            $userBank->account_number = isset($request->account_number) ? $request->account_number : $userBank->account_number;
            $userBank->account_holder_name = isset($request->account_holder_name) ? $request->account_holder_name : $userBank->account_holder_name;

            $userBank->save();

            return response()->json([
                "message" => "records updated successfully",
                'userBank' => $userBank
            ]);
        } else {
            return response()->json([
                "message" => "record not found"
            ], 404);
        }
    }

    public function widget(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'secret' => 'required',
        ]);

        if ($validator->fails()) {

            $errors = $validator->errors();

            if ($errors->first('secret')) {
                return response()->json(['message' => $errors->first('secret'), 'status' => 'fail']);
            }
        }

        $key = DB::table('api_keys')->where('secret_key', '=', $request->secret)->first();

        if (!$key) {
            return response()->json(['Invalid Secret Key !']);
        }


        $widget = WidgetSetting::first();

        return response()->json(array('widget' => $widget), 200);
    }

    public function addwatchlist(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'secret' => 'required',
            'course_id' => 'required',
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

        $user = Auth::user();

        $watch = WatchCourse::create(
            [
                'user_id'    => $user->id,
                'course_id'  => $request->course_id,
                'start_time' => \Carbon\Carbon::now()->toDateTimeString(),
                'active'     => '1',
                'created_at' => \Carbon\Carbon::now()->toDateTimeString(),
                'updated_at' => \Carbon\Carbon::now()->toDateTimeString(),
            ]
        );

        return response()->json(array('watchlist' => $watch), 200);
    }

    public function viewwatchlist(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'secret' => 'required',
        ]);

        if ($validator->fails()) {

            $errors = $validator->errors();

            if ($errors->first('secret')) {
                return response()->json(['message' => $errors->first('secret'), 'status' => 'fail']);
            }
        }

        $key = DB::table('api_keys')->where('secret_key', '=', $request->secret)->first();

        if (!$key) {
            return response()->json(['Invalid Secret Key !']);
        }

        $user = Auth::user();

        $watch = WatchCourse::where('user_id', $user->id)->get();

        return response()->json(array('watchlist' => $watch), 200);
    }

    public function deletewatchlist(Request $request)
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

        $user = Auth::user();

        if (WatchCourse::where('course_id', $request->course_id)->where('user_id', $user->id)->exists()) {
            WatchCourse::where('course_id', $request->course_id)->where('user_id', $user->id)->delete();

            return response()->json([
                "message" => "records deleted"
            ]);
        } else {
            return response()->json([
                "message" => "record not found"
            ], 404);
        }
    }

    public function manual(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'secret' => 'required',
        ]);

        if ($validator->fails()) {

            $errors = $validator->errors();

            if ($errors->first('secret')) {
                return response()->json(['message' => $errors->first('secret'), 'status' => 'fail']);
            }
        }

        $payments = ManualPayment::get();

        $result = array();

        foreach ($payments as $data) {

            $result[] = array(
                'id' => $data->id,
                'name' => $data->name,
                'detail' => strip_tags($data->detail),
                'image' => $data->image,
                'image_path' => url('images/manualpayment/' . $data->image),
                'status' => $data->status,
                'created_at' => $data->created_at,
                'updated_at' => $data->updated_at,
            );
        }

        return response()->json(array('manual_payment' => $result), 200);
    }


    public function attandance(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'secret' => 'required',
        ]);
        if ($validator->fails()) {
            $errors = $validator->errors();
            if ($errors->first('secret')) {
                return response()->json(['message' => $errors->first('secret'), 'status' => 'fail']);
            }
        }
        $user = Auth::user();
        $date = Carbon::now();
        //Get date
        $date->toDateString();
        $zoom = Meeting::where('id', $request->meeting_id)->first();
        if ($request->meeting_type == '1') {
            $courseAttandance = Attandance::where('user_id', $user->id)->where('zoom_id', $request->meeting_id)->first();
            if (!$courseAttandance) {
                $attanded = Attandance::create(
                    [
                        'user_id'    => Auth::user()->id,
                        'zoom_id'  => $zoom->id,
                        'instructor_id' => $zoom->user_id,
                        'date'     => $date->toDateString(),
                        'created_at' => \Carbon\Carbon::now()->toDateTimeString(),
                        'updated_at' => \Carbon\Carbon::now()->toDateTimeString(),
                    ]
                );
                return response()->json(array('attanded' => $attanded));
            }
        }
        $googlemeet = Googlemeet::where('id', $request->meeting_id)->first();
        if ($request->meeting_type == '2') {
            $courseAttandance = Attandance::where('user_id', $user->id)->where('googlemeet_id', $request->meeting_id)->first();
            if (!$courseAttandance) {
                $attanded = Attandance::create(
                    [
                        'user_id'    => Auth::user()->id,
                        'zoom_id'  => $googlemeet->id,
                        'instructor_id' => $googlemeet->user_id,
                        'date'     => $date->toDateString(),
                        'created_at' => \Carbon\Carbon::now()->toDateTimeString(),
                        'updated_at' => \Carbon\Carbon::now()->toDateTimeString(),
                    ]
                );
                return response()->json(array('attanded' => $attanded));
            }
        }
        $jitsimeetings = JitsiMeeting::where('meeting_id', '=', $request->meeting_id)->first();
        if ($request->meeting_type == '3') {
            $courseAttandance = Attandance::where('user_id', $user->id)->where('jitsi_id', $request->meeting_id)->first();
            if (!$courseAttandance) {
                $attanded = Attandance::create(
                    [
                        'user_id'    => Auth::user()->id,
                        'zoom_id'  => $jitsimeetings->id,
                        'instructor_id' => $jitsimeetings->user_id,
                        'date'     => $date->toDateString(),
                        'created_at' => \Carbon\Carbon::now()->toDateTimeString(),
                        'updated_at' => \Carbon\Carbon::now()->toDateTimeString(),
                    ]
                );
                return response()->json(array('attanded' => $attanded));
            }
        }
        $bigblue = BBL::where('meetingid', $request->meeting_id)->first();
        if ($request->meeting_type == '4') {
            $courseAttandance = Attandance::where('user_id', $user->id)->where('bbl_id', $request->meeting_id)->first();
            if (!$courseAttandance) {
                $attanded = Attandance::create(
                    [
                        'user_id'    => Auth::user()->id,
                        'zoom_id'  => $bigblue->id,
                        'instructor_id' => $bigblue->user_id,
                        'date'     => $date->toDateString(),
                        'created_at' => \Carbon\Carbon::now()->toDateTimeString(),
                        'updated_at' => \Carbon\Carbon::now()->toDateTimeString(),
                    ]
                );
                return response()->json(array('attanded' => $attanded));
            }
        }
    }


    public function currencies(Request $request)
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

        $currencies = Currency::get();

        return response()->json(array('currencies' => $currencies), 200);
    }

    public function currency_rates(Request $request, $code)
    {

        $validator = Validator::make($request->all(), [
            'secret' => 'required',
            'amount' => 'required',
            'currency_from' => 'required',
            'currency_to' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['Secret Key is required']);
        }

        $key = DB::table('api_keys')->where('secret_key', '=', $request->secret)->first();

        if (!$key) {
            return response()->json(['Invalid Secret Key !']);
        }

        $currency = currency($request->price, $from = $currency_from, $to = $currency_to, $format = true);

        return response()->json(array('currency' => $currency), 200);
    }

    public function getWallet(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'secret' => 'required',
        ]);

        if ($validator->fails()) {

            $errors = $validator->errors();

            if ($errors->first('secret')) {
                return response()->json(['message' => $errors->first('secret'), 'status' => 'fail']);
            }
        }

        $key = DB::table('api_keys')->where('secret_key', '=', $request->secret)->first();

        if (!$key) {
            return response()->json(['Invalid Secret Key !']);
        }
        $user = Auth::user();
        $wallet = Wallet::where('user_id', $user->id)->get();
        return response()->json(array('walletdetails' => $wallet), 200);
    }

    public function getWalletTransactions(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'secret' => 'required',
        ]);

        if ($validator->fails()) {

            $errors = $validator->errors();

            if ($errors->first('secret')) {
                return response()->json(['message' => $errors->first('secret'), 'status' => 'fail']);
            }
        }

        $key = DB::table('api_keys')->where('secret_key', '=', $request->secret)->first();

        if (!$key) {
            return response()->json(['Invalid Secret Key !']);
        }
        $user = Auth::user();
        $WalletTransactions = WalletTransactions::where('user_id', $user->id)->get();
        return response()->json(array('WalletTransactions' => $WalletTransactions), 200);
    }

    public function getAffiliate(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'secret' => 'required',
        ]);

        if ($validator->fails()) {

            $errors = $validator->errors();

            if ($errors->first('secret')) {
                return response()->json(['message' => $errors->first('secret'), 'status' => 'fail']);
            }
        }

        $key = DB::table('api_keys')->where('secret_key', '=', $request->secret)->first();

        if (!$key) {
            return response()->json(['Invalid Secret Key !']);
        }
        $user = Auth::user();
        $Affiliate = Affiliate::get();
        return response()->json(array('Affiliate' => $Affiliate), 200);
    }

    public function getInstitute(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'secret' => 'required',
        ]);

        if ($validator->fails()) {

            $errors = $validator->errors();

            if ($errors->first('secret')) {
                return response()->json(['message' => $errors->first('secret'), 'status' => 'fail']);
            }
        }

        $key = DB::table('api_keys')->where('secret_key', '=', $request->secret)->first();

        if (!$key) {
            return response()->json(['Invalid Secret Key !']);
        }
        $user = Auth::user();
        $Institute = Institute::where('user_id', $user->id)->get();
        return response()->json(array('Institute' => $Institute), 200);
    }

    public function getHomework(Request $request)
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
        $user = Auth::user();

        $Homework = Homework::select('homework.id as id', 'homework.title as title', 'homework.description as description', 'homework.pdf as pdf', 'homework.compulsory as compulsory', 'submit_homework.homework as homework', 'submit_homework.remark as remark', 'submit_homework.marks as marks', \DB::raw('(CASE 
        WHEN submit_homework.id IS NULL THEN "0" ELSE "1" END) AS is_submit'), DB::raw("DATEDIFF(homework.endtime,CURDATE())AS Days"))->leftJoin('submit_homework', 'submit_homework.homework_id', '=', 'homework.id')->where('homework.status', '=', 1)->where('homework.course_id', $request->course_id)->get();

        return response()->json(array('Homework' => $Homework), 200);
    }


    public function submitHomework(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'homework_id' => 'required',
            'course_id' => 'required',
            'detail' => 'required',
            'homework' => 'required',
        ]);

        if ($validator->fails()) {

            $errors = $validator->errors();

            if ($errors->first('homework_id')) {
                return response()->json(['message' => $errors->first('homework_id'), 'status' => 'fail']);
            }

            if ($errors->first('course_id')) {
                return response()->json(['message' => $errors->first('course_id'), 'status' => 'fail']);
            }

            if ($errors->first('detail')) {
                return response()->json(['message' => $errors->first('detail'), 'status' => 'fail']);
            }

            if ($errors->first('homework')) {
                return response()->json(['message' => $errors->first('homework'), 'status' => 'fail']);
            }
        }

        $key = DB::table('api_keys')->where('secret_key', '=', $request->secret)->first();

        if (!$key) {
            return response()->json(['Invalid Secret Key !']);
        }

        $user = Auth::user();
        $filename = '';
        if ($file = $request->file('homework')) {

            $filename = time() . '_' . $file->getClientOriginalName();
            $filename = str_replace(" ", "_", $filename);
            $file->move('files/Homework/', $filename);
            $courseclass['homework'] = $filename;
        }
        $submitHomework = SubmitHomework::create(
            [
                'user_id'    => $user->id,
                'homework_id' => $request->homework_id,
                'course_id'  => $request->course_id,
                'detail'  => $request->detail,
                'homework' => $filename,
            ]
        );
        return response()->json(array('submitHomework' => $submitHomework), 200);
    }


    public function getSpecificHomework(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'secret' => 'required',
        ]);

        if ($validator->fails()) {

            $errors = $validator->errors();

            if ($errors->first('secret')) {
                return response()->json(['message' => $errors->first('secret'), 'status' => 'fail']);
            }
        }

        $key = DB::table('api_keys')->where('secret_key', '=', $request->secret)->first();

        if (!$key) {
            return response()->json(['Invalid Secret Key !']);
        }
        if (Homework::where('id', $id)->exists()) {
            $user = Auth::user();
            $Homework = Homework::select('homework.id as id', 'homework.pdf as pdf')->where('id', $id)->get();
            return response()->json(array('Homework' => $Homework), 200);
        } else {
            return response()->json([
                "message" => "data not found"
            ], 404);
        }
    }

    public function getAnswer(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'secret' => 'required',
        ]);

        if ($validator->fails()) {

            $errors = $validator->errors();

            if ($errors->first('secret')) {
                return response()->json(['message' => $errors->first('secret'), 'status' => 'fail']);
            }
        }

        $key = DB::table('api_keys')->where('secret_key', '=', $request->secret)->first();

        if (!$key) {
            return response()->json(['Invalid Secret Key !']);
        }
        if (Homework::where('id', $id)->exists()) {
            $user = Auth::user();
            $Homework = SubmitHomework::select('submit_homework.id as id', 'submit_homework.homework as answer')->where('id', $id)->get();
            return response()->json(array('Answer' => $Homework), 200);
        } else {
            return response()->json([
                "message" => "data not found"
            ], 404);
        }
    }

    public function getCertificate($progress_id)
    {
        // $user = Auth::user();

        $progress = CourseProgress::where('id', $progress_id)->first();
        $course = Course::where('id', $progress->course_id)->first();

        if ($progress == NULL || $progress->mark_chapter_id != $progress->all_chapter_id) {
            return response()->json(['Please Complete your course to get certificate !'], 400);
        }
        $random = $progress->id . 'CR-' . uniqid();

        $serial_no = $random;

        $whatIWant = strtok($random, 'CR-');


        $pdf = PDF::loadView(
            'front.certificate.download',
            compact('course', 'progress', 'serial_no'),
            [],
            [
                'title' => 'Certificate',
                'orientation' => 'L'
            ]
        );

        return $pdf->download('certificate.pdf');
    }

    public function homeModules()
    {

        $setting = Setting::first();
        $is_homemodule = 0;
        $is_resumemodules = 0;
        $is_certicifate = 0;
        $is_forum = 0;
        // $home_modules = array();
        if (Module::has('Homework') &&  Module::find('Homework')->isEnabled()) {
            $is_homemodule = 1;
        }
        if (Module::has('Resume') &&  Module::find('Resume')->isEnabled()) {
            $is_resumemodules = 1;
        }
        if (Module::has('Certificate') &&  Module::find('Certificate')->isEnabled()) {
            $is_certicifate = 1;
        }
        if (Module::has('Forum') &&  Module::find('Forum')->isEnabled() && $setting->forum_enable == 1) {
            $is_forum = 1;
        }
        // $home_modules = array('Homework'=> $is_homemodule, 'Resume'=> $is_resumemodules, 'Certificate'=> $is_certicifate, 'forum'=> $is_forum);
        return response()->json(array('Homework' => $is_homemodule, 'Resume' => $is_resumemodules, 'Certificate' => $is_certicifate, 'Forum' => $is_forum), 200);
    }

    public function addResumeDetails(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'secret' => 'required',
            'fname' => 'required',
            'lname' => 'required',
            'profession' => 'required',
            'country' => 'required',
            'address' => 'required',
            'phone' => 'required',
            'email' => 'required',
            'skill' => 'required',
            'strength' => 'required',
            'interest' => 'required',
            'objective' => 'required',
            'language' => 'required',
        ]);

        if ($validator->fails()) {

            $errors = $validator->errors();

            if ($errors->first('secret')) {
                return response()->json(['message' => $errors->first('secret'), 'status' => 'fail']);
            }

            if ($errors->first('fname')) {
                return response()->json(['message' => $errors->first('fname'), 'status' => 'fail']);
            }

            if ($errors->first('lname')) {
                return response()->json(['message' => $errors->first('lname'), 'status' => 'fail']);
            }

            if ($errors->first('profession')) {
                return response()->json(['message' => $errors->first('profession'), 'status' => 'fail']);
            }

            if ($errors->first('country')) {
                return response()->json(['message' => $errors->first('country'), 'status' => 'fail']);
            }

            if ($errors->first('address')) {
                return response()->json(['message' => $errors->first('address'), 'status' => 'fail']);
            }

            if ($errors->first('phone')) {
                return response()->json(['message' => $errors->first('phone'), 'status' => 'fail']);
            }

            if ($errors->first('email')) {
                return response()->json(['message' => $errors->first('email'), 'status' => 'fail']);
            }

            if ($errors->first('skill')) {
                return response()->json(['message' => $errors->first('skill'), 'status' => 'fail']);
            }

            if ($errors->first('strength')) {
                return response()->json(['message' => $errors->first('strength'), 'status' => 'fail']);
            }

            if ($errors->first('interest')) {
                return response()->json(['message' => $errors->first('interest'), 'status' => 'fail']);
            }

            if ($errors->first('objective')) {
                return response()->json(['message' => $errors->first('objective'), 'status' => 'fail']);
            }

            if ($errors->first('language')) {
                return response()->json(['message' => $errors->first('language'), 'status' => 'fail']);
            }
        }

        $persoanl['fname']      = strip_tags($request->fname);
        $persoanl['lname']      = strip_tags($request->lname);
        $persoanl['profession'] = strip_tags($request->profession);
        $persoanl['country']    = strip_tags($request->country);
        $persoanl['address']    = strip_tags($request->address);
        $persoanl['phone']      = strip_tags($request->phone);
        $persoanl['email']      = strip_tags($request->email);
        $persoanl['skill']      = strip_tags($request->skill);
        $persoanl['strength']   = strip_tags($request->strength);
        $persoanl['interest']   = strip_tags($request->interest);
        $persoanl['objective']  = strip_tags($request->objective);
        $persoanl['language']   = strip_tags($request->language);
        if ($file = $request->file('photo')) {
            $validator = Validator::make(
                [
                    'file' => strip_tags($request->photo),
                    'extension' => strtolower($request->photo->getClientOriginalExtension()),
                ],
                [
                    'file' => 'required',
                    'extension' => 'required|in:jpg,png',
                ]
            );
            if ($validator->fails()) {
                return back()->withErrors(__('Invalid file !'));
            }
            if ($file = $request->file('photo')) {
                $name = time() . '_' . $file->getClientOriginalName();
                $name = str_replace(" ", "_", $name);
                $file->move('files/resume', $name);
                $persoanl['image'] = $name;
            }
        }

        /** foreach for acedmic **/
        if (!empty($request->course)) {
            foreach ($request->course as $key => $course) {

                Acedemic::create([
                    'user_id'       => Auth::user()->id,
                    'course'        => strip_tags($request->course[$key]),
                    'school'        => strip_tags($request->school[$key]),
                    'marks'         => strip_tags($request->marks[$key]),
                    'yearofpassing' => strip_tags($request->yearofpassing[$key]),
                ]);
            }
        }
        /** foreach for workexp **/
        if (!empty($request->startdate)) {
            foreach ($request->startdate as $key => $course) {
                Workexp::create([
                    'user_id'       => Auth::user()->id,
                    'startdate'     => strip_tags($request->startdate[$key]),
                    'enddate'       => strip_tags($request->enddate[$key]),
                    'city'          => strip_tags($request->city[$key]),
                    'state'         => strip_tags($request->state[$key]),
                    'jobtitle'      => strip_tags($request->jobtitle[$key]),
                    'employer'      => strip_tags($request->employer[$key]),
                ]);
            }
        }

        /** foreach for project **/
        if (!empty($request->projecttitle)) {
            foreach ($request->projecttitle as $key => $course) {
                Project::create([
                    'user_id' => Auth::user()->id,
                    'projecttitle' => strip_tags($request->projecttitle[$key]),
                    'role' => strip_tags($request->role[$key]),
                    'description' => strip_tags($request->description[$key]),
                ]);
            }
        }
        $data = Personalinfo::create($persoanl);

        return response()->json(array('Create Resume Details' => $data), 200);
    }

    public function updateResumeDetails(Request $request, $id)
    {
        $data = Personalinfo::where('user_id', $id)->first();
        $persoanl['fname']      = strip_tags($request->fname);
        $persoanl['lname']      = strip_tags($request->lname);
        $persoanl['profession'] = strip_tags($request->profession);
        $persoanl['country']    = strip_tags($request->country);
        $persoanl['address']    = strip_tags($request->address);
        $persoanl['phone']      = strip_tags($request->phone);
        $persoanl['email']      = strip_tags($request->email);
        $persoanl['skill']      = strip_tags($request->skill);
        $persoanl['strength']   = strip_tags($request->strength);
        $persoanl['interest']   = strip_tags($request->interest);
        $persoanl['objective']  = strip_tags($request->objective);
        $persoanl['language']   = strip_tags($request->language);
        if ($file = $request->file('photo')) {
            $validator = Validator::make(
                [
                    'file' => strip_tags($request->photo),
                    'extension' => strtolower($request->photo->getClientOriginalExtension()),
                ],
                [
                    'file' => 'required',
                    'extension' => 'required|in:jpg,png',
                ]
            );
            if ($validator->fails()) {
                return back()->withErrors(__('Invalid file !'));
            }
            if ($file = $request->file('photo')) {
                $name = time() . '_' . $file->getClientOriginalName();
                $name = str_replace(" ", "_", $name);
                $file->move('files/resume', $name);
                $persoanl['image'] = $name;
            }
        }

        /** foreach for acedmic **/
        if (!empty($request->course)) {
            Acedemic::where('user_id', Auth::user()->id)->delete();
            foreach ($request->course as $key => $course) {

                Acedemic::create([
                    'user_id'       => Auth::user()->id,
                    'course'        => strip_tags($request->course[$key]),
                    'school'        => strip_tags($request->school[$key]),
                    'marks'         => strip_tags($request->marks[$key]),
                    'yearofpassing' => strip_tags($request->yearofpassing[$key]),
                ]);
            }
        }
        /** foreach for workexp **/
        if (!empty($request->startdate)) {
            Workexp::where('user_id', Auth::user()->id)->delete();
            foreach ($request->startdate as $key => $course) {
                Workexp::create([
                    'user_id'       => Auth::user()->id,
                    'startdate'     => strip_tags($request->startdate[$key]),
                    'enddate'       => strip_tags($request->enddate[$key]),
                    'city'          => strip_tags($request->city[$key]),
                    'state'         => strip_tags($request->state[$key]),
                    'jobtitle'      => strip_tags($request->jobtitle[$key]),
                    'employer'      => strip_tags($request->employer[$key]),
                ]);
            }
        }

        /** foreach for project **/
        if (!empty($request->projecttitle)) {
            Project::where('user_id', Auth::user()->id)->delete();
            foreach ($request->projecttitle as $key => $course) {
                Project::create([
                    'user_id' => Auth::user()->id,
                    'projecttitle' => strip_tags($request->projecttitle[$key]),
                    'role' => strip_tags($request->role[$key]),
                    'description' => strip_tags($request->description[$key]),
                ]);
            }
        }
        $data->update($persoanl);

        Session::flash('success', __('Resume edit successfully'));
        return response()->json(array('Update Resume Details' => $data), 200);
    }

    public function viewResumeDetails(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'secret' => 'required',
        ]);

        if ($validator->fails()) {

            $errors = $validator->errors();

            if ($errors->first('secret')) {
                return response()->json(['message' => $errors->first('secret'), 'status' => 'fail']);
            }
        }

        $key = DB::table('api_keys')->where('secret_key', '=', $request->secret)->first();

        if (!$key) {
            return response()->json(['Invalid Secret Key !']);
        }
        $persoanl = Personalinfo::where('user_id', $id)->firstorfail();
        $works = Workexp::where('user_id', $id)->get();
        $education = Acedemic::where('user_id', $id)->get();
        $project = Project::where('user_id', $id)->get();

        return response()->json(array('persoanl' => $persoanl, "works" => $works, "education" => $education, "project" => $project), 200);
    }


    public function createPostJob(Request $request)
    {
        $request->validate([
            'companyname' => 'required',
            'title' => 'required',
            'description' => 'required',
            'experience' => 'required',
            'minexp' => 'required',
            'maxexp' => 'required',
            'location' => 'required',
            'requirement' => 'required',
            'role' => 'required',
            'industry_type' => 'required',
            'employment_type' => 'required',
            'skills' => 'required',
        ]);

        $job['user_id'] = Auth::user()->id;
        $job['companyname'] = strip_tags($request->companyname);
        $job['title'] = strip_tags($request->title);
        $job['description'] = clean($request->description);
        $job['experience'] = strip_tags($request->experience);
        $job['min_experience'] = strip_tags($request->minexp);
        $job['max_experience'] = strip_tags($request->maxexp);
        $job['location'] = strip_tags($request->location);
        $job['requirement'] = strip_tags($request->requirement);
        $job['role'] = strip_tags($request->role);
        $job['industry_type'] = strip_tags($request->industry_type);
        $job['employment_type'] = strip_tags($request->employment_type);
        $job['salary'] = strip_tags($request->salary);
        $job['min_salary'] = strip_tags($request->minsalary);
        $job['max_salary'] = strip_tags($request->maxsalary);
        $job['skills'] = strip_tags($request->skills);

        if ($file = $request->file('image')) {

            $validator = Validator::make(
                [
                    'file' => strip_tags($request->image),
                    'extension' => strtolower($request->image->getClientOriginalExtension()),
                ],
                [
                    'file' => 'required',
                    'extension' => 'required|in:jpg,png',
                ]
            );

            if ($validator->fails()) {
                return back()->withErrors(__('Invalid file !'));
            }

            if ($file = $request->file('image')) {
                $name = time() . '_' . $file->getClientOriginalName();
                $name = str_replace(" ", "_", $name);
                $file->move('files/job', $name);
                $job['image'] = $name;
            }
        }

        Postjob::create($job);
        $data = Postjob::create($job);
        return response()->json(array('Create Resume Details' => $data), 200);
    }

    public function JobList(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'secret' => 'required',
        ]);

        if ($validator->fails()) {

            $errors = $validator->errors();

            if ($errors->first('secret')) {
                return response()->json(['message' => $errors->first('secret'), 'status' => 'fail']);
            }
        }

        $key = DB::table('api_keys')->where('secret_key', '=', $request->secret)->first();

        if (!$key) {
            return response()->json(['Invalid Secret Key !']);
        }
        $jobs = Postjob::where('user_id', $id)->get();
        return response()->json(array("Posted Jobs" => $jobs), 200);
    }

    public function updateJobList(Request $request, $id)
    {
        $request->validate([
            'companyname' => 'required',
            'title' => 'required',
            'description' => 'required',
            'experience' => 'required',
            'minexp' => 'required',
            'maxexp' => 'required',
            'location' => 'required',
            'requirement' => 'required',
            'role' => 'required',
            'industry_type' => 'required',
            'employment_type' => 'required',
            'skills' => 'required',
        ]);

        $data = Postjob::where('id', $id)->first();
        $job['user_id'] = Auth::user()->id;
        $job['companyname'] = strip_tags($request->companyname);
        $job['title'] = strip_tags($request->title);
        $job['description'] = clean($request->description);
        $job['experience'] = strip_tags($request->experience);
        $job['min_experience'] = strip_tags($request->minexp);
        $job['max_experience'] = strip_tags($request->maxexp);
        $job['years'] = strip_tags($request->years);
        $job['location'] = strip_tags($request->location);
        $job['requirement'] = strip_tags($request->requirement);
        $job['role'] = strip_tags($request->role);
        $job['industry_type'] = strip_tags($request->industry_type);
        $job['employment_type'] = strip_tags($request->employment_type);
        $job['salary'] = strip_tags($request->salary);
        $job['min_salary'] = strip_tags($request->minsalary);
        $job['max_salary'] = strip_tags($request->maxsalary);
        $job['skills'] = strip_tags($request->skills);

        if ($file = $request->file('image')) {

            $validator = Validator::make(
                [
                    'file' => strip_tags($request->image),
                    'extension' => strtolower($request->image->getClientOriginalExtension()),
                ],
                [
                    'file' => 'required',
                    'extension' => 'required|in:jpg,png',
                ]
            );

            if ($validator->fails()) {
                return back()->withErrors(__('Invalid file !'));
            }

            if ($file = $request->file('image')) {
                $name = time() . '_' . $file->getClientOriginalName();
                $name = str_replace(" ", "_", $name);
                $file->move('files/job', $name);
                $job['image'] = $name;
            }
        }

        $data->update($job);
        // Session::flash('success', __('Job update successfully'));
        return response()->json(array("Update Posted Jobs" => $data), 200);
    }


    public function Jobview(Request $request, $jobid)
    {
        $validator = Validator::make($request->all(), [
            'secret' => 'required',
        ]);

        if ($validator->fails()) {

            $errors = $validator->errors();

            if ($errors->first('secret')) {
                return response()->json(['message' => $errors->first('secret'), 'status' => 'fail']);
            }
        }

        $key = DB::table('api_keys')->where('secret_key', '=', $request->secret)->first();

        if (!$key) {
            return response()->json(['Invalid Secret Key !']);
        }
        $jobs = Postjob::where('id', $jobid)->get();
        // $job = Postjob::findorfail($jobid);
        return response()->json(array("view Jobs" => $jobs), 200);
    }

    public function jobdestroy(Request $request, $id)
    {

        $validator = Validator::make($request->all(), [
            'secret' => 'required',
        ]);


        if ($validator->fails()) {

            $errors = $validator->errors();

            if ($errors->first('secret')) {
                return response()->json(['message' => $errors->first('secret'), 'status' => 'fail']);
            }
        }

        $key = DB::table('api_keys')->where('secret_key', '=', $request->secret)->first();

        if (!$key) {
            return response()->json(['Invalid Secret Key !']);
        }

        $job = Postjob::where('id', $id)->first();
        if (!empty($job)) {
            $job->postjob()->delete();
            $job->delete();
            return response()->json(['message' => 'Delete Successfully', 'status' => 'success']);
        } else {
            return response()->json(['message' => 'data not found', 'status' => 'fail']);
        }
    }


    public function userstatus(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'secret' => 'required',
        ]);


        if ($validator->fails()) {

            $errors = $validator->errors();

            if ($errors->first('secret')) {
                return response()->json(['message' => $errors->first('secret'), 'status' => 'fail']);
            }
        }

        $key = DB::table('api_keys')->where('secret_key', '=', $request->secret)->first();

        if (!$key) {
            return response()->json(['Invalid Secret Key !']);
        }

        $user = Auth::user();

        $job = Postjob::where('id', strip_tags($request->id))->where('user_id', $user->id)->first();
        if (!empty($job)) {
            $job->status = strip_tags($request->status);
            $job->save();
            return response()->json(['message' => 'update status successfully', 'status' => 'success']);
        } else {
            return response()->json(['message' => 'data not found', 'status' => 'fail']);
        }
    }


    public function searchfind(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'secret' => 'required',
        ]);

        if ($validator->fails()) {

            $errors = $validator->errors();

            if ($errors->first('secret')) {
                return response()->json(['message' => $errors->first('secret'), 'status' => 'fail']);
            }
        }

        $key = DB::table('api_keys')->where('secret_key', '=', $request->secret)->first();

        if (!$key) {
            return response()->json(['Invalid Secret Key !']);
        }


        /* Intitialize Query Builder */
        $postjob = Postjob::query();

        if ($request->search) {

            $result = $postjob->where("skills", "LIKE", '%' . strip_tags($request->search) . '%')
                ->orWhere("companyname", "LIKE", '%' . strip_tags($request->search) . '%')
                ->orWhere("title", "LIKE", '%' . strip_tags($request->search) . '%');
        } else {
            $result = $postjob->where('status', '1')
                ->where('approved', '1')
                ->orderBy('id', 'DESC');
        }

        $result = $postjob->paginate(10);
        return response()->json(array("List of Jobs" => $result), 200);
    }

    public function locationfilter(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'secret' => 'required',
        ]);

        if ($validator->fails()) {

            $errors = $validator->errors();

            if ($errors->first('secret')) {
                return response()->json(['message' => $errors->first('secret'), 'status' => 'fail']);
            }
        }

        $key = DB::table('api_keys')->where('secret_key', '=', $request->secret)->first();

        if (!$key) {
            return response()->json(['Invalid Secret Key !']);
        }

        if ($request->location) {

            $result = Postjob::whereIN('location', $request->location)
                ->where('status', '1')
                ->where('approved', '1')
                ->paginate(10);
        } else {
            $result = Postjob::where('status', '1')
                ->where('approved', '1')
                ->paginate(10);
        }

        return response()->json(array("List of Jobs" => $result), 200);
    }

    public function allcompanylist(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'secret' => 'required',
        ]);

        if ($validator->fails()) {

            $errors = $validator->errors();

            if ($errors->first('secret')) {
                return response()->json(['message' => $errors->first('secret'), 'status' => 'fail']);
            }
        }

        $key = DB::table('api_keys')->where('secret_key', '=', $request->secret)->first();

        if (!$key) {
            return response()->json(['Invalid Secret Key !']);
        }

        $result = Postjob::select('companyname')->distinct()->get();


        return response()->json(array("List of Company" => $result), 200);
    }


    public function allcountrystatelist(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'secret' => 'required',
        ]);

        if ($validator->fails()) {

            $errors = $validator->errors();

            if ($errors->first('secret')) {
                return response()->json(['message' => $errors->first('secret'), 'status' => 'fail']);
            }
        }

        $key = DB::table('api_keys')->where('secret_key', '=', $request->secret)->first();

        if (!$key) {
            return response()->json(['Invalid Secret Key !']);
        }

        $result = Postjob::select('location')->distinct()->where('status', '1')
            ->where('approved', '1')->get();

        return response()->json(array("List of Countrystates" => $result), 200);
    }

    public function viewjobcreatedbyuser(Request $request, $jobid)
    {
        $validator = Validator::make($request->all(), [
            'secret' => 'required',
        ]);

        if ($validator->fails()) {

            $errors = $validator->errors();

            if ($errors->first('secret')) {
                return response()->json(['message' => $errors->first('secret'), 'status' => 'fail']);
            }
        }

        $key = DB::table('api_keys')->where('secret_key', '=', $request->secret)->first();

        if (!$key) {
            return response()->json(['Invalid Secret Key !']);
        }
        $user = Auth::user();

        $jobs = Postjob::where('id', $jobid)->where('user_id', $user->id)->get();
        // $job = Postjob::findorfail($jobid);
        return response()->json(array("view Jobs" => $jobs), 200);
    }

    public function applyJobs(Request $request, $jobid)
    {
        $validator = Validator::make($request->all(), [
            'secret' => 'required',
            'skills' => 'required',
            'experiense' => 'required',
            'years' => 'required',

        ]);

        if ($validator->fails()) {

            $errors = $validator->errors();

            if ($errors->first('secret')) {
                return response()->json(['message' => $errors->first('secret'), 'status' => 'fail']);
            }
            if ($errors->first('skills')) {
                return response()->json(['message' => $errors->first('skills'), 'status' => 'fail']);
            }
            if ($errors->first('experiense')) {
                return response()->json(['message' => $errors->first('experiense'), 'status' => 'fail']);
            }
        }

        $key = DB::table('api_keys')->where('secret_key', '=', $request->secret)->first();

        if (!$key) {
            return response()->json(['Invalid Secret Key !']);
        }


        $applyjob['skills'] = strip_tags($request->skills);
        $applyjob['experiense'] = strip_tags($request->experience);
        $applyjob['years'] = strip_tags($request->years);
        $applyjob['job_id'] = $jobid;
        $applyjob['user_id'] = Auth::user()->id;

        if ($file = $request->file('pdf')) {

            $validator = Validator::make(
                [
                    'file' => strip_tags($request->pdf),
                    'extension' => strtolower($request->pdf->getClientOriginalExtension()),
                ],
                [
                    'file' => 'required',
                    'extension' => 'required|in:pdf',
                ]
            );

            if ($validator->fails()) {
                return back()->withErrors(__('Invalid file !'));
            }

            if ($file = $request->file('pdf')) {
                $name = time() . '_' . $file->getClientOriginalName();
                $name = str_replace(" ", "_", $name);
                $file->move('files/applyjob', $name);
                $applyjob['pdf'] = $name;
            }
        }


        $applyjobs = Applyjob::create($applyjob);
        return response()->json(array("List of Apply Jobs" => $applyjobs), 200);
    }


    /**
     *  This function holds the functionality to  apply for job delete.
     *  @return response true
     *  @param $id
     */
    public function applyjobdestroy(Request $request, $id)
    {

        $validator = Validator::make($request->all(), [
            'secret' => 'required',
        ]);


        if ($validator->fails()) {

            $errors = $validator->errors();

            if ($errors->first('secret')) {
                return response()->json(['message' => $errors->first('secret'), 'status' => 'fail']);
            }
        }

        $key = DB::table('api_keys')->where('secret_key', '=', $request->secret)->first();

        if (!$key) {
            return response()->json(['Invalid Secret Key !']);
        }

        // Applyjob::where('id', $id)->delete();
        $user = Auth::user();
        $desjob = Applyjob::where('id', $id)->where('user_id', $user->id)->first();
        if (!empty($desjob)) {
            $desjob->postjob()->delete();
            $desjob->delete();
            return response()->json(['message' => 'Delete Successfully', 'status' => 'success']);
        } else {
            return response()->json(['message' => 'data not found', 'status' => 'fail']);
        }
    }


    public function applyjoblist(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'secret' => 'required',
        ]);


        if ($validator->fails()) {

            $errors = $validator->errors();

            if ($errors->first('secret')) {
                return response()->json(['message' => $errors->first('secret'), 'status' => 'fail']);
            }
        }

        $key = DB::table('api_keys')->where('secret_key', '=', $request->secret)->first();

        if (!$key) {
            return response()->json(['Invalid Secret Key !']);
        }

        // Applyjob::where('id', $id)->delete();
        $user = Auth::user();
        $applyjob = Applyjob::where('user_id', $user->id)->get();
        if (!empty($applyjob)) {
            return response()->json(array("List of apply jobs" => $applyjob), 200);
        } else {
            return response()->json(['message' => 'data not found', 'status' => 'fail']);
        }
    }
}
