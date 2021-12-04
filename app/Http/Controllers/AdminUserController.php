<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Role;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AdminUserController extends Controller
{
    //
    function __construct(){
        $this->middleware(function($request, $next){
            session(['module_active' => 'users']);
            return $next($request);
        });
    }

    function list(Request $request){
        $status = $request->input('status');

        $list_action = [
            'delete' => 'Xóa tạm thời'
        ];

        if($status == 'no_active'){
            $users = User::where('email_verified_at', NULL)->paginate(5);
        }else if($status == 'trash'){
                $list_action = [
                    'restore' => 'Khôi phục',
                    'forceDelete' => 'Xóa vĩnh viễn'
                ];
                $users = User::onlyTrashed()->paginate(5);
            }elseif($status == 'active'){
                $users = User::where('email_verified_at', '>', 1)->paginate(5);
            }else{
                $keyword = "";
                if($request->input('keyword')){
                    $keyword = $request->input('keyword');
                }
                $users = User::where('name', 'LIKE', "%{$keyword}%")->orwhere('email', 'LIKE', "%{$keyword}%")->paginate(5);
            }

        $count_active = User::where('email_verified_at', '>', 1)->count();
        $count_no_active = User::where('email_verified_at', NULL)->count();
        $count_trash = User::onlyTrashed()->count();

        $count = [$count_active, $count_no_active, $count_trash];

        return view('admin.user.list', compact('users', 'count', 'list_action'));
    }

    function add(){
        $roles = Role::all();
        return view('admin.user.add', compact('roles'));
    }

    function store(Request $request){
        $request->validate(
            [
                'name' => 'required|string|max:255',
                'email' => 'required|email|string|max:255|unique:users',
                'password' => 'required|string|min:8|same:password_confirm',
                'role' => 'required'
            ],
            [
                'required' => ':attribute không được để trống',
                'min' => ':attribute có tối thiểu :min kí tự',
                'max' => ':attribute có tối đa :max kí tự',
                'email' => ':attribute không đúng định dạng',
                'unique' => ':attribute đã tồn tại trong hệ thống',
                'same' => 'Xác nhận mật khẩu không thành công'
            ],
            [
                'name' => 'Tên người dùng',
                'email' => 'Email',
                'password' => 'Mật khẩu',
                'role' => 'Quyền thành viên'
            ]
        );

        User::create(
            [
                'name' => $request->input('name'),
                'email' => $request->input('email'),
                'password' => Hash::make($request->input('password')),
                'role_id' => $request->input('role')
            ]
        );

        return redirect('admin/user/list')->with('status', 'Thêm người dùng thành công!');
    }

    function delete($id){
        if(Auth::id() != $id){
            User::find($id)->delete();
            return redirect('admin/user/list')->with('status', 'Xóa tài khoảng thành công!');
        }else{
            return redirect('admin/user/list')->with('warning', 'Bạn không thể xóa tài khoảng của mình!');
        }
    }

    function action(Request $request){
        $list_check = $request->input('list_check');
        $action = $request->input('action');

        if($list_check && $action){
            foreach($list_check as $k => $id){
                if(Auth::id() == $id){
                    unset($list_check[$k]);
                }
            }
            
            if(!empty($list_check)){
                if($action == 'delete'){
                    User::destroy($list_check);
                    return redirect('admin/user/list')->with('status', 'Bạn đã vô hiệu hóa người dùng thành công!');
                }

                if($action == 'restore'){
                    User::withTrashed()
                    ->whereIn('id', $list_check)
                    ->restore();
                    return redirect('admin/user/list')->with('status', 'Bạn đã khôi phục người dùng thành công!');
                }

                if($action == 'forceDelete'){
                    User::withTrashed()
                    ->whereIn('id', $list_check)
                    ->forceDelete();
                    return redirect('admin/user/list')->with('status', 'Bạn đã xóa vĩnh người dùng thành công!');
                }
            }

            return redirect('admin/user/list')->with('warning', 'Bạn không thể thao tác trên tài khoảng của mình!');
        }else{
            return redirect('admin/user/list')->with('warning', 'Hãy chọn bảng ghi và tác vụ cần thực hiện!');
        }
    }

    function edit($id){
        $user = User::find($id);
        return view('admin.user.edit', compact('user'));
    }

    function update(Request $request, $id){
        $request->validate(
            [
                'name' => 'required|string|max:255',
                'password' => 'required|string|min:8|same:password_confirm',
                'role' => 'required'
            ],
            [
                'required' => ':attribute không được để trống',
                'min' => ':attribute có tối thiểu :min kí tự',
                'max' => ':attribute có tối đa :max kí tự',
                'same' => 'Xác nhận mật khẩu không thành công'
            ],
            [
                'name' => 'Tên người dùng',
                'password' => 'Mật khẩu',
                'role' => 'Quyền thành viên'
            ]
        );

        User::where('id', $id)->update([
            'name' => $request->input('name'),
            'role_id' => $request->input('role'),
            'password' => Hash::make($request->input('password'))
        ]);

        return redirect('admin/user/list')->with('status', 'Đã cập nhật thông tin thành công!');
    }
}
