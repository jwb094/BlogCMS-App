<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;

#[Fillable(['filename','path','mime_type','file_size','width','height','user_id'])]
class Media extends Model
{
    //

      public function user()
    {
        return $this->belongsTo(User::class,'user_id');
    }
}
