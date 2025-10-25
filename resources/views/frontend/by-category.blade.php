<x-layout-site>
<div class="container mx-auto px-4 py-8 py-40 mt-40">
    
    {{-- Nút quay về trang chủ --}}
    <div class="mb-6 flex flex-wrap gap-3">
    <a href="{{ route('site.home') }}"
       class="inline-block bg-green-600 text-white px-4 py-2 rounded-lg shadow hover:bg-green-700 transition">
        ← Về trang chủ
    </a>
    <a href="{{ route('site.product') }}"
       class="inline-block bg-blue-600 text-white px-4 py-2 rounded-lg shadow hover:bg-blue-700 transition">
        🛍️ Về tất cả sản phẩm
    </a>
</div>


    <h1 class="text-2xl font-bold text-green-700 mb-6">Sản phẩm trong danh mục: {{ $category->name }}</h1>

    <!-- {{-- Form lọc giá + thương hiệu --}} -->
<form method="GET" action="{{ route('site.by-category', $category->slug) }}">
    <div class="flex items-center gap-4 mb-6 flex-wrap">
        {{-- Giá từ --}}
        <input type="number" name="min_price" placeholder="Giá từ" value="{{ request('min_price') }}" class="border rounded p-2 w-32" />

        {{-- Giá đến --}}
        <input type="number" name="max_price" placeholder="Đến" value="{{ request('max_price') }}" class="border rounded p-2 w-32" />

        {{-- Thương hiệu --}}
        <select name="brand" class="border rounded p-2">
            <option value="">-- Chọn thương hiệu --</option>
            @foreach ($brand_list as $brand)
                <option value="{{ $brand->id }}" {{ request('brand') == $brand->id ? 'selected' : '' }}>
                    {{ $brand->name }}
                </option>
            @endforeach
        </select>

        <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded">Lọc</button>
        <a href="{{ route('site.product.byCategory', $category->slug) }}" class="text-blue-500 underline ml-2">Reset</a>
    </div>
</form>






    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
        @foreach($products as $product)
            <div class="border border-gray-200 rounded-xl overflow-hidden shadow hover:shadow-lg transition">
                <a href="{{ route('site.product.detail', $product->slug) }}">
                    <img src="{{ asset('assets/images/product/' . $product->thumbnail) }}" class="w-full h-48 object-cover" alt="{{ $product->name }}">

                    <div class="p-4">
                        <h2 class="font-semibold text-lg text-gray-800 truncate mb-2">{{ $product->name }}</h2>
                        @if ($product->price_sale > 0)
                            <p class="text-red-600 font-bold">
                                {{ number_format($product->price_sale) }}đ
                                <span class="text-sm line-through text-gray-400 ml-2">
                                    {{ number_format($product->price_root) }}đ
                                </span>
                            </p>
                        @else
<p class="text-green-600 font-bold">{{ number_format($product->price_root) }}đ</p>
                        @endif
                    </div>
                </a>
            </div>
        @endforeach
    </div>


{{-- Nút quay lại --}}
<div class="mb-4 flex flex-col sm:flex-row gap-2">
    <a href="{{ route('site.product') }}" class="inline-block text-sm text-blue-600 hover:underline">
        ← Quay lại danh sách sản phẩm
    </a>
    <a href="{{ url('/san-pham') }}" class="inline-block text-sm text-blue-600 hover:underline">
        ← Về trang sản phẩm
    </a>
</div>


    
    <div class="mt-8">
        {{ $products->appends(request()->query())->links() }} {{-- Giữ query string khi phân trang --}}
    </div>
</div>
</x-layout-site>
