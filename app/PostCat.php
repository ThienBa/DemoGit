<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PostCat extends Model
{
    //
    protected $fillable = ['name', 'level', 'status', 'creator'];
}
