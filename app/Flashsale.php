<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;


class Flashsale extends Model
{
    use HasTranslations;
    
    public $translatable = ['title', 'detail'];

    protected $fillable = [
        'title','start_date','end_date','background_image','detail','status'
    ];

    public function saleitems(){
        return $this->hasMany(FlashSaleItem::class,'sale_id');
    }
    public function toArray()
    {
      $attributes = parent::toArray();
      
      foreach ($this->getTranslatableAttributes() as $name) {
          $attributes[$name] = $this->getTranslation($name, app()->getLocale());
      }
      
      return $attributes;
    }  
}
