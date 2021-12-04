<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Product;
use App\Post;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    public function index()
    {
        $product_standout = Product::orderBy('created_at', 'desc')->get();
        $product_selling = Product::where('qty', '<=', 5)->limit(10)->get();
        $product_phone = Product::where('cat_id', 1)->where('status', 2)->get();
        $product_laptop = Product::where('cat_id', 2)->where('status', 2)->get();
        $product_tablet = Product::where('cat_id', 4)->where('status', 2)->get();
        return view('home', compact('product_selling', 'product_standout', 'product_phone', 'product_laptop', 'product_tablet'));
    }

    function search_header(Request $request){
        if($request->has('search')){
            $text = $request->search;
            $output = "";
            if($text){
                $result_product = Product::where('name', 'LIKE', "%{$text}%")->orwhere('price', 'LIKE', "%{$text}%")->get();
                $count_product = Product::where('name', 'LIKE', "%{$text}%")->orwhere('price', 'LIKE', "%{$text}%")->count();

                if($count_product > 0){
                    $output .= "<h1>Tìm thấy {$count_product} kết quả cho từ khóa <b>'{$text}'</b></h1><br>";
                    $output .= "<div class='section' id='list-product-wp'>";
                    $output .= "<div class='section-detail'>";
                        $output .= "<ul class='list-item clearfix'>";
                            foreach ($result_product as &$item){
                                $slug = Str::slug($item->name);
                                $item_price = number_format($item->price, 0, '', '.').'đ';
                                $output .= "<li>";
                                    $output .= "<a href='http://localhost:8080/IsMart/san-pham/{$item->id}-{$slug}' title='' class='thumb'>
                                        <img src='http://localhost:8080/IsMart/public/{$item->thumbnail}'>
                                    </a>
                                    <a href='http://localhost:8080/IsMart/san-pham/{$item->id}-{$slug}' title='' class='product-name'>{$item->name}</a>
                                    <div class='price'>
                                        <span class='new'>{$item_price}</span>
                                    </div>
                                    <div class='action clearfix'>
                                        <a href='http://localhost:8080/IsMart/them-gio-hang/{$item->id}-{$slug}' title='' class='add-cart fl-left'>Thêm giỏ hàng</a>
                                        <a href='http://localhost:8080/IsMart/mua-ngay/{$item->id}-{$slug}' title='' class='buy-now fl-right'>Mua ngay</a>
                                    </div>";
                                    $output .= "
                                </li>";
                            }
                            $output .= "</ul>";
                        $output .= "</div>";
                    $output .= "</div>";
                    return $output;
                }else{
                    if($count_product <= 0){
                        $result_post = Post::where('title', 'LIKE', "%{$text}%")->get();
                        $count = Post::where('title', 'LIKE', "%{$text}%")->count();
                        if($result_post){
                            $output .= "<h1>Tìm thấy {$count} kết quả cho từ khóa <b>'{$text}'</b></h1><br>";
                            $output .= "<div class='section' id='list-blog-wp'>";
                            $output .= "<div class='section-detail'>";
                            $output .= "<ul class='list-item clearfix'>";
                                    foreach ($result_post as &$item){
                                        $slug = Str::slug($item->title);
                                        if($item->cat_id == 1) $item->name = 'Điện thoại'; else $item->name = 'Máy tính - Laptop';
                                        $output .= "<li class='clearfix'>";
                                            $output .= "<a href='http://localhost:8080/IsMart/bai-viet/{$item->id}-{$slug}.html' title='' class='thumb fl-left'>
                                                <img src='http://localhost:8080/IsMart/public/{$item->thumbnail}' alt=''>
                                            </a>
                                            <div class='info fl-right'>
                                                <a href='http://localhost:8080/IsMart/bai-viet/{$item->id}-{$slug}.html' title='' class='title'>{$item->title}</a>
                                                <span class='create-date'>{$item->created_at}</span>
                                                    <p class='desc'>{$item->name}</p>
                                            </div>";
                                            $output .= "
                                        </li>";
                                    }
                                    $output .= "</ul>";
                                $output .= "</div>";
                            $output .= "</div>";
                        }
                        return $output;
                    }
                }
            }else{
                return "<b>Hãy nhập từ khóa bạn muốn tìm kiếm cho sản phẩm và bài viết. Hoặc nhấn <a href='http://localhost:8080/IsMart/'>vào đây</a> để tiếp tục mua hàng.</b>";
            }
        }
    }
}
