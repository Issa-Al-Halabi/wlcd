<?php

namespace App\Http\Controllers\Api;

use App\Categories;
use App\ChildCategory;
use App\Course;
use App\FavCategory;
use App\FavSubcategory;
use App\Helpers\Is_wishlist;
use App\Http\Controllers\Controller;
use App\Http\Resources\FavCategoryResource;
use App\SubCategory;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Laravolt\Avatar\Avatar;
use App\Helpers\CategoryHelper;

class CategoryController extends Controller
{
    //
    public function getFavCategories(Request $request)
    {
        $categories = Categories::with('favoritedBy')->get();
        
        return response()->json(['category' => FavCategoryResource::collection($categories)], 200);
    }

    public function addToFavCategories(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'favCategories' => 'array',
        ]);
        $auth = Auth::guard('api')->user();

        $auth->favCategories()->delete();
        foreach ($request->favCategories as $categoryId) {
            $auth->favCategories()->create(['category_id' => $categoryId]);
        }
        
        $subCategories = SubCategory::whereIn('category_id', $request->favCategories)
            ->with(['favoritedBy' => function ($query) use ($auth) {
         $query->where('user_id', $auth->id);
         }])
         ->get();

         $result = $subCategories->map(function ($category) use ($auth) {
            $checked = $category->favoritedBy->isNotEmpty() ? 1 : 0;


        return [
            'id' => $category->id,
            'category_id' => $category->category_id,
            'title' => $category->title,
            'icon' => $category->icon,
            'slug' => $category->slug,
            'status' => $category->status,
            'featured' => $category->featured,
            'checked' => $checked,
            'created_at' => $category->created_at,
            'updated_at' => $category->updated_at,
        ];
        })->all();


        return response()->json(['subCategories' => $result], 200);
    }

    public function addToFavSubcategories(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'favSubcategories' => 'array',
        ]);


        $auth = Auth::guard('api')->user();
        $auth->favSubcategoies()->delete();
        foreach ($request->favSubcategories as $subcategoryId) {
            $auth->favSubcategoies()->create(['subcategory_id' => $subcategoryId]);
        }

        $courses = Course::whereIn('subcategory_id', $request->favSubcategories)->get();

        return response()->json(['$courses' => $courses], 200);
    }

    public function getcategoryCourse($catid)
    {
        $cat = Categories::whereHas('courses.user')
            ->where('status', '1')
            ->with(['courses.instructor'])
            ->find($catid);
    
        if ($cat) {
            $category_slider_courses = Category
            // $category_slider_courses = $cat->courses->map(function ($course) {
            //     return [
            //         'id' => $course->id,
            //         'title' => array_map(function ($lang) {
            //             return trim(preg_replace("/\r\n|\r|\n/", '', strip_tags(html_entity_decode($lang))));
            //         }, $course->getTranslations('title')),
            //         'level_tags' => $course->level_tags,
            //         'short_detail' => array_map(function ($lang) {
            //             return trim(preg_replace("/\r\n|\r|\n/", '', strip_tags(html_entity_decode($lang))));
            //         }, $course->getTranslations('short_detail')),
            //         'price' => $course->price,
            //         'discount_price' => $course->discount_price,
            //         'featured' => $course->featured,
            //         'status' => $course->status,
            //         'preview_image' => $course->preview_image,
            //         'total_rating_percent' => course_rating($course->id)->getData()->total_rating_percent,
            //         'total_rating' => course_rating($course->id)->getData()->total_rating,
            //         'imagepath' => url('images/course/' . $course->preview_image),
            //         'in_wishlist' => Is_wishlist::in_wishlist($course->id),
            //         'instructor' => [
            //             'id' => $course->user->id,
            //             'name' => $course->user->fname . ' ' . $course->user->lname,
            //             'image' => url('/images/user_img/' . $course->user->user_img),
            //         ],
            //     ];
            // });
    
            return response()->json([
                'course' => $category_slider_courses,
            ]);
        } else {
            return response()->json([
                'course' => null,
                'msg' => 'No courses or category found!',
            ]);
        }
    }
    
    public function categoryPage(Request $request, $id, $name)
    {
        $category = CategoryHelper::getCategory($id);
        if (!$category) {
            return response()->json(['Invalid Category !']);
        }
        $subcategory = CategoryHelper::getSubcategories($category);

        if ($request->type) {
            $course = CategoryHelper::getFilteredCourses($category, $request->type, $request->limit);
        } elseif ($request->sortby) {
            $course = CategoryHelper::getSortedCourses($category, $request->sortby, $request->type, $request->limit);
        } else {
            $course = CategoryHelper::getCategoryCourses($category, $request->limit);
        }

        $result = CategoryHelper::formatCategoryData($category, $subcategory, $course);

        return response()->json($result, 200);
    }

    public function subcategoryPage(Request $request, $id, $name)
    {
        $category = SubCategory::where('id', $id)->first();
        if (!$category) {
            return response()->json(['Invalid Category !']);
        }

        $subcategory = ChildCategory::where('status', 1)
            ->where('subcategory_id', $category->id)
            ->get();

        if ($request->type) {
            $course = CategoryHelper::getFilteredCourses($category, $request->type, $request->limit);
        } elseif ($request->sortby) {
            $course = CategoryHelper::getSortedCourses($category, $request->sortby, $request->type, $request->limit);
        } else {
            $course = CategoryHelper::getCategoryCourses($category, $request->limit);
        }

        $result = CategoryHelper::formatSubcategoryData($category, $subcategory, $course);

        return response()->json($result, 200);
    }
    public function childcategoryPage(Request $request, $id, $name)
    {
        $category = ChildCategory::where('id', $id)->first();
        if (!$category) {
            return response()->json(['Invalid Category !']);
        }

        if ($request->type) {
            $course = CategoryHelper::getFilteredCourses($category, $request->type, $request->limit);
        } elseif ($request->sortby) {
            $course = CategoryHelper::getSortedCourses($category, $request->sortby, $request->type, $request->limit);
        } else {
            $course = CategoryHelper::getCategoryCourses($category, $request->limit);
        }

        $result = CategoryHelper::formatChildcategoryData($category, $course);

        return response()->json($result, 200);
    }
}
