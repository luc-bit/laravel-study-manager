    @extends('layouts.admin')

    @section('content')
    <style>
        .dashboard-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
        }

        .stat-box {
            background: linear-gradient(to right, #42a5f5, #64b5f6);
            color: white;
            padding: 20px;
            border-radius: 15px;
            box-shadow: 0 6px 12px rgba(0,0,0,0.1);
            width: 250px;
            text-align: center;
        }

        .stat-box h3 {
            margin: 0;
            font-size: 18px;
        }

        .stat-box p {
            font-size: 32px;
            font-weight: bold;
            margin-top: 10px;
        }

        .user-table {
            width: 100%;
            border-collapse: collapse;
            background: white;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
            border-radius: 10px;
            overflow: hidden;
            margin-top: 40px;
        }

        .user-table th, .user-table td {
            padding: 15px;
            text-align: left;
            border-bottom: 1px solid #eee;
        }

        .user-table th {
            background-color: #e3f2fd;
            color: #1565c0;
        }

        .user-table tr:hover {
            background-color: #f1faff;
        }

        .avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            object-fit: cover;
            margin-right: 10px;
        }

        .user-info {
            display: flex;
            align-items: center;
        }

        .status-btn {
            padding: 6px 12px;
            border-radius: 6px;
            border: none;
            cursor: pointer;
            font-weight: bold;
            color: white;
        }

        .active-btn { background: #4caf50; }
        .banned-btn { background: #e53935; }
    </style>

    <div class="dashboard-header">
        <div class="stat-box">
            <h3>Tổng số người dùng</h3>
            <p>{{ $userCount }}</p>
        </div>
    </div>

    <h2>Danh sách người dùng</h2>
    <table class="user-table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Người dùng</th>
                <th>Email</th>
                <th>Ngày tạo</th>
                <th>Trạng thái</th> <!-- ✅ Cột mới -->
            </tr>
        </thead>
        <tbody>
            @foreach($users as $user)
            <tr>
                <td>{{ $user->id }}</td>

                <td>
                    <div class="user-info">
                        <img src="https://ui-avatars.com/api/?name={{ urlencode($user->name) }}&background=2196f3&color=fff" class="avatar">
                        {{ $user->name }}
                    </div>
                </td>

                <td>{{ $user->email }}</td>
                <td>{{ $user->created_at->format('d/m/Y') }}</td>

                <!-- ✅ Cột trạng thái -->
                <td>
                   <form action="{{ route('admin.user.updateStatus', $user->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    @if($user->id !== 1)
                        @if($user->status === 'active')
                            <input type="hidden" name="status" value="banned">
                            <button type="submit" class="status-btn active-btn">Active</button>
                        @else
                            <input type="hidden" name="status" value="active">
                            <button type="submit" class="status-btn banned-btn">Banned</button>
                        @endif
                    @endif
                </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    @endsection
