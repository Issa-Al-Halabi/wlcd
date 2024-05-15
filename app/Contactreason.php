<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contactreason extends Model
{
    use HasFactory;
    protected $fillable = ['status', 'reason'];

    // one to many
    public function contacts()
    {
        return $this->hasMany(Contact::class);
    }
}
