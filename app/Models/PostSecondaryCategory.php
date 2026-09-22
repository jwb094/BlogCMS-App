<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Attributes\Fillable;

#[Fillable(['post_id','category_id'])]
class PostSecondaryCategory extends Model
{
    //


        public function posts()
    {
        return $this->hasMany(PostSecondaryCategory::class, 'category_id');
    }
}
