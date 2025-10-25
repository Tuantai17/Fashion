<div class="container mx-auto py-10">
    <h3 class="text-center text-2xl font-semibold mb-8">Sản phẩm giảm giá</h3>
    
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
        @foreach ($product_sale as $product_item)
            <x-product-card :productitem="$product_item" />
        @endforeach
    </div>

    <div class="mt-10 text-center">
        <a href="{{ route('site.product') }}"> <!-- sửa thành route nếu có -->
            <button type="button" class="border border-gray-800 text-gray-800 px-6 py-2 rounded hover:bg-gray-800 hover:text-white transition">
                Xem tất cả sản phẩm
            </button>
        </a>
    </div>
</div>
