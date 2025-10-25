<x-layout-site title="Giỏ hàng">
    <div class="container mx-auto p-6">
        <h1 class="text-3xl font-bold text-[rgb(246,81,119)] mb-6">🛒 Giỏ hàng của bạn</h1>

        @if ($cart && count($cart) > 0)
        <table class="w-full table-auto border rounded-xl overflow-hidden shadow">
            <thead class="bg-pink-100 text-left text-[rgb(246,81,119)]">
                <tr>
                    <th class="p-3">Hình ảnh</th>
                    <th class="p-3">Sản phẩm</th>
                    <th class="p-3">Số lượng</th>
                    <th class="p-3">Giá</th>
                    <th class="p-3">Thành tiền</th>
                    <th class="p-3">Hành động</th>
                </tr>
            </thead>
            <tbody>
                @php $total = 0; @endphp
                @foreach ($cart as $key => $item)
                @php
                    $subtotal = $item['price'] * $item['quantity'];
                    $total += $subtotal;
                @endphp
                <tr class="border-b hover:bg-pink-50 transition">
                    <td class="p-3">
                        @if (!empty($item['thumbnail']))
                        <img src="{{ asset('assets/images/product/' . $item['thumbnail']) }}"
                             alt="{{ $item['name'] ?? 'Tên sản phẩm' }}"
                             class="w-16 h-16 object-cover rounded shadow">
                        @else
                        <div class="w-16 h-16 bg-gray-200 flex items-center justify-center rounded">
                            <span class="text-gray-500 text-sm">Không có ảnh</span>
                        </div>
                        @endif
                    </td>

                    <td class="p-3 text-gray-800 font-medium">
                        {{ $item['name'] ?? 'Tên SP' }}
                    </td>

                    <td class="p-3">
                        <form action="{{ route('site.cart.update') }}" method="POST" class="flex items-center gap-2">
                            @csrf
                            <input type="hidden" name="id" value="{{ $key }}">
                            <input type="number" name="quantity" value="{{ $item['quantity'] }}" min="1"
                                   class="w-16 border border-gray-300 rounded px-2 py-1 text-sm focus:outline-none focus:ring-1 focus:ring-[rgb(246,81,119)]">
                            <button type="submit" class="text-[rgb(246,81,119)] hover:underline text-sm">Cập nhật</button>
                        </form>
                    </td>

                    <td class="p-3 text-[rgb(246,81,119)] font-semibold">{{ number_format($item['price']) }}đ</td>
                    <td class="p-3 text-[rgb(246,81,119)] font-semibold">{{ number_format($subtotal) }}đ</td>

                    <td class="p-3">
                        <form action="{{ route('site.cart.remove') }}" method="POST" onsubmit="return confirm('Xóa sản phẩm này?')">
                            @csrf
                            <input type="hidden" name="id" value="{{ $key }}">
                            <button type="submit" class="text-red-500 hover:underline text-sm">❌ Xóa</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

        {{-- Nút xóa toàn bộ + Tổng cộng + Thanh toán --}}
        <div class="mt-6 flex justify-between items-center flex-wrap gap-4">
            {{-- Nút xóa toàn bộ --}}
            <form action="{{ route('site.cart.clear') }}" method="POST" onsubmit="return confirm('Bạn có chắc muốn xóa toàn bộ giỏ hàng không?')">
                @csrf
                <button type="submit"
                        class="bg-red-600 text-white px-4 py-2 rounded hover:bg-red-700 transition text-sm">
                    🧹 Xóa toàn bộ giỏ hàng
                </button>
            </form>

            {{-- Tổng tiền + thanh toán --}}
            <div class="text-right">
                <div class="text-xl font-semibold text-[rgb(246,81,119)] mb-2">
                    Tổng cộng: {{ number_format($total) }}đ
                </div>
                <div class="mt-3">
                    <a href="{{ route('site.cart.checkout') }}"
                       class="inline-block bg-[rgb(246,81,119)] hover:bg-pink-600 text-white px-6 py-2 rounded transition text-sm">
                        🧾 Tiến hành thanh toán
                    </a>
                </div>
            </div>
        </div>

        @else
        <p class="text-gray-600">Giỏ hàng của bạn đang trống.</p>
        <a href="{{ route('site.product') }}" class="inline-block mt-4 text-[rgb(246,81,119)] hover:underline">
            ← Tiếp tục mua sắm
        </a>
        @endif
    </div>
</x-layout-site>
