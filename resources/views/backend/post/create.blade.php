<x-layout-admin>
    @if (session('success'))
        <div class="p-4 mb-6 bg-green-100 text-green-800 rounded">
            {{ session('success') }}
        </div>
    @endif

    @if (session('error'))
        <div class="p-4 mb-6 bg-red-100 text-red-800 rounded">
            {{ session('error') }}
        </div>
    @endif

    <div class="content-wrapper">
        <div class="mb-3 rounded-lg p-2">
            <div class="flex items-center justify-between">
                <div>
                    <h2 class="text-xl font-bold text-[rgb(246,81,119)]">➕ Thêm bài viết mới</h2>
                </div>
                <div class="text-right">
                    <button type="submit" class="px-2 py-2 cursor-pointer rounded-xl mx-1 text-[rgb(246,81,119)]" title="Lưu">
                        <i class="fa fa-save" aria-hidden="true"></i>
                    </button>
                    <a href="{{ route('post.index') }}" title="Quay lại danh sách bài viết" class="text-[rgb(246,81,119)] px-2 py-2 rounded-xl mx-1 font-semibold hover:text-[rgb(244,8,8)]">
                        <i class="fa fa-arrow-left" aria-hidden="true"></i>
                    </a>
                </div>
            </div>
        </div>

        <div class="border border-[rgb(246,81,119)] rounded-lg p-3">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                {{-- Cột trái --}}
                <div>
                    <div class="mb-3">
                        <label for="title"><strong>Tiêu đề bài viết</strong></label>
                        <input type="text" name="title" id="title" class="w-full border border-[rgb(246,81,119)] rounded-lg p-2" value="{{ old('title') }}" placeholder="Nhập tiêu đề bài viết">
                        @if($errors->has('title'))
                            <div class="text-red-500">{{ $errors->first('title') }}</div>
                        @endif
                    </div>

                    <div class="mb-3">
                        <label for="detail"><strong>Chi tiết</strong></label>
                        <textarea name="detail" id="detail" class="w-full border border-[rgb(246,81,119)] rounded-lg p-2" rows="4" placeholder="Nhập chi tiết bài viết">{{ old('detail') }}</textarea>
                        @if($errors->has('detail'))
                            <div class="text-red-500">{{ $errors->first('detail') }}</div>
                        @endif
                    </div>

                    <div class="mb-3">
                        <label for="content"><strong>Nội dung chi tiết</strong></label>
                        <textarea name="content" id="content" class="w-full border border-[rgb(246,81,119)] rounded-lg p-2" rows="6" placeholder="Nhập nội dung chi tiết bài viết" required>{{ old('content') }}</textarea>
                        @if($errors->has('content'))
                            <div class="text-red-500">{{ $errors->first('content') }}</div>
                        @endif
                    </div>

                    <div class="mb-3">
                        <label for="description"><strong>Mô tả ngắn</strong></label>
                        <textarea name="description" id="description" class="w-full border border-[rgb(246,81,119)] rounded-lg p-2" rows="4" placeholder="Nhập mô tả ngắn">{{ old('description') }}</textarea>
                        @if($errors->has('description'))
                            <div class="text-red-500">{{ $errors->first('description') }}</div>
                        @endif
                    </div>
                </div>

                {{-- Cột phải --}}
                <div>
                    <div class="mb-3">
                        <label for="thumbnail"><strong>Ảnh đại diện</strong></label>
                        <input type="file" name="thumbnail" id="thumbnail" class="w-full border border-[rgb(246,81,119)] rounded-lg p-2" accept="image/*">
                        @if($errors->has('thumbnail'))
                            <div class="text-red-500">{{ $errors->first('thumbnail') }}</div>
                        @endif
                    </div>

                    <div class="mb-3">
                        <label for="status"><strong>Trạng thái</strong></label>
                        <select name="status" id="status" class="w-full border border-[rgb(246,81,119)] rounded-lg p-2">
                            <option value="1" {{ old('status', 1) == 1 ? 'selected' : '' }}>Hiển thị</option>
                            <option value="0" {{ old('status') == 0 ? 'selected' : '' }}>Ẩn</option>
                        </select>
                        @if($errors->has('status'))
                            <div class="text-red-500">{{ $errors->first('status') }}</div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-layout-admin>
