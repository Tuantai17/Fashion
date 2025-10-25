<x-layout-admin>
    <x-slot:title>
        Chi Tiết Menu
    </x-slot:title>

    <div class="mb-3 rounded-lg p-2">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-xl font-bold text-[rgb(246,81,119)]">Chi Tiết Menu</h2>
            </div>
            <div class="text-right">
                <a href="{{ route('menu.index') }}" class="text-[rgb(246,81,119)] px-2 py-2 rounded-xl mx-1 font-semibold hover:text-[rgb(244,8,8)]">
                    <i class="fa fa-arrow-left" aria-hidden="true"></i>
                </a>
            </div>
        </div>
    </div>

    <div class="content-wrapper p-4 border border-[rgb(246,81,119)] rounded-lg">
        <div class="grid grid-cols-2 gap-4 mb-4">
            <div><strong>Tên Menu:</strong> {{ $menu->name }}</div>
            <div><strong>Link:</strong> {{ $menu->link }}</div>
            <div><strong>Vị trí:</strong> {{ $menu->position }}</div>
            <div><strong>Loại:</strong> {{ $menu->type }}</div>
            <div><strong>Sắp xếp:</strong> {{ $menu->sort_order }}</div>
            <div><strong>Trạng thái:</strong>
                <span class="{{ $menu->status ? 'text-green-600' : 'text-red-600' }}">
                    {{ $menu->status ? 'Hiển thị' : 'Ẩn' }}
                </span>
            </div>
        </div>

        <div class="mb-4">
            <strong>Menu Cha:</strong>
            <p>
                @if ($menu->parent_id)
                    {{ $menus->find($menu->parent_id)->name ?? 'Không xác định' }}
                @else
                    Không có
                @endif
            </p>
        </div>

        <div class="grid grid-cols-2 gap-4 mb-4">
            <div><strong>Ngày Tạo:</strong> {{ $menu->created_at->format('d-m-Y H:i') }}</div>
            <div><strong>Ngày Cập Nhật:</strong> {{ $menu->updated_at->format('d-m-Y H:i') }}</div>
        </div>
    </div>
</x-layout-admin>
