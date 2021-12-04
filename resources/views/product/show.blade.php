@extends('layouts.main')

@section('title', 'Sản phẩm')

@section('content')
    <div id="main-content-wp" class="clearfix category-product-page">
        <div class="wp-inner">
            <div class="secion" id="breadcrumb-wp">
                <div class="secion-detail">
                    <ul class="list-item clearfix">
                        <li>
                            <a href="{{ url('/') }}" title="">Trang chủ</a>
                        </li>
                        <li>
                            <a href="{{ url('san-pham') }}" title="">Sản phẩm</a>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="main-content fl-right">
                <div class="section" id="list-product-wp">
                    <div class="section-head clearfix">
                        <h3 class="section-title fl-left">Tất cả sản phẩm</h3>
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
                <div class="section" id="filter-product-wp">
                    <div class="section-head">
                        <h3 class="section-title">Bộ lọc</h3>
                    </div>
                    <div class="section-detail">
                        <form method="POST">
                            <table>
                                <thead>
                                    <tr>
                                        <td colspan="2">Giá</td>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td><input id="500000" type="radio" value-price="500000" name="r-price"></td>
                                        <td><label for="500000">Dưới 500.000đ</label></td>
                                    </tr>
                                    <tr>
                                        <td><input id="1000000" type="radio" value-price="1000000" name="r-price"></td>
                                        <td><label for="1000000">Dưới 1.000.000đ</label></td>
                                    </tr>
                                    <tr>
                                        <td><input id="5000000" type="radio" value-price="5000000" name="r-price">
                                        </td>
                                        <td><label for="5000000">Dưới 5.000.000đ</label></td>
                                    </tr>
                                    <tr>
                                        <td><input id="10000000" type="radio" value-price="10000000" name="r-price">
                                        </td>
                                        <td><label for="10000000">Dưới 10.000.000đ</label></td>
                                    </tr>
                                    <tr>
                                        <td><input id="20000000" type="radio" value-price="20000000" name="r-price"></td>
                                        <td><label for="20000000">Dưới 20.000.000đ</label></td>
                                    </tr>
                                    <tr>
                                        <td><input id="50000000" type="radio" value-price="50000000" name="r-price"></td>
                                        <td><label for="50000000">Dưới 50.000.000đ</label></td>
                                    </tr>
                                </tbody>
                            </table>

                            <table>
                                <thead>
                                    <tr>
                                        <td colspan="2">Hãng</td>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td><input id="iPhone" type="radio" value-brand="iphone" name="r-brand"></td>
                                        <td><label for="iPhone">iPhone</label></td>
                                    </tr>
                                    <tr>
                                        <td><input id="Samsung" type="radio" value-brand="samsung" name="r-brand"></td>
                                        <td><label for="iPhone">Samsung</label></td>
                                    </tr>
                                    <tr>
                                        <td><input id="Oppo" type="radio" value-brand="oppo" name="r-brand"></td>
                                        <td><label for="iPhone">Oppo</label></td>
                                    </tr>
                                    <tr>
                                        <td><input id="Xiaomi" type="radio" value-brand="xiaomi" name="r-brand"></td>
                                        <td><label for="Xiaomi">Xiaomi</label></td>
                                    </tr>
                                    <tr>
                                        <td><input id="Macbook" type="radio" value-brand="macbook" name="r-brand"></td>
                                        <td><label for="iPhone">Macbook</label></td>
                                    </tr>
                                    <tr>
                                        <td><input id="Asus" type="radio" value-brand="asus" name="r-brand"></td>
                                        <td><label for="Asus">Asus</label></td>
                                    </tr>
                                    <tr>
                                        <td><input id="Acer" type="radio" value-brand="acer" name="r-brand"></td>
                                        <td><label for="Acer">Acer</label></td>
                                    </tr>
                                    <tr>
                                        <td><input id="Msi" type="radio" value-brand="msi" name="r-brand"></td>
                                        <td><label for="Msi">Msi</label></td>
                                    </tr>
                                    <tr>
                                        <td><input id="Huawei" type="radio" value-brand="huawei" name="r-brand"></td>
                                        <td><label for="Huawei">Huawei</label></td>
                                    </tr>
                                    <tr>
                                        <td><input id="Ipad" type="radio" value-brand="ipad" name="r-brand"></td>
                                        <td><label for="Ipad">Ipad</label></td>
                                    </tr>
                                </tbody>
                            </table>
                            <table>
                                <thead>
                                    <tr>
                                        <td colspan="2">Loại</td>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td><input id="phone" type="radio" value-type="1" name="type"></td>
                                        <td><label for="phone">Điện thoại</label></td>
                                    </tr>
                                    <tr>
                                        <td><input id="laptop" type="radio" value-type="2" name="type"></td>
                                        <td><label for="laptop">Laptop</label></td>
                                    </tr>
                                    <tr>
                                        <td><input id="tablet" type="radio" value-type="4" name="type"></td>
                                        <td><label for="tablet">Tablet</label></td>
                                    </tr>
                                </tbody>
                            </table>
                        </form>
                    </div>
                </div>
                @include('inc.banner')
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function() {
            $('input[type=radio]').click(function() {
                var value_price = $("input[name=r-price]:checked").attr("value-price");
                var value_brand = $("input[name=r-brand]:checked").attr("value-brand");
                var value_type = $("input[name=type]:checked").attr("value-type");
                var data = {
                    value_price: value_price,
                    value_brand: value_brand,
                    value_type: value_type
                };

                $.ajax({
                    type: "GET",
                    url: "{{url('product/search_fillter')}}",
                    data: data,
                    dataType: "html",
                    success: function(data) {
                        $(".main-content").html(data);
                    }
                });
            });
        });
    </script>
@endsection
