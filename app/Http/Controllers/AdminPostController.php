<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Post;
use App\PostCat;

class AdminPostController extends Controller
{
    function __construct(){
        $this->middleware(function($request, $next){
            session(['module_active' => 'post']);
            return $next($request);
        });
    }

    function add(){
        $cats = PostCat::all();
        return view('admin.post.add', compact('cats'));
    }

    function store(Request $request){
        $request->validate(
            [
                'title' => 'required|min:6|max:200',
                'content' => 'required',
                'post_cat' => 'required',
                'file' => 'image|required'
            ],
            [
                'required' => ':attribute không được để trống',
                'min' => ':attribute có ít nhất :min kí tự',
                'image' => ':attribute phải là dạng ảnh',
                'max' => ':attribute có tối đa :max kí tự'
            ],
            [
                'title' => 'Tiêu đề',
                'content' => 'Nội dung',
                'file' => 'Ảnh đại diện bài viết',
                'post_cat' => 'Danh mục bài viết'
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

        Post::create(
            [
                'title' => $request->input('title'),
                'content' => $request->input('content'),
                'thumbnail' => $input['thumbnail'],
                'cat_id' => $request->input('post_cat'),
                'status' => $request->input('status'),
                'creator' => Auth::user()->name
            ]
        );
        return redirect('admin/post/list')->with('status', 'Thêm bài viết mới thành công!');
    }

    function list(Request $request){
        $status = $request->input('status');

        $list_action = [
            'delete' => 'Xóa tạm thời'
        ];

        if($status){
            if($status == 'pending'){
                $posts = Post::where('status', 1)->paginate(10);
            }elseif($status == 'posted'){
                $posts = Post::where('status', 2)->paginate(10);
            }else{
                $list_action = [
                    'restore' => 'Khôi phục',
                    'forceDelete' => 'Xóa vĩnh viễn'
                ];
                $posts = Post::onlyTrashed()->paginate(10);
            }
        }else{
            $keyword = "";
            if($request->input('keyword')){
                $keyword = $request->input('keyword');
            }
            $posts = Post::where('title', 'LIKE', "%{$keyword}%")->paginate(10);
        }

        $count_pending = Post::where('status', 1)->count();
        $count_posted = Post::where('status', 2)->count();
        $count_trash = Post::onlyTrashed()->count();
        $count = [$count_pending, $count_posted, $count_trash];

        return view("admin.post.list", compact('posts', 'count', 'list_action'));
    }

    function edit($id){
        $cats = PostCat::all();
        $post = Post::find($id);
        return view("admin.post.edit", compact('post', 'cats'));
    }

    function update(Request $request, $id){
        $request->validate(
            [
                'title' => 'required|min:6|max:200',
                'content' => 'required',
                'post_cat' => 'required',
                'file' => 'image|required'
            ],
            [
                'required' => ':attribute không được để trống',
                'min' => ':attribute có ít nhất :min kí tự',
                'max' => ':attribute có tối đa :max kí tự',
                'image' => ':attribute phải là dạng ảnh'
            ],
            [
                'title' => 'Tiêu đề',
                'content' => 'Nội dung',
                'post_cat' => 'Danh mục',
                'file' => 'Ảnh đại diện bài viết'
            ]
        );

        if($request->hasFile('file')){
            $file = $request->file;

            $file_name = $file->getClientOriginalName();
            $path = $file->move('public/uploads', $file_name);
            $thumb_nail = 'uploads/'.$file_name;
            $input['thumbnail'] = $thumb_nail;
        }

        Post::where('id', $id)->update(
            [
                'title' => $request->input('title'),
                'content' => $request->input('content'),
                'thumbnail' => $input['thumbnail'],
                'cat_id' => $request->input('post_cat'),
                'status' => $request->input('status')
            ]
        );
        return redirect('admin/post/list')->with('status', 'Cập nhật bài viết thành công!');
    }
    
    function delete($id){
        Post::find($id)->delete();
        return redirect('admin/post/list')->with('status', 'Chuyển bài viết vào thùng rác thành công!');
    }

    function action(Request $request){
        $action = $request->input('action');
        $list_check = $request->input('list_check');

        if($action && $list_check){
            if($action == 'delete'){
                Post::destroy($list_check);
                return redirect('admin/post/list')->with('status', 'Chuyển bài viết vào thùng rác thành công!');
            }elseif($action == 'restore'){
                Post::withTrashed()
                ->whereIn('id', $list_check)
                ->restore();
                return redirect('admin/post/list')->with('status', 'Bạn đã khôi phục bài viết thành công!');
            }else{
                Post::withTrashed()
                ->whereIn('id', $list_check)
                ->forceDelete();
                return redirect('admin/post/list')->with('status', 'Bạn đã xóa vĩnh viễn bài viết thành công!');
            }
        }else{
            return redirect('admin/post/list')->with('warning', 'Hãy chọn bài viết và hành động cần thực hiện!');
        }
    }
}
