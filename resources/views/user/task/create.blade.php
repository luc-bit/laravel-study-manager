@extends('layouts.user')

@section('content')
<style>
    .form-container {
         margin: 20px;
    background: #ffffff;
    padding: 30px;
    border-radius: 12px;
    box-shadow: 0 8px 20px rgba(0,0,0,0.1);
    }

    .form-container h2 {
        text-align: center;
        margin-bottom: 25px;
        color: #2196f3;
    }

    .form-group {
        margin-bottom: 20px;
    }

    label {
        display: block;
        font-weight: 600;
        margin-bottom: 6px;
        color: #333;
    }

    input[type="text"],
    input[type="date"],
    select {
        width: 100%;
        padding: 10px 12px;
        border: 1px solid #ccc;
        border-radius: 8px;
        font-size: 15px;
        transition: border-color 0.2s ease;
    }

    input:focus,
    select:focus {
        border-color: #2196f3;
        outline: none;
    }

    button {
        width: 100%;
        padding: 12px;
        background: #2196f3;
        color: white;
        font-size: 16px;
        font-weight: bold;
        border: none;
        border-radius: 8px;
        cursor: pointer;
        transition: background 0.3s ease;
    }

    button:hover {
        background: #1976d2;
    }

    .back-link {
        display: block;
        text-align: center;
        margin-top: 20px;
        color: #666;
        text-decoration: none;
        font-size: 14px;
    }

    .back-link:hover {
        text-decoration: underline;
    }
</style>

<div class="form-container">
    <h2>Thêm bài tập</h2>

    <form method="POST" action="{{ route('task.store') }}">
        @csrf

        <div class="form-group">
            <label for="title">Tiêu đề</label>
            <input type="text" name="title" id="title" required>
        </div>

        <div class="form-group">
            <label for="date">Ngày</label>
            <input type="date" name="date" id="date" value="{{ $date }}" required readonly>
        </div>

        <div class="form-group">
            <label for="status">Trạng thái</label>
            <select name="status" id="status" required>
                <option value="prepare">Chuẩn bị</option>
                <option value="doing">Đang thực hiện</option>
                <option value="done">Hoàn thành</option>
            </select>
        </div>

        <button type="submit">Lưu bài tập</button>
    </form>

    <a href="{{ route('user.calendar') }}" class="back-link">← Quay lại lịch học</a>
</div>
@endsection
