<?php

namespace App\Http\Controllers;
use App\Course;
use App\Order;
use Auth;
use Redirect;
use PDF;
use Illuminate\Http\Request;
use App\CourseProgress;
use Crypt;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Role;

class CertificateController extends Controller
{
    public function __construct()
    {
    
        $this->middleware('permission:certificate.manage', ['only' => ['verification']]);
    
    }
    public function show($slug)
    {
        
        $serial_no = $slug;

        $whatIWant = strtok($slug, 'CR-');

        $progress = CourseProgress::where('id', $whatIWant)->firstOrfail();

        $course = Course::where('id', $progress->course_id)->firstOrfail();

    
        return view('front.certificate.certificate', compact('course', 'progress', 'serial_no'));
        
    }

    public function pdfdownload($slug)
    {
        $serial_no = $slug;

        $whatIWant = strtok($slug, 'CR-');

        $progress = CourseProgress::where('id', $whatIWant)->first();

        $course = Course::where('id', $progress->course_id)->first();
        
        $pdf = PDF::loadView('front.certificate.download', compact('course', 'progress', 'serial_no'), [], 
        [ 
          'title' => 'Certificate', 
          'orientation' => 'L'
        ]);

        return $pdf->download('certificate.pdf');
        // return $pdf->stream('certificate.pdf');
    }


    public function apipdfdownload($id)
    {
        $user = Auth::guard('api')->user();

        $random = $id.'CR-'.uniqid();

        $serial_no = $random;

        $whatIWant = strtok($random, 'CR-'); 
    
        $progress = CourseProgress::where('id', $whatIWant)->where('user_id', $user->id)->first();

        $course = Course::where('id', $progress->course_id)->first();

        if($progress == NULL)
        {
            return response()->json(['Please Complete your course to get certificate !'], 400); 
        }
        
        
        $pdf = PDF::loadView('front.certificate.download', compact('course', 'progress', 'serial_no'), [], 
        [ 
          'title' => 'Certificate', 
          'orientation' => 'L'
        ]);
        
        // $pdf->save(storage_path().'/app/pdf/certificate.pdf');
        
        return $pdf->download('certificate.pdf');
        
    }

    public function verification(Request $request)
    {



        $contains = Str::contains($request->title, 'CR-');

        if($contains)
        {
           
            if(isset($request->title))
            {
                $posts = $request->title;
            }
            else
            {
               $posts = NULL; 
            }
            

            return view('admin.certificate.view', compact('posts'));
        }


        $posts = NULL;

        // if(!isset($posts))
        // {
        //     session()->flash('fail',__('Invalid serial no.'));
        // }
          return view('admin.certificate.view', compact('posts'));
        
        
    }

}
