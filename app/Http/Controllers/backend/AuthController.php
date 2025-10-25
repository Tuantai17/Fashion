<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
class AuthController extends Controller
{
    public function login()
    {
        return view('backend.auth.login');
    }

    public function dologin(Request $request)
    {
        // Lấy username và password từ request
        $username = $request->username;
        $password = $request->password;

        // Kiểm tra xem username là email hay username thông thường
        if (filter_var($username, FILTER_VALIDATE_EMAIL)) {
            $data['email'] = $username;
        } else {
            $data['username'] = $username;
        }

        $data['password'] = $password;

        // Kiểm tra đăng nhập
        if (Auth::attempt($data)) {
            return redirect()->route('admin.dashboard')->with('success', 'Đăng nhập thành công');
        }

        // Nếu đăng nhập thất bại
        return back()->with('error', 'Đăng nhập thất bại');
    }

    public function logout(Request $request)
    {
        // Lưu lại username và password đang dùng
        $username = Auth::user()->username ?? '';
        $email = Auth::user()->email ?? '';

        Auth::logout(); // Đăng xuất
        $request->session()->invalidate(); // Xóa session
        $request->session()->regenerateToken(); // Tạo token mới

        // Gửi lại thông tin cũ về form login
        return redirect()
            ->route('admin.login')
            ->withInput([
                'username' => $username ?: $email,
                'password' => '' // vì lý do bảo mật, không gửi lại password thật
            ])
            ->with('success', 'Đăng xuất thành công');
    }



    
}
