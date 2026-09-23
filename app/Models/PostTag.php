<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Attributes\Fillable;
 use Illuminate\Database\Eloquent\Factories\HasFactory;
#[Fillable(['post_id','tag_id'])]
class PostTag extends Model
{
    //
      use HasFactory;


        public function posts()
    {
        return $this->hasMany(PostTag::class, 'tag_id');
    }
}
