<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

#[Fillable(['name', 'slug', 'description', 'meta_description', 'meta_title'])]
class Tag extends Model
{
  //

  use HasFactory;



  public function posts(): BelongsToMany
  {
    return $this->belongsToMany(
      Post::class,
      'post_tags'
    );
  }
}
