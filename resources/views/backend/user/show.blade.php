<x-layout-admin>
    <x-slot:title>
        Chi Tiết Người Dùng
    </x-slot:title>
    
    <div class="mb-3 rounded-lg p-2">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-xl font-bold text-[rgb(246,81,119)]">Chi Tiết Người Dùng</h2>
            </div>
            <div class="text-right">
                <a href="{{ route('user.index') }}" class="text-[rgb(246,81,119)] px-2 py-2 rounded-xl mx-1 font-semibold hover:text-[rgb(244,8,8)]">
                    <i class="fa fa-arrow-left" aria-hidden="true"></i> 
                </a>
            </div>
        </div>
    </div>

    <div class="content-wrapper p-4 border border-[rgb(246,81,119)] rounded-lg">

        <div class="grid grid-cols-2 gap-4 mb-4">
            <div><strong>Tên người dùng:</strong> {{ $user->name }}</div>
            <div><strong>Email:</strong> {{ $user->email }}</div>
            <div><strong>Vai trò:</strong> {{ ucfirst($user->roles) }}</div>
            <div><strong>Trạng thái:</strong> 
                <span class="{{ $user->status ? 'text-green-600' : 'text-red-600' }}">
                    {{ $user->status ? 'Hoạt động' : 'Ngừng hoạt động' }}
                </span>
            </div>
            <div><strong>Ngày tạo:</strong> {{ $user->created_at->format('d/m/Y H:i') }}</div>
        </div>

        <div class="mb-4">
            <strong>Avatar:</strong><br>
            <img src="{{ asset($user->avatar) }}" class="w-32 h-32 object-cover rounded-full mt-2">
        </div>

        {{-- Hiển thị danh sách đơn hàng của người dùng --}}
        <div class="mt-6">
            <h3 class="text-xl font-bold text-[rgb(246,81,119)] mb-4">Danh sách Đơn hàng</h3>
            
            @if ($user->orders->count() > 0)
                <div class="space-y-4">
                    @foreach ($user->orders as $order)
                        <div class="border p-4 rounded-lg shadow-sm mb-4">
                            <div class="flex justify-between">
                                <div>
                                    <p><strong>Mã đơn hàng:</strong> #{{ $order->id }}</p>
                                    <p><strong>Ngày đặt:</strong> {{ $order->created_at->format('d/m/Y') }}</p>
                                    <p><strong>Trạng thái:</strong> 
                                        <span class="{{ $order->status === 'completed' ? 'text-green-600' : 'text-yellow-600' }}">
                                            {{ ucfirst($order->status) }}
                                        </span>
                                    </p>
                                </div>
                                <div class="text-right">
                                    <p><strong>Tổng tiền:</strong> {{ number_format($order->orderDetails->sum('amount')) }}₫</p>
                                </div>
                            </div>

                            {{-- Bảng chi tiết sản phẩm trong đơn --}}
                            <table class="w-full table-auto border-collapse text-sm mt-4">
                                <thead class="bg-pink-100">
                                    <tr>
                                        <th class="border p-2">Tên sản phẩm</th>
                                        <th class="border p-2">Hình ảnh</th>
                                        <th class="border p-2 text-center">Số lượng</th>
                                        <th class="border p-2 text-right">Giá</th>
                                        <th class="border p-2 text-right">Tổng</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($order->orderDetails as $detail)
                                        <tr class="hover:bg-gray-50">
                                            <td class="border p-2">{{ $detail->product->name }}</td>
                                            <td class="border p-2">
                                                <img src="{{ asset('assets/images/product/' . $detail->product->thumbnail) }}"
                                                     class="w-20 h-20 object-cover border rounded" alt="{{ $detail->product->name }}">
                                            </td>
                                            <td class="border p-2 text-center">{{ $detail->qty }}</td>
                                            <td class="border p-2 text-right">{{ number_format($detail->price_buy) }}₫</td>
                                            <td class="border p-2 text-right">{{ number_format($detail->amount) }}₫</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endforeach
                </div>
            @else
                <p class="text-gray-600">Không có đơn hàng nào.</p>
            @endif
        </div>

    </div>
</x-layout-admin>
