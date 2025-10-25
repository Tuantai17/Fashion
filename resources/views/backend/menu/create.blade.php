<x-layout-admin>
    <x-slot:title>
        Thêm Menu
    </x-slot:title>

    <form action="{{ route('menu.store') }}" method="POST">
        @csrf
        <div class="content-wrapper">
            <div class="mb-3 rounded-lg p-2">
                <div class="flex items-center justify-between">
                    <div>
                        <h2 class="text-xl font-bold text-[rgb(246,81,119)]">Thêm Menu</h2>
                    </div>
                    <div class="text-right">
                        <button type="submit" class="px-2 py-2 cursor-pointer rounded-xl mx-1 text-[rgb(246,81,119)]" title="Lưu">
                            <i class="fa fa-save" aria-hidden="true"></i>
                        </button>
                        <a href="{{ route('menu.index') }}" title="Quay lại danh sách menu" class="text-[rgb(246,81,119)] px-2 py-2 rounded-xl mx-1 font-semibold hover:text-[rgb(244,8,8)]">
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
                            <label for="name"><strong>Tên Menu</strong></label>
                            <input type="text" name="name" id="name"
                                class="w-full border border-[rgb(246,81,119)] rounded-lg p-2"
                                value="{{ old('name') }}" placeholder="Nhập tên menu">
                            @if($errors->has('name'))
                                <div class="text-red-500">{{ $errors->first('name') }}</div>
                            @endif
                        </div>

                        <div class="mb-3">
                            <label for="link"><strong>Liên kết</strong></label>
                            <input type="text" name="link" id="link"
                                class="w-full border border-[rgb(246,81,119)] rounded-lg p-2"
                                value="{{ old('link') }}" placeholder="Nhập liên kết">
                            @if($errors->has('link'))
                                <div class="text-red-500">{{ $errors->first('link') }}</div>
                            @endif
                        </div>

                        <div class="mb-3">
                            <label for="sort_order"><strong>Thứ tự</strong></label>
                            <input type="number" name="sort_order" id="sort_order"
                                class="w-full border border-[rgb(246,81,119)] rounded-lg p-2"
                                value="{{ old('sort_order') }}" placeholder="Thứ tự hiển thị">
                        </div>
                    </div>

                    {{-- Cột phải --}}
                    <div>
                        <div class="mb-3">
                            <label for="parent_id"><strong>Menu Cha</strong></label>
                            <select name="parent_id" id="parent_id"
                                    class="w-full border border-[rgb(246,81,119)] rounded-lg p-2">
                                <option value="0">-- Chọn menu cha --</option>
                                @foreach($menus as $item)
                                    <option value="{{ $item->id }}" {{ old('parent_id') == $item->id ? 'selected' : '' }}>
                                        {{ $item->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="type"><strong>Loại menu</strong></label>
                            <select name="type" id="type"
                                    class="w-full border border-[rgb(246,81,119)] rounded-lg p-2">
                                <option value="category" {{ old('type') == 'category' ? 'selected' : '' }}>Danh mục</option>
                                <option value="brand" {{ old('type') == 'brand' ? 'selected' : '' }}>Thương hiệu</option>
                                <option value="page" {{ old('type') == 'page' ? 'selected' : '' }}>Trang</option>
                                <option value="topic" {{ old('type') == 'topic' ? 'selected' : '' }}>Chủ đề</option>
                                <option value="custom" {{ old('type') == 'custom' ? 'selected' : '' }}>Tùy chỉnh</option>
                            </select>
                            @if($errors->has('type'))
                                <div class="text-red-500">{{ $errors->first('type') }}</div>
                            @endif
                        </div>

                        <div class="mb-3">
                            <label for="position"><strong>Vị trí hiển thị</strong></label>
                            <select name="position" id="position"
                                    class="w-full border border-[rgb(246,81,119)] rounded-lg p-2">
                                <option value="mainmenu" {{ old('position') == 'mainmenu' ? 'selected' : '' }}>Menu chính</option>
                                <option value="footer" {{ old('position') == 'footer' ? 'selected' : '' }}>Chân trang</option>
                            </select>
                            @if($errors->has('position'))
                                <div class="text-red-500">{{ $errors->first('position') }}</div>
                            @endif
                        </div>

                        <div class="mb-3">
                            <label for="status"><strong>Trạng Thái</strong></label>
                            <select name="status" id="status"
                                    class="w-full border border-[rgb(246,81,119)] rounded-lg p-2">
                                <option value="1">Xuất Bản</option>
                                <option value="0">Không Xuất Bản</option>
                            </select>
                            @if($errors->has('status'))
                                <div class="text-red-500">{{ $errors->first('status') }}</div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</x-layout-admin>
