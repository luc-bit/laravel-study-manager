<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TaskController extends Controller
{
    /**
     * Form thêm bài tập
     */
    public function create(Request $request)
    {
        $date = $request->query('date');
        return view('user.task.create', compact('date'));
    }

    /**
     * Lưu bài tập mới
     */
    public function store(Request $request)
    {
        $request->validate([
            'title'  => 'required|string|max:255',
            'date'   => 'required|date',
            'status' => 'required|in:prepare,doing,done',
        ]);

        Task::create([
            'user_id' => Auth::id(),
            'title'   => $request->title,
            'date'    => $request->date,
            'status'  => $request->status,
        ]);

        return redirect()
            ->route('user.calendar')
            ->with('success', 'Thêm bài tập thành công');
    }

    /**
     * Form sửa bài tập
     */
    public function edit($id)
    {
        $task = Task::where('id', $id)
                    ->where('user_id', Auth::id())
                    ->firstOrFail();

        return view('user.task.edit', compact('task'));
    }

    /**
     * Cập nhật bài tập
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'title'  => 'required|string|max:255',
            'date'   => 'required|date',
            'status' => 'required|in:prepare,doing,done',
        ]);

        $task = Task::where('id', $id)
                    ->where('user_id', Auth::id())
                    ->firstOrFail();

        $task->update([
            'title'  => $request->title,
            'date'   => $request->date,
            'status' => $request->status,
        ]);

        return redirect()
            ->route('user.calendar')
            ->with('success', 'Cập nhật bài tập thành công');
    }

    /**
     * Xoá bài tập
     */
    public function destroy($id)
    {
        $task = Task::where('id', $id)
                    ->where('user_id', Auth::id())
                    ->firstOrFail();

        $task->delete();

        return redirect()
            ->route('user.calendar')
            ->with('success', 'Đã xoá bài tập');
    }
}
