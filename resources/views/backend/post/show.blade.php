<x-layout-admin>
    <x-slot:title>
        Chi Tiết Bài Viết
    </x-slot:title>

    <div class="mb-3 rounded-lg p-2">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-xl font-bold text-[rgb(246,81,119)]">Chi Tiết Bài Viết</h2>
            </div>
            <div class="text-right">
                <a href="{{ route('post.index') }}" class="text-[rgb(246,81,119)] px-2 py-2 rounded-xl mx-1 font-semibold hover:text-[rgb(244,8,8)]">
                    <i class="fa fa-arrow-left" aria-hidden="true"></i>
                </a>
            </div>
        </div>
    </div>

    <div class="content-wrapper p-4 border border-[rgb(246,81,119)] rounded-lg">
        <div class="grid grid-cols-2 gap-4 mb-4">
            <div><strong>Tiêu Đề:</strong> {{ $post->title }}</div>
            <div><strong>Slug:</strong> {{ $post->slug }}</div>
            <div><strong>Loại:</strong> {{ $post->type == 'news' ? 'Tin tức' : 'Blog' }}</div>
            <div><strong>Trạng Thái:</strong>
                <span class="{{ $post->status == 1 ? 'text-green-600' : 'text-red-600' }}">
                    {{ $post->status == 1 ? 'Xuất bản' : 'Không xuất bản' }}
                </span>
            </div>
        </div>

        <div class="mb-4">
            <strong>Mô Tả:</strong>
            <p class="whitespace-pre-line">{{ $post->description ?? 'Chưa có mô tả' }}</p>
        </div>

        <div class="mb-4">
            <strong>Nội Dung:</strong>
            <p class="whitespace-pre-line">{{ $post->detail ?? 'Chưa có nội dung' }}</p>
        </div>

        <div class="mb-4">
            <strong>Chủ Đề:</strong>
            <p>{{ $post->topic->name ?? 'Chưa có chủ đề' }}</p>
        </div>

        <div class="mb-4">
            <strong>Ngày Tạo:</strong>
            <p>{{ $post->created_at->format('d-m-Y H:i') }}</p>
        </div>

        <div class="mb-4">
            <strong>Ngày Cập Nhật:</strong>
            <p>{{ $post->updated_at->format('d-m-Y H:i') }}</p>
        </div>

        @if ($post->thumbnail)
            <div class="mb-4">
                <strong>Hình Ảnh:</strong><br>
                <img src="{{ asset('assets/images/post/' . $post->thumbnail) }}" class="w-48 h-48 object-cover rounded-lg mt-2">
            </div>
        @else
            <p class="text-gray-500">Chưa có hình ảnh</p>
        @endif
    </div>
</x-layout-admin>