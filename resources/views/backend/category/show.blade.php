<x-layout-admin>
    <x-slot:title>
        Chi Tiết Danh Mục
    </x-slot:title>

    <div class="mb-3 rounded-lg p-2">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-xl font-bold text-[rgb(246,81,119)]">Chi Tiết Danh Mục</h2>
            </div>
            <div class="text-right">
                <a href="{{ route('category.index') }}" class="text-[rgb(246,81,119)] px-2 py-2 rounded-xl mx-1 font-semibold hover:text-[rgb(244,8,8)]">
                    <i class="fa fa-arrow-left" aria-hidden="true"></i>
                </a>
            </div>
        </div>
    </div>

    <div class="content-wrapper p-4 border border-[rgb(246,81,119)] rounded-lg">
        <div class="grid grid-cols-2 gap-4 mb-4">
            <div><strong>Tên Danh Mục:</strong> {{ $category->name }}</div>
            <div><strong>Thứ Tự Sắp Xếp:</strong> {{ $category->sort_order }}</div>
            <div><strong>Danh Mục Cha:</strong> {{ $category->parent_id == 0 ? 'Không có' : $category->parent->name ?? 'Đã bị xoá' }}</div>
            <div><strong>Trạng Thái:</strong>
                <span class="{{ $category->status == 1 ? 'text-green-600' : 'text-red-600' }}">
                    {{ $category->status == 1 ? 'Xuất bản' : 'Không xuất bản' }}
                </span>
            </div>
        </div>

        <div class="mb-4">
            <strong>Mô Tả:</strong>
            <p class="whitespace-pre-line">{{ $category->description ?? 'Chưa có mô tả' }}</p>
        </div>

        @if ($category->image)
            <div class="mb-4">
                <strong>Hình Ảnh:</strong><br>
                <img src="{{ asset('assets/images/category/' . $category->image) }}" class="w-48 h-48 object-cover rounded-lg mt-2">
            </div>
        @else
            <p class="text-gray-500">Chưa có hình ảnh</p>
        @endif
    </div>
</x-layout-admin>
