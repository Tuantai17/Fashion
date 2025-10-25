{{-- resources/views/backend/order/show.blade.php --}}
<x-layout-admin>
    <x-slot:title>Chi Tiết Đơn Hàng</x-slot:title>

    <div class="mb-3 rounded-lg p-2">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-xl font-bold text-[rgb(246,81,119)]">Chi Tiết Đơn Hàng</h2>
            </div>
            <div class="text-right">
                <a href="{{ route('order.index') }}" class="text-[rgb(246,81,119)] px-2 py-2 rounded-xl mx-1 font-semibold hover:text-[rgb(244,8,8)]">
                    <i class="fa fa-arrow-left" aria-hidden="true"></i>
                </a>
            </div>
        </div>
    </div>

    <div class="content-wrapper p-4 border border-[rgb(246,81,119)] rounded-lg">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
            <div>
                <h3 class="text-lg font-bold text-[rgb(246,81,119)] mb-2">Thông tin khách hàng</h3>
                <p><strong>ID đơn hàng:</strong> {{ $order->id }}</p>
                <p><strong>Họ tên:</strong> {{ $order->name }}</p>
                <p><strong>Số điện thoại:</strong> {{ $order->phone }}</p>
                <p><strong>Email:</strong> {{ $order->email }}</p>
                <p><strong>Địa chỉ:</strong> {{ $order->address }}</p>
                <p><strong>Ghi chú:</strong> {{ $order->note }}</p>
                <p><strong>Trạng thái:</strong> 
                    <span class="{{ $order->status == 1 ? 'text-green-600' : 'text-red-600' }}">
                        {{ $order->status == 1 ? 'Đã xử lý' : 'Chưa xử lý' }}
                    </span>
                </p>
                <p><strong>Ngày tạo:</strong> {{ $order->created_at->format('d/m/Y H:i') }}</p>
                <p><strong>Tổng tiền:</strong> {{ number_format($order->total, 0, ',', '.') }} đ</p>
            </div>

            <div>
                <h3 class="text-lg font-bold text-[rgb(246,81,119)] mb-2">Danh sách sản phẩm</h3>
                @if ($order->orderDetails && count($order->orderDetails))
                    <table class="w-full border border-gray-300 text-sm">
                        <thead class="bg-gray-200">
                            <tr>
                                <th class="border p-2">Tên sản phẩm</th>
                                <th class="border p-2">Số lượng</th>
                                <th class="border p-2">Giá mua</th>
                                <th class="border p-2">Thành tiền</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($order->orderDetails as $detail)
                                <tr>
                                    <td class="border p-2 text-center">{{ $detail->product->name ?? '[Không tìm thấy]' }}</td>
                                    <td class="border p-2 text-center">{{ $detail->qty }}</td>
                                    <td class="border p-2 text-center">{{ number_format($detail->price_buy, 0, ',', '.') }} đ</td>
                                    <td class="border p-2 text-center">{{ number_format($detail->amount, 0, ',', '.') }} đ</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @else
                    <p>Không có sản phẩm nào trong đơn hàng.</p>
                @endif
            </div>
        </div>
    </div>
</x-layout-admin>
