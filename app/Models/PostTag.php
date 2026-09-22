<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PostTag extends Model
{
    //


        public function posts()
    {
        return $this->hasMany(PostTag::class, 'tag_id');
    }
}
