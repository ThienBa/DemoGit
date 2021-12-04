@extends('layouts.main')

@section('content')
    <div id="main-content-wp" class="checkout-page">
        <div class="section" id="breadcrumb-wp">
            <div class="wp-inner">
                <div class="section-detail">
                    <ul class="list-item clearfix">
                        <li>
                            <a href="{{url('/')}}" title="">Trang chủ</a>
                        </li>
                        <li>
                            <a href="" title="">Thanh toán</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <div id="wrapper" class="wp-inner clearfix">
            @if (session('status'))
                <div class="alert bg-success">{{session('status')}}</div>
            @endif
            <form action="{{ url('checkout/store_buyNow', $product->id) }}" method="post">
                @csrf
                <div class="section" id="customer-info-wp">
                    <div class="section-head">
                        <h1 class="section-title">Thông tin khách hàng</h1>
                    </div>
                    <div class="section-detail">
                        <div class="form-row clearfix">
                            <div class="form-col fl-left">
                                <label for="name">Họ tên</label>
                                <input type="text" name="name" id="name">
                                @error('name')
                                    <small class="alet text-danger font-italic">{{$message}}</small>
                                @enderror
                            </div>
                            <div class="form-col fl-right">
                                <label for="email">Email</label>
                                <input type="email" name="email" id="email">
                                @error('email')
                                    <small class="alet text-danger font-italic">{{$message}}</small>
                                @enderror
                            </div>
                        </div>
                        <div class="form-row clearfix">
                            <div class="form-col fl-left">
                                <label for="address">Địa chỉ</label>
                                <input type="text" name="address" id="address">
                                @error('address')
                                    <small class="alet text-danger font-italic">{{$message}}</small>
                                @enderror
                            </div>
                            <div class="form-col fl-right">
                                <label for="phone_number">Số điện thoại</label>
                                <input type="text" name="phone_number" id="phone_number">
                                @error('phone_number')
                                    <small class="alet text-danger font-italic">{{$message}}</small>
                                @enderror
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-col">
                                <label for="notice">Ghi chú</label>
                                <textarea name="notice"></textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="section" id="order-review-wp">
                    <div class="section-head">
                        <h1 class="section-title">Thông tin đơn hàng</h1>
                    </div>
                    <div class="section-detail">
                        <table class="shop-table">
                            <thead>
                                <tr>
                                    <td>Sản phẩm</td>
                                    <td>Tổng</td>
                                </tr>
                            </thead>
                            <tbody>
                                <tr class="cart-item">
                                    <td>
                                        <strong class="product-name">{{ Str::of($product->name)->limit(45) }}</strong
                                            class="product-quantity"> x1</strong>
                                    </td>
                                    <td class="product-total">{{ number_format($product->price, 0, '', '.') }}đ</td>
                                </tr>
                            </tbody>
                            <tfoot>
                                <tr class="order-total">
                                    <td>Tổng đơn hàng:</td>
                                    <td><strong class="total-price">{{ number_format($product->price, 0, '', '.') }}đ</strong></td>
                                </tr>
                            </tfoot>
                        </table>
                        <div id="payment-checkout-wp">
                            <ul id="payment_methods">
                                <li>
                                    <input type="radio" id="direct-payment" name="pay_method" value="2">
                                    <label for="direct-payment">Thanh toán tại cửa hàng</label>
                                </li>
                                <li>
                                    <input type="radio" id="payment-home" checked name="pay_method" value="1">
                                    <label for="payment-home">Thanh toán tại nhà</label>
                                </li>
                                @error('pay_method')
                                    <small class="alet text-danger font-italic">{{$message}}</small>
                                @enderror
                            </ul>
                        </div>
                        <div class="place-order-wp clearfix">
                            <input type="submit" name="btn_checkout" id="order-now" value="Đặt hàng">
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
