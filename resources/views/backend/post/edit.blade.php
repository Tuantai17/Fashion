<x-layout-admin>
    <x-slot:title>Chỉnh Sửa Bài Viết</x-slot:title>

    <form action="{{ route('post.update', ['post' => $post->id]) }}" method="post" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="content-wrapper">
            <!-- Header -->
            <div class="mb-3 rounded-lg p-2">
                <div class="flex items-center justify-between">
                    <h2 class="text-xl font-bold text-[rgb(246,81,119)]">Chỉnh Sửa Bài Viết</h2>
                    <div class="text-right">
                        <button type="submit" class="px-2 py-2 cursor-pointer rounded-xl mx-1 text-[rgb(246,81,119)]">
                            <i class="fa fa-save" aria-hidden="true"></i>
                        </button>
                        <a href="{{ route('post.index') }}" class="text-[rgb(246,81,119)] px-2 py-2 rounded-xl mx-1 font-semibold hover:text-[rgb(244,8,8)]">
                            <i class="fa fa-arrow-left" aria-hidden="true"></i>
                        </a>
                    </div>
                </div>
            </div>

            <div class="border border-[rgb(246,81,119)] rounded-lg p-3">
                <!-- Tiêu đề -->
                <div class="mb-3">
                    <label for="title"><strong>Tiêu đề</strong></label>
                    <input type="text" name="title" id="title" class="w-full border border-[rgb(246,81,119)] rounded-lg p-2"
                        value="{{ old('title', $post->title) }}" placeholder="Nhập tiêu đề">
                    @if($errors->has('title'))
                        <div class="text-red-500">{{ $errors->first('title') }}</div>
                    @endif
                </div>

                <!-- Loại bài viết -->
                <div class="mb-3">
                    <label for="type"><strong>Loại bài viết</strong></label>
                    <select name="type" id="type" class="w-full border border-[rgb(246,81,119)] rounded-lg p-2">
                        <option value="news" {{ old('type', $post->type) == 'news' ? 'selected' : '' }}>Tin tức</option>
                        <option value="blog" {{ old('type', $post->type) == 'blog' ? 'selected' : '' }}>Blog</option>
                    </select>
                    @error('type') <div class="text-red-500">{{ $message }}</div> @enderror
                </div>

                <!-- Nội dung -->
                <div class="mb-3">
                    <label for="content"><strong>Nội dung</strong></label>
                    <textarea name="content" id="content" rows="6" class="w-full border border-[rgb(246,81,119)] rounded-lg p-2">{{ old('content', $post->content) }}</textarea>
                    @if($errors->has('content')) 
                        <div class="text-red-500">{{ $errors->first('content') }}</div>
                    @endif
                </div>

                <!-- Hình ảnh -->
                <div class="mb-3">
                    <label for="thumbnail"><strong>Hình ảnh</strong></label>
                    <input type="file" name="thumbnail" id="thumbnail" class="w-full border border-[rgb(246,81,119)] rounded-lg p-2">
                    @if($post->thumbnail)
                        <div class="mt-2 border border-[rgb(246,81,119)] p-2 rounded-lg inline-block">
                            <img src="{{ asset('assets/images/post/' . $post->thumbnail) }}" class="w-32 h-32 object-cover rounded-lg">
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
                        <option value="1" {{ old('status', $post->status) == '1' ? 'selected' : '' }}>Xuất bản</option>
                        <option value="0" {{ old('status', $post->status) == '0' ? 'selected' : '' }}>Không xuất bản</option>
                    </select>
                </div>
            </div>
        </div>
    </form>
</x-layout-admin>
