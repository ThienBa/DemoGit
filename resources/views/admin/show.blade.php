@extends('layouts.admin')

@section('content')
    <div class="container-fluid py-5">
        <div class="row">
            <div class="col">
                <div class="card text-white bg-primary mb-3" style="max-width: 18rem;">
                    <div class="card-header">ĐƠN HÀNG THÀNH CÔNG</div>
                    <div class="card-body">
                        <h5 class="card-title">{{ $count[0] }}</h5>
                        <p class="card-text">Đơn hàng giao dịch thành công</p>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card text-white bg-danger mb-3" style="max-width: 18rem;">
                    <div class="card-header">ĐANG XỬ LÝ</div>
                    <div class="card-body">
                        <h5 class="card-title">{{ $count[1] }}</h5>
                        <p class="card-text">Số lượng đơn hàng đang xử lý</p>
                    </div>
                </div>
            </div>

            <div class="col">
                <div class="card text-white bg-success mb-3" style="max-width: 18rem;">
                    <div class="card-header">DOANH SỐ</div>
                    <div class="card-body">
                        <h5 class="card-title">{{ number_format($revenue, 0, '', '.') }}đ</h5>
                        <p class="card-text">Doanh số hệ thống</p>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card text-white bg-dark mb-3" style="max-width: 18rem;">
                    <div class="card-header">ĐƠN HÀNG HỦY</div>
                    <div class="card-body">
                        <h5 class="card-title">{{ $count[2] }}</h5>
                        <p class="card-text">Số đơn bị hủy trong hệ thống</p>
                    </div>
                </div>
            </div>
        </div>
        <!-- end analytic  -->
        <div class="card">
            <div class="card-header font-weight-bold">
                ĐƠN HÀNG MỚI
            </div>
            <div class="card-body">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Mã</th>
                            <th scope="col">Khách hàng</th>
                            <th scope="col">Sản phẩm</th>
                            <th scope="col">Số lượng</th>
                            <th scope="col">Giá trị</th>
                            <th scope="col">Trạng thái</th>
                            <th scope="col">Thời gian</th>
                            <th scope="col">Tác vụ</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $count = 0;
                        @endphp
                        @foreach ($orders as $order)
                            @php
                                $count++;
                            @endphp
                            <tr>
                                <td scope="row">{{ $count }}</td>
                                <td>UniO{{ $order->id }}</td>
                                <td>
                                    {{ $order->name }} <br>
                                    {{ $order->phone_number }}
                                </td>

                                @php
                                    foreach ($products as $product) {
                                        if($product->id == $order->product_id){
                                            $product_name = $product->name;
                                        }
                                    }
                                @endphp
                                <td><a href="{{ url('admin/order/edit', $order->id) }}">{{ Str::of($product_name)->limit(50) }}</a></td>
                                <td>{{ $order->qty }}</td>
                                <td>{{ number_format($order->price, 0, '', '.') }}đ</td>
                                <td><span class="badge
                                                @if ($order->status == 1) {{ 'badge-warning' }}
                                    @elseif ($order->status==2)
                                        {{ 'badge-success' }}
                                    @else
                                        {{ 'badge-dark' }} @endif">

                                        @if ($order->status == 1)
                                            {{ 'Đang xử lí' }}
                                        @elseif ($order->status==2)
                                            {{ 'Đã giao' }}
                                        @else
                                            {{ 'Đã hủy' }}
                                        @endif
                                    </span></td>
                                <td>{{ $order->created_at }}</td>
                                <td>
                                    <a href="{{ url('admin/order/edit', $order->id) }}" class="btn btn-success btn-sm rounded-0 text-white" type="button"
                                        data-toggle="tooltip" data-placement="top" title="Edit"><i
                                            class="fa fa-edit"></i></a>
                                    <a href="{{ url('admin/order/delete', $order->id) }}" onclick="return confirm('Bạn có chắc chắn muốn xóa đơn hàng này?')" class="btn btn-danger btn-sm rounded-0 text-white" type="button"
                                        data-toggle="tooltip" data-placement="top" title="Delete"><i
                                            class="fa fa-trash"></i></a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

    </div>
@endsection
