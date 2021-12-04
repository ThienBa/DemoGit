<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Page;
use Illuminate\Support\Facades\Auth;

class AdminPageController extends Controller
{
    //
    function __construct() {
        $this->middleware(function($request, $next) {
            session(['module_active' => 'page']);
            return $next($request);
        });
    }

    function add(){
        return view('admin.page.add');
    }


    function store(Request $request){
        $request->validate(
            [
                'title' => 'required|min:6|max:200',
                'content' => 'required',
                // 'slug' => 'required'
            ],
            [
                'required' => ':attribute không được để trống',
                'min' => ':attribute có ít nhất :min kí tự',
                'max' => ':attribute có tối đa :max kí tự'
            ],
            [
                'title' => 'Tiêu đề',
                'content' => 'Nội dung',
                // 'slug' => 'Slug'
            ]
        );

        Page::create(
            [
                'title' => $request->input('title'),
                'content' => $request->input('content'),
                'status' => $request->input('status'),
                // 'slug' => $request->input('slug'),
                'creator' => Auth::user()->name
            ]
        );
        return redirect('admin/page/list')->with('status', 'Thêm trang mới thành công!');
    }

    function list(Request $request){
        $status = $request->input('status');

        $list_action = [
            'delete' => 'Xóa tạm thời'
        ];

        if($status){
            if($status == 'pending'){
                $pages = Page::where('status', 1)->paginate(10);
            }elseif($status == 'posted'){
                $pages = Page::where('status', 2)->paginate(10);
            }else{
                $list_action = [
                    'restore' => 'Khôi phục',
                    'forceDelete' => 'Xóa vĩnh viễn'
                ];
                $pages = Page::onlyTrashed()->paginate(10);
            }
        }else{
            $keyword = "";
            if($request->input('keyword')){
                $keyword = $request->input('keyword');
            }
            $pages = Page::where('title', 'LIKE', "%{$keyword}%")->paginate(10);
        }

        $count_pending = Page::where('status', 1)->count();
        $count_posted = Page::where('status', 2)->count();
        $count_trash = Page::onlyTrashed()->count();
        $count = [$count_pending, $count_posted, $count_trash];
         
        return view('admin.page.list', compact('pages', 'count', 'list_action'));
    }

    function edit($id){
        $page = Page::find($id); 
        return view('admin.page.edit', compact('page'));
    }

    function update(Request $request, $id){
        $request->validate(
            [
                'title' => 'required|min:6|max:200',
                'content' => 'required',
                // 'slug' => 'required'
            ],
            [
                'required' => ':attribute không được để trống',
                'min' => ':attribute có ít nhất :min kí tự',
                'max' => ':attribute có tối đa :max kí tự'
            ],
            [
                'title' => 'Tiêu đề',
                'content' => 'Nội dung',
                // 'slug' => 'Slug'
            ]
        );
        Page::where('id', $id)->update(
            [
                'title' => $request->input('title'),
                'content' => $request->input('content'),
                'status' => $request->input('status'),
                // 'slug' => $request->input('slug')
            ]
        );
        return redirect('admin/page/list')->with('status', 'Cập nhật trang thành công!');
    }

    function delete($id){
        Page::find($id)->delete();
        return redirect('admin/page/list')->with('status', 'Chuyển trang vào thùng rác thành công!');
    }

    function action(Request $request){
        $action = $request->input('action');
        $list_check = $request->input('list_check');

        if($action && $list_check){
            if($action == 'delete'){
                Page::destroy($list_check);
                return redirect('admin/page/list')->with('status', 'Chuyển trang vào thùng rác thành công!');
            }elseif($action == 'restore'){
                Page::withTrashed()
                ->whereIn('id', $list_check)
                ->restore();
                return redirect('admin/page/list')->with('status', 'Bạn đã khôi phục trang thành công!');
            }else{
                Page::withTrashed()
                ->whereIn('id', $list_check)
                ->forceDelete();
                return redirect('admin/page/list')->with('status', 'Bạn đã xóa vĩnh viễn trang thành công!');
            }
        }else{
            return redirect('admin/page/list')->with('warning', 'Hãy chọn trang và hành động cần thực hiện!');
        }
    }
}
