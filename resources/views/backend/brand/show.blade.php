<x-layout-admin>
    <x-slot:title>
        Chi Tiết Thương Hiệu
    </x-slot:title>

    <div class="mb-3 rounded-lg p-2">
        <div class="flex items-center justify-between">
            <h2 class="text-xl font-bold text-[rgb(246,81,119)]">Chi Tiết Thương Hiệu</h2>
            <div class="text-right">
                <a href="{{ route('brand.index') }}"
                   class="text-[rgb(246,81,119)] px-2 py-2 rounded-xl mx-1 font-semibold hover:text-[rgb(244,8,8)]">
                    <i class="fa fa-arrow-left" aria-hidden="true"></i>
                </a>
            </div>
        </div>
    </div>

    <div class="content-wrapper p-4 border border-[rgb(246,81,119)] rounded-lg">
        <div class="grid grid-cols-2 gap-4 mb-4">
            <div><strong>Tên Thương Hiệu:</strong> {{ $brand->name }}</div>
            <div><strong>Trạng Thái:</strong> 
                <span class="{{ $brand->status == 1 ? 'text-green-600' : 'text-red-600' }}">
                    {{ $brand->status == 1 ? 'Xuất Bản' : 'Không Xuất Bản' }}
                </span>
            </div>
        </div>

        <div class="mb-4">
            <strong>Mô Tả:</strong>
            <p class="whitespace-pre-line">
                {!! nl2br(e(preg_replace('/❀/', '❀', $brand->description ?? 'Chưa có mô tả'))) !!}
            </p>
        </div>

        @if ($brand->image)
            <div class="mb-4">
                <strong>Logo / Hình ảnh:</strong><br>
                <img src="{{ asset('assets/images/brand/' . $brand->image) }}" 
                     alt="{{ $brand->name }}"
                     class="w-48 h-48 object-cover rounded-lg mt-2">
            </div>
        @else
            <p class="text-gray-500">Chưa có hình ảnh</p>
        @endif
    </div>
</x-layout-admin>
