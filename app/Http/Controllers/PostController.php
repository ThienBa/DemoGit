<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Post;
use App\Product;

class PostController extends Controller
{
    //
    function show(){
        $posts = Post::where('status', 2)->paginate(10);
        $product_selling = Product::where('qty', '<=', 5)->limit(10)->get();
        return view('post.show', compact('posts', 'product_selling'));
    }

    function detail($id){
        $post = Post::find($id);
        $product_selling = Product::where('qty', '<=', 5)->limit(10)->get();
        return view('post.detail', compact('post', 'product_selling'));
    }
}
