<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Attributes\Fillable;

#[Fillable(['post_id','tag_id'])]
class PostTag extends Model
{
    //


        public function posts()
    {
        return $this->hasMany(PostTag::class, 'tag_id');
    }
}
