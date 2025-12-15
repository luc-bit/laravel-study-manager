<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Đăng nhập hệ thống</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: 'Segoe UI', sans-serif;
            background: linear-gradient(135deg, #2193b0 0%, #6dd5ed 100%);
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .login-container {
            background: rgba(255, 255, 255, 0.95);
            padding: 40px;
            border-radius: 20px;
            box-shadow: 0 12px 24px rgba(0, 0, 0, 0.2);
            width: 360px;
            backdrop-filter: blur(10px);
        }

        .login-container h2 {
            text-align: center;
            margin-bottom: 30px;
            color: #1565c0;
        }

        label {
            display: block;
            margin-bottom: 6px;
            font-weight: 600;
            color: #444;
        }

        input {
            width: 100%;
            padding: 12px;
            margin-bottom: 20px;
            border: none;
            border-radius: 12px;
            background-color: #e3f2fd;
            box-shadow: inset 0 2px 4px rgba(0,0,0,0.1);
            font-size: 14px;
        }

        button {
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

        button:hover {
            background: linear-gradient(to right, #0d47a1, #42a5f5);
        }

        .error {
            color: red;
            text-align: center;
            margin-top: 10px;
            font-size: 14px;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <h2>Đăng nhập hệ thống</h2>
        <form method="POST" action="{{ route('login') }}">
            @csrf
            <label for="email">Email:</label>
            <input type="text" name="email" id="email" required>

            <label for="password">Mật khẩu:</label>
            <input type="password" name="password" id="password" required>

            <button type="submit">Đăng nhập</button>
        </form>
        <div style="text-align:center; margin-top: 15px;">
            <a href="{{ route('register') }}" 
                style="display:inline-block; margin-top:10px; color:#0d47a1; font-weight:bold; text-decoration:none;">
            Chưa có tài khoản? Đăng ký ngay
            </a>
        </div>
        @if($errors->any())
            <div class="error">tài khoản không tồn tại hoặc bị vô hiệu hóa</div>
        @endif
    </div>
</body>
</html>
