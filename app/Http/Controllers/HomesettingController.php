<?php

namespace App\Http\Controllers;

use App\Homesetting;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;


class HomesettingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
   
    public function __construct()
    {
        $this->middleware('permission:homepage-setting.manage', ['only' => ['index','update']]);
    }
    public function index()
    {
        $hsetting = Homesetting::first();
        return view('admin.homepage.setting',compact('hsetting'));
    }

   
    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateHomesettingRequest  $request
     * @param  \App\Homesetting  $homesetting
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        // return $request;
        try {

            $hsetting = Homesetting::first();
            // $input = array_filter($request->all());
            if ($hsetting) {
                $hsetting->fact_enable = isset($request->fact_enable) ? 1 : 0;
                $hsetting->discount_enable = isset($request->discount_enable) ? 1 : 0;
                $hsetting->purchase_enable = isset($request->purchase_enable) ? 1 : 0;
                $hsetting->recentcourse_enable = isset($request->recentcourse_enable) ? 1 : 0;
                $hsetting->featured_enable = isset($request->featured_enable) ? 1 : 0;
                $hsetting->bundle_enable = isset($request->bundle_enable) ? 1 : 0;
                $hsetting->bestselling_enable = isset($request->bestselling_enable) ? 1 : 0;
                $hsetting->batch_enable = isset($request->batch_enable) ? 1 : 0;
                $hsetting->livemeetings_enable = isset($request->livemeetings_enable) ? 1 : 0;
                $hsetting->blog_enable = isset($request->blog_enable) ? 1 : 0;
                $hsetting->became_enable = isset($request->became_enable) ? 1 : 0;
                $hsetting->featuredcategories_enable = isset($request->featuredcategories_enable) ? 1 : 0;
                $hsetting->testimonial_enable = isset($request->testimonial_enable) ? 1 : 0;
                $hsetting->video_enable = isset($request->video_enable) ? 1 : 0;
                $hsetting->instructor_enable = isset($request->instructor_enable) ? 1 : 0;
                $hsetting->save();

            } else {

                $hsetting = new Homesetting;
                $hsetting->fact_enable = isset($request->fact_enable) ? 1 : 0;
                $hsetting->discount_enable = isset($request->discount_enable) ? 1 : 0;
                $hsetting->purchase_enable = isset($request->purchase_enable) ? 1 : 0;
                $hsetting->recentcourse_enable = isset($request->recentcourse_enable) ? 1 : 0;
                $hsetting->featured_enable = isset($request->featured_enable) ? 1 : 0;
                $hsetting->bundle_enable = isset($request->bundle_enable) ? 1 : 0;
                $hsetting->bestselling_enable = isset($request->bestselling_enable) ? 1 : 0;
                $hsetting->batch_enable = isset($request->batch_enable) ? 1 : 0;
                $hsetting->livemeetings_enable = isset($request->livemeetings_enable) ? 1 : 0;
                $hsetting->blog_enable = isset($request->blog_enable) ? 1 : 0;
                $hsetting->became_enable = isset($request->became_enable) ? 1 : 0;
                $hsetting->featuredcategories_enable = isset($request->featuredcategories_enable) ? 1 : 0;
                $hsetting->testimonial_enable = isset($request->testimonial_enable) ? 1 : 0;
                $hsetting->video_enable = isset($request->video_enable) ? 1 : 0;
                $hsetting->instructor_enable = isset($request->instructor_enable) ? 1 : 0;
                $hsetting->save();
            }
            return redirect()->route('homepage.setting')->with('success', trans('flash.UpdatedSuccessfully'));

        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

  
}
