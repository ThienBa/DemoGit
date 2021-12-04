<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Order;

class AdminOrderController extends Controller
{
    //
    function __construct(){
        $this->middleware(function($request, $next){
            session(['module_active' => 'order']);
            return $next($request);
        });
    }
    
    function list(Request $request){
        $status = $request->input('status');

        $list_action = [
            'delete' => 'Xóa tạm thời'
        ];

        if($status){
            if($status == 'processing'){
                $orders = Order::where('status', 1)->orderBy('created_at', 'desc')->paginate(10);
            }elseif($status == 'completed'){
                $orders = Order::where('status', 2)->orderBy('created_at', 'desc')->paginate(10);
            }elseif($status == 'home'){
                $orders = Order::where('pay_method', 1)->orderBy('created_at', 'desc')->paginate(10);
            }elseif($status == 'store'){
                $orders = Order::where('pay_method', 2)->orderBy('created_at', 'desc')->paginate(10);
            }else{
                $list_action = [
                    'restore' => 'Khôi phục',
                    'forceDelete' => 'Xóa vĩnh viễn'
                ];
                $orders = Order::onlyTrashed()->paginate(10);
            }
        }else{
            $keyword = "";
            if($request->input('keyword')){
                $keyword = $request->input('keyword');
            }
            $orders = Order::where('name', 'LIKE', "%{$keyword}%")->orwhere('price', 'LIKE', "%{$keyword}%")->orwhere('qty', $keyword)->orderBy('created_at', 'desc')->paginate(10);
        }

        $count_processing = Order::where('status', 1)->count();
        $count_completed = Order::where('status', 2)->count();
        $count_trash = Order::onlyTrashed()->count();
        $count_home = Order::where('pay_method', 1)->count();
        $count_store = Order::where('pay_method', 2)->count();

        $count = [$count_processing, $count_completed, $count_home, $count_store, $count_trash];

        return view('admin.order.list', compact('orders', 'list_action', 'count'));
    }

    function edit($id){
        $order = Order::find($id);
        $product = Order::find($id)->product;
        return view('admin.order.edit', compact('order', 'product'));
    }

    function update(Request $request, $id){
        $request->validate(
            [
                'name' => 'required',
                'email' => 'required|email',
                'phone_number' => 'required',
                'address' => 'required',
                'qty' => 'required|integer',
                'price' => 'required|integer'
            ],
            [
                'required' => ':attribute không được để trống',
                'email' => ':attribute không đúng định dạng',
                'integer' => ':attribute phải là kiểu số'
            ],
            [
                'name' => 'Tên khách hàng',
                'email' => 'Email',
                'phone_number' => 'Số điện thoại',
                'address' => 'Địa chỉ',
                'qty' => 'Số lượng',
                'price' => 'Tổng tiền',
            ]
        );

        Order::where('id', $id)->update(
            [
                'name' => $request->input('name'),
                'email' => $request->input('email'),
                'phone_number' => $request->input('phone_number'),
                'address' => $request->input('address'),
                'qty' => $request->input('qty'),
                'price' => $request->input('price'),
                'notice' => $request->input('notice'),
                'pay_method' => $request->input('pay_method'),
                'status' => $request->input('status')
            ]
        );
        return redirect('admin/order/list')->with('status', 'Cập nhật thông tin đơn hàng thành công!');
    }

    function delete($id){
        Order::find($id)->delete();
        return redirect('admin/order/list')->with('status', 'Đơn hàng đã được chuyển vào thùng rác!');
    }

    function action(Request $request){
        $action = $request->input('action');
        $list_check = $request->input('list_check');

        if($action && $list_check){
            if($action == 'delete'){
                Order::destroy($list_check);
                return redirect('admin/order/list')->with('status', 'Chuyển đơn đặt hàng vào thùng rác thành công!');
            }elseif($action == 'restore'){
                Order::withTrashed()
                ->whereIn('id', $list_check)
                ->restore();
                return redirect('admin/order/list')->with('status', 'Bạn đã khôi phục đơn đặt hàng thành công!');
            }else{
                Order::withTrashed()
                ->whereIn('id', $list_check)
                ->forceDelete();
                return redirect('admin/order/list')->with('status', 'Bạn đã xóa vĩnh viễn đơn đặt hàng thành công!');
            }
        }else{
            return redirect('admin/order/list')->with('warning', 'Hãy chọn đơn đặt hàng và hành động cần thực hiện!');
        }
    }
}
