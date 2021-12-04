<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Mail\Checkout;
use App\Mail\CheckoutBuyNow;
use Illuminate\Support\Facades\Mail;
use Gloudemans\Shoppingcart\Facades\Cart;
use App\Order;
use App\Product;

class CheckoutController extends Controller
{
    //
    function checkout(){
        return view('checkout.checkout');
    }

    function store(Request $request){
        $request->validate(
            [
                'name' => 'required',
                'email' => 'required|email',
                'address' => 'required',
                'phone_number' => 'required',
                'pay_method' => 'required'
            ],
            [
                'required' => ':attribute không được để trống',
                'email' => ':attribute không đúng định dạng',
                'integer' => ':attribute phải là kiểu số'
            ],
            [
                'name' => "Họ và tên",
                'email' => "Email",
                'address' => "Địa chỉ nhận hàng",
                'phone_number' => "Số điện thoại",
                'pay_method' => "Phương thức thanh toán"
            ]
        );

        foreach (Cart::content() as $product) {
            Order::create(
                [
                    'name' => $request->input('name'),
                    'address' => $request->input('address'),
                    'phone_number' => $request->input('phone_number'),
                    'email' => $request->input('email'),
                    'qty' => $product->qty,
                    'price' => $product->subtotal,
                    'pay_method' => $request->input('pay_method'),
                    'notice' => $request->input('notice'),
                    'product_id' => $product->id
                ]
            );
        }

        $data = [
            'name' => $request->input('name'),
            'address' => $request->input('address'),
            'phone_number' => $request->input('phone_number'),
            'email' => $request->input('email')
        ];
        Mail::to($request->input('email'))->send(new Checkout($data));
        return redirect('thank');
        // return $request->input();
    }

    function buy_now($id){
        $product = Product::find($id);
        if($product->qty>0){
            return view('checkout.buy_now', compact('product'));
        }else{
            return redirect('checkout')->with('warning', 'Xin lỗi! Sản phẩm này đã hết hàng hãy chọn mới hoặc mua những sản phẩm đã thêm vào giỏ hàng!'); 
        }
    }

    function store_buyNow(Request $request, $id){
        $request->validate(
            [
                'name' => 'required',
                'email' => 'required|email',
                'address' => 'required',
                'phone_number' => 'required',
                'pay_method' => 'required'
            ],
            [
                'required' => ':attribute không được để trống',
                'email' => ':attribute không đúng định dạng',
                'integer' => ':attribute phải là kiểu số'
            ],
            [
                'name' => "Họ và tên",
                'email' => "Email",
                'address' => "Địa chỉ nhận hàng",
                'phone_number' => "Số điện thoại",
                'pay_method' => "Phương thức thanh toán"
            ]
        );

        $product = Product::find($id);
        Order::create(
            [
                'name' => $request->input('name'),
                'address' => $request->input('address'),
                'phone_number' => $request->input('phone_number'),
                'email' => $request->input('email'),
                'qty' => 1,
                'price' => $product->price,
                'pay_method' => $request->input('pay_method'),
                'notice' => $request->input('notice'),
                'product_id' => $product->id
            ]
        );

        $data = [
            'name' => $request->input('name'),
            'address' => $request->input('address'),
            'phone_number' => $request->input('phone_number'),
            'email' => $request->input('email'),
            'qty' => 1,
            'price' => $product->price,
            'pay_method' => $request->input('pay_method'),
            'notice' => $request->input('notice'),
            'product_name' => $product->name
        ];

        Mail::to($request->input('email'))->send(new CheckoutBuyNow($data));
        Cart::destroy();
        return redirect('thank');
    }

    function thank() {
        return view('checkout.thank');
    }
}
