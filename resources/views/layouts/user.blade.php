<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Study Manager</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }

        html, body {
            height: 100%;
            font-family: 'Segoe UI', sans-serif;
            background: #f5f8fc;
        }

        body { display: flex; }

        .sidebar {
            width: 220px;
            background: #2196f3;
            color: white;
            padding: 30px 20px;
            flex-shrink: 0;
            display: flex;
            flex-direction: column;
            align-items: flex-start;
            height: 100vh;
        }

        .sidebar h3 {
            margin-bottom: 30px;
            font-size: 20px;
            font-weight: bold;
        }

        .sidebar a {
            display: block;
            color: white;
            text-decoration: none;
            margin-bottom: 18px;
            font-size: 16px;
            transition: background 0.2s ease, padding-left 0.2s ease;
            padding: 6px 10px;
            border-radius: 6px;
            width: 100%;
        }

        .sidebar a:hover {
            background: rgba(255,255,255,0.2);
            padding-left: 16px;
        }

        .main-content {
            flex-grow: 1;
            height: 100vh;
            overflow-y: auto;
            padding: 30px 40px;
        }

        @media (max-width: 768px) {
            .sidebar { width: 100px; padding: 20px 10px; }
            .sidebar h3 { font-size: 16px; }
            .sidebar a { font-size: 14px; margin-bottom: 12px; }
            .main-content { padding: 20px; }
        }

        .overlay {
            position: fixed;
            top: 0; left: 0;
            width: 100%; height: 100%;
            background: rgba(0,0,0,0.4);
            display: none;
            justify-content: center;
            align-items: center;
            z-index: 9999;
        }

        .box-content {
            background: white;
            padding: 30px 40px;
            border-radius: 12px;
            box-shadow: 0 8px 20px rgba(0,0,0,0.2);
            text-align: center;
            font-size: 16px;
            max-width: 400px;
        }

        .box-buttons {
            margin-top: 20px;
            display: flex;
            justify-content: center;
            gap: 20px;
        }

        .box-buttons button {
            padding: 10px 20px;
            background: #2196f3;
            color: white;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-weight: bold;
        }

        .box-buttons button:last-child {
            background: #888;
        }
    </style>
</head>
<body>
    <div class="sidebar">
        <h3>{{ Auth::user()->name }}</h3>
        <a href="{{ route('user.calendar') }}">📅 Lịch học</a>
        <a href="{{ route('user.statistics') }}">📊 Thống kê</a>
        <a href="{{ route('user.grades.index') }}">📘 QL Điểm</a>
        <a href="{{ route('logout') }}">🚪 Đăng xuất</a>
    </div>

    <div class="main-content">
        @yield('content')
    </div>

    <!-- Message box -->
    <div id="message-box" class="overlay">
        <div class="box-content">
            <p id="message-text">Thông báo</p>
            <div class="box-buttons">
                <button onclick="closeMessageBox()">OK</button>
            </div>
        </div>
    </div>

    <!-- Confirm box -->
    <div id="confirm-box" class="overlay">
        <div class="box-content">
            <p id="confirm-text">Bạn có chắc muốn xoá bài tập này?</p>
            <div class="box-buttons">
                <button onclick="confirmAction()">OK</button>
                <button onclick="closeConfirmBox()">Hủy</button>
            </div>
        </div>
    </div>

    <script>
    // Message box
    function showMessageBox(message) {
        document.getElementById('message-text').textContent = message;
        document.getElementById('message-box').style.display = 'flex';
    }
    function closeMessageBox() {
        document.getElementById('message-box').style.display = 'none';
    }

    // Confirm box
   let confirmUrl = null;
let confirmCallback = null;

function showConfirmBox(message, url = null, callback = null) {
    document.getElementById('confirm-text').textContent = message;
    document.getElementById('confirm-box').style.display = 'flex';
    confirmUrl = url;
    confirmCallback = callback;
}

function closeConfirmBox() {
    document.getElementById('confirm-box').style.display = 'none';
    confirmUrl = null;
    confirmCallback = null;
}

function confirmAction() {
    if (typeof confirmCallback === 'function') {
        confirmCallback(confirmUrl);
    } else if (confirmUrl) {
        // fallback kiểu cũ nếu sau này bạn dùng cho task
        window.location.href = confirmUrl;
    }
    closeConfirmBox();
}


    document.addEventListener("DOMContentLoaded", function () {
    var successMessage = "{{ session('success') ?? '' }}";
    if (successMessage) {
        showMessageBox(successMessage);
    }

    document.querySelectorAll('.delete-btn').forEach(function(btn) {
        btn.addEventListener('click', function() {
            const id = btn.getAttribute('data-id');
            const url = "/user/task/" + id + "/delete";
            showConfirmBox("Bạn có chắc muốn xoá bài tập này?", url);
        });
    });
});
</script>
</body>
</html>
