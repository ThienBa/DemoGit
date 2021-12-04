@extends('layouts.main')

@section('title', 'Sản phẩm')
@section('content')
    <div id="main-content-wp" class="clearfix category-product-page">
        <div class="wp-inner">
            <div class="secion" id="breadcrumb-wp">
                <div class="secion-detail">
                    <ul class="list-item clearfix">
                        <li>
                            <a href="{{url('/')}}" title="">Trang chủ</a>
                        </li>
                        <li>
                            <a href="{{url('san-pham')}}" title="">Sản phẩm</a>
                        </li>
                        <li>
                            <a href="" title="">
                                @if (request()->cat_name == 'iphone')
                                    {{ 'Iphone' }}
                                @elseif (request()->cat_name == 'samsung')
                                    {{ 'Samsung' }}
                                @elseif (request()->cat_name == 'oppo')
                                    {{ 'Oppo' }}
                                @elseif (request()->cat_name == 'xiaomi')
                                    {{ 'Xiaomi' }}
                                @endif
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="main-content fl-right">
                <div class="section" id="list-product-wp">
                    <div class="section-head clearfix">
                        <h3 class="section-title fl-left">
                            @if (request()->cat_name == 'iphone')
                                {{ 'Iphone' }}
                            @elseif (request()->cat_name == 'samsung')
                                {{ 'Samsung' }}
                            @elseif (request()->cat_name == 'oppo')
                                {{ 'Oppo' }}
                            @elseif (request()->cat_name == 'xiaomi')
                                {{ 'Xiaomi' }}
                            @endif
                        </h3>
                        <div class="filter-wp fl-right">
                            <p class="desc">Hiển thị {{ $count[0] }} trên {{ $count[1] }} sản phẩm</p>
                            <div class="form-filter">
                                <form action="#">
                                    <select name="select">
                                        <option value="">Sắp xếp</option>
                                        <option value="1">Từ A-Z</option>
                                        <option value="2">Từ Z-A</option>
                                        <option value="3">Giá cao xuống thấp</option>
                                        <option value="4">Giá thấp lên cao</option>
                                    </select>
                                    <button type="submit" name="btn_select" value="Lọc sản phẩm">Lọc</button>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="section-detail">
                        <ul class="list-item clearfix">
                            @foreach ($products as $product)
                                <li>
                                    <a href="{{url('san-pham/'.$product->id.'-'.Str::slug($product->name))}}" title="" class="thumb">
                                        <img src="{{ asset($product->thumbnail) }}">
                                    </a>
                                    <a href="{{url('san-pham/'.$product->id.'-'.Str::slug($product->name))}}" title=""
                                        class="product-name">{{ $product->name }}</a>
                                    <div class="price">
                                        <span class="new">{{ number_format($product->price, 0, '', '.') }}đ</span>
                                        @if ($product->old_price > 0)
                                            <span class="old">
                                                {{ number_format($product->old_price, 0, '', '.') }}đ
                                            </span>
                                        @endif
                                    </div>
                                    <div class="action clearfix">
                                        <a href="{{ url('them-gio-hang/'.$product->id.'-'.Str::slug($product->name)) }}" title="Thêm giỏ hàng"
                                            class="add-cart fl-left">Thêm giỏ
                                            hàng</a>
                                        <a href="{{ url('mua-ngay/'.$product->id.'-'.Str::slug($product->name)) }}" title="Mua ngay"
                                            class="buy-now fl-right">Mua ngay</a>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
                <div class="section float-right" id="paging-wp">
                    {{ $products->links() }}
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
