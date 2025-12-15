@extends('layouts.user')

@section('content')
<h2 style="text-align:center;">Thống kê bài tập</h2>

<!-- Bộ lọc tháng -->
<form method="GET" class="filter-form">
    <div class="filter-group">
        <label for="month">Tháng:</label>
        <select name="month" id="month">
            @for ($m = 1; $m <= 12; $m++)
                <option value="{{ $m }}" {{ (int)($month ?? 0) === $m ? 'selected' : '' }}>{{ $m }}</option>
            @endfor
        </select>

        <label for="year">Năm:</label>
        <select name="year" id="year">
            @php $startYear = 2023; $endYear = now()->year + 1; @endphp
            @for ($y = $startYear; $y <= $endYear; $y++)
                <option value="{{ $y }}" {{ (int)($year ?? 0) === $y ? 'selected' : '' }}>{{ $y }}</option>
            @endfor
        </select>

        <button type="submit">🔍 Xem</button>
        <a href="{{ route('user.statistics') }}" class="summary-link">📊 Tổng hợp tất cả</a>
    </div>
</form>

<style>
    .stats-container {
        display: flex;
        gap: 40px;
        align-items: flex-start;
        justify-content: flex-start;
    }

    .task-list {
        flex: 0 0 60%;
        max-width: 60%;
    }

    .task-status-columns {
        display: flex;
        gap: 20px;
        justify-content: space-between;
    }

    .status-column {
        flex: 1;
        background: #ffffff;
        padding: 12px;
        border-radius: 10px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.05);
    }

    .status-column h4 {
        text-align: center;
        color: #1565c0;
        margin-bottom: 10px;
        font-size: 16px;
    }

    .task-card {
        background: #f5f5f5;
        padding: 8px 12px;
        margin-bottom: 8px;
        border-radius: 6px;
        font-size: 14px;
        box-shadow: 0 1px 4px rgba(0,0,0,0.05);
    }

    .yellow { background: #fff9c4; }
    .blue   { background: #bbdefb; }
    .green  { background: #c8e6c9; }

    .chart-box {
        flex: 0 0 40%;
        max-width: 40%;
        text-align: center;
    }

    /* Chỉ áp dụng cho biểu đồ tròn */
    #taskChart {
        max-width: 300px;
        margin-top: 20px;
        margin-left: auto;
        margin-right: auto;
    }

    /* Biểu đồ cột to rõ */
    #barChart {
        width: 1000px !important;
        height: 400px !important;
        margin: 0 auto;
        display: block;
    }

    /* Bộ lọc */
    .filter-form {
        display: flex;
        justify-content: center;
        margin-bottom: 30px;
    }

    .filter-group {
        display: flex;
        gap: 15px;
        align-items: center;
        background: #ffffff;
        padding: 12px 20px;
        border-radius: 12px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.05);
    }

    .filter-group label {
        font-weight: bold;
        color: #1565c0;
    }

    .filter-group select {
        padding: 6px 10px;
        border-radius: 6px;
        border: 1px solid #ccc;
        background-color: #e3f2fd;
        font-size: 14px;
    }

    .filter-group button {
        padding: 6px 16px;
        background-color: #1976d2;
        color: white;
        border: none;
        border-radius: 6px;
        font-weight: bold;
        cursor: pointer;
        transition: background 0.3s ease;
    }

    .filter-group button:hover {
        background-color: #0d47a1;
    }

    .summary-link {
        margin-left: 10px;
        color: #1565c0;
        font-weight: bold;
        text-decoration: none;
    }

    .summary-link:hover {
        color: #0d47a1;
    }
</style>

<!-- Bố cục 2 bên -->
<div class="stats-container">
    <div class="task-list">
        <div class="task-status-columns">
            <div class="status-column">
                <h4>📌 Chuẩn bị</h4>
                @foreach($tasks->where('status', 'prepare') as $task)
                    <div class="task-card yellow">{{ $task->title }}</div>
                @endforeach
            </div>

            <div class="status-column">
                <h4>⚙️ Đang thực hiện</h4>
                @foreach($tasks->where('status', 'doing') as $task)
                    <div class="task-card blue">{{ $task->title }}</div>
                @endforeach
            </div>

            <div class="status-column">
                <h4>✅ Hoàn thành</h4>
                @foreach($tasks->where('status', 'done') as $task)
                    <div class="task-card green">{{ $task->title }}</div>
                @endforeach
            </div>
        </div>
    </div>

    <div class="chart-box">
        <h4>Biểu đồ trạng thái</h4>
        <canvas
            id="taskChart"
            data-prepare="{{ (int)($prepare ?? 0) }}"
            data-doing="{{ (int)($doing ?? 0) }}"
            data-done="{{ (int)($done ?? 0) }}"
        ></canvas>
    </div>
</div>

<!-- Biểu đồ cột -->
<div style="margin-top: 50px;">
    <h3 style="text-align:center;">Biểu đồ trạng thái theo tháng ({{ $year }})</h3>
    <canvas id="barChart"></canvas>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2.2.0"></script>

<script>
/* Biểu đồ tròn */
(function () {
    var el = document.getElementById('taskChart');
    var prepare = Number(el.dataset.prepare || 0);
    var doing   = Number(el.dataset.doing   || 0);
    var done    = Number(el.dataset.done    || 0);

    var ctx = el.getContext('2d');
    new Chart(ctx, {
        type: 'pie',
        data: {
            labels: ['Chuẩn bị', 'Đang thực hiện', 'Hoàn thành'],
            datasets: [{
                data: [prepare, doing, done],
                backgroundColor: ['#fbc02d', '#29b6f6', '#66bb6a'],
                borderColor: '#ffffff',
                borderWidth: 2
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: { position: 'bottom' },
                tooltip: { enabled: true },
                datalabels: {
                    color: '#fff',
                    font: { weight: 'bold', size: 14 },
                    formatter: value => value
                }
            }
        },
        plugins: [ChartDataLabels]
    });
})();

/* Biểu đồ cột */
(function () {
    const stats = JSON.parse(`{!! json_encode($stats) !!}`);

    const labels = Object.keys(stats).map(m => "Tháng " + m);
    const prepareData = Object.values(stats).map(s => s.prepare);
    const doingData   = Object.values(stats).map(s => s.doing);
    const doneData    = Object.values(stats).map(s => s.done);

    const ctx = document.getElementById('barChart').getContext('2d');

    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: labels,
            datasets: [
                {
                    label: 'Chuẩn bị',
                    data: prepareData,
                    backgroundColor: '#fbc02d'
                },
                {
                    label: 'Đang thực hiện',
                    data: doingData,
                    backgroundColor: '#29b6f6'
                },
                {
                    label: 'Hoàn thành',
                    data: doneData,
                    backgroundColor: '#66bb6a'
                }
            ]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { position: 'top' }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: { stepSize: 1 }
                }
            }
        }
    });
})();
</script>

@endsection
