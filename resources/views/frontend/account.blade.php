<x-layout-site>
    <x-slot:title>Thông tin tài khoản</x-slot:title>

    <main
        class="py-40 mt-40 relative max-w-4xl mx-auto p-10 rounded-3xl shadow-2xl border border-green-200 bg-white/80 backdrop-blur-lg">
        <div class="relative z-10">
            <h2 class="text-4xl font-bold text-center text-emerald-600 mb-8 tracking-wide">🪪 Thông tin tài khoản</h2>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 text-gray-800 text-base">
                <p><span class="font-semibold text-green-700">👤 Họ tên:</span> {{ $user->name }}</p>
                <p><span class="font-semibold text-green-700">🧾 Tên đăng nhập:</span> {{ $user->username }}</p>
                <p><span class="font-semibold text-green-700">📧 Email:</span> {{ $user->email }}</p>
                <p><span class="font-semibold text-green-700">📱 Số điện thoại:</span> {{ $user->phone }}</p>
                <p><span class="font-semibold text-green-700">🏠 Địa chỉ:</span> {{ $user->address }}</p>
                <p><span class="font-semibold text-green-700">🔑 Quyền:</span> <span
                        class="text-gray-600 italic">Customer</span></p>
            </div>

            @if ($user->avatar)
                <div class="mt-10 text-center">
                    <p class="font-semibold text-green-800 mb-3 text-lg">🖼️ Ảnh đại diện</p>
                    <div class="inline-block border-4 border-green-400 p-1 rounded-full shadow-lg bg-white">
                        <img src="{{ asset('assets/images/avatar.jpg') }}" class="w-36 h-36 object-cover rounded-full">
                    </div>
                </div>
            @endif

            {{-- Đăng xuất --}}
            <div class="text-center mt-10">
                <a href="{{ route('logout') }}"
                    onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                    class="inline-flex items-center gap-2 text-red-600 hover:text-red-700 font-semibold transition duration-200 hover:underline">
                    🚪 Đăng xuất
                </a>
            </div>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">
                @csrf
            </form>

            {{-- ✅ Nút chuyển tới trang Đăng ký Admin --}}
            <a href="{{ route('admin.login') }}"
                class="inline-flex items-center gap-2 px-6 py-2 border-2 border-pink-500 text-pink-600 rounded-lg font-semibold hover:bg-pink-500 hover:text-white transition duration-200">
                ➕ Đăng ký Admin
            </a>


            {{-- Đơn hàng đã đặt --}}
            @if ($user->orders && $user->orders->count() > 0)
                <div class="mt-16">
                    <h3 class="text-2xl font-bold text-emerald-700 mb-6 text-center">📦 Đơn hàng đã đặt</h3>

                    @foreach ($user->orders as $order)
                        @php $total = $order->orderDetails->sum('amount'); @endphp
                        <div class="mb-10 border border-gray-300 rounded-xl p-6 shadow-md bg-white/90">
                            <div class="flex justify-between items-center mb-4">
                                <div>
                                    <p class="font-semibold text-lg text-emerald-700">🧾 Mã đơn: #{{ $order->id }}
                                    </p>
                                    <p class="text-sm text-gray-500">Ngày đặt:
                                        {{ $order->created_at->format('d/m/Y') }}</p>
                                </div>
                                <div>
                                    <span class="px-3 py-1 rounded-full bg-emerald-100 text-emerald-700 text-sm">
                                        {{ ucfirst($order->status) }}
                                    </span>
                                </div>
                            </div>

                            <div class="overflow-x-auto">
                                <table
                                    class="min-w-full bg-white shadow-md rounded-lg overflow-hidden border border-gray-200">
                                    <thead class="bg-green-100 text-green-800">
                                        <tr>
                                            <th class="py-3 px-4 text-left">Sản phẩm</th>
                                            <th class="py-3 px-4 text-left">Hình ảnh</th>
                                            <th class="py-3 px-4 text-left">Số lượng</th>
                                            <th class="py-3 px-4 text-left">Giá</th>
                                            <th class="py-3 px-4 text-left">Tổng tiền</th>
                                        </tr>
                                    </thead>
                                    <tbody class="text-gray-700">
                                        @foreach ($order->orderDetails as $detail)
                                            <tr class="border-t">
                                                <td class="py-3 px-4">{{ $detail->product->name ?? 'Sản phẩm đã xóa' }}
                                                </td>
                                                <td class="py-3 px-4">
                                                    @if ($detail->product && $detail->product->thumbnail)
                                                        <img src="{{ asset('assets/images/product/' . $detail->product->thumbnail) }}"
                                                            class="w-20 h-20 object-cover rounded">
                                                    @else
                                                        <span class="text-gray-400 italic">Không có ảnh</span>
                                                    @endif
                                                </td>
                                                <td class="py-3 px-4">{{ $detail->qty }}</td>
                                                <td class="py-3 px-4">
                                                    {{ number_format($detail->price_buy, 0, ',', '.') }}₫</td>
                                                <td class="py-3 px-4 font-semibold text-green-600">
                                                    {{ number_format($detail->amount, 0, ',', '.') }}₫</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>

                            <div class="text-xl font-semibold text-green-700 mt-4">
                                Tổng cộng: {{ number_format($total, 0, ',', '.') }}₫
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <p class="text-center mt-10 text-gray-500 italic">Bạn chưa có đơn hàng nào.</p>
            @endif
        </div>
    </main>
    <br>
</x-layout-site>
