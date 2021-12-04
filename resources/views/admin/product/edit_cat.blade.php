@extends('layouts.admin')

@section('content')
<div id="content" class="container-fluid">
    <div class="card">
        <div class="card-header font-weight-bold">
            Cập nhật danh mục
        </div>
        <div class="card-body">
            <form method="post" action="{{ url('admin/product/cat/update', $cat->id) }}">
                @csrf
                <div class="form-group">
                    <label for="name">Tên danh mục</label>
                    <input class="form-control" type="text" name="name" id="name" value="{{$cat->name}}">
                    @error('name')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="parent_id">Cấp bậc danh mục</label>
                    <select class="form-control" name="parent_id" id="parent_id">
                        <option value="">Chọn</option>
                        <option {{$cat->parent_id==1?"selected='selected'":""}} value="1">Cấp bậc 1</option>
                        <option {{$cat->parent_id==2?"selected='selected'":""}} value="2">Cấp bậc 2</option>
                    </select>
                    @error('level')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="">Trạng thái</label>
                    <div class="form-check">
                        <input class="form-check-input" {{$cat->status==1?"checked":""}} type="radio" name="status" id="pending" value="1"
                            checked>
                        <label class="form-check-label" for="pending">
                            Chờ duyệt
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" {{$cat->status==2?"checked":""}} type="radio" name="status" id="public" value="2">
                        <label class="form-check-label" for="public">
                            Công khai
                        </label>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary" value="Thêm mới" name="btn_add_post_cat">Thêm
                    mới</button>
            </form>
        </div>
    </div>
</div>
@endsection