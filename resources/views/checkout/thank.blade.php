@extends('layouts.main')

@section('content')
    <style>
        #wrapper {
            border: 2px solid rgb(51, 51, 51);
            width: 600px;
            margin: 0px auto;
            padding: 20px 50px;
            background: rgb(231, 248, 236);
        }

        #wrapper p {
            text-align: center;
        }

        #wrapper .bold {
            font-weight: bold;
        }

        #wrapper .bold.big-size {
            font-size: 25px;
            padding: 10px;
        }

    </style>
    <div id="main-content-wp" class="cart-page">
        <div id="wrapper" class="wp-inner clearfix">
            <p class="bold">Đơn hàng của bạn đã được gửi đến <a href="{{ url('/') }}" target="_blank">công ty
                    ISMART</a> thành công!</p>
            <p class="bold big-size" style="color: #3366ff;">Cảm ơn bạn đã đặt hàng của chúng tôi</p>
            <p style="text-align: center;">Chúng tôi sẽ liên hệ cho bạn trong thời gian sớm nhất để xác nhận lại đơn hàng.
            </p>
            <p style="text-align: center;"><em><strong>Mọi thắc mắc bạn có thể gọi đến Hotline <a
                            href="tel:0908367738">0987654321</a> – <a href="tel:0938872828">0938 87 28 28</a><br> Hoặc <span
                            style="color: #3366ff;">(028)21 43 54 65</span> – <span style="color: #3366ff;">(028)12 34 56
                            78</span></strong></em></p>
        </div>
    </div>
@endsection
