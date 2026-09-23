<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

#[Fillable(['name', 'slug', 'description', 'meta_description', 'meta_title'])]
class Category extends Model
{
  use HasFactory;
    public function posts()
    {
        return $this->hasMany(Post::class, 'category_id');
    }
}
