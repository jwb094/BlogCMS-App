<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;

#[Fillable(['name','email','content','status','ip_address','user_id','post_id'])]
class Comment extends Model
{
    //

    public function post(){
        return $this->belongsTo(User::class,'user_id');
    }
}
