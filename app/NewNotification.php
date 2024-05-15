<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NewNotification extends Model
{
    use HasFactory;

    protected $fillable = ['body'];

    // many to many
    public function users()
    {
        return $this->belongsToMany(User::class, 'notification_user', 'notification_id' ,'user_id');
    }

}
