<div class="section" id="selling-wp">
    <div class="section-head">
        <h3 class="section-title">Sản phẩm bán chạy</h3>
    </div>
    <div class="section-detail">
        <ul class="list-item">
            @foreach ($product_selling as $selling)
                <li class="clearfix">
                    <a href="{{url('san-pham/'.$selling->id.'-'.Str::slug($selling->name))}}" title="" class="thumb fl-left">
                        <img src="{{ asset($selling->thumbnail) }}" alt="">
                    </a>
                    <div class="info fl-right">
                        <a href="{{url('san-pham/'.$selling->id.'-'.Str::slug($selling->name))}}" title=""
                            class="product-name">{{ $selling->name }}</a>
                        <div class="price">
                            <span class="new">{{ number_format($selling->price, 0, '', '.') }}đ</span>
                            <span class="old">
                                @if ($selling->old_price > 0)
                                    {{ number_format($selling->old_price, 0, '', '.') }}đ
                                @endif
                            </span>
                        </div>
                        <a href="{{ url('mua-ngay/'.$selling->id.'-'.Str::slug($selling->name)) }}" title="" class="buy-now">Mua
                            ngay</a>
                    </div>
                </li>
            @endforeach
        </ul>
    </div>
</div>