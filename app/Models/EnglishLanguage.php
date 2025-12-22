<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EnglishLanguage extends Model
{
   protected $guarded = [];

   public function user()
    {
        return $this->hasMany(User::class);
    }
}
