@extends('layouts.app')

@section('content')
<style>
    .form-title {
        text-align: center;
        font-size: 24px;
        font-weight: bold;
        color: #1565c0;
        margin-bottom: 25px;
    }

    form label {
        display: block;
        margin-bottom: 6px;
        font-weight: 600;
        color: #444;
    }

    form input {
        width: 100%;
        padding: 12px;
        margin-bottom: 20px;
        border: none;
        border-radius: 12px;
        background-color: #e3f2fd;
        box-shadow: inset 0 2px 4px rgba(0,0,0,0.1);
        font-size: 14px;
        transition: box-shadow 0.3s ease;
    }

    form input:focus {
        outline: none;
        box-shadow: 0 0 0 2px #64b5f6;
    }

    .btn-register {
        width: 100%;
        padding: 12px;
        background: linear-gradient(to right, #1976d2, #64b5f6);
        border: none;
        border-radius: 12px;
        color: white;
        font-weight: bold;
        font-size: 16px;
        cursor: pointer;
        transition: background 0.3s ease;
    }

    .btn-register:hover {
        background: linear-gradient(to right, #0d47a1, #42a5f5);
    }

    .form-footer {
        text-align: center;
        margin-top: 15px;
    }

    .form-footer a {
        color: #1565c0;
        text-decoration: none;
        font-weight: bold;
    }

    .form-footer a:hover {
        color: #0d47a1;
    }

    .error-box {
        color: red;
        margin-bottom: 15px;
        font-size: 14px;
    }
</style>

<h2 class="form-title">Đăng ký tài khoản</h2>

@if ($errors->any())
    <div class="error-box">
        <ul style="padding-left: 20px;">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form method="POST" action="{{ route('register.post') }}">
    @csrf

    <label for="name">Họ và tên:</label>
    <input type="text" name="name" id="name" value="{{ old('name') }}" required>
    
    <label for="email">Email:</label>
    <input type="email" name="email" id="email" value="{{ old('email') }}" required>

    <label for="password">Mật khẩu:</label>
    <input type="password" name="password" id="password" required>

    <label for="password_confirmation">Nhập lại mật khẩu:</label>
    <input type="password" name="password_confirmation" id="password_confirmation" required>

    <button type="submit" class="btn-register">Đăng ký</button>
</form>

<div class="form-footer">
    Đã có tài khoản? <a href="{{ route('login') }}">Đăng nhập</a>
</div>
@endsection
