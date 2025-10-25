<div class="left-sidebar p-6 bg-white border border-gray-200 rounded-lg shadow-lg hover:shadow-2xl transition-all duration-300 flex flex-col justify-between h-full">
    {{-- Hình ảnh sản phẩm --}}
    <a href="{{ route('site.product.detail', ['slug' => $product->slug]) }}">
        <img src="{{ asset('assets/images/product/' . $product->thumbnail) }}" class="w-full h-56 object-cover mb-4" alt="{{ $product->name }}">
    </a>

    {{-- Thông tin sản phẩm --}}
    <div class="flex-1 flex flex-col justify-between">
        <div>
            {{-- Tên sản phẩm cố định chiều cao (tối đa 2 dòng) --}}
            <h6 class="text-xl font-semibold mb-3 text-gray-800 leading-snug line-clamp-2 min-h-[3.5rem]">
                {{ $product->name }}
            </h6>

            {{-- Giá sản phẩm --}}
            <div class="flex items-center gap-4 mb-6">
                <p class="text-lg text-gray-600 whitespace-nowrap">Giá:</p>
                <div class="flex gap-4 flex-wrap">
                    <span class="text-lg text-gray-600 line-through">{{ number_format($product->price_root) }}VND</span>
                    <span class="text-lg text-gray-600 font-semibold">{{ number_format($product->price_sale) }}VND</span>
                </div>
            </div>
        </div>

        {{-- Tính giảm giá nếu có --}}
        @if ($product->price_sale > 0 && $product->price_sale < $product->price_root)
            @php
            $discountPercent = round((($product->price_root - $product->price_sale) / $product->price_root) * 100);
            $savedAmount = $product->price_root - $product->price_sale;
            @endphp

            <div class="flex justify-center items-center gap-2 mt-1"> <p class="text-xl ">sale</p>
                <span class="bg-gradient-to-r from-red-600 to-pink-500 text-white text-xs font-semibold px-2 py-1 rounded-full shadow-sm">
                    -{{ $discountPercent }}%
                </span>
                <span class="text-sm text-gray-500">
                    Tiết kiệm:
                    <span class="text-red-500 font-medium">{{ number_format($savedAmount) }}₫</span>
                </span>
            </div>
            @endif

        
        {{-- Nút chi tiết và thêm vào giỏ --}}
        <div class="flex gap-4">
            <a href="{{ route('site.product.detail', $product->slug ?? '') }}" class="w-1/2">
                <button type="button" class="bg-sky-400 text-white px-4 py-3 rounded-lg w-full transition duration-300 hover:bg-sky-500">
                    Chi tiết
                </button>
            </a>
        
            <form action="{{ route('site.cart.add') }}" method="POST" class="w-1/2">
                @csrf
                <input type="hidden" name="product_id" value="{{ $product->id }}">
                <button type="submit" class="bg-sky-400 text-white px-4 py-3 rounded-lg w-full transition duration-300 hover:bg-sky-500">
                    <span>Thêm vào giỏ</span>
                </button>
            </form>
        </div>
    </div>
</div>
