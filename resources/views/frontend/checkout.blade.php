<x-layout-site title="Xác nhận thanh toán">
    <div class="container mx-auto p-6">
        <h1 class="text-2xl font-bold mb-4">🧾 Xác nhận đơn hàng</h1>

        <table class="w-full table-auto mb-6">
            <thead class="bg-gray-200">
                <tr>
                    <th class="p-2">Sản phẩm</th>
                    <th class="p-2">Số lượng</th>
                    <th class="p-2">Giá</th>
                    <th class="p-2">Thành tiền</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($cart as $item)
                <tr>
                    <td class="p-2">{{ $item['name'] }}</td>
                    <td class="p-2">{{ $item['quantity'] }}</td>
                    <td class="p-2">{{ number_format($item['price']) }}đ</td>
                    <td class="p-2">{{ number_format($item['price'] * $item['quantity']) }}đ</td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <form action="{{ route('site.cart.checkout.submit') }}" method="POST" class="space-y-4">
            @csrf

            <!-- Hiển thị thông tin người dùng -->
            <div>
                <label for="name" class="block text-sm font-medium">👤 Họ tên</label>
                <input type="text" id="name" name="name" value="{{ Auth::user()->name }}" required class="w-full p-2 border rounded" placeholder="Nhập họ tên">
            </div>

            <div>
                <label for="phone" class="block text-sm font-medium">📞 Số điện thoại</label>
                <input type="text" id="phone" name="phone" value="{{ Auth::user()->phone }}" required class="w-full p-2 border rounded" placeholder="Nhập số điện thoại">
            </div>

            <div>
                <label for="address" class="block text-sm font-medium">🏠 Địa chỉ</label>
                <textarea id="address" name="address" required class="w-full p-2 border rounded" placeholder="Nhập địa chỉ giao hàng">{{ Auth::user()->address }}</textarea>
            </div>

            <div class="text-right">
                <button type="submit" class="bg-green-600 text-white px-6 py-2 rounded hover:bg-green-700">
                    ✅ Xác nhận và thanh toán
                </button>
            </div>
        </form>

        <div class="mb-4 text-right font-semibold text-lg text-green-700">
            Tổng cộng: {{ number_format($total) }}đ
        </div>

    </div>
</x-layout-site>
