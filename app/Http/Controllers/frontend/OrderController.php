<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Order;
use App\Models\OrderDetail;

class CartController extends Controller
{
    public function index()
    {
        $cart = session()->get('cart', []);
        return view('cart.index', compact('cart'));
    }

    // Thêm sản phẩm vào giỏ
    public function add(Request $request, $id)
    {
        $product = Product::findOrFail($id);
        $cart = session()->get('cart', []);
        $qty = $request->input('quantity', 1);

        if (isset($cart[$product->id])) {
            $cart[$product->id]['quantity'] += $qty;
        } else {
            $cart[$product->id] = [
                'name' => $product->name,
                'price_root' => $product->price_root,
                'price_sale' => $product->price_sale,
                'price' => $product->price_sale ?: $product->price_root,
                'quantity' => $qty,
                'image' => $product->image,
                'product_id' => $product->id
            ];
        }

        session()->put('cart', $cart);
        return redirect()->back()->with('success', 'Đã thêm sản phẩm vào giỏ hàng.');
    }

    // Cập nhật số lượng sản phẩm
    public function update(Request $request)
    {
        $id = $request->input('id');
        $quantity = $request->input('quantity');

        $cart = session()->get('cart', []);
        if (isset($cart[$id]) && $quantity > 0) {
            $cart[$id]['quantity'] = $quantity;
            session()->put('cart', $cart);
        }

        return redirect()->route('cart.index')->with('success', 'Cập nhật giỏ hàng thành công.');
    }

    // Xóa sản phẩm khỏi giỏ hàng
    public function remove($id)
    {
        $cart = session()->get('cart', []);
        if (isset($cart[$id])) {
            unset($cart[$id]);
            session()->put('cart', $cart);
        }

        return redirect()->route('cart.index')->with('success', 'Đã xóa sản phẩm khỏi giỏ hàng.');
    }

    // Hiển thị form thanh toán
    public function checkout()
    {
        $cart = session()->get('cart', []);
        if (empty($cart)) {
            return redirect()->route('cart.index')->with('error', 'Giỏ hàng trống.');
        }

        return view('cart.checkout', compact('cart'));
    }

    // Xử lý thanh toán
    public function processCheckout(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'phone' => 'required|string',
            'email' => 'required|email',
            'address' => 'required|string',
        ]);
    
        $cart = session()->get('cart', []);
        if (empty($cart)) {
            return redirect()->route('cart.index')->with('error', 'Giỏ hàng trống.');
        }
    
        $total = 0;
        foreach ($cart as $item) {
$total += $item['price'] * $item['quantity'];
        }
    
        // Lưu thông tin đơn hàng
        $order = Order::create([
            'user_id' => Auth::id() ?? 1, // Nếu không đăng nhập thì gán mặc định là 1
            'name' => $request->input('name'),
            'phone' => $request->input('phone'),
            'email' => $request->input('email'),
            'address' => $request->input('address'),
            'note' => $request->input('note'),
            'total' => $total,
            'status' => 1,
        ]);
    
        // Lưu chi tiết đơn hàng
        foreach ($cart as $productId => $item) {
            OrderDetail::create([
                'order_id' => $order->id,
                'product_id' => $productId,
                'price_buy' => $item['price'],
                'qty' => $item['quantity'],
                'amount' => $item['price'] * $item['quantity'],
            ]);
        }
    
        session()->forget('cart');
    
        // Chuyển hướng với thông báo thành công
        return redirect()->route('site.home')->with('success', 'Đặt hàng thành công!');
    }
    
    
}
