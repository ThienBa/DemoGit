@extends('layouts.main')

@section('content')
    <div id="main-content-wp" class="cart-page">
        <div class="section" id="breadcrumb-wp">
            <div class="wp-inner">
                <div class="section-detail">
                    <ul class="list-item clearfix">
                        <li>
                            <a href="{{url('/')}}" title="">Trang chủ</a>
                        </li>
                        <li>
                            <a href="" title="">Giỏ hàng</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <div id="wrapper" class="wp-inner clearfix">
            @if (Cart::count() > 0)
                <div class="section" id="info-cart-wp">
                    @if (session('warning'))
                        <div class="alert bg-warning">{{ session('warning') }}</div>
                    @endif
                    @if (session('status'))
                        <div class="alert bg-success">{{ session('status') }}</div>
                    @endif
                    <div class="section-detail table-responsive">
                        <form action="{{ url('cart/update') }}" method="post">
                            @csrf
                            <table class="table">
                                <thead>
                                    <tr>
                                        <td>Mã sản phẩm</td>
                                        <td>Ảnh sản phẩm</td>
                                        <td>Tên sản phẩm</td>
                                        <td>Giá sản phẩm</td>
                                        <td>Số lượng</td>
                                        <td colspan="2">Thành tiền</td>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach (Cart::content() as $cart)
                                        <tr>
                                            <td>PRODUCT{{ $cart->id }}</td>
                                            <td>
                                                <a href="{{url('san-pham/'.$cart->id.'-'.Str::slug($cart->name))}}" title="" class="thumb">
                                                    <img src="{{ asset($cart->options->thumbnail) }}" alt="">
                                                </a>
                                            </td>
                                            <td>
                                                <a href="{{url('san-pham/'.$cart->id.'-'.Str::slug($cart->name))}}" title=""
                                                    class="name-product">{{ Str::of($cart->name)->limit(50) }}</a>
                                            </td>
                                            <td>{{ number_format($cart->price, 0, '', '.') }}đ</td>
                                            <td>
                                                <input min="1" type="number" data-rowId="{{ $cart->rowId }}"
                                                    max="{{ $cart->options->max_qty }}" name="qty[{{ $cart->rowId }}]"
                                                    value="{{ $cart->qty }}" class="num-order">
                                            </td>
                                            <td id="sub-total-{{$cart->rowId}}" >{{ number_format($cart->subtotal, 0, '', '.') }}đ</td>
                                            <td>
                                                <a href="{{ url('remove', $cart->rowId) }}" title=""
                                                    class="del-product"><i class="fa fa-trash-o"></i></a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td colspan="7">
                                            <div class="clearfix">
                                                <p id="total-price" class="fl-right">Tổng giá:
                                                    <span>{{ Cart::subtotal(0, '', '.') }}đ</span>
                                                </p>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="7">
                                            <div class="clearfix">
                                                <div class="fl-right">
                                                    <button value="Cập nhật giỏ hàng" name="btn_update" id="update-cart">Cập
                                                        nhật giỏ hàng</button>
                                                    <a href="{{ url('checkout') }}" title="" id="checkout-cart">Thanh
                                                        toán</a>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                </tfoot>
                            </table>
                        </form>
                    </div>
                </div>
                <div class="section" id="action-cart-wp">
                    <div class="section-detail">
                        <p class="title">Click vào <span>“Cập nhật giỏ hàng”</span> để cập nhật số lượng. Nhập vào số lượng
                            <span>0</span> để xóa sản phẩm khỏi giỏ hàng. Nhấn vào thanh toán để hoàn tất mua hàng.
                        </p>
                        <a href="{{ url('/') }}" title="" id="buy-more">Mua tiếp</a><br />
                        <a href="{{ url('destroy') }}" onclick="return confirm('Bạn muốn xóa toàn bộ giỏ hàng?')"
                            title="" id="delete-cart">Xóa giỏ hàng</a>
                    </div>
                </div>
            @else
                <p>Không có sản phẩm nào trong giỏ hàng. Bấm <a href="{{ url('/') }}">vào đây</a> để tiếp tục mua
                    hàng.</p>
            @endif
        </div>
    </div>
    <script>
        $(document).ready(function() {
            $(".num-order").change(function() {
                var rowId = $(this).attr('data-rowId');
                var qty = $(this).val();
                var data = {
                    rowId: rowId,
                    qty: qty
                };

                $.ajax({
                    type: "GET",
                    url: "{{url('cart/update_ajax')}}",
                    data: data,
                    dataType: "json",
                    success: function(data) {
                        $("#sub-total-" + rowId).text(data.sub_total);
                        $("#total-price span").text(data.total);
                        $("span#num").text(data.num_order);
                    },
                    error: function(xhr, ajaxOptions, thrownError) {
                        alert(xhr.status);
                        alert(thrownError);
                    }
                });
            });
        });
    </script>
@endsection
