<?php

namespace App\Http\Controllers;

use App\PreviousPaper;
use Illuminate\Http\Request;
use Session;
use DB;
use Illuminate\Support\Facades\Validator;
use App\Http\Traits\TranslationTrait;

class PreviousPaperController extends Controller
{
    use TranslationTrait;

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
            'title' => 'required',
        ]);

        $paper = new PreviousPaper;
        $input = $this->getTranslatableRequest($paper->getTranslatableAttributes(), $request->all(), ['en', 'ar']);

        if ($file = $request->file('file')) {

            $path = 'files/papers/';

            if (!file_exists(public_path() . '/' . $path)) {

                $path = 'files/papers/';
                File::makeDirectory(public_path() . '/' . $path, 0777, true);
            }

            $name = time() . '_' . $file->getClientOriginalName();
            $name = str_replace(" ", "_", $name);
            $file->move('files/papers', $name);
            $input['file'] = $name;
        }

        if (isset($request->status)) {
            $input['status'] = '1';
        } else {
            $input['status'] = '0';
        }


        $data = PreviousPaper::create($input);

        $data->save();

        Session::flash('success', trans('flash.AddedSuccessfully'));
        return redirect()->route('course.show', $request->course_id);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\PreviousPaper  $previousPaper
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $paper = PreviousPaper::find($id);
        return view('admin.course.previous_paper.edit', compact('paper'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\PreviousPaper  $previousPaper
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\PreviousPaper  $previousPaper
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $data = $this->validate($request, [
            'title' => 'required',
        ]);

        $data = PreviousPaper::findorfail($id);
        $input = $this->getTranslatableRequest($data->getTranslatableAttributes(), $request->all(), [$request->lang]);


        if (isset($request->status)) {
            $input['status'] = '1';
        } else {
            $input['status'] = '0';
        }

        if ($file = $request->file('file')) {
            if ($data->file != "") {

                $path = 'files/papers/';

                if (!file_exists(public_path() . '/' . $path)) {

                    $path = 'files/papers/';
                    File::makeDirectory(public_path() . '/' . $path, 0777, true);
                }


                $chapter_file = @file_get_contents(public_path() . '/files/papers/' . $data->file);

                if ($chapter_file) {
                    unlink('files/papers/' . $data->file);
                }
            }
            $name = time() . '_' . $file->getClientOriginalName();
            $name = str_replace(" ", "_", $name);
            $file->move('files/papers', $name);
            $input['file'] = $name;
        }

        $data->update($input);

        Session::flash('success', trans('flash.UpdatedSuccessfully'));
        return redirect()->route('course.show', $request->course_id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\PreviousPaper  $previousPaper
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $papers = PreviousPaper::find($id);

        if ($papers->file != null) {

            $image_file = @file_get_contents(public_path() . '/files/papers/' . $papers->file);

            if ($image_file) {
                unlink(public_path() . '/files/papers/' . $papers->file);
            }
        }

        DB::table('previous_paper')->where('id', $id)->delete();

        return back();
    }
    public function bulk_delete(Request $request)
    {

        $validator = Validator::make($request->all(), ['checked' => 'required']);
        if ($validator->fails()) {
            return back()->with('error', trans('Please select field to be deleted.'));
        }
        PreviousPaper::whereIn('id', $request->checked)->delete();

        return back()->with('error', trans('Selected PreviousPaper has been deleted.'));
    }

    public function previouspaperstatus($id)
    {
        $previouspaper = PreviousPaper::findorfail($id);

        if ($previouspaper->status == 0) {
            DB::table('previous_paper')->where('id', '=', $id)->update(['status' => "1"]);
            return back()->with('success', 'Status changed to active !');
        } else {
            DB::table('previous_paper')->where('id', '=', $id)->update(['status' => "0"]);
            return back()->with('delete', 'Status changed to deactive !');
        }
    }
}
