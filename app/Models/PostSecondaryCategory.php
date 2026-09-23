<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Attributes\Fillable;
 use Illuminate\Database\Eloquent\Factories\HasFactory;
#[Fillable(['post_id','category_id'])]
class PostSecondaryCategory extends Model
{
    //
  use HasFactory;

        public function posts()
    {
        return $this->hasMany(PostSecondaryCategory::class, 'category_id');
    }
}
