<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Auth;
use App\Answer;
use App\Course;
use App\User; 
use App\Question;
use Session;
use Spatie\Permission\Models\Role;
use App\Http\Traits\SendNotification;
use App\NewNotification;
class AnswerController extends Controller
{
    use SendNotification;

    public function __construct()
    {
    
        $this->middleware('permission:answer.view', ['only' => ['show']]);
        $this->middleware('permission:answer.create', ['only' => ['store']]);
        $this->middleware('permission:answer.edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:answer.delete', ['only' => ['destroy']]);
    
    }
    public function index()
    {

    }


    public function store(Request $request)
    {
        $data = $this->validate($request,[
            'answer' => 'required',
            'question_id' => 'required'
        ]);

        $input = $request->all();
        $input['status'] = isset($request->status)  ? 1 : 0;

        $data = Answer::create($input);
        $data->save(); 

        Session::flash('success', trans('flash.AddedSuccessfully'));
        return redirect()->route('course.show',$request->course_id);
    }

    public function show($id)
    {
        $questions = Question::where('id',$id)->get();
        $answers = Answer::where('question_id',$id)->get();
        return view('admin.course.answer.index',compact('questions', 'answers'));

    }

    public function edit($id)
    {
        $show= Answer::find($id);
        return view('admin.course.answer.edit', compact('show'));
    }

    public function update(Request $request, $id)
    {
        
        $data = Answer::findorfail($id);
        $input = $request->all();
        $input['status'] = isset($request->status)  ? 1 : 0;
        
        $data->update($input);

        return redirect()->route('course.show',$request->course_id);
    }

    public function destroy($id)
    {
        DB::table('answers')->where('id',$id)->delete();
        return back()->with('delete', trans('flash.DeletedSuccessfully'));
    }

    public function answer(Request $request, $id)
    {
        $input = $request->all();
        $data = Answer::create($input);
        $data->save();
        $course = Course::where('id', $id)->first();

        if (isset($data) && isset($course->user_id)) {
            if($course->user_id != Auth::id()){
                $user = User::where('id', $request->ques_user_id)->first();
                $body = 'A new answer has been added to your question on course: ' . $course->title;
                $notification = NewNotification::create(['body' => $body]);
                $notification->users()->attach(['user_id' => $user->id]);
                if (isset($user->device_token)) {
                    $this->send_notification($user->device_token, 'New Answer', $body);
                }
            }
        }
         
        Session::flash('success', trans('flash.AddedSuccessfully'));
        return back();
    }
}
