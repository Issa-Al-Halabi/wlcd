<?php

namespace App\Http\Controllers;

use App\NewNotification;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class NewNotificationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\NewNotification  $newNotification
     * @return \Illuminate\Http\Response
     */
    public function show(NewNotification $newNotification)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\NewNotification  $newNotification
     * @return \Illuminate\Http\Response
     */
    public function edit(NewNotification $newNotification)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\NewNotification  $newNotification
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, NewNotification $newNotification)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\NewNotification  $newNotification
     * @return \Illuminate\Http\Response
     */
    public function destroy(NewNotification $newNotification)
    {
        //
    }

    public function dalateAll(Request $request)
    {

        $user = User::where('id', Auth::id())->first();

        $notifications = $user->newNotifications;
        foreach ($notifications as $notification) {
            DB::table('notification_user')->where('notification_id', '=',  $notification->id)->where('user_id', '=',  Auth::id())->delete();
        }
        return back();
    }

    public function deleteNotification(Request $request)
    {

        $notification = NewNotification::where('id', $request->id)->first();

        DB::table('notification_user')->where('notification_id', '=',  $request->id)->where('user_id', '=',  Auth::id())->delete();


        return back();
    }

    public function editNotificationsStatus(Request $request)
    {
        DB::table('notification_user')->where('user_id', '=',  Auth::id())->update(['status' => 1]);
        
        // $user = Auth::user();

        // $new_notifications = $user->newNotifications()->orderBy('created_at', 'desc')->get()->toArray();
        return response()->json(['success' => true]);
    }
}
