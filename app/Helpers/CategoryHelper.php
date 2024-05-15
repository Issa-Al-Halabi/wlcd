<?php

namespace App\Helpers;


use Twilio\Rest\Client;
use App\Wishlist;
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
class CategoryHelper
{ 

    public static function getCategory($id)
    {
        return Categories::where('status', '1')
            ->where('id', $id)
            ->first();
    }
    
    public static function getSubcategories($category)
    {
        return $category->subcategory()
            ->where('status', 1)
            ->get();
    }
    
    public static function getFilteredCourses($category, $type, $limit)
    {
        return $category->courses()
            ->where('status', '1')
            ->where('type', $type == 'paid' ? '1' : '0')
            ->paginate($limit ?? 10);
    }
    
    public static function getSortedCourses($category, $sortby, $type, $limit)
    {
        $query = $category->courses()->where('status', '1');
    
        switch ($sortby) {
            case 'l-h':
                $query->where('type', '1')->orderBy('price', 'DESC');
                break;
            case 'h-l':
                $query->where('type', '1')->orderBy('price', 'ASC');
                break;
            case 'a-z':
                $query->orderBy('title', 'ASC');
                break;
            case 'z-a':
                $query->orderBy('title', 'DESC');
                break;
            case 'newest':
                $query->orderBy('created_at', 'DESC');
                break;
            case 'featured':
                $query->where('featured', '1');
                break;
        }
    
        if ($type) {
            $query->where('type', $type == 'paid' ? '1' : '0');
        }
    
        return $query->paginate($limit ?? 10);
    }
    
    public static function getCategoryCourses($category, $limit)
    {
        return Course::where('status', 1)
            ->where('category_id', $category->id)
            ->paginate($limit ?? 10);
    }
    
    public static function formatCategoryData($category, $subcategory, $course)
    {
        
        return [
            'id' => $category->id,
            'title' => array_map(function ($lang) {
                return trim(preg_replace("/\r\n|\r|\n/", '', strip_tags(html_entity_decode($lang))));
            }, $category->getTranslations('title')),
            'icon' => $category->icon,
            'slug' => $category->slug,
            'status' => $category->status,
            'featured' => $category->featured,
            'image' => $category->cat_image,
            'imagepath' => url('images/category/' . $category->cat_image),
            'position' => $category->position,
            'created_at' => $category->created_at,
            'updated_at' => $category->updated_at,
            'subcategory' => $subcategory,
            'course' => $course,
        ];
    }
    public static function formatSubcategoryData($category, $subcategory, $course)
    {
        return [
            'id' => $category->id,
            'title' => array_map(function ($lang) {
                return trim(preg_replace("/\r\n|\r|\n/", '', strip_tags(html_entity_decode($lang))));
            }, $category->getTranslations('title')),
            'icon' => $category->icon,
            'slug' => $category->slug,
            'status' => $category->status,
            'image' => Avatar::create($category->title),
            'position' => $category->position,
            'created_at' => $category->created_at,
            'updated_at' => $category->updated_at,
            'childcategory' => $subcategory,
            'course' => $course,
        ];
    }
    public static function formatChildcategoryData($category, $course)
    {
        return [
            'id' => $category->id,
            'title' => array_map(function ($lang) {
                return trim(preg_replace("/\r\n|\r|\n/", '', strip_tags(html_entity_decode($lang))));
            }, $category->getTranslations('title')),
            'icon' => $category->icon,
            'slug' => $category->slug,
            'status' => $category->status,
            'featured' => $category->featured,
            'image' => Avatar::create($category->title),
            'position' => $category->position,
            'created_at' => $category->created_at,
            'updated_at' => $category->updated_at,
            'course' => $course,
        ];
    }
    public static function sliders($courses)
    {
        $category_slider_courses = $courses->map(function ($course) {
                return [
                    'id' => $course->id,
                    'title' => array_map(function ($lang) {
                        return trim(preg_replace("/\r\n|\r|\n/", '', strip_tags(html_entity_decode($lang))));
                    }, $course->getTranslations('title')),
                    'level_tags' => $course->level_tags,
                    'short_detail' => array_map(function ($lang) {
                        return trim(preg_replace("/\r\n|\r|\n/", '', strip_tags(html_entity_decode($lang))));
                    }, $course->getTranslations('short_detail')),
                    'price' => $course->price,
                    'discount_price' => $course->discount_price,
                    'featured' => $course->featured,
                    'status' => $course->status,
                    'preview_image' => $course->preview_image,
                    'total_rating_percent' => course_rating($course->id)->getData()->total_rating_percent,
                    'total_rating' => course_rating($course->id)->getData()->total_rating,
                    'imagepath' => url('images/course/' . $course->preview_image),
                    'in_wishlist' => Is_wishlist::in_wishlist($course->id),
                    'instructor' => [
                        'id' => $course->user->id,
                        'name' => $course->user->fname . ' ' . $course->user->lname,
                        'image' => url('/images/user_img/' . $course->user->user_img),
                    ],
                ];
            });
            return $category_slider_courses;
    }
}
