<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
 
#[Fillable(['title','slug','subheading','excerpt','status','allow_comments','featured_image',
'featured_image_caption','content','meta_title','meta_description','user_id','category_id','deleted_at'])]
class Post extends Model
{
    //




    public function user()
    {
        return $this->belongsTo(User::class,'user_id');
    }

    public function category()
    {
        return $this->belongsTo(Category::class,'category_id');
    }

     public function media()
    {
        return $this->belongsTo(Media::class,'media_id');
    }

      public function comments()
    {
        return $this->hasMany(Comment::class, 'post_id');
    }

       public function tags()
    {
        return $this->hasMany(PostTag::class, 'post_id');
    }

        public function secondarycategories()
    {
        return $this->hasMany(PostSecondaryCategory::class, 'post_id');
    }
}
