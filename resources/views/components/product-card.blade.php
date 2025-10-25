<div class="border rounded-lg overflow-hidden bg-white shadow hover:shadow-lg transition-all duration-300 hover:scale-105">
    <div class="relative overflow-hidden">
        <!-- Giảm giá badge -->
        <span class="absolute top-2 left-2 bg-red-600 text-white text-xs px-2 py-1 rounded">Giảm 11%</span>

        <a href="{{ route('site.product.detail', ['slug' => $product->slug]) }}">
        <img src="{{ asset('assets/images/product/' . $product->thumbnail) }}"
        class="w-full h-80 object-cover rounded" alt="{{ $product->name }}">
        </a>
    </div>

    <div class="text-center p-4 ">
        <p class="text-xs text-gray-500 uppercase tracking-widest">NV STORE</p>

        <h2 class="text-base font-semibold text-gray-800 my-2 hover:text-[rgb(244,184,198)]">
            <a href="{{ route('site.product.detail', ['slug' => $product->slug]) }}">
                {{ $product->name }}
            </a>
        </h2>

        {{-- Giá --}}
        <div class="flex justify-center items-center gap-2 mb-2">
            @if ($product->price_sale > 0 && $product->price_sale < $product->price_root)
                <span class="text-red-600 font-bold text-lg">{{ number_format($product->price_sale) }}₫</span>
                <span class="line-through text-gray-500 text-sm">{{ number_format($product->price_root) }}₫</span>
            @else
                <span class="text-gray-800 font-bold text-lg">{{ number_format($product->price_root) }}₫</span>
            @endif
        </div>

        {{-- Tính giảm giá nếu có --}}
        @if ($product->price_sale > 0 && $product->price_sale < $product->price_root)
            @php
                $discountPercent = round((($product->price_root - $product->price_sale) / $product->price_root) * 100);
                $savedAmount = $product->price_root - $product->price_sale;
            @endphp

            <div class="flex justify-center items-center gap-2 mt-1">
                <span class="text-sm text-gray-600">Tiết kiệm:
                    <span class="text-red-600 font-medium">{{ number_format($savedAmount) }}₫</span>
                </span>
            </div>
        @endif

        {{-- Thêm icon cho chi tiết và giỏ hàng --}}
        <div class="mt-4 flex justify-end space-x-4">
            
        <form action="{{ route('site.cart.add') }}" method="POST" class="w-1/2">
                @csrf
                <input type="hidden" name="product_id" value="{{ $product->id }}">
                <button type="submit" class="flex items-center justify-center gap-2  text-white px-4 py-3 rounded-lg w-full transition duration-300 hover:bg-sky-200">
                    <i class="fa fa-shopping-cart text-pink-500"></i>
                </button>

            </form>
        </div>
    </div>
</div>
