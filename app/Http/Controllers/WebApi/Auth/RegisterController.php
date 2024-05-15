<?php

namespace App\Http\Controllers\WebApi\Auth;

use App\Http\Controllers\Api\Auth\IssueTokenTrait;
use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Laravel\Passport\Client;
use App\Setting;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;
use App\Mail\verifyEmail;
use App\Mail\WelcomeUser;
use App\Instructor;
use App\NewNotification;
use Auth;
use Validator;
use Illuminate\Support\Facades\Mail;

use App\Http\Controllers\Api\VerificationController;

class RegisterController extends Controller
{
    use IssueTokenTrait;

    private $client;

    public function __construct()
    {
        $this->client = Client::find(2);
    }

    public function register(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6'
        ]);

        $config = Setting::first();

        if ($config->mobile_enable == 1) {

            $request->validate([
                'mobile' => 'required|numeric'
            ]);
        }

        if ($config->verify_enable == 0) {
            $verified = \Carbon\Carbon::now()->toDateTimeString();
        } else {
            $verified = NULL;
        }

        $user = User::create([

            'fname' => request('name'),
            'email' => request('email'),
            'email_verified_at'  => $verified,
            'mobile' => $config->mobile_enable == 1 ? request('mobile') : NULL,
            'password' => bcrypt(request('password')),

        ]);
        if (isset($request->device_token)) {
            $user->device_token = $request->device_token;
            $user->save();
        }

        if ($config->w_email_enable == 1) {
            try {
                Mail::to(request('email'))->send(new WelcomeUser($user));
            } catch (\Exception $e) {
                // return response()->json(['message'=>'registration done. Mail cannot be sent', 'token' =>$this->issueToken($request, 'password')],201);
                return $this->issueToken($request, 'password');
            }
        }

        if ($config->verify_enable == 0) {
            return $this->issueToken($request, 'password');
        } else {
            if ($verified != NULL) {
                return $this->issueToken($request, 'password');
            } else {
                $user->sendEmailVerificationNotificationViaAPI();
                Mail::to(request('email'))->send(new WelcomeUser($user));
                return response()->json('Verify your email', 402);
            }
        }
    }

    public function instructor(Request $request)
    {
        $user_id  = Auth::user()->id;
        $users = Instructor::where('user_id', $user_id)->get();

        if (!$users->isEmpty()) {
            return response()->json('AlreadyRequested', 402);
        } else {
            $request->validate([
                'file' => 'mimes:jpeg,png,jpg,bmp,webp,zip,pdf',
                'image' => 'mimes:jpg,jpeg,png,bmp,webp'
            ]);

            $input = $request->all();

            if ($file = $request->file('image')) {


                $validator = Validator::make(
                    [
                        'file' => $request->image,
                        'extension' => strtolower($request->image->getClientOriginalExtension()),
                    ],
                    [
                        'file' => 'required',
                        'extension' => 'required|in:jpg,jpeg,bmp,png,webp',
                    ]
                );

                if ($validator->fails()) {
                    return response()->json('Invalid file !', 402);
                }

                if ($file = $request->file('image')) {
                    $name = time() . '_' . $file->getClientOriginalName();
                    $name = str_replace(" ", "_", $name);
                    $file->move('images/instructor', $name);
                    $input['image'] = $name;
                }
            }


            if ($file = $request->file('file')) {


                $validator = Validator::make(
                    [
                        'file' => $request->file,
                        'extension' => strtolower($request->file->getClientOriginalExtension()),
                    ],
                    [
                        'file' => 'required',
                        'extension' => 'required|in:jpeg,png,jpg,bmp,webp,zip,pdf',
                    ]
                );

                if ($validator->fails()) {
                    return response()->json('Invalid file !', 402);
                }

                if ($file = $request->file('file')) {
                    $name = time() . '_' . $file->getClientOriginalName();
                    $name = str_replace(" ", "_", $name);
                    $file->move('files/instructor/', $name);
                    $input['file'] = $name;
                }
            }
            $data = Instructor::create($input);
            $data->save();

            if ($data) {
                $admins = User::where('role', 'admin')->get();
                foreach ($admins as $admin) {
                    $body = 'A new instructor request has been added.';
                    $notification = NewNotification::create(['body' => $body]);
                    $notification->users()->attach(['user_id' => $admin->user_id]);
                }
            }

        }

        return response()->json('success');
    }
}
