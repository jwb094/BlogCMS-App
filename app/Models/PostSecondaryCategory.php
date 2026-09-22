<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PostSecondaryCategory extends Model
{
    //


        public function posts()
    {
        return $this->hasMany(PostSecondaryCategory::class, 'category_id');
    }
}
