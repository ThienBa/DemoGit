@extends('layouts.admin')

@section('content')
    <div id="content" class="container-fluid">
        <div class="card">
            <div class="card-header font-weight-bold">
                Cập nhật tài khoảng
            </div>
            <div class="card-body">
                <form action="{{ route('user.update', $user->id) }}" method="post">
                    @csrf
                    <div class="form-group">
                        <label for="name">Họ và tên</label>
                        <input class="form-control" type="text" value="{{$user->name}}" name="name" id="name">
                        @error('name')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input class="form-control" type="text" value="{{$user->email}}" name="email" id="email" disabled>
                        @error('email')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="password">Mật khẩu</label>
                        <input class="form-control" type="password" name="password" id="password">
                        @error('password')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="password-confirm">Xác nhận mật khẩu</label>
                        <input class="form-control" type="password" name="password_confirm" id="password-confirm">
                    </div>
                    <div class="form-group">
                        <label for="">Nhóm quyền</label>
                        <select class="form-control" name="role" id="role">
                            <option value="">Chọn quyền</option>
                            <option @if ($user->role_id == 1)
                                        return selected="selected";
                                    @endif value="1">Admintrator</option>
                            <option @if ($user->role_id == 2)
                                        return selected="selected";
                                    @endif value="2">Subcriber</option>
                        </select>
                        @error('role')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <button type="submit" class="btn btn-primary" value="Cập nhật" name="btn_update">Cập nhật</button>
                </form>
            </div>
        </div>
    </div>
@endsection
