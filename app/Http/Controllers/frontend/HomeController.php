<?php

namespace App\Http\Controllers\frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\Category;
use App\Models\Menu;
use App\Models\Contact;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;

use App\Models\Topic;

class HomeController extends Controller
{
    // Hàm khởi tạo dùng chung menu cho tất cả action
    private $menu_list = [];

    public function __construct()
    {
        $this->menu_list = [
            ['title' => 'Home', 'url' => url('/')],
            ['title' => 'About', 'url' => url('/about')],
            ['title' => 'Product', 'url' => url('/san-pham')],
            ['title' => 'Contact', 'url' => url('/lien-he')],
            ['title' => 'Register', 'url' => url('/register')],
            ['title' => 'Post', 'url' => url('/post')],

        ];
        $menuParents = Menu::where('parent_id', 0)->orderBy('sort_order')->get();
return view('frontend.home', compact('menuParents'));

    }

    // Trang Chủ
public function index()
{
    $categories = Category::where('parent_id', 0)->where('status', 1)->get(); // Lọc danh mục cha với parent_id = 0
    $posts = Post::latest()->take(1)->get();
    $topics = Topic::latest()->take(1)->get();

    return view('frontend.home', compact('categories', 'posts', 'topics'));
}


    // Trang đăng nhập
    public function login()
    {
        return view('frontend.loginuser', [
            'menu_list' => $this->menu_list
        ]);
    }

    // Trang đăng ký
    public function register()
    {
        return view('frontend.register', [
            'menu_list' => $this->menu_list
        ]);
    }

    // Trang giới thiệu
    public function about()
    {
        return view('frontend.about', [
            'menu_list' => $this->menu_list
        ]);
    }

    // Trang mới
    public function newpage()
    {
        return view('frontend.newpage', [
            'menu_list' => $this->menu_list
        ]);
    }


    //lấy tất cả bài vết
    public function allPosts()
    {
        $posts = Post::latest()->paginate(6); // lấy mới nhất và phân trang
        return view('frontend.post-all', compact('posts'));
    }
    

// chi tiết bài viết
public function detail($slug)
{
    $post = Post::where('slug', $slug)->firstOrFail();

    // Bài viết khác cùng chủ đề
    $relatedPosts = Post::where('topic_id', $post->topic_id)
                        ->where('id', '!=', $post->id)
                        ->take(3)
                        ->get();

    return view('frontend.post-detail', compact('post', 'relatedPosts'));
}

public function submitContact(Request $request)
{
    $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email',
        'phone' => 'required|string|max:255',
        'title' => 'required|string|max:1000',
        'content' => 'required|string',
    ]);

    Contact::create([
        'name' => $request->name,
        'email' => $request->email,
        'phone' => $request->phone,
        'title' => $request->title,
        'content' => $request->content,
        'reply_id' => 0,
        'created_by' => 0, // 👈 bắt buộc có, thay bằng auth()->id() nếu dùng đăng nhập
        'status' => 0,
    ]);

    return redirect()->back()->with('success', 'Cảm ơn bạn đã liên hệ với chúng tôi!');
}


public function showContactForm()
{
    return view('frontend.contact'); // thay tên view nếu bạn dùng tên khác
}


public function contact()
{
    return view('frontend.contact'); // thay bằng đúng tên view của bạn
}
// tìm kiếm
public function searchProduct(Request $request)
{
    $keyword = $request->input('keyword');

    $products = Product::where('name', 'like', "%$keyword%")
        ->orWhere('description', 'like', "%$keyword%")
        ->get();

    return view('frontend.search', compact('products', 'keyword'));
}


 // Trang Chủ
    // Tài khoản
    public function accountInfo()
    {
        $user = Auth::user();
        return view('frontend.account', compact('user'));
    }
    

    // Cập nhật tài khoản
    public function updateAccount(Request $request)
    {
        $user = Auth::user();

        // Kiểm tra và xử lý upload avatar
        if ($request->hasFile('avatar')) {
            // Xóa avatar cũ nếu có
            if ($user->avatar && file_exists(storage_path('app/public/' . $user->avatar))) {
                unlink(storage_path('app/public/' . $user->avatar));
            }

            // Lưu avatar mới
            $path = $request->file('avatar')->store('avatars', 'public');
            $user->avatar = $path;
        }

        // Cập nhật thông tin người dùng
        $user->name = $request->input('name');
        $user->phone = $request->input('phone');
        
        // Nếu có thay đổi mật khẩu
        if ($request->filled('password')) {
            $user->password = bcrypt($request->input('password'));
        }

        $user->save();

        return redirect()->route('user.account')->with('success', 'Cập nhật tài khoản thành công!');
    }
 
 // giỏ hang
public function cart()
{
    $cart = session()->get('cart', []);
    return view('frontend.cart', compact('cart'));
}

public function addToCart(Request $request)
{
    $id = $request->input('id');
    $product = Product::findOrFail($id);

    $cart = session()->get('cart', []);

    $cart[$id] = [
        'id' => $product->id, // ĐẢM BẢO có dòng này
        'name' => $product->name,
        'thumbnail' => $product->thumbnail ?? 'no-image.jpg',
        'price' => $product->price_sale > 0 ? $product->price_sale : $product->price_root,
        'quantity' => isset($cart[$id]) ? $cart[$id]['quantity'] + 1 : 1,
    ];

    session()->put('cart', $cart);

    return redirect()->back()->with('success', 'Đã thêm sản phẩm vào giỏ hàng');
}


public function removeFromCart(Request $request)
{
    $id = $request->input('id');
    $cart = session()->get('cart', []);

    if (isset($cart[$id])) {
        unset($cart[$id]);
        session()->put('cart', $cart);
    }

    return redirect()->back()->with('success', 'Đã xóa sản phẩm khỏi giỏ hàng');
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
