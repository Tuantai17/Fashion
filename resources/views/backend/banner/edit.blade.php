<x-layout-admin>
    <x-slot:title>Thêm Banner</x-slot:title>

    <form action="{{ route('banner.update', ['banner'=>$banner->id]) }}" method="post" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="content-wrapper">
            <!-- Header -->
            <div class="mb-3 rounded-lg p-2">
                <div class="flex justify-between items-center">
                    <h2 class="text-xl font-bold text-[rgb(246,81,119)]">Chỉnh Sửa Banner</h2>
                    <div class="text-right">
                        <button type="submit" class="px-2 py-2 rounded-xl text-[rgb(246,81,119)]">
                            <i class="fa fa-save" aria-hidden="true"></i>
                        </button>
                        <a href="{{ route('banner.index') }}" class="px-2 py-2 rounded-xl text-[rgb(246,81,119)] hover:text-red-600">
                            <i class="fa fa-arrow-left" aria-hidden="true"></i>
                        </a>
                    </div>
                </div>
            </div>

            <div class="border border-[rgb(246,81,119)] rounded-lg p-3 grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <!-- Tên Banner -->
                     <div class="mb-3">
                        <label for="name"><strong>Tên Banner</strong></label>
                        <input  value="{{ old('name', $banner->name) }}" type="text" name="name" id="name"
                            class="w-full border border-[rgb(246,81,119)] rounded-lg p-2"
                            placeholder="Nhập tên banner">
                        @if($errors->has('name'))
                            <div class="text-red-500">{{ $errors->first('name') }}</div>
                        @endif
                    </div>

                    <!-- Hình ảnh -->
                    <div class="mb-3">
                        <label for="image"><strong>Hình ảnh</strong></label>
                        <input type="file" name="image" id="image"
                            accept="image/*"
                            class="w-full border border-[rgb(246,81,119)] rounded-lg p-2">

                        {{-- Hiển thị ảnh nếu có --}}
                        @if (!empty($banner->image))
                            <div class="mt-2 border border-[rgb(246,81,119)] p-2 rounded-lg inline-block">
                                <img src="{{ asset($banner->image) }}" alt="{{ $banner->name }}" class="w-32 h-32 object-cover rounded">
                            </div>
                        @endif

                        {{-- Hiển thị lỗi nếu có --}}
                        @if($errors->has('image'))
                            <div class="text-red-500 text-sm mt-1">{{ $errors->first('image') }}</div>
                        @endif
                    </div>
                    <!-- <div class="mb-3">
                        <label for="image"><strong>Hình ảnh</strong></label>
                        <input type="file" name="image" id="image"
                            accept="image/*"
                            class="w-full border border-[rgb(246,81,119)] rounded-lg p-2">
                            
                            @if ($errors->has('image'))
                            <div class="mt-2 border border-[rgb(246,81,119)] p-2 rounded-lg inline-block">
                                <img src="{{ asset($banner->image) }}" alt="{{ $banner->name }}" class="w-32 h-32 object-cover rounded">
                            </div>
                            @endif
                    </div> -->

                </div>

               
                <div>
                    <!-- Thứ tự-->
                    <div class="mb-3">
                        <label for="sort_order"><strong>Thứ tự</strong></label>
                        <input value="{{ old('sort_order', $banner->sort_order) }}" type="number" name="sort_order" id="sort_order"
                        class="w-full border border-[rgb(246,81,119)] rounded-lg p-2"
                            >
                        @if($errors->has('sort_order'))
                            <div class="text-red-500">{{ $errors->first('sort_order') }}</div>
                        @endif
                    </div>

                    <!-- Vị trí -->
                    <div class="mb-3">
                        <label for="position"><strong>Vị trí</strong></label>
                        <input value="{{ old('position', $banner->position) }}" type="text" name="position" id="position"
                        class="w-full border border-[rgb(246,81,119)] rounded-lg p-2"
                            placeholder="Ví dụ: home, sidebar, slideshow">
                        @if($errors->has('position'))
                            <div class="text-red-500 text-sm mt-1">{{ $errors->first('position') }}</div>
                        @endif
                    </div>

                    <!-- Trạng thái -->
                    <div class="mb-3">
                        <label for="status"><strong>Trạng Thái</strong></label>
                        <select name="status" id="status" class="w-full border border-[rgb(246,81,119)] rounded-lg p-2">
                            <option value="1" {{ old('status', $banner->status) == '1' ? 'selected' : '' }}>Xuất Bản</option>
                            <option value="0" {{ old('status', $banner->status) == '0' ? 'selected' : '' }}>Không Xuất Bản</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>
    </form>
</x-layout-admin>
