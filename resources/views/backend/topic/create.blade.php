<x-layout-admin>
    <x-slot:title>Thêm Chủ Đề</x-slot:title>

    <form action="{{ route('topic.store') }}" method="POST">
        @csrf

        <div class="content-wrapper">
            <!-- Header -->
            <div class="mb-3 rounded-lg p-2">
                <div class="flex items-center justify-between">
                    <h2 class="text-xl font-bold text-[rgb(246,81,119)]">Thêm Chủ Đề</h2>
                    <div class="text-right">
                        <button type="submit" class="px-2 py-2 cursor-pointer rounded-xl mx-1 text-[rgb(246,81,119)]">
                            <i class="fa fa-save"></i>
                        </button>
                        <a href="{{ route('topic.index') }}" class="text-[rgb(246,81,119)] px-2 py-2 rounded-xl mx-1 font-semibold hover:text-red-600">
                            <i class="fa fa-arrow-left"></i>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Form Body -->
            <div class="border border-[rgb(246,81,119)] rounded-lg p-3">
                <!-- Tên Chủ Đề -->
                <div class="mb-3">
                    <label for="name" class="font-semibold">Tên Chủ Đề</label>
                    <input type="text" name="name" id="name" value="{{ old('name') }}" required
                        class="w-full border border-[rgb(246,81,119)] rounded-lg p-2">
                        @if($errors->has('name')) <div class="text-red-500">{{ $errors->first('name') }}</div> @endif
                </div>

                <!-- Slug -->
                <div class="mb-3">
                    <label for="slug" class="font-semibold">Slug</label>
                    <input type="text" name="slug" id="slug" value="{{ old('slug') }}"
                        class="w-full border border-[rgb(246,81,119)] rounded-lg p-2"
                        placeholder="Tự động tạo nếu bỏ trống">
                        @if($errors->has('name')) <div class="text-red-500">{{ $errors->first('name') }}</div> @endif
                </div>

                <!-- Mô tả -->
                <div class="mb-3">
                    <label for="description" class="font-semibold">Mô Tả</label>
                    <textarea name="description" id="description" rows="3"
                        class="w-full border border-[rgb(246,81,119)] rounded-lg p-2"
                        placeholder="Nhập mô tả">{{ old('description') }}</textarea>
                    
                </div>

                <!-- Trạng thái -->
                <div class="mb-3">
                    <label for="status"><strong>Trạng Thái</strong></label>
                    <select name="status" id="status" class="w-full border border-[rgb(246,81,119)] rounded-lg p-2">
                    <option value="1" {{ old('status') == '1' ? 'selected' : '' }}>Xuất Bản</option>
                    <option value="0" {{ old('status') == '0' ? 'selected' : '' }}>Không Xuất Bản</option>

                    </select>
                </div>
            </div>
        </div>
    </form>
</x-layout-admin>
