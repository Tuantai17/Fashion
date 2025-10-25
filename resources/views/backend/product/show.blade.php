<x-layout-admin>
    <x-slot:title>
        Chi Tiết Sản Phẩm
    </x-slot:title>
    <div class="mb-3 rounded-lg p-2">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-xl font-bold text-[rgb(246,81,119)]">Chi Tiết Sản Phẩm</h2>
            </div>
            <div class="text-right">
                <a href="{{ route('product.index') }}" class="text-[rgb(246,81,119)] px-2 py-2 rounded-xl mx-1 font-semibold hover:text-[rgb(244,8,8)]">
                    <i class="fa fa-arrow-left" aria-hidden="true"></i>
                </a>
            </div>
        </div>
    </div>
    <div class="content-wrapper p-4 border border-[rgb(246,81,119)] rounded-lg">
        

        <div class="grid grid-cols-2 gap-4 mb-4">
            <div><strong>Tên sản phẩm:</strong> {{ $product->name }}</div>
            <div><strong>Slug:</strong> {{ $product->slug }}</div>
            <div><strong>Danh mục:</strong> {{ $product->category_name }}</div>
            <div><strong>Thương hiệu:</strong> {{ $product->brand_name }}</div>
            <div><strong>Giá gốc:</strong> {{ number_format($product->price_root) }} đ</div>
            <div><strong>Giá khuyến mãi:</strong> {{ number_format($product->price_sale) }} đ</div>
            <div><strong>Số lượng:</strong> {{ $product->qty }}</div>
            <div><strong>Trạng thái:</strong> 
                <span class="{{ $product->status ? 'text-green-600' : 'text-red-600' }}">
                    {{ $product->status ? 'Xuất bản' : 'Không xuất bản' }}
                </span>
            </div>
        </div>

        <div class="mb-4">
            <strong>Mô tả ngắn:</strong>
            <p>{{ $product->description }}</p>
        </div>

        <div class="mb-4">
            <strong>Chi tiết sản phẩm:</strong>
            <p>{{ $product->detail }}</p>
        </div>

        @if ($product->thumbnail)
            <div class="mb-4">
                <strong>Hình ảnh:</strong><br>
                <img src="{{ asset('assets/images/product/' . $product->thumbnail) }}" class="w-48 h-48 object-cover rounded-lg mt-2">
            </div>
        @endif

        
    </div>
</x-layout-admin>
