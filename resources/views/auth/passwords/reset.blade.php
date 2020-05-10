@extends('layouts.app')

@section('content')
    <style>
        .reset-password h2 {
            text-align: center;
        }
        .reset-password form input::placeholder {
            color: #0a001f;
        }
    </style>
    <div class="col-md-2"></div>
    <div class="col-md-10 reset-password">
        <div class="col-md-3"></div>
        <div class="col-md-6">
            <h2 class="center">Mật Khẩu Mới</h2>
            <form action="{{route('password.update')}}" class="form-group" method="POST">
                @csrf
                <input type="hidden" name="token" class="username form-control" value="{{ $token ?? '' }}"/>
                <input type="password" name="password" placeholder="Mật Khẩu Mới" class="form-control">
                <input type="password" name="password_confirmation" placeholder="Nhập lại Mật Khẩu Mới" class="form-control">
                <button class="btn btn-default center-block" type="submit" >Đổi Mật Khẩu</button>
            </form>
        </div>
        <div class="col-md-3"></div>
    </div>
@endsection
