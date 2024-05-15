<?php

namespace App\Http\Controllers;
use App\Compare;
use Auth;
use Session;

use Illuminate\Http\Request;

class CompareController extends Controller
{
    public function dataput(Request $request)
    {
      
        $compare['user_id'] = Auth::user()->id;
        $compare['course_id'] = $request->id;
        Compare::create($compare);
        return back();
        
    }
    public function index(Request $request)
    {
        
        $compare = Compare::where('user_id', Auth::user()->id)->get();
        return view('front.compare.index',compact('compare'));
        
    }
    public function destroy(Request $request,$id)
    {
        
        Compare::findOrFail($id)->delete();
        Session::flash('success', __('Delete Successfully'));
        return back();

        
    }
}
