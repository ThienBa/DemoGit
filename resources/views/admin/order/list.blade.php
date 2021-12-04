@extends('layouts.admin')

@section('content')
    <div id="content" class="container-fluid">
        <div class="card">
            @if (session('status'))
                <div class="alert alert-success">
                    {{ session('status') }}
                </div>
            @endif
            @if (session('warning'))
                <div class="alert alert-warning">
                    {{ session('warning') }}
                </div>
            @endif
            <div class="card-header font-weight-bold d-flex justify-content-between align-items-center">
                <h5 class="m-0 ">Danh sách đơn hàng</h5>
                <div class="form-search form-inline">
                    <form action="#">
                        <input type="text" name="keyword" class="form-control form-search" placeholder="Tìm kiếm"
                            value="{{ request()->input('keyword') }}">
                        <input type="submit" name="btn-search" value="Tìm kiếm" class="btn btn-primary">
                    </form>
                </div>
            </div>
            <div class="card-body">
                <div class="analytic">
                    <a href="{{ request()->fullUrlWithQuery(['status' => 'processing']) }}" class="text-primary">Đang xử
                        lí<span class="text-muted">({{ $count[0] }})</span></a>
                    <a href="{{ request()->fullUrlWithQuery(['status' => 'completed']) }}" class="text-primary">Đã
                        giao<span class="text-muted">({{ $count[1] }})</span></a>
                    <a href="{{ request()->fullUrlWithQuery(['status' => 'home']) }}" class="text-primary">Thanh toán tại
                        nhà<span class="text-muted">({{ $count[2] }})</span></a>
                    <a href="{{ request()->fullUrlWithQuery(['status' => 'store']) }}" class="text-primary">Thanh toán tại
                        cửa hàng<span class="text-muted">({{ $count[3] }})</span></a>
                    <a href="{{ request()->fullUrlWithQuery(['status' => 'trash']) }}" class="text-primary">Thùng
                        rác<span class="text-muted">({{ $count[4] }})</span></a>
                </div>
                <form action="{{ url('admin/order/action') }}" method="post">
                    @csrf
                    <div class="form-action form-inline py-3">
                        <select class="form-control mr-1" name="action">
                            <option value="">Chọn</option>
                            @foreach ($list_action as $k => $v)
                                <option value="{{ $k }}">{{ $v }}</option>
                            @endforeach
                        </select>
                        <input type="submit" name="btn-search" value="Áp dụng" class="btn btn-primary">
                    </div>
                    <table class="table table-striped table-checkall">
                        <thead>
                            <tr>
                                <th>
                                    <input type="checkbox" name="checkall">
                                </th>
                                <th scope="col">#</th>
                                <th scope="col">Mã</th>
                                <th scope="col">Khách hàng</th>
                                <th scope="col">Số lượng</th>
                                <th scope="col">Tổng tiền</th>
                                <th scope="col">Trạng thái</th>
                                <th scope="col">Thanh toán</th>
                                <th scope="col">Thời gian</th>
                                @if (request()->get('status') == 'trash')
                                    <th scope="col">Thời gian xóa tạm</th>
                                @else
                                    <th scope="col">Tác vụ</th>
                                @endif
                            </tr>
                        </thead>
                        @if ($orders->total() > 0)
                            <tbody>
                                @php
                                    $count = 0;
                                @endphp
                                @foreach ($orders as $order)
                                    @php
                                        $count++;
                                    @endphp
                                    <tr>
                                        <td>
                                            <input type="checkbox" name="list_check[]" value="{{ $order->id }}">
                                        </td>
                                        <td>{{ $count }}</td>
                                        <td>UniO{{ $order->id }}</td>
                                        <td>
                                            {{ $order->name }}
                                            <br>
                                            {{ $order->phone_number }}
                                        </td>
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
                                        <td>{{ $order->pay_method == 1 ? 'Tại nhà' : 'Tại cửa hàng' }}</a></td>
                                        <td>{{ $order->created_at }}</td>
                                        @if (request()->get('status') == 'trash')
                                            <td>{{ $order->deleted_at }}</td>
                                        @else
                                            <td>
                                                <a href="{{ url('admin/order/edit', $order->id) }}"
                                                    class="btn btn-success btn-sm rounded-0 text-white" type="button"
                                                    data-toggle="tooltip" data-placement="top" title="Edit"><i
                                                        class="fa fa-edit"></i></a>
                                                <a href="{{ url('admin/order/delete', $order->id) }}"
                                                    class="btn btn-danger btn-sm rounded-0 text-white" type="button"
                                                    data-toggle="tooltip"
                                                    onclick="return confirm('Bạn có muốn xóa đơn hàng này?')"
                                                    data-placement="top" title="Delete"><i class="fa fa-trash"></i></a>
                                            </td>
                                        @endif
                                    </tr>
                                @endforeach
                            </tbody>
                        @else
                            <tr>
                                <td colspan="8" class="bg-white">Không tìm thấy kết quả phù hợp</td>
                            </tr>
                        @endif
                    </table>
                </form>
                <nav aria-label="Page navigation example">
                    {{ $orders->links() }}
                </nav>
            </div>
        </div>
    </div>
@endsection
