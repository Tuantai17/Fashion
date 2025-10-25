<x-layout-site title="{{ $product_item->name }}">
    <div class="container mx-auto p-4">
        <h1 class="text-2xl font-bold mb-4">{{ $product_item->name }}</h1>

        <img src="{{ asset('assets/images/product/' . $product_item->thumbnail) }}" alt="{{ $product_item->name }}" class="mb-4 max-w-sm rounded-xl shadow">

        <p class="text-gray-700">{{ $product_item->description }}</p>

        <p class="mt-2 text-[rgb(246,81,119)] font-semibold text-lg">
            Giá: {{ number_format($product_item->price_sale) }}đ
        </p>

        <!-- Form thêm vào giỏ hàng -->
        <form action="{{ route('site.cart.add') }}" method="POST" class="mt-4 flex items-center gap-3">
            @csrf
            <input type="hidden" name="product_id" value="{{ $product_item->id }}">
            <input type="number" name="quantity" value="1" min="1"
                   class="w-16 border border-gray-300 rounded px-3 py-2 text-sm focus:outline-none focus:ring-1 focus:ring-[rgb(246,81,119)]">

            <button type="submit"
                    class="flex items-center gap-2 px-4 py-2 bg-[rgb(246,81,119)] text-white text-sm font-medium rounded-lg hover:bg-pink-600 transition">
                <i class="fas fa-shopping-cart"></i>
                <span>Thêm vào giỏ</span>
            </button>
        </form>

        {{-- Quay lại danh sách sản phẩm --}}
        <div class="mb-4 pt-10">
            <a href="{{ route('site.product') }}"
               class="inline-flex items-center px-4 py-2 bg-[rgb(246,81,119)] text-white text-sm font-medium rounded hover:[rgb(246, 166, 185)]  transition">
                <i class="fa fa-arrow-left" aria-hidden="true"></i>
            </a>
        </div>

        {{-- Sản phẩm liên quan --}}
        @if ($product_list->count())
            <h2 class="text-xl font-semibold mt-12 mb-4 text-[rgb(246,81,119)]">Sản phẩm liên quan</h2>

            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-6 pb-10">
                @foreach ($product_list as $item)
                    <div class="border rounded-lg overflow-hidden shadow hover:shadow-lg transition-all duration-300 hover:-translate-y-1">
                        <a href="{{ route('site.product.detail', $item->slug) }}">
                            <img src="{{ asset('assets/images/product/' . $item->thumbnail) }}"
                                 class="w-full h-100 object-cover" alt="{{ $item->name }}">
                            <div class="p-4">
                                <h4 class="font-semibold text-gray-800 mb-1 truncate">{{ $item->name }}</h4>
                                <p class="text-[rgb(246,81,119)] font-bold">
                                    {{ number_format($item->price_sale > 0 ? $item->price_sale : $item->price_root) }}đ
                                </p>
                            </div>
                        </a>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</x-layout-site>
