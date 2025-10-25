<?php

namespace App\Http\Controllers\frontend;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    // Hiển thị form đăng ký
    public function showRegisterForm()
    {
        return view('frontend.register');
    }

    // Xử lý đăng ký
    public function register(Request $request)
    {
        // Validate dữ liệu đầu vào
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:user,username',
            'email' => 'required|email|unique:user,email',
            'password' => 'required|confirmed|min:6',
            'phone' => 'required|string|max:15',
            'address' => 'required|string|max:255',
            'avatar' => 'required|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->with('error', 'Đăng ký thất bại. Vui lòng kiểm tra lại thông tin.')
                ->withErrors($validator)
                ->withInput();
        }

        try {
            // Lưu ảnh đại diện
            $avatarPath = $request->file('avatar')->store('avatars', 'public');

            // Tạo người dùng mới
            User::create([
                'name' => $request->name,
                'username' => $request->username,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'phone' => $request->phone,
                'address' => $request->address,
                'avatar' => $avatarPath,
                'roles' => 'customer',
            ]);

            return redirect()->route('site.loginuser')->with('success', 'Đăng ký thành công!');

        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Đăng ký thất bại. Vui lòng thử lại sau.');
        }
    }

    // Xử lý đăng nhập
    public function loginuser(Request $request)
    {
        $validated = $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        // Đăng nhập bằng username
        if (Auth::attempt(['username' => $validated['username'], 'password' => $validated['password']])) {
            session()->flash('success', 'Đăng nhập thành công!');
            return redirect()->route('site.home');
        }

        // Thất bại
        return redirect()->back()->with('error', 'Sai tên đăng nhập hoặc mật khẩu.');
    }

  /*showByCategory---------------------------------------------------------*/
  public function showByCategory($category_slug)
  {
      $category = Category::where('slug', $category_slug)->first();

      if (!$category) {
          return redirect()->route('product.index')->with('error', 'Danh mục không tồn tại');
      }

      $products = Product::where('category_id', $category->id)->get();

      return view('frontend.products.category', compact('products', 'category'));
  }

    public function forceDelete(string $id)
    {
        $user = User::findOrFail($id);

        // Optional: Handle deleting related models if necessary, for example, orders, reviews, etc.
        // Example: Delete orders associated with the user (if needed)
        // $user->orders()->delete();

        // Force delete the user
        $user->forceDelete();

        return redirect()->route('user.index')->with('success', 'Đã xóa vĩnh viễn người dùng.');
    }

}
