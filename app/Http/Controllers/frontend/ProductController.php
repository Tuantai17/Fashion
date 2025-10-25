<?php

// namespace App\Http\Controllers\frontend;

// use App\Http\Controllers\Controller;
// use Illuminate\Http\Request;

// class ProductController extends Controller
// {
//     function index()
//     {
//         return view('frontend.product');
//     }

//     function detial($slug)
//     {
//         return view('frontend.product-detail');
//     }
// }


namespace App\Http\Controllers\frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use App\Models\Brand;
use App\Models\Order;
use App\Models\OrderDetail;
use Illuminate\Support\Facades\Auth;



class ProductController extends Controller
{
    public function index(Request $request)
    {
        // Bắt đầu query
        $query = Product::query();
        
        // Lọc theo danh mục
        if ($request->has('category') && $request->category) {
            $query->where('category_id', $request->category);
        }
        
        // Lọc theo thương hiệu
        if ($request->has('brand') && $request->brand) {
            $query->where('brand_id', $request->brand);
        }
        
        // Lọc theo mức giá (giá sale và giá gốc)
        if ($request->has('min_price') && $request->min_price) {
            $min_price = $request->min_price;
            $query->where(function ($q) use ($min_price) {
                $q->where('price_sale', '>=', $min_price)
                    ->orWhere('price_root', '>=', $min_price); // Kiểm tra giá sale hoặc giá gốc
            });
        }
        
        if ($request->has('max_price') && $request->max_price) {
            $max_price = $request->max_price;
            $query->where(function ($q) use ($max_price) {
                $q->where('price_sale', '<=', $max_price)
                    ->orWhere('price_root', '<=', $max_price); // Kiểm tra giá sale hoặc giá gốc
            });
        }

        // Lấy tất cả sản phẩm theo các điều kiện đã lọc và phân trang 12 sản phẩm mỗi trang
        $products = $query->paginate(6)->withQueryString(); // Thêm phân trang
        
        // Lấy danh mục và thương hiệu để hiển thị trên form lọc
        $categories = Category::all();
        $brands = Brand::all();
        
        // Trả về view với các dữ liệu
        return view('frontend.product', compact('products', 'categories', 'brands'));
    }
    

    public function detail($slug)
    {
        // Lấy sản phẩm đang xem
        $product_item = Product::where([
            ['status', '=', 1],
            ['slug', '=', $slug]
        ])->firstOrFail();
    
        $priceRange = 20000;
    
        // Lấy giá để so sánh
        $compare_price = ($product_item->price_sale > 0 && $product_item->price_sale < $product_item->price_root)
            ? $product_item->price_sale
            : $product_item->price_root;
    
        // Lấy sản phẩm liên quan cùng danh mục và trong khoảng giá tương tự
        $product_list = Product::where('status', 1)
            ->where('id', '!=', $product_item->id)
            ->where('category_id', $product_item->category_id)
            ->where(function ($query) use ($compare_price, $priceRange) {
                $query->whereBetween('price_sale', [$compare_price - $priceRange, $compare_price + $priceRange])
                    ->orWhere(function ($subQuery) use ($compare_price, $priceRange) {
                        $subQuery->where('price_sale', 0)
                            ->whereBetween('price_root', [$compare_price - $priceRange, $compare_price + $priceRange]);
                    });
            })
            ->orderBy('created_at', 'desc')
            ->limit(4)
            ->get();
    
        // Nếu chưa đủ 4 sản phẩm, lấy thêm sp cùng danh mục (bỏ điều kiện giá)
        if ($product_list->count() < 4) {
            $additional = Product::where('status', 1)
                ->where('id', '!=', $product_item->id)
                ->where('category_id', $product_item->category_id)
                ->whereNotIn('id', $product_list->pluck('id')) // tránh trùng
                ->orderBy('created_at', 'desc')
                ->limit(4 - $product_list->count())
                ->get();
    
            $product_list = $product_list->merge($additional);
        }
    
        return view('frontend.product-detail', compact('product_item', 'product_list'));
    }
    


// Sản phẩm theo danh mục
public function byCategory(Request $request, $category_slug)
{
    // Tìm danh mục
    $category = Category::where('slug', $category_slug)->firstOrFail();

    // Danh sách danh mục & thương hiệu
    $category_list = Category::all();
    $brand_list = Brand::all();

    // Lọc giá
    $min_price = $request->input('min_price', 0);
    $max_price = $request->input('max_price', 10000000);

    // Lọc thương hiệu nếu có
    $brand_id = $request->input('brand');

    // Lấy sản phẩm theo danh mục và lọc
    $products = Product::where('category_id', $category->id)
        ->when($brand_id, function ($query) use ($brand_id) {
            $query->where('brand_id', $brand_id);
        })
        ->where(function ($query) use ($min_price, $max_price) {
            $query->where(function ($q) use ($min_price, $max_price) {
                $q->where('price_sale', '>', 0)
                    ->whereBetween('price_sale', [$min_price, $max_price]);
            })
            ->orWhere(function ($q) use ($min_price, $max_price) {
                $q->where(function ($sub) {
                    $sub->where('price_sale', 0)
                        ->orWhereNull('price_sale');
                })
                ->whereBetween('price_root', [$min_price, $max_price]);
            });
        })
        ->paginate(8);

    return view('frontend.by-category', compact(
        'products',
        'category',
        'category_list',
        'brand_list'
    ));
}


// Sản phẩm theo thương hiệu
public function byBrand(Request $request, $brand_slug)
{
    // Tìm thương hiệu
    $brand = Brand::where('slug', $brand_slug)->firstOrFail();

    // Danh sách thương hiệu & danh mục
    $brand_list = Brand::all();
    $category_list = Category::all();

    // Lọc giá
    $min_price = $request->input('min_price', 0);
    $max_price = $request->input('max_price', 10000000);

    // Lọc danh mục nếu có
    $category_id = $request->input('category');

    // Lấy sản phẩm theo thương hiệu và lọc
    $products = Product::where('brand_id', $brand->id)
        ->when($category_id, function ($query) use ($category_id) {
            $query->where('category_id', $category_id);
        })
        ->where(function ($query) use ($min_price, $max_price) {
            $query->where(function ($q) use ($min_price, $max_price) {
                $q->where('price_sale', '>', 0)
                    ->whereBetween('price_sale', [$min_price, $max_price]);
            })
            ->orWhere(function ($q) use ($min_price, $max_price) {
                $q->where(function ($sub) {
                    $sub->where('price_sale', 0)
                        ->orWhereNull('price_sale');
                })
                ->whereBetween('price_root', [$min_price, $max_price]);
            });
        })
        ->paginate(8);

    // Trả về view với các biến cần thiết
    return view('frontend.by-brand', compact(
        'products',
        'brand',         // Đảm bảo truyền biến $brand vào view
        'brand_list',
        'category_list'
    ));
}




