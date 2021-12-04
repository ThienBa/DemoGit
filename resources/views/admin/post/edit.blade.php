@extends('layouts.admin')

@section('content')
<div id="content" class="container-fluid">
    <div class="card">
        <div class="card-header font-weight-bold">
            Thêm bài viết
        </div>
        <div class="card-body">
            <form method="post" action="{{route('post.update', $post->id)}}" enctype="multipart/form-data" onchange="ImagesFileAsURL()">
                @csrf
                <div class="form-group">
                    <label for="title">Tiêu đề bài viết</label>
                    <input class="form-control" type="text" name="title" id="title" value="{{$post->title}}">
                    @error('title')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="content">Nội dung bài viết</label>
                    <textarea name="content" class="form-control" id="content" cols="30" rows="5">{!!$post->content!!}</textarea>
                    @error('content')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="file">Chọn ảnnh đại diện mới cho bài viết</label>
                    <div id="displayImg" class="img-fluid">
                    </div>
                    <input type="file" class="form-control-file" name="file" id="file">
                    @error('file')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="post_cat">Danh mục</label>
                    <select class="form-control" id="post_cat" name="post_cat">
                      <option value="">Chọn danh mục</option>
                      {{-- <option {{$post->cat_id == 1?"selected='selected'":""}} value="1">Điện thoại</option>
                      <option {{$post->cat_id == 2?"selected='selected'":""}} value="2">Laptop</option> --}}
                    @foreach ($cats as $cat)
                        <option {{$post->cat_id==$cat->id?"selected='selected'":""}} value="{{$cat->id}}">{{$cat->name}}</option>
                    @endforeach
                    </select>
                    @error('post_cat')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="">Trạng thái</label>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" {{$post->status==1?"checked":""}} name="status" id="pending" value="1">
                        <label class="form-check-label" for="pending">
                          Chờ duyệt
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" {{$post->status==2?"checked":""}} name="status" id="public" value="2">
                        <label class="form-check-label" for="public">
                          Đã đăng
                        </label>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary" name="btn_update_post" value="Thêm bài viết">Cập nhật</button>
            </form>
        </div>
    </div>
</div>
@endsection