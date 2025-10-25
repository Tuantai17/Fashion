    <x-layout-site>
        <x-slot:title>Tất cả sản phẩm</x-slot:title>

        <main class="my-5">
            <div class="container mx-auto md:px-4 px-2">
                <div class="flex md:flex-row flex-col gap-5">
                    <div class="md:basis-3/12 mt-9">
                        <!-- Lọc theo Danh mục -->
                        <form method="GET" action="{{ route('site.product') }}">
                            <div class="mb-5">
                                <label for="category" class="block text-lg font-bold">Danh mục</label>
                                <select name="category" id="category" class="w-full p-2 border border-gray-300 rounded-md">
                                    <option value="">Tất cả</option>
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>
                                            {{ $category->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Lọc theo Thương hiệu -->
                            <div class="mb-5">
                                <label for="brand" class="block text-lg font-bold">Thương hiệu</label>
                                <select name="brand" id="brand" class="w-full p-2 border border-gray-300 rounded-md">
                                    <option value="">Tất cả</option>
                                    @foreach ($brands as $brand)
                                        <option value="{{ $brand->id }}" {{ request('brand') == $brand->id ? 'selected' : '' }}>
                                            {{ $brand->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Lọc theo mức giá -->
                            <div class="mb-5">
                                <label for="min_price" class="block text-lg font-bold">Mức giá</label>
                                <input type="number" name="min_price" id="min_price" placeholder="Từ" class="w-full p-2 border border-gray-300 rounded-md"
                                    value="{{ request('min_price', 0) }}">
                                <input type="number" name="max_price" id="max_price" placeholder="Đến" class="w-full p-2 border border-gray-300 rounded-md mt-2"
                                    value="{{ request('max_price', 1000000) }}">
                            </div>

                            <button type="submit" class="bg-pink-500 text-white py-2 px-4 rounded">Lọc</button>
                        </form>
                    </div>

                    <div class="md:basis-9/12">
                        <div class="product-all">
                            <div class="flex justify-between">
                                <h1 class="mb-3 text-3xl">
                                    <strong class="border-b-2 border-[#1c2e37]">TẤT CẢ SẢN PHẨM</strong>
                                </h1>
                            </div>

                            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6 text-center">
        @foreach ($products as $product)
            @php
                $discountPercent = 0;
                $savedAmount = 0;
                if ($product->price_sale > 0 && $product->price_sale < $product->price_root) {
                    $discountPercent = round((($product->price_root - $product->price_sale) / $product->price_root) * 100);
                    $savedAmount = $product->price_root - $product->price_sale;
                }
            @endphp

            <div class="border rounded-lg overflow-hidden bg-white shadow hover:shadow-lg transition-all duration-300 hover:scale-105">
                <div class="relative overflow-hidden">
                    <!-- Giảm giá badge -->
                    @if($discountPercent > 0)
                        <span class="absolute top-2 left-2 bg-red-600 text-white text-xs px-2 py-1 rounded">
                            Giảm {{ $discountPercent }}%
                        </span>
                    @endif

                    <a href="{{ route('site.product.detail', ['slug' => $product->slug]) }}">
                        <img src="{{ asset('assets/images/product/' . $product->thumbnail) }}"
                            class="w-full h-80 object-cover rounded" alt="{{ $product->name }}">
                    </a>
                </div>

                <div class="text-center p-4">
                    <p class="text-xs text-gray-500 uppercase tracking-widest">NV STORE</p>

                    <h2 class="text-base rounded-lg relative text-gray-800 my-2 hover:text-[rgb(244,184,198)]">
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

                    {{-- Tiết kiệm --}}
                    @if ($discountPercent > 0)
                        <div class="flex justify-center items-center gap-2 mt-1">
                            <span class="text-sm text-gray-600">Tiết kiệm:
                                <span class="text-red-600 font-medium">{{ number_format($savedAmount) }}₫</span>
                            </span>
                        </div>
                    @endif

                    {{-- Nút chi tiết và giỏ hàng --}}
                    <div class="mt-4 flex justify-end space-x-4 px-4 pb-4">
        <form action="{{ route('site.cart.add') }}" method="POST">
            @csrf
            <input type="hidden" name="product_id" value="{{ $product->id }}">
            <input type="hidden" name="quantity" value="1">
            <button type="submit" class="flex items-center justify-center gap-2  text-white px-4 py-3 rounded-lg w-full transition duration-300 hover:bg-sky-200">
                <i class="fa fa-shopping-cart text-pink-500"></i>
            </button>
        </form>
    </div>

                </div>
            </div>
        @endforeach
    </div>



                            <!-- Phân trang -->
                            <div class="mt-6">
                                {{ $products->links() }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </x-layout-site>
