<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{
    //
    use SoftDeletes;

    protected $fillable = ['name', 'email', 'phone_number', 'address', 'qty', 'price', 'pay_method', 'notice', 'product_id'];
    function product(){
        return $this->belongsTo("App\Product");
    }
}
