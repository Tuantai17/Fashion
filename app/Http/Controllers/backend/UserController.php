<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function index()
    {
        $list = User::select('user.id', 'user.name', 'user.email', 'user.status', 'user.created_at', 'user.roles')
            ->orderBy('user.created_at', 'DESC')
            ->paginate(5);

        return view('backend.user.index', compact('list'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('backend.user.create'); // Đường dẫn tới file Blade bạn vừa tạo
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:user,email',
            'password' => 'required|string|min:6|confirmed',
            'roles' => 'required|in:admin,customer', // Vai trò là admin hoặc customer
            'status' => 'required|boolean',
            'phone' => 'required|string|unique:user,phone',
        ]);

        // Tạo username nếu không có giá trị
        $username = $request->username ?: strtolower(str_replace(' ', '.', $request->name)); // Tạo username từ tên người dùng

        // Kiểm tra nếu username đã tồn tại
        if (User::where('username', $username)->exists()) {
            return redirect()->back()->with('error', 'Username đã tồn tại. Vui lòng chọn username khác.');
        }

        // Tạo người dùng mới
        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'status' => $request->status,
            'roles' => $request->role, // Lưu giá trị vai trò từ form
            'phone' => $request->phone,
            'address' => '', // Mặc định rỗng nếu không nhập
            'avatar' => '',  // Mặc định rỗng nếu không có avatar
            'username' => $username, // Gán giá trị username đã tạo
            'created_by' => Auth::id() ?? 1, // Nếu chưa đăng nhập thì để mặc định là 1
        ]);

        return redirect()->route('user.index')->with('success', 'Thêm người dùng thành công!');
    }

    // cho khách hàng
    public function customerList()
    {
        $list = User::select('user.id', 'user.name', 'user.email', 'user.status', 'user.created_at', 'user.roles')
            ->where('roles', 'customer')  // Lọc role là 'customer'
            ->orderBy('user.created_at', 'DESC')
            ->paginate(5);

        return view('backend.user.customer', compact('list'));
    }

    /**
     * Display the specified resource.
     */
    // public function show(string $id)
    // {
    //     // Hiển thị thông tin chi tiết người dùng
    //     $user = User::findOrFail($id);
    //     return view('backend.user.show', compact('user'));
    // }

    public function edit(string $id)
    {
        // Chỉnh sửa thông tin người dùng
        $user = User::findOrFail($id);
        return view('backend.user.edit', compact('user'));
    }

    public function update(Request $request, string $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:user,email,' . $id,
            'phone' => 'nullable|string|max:20',
            'roles' => 'required|string|in:admin,customer', // Kiểm tra vai trò là admin hoặc customer
            'status' => 'required|boolean',
        ]);

        // Cập nhật thông tin người dùng
        $user = User::findOrFail($id);
        $user->name = $request->name;
        $user->email = $request->email;
        $user->phone = $request->phone;
        $user->roles = $request->roles; // Lưu giá trị roles
        $user->status = $request->status;

        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }
        $user->save();

        return redirect()->route('user.index')->with('success', 'Cập nhật người dùng thành công.');
    }

    public function destroy(string $id)
    {
        // Soft delete người dùng
        $user = User::findOrFail($id);
        $user->delete();
        return redirect()->route('user.index')->with('success', 'Đã chuyển vào thùng rác.');
    }

    // Thùng rác - xem danh sách bị soft delete
    public function trash()
    {
        $list = User::onlyTrashed()->get();
        return view('backend.user.trash', compact('list'));
    }

    // Khôi phục
    public function restore(string $id)
    {
        $user = User::onlyTrashed()->findOrFail($id);
        $user->restore();
        return redirect()->route('user.index')->with('success', 'Khôi phục người dùng thành công.');
    }

    // Xoá vĩnh viễn
    public function delete(string $id)
    {
        $user = User::onlyTrashed()->findOrFail($id);
        $user->forceDelete();
        return redirect()->route('user.trash')->with('success', 'Đã xóa vĩnh viễn người dùng.');
    }


  
public function show($id)
{
    $user = User::with('orders.orderDetails.product')->findOrFail($id);
    return view('backend.user.show', compact('user'));
}

    
     // hoem
     public function registerForm()
     {
         return view('frontend.register');
     }
     
     public function doRegister(Request $request)
     {
         $request->validate([
             'name' => 'required|string|max:255',
             'username' => 'required|string|unique:user,username',
             'email' => 'required|email|unique:user,email',
             'phone' => 'required',
             'address' => 'required',
             'password' => 'required|confirmed',
             'avatar' => 'required|image|mimes:jpg,jpeg,png,gif|max:2048',
         ]);
     
         // Xử lý upload avatar
         $avatarPath = null;
         if ($request->hasFile('avatar')) {
             $avatarPath = $request->file('avatar')->store('avatars', 'public');
         }
     
         // Lưu vào database
         User::create([
             'name' => $request->name,
             'username' => $request->username,
             'email' => $request->email,
             'password' => Hash::make($request->password),
             'phone' => $request->phone,
             'address' => $request->address,
             'avatar' => $avatarPath,
             'created_by' => 0,
             'status' => 1, // hoặc 0
         ]);
         
     
         return redirect()->route('loginngdung')->with('success', 'Đăng ký thành công! Vui lòng đăng nhập.');
     }
     public function showLoginForm()
     {
         return view('frontend.loginuser'); // Đường dẫn đúng với view bạn đang sử dụng
     }
     public function login(Request $request)
     {
         $credentials = $request->only('email', 'password'); // <-- chú ý 'email' đúng field trong database!
     
         if (Auth::attempt($credentials)) {
             $request->session()->regenerate();
             return redirect()->intended('/')->with('success', 'Đăng nhập thành công!');
         }
     
         return back()->with('error', 'Sai tên đăng nhập hoặc mật khẩu.');
     }
     public function dologinuser(Request $request)
     {
         // Validate dữ liệu đầu vào
         $request->validate([
             'email' => 'required|email',
             'password' => 'required|min:6'
         ]);
 
         // Thử đăng nhập với guard mặc định
         $credentials = $request->only('email', 'password');
         if (Auth::attempt($credentials)) {
             return redirect()->route('site.home')->with('success', 'Đăng nhập thành công!');
         }
 
         // Nếu thất bại, quay lại với lỗi
         return back()->withErrors([
             'email' => 'Email hoặc mật khẩu không đúng.',
         ])->withInput();
     }
}

