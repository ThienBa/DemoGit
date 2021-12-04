<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Product;
use App\ProductCat;

class AdminProductController extends Controller
{
    //
    function __construct(){
        $this->middleware(function($request, $next){
            session(['module_active' => 'product']);
            return $next($request);
        });
    }

    function add(){
        $cats = ProductCat::all();
        return view('admin.product.add', compact('cats'));
    }

    function store(Request $request){
        $request->validate(
            [
                'name' => 'required|min:6|max:200',
                'price' => 'required|integer',
                'desc' => 'required|min:6',
                'content' => 'required',
                'file' => 'required|image',
                'category' => 'required',
                'qty' => 'required|integer'
            ],
            [
                'required' => ':attribute không được để trống',
                'integer' => ':attribute phải là số',
                'image' => ':attribute không phải dạng ảnh',
                'min' => ':attribute có ít nhất :min kí tự',
                'max' => ':attribute có tối đa :max kí tự'
            ],
            [
                'name' => 'Tên sản phẩm',
                'price' => 'Giá sản phẩm',
                'desc' => 'Mô tả ngắn',
                'content' => 'Chi tiết sản phẩm',
                'file' => 'Ảnh đại diện',
                'category' => 'Danh mục',
                'qty' => 'Số lượng sản phẩm'
            ]
        );
        
        $input = $request->all();

        if($request->hasFile('file')){
            $file = $request->file;

            $file_name = $file->getClientOriginalName();
            $path = $file->move('public/uploads', $file_name);
            $thumb_nail = 'uploads/'.$file_name;
            $input['thumbnail'] = $thumb_nail;
        }

        Product::create(
            [
                'name' => $request->input('name'),
                'price' => $request->input('price'),
                'desc' => $request->input('desc'),
                'content' => $request->input('content'),
                'thumbnail' => $input['thumbnail'],
                'cat_id' => $request->input('category'),
                'status' => $request->input('status'),
                'qty' => $request->input('qty'),
                'creator' => Auth::user()->name
            ]
        );
        return redirect('admin/product/list')->with('status', 'Thêm sản phẩm thành công!');
    }

    function list(Request $request){
        $status = $request->input('status');

        $list_action = [
            'delete' => 'Xóa tạm thời'
        ];

        if($status){
            if($status == 'pending'){
                $products = Product::where('status', 1)->paginate(10);
            }elseif($status == 'posted'){
                $products = Product::where('status', 2)->paginate(10);
            }elseif($status == 'still'){
                $products = Product::where('qty', '>', 0)->paginate(10);
            }elseif($status == 'over'){
                $products = Product::where('qty', '<=', 0)->paginate(10);
            }else{
                $list_action = [
                    'restore' => 'Khôi phục',
                    'forceDelete' => 'Xóa vĩnh viễn'
                ];
                $products = Product::onlyTrashed()->paginate(10);
            }
        }else{
            $keyword = "";
            if($request->input('keyword')){
                $keyword = $request->input('keyword');
            }
            $products = Product::where('name', 'LIKE', "%{$keyword}%")->orwhere('price', 'LIKE', "%{$keyword}%")->paginate(10);
        }

        $count_pending = Product::where('status', 1)->count();
        $count_posted = Product::where('status', 2)->count();
        $count_still = Product::where('qty', '>', 0)->count();
        $count_over = Product::where('qty', '<=', 0)->count();
        $count_trash = Product::onlyTrashed()->count();
        $count = [$count_pending, $count_posted, $count_still, $count_over,$count_trash];

        $productCats = ProductCat::all();
        return view('admin.product.list', compact('products', 'count', 'list_action', 'productCats'));
    }

    function edit($id){
        $cats = ProductCat::all();
        $product = Product::find($id);
        return view('admin.product.edit', compact('product', 'cats'));
    }

    function update(Request $request, $id){
        $request->validate(
            [
                'name' => 'required|min:6|max:200',
                'price' => 'required|integer',
                'desc' => 'required|min:6',
                'content' => 'required',
                'file' => 'required|image',
                'category' => 'required',
                'qty' => 'required|integer'
            ],
            [
                'required' => ':attribute không được để trống',
                'integer' => ':attribute phải là số',
                'image' => ':attribute không phải dạng ảnh',
                'min' => ':attribute có ít nhất :min kí tự',
                'max' => ':attribute có tối đa :max kí tự'
            ],
            [
                'name' => 'Tên sản phẩm',
                'price' => 'Giá sản phẩm',
                'desc' => 'Mô tả ngắn',
                'content' => 'Chi tiết sản phẩm',
                'file' => 'Ảnh đại diện',
                'category' => 'Danh mục',
                'qty' => 'Số lượng sản phẩm'
            ]
        );
        
        $input = $request->all();

        if($request->hasFile('file')){
            $file = $request->file;

            $file_name = $file->getClientOriginalName();
            $path = $file->move('public/uploads', $file_name);
            $thumb_nail = 'uploads/'.$file_name;
            $input['thumbnail'] = $thumb_nail;
        }


        Product::where('id', $id)->update(
            [
                'name' => $request->input('name'),
                'price' => $request->input('price'),
                'desc' => $request->input('desc'),
                'content' => $request->input('content'),
                'thumbnail' => $input['thumbnail'],
                'cat_id' => $request->input('category'),
                'status' => $request->input('status'),
                'qty' => $request->input('qty'),
                'old_price' => $request->input('old_price')
            ]
        );
        return redirect('admin/product/list')->with('status', 'Cập nhật sản phẩm thành công!');
    }

    function delete($id) {
        if($id){
            Product::find($id)->delete();
        }
        return redirect('admin/product/list')->with('status', 'Đã chuyển sản phẩm vào thùng rác!');
    }

    function action(Request $request){
        $action = $request->input('action');
        $list_check = $request->input('list_check');

        if($action && $list_check){
            if($action == 'delete'){
                Product::destroy($list_check);
                return redirect('admin/product/list')->with('status', 'Chuyển sản phẩm vào thùng rác thành công!');
            }elseif($action == 'restore'){
                Product::withTrashed()
                ->whereIn('id', $list_check)
                ->restore();
                return redirect('admin/product/list')->with('status', 'Bạn đã khôi phục sản phẩm thành công!');
            }else{
                Product::withTrashed()
                ->whereIn('id', $list_check)
                ->forceDelete();
                return redirect('admin/product/list')->with('status', 'Bạn đã xóa vĩnh viễn sản phẩm thành công!');
            }
        }else{
            return redirect('admin/product/list')->with('warning', 'Hãy chọn sản phẩm và hành động cần thực hiện!');
        }
    }
}
