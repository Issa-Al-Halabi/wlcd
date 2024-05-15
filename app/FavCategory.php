<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FavCategory extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'category_id'
    ];

    // one to many
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
