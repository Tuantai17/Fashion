<x-layout-admin>
    <x-slot:title>
        Chỉnh Sửa Danh Mục
    </x-slot:title>

    <form action="{{ route('category.update', ['category'=>$category->id]) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="content-wrapper">
            <div class="mb-3 rounded-lg p-2">
                <div class="flex items-center justify-between">
                    <div>
                        <h2 class="text-xl font-bold text-[rgb(246,81,119)]">Chỉnh Sửa Danh Mục</h2>
                    </div>
                    <div class="text-right">
                        <button type="submit" class="px-2 py-2 cursor-pointer rounded-xl mx-1 text-[rgb(246,81,119)]">
                            <i class="fa fa-save" aria-hidden="true"></i>
                        </button>
                        <a href="{{ route('category.index') }}" class="text-[rgb(246,81,119)] px-2 py-2 rounded-xl mx-1 font-semibold hover:text-[rgb(244,8,8)]">
                            <i class="fa fa-arrow-left" aria-hidden="true"></i>
                        </a>
                    </div>
                </div>
            </div>

            <div class="border border-[rgb(246,81,119)] rounded-lg p-3">
                <div class="flex gap-6">
                    <div class="w-full">
                        <div class="mb-3">
                            <label for="name"><strong>Tên Danh Mục</strong></label>
                            <input type="text" name="name" id="name"
                                   value="{{ old('name', $category->name) }}"
                                   class="w-full border border-[rgb(246,81,119)] rounded-lg p-2"
                                   placeholder="Nhập tên danh mục">
                            @if($errors->has('name'))
                                <div class="text-red-500">{{ $errors->first('name') }}</div>
                            @endif
                        </div>

                        <div class="mb-3">
                            <label for="description"><strong>Mô Tả</strong></label>
                            <textarea name="description" id="description" rows="4"
                                      class="w-full border border-[rgb(246,81,119)] rounded-lg p-2"
                                      placeholder="Nhập mô tả">{{ old('description', $category->description) }}</textarea>
                        </div>

                        <div class="mb-3">
                            <label for="sort_order"><strong>Thứ Tự Sắp Xếp</strong></label>
                            <input type="number" name="sort_order" id="sort_order"
                                   value="{{ old('sort_order', $category->sort_order) }}"
                                   class="w-full border border-[rgb(246,81,119)] rounded-lg p-2"
                                   placeholder="Nhập thứ tự sắp xếp">
                            @if($errors->has('sort_order'))
                                <div class="text-red-500">{{ $errors->first('sort_order') }}</div>
                            @endif
                        </div>

                        <div class="mb-3">
                            <label for="thumbnail"><strong>Hình Ảnh</strong></label>
                            <input type="file" name="thumbnail" id="thumbnail"
                                   class="w-full border border-[rgb(246,81,119)] rounded-lg p-2">
                            @if($category->image)
                                <div class="mt-2 border border-[rgb(246,81,119)] p-2 rounded-lg inline-block">
                                    <img src="{{ asset('assets/images/category/' . $category->image) }}" class="w-32 h-32 object-cover rounded-lg">
                                </div>
                            @endif
                            @if($errors->has('thumbnail'))
                                <div class="text-red-500">{{ $errors->first('thumbnail') }}</div>
                            @endif
                        </div>

                        <div class="mb-3">
                            <label for="parent_id"><strong>Danh Mục Cha</strong></label>
                            <select name="parent_id" id="parent_id" class="w-full border border-[rgb(246,81,119)] rounded-lg p-2">
                                <option value="0">-- Không có --</option>
                                @foreach ($list_category as $cat)
                                    <option value="{{ $cat->id }}" {{ old('parent_id', $category->parent_id) == $cat->id ? 'selected' : '' }}>
                                        {{ $cat->name }}
                                    </option>
                                @endforeach
                            </select>
                            @if($errors->has('parent_id'))
                                <div class="text-red-500">{{ $errors->first('parent_id') }}</div>
                            @endif
                        </div>

                        <div class="mb-3">
                            <label for="status"><strong>Trạng Thái</strong></label>
                            <select name="status" id="status"
                                    class="w-full border border-[rgb(246,81,119)] rounded-lg p-2">
                                <option value="1" {{ old('status', $category->status) == '1' ? 'selected' : '' }}>Xuất Bản</option>
                                <option value="0" {{ old('status', $category->status) == '0' ? 'selected' : '' }}>Không Xuất Bản</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</x-layout-admin>
