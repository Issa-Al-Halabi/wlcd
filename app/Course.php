<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Spatie\Translatable\HasTranslations;

class Course extends Model
{
    use HasTranslations;

    public $translatable = ['title', 'short_detail', 'detail', 'requirement', 'level_tags'];
    /**
     * Convert the model instance to an array.
     *
     * @return array
     */
    public function toArray()
    {
        $attributes = parent::toArray();

        foreach ($this->getTranslatableAttributes() as $name) {
            $attributes[$name] = $this->getTranslation($name, app()->getLocale());
        }

        return $attributes;
    }


    protected $table = 'courses';

    protected $fillable = [
        'category_id', 'childcategory_id', 'subcategory_id', 'language_id', 'user_id', 'title',
        'short_detail', 'detail', 'price', 'discount_price', 'day', 'video', 'video_url', 'featured',
        'requirement', 'url', 'slug', 'status', 'preview_image','thumble_preview_image', 'type', 'preview_type', 'duration',
        'duration_type', 'instructor_revenue', 'involvement_request', 'refund_policy_id', 'assignment_enable',
        'appointment_enable','course_type', 'certificate_enable', 'course_tags', 'level_tags', 'reject_txt', 'drip_enable',
        'institude_id', 'country', 'start_date', 'new_course_mail', 'vr_code', 'vr_hole', 'end_date'
    ];

    protected $casts = [
        'course_tags' => 'array',
        'country' => 'array',
    ];

    public function chapter()
    {
        return $this->hasMany('App\CourseChapter', 'course_id');
    }

    public function whatlearns()
    {
        return $this->hasMany('App\WhatLearn', 'course_id');
    }

    public function progress()
    {
        return $this->hasMany('App\CourseProgress', 'course_id');
    }

    public function include()
    {
        return $this->hasMany('App\CourseInclude', 'course_id');
    }

    public function related()
    {
        return $this->hasMany('App\RelatedCourse', 'main_course_id');
    }

    public function question()
    {
        return $this->hasMany('App\Question', 'course_id');
    }

    public function answer()
    {
        return $this->hasMany('App\Answer', 'course_id');
    }

    public function announsment()
    {
        return $this->hasMany('App\Announcement', 'course_id');
    }

    public function courseclass()
    {
        return $this->hasMany('App\CourseClass', 'course_id');
    }

    public function favourite()
    {
        return $this->hasMany('App\Favourite', 'course_id');
    }

    public function wishlist()
    {
        return $this->hasMany('App\Wishlist', 'course_id');
    }

    public function review()
    {
        return $this->hasMany('App\ReviewRating', 'course_id');
    }

    public function reportreview()
    {
        return $this->hasMany('App\ReportReview', 'course_id');
    }

    public function instructor()
    {
        return $this->hasMany('App\Question', 'instructor_id');
    }

    public function order()
    {
        return $this->hasMany('App\Order', 'course_id');
    }

    public function pending()
    {
        return $this->hasMany('App\PendingPayout', 'course_id');
    }

    public function category()
    {
        return $this->belongsTo('App\Categories', 'category_id', 'id')->withDefault();
    }

    public function subCategory()
    {
        return $this->belongsTo('App\SubCategory', 'subcategory_id', 'id')->withDefault();
    }

    public function childCategory()
    {
        return $this->belongsTo('App\ChildCategory', 'childcategory_id', 'id')->withDefault();
    }

    public function language()
    {
        return $this->belongsTo('App\CourseLanguage', 'language_id', 'id')->withDefault();
    }

    public function user()
    {
        return $this->belongsTo('App\User', 'user_id', 'id')->withDefault();
    }

    public function policy()
    {
        return $this->belongsTo('App\RefundPolicy', 'refund_policy_id', 'id')->withDefault();
    }

    public function quiztopic()
    {
        return $this->hasMany('App\QuizTopic', 'course_id');
    }

    public function scopeSearch($query, $searchTerm)
    {
        return $query->where('title', 'like', '%' . $searchTerm . '%');
    }

    public function scopeFilter($query)
    {
        // $user = Auth::user();

        $query
            ->when(request()->status == 1, function ($query) {
                return $query->where('status', 1);
            })
            ->when(request()->has_discount == 1, function ($query) {
                return $query->where('discount_price', '!=', null)->where('discount_price', '!=', 0);
            })
            ->when(request()->featured == 1, function ($query) {
                return $query->where('featured', 1);
            })
            ->when(isset(request()->paid), function ($query) {
                if (request()->paid == 1) {
                    return $query->where('price', '!=', null)->where('price', '!=', '')->where('price', '!=', 0);
                } else {
                    return $query->where('price', NULL)->orWhere('price', '')->orWhere('price', 0);
                }
            })
            ->when(request()->category_id, function ($query) {
                return $query->where('category_id', request()->category_id);
            })
            ->when(request()->subcategory_id, function ($query) {
                return $query->where('subcategory_id', request()->subcategory_id);
            })
            ->when(request()->childcategory_id, function ($query) {
                return $query->where('childcategory_id', request()->childcategory_id);
            })
            ->when(request()->language_id, function ($query) {
                return $query->where('language_id', request()->language_id);
            })
            ->when(request()->level, function ($query) {
                return $query->where("level_tags->en", request()->level);
            })
            ->when(request()->search, function ($query) {
                return $query->where(DB::raw("lower(title)"), 'like', '%' . strtolower(request()->search) . '%')
                    ->orWhere("title->ar", 'like', '%' . request()->search . '%');
            })
            ->when(isset(request()->sort_by_title), function ($query) {
                $sortOrder = request()->sort_by_title == '1' ? 'ASC' : 'DESC';
                return $query->orderBy('title', $sortOrder, request()->lang);
            })
            ->when(isset(request()->recent), function ($query) {
                $sortOrder = request()->recent == '1' ? 'ASC' : 'DESC';
                return $query->orderBy('created_at', $sortOrder);
            });

    }
    
}
