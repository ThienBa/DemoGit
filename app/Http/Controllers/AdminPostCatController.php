<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\PostCat;

class AdminPostCatController extends Controller
{
    //
    function __construct(){
        $this->middleware(function($request, $next){
            session(['module_active' => 'post']);
            return $next($request);
        });
    }

    function add(Request $request){
        $request->validate(
            [
                'name' => 'required|min:6|max:200',
                'level' => 'required',
            ],
            [
                'required' => ':attribute không được để trống',
                'min' => ':attribute có ít nhất :min kí tự',
                'max' => ':attribute tối đa :max kí tự'
            ],
            [
                'name' => 'Tên danh mục',
                'level' => 'Cấp bậc danh mục'
            ]
        );

        PostCat::create(
            [
                'name' => $request->input('name'),
                'level' => $request->input('level'),
                'status' => $request->input('status'),
                'creator' => Auth::user()->name
            ]
        );
        return redirect('admin/post/cat/list')->with('status', 'Thêm danh mục thành công');
    }

    function list(){
        $cats = PostCat::all();
        return view('admin.post.cat', compact('cats'));
    }

    function edit($id){
        $cat = PostCat::find($id);
        return view('admin.post.edit_cat', compact('cat'));
    }

    function update(Request $request, $id){
        $request->validate(
            [
                'name' => 'required|min:6|max:200',
                'level' => 'required',
            ],
            [
                'required' => ':attribute không được để trống',
                'min' => ':attribute có ít nhất :min kí tự',
                'max' => ':attribute tối đa :max kí tự'
            ],
            [
                'name' => 'Tên danh mục',
                'level' => 'Cấp bậc danh mục'
            ]
        );

        PostCat::where('id', $id)->update(
            [
                'name' => $request->input('name'),
                'level' => $request->input('level'),    
                'status' => $request->input('status')
            ]
        );
        return redirect('admin/post/cat/list')->with('status', 'Cập nhật danh mục thành công');
    }

    function delete($id){
        PostCat::destroy($id);
        return redirect('admin/post/cat/list')->with('status', 'Xóa danh mục thành công');
    }
}
