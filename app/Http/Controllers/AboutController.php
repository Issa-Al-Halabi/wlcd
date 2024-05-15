<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\About;
use Spatie\Permission\Models\Role;
use App\Http\Traits\TranslationTrait;

class AboutController extends Controller
{
    use TranslationTrait;

    public function __construct()
    {
        $this->middleware('permission:about.manage', ['only' => ['show', 'about']]);
    }
    public function show()
    {
        $data = About::first();
        return view('admin.about.edit', compact('data'));
    }

    public function update(Request $request)
    {
        $about = About::first();

        $input = $this->getTranslatableRequest($about->getTranslatableAttributes(), $request->all(), [$request->lang]);


        if (isset($about)) {

            if ($file = $request->file('one_first_image')) {
                if ($about->one_first_image != "") {
                    $image_file = @file_get_contents(public_path() . '/images/about/' . $about->one_first_image);

                    if ($image_file) {
                        unlink('images/about/' . $about->one_first_image);
                    }
                }
                $name = time() . '_' . $file->getClientOriginalName();
                $name = str_replace(" ", "_", $name);
                $file->move('images/about', $name);
                $input['one_first_image'] = $name;
            }
            
            if ($file = $request->file('one_second_image')) {
                if ($about->one_second_image != "") {
                    $image_file = @file_get_contents(public_path() . '/images/about/' . $about->one_second_image);

                    if ($image_file) {
                        unlink('images/about/' . $about->one_second_image);
                    }
                }
                $name = time() . '_' . $file->getClientOriginalName();
                $name = str_replace(" ", "_", $name);
                $file->move('images/about', $name);
                $input['one_second_image'] = $name;
            }

            if ($file = $request->file('one_third_image')) {
                if ($about->one_third_image != "") {
                    $image_file = @file_get_contents(public_path() . '/images/about/' . $about->one_third_image);

                    if ($image_file) {
                        unlink('images/about/' . $about->one_third_image);
                    }
                }
                $name = time() . '_' . $file->getClientOriginalName();
                $name = str_replace(" ", "_", $name);
                $file->move('images/about', $name);
                $input['one_third_image'] = $name;
            }

            if ($file = $request->file('two_first_image')) {
                if ($about->two_first_image != "") {
                    $image_file = @file_get_contents(public_path() . '/images/about/' . $about->two_first_image);

                    if ($image_file) {
                        unlink('images/about/' . $about->two_first_image);
                    }
                }
                $name = time() . '_' . $file->getClientOriginalName();
                $name = str_replace(" ", "_", $name);
                $file->move('images/about', $name);
                $input['two_first_image'] = $name;
            }

            if ($file = $request->file('two_second_image')) {
                if ($about->two_second_image != "") {
                    $image_file = @file_get_contents(public_path() . '/images/about/' . $about->two_second_image);

                    if ($image_file) {
                        unlink('images/about/' . $about->two_second_image);
                    }
                }
                $name = time() . '_' . $file->getClientOriginalName();
                $name = str_replace(" ", "_", $name);
                $file->move('images/about', $name);
                $input['two_second_image'] = $name;
            }

            if ($file = $request->file('two_third_image')) {
                if ($about->two_third_image != "") {
                    $image_file = @file_get_contents(public_path() . '/images/about/' . $about->two_third_image);

                    if ($image_file) {
                        unlink('images/about/' . $about->two_third_image);
                    }
                }
                $name = time() . '_' . $file->getClientOriginalName();
                $name = str_replace(" ", "_", $name);
                $file->move('images/about', $name);
                $input['two_third_image'] = $name;
            }

            if ($file = $request->file('three_first_image')) {
                if ($about->three_first_image != "") {
                    $image_file = @file_get_contents(public_path() . '/images/about/' . $about->three_first_image);

                    if ($image_file) {
                        unlink('images/about/' . $about->three_first_image);
                    }
                }
                $name = time() . '_' . $file->getClientOriginalName();
                $name = str_replace(" ", "_", $name);
                $file->move('images/about', $name);
                $input['three_first_image'] = $name;
            }

            if ($file = $request->file('three_second_image')) {
                if ($about->three_second_image != "") {
                    $image_file = @file_get_contents(public_path() . '/images/about/' . $about->three_second_image);

                    if ($image_file) {
                        unlink('images/about/' . $about->three_second_image);
                    }
                }
                $name = time() . '_' . $file->getClientOriginalName();
                $name = str_replace(" ", "_", $name);
                $file->move('images/about', $name);
                $input['three_second_image'] = $name;
            }

            $about->save();
            $about->update($input);
        } else {
            if ($file = $request->file('one_first_image')) {
                $name = time() . '_' . $file->getClientOriginalName();
                $name = str_replace(" ", "_", $name);
                $file->move('images/about', $name);
                $input['one_first_image'] = $name;
            }

            if ($file = $request->file('one_second_image')) {
                $name = time() . '_' . $file->getClientOriginalName();
                $name = str_replace(" ", "_", $name);
                $file->move('images/about', $name);
                $input['one_second_image'] = $name;
            }

            if ($file = $request->file('one_third_image')) {
                $name = time() . '_' . $file->getClientOriginalName();
                $name = str_replace(" ", "_", $name);
                $file->move('images/about', $name);
                $input['one_third_image'] = $name;
            }

            if ($file = $request->file('two_first_image')) {
                $name = time() . '_' . $file->getClientOriginalName();
                $name = str_replace(" ", "_", $name);
                $file->move('images/about', $name);
                $input['two_first_image'] = $name;
            }

            if ($file = $request->file('two_second_image')) {
                $name = time() . '_' . $file->getClientOriginalName();
                $name = str_replace(" ", "_", $name);
                $file->move('images/about', $name);
                $input['two_second_image'] = $name;
            }
            
            if ($file = $request->file('two_third_image')) {
                $name = time() . '_' . $file->getClientOriginalName();
                $name = str_replace(" ", "_", $name);
                $file->move('images/about', $name);
                $input['two_third_image'] = $name;
            }

            if ($file = $request->file('three_first_image')) {
                $name = time() . '_' . $file->getClientOriginalName();
                $name = str_replace(" ", "_", $name);
                $file->move('images/about', $name);
                $input['three_first_image'] = $name;
            }

            if ($file = $request->file('three_second_image')) {
                $name = time() . '_' . $file->getClientOriginalName();
                $name = str_replace(" ", "_", $name);
                $file->move('images/about', $name);
                $input['three_second_image'] = $name;
            }

            $data = About::create($input);

            $data->save();
        }

        return back()->with('success', trans('flash.UpdatedSuccessfully'));
    }

    public function aboutpage()
    {
        $about = About::first();
        return view('front.about', compact('about'));
    }
}
