<x-layout-admin>
    <x-slot:title>
        Chỉnh Sửa Thương Hiệu
    </x-slot:title>

    <form action="{{ route('brand.update', ['brand'=>$brand->id]) }}" method="post" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="content-wrapper">
            <!-- Header -->
            <div class="mb-3 rounded-lg p-2">
                <div class="flex items-center justify-between">
                    <h2 class="text-xl font-bold text-[rgb(246,81,119)]">Chỉnh Sửa Thương Hiệu</h2>
                    <div class="text-right">
                        <button type="submit" class="px-2 py-2 cursor-pointer rounded-xl mx-1 text-[rgb(246,81,119)]">
                            <i class="fa fa-save" aria-hidden="true"></i>
                        </button>
                        <a href="{{ route('brand.index') }}"
                            class="text-[rgb(246,81,119)] px-2 py-2 rounded-xl mx-1 font-semibold hover:text-[rgb(244,8,8)]">
                            <i class="fa fa-arrow-left" aria-hidden="true"></i>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Form -->
            <div class="border border-[rgb(246,81,119)] rounded-lg p-3">
                <div class="flex gap-6">
                    <div class="basis-9/12">
                        <div class="mb-3">
                            <label for="name"><strong>Tên Nhãn Hàng</strong></label>
                            <input type="text" name="name" id="name" value="{{ old('name', $brand->name) }}"
                                class="w-full border border-[rgb(246,81,119)] rounded-lg p-2"
                                placeholder="Nhập tên nhãn hàng">
                            @error('name') <div class="text-red-500">{{ $message }}</div> @enderror
                        </div>

                        <div class="mb-3">
                            <label for="description"><strong>Mô Tả</strong></label>
                            <textarea name="description" id="description" rows="4"
                                class="w-full border border-[rgb(246,81,119)] rounded-lg p-2"
                                placeholder="Nhập mô tả">{{ old('description', $brand->description) }}</textarea>
                            @error('description') <div class="text-red-500">{{ $message }}</div> @enderror
                        </div>
                    </div>

                    <div class="basis-3/12">
                        <div class="mb-3">
                            <label for="image"><strong>Logo / Hình ảnh</strong></label>
                            <input type="file" name="image" id="image"
                                class="w-full border border-[rgb(246,81,119)] rounded-lg p-2">
                            @error('image') <div class="text-red-500">{{ $message }}</div> @enderror
                        </div>

                        <div class="mb-3">
                            <label id="status">
                                <strong>Trạng Thái</strong>
                            </label>
                            <select name="status" id="status" class="w-full border border-[rgb(246,81,119)] rounded-lg p-2">
                                <option value="1" {{ old('status') == '1' ? 'selected' : '' }}>Xuất Bản</option>
                                <option value="0" {{ old('status') == '0' ? 'selected' : '' }}>Không Xuất Bản</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</x-layout-admin>
