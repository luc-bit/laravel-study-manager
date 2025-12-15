<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="utf-8">
    <title>Study Manager</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <style>
        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            font-family: 'Segoe UI', sans-serif;
            background: linear-gradient(135deg, #2193b0 0%, #6dd5ed 100%);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        header {
            background: rgba(255, 255, 255, 0.9);
            padding: 20px 40px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        }

        header h1 {
            margin: 0;
            color: #1565c0;
            font-size: 24px;
        }

        nav a {
            margin-left: 20px;
            text-decoration: none;
            color: #1565c0;
            font-weight: bold;
            transition: color 0.3s ease;
        }

        nav a:hover {
            color: #0d47a1;
        }

        main {
            flex: 1;
            padding: 40px 20px;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        footer {
            background: rgba(255, 255, 255, 0.9);
            text-align: center;
            padding: 15px;
            font-size: 14px;
            color: #333;
            box-shadow: 0 -2px 8px rgba(0,0,0,0.05);
        }

        .content-box {
            background: rgba(255, 255, 255, 0.95);
            padding: 30px;
            border-radius: 16px;
            box-shadow: 0 8px 16px rgba(0,0,0,0.1);
            width: 100%;
            max-width: 500px;
        }
    </style>
</head>
<body>
    <main>
        <div class="content-box">
            @yield('content')
        </div>
    </main>
</body>
</html>
