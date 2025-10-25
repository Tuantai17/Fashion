<x-layout-admin>
    <x-slot:title>
        Chi Tiết Chủ Đề
    </x-slot:title>

    <div class="mb-3 rounded-lg p-2">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-xl font-bold text-[rgb(246,81,119)]">Chi Tiết Chủ Đề</h2>
            </div>
            <div class="text-right">
                <a href="{{ route('topic.index') }}" class="text-[rgb(246,81,119)] px-2 py-2 rounded-xl mx-1 font-semibold hover:text-[rgb(244,8,8)]">
                    <i class="fa fa-arrow-left" aria-hidden="true"></i>
                </a>
            </div>
        </div>
    </div>

    <div class="content-wrapper p-4 border border-[rgb(246,81,119)] rounded-lg">
        <!-- Thông tin cơ bản -->
        <div class="grid grid-cols-2 gap-4 mb-4">
            <div><strong>Tên Chủ Đề:</strong> {{ $topic->name }}</div>
            <div><strong>Slug:</strong> {{ $topic->slug }}</div>
            <div><strong>Trạng Thái:</strong> 
                <span class="{{ $topic->status ? 'text-green-600' : 'text-red-600' }}">
                    {{ $topic->status ? 'Xuất bản' : 'Không xuất bản' }}
                </span>
            </div>
        </div>

        <!-- Mô tả -->
        <div class="mb-4">
            <strong>Mô Tả:</strong>
            <p>{{ $topic->description ?? 'Chưa có mô tả' }}</p>
        </div>

       

    </div>
</x-layout-admin>