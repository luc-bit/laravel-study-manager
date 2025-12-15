@extends('layouts.user')

@section('content')
<h2 style="text-align:center;">Lịch bài tập tháng {{ str_pad($month, 2, '0', STR_PAD_LEFT) }}/{{ $year }}</h2>

<div style="text-align:center; margin-top: 10px; margin-bottom: 20px;">
    <span style="background:#fff9c4; padding:4px 10px; border-radius:6px; margin-right:10px;">📌 Chuẩn bị</span>
    <span style="background:#bbdefb; padding:4px 10px; border-radius:6px; margin-right:10px;">⚙️ Đang thực hiện</span>
    <span style="background:#c8e6c9; padding:4px 10px; border-radius:6px;">✅ Hoàn thành</span>
</div>


@if(session('success'))
    <p style="color: green; text-align:center;">{{ session('success') }}</p>
@endif

@php
    $prevMonth = $month - 1;
    $prevYear = $year;
    if ($prevMonth < 1) {
        $prevMonth = 12;
        $prevYear--;
    }

    $nextMonth = $month + 1;
    $nextYear = $year;
    if ($nextMonth > 12) {
        $nextMonth = 1;
        $nextYear++;
    }
@endphp

<style>
    .calendar-wrapper {
        position: relative;
        margin-top: 20px;
    }

    .calendar {
        display: grid;
        grid-template-columns: repeat(7, 1fr);
        gap: 10px;
    }

    .day {
        background: #fff;
        border-radius: 10px;
        padding: 10px;
        min-height: 140px;
        box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        position: relative;
        display: flex;
        flex-direction: column;
        justify-content: flex-start;
    }

    .date {
        font-weight: bold;
        color: #2196f3;
    }

    .add-task {
        position: absolute;
        top: 8px;
        right: 8px;
        font-size: 18px;
        color: #2196f3;
        cursor: pointer;
        transition: color 0.2s ease;
    }

    .add-task:hover {
        color: #0d47a1;
    }

    .task {
        margin-top: 8px;
        padding: 6px 10px;
        border-radius: 6px;
        font-size: 14px;
        position: relative;
        color: #333;
    }

    .task.prepare { background: #fff9c4; }
    .task.doing   { background: #bbdefb; }
    .task.done    { background: #c8e6c9; }

    .task:hover {
        opacity: 0.9;
    }

    .status-icon {
        margin-right: 6px;
        font-weight: bold;
    }

    .actions {
        margin-top: 6px;
        display: flex;
        justify-content: flex-end;
        gap: 10px;
        font-size: 16px;
    }

    .edit-btn,
    .delete-btn {
        cursor: pointer;
        transition: color 0.2s ease;
    }

    .edit-btn:hover {
        color: #2196f3;
    }

    .delete-btn:hover {
        color: #e53935;
    }

    .month-btn {
        position: absolute;
        top: 50%;
        transform: translateY(-50%);
        font-size: 28px;
        color: #2196f3;
        text-decoration: none;
        font-weight: bold;
        padding: 10px;
        z-index: 10;
    }

    .month-btn.left {
        left: -50px;
    }

    .month-btn.right {
        right: -50px;
    }

    .month-btn:hover {
        color: #0d47a1;
    }
</style>

<div class="calendar-wrapper">
    <a class="month-btn left" href="{{ route('user.calendar', ['month' => $prevMonth, 'year' => $prevYear]) }}">⬅️</a>

    <div class="calendar">
        @for ($i = 1; $i <= $daysInMonth; $i++)
            @php
                $dateStr = $year . '-' . str_pad($month, 2, '0', STR_PAD_LEFT) . '-' . str_pad($i, 2, '0', STR_PAD_LEFT);
            @endphp

            <div class="day" data-date="{{ $dateStr }}">
                <div class="date">{{ $i }}</div>
                <div class="add-task">➕</div>

                @foreach($tasks as $task)
                    @if($task->date->format('Y-m-d') === $dateStr)
                        <div class="task {{ $task->status }}">
                            <span class="status-icon">
                                @if($task->status === 'prepare') 📌
                                @elseif($task->status === 'doing') ⚙️
                                @elseif($task->status === 'done') ✅
                                @endif
                            </span>
                            {{ $task->title }}
                            <div class="actions">
                                <span class="edit-btn" data-id="{{ $task->id }}">✏️</span>
                                <span class="delete-btn" data-id="{{ $task->id }}">🗑️</span>
                            </div>
                        </div>
                    @endif
                @endforeach
            </div>
        @endfor
    </div>

    <a class="month-btn right" href="{{ route('user.calendar', ['month' => $nextMonth, 'year' => $nextYear]) }}">➡️</a>
</div>

<script>
    document.querySelectorAll('.add-task').forEach(function(btn) {
        btn.addEventListener('click', function() {
            const date = btn.parentElement.getAttribute('data-date');
            window.location.href = "/user/task/create?date=" + date;
        });
    });

    document.querySelectorAll('.edit-btn').forEach(function(btn) {
        btn.addEventListener('click', function() {
            const id = btn.getAttribute('data-id');
            window.location.href = "/user/task/" + id + "/edit";
        });
    });

    document.querySelectorAll('.delete-btn').forEach(function(btn) {
        btn.addEventListener('click', function() {
            const id = btn.getAttribute('data-id');
            const url = "/user/task/" + id + "/delete";
            showConfirmBox("Bạn có chắc muốn xoá bài tập này?", url);
        });
    });
</script>
@endsection
