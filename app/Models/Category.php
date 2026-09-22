<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;

#[Fillable (['name', 'slug','description','meta_description','meta_title'])]
class Category extends Model
{

       public function posts()
    {
        return $this->hasMany(Post::class, 'category_id');
    }
}
