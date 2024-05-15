<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Allcountry extends Model
{
    protected $table = 'allcountry';

    public function states(){
    	return $this->hasMany('App\Allstate','country_id');
    }
    
    public function users(){
    	return $this->hasMany('App\User','country_id');
    }
}
