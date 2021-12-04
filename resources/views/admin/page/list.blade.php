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
                <h5 class="m-0 ">Danh sách bài viết</h5>
                <div class="form-search form-inline">
                    <form action="#">
                        <input type="text" name='keyword' class="form-control form-search" placeholder="Tìm kiếm"
                            value="{{ request()->input('keyword') }}">
                        <input type="submit" name="btn-search" value="Tìm kiếm" class="btn btn-primary">
                    </form>
                </div>
            </div>
            <div class="card-body">
                <div class="analytic">
                    <a href="{{ request()->fullUrlWithQuery(['status' => 'pending']) }}" class="text-primary">Chờ
                        duyệt<span class="text-muted">({{ $count[0] }})</span></a>
                    <a href="{{ request()->fullUrlWithQuery(['status' => 'posted']) }}" class="text-primary">Đã đăng<span
                            class="text-muted">({{ $count[1] }})</span></a>
                    <a href="{{ request()->fullUrlWithQuery(['status' => 'trash']) }}" class="text-primary">Thùng rác<span
                            class="text-muted">({{ $count[2] }})</span></a>
                </div>
                <form action="{{ url('admin/page/action') }}" method="post">
                    @csrf
                    <div class="form-action form-inline py-3">
                        <select class="form-control mr-1" name="action">
                            <option value="">Chọn</option>
                            @foreach ($list_action as $k => $value)
                                <option value="{{ $k }}">{{ $value }}</option>
                            @endforeach
                        </select>
                        <input type="submit" name="btn-action" value="Áp dụng" class="btn btn-primary">
                    </div>
                    <table class="table table-striped table-checkall">
                        <thead>
                            <tr>
                                <th scope="col">
                                    <input name="checkall" type="checkbox">
                                </th>
                                <th scope="col">#</th>
                                <th scope="col">Tiêu đề</th>
                                <th scope="col">Nội dung</th>
                                <th scope="col">Trạng thái</th>
                                <th scope="col">Người tạo</th>
                                <th scope="col">Ngày tạo</th>
                                @if (request()->get('status') == 'trash')
                                    <th scope="col">Ngày xóa</th>
                                @else
                                    <th scope="col">Tác vụ</th>
                                @endif
                            </tr>
                        </thead>
                        @if ($pages->total() > 0)
                            <tbody>
                                @php
                                    $count = 0;
                                @endphp
                                @foreach ($pages as $page)
                                    @php
                                        $count++;
                                    @endphp
                                    <tr>
                                        <td>
                                            <input type="checkbox" name="list_check[]" value="{{ $page->id }}}">
                                        </td>
                                        <td scope="row">{{ $count }}</td>
                                        <td><a href="{{ url('admin/page/edit', $page->id)}}">{{ $page->title }}</a>
                                        <td>{!! Str::of($page->content)->limit(50) !!}</td>
                                        <td>{{ $page->status == 1 ? 'Chờ duyệt' : 'Đã đăng' }}</td>
                                        <td><a href="">{{ $page->creator }}</a>
                                        <td>{{ $page->created_at }}</td>
                                        @if (request()->get('status') == 'trash')
                                            <td>{{ $page->deleted_at }}</td>
                                        @else
                                            <td><a href="{{ url('admin/page/edit', $page->id) }}"
                                                    class="btn btn-success btn-sm rounded-0" type="button"
                                                    data-toggle="tooltip" data-placement="top" title="Edit"><i
                                                        class="fa fa-edit"></i></a>
                                                <a href="{{ url('admin/page/delete', $page->id) }}"
                                                    onclick="return confirm('Bạn muốn xóa trang này?')"
                                                    class="btn btn-danger btn-sm rounded-0" type="button"
                                                    data-toggle="tooltip" data-placement="top" title="Delete"><i
                                                        class="fa fa-trash"></i></a>
                                            </td>
                                        @endif
                                    </tr>
                                @endforeach
                            </tbody>
                        @else
                            <tr>
                                <td colspan="7" class="bg-white">Không tìm thấy kết quả phù hợp</td>
                            </tr>
                        @endif
                    </table>
                </form>
                <nav aria-label="Page navigation example">
                    {{ $pages->links() }}
                </nav>
            </div>
        </div>
    </div>
@endsection
