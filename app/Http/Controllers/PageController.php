<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Page;
use App\Product;

class PageController extends Controller
{
    //
    function detail($id){
        $page = Page::find($id);
        $product_selling = Product::where('qty', '<=', 5)->limit(10)->get();
        return view('page.detail', compact('page', 'product_selling'));
    }
}
