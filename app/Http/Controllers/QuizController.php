<?php

namespace App\Http\Controllers;

use App\Quiz;
use Illuminate\Http\Request;
use App\Course;
use App\QuizTopic;
use App\QuizAnswer;
use App\User;
use File;
use Image;
use Illuminate\Support\Facades\DB as FacadesDB;
use Illuminate\Support\Facades\Validator;
use Rap2hpoutre\FastExcel\FastExcel;
use Session;
use DB;
use Spatie\Permission\Models\Role;
use App\Http\Traits\TranslationTrait;


class QuizController extends Controller
{
  use TranslationTrait;

  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index()
  {
    $cor = Course::all();
    $topics = QuizTopic::all();
    $questions = Quiz::all();
    return view('admin.course.quiz.index', compact('questions', 'topics', 'cor'));
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


    if (isset($request->type)) {

      $request->validate([
        'course_id' => 'required',
        'topic_id' => 'required',
        'question' => 'required',
        'type' => 'required',
      ]);
    } else {

      $request->validate([
        'course_id' => 'required',
        'topic_id' => 'required',
        'question' => 'required',
        'a' => 'required',
        'b' => 'required',
        'c' => 'required',
        'd' => 'required',
        'answer' => 'required',

      ]);
    }


    $data = new Quiz;
    $input = $this->getTranslatableRequest($data->getTranslatableAttributes(), $request->all(), ['en', 'ar']);


    if (isset($request->type)) {
      $input['type'] = '1';
    } else {
      $input['type'] = null;
    }

    if ($file = $request->file('question_img')) {

      $path = 'images/quiz/';

      if (!file_exists(public_path() . '/' . $path)) {

        $path = 'images/quiz/';
        File::makeDirectory(public_path() . '/' . $path, 0777, true);
      }
      $optimizeImage = Image::make($file);
      $optimizePath = public_path() . '/images/quiz/';
      $image = time() . '_' . $file->getClientOriginalName();
      $image = str_replace(" ", "_", $image);
      $optimizeImage->save($optimizePath . $image, 72);

      $input['question_img'] = $image;
    }


    $input['answer_exp'] = $request->answer_exp;
    Quiz::create($input);
    return back()->with('success', trans('flash.AddedSuccessfully'));
  }

