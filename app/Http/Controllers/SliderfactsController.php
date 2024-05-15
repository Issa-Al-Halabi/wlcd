<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\SliderFacts;
use DB;
use Session;
use Spatie\Permission\Models\Role;

class SliderfactsController extends Controller
{
	public function __construct()
    {
		$this->middleware('permission:front-settings.fact-slider.view', ['only' => ['index']]);
		$this->middleware('permission:front-settings.fact-slider.create', ['only' => ['create','store']]);
		$this->middleware('permission:front-settings.fact-slider.edit', ['only' => ['edit','update']]);
		$this->middleware('permission:front-settings.fact-slider.delete', ['only' => ['destroy']]);

    }

	public function index()
	{
		$facts = SliderFacts::all();
		return view('admin.slider_facts.index',compact('facts'));
	}

	public function create()
	{
		return view('admin.slider_facts.create');
	}

	public function store(Request $request)
	{
		
		$data = $this->validate($request, [
            'icon'           => 'required',
            'heading_ar'     => 'required',
			'heading_en'     => 'required',
			'sub_heading_ar' => 'required',
			'sub_heading_en' => 'required',

        ]);

        $input = $request->all();

		$input['heading']['en'] = $input['heading_en'];
        $input['heading']['ar'] = $input['heading_ar'];

		$input['sub_heading']['en'] = $input['sub_heading_en'];
        $input['sub_heading']['ar'] = $input['sub_heading_en'];

        $data = SliderFacts::create($input);
        $data->save();

    	Session::flash('success','Added Successfully !');
        return redirect()->route('facts.index');
	}

   	public function show(Request $request)
	{
		//
	}

	public function edit($id)
	{
		$show = SliderFacts::where('id', $id)->first();
    	return view('admin.slider_facts.edit', compact('show')); 
	}

    public function update(Request $request, $id)
    {
    	$this -> validate($request,[
            'icon'           => 'required',
            'heading_ar'     => 'required',
			'heading_en'     => 'required',
            'sub_heading_ar' => 'required',
			'sub_heading_en' => 'required',
        ]);

        $data = SliderFacts::findorfail($id);
        $input = $request->all();
		$input['heading']['en'] = $input['heading_en'];
        $input['heading']['ar'] = $input['heading_ar'];

		$input['sub_heading']['en'] = $input['sub_heading_en'];
        $input['sub_heading']['ar'] = $input['sub_heading_en'];

        $data->update($input);
      
        Session::flash('success', trans('flash.UpdatedSuccessfully'));
     	return redirect()->route('facts.index');
    }

    public function destroy($id)
    {
    	DB::table('slider_facts')->where('id',$id)->delete();
        return redirect()->route('facts.index');
    }
}
