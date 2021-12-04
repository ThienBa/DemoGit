@extends('layouts.main')

@section('title', 'Ismart.com')
@section('content')
    <div id="main-content-wp" class="home-page clearfix">
        <div class="wp-inner">
            <div class="main-content fl-right">
                <div class="section" id="slider-wp">
                    <div class="section-detail">
                        <div class="item">
                            <img src="{{ asset('images/slider-1.jpg') }}" alt="">
                        </div>
                        <div class="item">
                            <img src="{{ asset('images/slider-03.png') }}" alt="">
                        </div>
                        <div class="item">
                            <img src="{{ asset('images/slider-3.jpg') }}" alt="">
                        </div>
                    </div>
                </div>
                <div class="section" id="support-wp">
                    <div class="section-detail">
                        <ul class="list-item clearfix">
                            <li>
                                <div class="thumb">
                                    <img src="public/images/icon-1.png">
                                </div>
                                <h3 class="title">Miễn phí vận chuyển</h3>
                                <p class="desc">Tới tận tay khách hàng</p>
                            </li>
                            <li>
                                <div class="thumb">
                                    <img src="public/images/icon-2.png">
                                </div>
                                <h3 class="title">Tư vấn 24/7</h3>
                                <p class="desc">1900.9999</p>
                            </li>
                            <li>
                                <div class="thumb">
                                    <img src="public/images/icon-3.png">
                                </div>
                                <h3 class="title">Tiết kiệm hơn</h3>
                                <p class="desc">Với nhiều ưu đãi cực lớn</p>
                            </li>
                            <li>
                                <div class="thumb">
                                    <img src="public/images/icon-4.png">
                                </div>
                                <h3 class="title">Thanh toán nhanh</h3>
                                <p class="desc">Hỗ trợ nhiều hình thức</p>
                            </li>
                            <li>
                                <div class="thumb">
                                    <img src="public/images/icon-5.png">
                                </div>
                                <h3 class="title">Đặt hàng online</h3>
                                <p class="desc">Thao tác đơn giản</p>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="section" id="feature-product-wp">
                    <div class="section-head">
                        <h3 class="section-title">Sản phẩm nổi bật</h3>
                    </div>
                    <div class="section-detail">
                        <ul class="list-item">
                            @foreach ($product_standout as $standout)
                                <li>
                                    <a href="{{url('san-pham/'.$standout->id.'-'.Str::slug($standout->name))}}" title="" class="thumb">
                                        <img src="{{asset($standout->thumbnail)}}">
                                    </a>
                                    <a href="{{url('san-pham/'.$standout->id.'-'.Str::slug($standout->name))}}" title="" class="product-name">{{$standout->name}}</a>
                                    <div class="price">
                                        <span class="new">{{number_format($standout->price, 0,'','.')}}đ</span>
                                        <span class="old">@if ($standout->old_price>0)
                                            {{ number_format($standout->old_price, 0,'', '.')}}đ
                                        @endif</span>
                                    </div>
                                    <div class="action clearfix">
                                        <a href="{{ url('them-gio-hang/'.$standout->id.'-'.Str::slug($standout->name)) }}" title="" class="add-cart fl-left">Thêm giỏ hàng</a>
                                        <a href="{{ url('mua-ngay/'.$standout->id.'-'.Str::slug($standout->name)) }}" title="" class="buy-now fl-right">Mua ngay</a>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
                <div class="section" id="list-product-wp">
                    <div class="section-head">
                        <h3 class="section-title">Điện thoại</h3>
                    </div>
                    <div class="section-detail">
                        <ul class="list-item clearfix">
                            @foreach ($product_phone as $phone)
                                <li>
                                    <a href="{{url('san-pham/'.$phone->id.'-'.Str::slug($phone->name))}}" title="" class="thumb">
                                        <img src="{{asset($phone->thumbnail)}}">
                                    </a>
                                    <a href="{{url('san-pham/'.$phone->id.'-'.Str::slug($phone->name))}}" title="" class="product-name">{{$phone->name}}</a>
                                    <div class="price">
                                        <span class="new">{{number_format($phone->price, 0,'','.')}}đ</span>
                                        <span class="old">@if ($phone->old_price>0)
                                            {{ number_format($phone->old_price, 0,'', '.')}}đ
                                        @endif</span>
                                    </div>
                                    <div class="action clearfix">
                                        <a href="{{ url('them-gio-hang/'.$phone->id.'-'.Str::slug($phone->name)) }}" title="" class="add-cart fl-left">Thêm giỏ hàng</a>
                                        <a href="{{ url('mua-ngay/'.$phone->id.'-'.Str::slug($phone->name)) }}" title="" class="buy-now fl-right">Mua ngay</a>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
                <div class="section" id="list-product-wp">
                    <div class="section-head">
                        <h3 class="section-title">Laptop</h3>
                    </div>
                    <div class="section-detail">
                        <ul class="list-item clearfix">
                            @foreach ($product_laptop as $laptop)
                                <li>
                                    <a href="{{url('san-pham/'.$laptop->id.'-'.Str::slug($laptop->name))}}" title="" class="thumb">
                                        <img src="{{asset($laptop->thumbnail)}}">
                                    </a>
                                    <a href="{{url('san-pham/'.$laptop->id.'-'.Str::slug($laptop->name))}}" title="" class="product-name">{{$laptop->name}}</a>
                                    <div class="price">
                                        <span class="new">{{number_format($laptop->price, 0,'','.')}}đ</span>
                                        <span class="old">@if ($laptop->old_price>0)
                                            {{ number_format($laptop->old_price, 0,'', '.')}}đ
                                        @endif</span>
                                    </div>
                                    <div class="action clearfix">
                                        <a href="{{ url('them-gio-hang/'.$laptop->id.'-'.Str::slug($laptop->name)) }}" title="" class="add-cart fl-left">Thêm giỏ hàng</a>
                                        <a href="{{ url('mua-ngay/'.$laptop->id.'-'.Str::slug($laptop->name)) }}" title="" class="buy-now fl-right">Mua ngay</a>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
                <div class="section" id="list-product-wp">
                    <div class="section-head">
                        <h3 class="section-title">Tablet</h3>
                    </div>
                    <div class="section-detail">
                        <ul class="list-item clearfix">
                            @foreach ($product_tablet as $tablet)
                                <li>
                                    <a href="{{url('san-pham/'.$tablet->id.'-'.Str::slug($tablet->name))}}" title="" class="thumb">
                                        <img src="{{asset($tablet->thumbnail)}}">
                                    </a>
                                    <a href="{{url('san-pham/'.$tablet->id.'-'.Str::slug($tablet->name))}}" title="" class="product-name">{{$tablet->name}}</a>
                                    <div class="price">
                                        <span class="new">{{number_format($tablet->price, 0,'','.')}}đ</span>
                                        <span class="old">@if ($tablet->old_price>0)
                                            {{ number_format($tablet->old_price, 0,'', '.')}}đ
                                        @endif</span>
                                    </div>
                                    <div class="action clearfix">
                                        <a href="{{ url('them-gio-hang/'.$tablet->id.'-'.Str::slug($tablet->name)) }}" title="" class="add-cart fl-left">Thêm giỏ hàng</a>
                                        <a href="{{ url('mua-ngay/'.$tablet->id.'-'.Str::slug($tablet->name)) }}" title="" class="buy-now fl-right">Mua ngay</a>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
            <div class="sidebar fl-left">
                @include('inc.product_cat')
                @include('inc.product_selling')
                @include('inc.banner')
            </div>
        </div>
    </div>
@endsection