  /**
   * Display the specified resource.
   *
   * @param  \App\Quiz  $quiz
   * @return \Illuminate\Http\Response
   */
  public function show($id)
  {

    $topic = QuizTopic::findOrFail($id);
    $quizes = Quiz::where('topic_id', $topic->id)->get();
    return view('admin.course.quiz.index', compact('topic', 'quizes'));
  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param  \App\Quiz  $quiz
   * @return \Illuminate\Http\Response
   */
  public function edit($id)
  {
    $topic = QuizTopic::findOrFail($id);
    $editquizes = Quiz::where('$id', $topic->id)->get();
    return view('admin.course.quiz.index', compact('topic', 'editquizes'));
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  \App\Quiz  $quiz
   * @return \Illuminate\Http\Response
   */
  public function update(Request $request, $id)
  {
    $question = Quiz::findOrFail($id);
    $request->validate([
      'topic_id' => 'required',
      'question' => 'required',
      'a' => 'required',
      'b' => 'required',
      'c' => 'required',
      'd' => 'required',
      'answer' => 'required',
    ]);

    $input = $request->all();
    $input = $this->getTranslatableRequest($question->getTranslatableAttributes(), $request->all(), [$request->lang]);


    if ($file = $request->file('question_img')) {

      $path = 'images/quiz/';

      if (!file_exists(public_path() . '/' . $path)) {

        $path = 'images/quiz/';
        File::makeDirectory(public_path() . '/' . $path, 0777, true);
      }
      $optimizeImage = Image::make($file);
      $optimizePath = public_path() . '/images/quiz/';
      $image = time() . '_' . $file->getClientOriginalName();
      $image = str_replace(" ", "_", $image);
      $optimizeImage->save($optimizePath . $image, 72);

      $input['question_img'] = $image;
    }



    $input['answer_exp'] = $request->answer_exp;
    $question->update($input);
    return back()->with('success', trans('flash.UpdatedSuccessfully'));
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  \App\Quiz  $quiz
   * @return \Illuminate\Http\Response
   */
  public function destroy($id)
  {
    $question = Quiz::findOrFail($id);
    $question->delete();

    QuizAnswer::where('question_id', $id)->delete();

    return back()->with('delete', trans('flash.DeletedSuccessfully'));
  }


  public function importquiz($id)
  {
    $topic_id = $id;
    return view('admin.course.quiz.importindex', compact('topic_id'));
  }


  public function import(Request $request)
  {

    $validator = Validator::make(
      [
        'file' => $request->file,
        'extension' => strtolower($request->file->getClientOriginalExtension()),
      ],
      [
        'file' => 'required',
        'extension' => 'required|in:xlsx,xls',
      ]

    );


    if ($validator->fails()) {
      return back()->withErrors('Invalid file type!');
    }

    if (!$request->has('file')) {

      return back()->withErrors('Please choose a file !');
    }

    $fileName = time() . '_' . $request->file->getClientOriginalName();
    $fileName = str_replace(" ", "_", $fileName);

    if (!is_dir(public_path() . '/excel')) {
      mkdir(public_path() . '/excel');
    }

    $request->file->move(public_path('excel'), $fileName);

    $lang = Session::get('changed_language');



    $quiz_import = (new FastExcel)->import(public_path() . '/excel/' . $fileName);

    //  $quiz_import  = (new FastExcel)->import($request->file('file'));

    // try {
    //   $quiz_import = (new FastExcel)->import($request->file('products_file'));
    // } catch (\Exception $exception) {
    //   dd('sdfbn');
    //   return back();
    // }

    if (count($quiz_import) > 0) {

      try {

        foreach ($quiz_import as $key => $row_fetch) {

          $line_number = $key + 1;

          $topic_id = QuizTopic::where('id', $request->topic_id)->first();

          $course_id = Course::where("id", $topic_id->course_id)->first();

          $quiz_question = $row_fetch['Question'];

          $option_A = $row_fetch['A'];

          $option_B = $row_fetch['B'];

          $option_C = $row_fetch['C'];

          $option_D = $row_fetch['D'];


          $correct_answer = $row_fetch['CorrectAnswer'];

          $product = Quiz::whereRaw("JSON_EXTRACT(question, '$.$lang') = '$quiz_question'")->first();

          if (isset($product)) {

            $product->update([
              'course_id' => $course_id->id,
              'topic_id' => $topic_id->id,
              'question' => $quiz_question,
              'a' => $option_A,
              'b' => $option_B,
              'c' => $option_C,
              'd' => $option_D,
              'answer' => $correct_answer,

            ]);
          } else {

            $product = Quiz::create([
              'course_id' => $course_id->id,
              'topic_id' => $topic_id->id,
              'question' => $quiz_question,
              'a' => $option_A,
              'b' => $option_B,
              'c' => $option_C,
              'd' => $option_D,
              'answer' => $correct_answer,

            ]);
          }
        }
      } catch (\Swift_TransportException $e) {

        $file = @file_get_contents(public_path() . '/excel/' . $fileName);

        if ($file) {
          unlink(public_path() . '/excel/' . $fileName);
        }

        \Session::flash('delete', $e->getMessage());
        return back();
      }
    } else {

      $file = @file_get_contents(public_path() . '/excel/' . $fileName);

      if ($file) {
        unlink(public_path() . '/excel/' . $fileName);
      }

      return back()->with('success', trans('flash.AddedSuccessfully'));
    }


    return back()->with('success', trans('flash.AddedSuccessfully'));
  }

  //   public function import(Request $request)
  //     {
  //         try {
  //             $collections = (new FastExcel)->import($request->file('file'));
  //           } catch (\Exception $exception) {
  //             dd($exception);

  // Toastr::error('You have uploaded a wrong format file, please upload the right file.');
  // return back();
  //         }
  //         $countUpdate = 0;
  //         $data = [];
  //         $dataUpdate = [];

  //         foreach ($collections as $collection) {

  //           dd($collection);

  //             $dateNew = $this->rev_date($collection['تاريخ الصلاحية']);
  //             //$product = Product::where('num_id', '=', $collection['رمز المادة '])->get()->first();
  //            if (isset($product)) {
  //                 $product->unit_price = $collection['السعر'];
  //                 $product->save();
  //             } else {
  //               array_push($data, [
  //                 'num_id' => $collection['رمز المادة '],

  //             ]);
  //         }
  //     }

  //     if (count($data) > 0) {
  //         //DB::table('products')->insert($data);
  //     }
  // Toastr::success(count($data) . ' - Products imported successfully! and (' . $countUpdate . ') Products updated successfully!');
  // return back();
  // }

  public function userAnswers($quiz_id, $user_id)
  {
    $user = User::where('id', $user_id)->first();
    $topics = QuizTopic::findOrFail($quiz_id);
    $answers = QuizAnswer::where('topic_id', $topics->id)->where('user_id', $user_id)->get();
    $mark = 0;
    foreach ($answers as $answer) {
      if ($answer->answer == $answer->user_answer) {
        $mark++;
      }
    }
    $correct = $mark * $topics->per_q_mark;
    $total = count($answers) * $topics->per_q_mark;
    return view('admin.course.quiz.review.userAnswers', compact('user', 'answers', 'topics', 'correct', 'total'));
  }

  public function quizreview()
  {
    $answers = QuizAnswer::where('type', '1')->get();
    return view('admin.course.quiz.review.index', compact('answers'));
  }


  public function quizreviewQuick(Request $request)
  {

    $user =  QuizAnswer::find($request->id);

    $user->txt_approved = $request->status;

    $user->save();
    return response()->json($request->all());
  }

  public function status(Request $request)
  {
    $user = QuizAnswer::find($request->id);
    $user->status = $request->status;
    $user->save();
    return back()->with('success', trans('flash.UpdatedSuccessfully'));
  }
}
