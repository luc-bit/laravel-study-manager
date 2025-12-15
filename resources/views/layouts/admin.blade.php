<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Admin - Study Manager</title>
    <style>
        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            font-family: 'Segoe UI', sans-serif;
            background: #f4f6f9;
            display: flex;
            min-height: 100vh;
        }

        .sidebar {
            width: 240px;
            background: linear-gradient(135deg, #2193b0 0%, #6dd5ed 100%);
            color: white;
            padding: 30px 20px;
            position: fixed;
            top: 0;
            bottom: 0;
            left: 0;
            box-shadow: 2px 0 10px rgba(0,0,0,0.1);
        }

        .sidebar h2 {
            font-size: 22px;
            margin-bottom: 40px;
            text-align: center;
        }

        .sidebar a {
            display: block;
            color: white;
            text-decoration: none;
            margin-bottom: 20px;
            font-weight: bold;
            padding: 10px 14px;
            border-radius: 8px;
            transition: background 0.3s ease;
        }

        .sidebar a:hover {
            background: rgba(255, 255, 255, 0.2);
        }

        .main {
            margin-left: 240px;
            padding: 40px;
            flex: 1;
        }

        .content-box {
            background: white;
            border-radius: 20px;
            padding: 30px;
            box-shadow: 0 12px 24px rgba(0,0,0,0.1);
        }

        footer {
            text-align: center;
            margin-top: 40px;
            font-size: 14px;
            color: #888;
        }
    </style>
</head>
<body>
    <div class="sidebar">
        <h2>Quản trị</h2>
        <a href="{{ route('admin.index') }}">📋 Người dùng</a>
        <a href="{{ route('logout') }}">🚪 Đăng xuất</a>
    </div>

    <div class="main">
        <div class="content-box">
            @yield('content')
        </div>
      
    </div>
</body>
</html>
