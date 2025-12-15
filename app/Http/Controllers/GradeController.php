<?php

namespace App\Http\Controllers;

use App\Models\Grade;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GradeController extends Controller
{
    /**
     * Hiển thị bảng điểm của user
     */
    public function index()
    {
        $grades = Grade::where('user_id', Auth::id())
            ->orderBy('id', 'asc')
            ->get();

        return view('user.grades.index', compact('grades'));
    }

    /**
     * Lưu một dòng điểm mới (thêm môn)
     */
    public function store(Request $request)
    {
        $request->validate([
            'subject_name'    => 'required|string|max:255',
            'process_score'   => 'nullable|numeric|min:0|max:10',
            'midterm_score'   => 'nullable|numeric|min:0|max:10',
            'final_score'     => 'nullable|numeric|min:0|max:10',
            'process_weight'  => 'nullable|integer|min:0|max:100',
            'midterm_weight'  => 'nullable|integer|min:0|max:100',
            'final_weight'    => 'nullable|integer|min:0|max:100',
        ]);

        $data = $this->calculateResult($request);

        Grade::create(array_merge($data, [
            'user_id' => Auth::id(),
        ]));

        return redirect()->route('user.grades.index')
            ->with('success', 'Đã thêm môn học vào bảng điểm.');
    }

    /**
     * Cập nhật một dòng điểm
     */
    public function update(Request $request, $id)
    {
        $grade = Grade::where('id', $id)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        $request->validate([
            'subject_name'    => 'required|string|max:255',
            'process_score'   => 'nullable|numeric|min:0|max:10',
            'midterm_score'   => 'nullable|numeric|min:0|max:10',
            'final_score'     => 'nullable|numeric|min:0|max:10',
            'process_weight'  => 'nullable|integer|min:0|max:100',
            'midterm_weight'  => 'nullable|integer|min:0|max:100',
            'final_weight'    => 'nullable|integer|min:0|max:100',
        ]);

        $data = $this->calculateResult($request);

        $grade->update($data);

        return redirect()->route('user.grades.index')
            ->with('success', 'Đã cập nhật điểm môn học.');
    }

    /**
     * Xóa một dòng điểm
     */
    public function destroy($id)
    {
        $grade = Grade::where('id', $id)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        $grade->delete();

        return redirect()->route('user.grades.index')
            ->with('success', 'Đã xóa môn học khỏi bảng điểm.');
    }

    /**
     * Tính KQ và trạng thái theo yêu cầu
     */
    protected function calculateResult(Request $request): array
    {
        $processScore  = $request->process_score;
        $midtermScore  = $request->midterm_score;
        $finalScore    = $request->final_score;

        $processWeight = $request->process_weight;
        $midtermWeight = $request->midterm_weight;
        $finalWeight   = $request->final_weight;

        // Mặc định
        $resultScore = 0;
        $status = 'không đạt';

        // Chỉ tính nếu có ít nhất 1 trọng số > 0
        $hasWeight = ($processWeight || $midtermWeight || $finalWeight);

        if ($hasWeight) {
            $total = 0;

            if (!is_null($processScore) && !is_null($processWeight)) {
                $total += $processScore * ($processWeight / 100);
            }

            if (!is_null($midtermScore) && !is_null($midtermWeight)) {
                $total += $midtermScore * ($midtermWeight / 100);
            }

            if (!is_null($finalScore) && !is_null($finalWeight)) {
                $total += $finalScore * ($finalWeight / 100);
            }

            $resultScore = round($total, 2);

            if ($resultScore >= 5) {
                $status = 'đạt';
            } else {
                $status = 'không đạt';
            }
        }

        return [
            'subject_name'   => $request->subject_name,
            'process_score'  => $processScore,
            'midterm_score'  => $midtermScore,
            'final_score'    => $finalScore,
            'process_weight' => $processWeight,
            'midterm_weight' => $midtermWeight,
            'final_weight'   => $finalWeight,
            'result_score'   => $resultScore,
            'status'         => $status,
        ];
    }
}
