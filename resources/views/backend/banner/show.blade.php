<x-layout-admin>
    <x-slot:title>
        Chi Tiết Banner
    </x-slot:title>

    <div class="mb-3 rounded-lg p-2">
        <div class="flex items-center justify-between">
            <h2 class="text-xl font-bold text-[rgb(246,81,119)]">Chi Tiết Banner</h2>
            <div class="text-right">
                <a href="{{ route('banner.index') }}"
                   class="text-[rgb(246,81,119)] px-2 py-2 rounded-xl mx-1 font-semibold hover:text-[rgb(244,8,8)]">
                    <i class="fa fa-arrow-left" aria-hidden="true"></i>
                </a>
            </div>
        </div>
    </div>

    <div class="content-wrapper p-4 border border-[rgb(246,81,119)] rounded-lg">
        <div class="grid grid-cols-2 gap-4 mb-4">
            <div><strong>Tên Banner:</strong> {{ $banner->name }}</div>
            <div><strong>Trạng Thái:</strong> 
                <span class="{{ $banner->status == 1 ? 'text-green-600' : 'text-red-600' }}">
                    {{ $banner->status == 1 ? 'Xuất Bản' : 'Không Xuất Bản' }}
                </span>
            </div>
            <div><strong>Vị Trí:</strong> {{ $banner->position ?? 'Không rõ' }}</div>
            <div><strong>Thứ Tự Hiển Thị:</strong> {{ $banner->sort_order ?? 1 }}</div>
        </div>

        @if ($banner->image)
            <div class="mb-4">
                <strong>Hình Ảnh:</strong><br>
                <img src="{{ asset($banner->image) }}" 
                     alt="{{ $banner->name }}"
                     class="w-48 h-48 object-cover rounded-lg mt-2">
            </div>
        @else
            <p class="text-gray-500">Chưa có hình ảnh</p>
        @endif
    </div>
</x-layout-admin>
