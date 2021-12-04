<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Post extends Model
{
    //
    use SoftDeletes;
    protected $fillable = ['title', 'content', 'thumbnail', 'status', 'post_cat', 'creator', 'cat_id'];
}
