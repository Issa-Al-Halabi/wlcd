<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FavSubcategory extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'subcategory_id'
    ];

    // one to many
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
