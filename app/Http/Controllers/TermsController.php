<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Terms;
use Spatie\Permission\Models\Role;
use App\Http\Traits\TranslationTrait;


class TermsController extends Controller
{
    use TranslationTrait;

    public function __construct()
    {

        $this->middleware('permission:terms-condition.manage', ['only' => ['show', 'update', 'showpolicy', 'updatepolicy']]);
    }
    public function show()
    {
        $items = Terms::first();
        return view('admin.terms.edit_terms', compact('items'));
    }

    public function update(Request $request)
    {

        $data = Terms::first();
        $input = $this->getTranslatableRequest($data->getTranslatableAttributes(), $request->all(), [$request->lang]);

        if (isset($data)) {
            $data->update($input);
        } else {
            $data = Terms::create($input);

            $data->save();
        }

        return back()->with('success', trans('flash.UpdatedSuccessfully'));
    }

    public function showpolicy()
    {
        $items = Terms::first();
        return view('admin.terms.edit_policy', compact('items'));
    }

    public function updatepolicy(Request $request)
    {

        $data = Terms::first();
        $input = $this->getTranslatableRequest($data->getTranslatableAttributes(), $request->all(), [$request->lang]);

        if (isset($data)) {
            $data->update($input);
        } else {
            $data = Terms::create($input);
            $data->save();
        }

        return back()->with('success', trans('flash.UpdatedSuccessfully'));
    }
}
