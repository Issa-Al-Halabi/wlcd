<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class About extends Model
{
  use HasTranslations;

  public $translatable = [
    'about_description', 'one_heading', 'one_text',

    'two_heading', 'two_text', 'two_first_title', 'two_first_text', 'two_second_title', 'two_second_text', 'two_third_title', 'two_third_text',

    'three_first_heading', 'three_first_text','three_second_heading', 'three_second_text',
  ];

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

  protected $table = 'abouts';

  protected $fillable = [
    'about_description', 'one_heading', 'one_text', 'one_first_image', 'one_second_image', 'one_third_image',

    'two_heading', 'two_text', 'two_first_title', 'two_first_text', 'two_first_image', 'two_second_title',
    'two_second_text', 'two_second_image', 'two_third_title', 'two_third_text', 'two_third_image',

    'three_first_heading', 'three_first_text', 'three_first_image',
    'three_second_heading', 'three_second_text', 'three_second_image',

    'facebook_link', 'twitter_link', 'instagram_link', 'linkedin_link',
  ];
}
