<?php

namespace App\Http\Controllers\Api;

use App\Blog;
use App\Http\Controllers\Controller;
use App\Http\Resources\BlogResource;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    //
    public function blog(Request $request)
    {
        $blog = Blog::where('status', 1)->get();
        return response()->json(['blog' => BlogResource::collection($blog)], 200);
    }

    public function blogdetail(Request $request)
    {

        $blog = Blog::where('id', $request->blog_id)
            ->where('status', 1)
            ->with('user')
            ->get();

        return response()->json(['blog' => $blog], 200);
    }

    public function recentblog(Request $request)
    {
       
        $blog = Blog::where('status', 1)
            ->orderBy('id', 'DESC')->take(5)
            ->get();

        return response()->json(['blog' => $blog], 200);
    }
}
