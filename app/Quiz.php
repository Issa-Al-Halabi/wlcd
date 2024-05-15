<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class Quiz extends Model
{
	use HasTranslations;
    
    public $translatable = ['question', 'a', 'b', 'c', 'd'];

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

	  protected $table = 'quiz_questions';

    protected $fillable = ['course_id', 'topic_id', 'question', 'a', 'b', 'c', 'd', 'answer', 'question_video_link', 'question_img', 'type'];

    public function quizanswers()
    {
    	return $this->hasMany('App\QuizAnswer','question_id')->withDefault();
    }

    public function courses()
    {
      return $this->belongsTo('App\Course','course_id','id')->withDefault()->withDefault();
    }

    public function topic()
    {
      return $this->belongsTo('App\QuizTopic','topic_id','id')->withDefault()->withDefault();
    }
    
}
