<?php

namespace App\Http\Controllers\Api;

use App\About;
use App\Answer;
use App\Appointment;
use App\Assignment;
use App\BBL;
use App\Career;
use App\Http\Controllers\Controller;
use App\Instructor;
use App\Mail\UserAppointment;
use App\Meeting;
use App\Page;
use App\Question;
use App\QuizAnswer;
use App\QuizTopic;
use App\ReviewHelpful;
use App\Terms;
use App\User;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Quiz;
use Mail;
use Validator;
use App\Http\Traits\SendNotification;
use App\NewNotification;

class MainController extends Controller
{
    use SendNotification;

    public function main()
    {
        return response()->json(['ok'], 200);
    }
    public function pages(Request $request)
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
        return response()->json(['pages' => Page::get()], 200);
    }
    public function apikeys(Request $request)
    {
        $key = DB::table('api_keys')->first();

        if (!$key) {
            return response()->json(['Invalid Secret Key !']);
        }

        return response()->json(['key' => $key], 200);
    }



    public function showcoupon(Request $request)
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

        $coupon = Coupon::get();

        return response()->json(['coupon' => $coupon], 200);
    }



    public function aboutus(Request $request)
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

        $about = About::all()->toArray();
        return response()->json(['about' => $about], 200);
    }

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

        $terms_policy = Terms::get()->toArray();

        return response()->json(['terms_policy' => $terms_policy], 200);
    }

    public function career(Request $request)
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

        $career = Career::get()->toArray();

        return response()->json(['career' => $career], 200);
    }

    public function zoom(Request $request)
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

        $meeting = Meeting::get()->toArray();

        return response()->json(['meeting' => $meeting], 200);
    }

    public function bigblue(Request $request)
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

        $bigblue = BBL::get()->toArray();

        return response()->json(['bigblue' => $bigblue], 200);
    }
    public function assignment(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'secret' => 'required',
            'course_id' => 'required',
            'chapter_id' => 'required',
            'title' => 'required',
            'file' => 'required',
        ]);

        if ($validator->fails()) {
            $errors = $validator->errors();
            if ($errors->first('secret')) {
                return response()->json(['message' => $errors->first('secret'), 'status' => 'fail']);
            }
            if ($errors->first('course_id')) {
                return response()->json(['message' => $errors->first('course_id'), 'status' => 'fail']);
            }
            if ($errors->first('chapter_id')) {
                return response()->json(['message' => $errors->first('chapter_id'), 'status' => 'fail']);
            }
            if ($errors->first('title')) {
                return response()->json(['message' => $errors->first('title'), 'status' => 'fail']);
            }
            if ($errors->first('file')) {
                return response()->json(['message' => $errors->first('file'), 'status' => 'fail']);
            }
        }

        $key = DB::table('api_keys')
            ->where('secret_key', '=', $request->secret)
            ->first();
        if (!$key) {
            return response()->json(['Invalid Secret Key !']);
        }
        $auth = Auth::guard('api')->user();
        $course = Course::where('id', $request->course_id)->first();
        if ($file = $request->file('file')) {
            $name = time() . '_' . $file->getClientOriginalName();
            $name = str_replace(" ", "_", $name);
            $file->move('files/assignment', $name);
            $input['assignment'] = $name;
        }
        $assignment = Assignment::create([
            'user_id' => $auth->id,
            'instructor_id' => $course->user_id,
            'course_id' => $course->id,
            'chapter_id' => $request->chapter_id,
            'title' => $request->title,
            'assignment' => $name,
            'type' => 0,
        ]);

        if (isset($assignment) && isset($course->user_id)) {
            $body = 'A new assignment has been added to course: ' . $course->title;
            $notification = NewNotification::create(['body' => $body]);
            $notification->users()->attach(['user_id' => $course->user_id]);
            $user = User::where('id', $course->user_id)->first();
            if (isset($user->device_token)) {
                $this->send_notification($user->device_token, 'New Assignment', $body);
            }
        }

        return response()->json(['message' => 'Assignment submitted successfully', 'status' => 'success'], 200);
    }

    public function appointment(Request $request)
    {
        $this->validate($request, [
            'course_id' => 'required',
            'title' => 'required',
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

        $auth = Auth::guard('api')->user();

        $course = Course::where('id', $request->course_id)->first();

        $appointment = Appointment::create([
            'user_id' => $auth->id,
            'instructor_id' => $course->user_id,
            'course_id' => $course->id,
            'title' => $request->title,
            'detail' => $request->detail,
            'accept' => '0',
            'start_time' => \Carbon\Carbon::now()->toDateTimeString(),
        ]);

        $users = User::where('id', $course->user_id)->first();

        if ($appointment) {
            if (env('MAIL_USERNAME') != null) {
                try {
                    /*sending email*/
                    $x = 'You get Appointment Request';
                    $request = $appointment;
                    Mail::to($users->email)->send(new UserAppointment($x, $request));
                } catch (\Swift_TransportException $e) {
                    return back()->with('success', trans('flash.RequestMailError'));
                }
            }
        }

        return response()->json(['appointment' => $appointment], 200);
    }

    public function question(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'secret' => 'required',
            'course_id' => 'required',
            'question' => 'required',
        ]);

        if ($validator->fails()) {
            $errors = $validator->errors();
            if ($errors->first('secret')) {
                return response()->json(['message' => $errors->first('secret'), 'status' => 'fail']);
            }
            if ($errors->first('course_id')) {
                return response()->json(['message' => $errors->first('course_id'), 'status' => 'fail']);
            }
            if ($errors->first('question')) {
                return response()->json(['message' => $errors->first('question'), 'status' => 'fail']);
            }
        }

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

        $course = Course::where('id', $request->course_id)->first();

        $question = Question::create([
            'user_id' => $auth->id,
            'instructor_id' => $course->user_id,
            'course_id' => $course->id,
            'status' => 1,
            'question' => $request->question,
        ]);

        if (isset($question) && isset($course->user_id)) {
            if ($course->user_id != $auth->id) {
                $user = User::where('id', $course->user_id)->first();
                $body = 'A new question has been added to course: ' . $course->title;
                $notification = NewNotification::create(['body' => $body]);
                $notification->users()->attach(['user_id' => $course->user_id]);
                if (isset($user->device_token)) {
                    $this->send_notification($user->device_token, 'New Question', $body);
                }
            }
        }

        return response()->json(['question' => $question], 200);
    }

    public function answer(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'secret' => 'required',
            'course_id' => 'required',
            'question_id' => 'required',
            'answer' => 'required',
        ]);
        if ($validator->fails()) {
            $errors = $validator->errors();
            if ($errors->first('secret')) {
                return response()->json(['message' => $errors->first('secret'), 'status' => 'fail']);
            }
            if ($errors->first('course_id')) {
                return response()->json(['message' => $errors->first('course_id'), 'status' => 'fail']);
            }
            if ($errors->first('question_id')) {
                return response()->json(['message' => $errors->first('question_id'), 'status' => 'fail']);
            }
            if ($errors->first('answer')) {
                return response()->json(['message' => $errors->first('answer'), 'status' => 'fail']);
            }
        }
        $key = DB::table('api_keys')
            ->where('secret_key', '=', $request->secret)
            ->first();
        if (!$key) {
            return response()->json(['Invalid Secret Key !']);
        }
        $auth = Auth::guard('api')->user();
        $course = Course::where('id', $request->course_id)->first();
        $question = Question::where('id', $request->question_id)->first();

        $answer = Answer::create([
            'ans_user_id' => $auth->id,
            'ques_user_id' => $question->user_id,
            'instructor_id' => $course->user_id,
            'course_id' => $course->id,
            'question_id' => $question->id,
            'status' => 1,
            'answer' => $request->answer,
        ]);

        if (isset($answer) && isset($course->user_id)) {
            if ($course->user_id != $auth->id) {
                $user = User::where('id', $question->user_id)->first();
                $body = 'A new answer has been added to your question on course: ' . $course->title;
                $notification = NewNotification::create(['body' => $body]);
                $notification->users()->attach(['user_id' => $user->id]);
                if (isset($user->device_token)) {
                    $this->send_notification($user->device_token, 'New Answer', $body);
                }
            }
        }
        return response()->json(['message' => 'Answer Submitted', 'status' => 'success'], 200);
    }
    public function appointmentdelete(Request $request, $id)
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

        Appointment::where('id', $id)->delete();

        return response()->json('Deleted Successfully !', 200);
    }    
    public function quizsubmit(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'secret' => 'required',
            'course_id' => 'required',
            'question_id' => 'required',
            'topic_id' => 'required',
        ]);
        if ($validator->fails()) {
            $errors = $validator->errors();
            if ($errors->first('secret')) {
                return response()->json(['message' => $errors->first('secret'), 'status' => 'fail'], 400);
            }
            if ($errors->first('course_id')) {
                return response()->json(['message' => $errors->first('course_id'), 'status' => 'fail'], 400);
            }
            if ($errors->first('question_id')) {
                return response()->json(['message' => $errors->first('question_id'), 'status' => 'fail'], 400);
            }
            if ($errors->first('topic_id')) {
                return response()->json(['message' => $errors->first('topic_id'), 'status' => 'fail'], 400);
            }
        }

        $key = DB::table('api_keys')->where('secret_key', '=', $request->secret)->first();
        if (!$key) {
            return response()->json(['Invalid Secret Key !']);
        }

        $auth = Auth::guard('api')->user();
        $course = Course::where('id', $request->course_id)->first();
        $topics = QuizTopic::where('id', $request->topic_id)->first();
        $unique_question = array_unique($request->question_id);
        $quiz_already = QuizAnswer::where('user_id', $auth->id)->where('topic_id', $topics->id)->first();
        if ($quiz_already != null && $topics->quiz_again == 1) {
            QuizAnswer::where('user_id', $auth->id)->where('topic_id', $topics->id)->delete();
        } elseif ($quiz_already != null && $topics->quiz_again == 0) {
            return response()->json(array('message' => 'you did the quiz befor', 'status' => 'error'), 400);
        }
        if ($topics->type == null) {
            for ($i = 1; $i <= count($request->answer); $i++) {
                $already_answer = QuizAnswer::where('question_id', $unique_question[$i])->where('topic_id', $topics->id)->where('user_id', Auth::guard('api')->user()->id)->first();
                if ($already_answer == null) {
                    $question = Quiz::where('id', $unique_question[$i])->first();

                    $answers[] = [
                        'user_id' => Auth::guard('api')->user()->id,
                        'user_answer' => $request->answer[$i],
                        'question_id' => $unique_question[$i],
                        'course_id' => $topics->course_id,
                        'topic_id' => $topics->id,
                        'answer' => $question->answer,
                        // 'answer' => $request->canswer[$i],
                        'created_at' => \Carbon\Carbon::now()->toDateTimeString(),
                    ];
                }
            }
            QuizAnswer::insert($answers);
            return response()->json(array('message' => 'Quiz Submitted', 'status' => 'success'), 200);
        } elseif ($topics->type == 1) {
            for ($i = 1; $i <= count($request->txt_answer); $i++) {

                $already_answer = QuizAnswer::where('question_id', $unique_question[$i])->where('topic_id', $topics->id)->where('user_id', Auth::guard('api')->user()->id)->first();
                if (!isset($already_answer)) {
                    $answers[] = [
                        'user_id' => Auth::guard('api')->user()->id,
                        'question_id' => $unique_question[$i],
                        'course_id' => $topics->course_id,
                        'topic_id' => $topics->id,
                        'txt_answer' => $request->txt_answer[$i],
                        'type' => '1',
                        'txt_approved' => '0',
                        'created_at' => \Carbon\Carbon::now()->toDateTimeString(),
                    ];
                }
            }
            QuizAnswer::insert($answers);
            return response()->json(array('message' => 'Quiz Submitted', 'status' => 'success'), 200);
        }
    }

    public function deleteAssignment(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'secret' => 'required',
            'assignment_id' => 'required',
        ]);

        if ($validator->fails()) {
            $errors = $validator->errors();

            if ($errors->first('secret')) {
                return response()->json(['message' => $errors->first('secret'), 'status' => 'fail']);
            }

            if ($errors->first('assignment_id')) {
                return response()->json(['message' => $errors->first('assignment_id'), 'status' => 'fail']);
            }
        }

        $key = DB::table('api_keys')
            ->where('secret_key', '=', $request->secret)
            ->first();

        if (!$key) {
            return response()->json(['Invalid Secret Key !']);
        }

        $user = Auth::guard('api')->user();

        Assignment::where('id', $request->assignment_id)
            ->where('user_id', $user->id)
            ->delete();

        return response()->json(['watchlist' => $watch], 200);
    }

    public function requestCheck(Request $request)
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

        $key = DB::table('api_keys')
            ->where('secret_key', '=', $request->secret)
            ->first();

        if (!$key) {
            return response()->json(['Invalid Secret Key !'], 400);
        }

        $user = Auth::guard('api')->user();

        $alreadyRequest = Instructor::where('user_id', Auth::guard('api')->user()->id)->first();

        if ($alreadyRequest != null) {
            return response()->json([
                'message' => 'Already Requested',
            ]);
        }

        return response()->json([
            'message' => 'Please Request to became an instructor',
        ]);
    }
    public function cancelRequest(Request $request)
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

        $key = DB::table('api_keys')
            ->where('secret_key', '=', $request->secret)
            ->first();

        if (!$key) {
            return response()->json(['Invalid Secret Key !'], 400);
        }

        $user = Auth::guard('api')->user();

        if (Instructor::where('user_id', $user->id)->exists()) {
            $instructor = Instructor::where('user_id', $user->id)->first();
            $instructor->delete();

            return response()->json([
                'message' => 'records deleted',
            ]);
        } else {
            return response()->json(
                [
                    'message' => 'Instructor not found',
                ],
                404,
            );
        }
    }

    public function reviewlike(Request $request, $id)
    {
        $user = Auth::user();

        $help = ReviewHelpful::where('review_id', $id)
            ->where('user_id', $user->id)
            ->first();

        if ($request->review_like == '1') {
            if (isset($help)) {
                ReviewHelpful::where('id', $help->id)->update([
                    'review_like' => '1',
                    'review_dislike' => '0',
                ]);
            } else {
                $created_review = ReviewHelpful::create([
                    'course_id' => $request->course_id,
                    'user_id' => $user->id,
                    'review_id' => $id,
                    'helpful' => 'yes',
                    'review_like' => '1',
                ]);

                ReviewHelpful::where('id', $created_review->id)->update([
                    'review_dislike' => '0',
                ]);
            }
        } elseif ($request->review_dislike == '1') {
            if (isset($help)) {
                ReviewHelpful::where('id', $help->id)->update([
                    'review_dislike' => '1',
                    'review_like' => '0',
                ]);
            } else {
                $created_review = ReviewHelpful::create([
                    'course_id' => $request->course_id,
                    'user_id' => $user->id,
                    'review_id' => $id,
                    'helpful' => 'yes',
                    'review_dislike' => '1',
                ]);

                ReviewHelpful::where('id', $created_review->id)->update([
                    'review_like' => '0',
                ]);
            }
        } elseif ($help->review_like == '1') {
            ReviewHelpful::where('id', $help->id)->update([
                'review_like' => '0',
            ]);
        } elseif ($help->review_dislike == '1') {
            ReviewHelpful::where('id', $help->id)->update([
                'review_dislike' => '0',
            ]);
        }

        return response()->json(['message' => 'Updated Successfully', 'status' => 'success'], 200);
    }

    public function quiz_reports(Request $request, $id)
    {
        $auth = Auth::user();
        $topic = QuizTopic::where('id', $id)->get();
        $questions = Quiz::where('topic_id', $id)->get();
        $count_questions = $questions->count();
        $topics = QuizTopic::where('id', $id)->first();
        $ans = QuizAnswer::where('user_id', $auth->id)
            ->where('topic_id', $id)
            ->get();

        $mark = 0;

        if ($topics->type == null) {
            foreach ($ans as $answer) {
                if ($answer->answer == $answer->user_answer) {
                    $mark++;
                }
            }
        } else {
            foreach ($ans as $answer) {
                if ($answer->txt_approved == 1) {
                    $mark++;
                }
            }
        }

        $per_question_mark = $topics->per_q_mark;
        $correct = $mark * $topics->per_q_mark;

        return response()->json([
            'question_count' => $count_questions,
            'correct_count' => $mark,
            'correct_answer' => $mark,
            'per_question_mark' => $per_question_mark,
            'total_marks' => $correct,
        ], 200);
    }

    public function contactReasons(Request $request)
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

        $data =  Contactreason::where('status', '1')->get(['id', 'reason']);

        return response()->json([
            'reasons' => $data,
        ], 200);
    }
}
