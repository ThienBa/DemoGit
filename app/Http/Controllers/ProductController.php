<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Product;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    //
    function show(Request $request){
        $select = $request->input('select');
        if($select){
            if($select == 1){
                $products = Product::where('status', 2)->orderBy('name', 'desc')->paginate(12);
            }elseif($select == 2){
                $products = Product::where('status', 2)->orderBy('name')->paginate(12);
            }elseif($select == 3){
                $products = Product::where('status', 2)->orderBy('price', 'desc')->paginate(12);
            }elseif($select == 4){
                $products = Product::where('status', 2)->orderBy('price')->paginate(12);
            }
        }else{
            $products = Product::where('status', 2)->paginate(12);
        }

        $count_total = Product::where('status', 2)->count();
        $count_products = $products->count();
        $count = [$count_products, $count_total];
        return view('product.show', compact('products', 'count'));
    }

    function detail($id){
        $product = Product::find($id);
        $product_selling = Product::where('qty', '<=', 5)->limit(10)->get();
        return view('product.detail', compact('product', 'product_selling'));
    }

    function list(Request $request, $cat_id){
        $select = $request->input('select');
        if($select){
            if($select == 1){
                $products = Product::where('cat_id', $cat_id)->where('status', 2)->orderBy('name', 'desc')->paginate(12);
            }elseif($select == 2){
                $products = Product::where('cat_id', $cat_id)->where('status', 2)->orderBy('name')->paginate(12);
            }elseif($select == 3){
                $products = Product::where('cat_id', $cat_id)->where('status', 2)->orderBy('price', 'desc')->paginate(12);
            }elseif($select == 4){
                $products = Product::where('cat_id', $cat_id)->where('status', 2)->orderBy('price')->paginate(12);
            }
        }else{
            $products = Product::where('cat_id', $cat_id)->where('status', 2)->paginate(12);
        }
        $product_selling = Product::where('qty', '<=', 5)->limit(10)->get();

        $count_total = Product::where('cat_id', $cat_id)->where('status', 2)->count();
        $count_products = $products->count();
        $count = [$count_products, $count_total];

        return view('product.list', compact('products', 'product_selling', 'count'));
    }

    function show_cat(Request $request, $cat_name){
        $select = $request->input('select');
        if($select){
            if($select == 1){
                $products = Product::where('name', 'LIKE', "%{$cat_name}%")->where('status', 2)->orderBy('name', 'desc')->paginate(12);
            }elseif($select == 2){
                $products = Product::where('name', 'LIKE', "%{$cat_name}%")->where('status', 2)->orderBy('name')->paginate(12);
            }elseif($select == 3){
                $products = Product::where('name', 'LIKE', "%{$cat_name}%")->where('status', 2)->orderBy('price', 'desc')->paginate(12);
            }elseif($select == 4){
                $products = Product::where('name', 'LIKE', "%{$cat_name}%")->where('status', 2)->orderBy('price')->paginate(12);
            }
        }else{
            $products = Product::where('name', 'LIKE', "%{$cat_name}%")->where('status', 2)->paginate(12);
        }
        $product_selling = Product::where('qty', '<=', 5)->limit(10)->get();

        $count_total = Product::where('name', 'LIKE', "%{$cat_name}%")->where('status', 2)->count();
        $count_products = $products->count();
        $count = [$count_products, $count_total];

        return view('product.show_cat', compact('products', 'product_selling', 'count'));
    }

    function search_fillter(Request $request) {
            $output = "";
            $value_price = $request->get('value_price');
            $value_brand = $request->get('value_brand');
            $value_type = $request->get('value_type');
           
            if(!empty($value_price)){
                if(!empty($value_brand) && !empty($value_type)){
                    $result = Product::where('price', '<', $value_price)
                    ->where('name', 'LIKE', "%{$value_brand}%")
                    ->where('cat_id', $value_type)
                    ->get();
                }elseif(!empty($value_brand) && empty($value_type)){
                    $result = Product::where('price', '<', $value_price)
                    ->where('name', 'LIKE', "%{$value_brand}%")
                    ->get();
                }elseif(empty($value_brand) && !empty($value_type)){
                    $result = Product::where('price', '<', $value_price)
                    ->where('cat_id', $value_type)
                    ->get(); 
                }else{
                    $result = Product::where('price', '<', $value_price)
                    ->orderBy('price', 'desc')
                    ->get();
                }
            }else{
                if(!empty($value_brand) && !empty($value_type)){
                    $result = Product::where('name', 'LIKE', "%{$value_brand}%")
                    ->where('cat_id', $value_type)
                    ->get();
                }elseif(empty($value_brand) && !empty($value_type)){
                    $result = Product::where('cat_id', $value_type)
                    ->get();
                }elseif(!empty($value_brand) && empty($value_type)){
                    $result = Product::where('name', 'LIKE', "%{$value_brand}%")
                    ->get();
                }
            }
            $count = count($result);
            if($count == 0){
                return "Không có kết quả tìm kiếm nào cho danh mục trên.";
            }   

            if(!empty($result)){
                $output .= "<h1>Tìm thấy <b>{$count}</b> kết quả !</h1><br>";
                $output .= "<div class='section' id='list-product-wp'>";
                $output .= "<div class='section-detail'>";
                $output .= "<ul class='list-item clearfix'>";
                foreach ($result as &$item){
                    $item_price = number_format($item->price, 0, '', '.').'đ';
                    $slug = Str::slug($item->name);
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
                    $output .= "</li>"; 
                }
                $output .= "</ul>";
                $output .= "</div>";
                $output .= "</div>";
                return $output;
            } 
    }
}
