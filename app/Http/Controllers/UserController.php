<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class UserController extends Controller
{
    /**
     * Trang chính của user
     */
    public function index()
    {
        return view('user.index');
    }

    /**
     * Lịch bài tập theo tháng
     */
    public function calendar(Request $request)
    {
        $month = $request->input('month') ?? now()->month;
        $year  = $request->input('year') ?? now()->year;

        // ✅ Tạo ngày đầu tháng để lấy số ngày
        $date = Carbon::createFromDate($year, $month, 1);
        $daysInMonth = $date->daysInMonth;

        // ✅ Lấy bài tập theo tháng + năm + user
        $tasks = Task::where('user_id', Auth::id())
                     ->whereMonth('date', $month)
                     ->whereYear('date', $year)
                     ->get();

        return view('user.calendar', compact(
            'month',
            'year',
            'daysInMonth',
            'tasks'
        ));
    }

    /**
     * Thống kê bài tập theo tháng/năm
     */
    public function statistics(Request $request)
    {
        $userId = Auth::id();
        $month  = $request->input('month');
        $year   = $request->input('year');

        // ✅ Query cơ bản
        $query = Task::where('user_id', $userId);

        // ✅ Nếu có chọn tháng + năm thì lọc
        if (!empty($month) && !empty($year)) {
            $query->whereMonth('date', $month)
                  ->whereYear('date', $year);
        }

        $tasks = $query->get();

        // ✅ Đếm trạng thái
        $prepare = $tasks->where('status', 'prepare')->count();
        $doing   = $tasks->where('status', 'doing')->count();
        $done    = $tasks->where('status', 'done')->count();

        return view('user.statistics', compact(
            'tasks',
            'prepare',
            'doing',
            'done',
            'month',
            'year'
        ));
    }
}
