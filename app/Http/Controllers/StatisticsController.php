<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class StatisticsController extends Controller
{
    /**
     * Trang thống kê bài tập theo tháng/năm
     */
    public function index(Request $request)
    {
        $year  = $request->year ?? now()->year;
        $month = $request->month ?? null;

        // ✅ Query danh sách task theo năm + tháng (nếu có)
        $tasksQuery = Task::where('user_id', Auth::id())
                          ->whereYear('date', $year);

        if (!empty($month)) {
            $tasksQuery->whereMonth('date', $month);
        }

        $tasks = $tasksQuery->get();

        // ✅ Đếm trạng thái cho biểu đồ tròn
        $prepare = $tasks->where('status', 'prepare')->count();
        $doing   = $tasks->where('status', 'doing')->count();
        $done    = $tasks->where('status', 'done')->count();

        // ✅ Lấy dữ liệu biểu đồ cột theo tháng
        $rawStats = DB::table('tasks')
            ->select(
                DB::raw('MONTH(date) as month'),
                'status',
                DB::raw('COUNT(*) as total')
            )
            ->where('user_id', Auth::id())
            ->whereYear('date', $year)
            ->groupBy(DB::raw('MONTH(date)'), 'status')
            ->get();

        // ✅ Chuẩn bị mảng thống kê 12 tháng
        $stats = [];
        for ($m = 1; $m <= 12; $m++) {
            $stats[$m] = [
                'prepare' => 0,
                'doing'   => 0,
                'done'    => 0,
            ];
        }

        // ✅ Gán dữ liệu vào mảng
        foreach ($rawStats as $row) {
            $stats[$row->month][$row->status] = $row->total;
        }

        return view('user.statistics', compact(
            'tasks',
            'prepare',
            'doing',
            'done',
            'stats',
            'month',
            'year'
        ));
    }
}
