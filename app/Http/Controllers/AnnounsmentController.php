<?php

namespace App\Http\Controllers;

use App\Announcement;
use Illuminate\Http\Request;
use App\User;
use App\Course;
use App\Order;
use DB;
use Session;
use Spatie\Permission\Models\Role;
use App\Http\Traits\SendNotification;
use App\NewNotification;

class AnnounsmentController extends Controller
{
    use SendNotification;

    public function __construct()
    {

        $this->middleware('permission:announcement.view', ['only' => ['index', 'show']]);
        $this->middleware('permission:announcement.create', ['only' => ['create', 'store']]);
        $this->middleware('permission:announcement.edit', ['only' => ['update']]);
        $this->middleware('permission:announcement.delete', ['only' => ['destroy', 'bulk_delete']]);
    }
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

        $data = $this->validate($request, [
            'announsment_en' => 'required',
            'announsment_ar' => 'required',
        ]);

        $input = $request->all();
        $input['announsment']['en'] = $input['announsment_en'];
        $input['announsment']['ar'] = $input['announsment_ar'];
        $data = Announcement::create($input);
        
        if (isset($request->status)) {
            $data->status = '1';
        } else {
            $data->status = '0';
        }

        $data->save();

        $cor = Course::where('id', $request->course_id)->first();
        $enroll = Order::where('course_id', $request->course_id)->where('status', 1)->get();
        if ($data->save()  && $data->status == 1) {
            if (!$enroll->isEmpty()) {
                $body = 'A new announcement has been released in course: ' . $cor->title . '.';
                $notification = NewNotification::create(['body' => $body]);
                foreach ($enroll as $enrol) {
                    $user = User::where('id', $enrol->user_id)->first();
                    $notification->users()->attach(['user_id' => $user->id]);
                    if (isset($user->device_token)) {
                        $this->send_notification($user->device_token, 'New Announcement', $body);
                    }
                }
            }
        }

        Session::flash('success', trans('flash.AddedSuccessfully'));
        return redirect()->route('course.show', $request->course_id);
    }


    /**
     * Display the specified resource.
     *
     * @param  \App\announsment  $announsment
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $annou = Announcement::find($id);
        $user =  User::all();
        $courses = Course::all();
        return view('admin.course.announsment.edit', compact('annou', 'courses', 'user'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\announsment  $announsment
     * @return \Illuminate\Http\Response
     */
    public function edit(announsment $announsment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\announsment  $announsment
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $data = Announcement::findorfail($id);
        $input = $request->all();
        $input['announsment']['en'] = $input['announsment_en'];
        $input['announsment']['ar'] = $input['announsment_ar'];

        if (isset($request->status)) {
            $input['status'] = '1';
        } else {
            $input['status'] = '0';
        }

        $data->update($input);

        Session::flash('success', trans('flash.UpdatedSuccessfully'));

        return redirect()->route('course.show', $request->course_id);
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\announsment  $announsment
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        DB::table('announcements')->where('id', $id)->delete();
        return back();
    }

    public function announcementstatus($id)
    {

        $announcement = Announcement::findorfail($id);

        if ($announcement->status == 0) {

            DB::table('announcements')->where('id', '=', $id)->update(['status' => "1"]);
            return back()->with('success', 'Status changed to active !');
        } else {
            DB::table('announcements')->where('id', '=', $id)->update(['status' => "0"]);
            return back()->with('delete', 'Status changed to deactive !');
        }
    }
}
