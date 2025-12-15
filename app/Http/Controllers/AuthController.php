<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    /**
     * Hiển thị form đăng nhập
     */
    public function showLogin()
    {
        return view('auth.login');
    }

    /**
     * Xử lý đăng nhập (không dùng hash)
     */
    public function login(Request $request)
    {
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required'
        ]);

        // ✅ Tìm user theo email + mật khẩu plain text
        $user = User::where('email', $request->email)
                    ->where('password', $request->password)
                    ->first();

        if (!$user) {
            return back()->withErrors([
                'email' => 'Sai thông tin đăng nhập'
            ]);
        }

        // ✅ Chặn tài khoản bị banned
        if ($user->status === 'banned') {
            return back()->withErrors([
                'email' => 'Tài khoản của bạn đã bị khóa bởi admin.'
            ]);
        }

        // ✅ Đăng nhập thủ công
        Auth::login($user);

        // ✅ Điều hướng theo vai trò
        return $user->email === 'admin@example.com'
            ? redirect()->route('admin.index')
            : redirect()->route('user.index');
    }

    /**
     * Đăng xuất
     */
    public function logout()
    {
        Auth::logout();
        return redirect()->route('login');
    }

    /**
     * Hiển thị form đăng ký
     */
    public function showRegister()
    {
        return view('auth.register');
    }

    /**
     * Xử lý đăng ký (không hash mật khẩu)
     */
    public function register(Request $request)
    {
        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email',
            'password' => 'required|min:6|confirmed'
        ]);

        // ✅ Lưu mật khẩu dạng plain text
        $user = User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => $request->password,
            'status'   => 'active'
        ]);

        Auth::login($user);

        return redirect()->route('user.index');
    }
}
