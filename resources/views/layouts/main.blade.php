<!DOCTYPE html>
<html>

<head>
    <title>@yield('title', 'ISMART STORE')</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
        integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link href="{{ url('public/css/bootstrap/bootstrap-theme.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ url('public/css/bootstrap/bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ url('public/reset.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ url('public/css/carousel/owl.carousel.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ url('public/css/carousel/owl.theme.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ url('public/css/font-awesome/css/font-awesome.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ url('public/style.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ url('public/responsive.css') }}" rel="stylesheet" type="text/css" />

    <script src="{{ url('public/js/jquery-2.2.4.min.js') }}" type="text/javascript"></script>
    <script src="{{ url('public/js/elevatezoom-master/jquery.elevatezoom.js') }}" type="text/javascript"></script>
    <script src="{{ url('public/js/bootstrap/bootstrap.min.js') }}" type="text/javascript"></script>
    <script src="{{ url('public/js/carousel/owl.carousel.js') }}" type="text/javascript"></script>
    <script src="{{ url('public/js/main.js') }}" type="text/javascript"></script>
</head>

<body>
    <div id="site">
        <div id="container">
            <div id="header-wp">
                <div id="head-top" class="clearfix">
                    <div class="wp-inner">
                        <a href="" title="" id="payment-link" class="fl-left">Hình thức thanh toán</a>
                        <div id="main-menu-wp" class="fl-right">
                            <ul id="main-menu" class="clearfix">
                                <li>
                                    <a href="{{ url('/') }}" title="">Trang chủ</a>
                                </li>
                                <li>
                                    <a href="{{ url('san-pham') }}" title="">Sản phẩm</a>
                                </li>
                                <li>
                                    <a href="{{ url('bai-viet') }}" title="">Bài viết</a>
                                </li>
                                <li>
                                    <a href="{{ url('1-gioi-thieu') }}" title="">Giới thiệu</a>
                                </li>
                                <li>
                                    <a href="{{ url('2-lien-he') }}" title="">Liên hệ</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div id="head-body" class="clearfix">
                    <div class="wp-inner">
                        <a href="{{ url('/') }}" title="" id="logo" class="fl-left"><img
                                src="{{ asset('images/logo.png') }}" /></a>
                        <div id="search-wp" class="fl-left">
                            <form>
                                @csrf
                                <input type="text" name="search_header" class="search_header" id="s"
                                    placeholder="Nhập từ khóa tìm kiếm tại đây!">
                                <button type="submit" id="sm-s" name="btn_search">Tìm kiếm</button>
                            </form>
                        </div>
                        <div id="action-wp" class="fl-right">
                            <div id="advisory-wp" class="fl-left">
                                <span class="title">Tư vấn</span>
                                <span class="phone">0987.654.321</span>
                            </div>
                            <div id="btn-respon" class="fl-right"><i class="fa fa-bars" aria-hidden="true"></i></div>
                            <a href="{{ url('cart/show') }}" title="giỏ hàng" id="cart-respon-wp" class="fl-right">
                                <i class="fa fa-shopping-cart" aria-hidden="true"></i>
                                <span id="num">
                                    @if (Cart::count() > 0)
                                        {{ Cart::count() }}
                                    @endif
                                </span>
                            </a>
                            <div id="cart-wp" class="fl-right">
                                <div id="btn-cart">
                                    <i class="fa fa-shopping-cart" aria-hidden="true"></i>
                                    <span id="num">
                                        @if (Cart::count() > 0)
                                            {{ Cart::count() }}
                                        @endif
                                    </span>
                                </div>
                                <div id="dropdown">
                                    <p class="desc">Có <span>{{ Cart::count() }} sản phẩm</span> trong giỏ hàng</p>
                                    <ul class="list-cart">
                                        @foreach (Cart::content() as $item)
                                            <li class="clearfix">
                                                <a href="{{ url('product/detail', $item->id) }}" title=""
                                                    class="thumb fl-left">
                                                    <img src="{{ asset($item->options->thumbnail) }}" alt="">
                                                </a>
                                                <div class="info fl-right">
                                                    <a href="{{ url('product/detail', $item->id) }}" title=""
                                                        class="product-name">{{ $item->name }}</a>
                                                    <p class="price">{{ number_format($item->price, 0, '', '.') }}đ
                                                    </p>
                                                    <p class="qty">Số lượng: <span>{{ $item->qty }}</span></p>
                                                </div>
                                            </li>
                                        @endforeach
                                    </ul>
                                    <div class="total-price clearfix">
                                        <p class="title fl-left">Tổng:</p>
                                        <p class="price fl-right">{{ Cart::subtotal(0, '', '.') }}đ</p>
                                    </div>
                                    <div class="action-cart clearfix">
                                        <a href="{{ url('cart') }}" title="Giỏ hàng"
                                            class="view-cart fl-left">Giỏ
                                            hàng</a>
                                        <a href="{{ url('checkout') }}" title="Thanh toán"
                                            class="checkout fl-right">Thanh
                                            toán</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @yield('content')
            <div id="footer-wp">
                <div id="foot-body">
                    <div class="wp-inner clearfix">
                        <div class="block" id="info-company">
                            <h3 class="title">ISMART</h3>
                            <p class="desc">ISMART luôn cung cấp luôn là sản phẩm chính hãng có thông tin rõ ràng, chính
                                sách ưu đãi cực lớn cho khách hàng có thẻ thành viên.</p>
                            <div id="payment">
                                <div class="thumb">
                                    <img src="{{ url('public/images/img-foot.png') }}" alt="">
                                </div>
                            </div>
                        </div>
                        <div class="block menu-ft" id="info-shop">
                            <h3 class="title">Thông tin cửa hàng</h3>
                            <ul class="list-item">
                                <li>
                                    <p>Quận 7 - TP.HCM</p>
                                </li>
                                <li>
                                    <p>0987.654.321 - 0989.989.989</p>
                                </li>
                                <li>
                                    <p>huynhthienba4@gmail.com</p>
                                </li>
                            </ul>
                        </div>
                        <div class="block menu-ft policy" id="info-shop">
                            <h3 class="title">Chính sách mua hàng</h3>
                            <ul class="list-item">
                                <li>
                                    <a href="" title="">Quy định - chính sách</a>
                                </li>
                                <li>
                                    <a href="" title="">Chính sách bảo hành - đổi trả</a>
                                </li>
                                <li>
                                    <a href="" title="">Chính sách hội viện</a>
                                </li>
                                <li>
                                    <a href="" title="">Giao hàng - lắp đặt</a>
                                </li>
                            </ul>
                        </div>
                        <div class="block" id="newfeed">
                            <h3 class="title">Bảng tin</h3>
                            <p class="desc">Đăng ký với chung tôi để nhận được thông tin ưu đãi sớm nhất</p>
                            <div id="form-reg">
                                {{-- <form method="post" action=""> --}}
                                <input type="email" name="email" id="email" placeholder="Nhập email tại đây">
                                <button type="submit" id="sm-reg">Đăng ký</button>
                                {{-- </form> --}}
                            </div>
                        </div>
                    </div>
                </div>
                <div id="foot-bot">
                    <div class="wp-inner">
                        <p id="copyright">© Bản quyền thuộc về ismart | huynhthienba</p>
                    </div>
                </div>
            </div>
        </div>
        <div id="menu-respon">
            <a href="{{ url('/') }}   " title="" class="logo">Ismart</a>
            <div id="menu-respon-wp">
                <ul class="" id="main-menu-respon">
                    <li>
                        <a href="{{ url('/') }}" title>Trang chủ</a>
                    </li>
                    <li>
                        <a href="{{ url('product/list/1') }}" title="">Điện thoại</a>
                        <ul class="sub-menu">
                            <li>
                                <a href="{{ url('product/show_cat/iphone') }}" title="">Iphone</a>
                            </li>
                            <li>
                                <a href="{{ url('product/show_cat/samsung') }}" title="">Samsung</a>
                            </li>
                            <li>
                                <a href="{{ url('product/show_cat/oppo') }}" title="">Oppo</a>
                            </li>
                            <li>
                                <a href="{{ url('product/show_cat/xiaomi') }}" title="">Xiaomi</a>
                            </li>
                        </ul>
                    </li>
                    <li>
                        <a href="{{ url('product/list/2') }}" title="">Laptop</a>
                    </li>
                    <li>
                        <a href="{{ url('product/list/4') }}" title="">Máy tính bảng</a>
                    </li>
                </ul>
            </div>
        </div>
        <div id="btn-top"><img src="{{ asset('images/icon-to-top.png') }}" alt="" /></div>
        <div id="fb-root"></div>
        <script>
            (function(d, s, id) {
                var js, fjs = d.getElementsByTagName(s)[0];
                if (d.getElementById(id))
                    return;
                js = d.createElement(s);
                js.id = id;
                js.src = "//connect.facebook.net/vi_VN/sdk.js#xfbml=1&version=v2.8&appId=849340975164592";
                fjs.parentNode.insertBefore(js, fjs);
            }(document, 'script', 'facebook-jssdk'));
        </script>
        <script>
            $(document).ready(function() {
                $(".search_header").keyup(function() {
                    var txt = $(this).val();
                    var data = {
                        search: txt
                    };

                    $.ajax({
                        type: "get",
                        url: "{{ url('home/search_header') }}",
                        data: data,
                        dataType: "html",
                        success: function(data) {
                            $(".main-content").html(data);
                        }
                    });
                });
            });
        </script>
</body>

</html>