    // Giỏ hàng
    public function cart()
    {
        $cart = session()->get('cart', []);
        return view('frontend.cart', compact('cart'));
    }

    // Thêm sản phẩm vào giỏ hàng
    public function addToCart(Request $request)
{
    $id = $request->input('product_id'); // Tên input từ form phải đúng là product_id

    // Kiểm tra xem sản phẩm có tồn tại không
    $product = Product::find($id);

    if (!$product) {
        return redirect()->back()->with('error', 'Sản phẩm không tồn tại');
    }

    $cart = session()->get('cart', []);

    // Thêm sản phẩm vào giỏ hàng hoặc tăng số lượng nếu đã có
    $cart[$id] = [
        'id' => $product->id, // Phải có dòng này!
        'name' => $product->name,
        'thumbnail' => $product->thumbnail ?? 'no-image.jpg',
        'price' => $product->price_sale > 0 ? $product->price_sale : $product->price_root,
        'quantity' => isset($cart[$id]) ? $cart[$id]['quantity'] + 1 : 1,
    ];

    session()->put('cart', $cart);

    return redirect()->back()->with('success', 'Đã thêm sản phẩm vào giỏ hàng');
}


    // Cập nhật số lượng sản phẩm trong giỏ hàng
    public function updateCart(Request $request)
    {
        $id = $request->input('id'); // lấy product_id
        $quantity = $request->input('quantity');

        $cart = session()->get('cart', []);

        if (isset($cart[$id])) {
            $cart[$id]['quantity'] = $quantity;
            session()->put('cart', $cart);
        }

        return redirect()->back()->with('success', 'Cập nhật số lượng thành công!');
    }

    // Xóa sản phẩm khỏi giỏ hàng
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

    // Xóa toàn bộ giỏ hàng
    public function clearCart()
    {
        session()->forget('cart');
        return redirect()->back()->with('success', 'Đã xóa toàn bộ giỏ hàng!');
    }

    // Thanh toán
    public function checkout(Request $request)
    {
        $cart = session('cart', []);

        if (empty($cart)) {
            return redirect()->back()->with('error', 'Giỏ hàng đang trống!');
        }

        // Lưu đơn hàng
        $order = Order::create([
            'name' => $request->name,
            'phone' => $request->phone,
            'email' => $request->email,
            'address' => $request->address,
        ]);

        // Lưu chi tiết từng sản phẩm
        foreach ($cart as $item) {
            OrderDetail::create([
                'order_id' => $order->id,
                'product_id' => $item['id'],
                'quantity' => $item['quantity'],
                'price' => $item['price'],
            ]);
        }

        // Xoá giỏ hàng
        session()->forget('cart');

        return redirect()->route('site.cart')->with('success', 'Đặt hàng thành công!');
    }

    // Hiển thị thông tin thanh toán
    public function checkoutForm()
    {
        $cart = session()->get('cart', []);
        if (empty($cart)) {
            return redirect()->route('site.cart')->with('error', 'Giỏ hàng đang trống!');
        }

        // Tính tổng tiền
        $total = 0;
        foreach ($cart as $item) {
            $total += $item['price'] * $item['quantity'];
        }

        return view('frontend.checkout', compact('cart', 'total'));
    }

    // Xử lý thanh toán
    public function checkoutSubmit(Request $request)
    {
        $cart = session()->get('cart', []);
        if (empty($cart)) {
            return redirect()->route('site.cart')->with('error', 'Giỏ hàng đang trống!');
        }

        $user_id = Auth::check() ? Auth::id() : 1; // Nếu chưa đăng nhập, fallback là user_id = 1

        $total = 0;
        foreach ($cart as $item) {
            $total += $item['price'] * $item['quantity'];
        }

        $order = Order::create([
            'name' => $request->input('name'),
            'phone' => $request->input('phone'),
            'email' => 'example@gmail.com', // Thêm email nếu cần
            'address' => $request->input('address'),
            'note' => '',
            'status' => 1,
            'user_id' => $user_id, // Phải có user_id
        ]);

        foreach ($cart as $item) {
            OrderDetail::create([
                'order_id' => $order->id,
                'product_id' => $item['id'],
                'price_buy' => $item['price'],
                'qty' => $item['quantity'],
                'amount' => $item['price'] * $item['quantity'],
            ]);
        }

        session()->forget('cart');

        return redirect()->route('site.home')->with('success', 'Đặt hàng thành công!');
    }
    
    
}
