@extends('layouts.admin')

@section('content')
    <div id="content" class="container-fluid">
        <div class="card">
            <div class="card-header font-weight-bold">
                Chỉnh đơn hàng
            </div>
            <div class="card-body">
                <form action="{{ route('order.update', $order->id) }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <label for="name">Người đặt hàng</label>
                        <input class="form-control" type="text" name="name" id="name" value="{{$order->name}}">
                        @error('name')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input class="form-control" type="text" name="email" id="email" value="{{$order->email}}">
                        @error('email')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="phone_number">Số điện thoại</label>
                        <input class="form-control" type="text" name="phone_number" id="phone_number" value="{{$order->phone_number}}">
                        @error('phone_number')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="address">Địa chỉ</label>
                        <textarea name="address" class="form-control" id="address" cols="30" rows="5">{!!$order->address!!}</textarea>
                        @error('address')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="product_name">Tên sản phẩm</label>
                        <input class="form-control" type="text" name="product_name" id="product_name" disabled value="{{$product->name}}">
                    </div>
                    <div class="form-group">
                        <label for="qty">Số lượng</label>
                        <input class="form-control" type="number" min="1" name="qty" id="qty" value="{{$order->qty}}">
                        @error('qty')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="price">Tổng tiền</label>
                        <input class="form-control" type="number" name="price" id="price" value="{{$order->price}}">
                        @error('price')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="notice">Notice</label>
                        <textarea name="notice" class="form-control" id="notice" cols="30" rows="5">{!!$order->notice!!}</textarea>
                    </div>
                    <div class="form-group">
                        <label for="">Phương thức thanh toán</label>
                        <div class="form-check">
                            <input {{$order->pay_method==1?"checked":""}} class="form-check-input" type="radio" name="pay_method" id="home" value="1">
                            <label class="form-check-label" for="home">
                                Thanh toán tại nhà
                            </label>
                        </div>
                        <div class="form-check">
                            <input {{$order->pay_method==2?"checked":""}} class="form-check-input" type="radio" name="pay_method" id="store" value="2">
                            <label class="form-check-label" for="store">
                                Thanh toán tại cửa hàng
                            </label>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="">Trạng thái</label>
                        <div class="form-check">
                            <input {{$order->status==1?"checked":""}} class="form-check-input" type="radio" name="status" id="processing" value="1">
                            <label class="form-check-label" for="processing">
                                Đang xử lí
                            </label>
                        </div>
                        <div class="form-check">
                            <input {{$order->status==2?"checked":""}} class="form-check-input" type="radio" name="status" id="completed" value="2">
                            <label class="form-check-label" for="completed">
                                Đã giao
                            </label>
                        </div>
                        <div class="form-check">
                            <input {{$order->status==3?"checked":""}} class="form-check-input" type="radio" name="status" id="cancel" value="3">
                            <label class="form-check-label" for="cancel">
                                Đã hủy
                            </label>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary" name="btn_update_order" value='Cập nhật'>Cập nhật</button>
                </form>
            </div>
        </div>
    </div>
@endsection
