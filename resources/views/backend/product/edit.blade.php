<x-layout-admin>
    <x-slot:title>Chỉnh Sửa Sản Phẩm</x-slot:title>

    <form action="{{ route('product.update', ['product'=>$product->id]) }}" method="post" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="content-wrapper">
            <!-- Header -->
            <div class="mb-3 rounded-lg p-2">
                <div class="flex items-center justify-between">
                    <h2 class="text-xl font-bold text-[rgb(246,81,119)]">Chỉnh Sửa Sản Phẩm</h2>
                    <div class="text-right">
                        <button type="submit" class="px-2 py-2 cursor-pointer rounded-xl mx-1 text-[rgb(246,81,119)]">
                            <i class="fa fa-save" aria-hidden="true"></i>
                        </button>
                        <a href="{{ route('product.index') }}" class="text-[rgb(246,81,119)] px-2 py-2 rounded-xl mx-1 font-semibold hover:text-[rgb(244,8,8)]">
                            <i class="fa fa-arrow-left" aria-hidden="true"></i>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Form Body -->
            <div class="border border-[rgb(246,81,119)] rounded-lg p-3">
                <div class="flex gap-6">
                    <div class="basis-9/12">
                        <!-- Tên sản phẩm -->
                        <div class="mb-3">
                            <label for="name"><strong>Tên Sản Phẩm</strong></label>
                            <input value="{{ old('name', $product->name) }}" type="text" class="w-full border border-[rgb(246,81,119)] rounded-lg p-2" name="name" id="name" placeholder="Nhập Tên Sản Phẩm">
                            @if($errors->has('name')) 
                                <div class="text-red-500">{{ $errors->first('name') }}</div> 
                            @endif
                        </div>

                        <!-- Chi tiết -->
                        <div class="mb-3">
                            <label for="detail"><strong>Chi Tiết Sản Phẩm</strong></label>
                            <textarea name="detail" id="detail" rows="4" class="w-full border border-[rgb(246,81,119)] rounded-lg p-2">{{ old('detail', $product->detail) }}</textarea>
                            @if($errors->has('detail')) <div class="text-red-500">{{ $errors->first('detail') }}</div> @endif
                        </div>

                        <!-- Mô tả -->
                        <div class="mb-3">
                            <label for="description"><strong>Mô Tả</strong></label>
                            <textarea name="description" id="description" class="w-full border border-[rgb(246,81,119)] rounded-lg p-2">{{ old('description', $product->description) }}</textarea>
                        </div>

                        <!-- Giá bán, giá khuyến mãi, số lượng -->
                        <div class="flex justify-between gap-5">
                            <div class="mb-3 w-full">
                                <label for="price_root"><strong>Giá Bán</strong></label>
                                <input value="{{ old('price_root', $product->price_root) }}" type="number" class="w-full border border-[rgb(246,81,119)] rounded-lg p-2" name="price_root" id="price_root">
                                @if($errors->has('price_root')) <div class="text-red-500">{{ $errors->first('price_root') }}</div> @endif
                            </div>
                            <div class="mb-3 w-full">
                                <label for="price_sale"><strong>Giá Khuyến Mãi</strong></label>
                                <input value="{{ old('price_sale', $product->price_sale) }}" type="number" class="w-full border border-[rgb(246,81,119)] rounded-lg p-2" name="price_sale" id="price_sale">
                                @if($errors->has('price_sale')) <div class="text-red-500">{{ $errors->first('price_sale') }}</div> @endif
                            </div>
                            <div class="mb-3 w-full">
                                <label for="qty"><strong>Số Lượng</strong></label>
                                <input value="{{ old('qty', $product->qty) }}" type="number" class="w-full border border-[rgb(246,81,119)] rounded-lg p-2" name="qty" id="qty" min="1">
                            </div>
                        </div>
                    </div>

                    <div class="basis-3/12">
                        <!-- Danh mục -->
                        <div class="mb-3">
                            <label for="category_id"><strong>Danh Mục</strong></label>
                            <select name="category_id" id="category_id" class="w-full border border-[rgb(246,81,119)] rounded-lg p-2">
                                <option value="">Chọn Danh Mục</option>
                                @foreach($list_category as $category)
                                    <option value="{{ $category->id }}" {{ old('category_id', $product->category_id) == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                            @if($errors->has('category_id')) <div class="text-red-500">{{ $errors->first('category_id') }}</div> @endif
                        </div>

                        <!-- Thương hiệu -->
                        <div class="mb-3">
                            <label for="brand_id"><strong>Thương Hiệu</strong></label>
                            <select name="brand_id" id="brand_id" class="w-full border border-[rgb(246,81,119)] rounded-lg p-2">
                                <option value="">Chọn Thương Hiệu</option>
                                @foreach($list_brand as $brand)
                                    <option value="{{ $brand->id }}" {{ old('brand_id', $product->brand_id) == $brand->id ? 'selected' : '' }}>
                                        {{ $brand->name }}
                                    </option>
                                @endforeach
                            </select>
                            @if($errors->has('brand_id')) <div class="text-red-500">{{ $errors->first('brand_id') }}</div> @endif
                        </div>

                        <!-- Hình ảnh -->
                        <div class="mb-3">
                            <label for="thumbnail"><strong>Hình</strong></label>
                            <input type="file" name="thumbnail" id="thumbnail" class="w-full border border-[rgb(246,81,119)] rounded-lg p-2">
                            @if($product->thumbnail)
                                <div class="mt-2 border border-[rgb(246,81,119)] p-2 rounded-lg inline-block">
                                    <img src="{{ asset('assets/images/product/' . $product->thumbnail) }}" class="w-32 h-32 object-cover rounded-lg">
                                </div>
                            @endif
                            
                            @if($errors->has('thumbnail')) 
                                <div class="text-red-500">{{ $errors->first('thumbnail') }}</div>
                             @endif
                        </div>

                        <!-- Trạng thái -->
                        <div class="mb-3">
                            <label for="status"><strong>Trạng Thái</strong></label>
                            <select name="status" id="status" class="w-full border border-[rgb(246,81,119)] rounded-lg p-2">
                                <option value="1" {{ old('status', $product->status) == '1' ? 'selected' : '' }}>Xuất Bản</option>
                                <option value="0" {{ old('status', $product->status) == '0' ? 'selected' : '' }}>Không Xuất Bản</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</x-layout-admin>
