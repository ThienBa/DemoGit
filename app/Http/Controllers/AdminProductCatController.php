<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\ProductCat;

class AdminProductCatController extends Controller
{
    //
    function __construct(){
        $this->middleware(function($request, $next){
            session(['module_active' => 'product']);
            return $next($request);
        });
    }
    
    function add(Request $request){
        $request->validate(
            [
                'name' => 'required|min:6|max:200',
                'parent_id' => 'required',
            ],
            [
                'required' => ':attribute không được để trống',
                'min' => ':attribute có ít nhất :min kí tự',
                'max' => ':attribute tối đa :max kí tự'
            ],
            [
                'name' => 'Tên danh mục',
                'parent_id' => 'Cấp bậc danh mục'
            ]
        );

        ProductCat::create(
            [
                'name' => $request->input('name'),
                'parent_id' => $request->input('parent_id'),
                'status' => $request->input('status'),
                'creator' => Auth::user()->name
            ]
        );
        return redirect('admin/product/cat/list')->with('status', 'Thêm danh mục thành công');
    }

    function list(){
        $cats = ProductCat::all();
        return view('admin.product.cat', compact('cats'));
    }

    function edit($id){
        $cat = ProductCat::find($id);
        return view('admin.product.edit_cat', compact('cat'));
    }

    function update(Request $request, $id){
        $request->validate(
            [
                'name' => 'required|min:6|max:200',
                'parent_id' => 'required',
            ],
            [
                'required' => ':attribute không được để trống',
                'min' => ':attribute có ít nhất :min kí tự',
                'max' => ':attribute tối đa :max kí tự'
            ],
            [
                'name' => 'Tên danh mục',
                'parent_id' => 'Cấp bậc danh mục'
            ]
        );

        ProductCat::where('id', $id)->update(
            [
                'name' => $request->input('name'),
                'parent_id' => $request->input('parent_id'),    
                'status' => $request->input('status')
            ]
        );
        return redirect('admin/product/cat/list')->with('status', 'Cập nhật danh mục thành công');
    }

    function delete($id){
        ProductCat::destroy($id);
        return redirect('admin/product/cat/list')->with('status', 'Xóa danh mục thành công');
    }
}
