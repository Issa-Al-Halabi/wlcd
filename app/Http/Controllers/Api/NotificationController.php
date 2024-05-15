<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Traits\SendNotification;
use App\NewNotification;
use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class NotificationController extends Controller
{
    //
    use SendNotification;
    public function allnotification(Request $request)
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
        $notifications = $user->unreadnotifications;

        if ($notifications) {
            return response()->json(['notifications' => $notifications], 200);
        } else {
            return response()->json(['error'], 401);
        }
    }

    public function notificationread(Request $request, $id)
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

        $userunreadnotification = Auth::guard('api')
            ->user()
            ->unreadNotifications->where('id', $id)
            ->first();

        if ($userunreadnotification) {
            $userunreadnotification->markAsRead();
            return response()->json(['1'], 200);
        } else {
            return response()->json(['error'], 401);
        }
    }

    public function readallnotification(Request $request)
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

        $notifications = auth()
            ->User()
            ->unreadNotifications()
            ->count();

        if ($notifications > 0) {
            $user = auth()->User();

            foreach ($user->unreadNotifications as $unnotification) {
                $unnotification->markAsRead();
            }

            return response()->json(['1'], 200);
        } else {
            return response()->json(['Notification already marked as read !'], 401);
        }
    }
    public function userNotifications(Request $request)
    {
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

        // $notification->users()->detach(Auth::id());
        DB::table('notification_user')->where('notification_id', '=',  $request->id)->where('user_id', '=',  Auth::id())->delete();


        return response()->json([
            'message' => 'Notification has been deleted successfully.',
        ], 200);
    }

    public function bulkDeleteNotification(Request $request)
    {
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
}
