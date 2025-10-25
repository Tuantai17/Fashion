<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;
use App\Models\Product;

class OrderController extends Controller
{
    /**
     * Danh sách đơn hàng (có sắp xếp)
     */
    public function index(Request $request)
    {
        $sortBy = $request->get('sortBy', 'created_at');
        $sortType = $request->get('sortType', 'desc');

        // Chỉ cho phép sắp xếp theo một số cột hợp lệ
        $validSorts = ['id', 'user_id', 'name', 'status', 'created_at'];
        if (!in_array($sortBy, $validSorts)) {
            $sortBy = 'created_at';
        }

        $list = Order::select('id', 'user_id', 'name', 'phone', 'email', 'address', 'note', 'status', 'created_at')
            ->orderBy($sortBy, $sortType)
            ->paginate(5);

        return view('backend.order.index', compact('list', 'sortBy', 'sortType'));
    }

    /**
     * Hiển thị form tạo đơn hàng mới (nếu cần)
     */
    public function create()
    {
        return view('backend.order.create');
    }

    /**
     * Lưu đơn hàng mới
     */
    public function store(Request $request)
    {
        // Kiểm tra và validate dữ liệu nhập từ request
        $request->validate([
            'name'    => 'required|string|max:255',
            'phone'   => 'required|string|max:20',
            'email'   => 'required|email|max:255',
            'address' => 'required|string|max:255',
            'note'    => 'nullable|string|max:255',
            'cart_items' => 'required|array|min:1', // Bạn cần truyền danh sách sản phẩm từ giỏ hàng
        ]);
    
        // Tạo đơn hàng mới
        $order = Order::create([
            'user_id' => Auth::id(),
            'name'    => $request->name,
            'phone'   => $request->phone,
            'email'   => $request->email,
            'address' => $request->address,
            'note'    => $request->note,
            'status'  => 1,
        ]);
    
        // Khởi tạo tổng tiền
        $total = 0;
    
        // Thêm chi tiết sản phẩm vào đơn hàng và tính tổng tiền
        foreach ($request->cart_items as $cartItem) {
            // Lấy sản phẩm từ giỏ hàng hoặc database
            $product = Product::find($cartItem['product_id']);
            
            if ($product) {
                // Tạo chi tiết đơn hàng
                $order->orderDetails()->create([
                    'product_id' => $cartItem['product_id'],
                    'qty'        => $cartItem['qty'],
                    'price_buy'  => $product->price, // Hoặc lấy giá khác nếu cần
                    'amount'     => $cartItem['qty'] * $product->price, // Tính tổng tiền cho sản phẩm
                ]);
    
                // Cộng dồn tổng tiền
$total += $cartItem['qty'] * $product->price;
            }
        }
    
        // Cập nhật tổng tiền vào đơn hàng
        $order->total = $total;
        $order->save();
    
        return redirect()->route('order.index')->with('success', 'Đơn hàng đã được tạo.');
    }
    
    /**
     * Hiển thị chi tiết đơn hàng
     */
    public function show($id)
    {
        $order = Order::with('orderDetails.product')->findOrFail($id);
        return view('backend.order.show', compact('order'));
    }

    /**
     * Chuyển đơn hàng vào thùng rác (soft delete)
     */
    public function delete($id)
    {
        $order = Order::findOrFail($id);
        $order->delete();
        return redirect()->route('order.index')->with('success', 'Đã chuyển đơn hàng vào thùng rác.');
    }

    /**
     * Danh sách đơn hàng trong thùng rác
     */
    public function trash()
    {
        $list = Order::onlyTrashed()->paginate(10);
        return view('backend.order.trash', compact('list'));
    }

    /**
     * Khôi phục đơn hàng từ thùng rác
     */
    public function restore($id)
    {
        Order::onlyTrashed()->findOrFail($id)->restore();
        return redirect()->route('order.trash')->with('success', 'Khôi phục đơn hàng thành công.');
    }

    /**
     * Xóa đơn hàng vĩnh viễn
     */
    public function forceDelete($id)
    {
        Order::onlyTrashed()->findOrFail($id)->forceDelete();
        return redirect()->route('order.trash')->with('success', 'Đã xóa đơn hàng vĩnh viễn.');
    }

    /**
     * Cập nhật trạng thái đơn hàng bằng request ajax
     */
    public function updateStatus(Request $request)
    {
        $order = Order::findOrFail($request->id);
        $order->status = $request->status;
        $order->save();

        return response()->json(['success' => true]);
    }

    /**
     * Đảo trạng thái nhanh (bật/tắt) từ danh sách
     */
    public function status($id)
    {
        $order = Order::findOrFail($id);
        $order->status = $order->status == 1 ? 0 : 1;
        $order->save();
        return redirect()->route('order.index')->with('success', 'Cập nhật trạng thái đơn hàng thành công.');
    }
    public function toggleStatus($id)
    {
        $order = Order::withTrashed()->findOrFail($id);
        $order->status = !$order->status;
        $order->save();
    
        return redirect()->back()->with('success', 'Trạng thái đơn hàng đã được cập nhật.');
    }
    

}
