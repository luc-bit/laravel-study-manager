<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index() {
        // Truy vấn thêm cột status
        $users = User::select('id', 'name', 'email', 'created_at', 'status')->get();
        $userCount = $users->count();
        return view('admin.index', compact('users', 'userCount'));
    }

    // ✅ Hàm cập nhật trạng thái
    public function updateStatus(Request $request, $id) {
        $user = User::findOrFail($id);
        $user->status = $request->status;
        $user->save();
        return redirect()->route('admin.index')->with('success', 'Đã cập nhật trạng thái');
    }
}
