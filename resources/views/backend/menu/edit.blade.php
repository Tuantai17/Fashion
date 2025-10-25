<x-layout-admin>
    <x-slot:title>Chỉnh Sửa Menu</x-slot:title>

    <form action="{{ route('menu.update', ['menu' => $menu->id]) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="content-wrapper">
            <!-- Header -->
            <div class="mb-3 rounded-lg p-2">
                <div class="flex items-center justify-between">
                    <h2 class="text-xl font-bold text-[rgb(246,81,119)]">Chỉnh Sửa Menu</h2>
                    <div class="text-right">
                        <button type="submit" class="px-2 py-2 cursor-pointer rounded-xl mx-1 text-[rgb(246,81,119)]">
                            <i class="fa fa-save" aria-hidden="true"></i>
                        </button>
                        <a href="{{ route('menu.index') }}" class="text-[rgb(246,81,119)] px-2 py-2 rounded-xl mx-1 font-semibold hover:text-[rgb(244,8,8)]">
                            <i class="fa fa-arrow-left" aria-hidden="true"></i>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Form Body -->
            <div class="border border-[rgb(246,81,119)] rounded-lg p-3">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Cột trái -->
                    <div>
                        <!-- Tên menu -->
                        <div class="mb-3">
                            <label for="name"><strong>Tên Menu</strong></label>
                            <input value="{{ old('name', $menu->name) }}" type="text" class="w-full border border-[rgb(246,81,119)] rounded-lg p-2" name="name" id="name" placeholder="Nhập tên menu">
                            @if($errors->has('name')) 
                                <div class="text-red-500">{{ $errors->first('name') }}</div> 
                            @endif
                        </div>

                        <!-- Liên kết -->
                        <div class="mb-3">
                            <label for="link"><strong>Liên Kết</strong></label>
                            <input value="{{ old('link', $menu->link) }}" type="text" class="w-full border border-[rgb(246,81,119)] rounded-lg p-2" name="link" id="link" placeholder="Nhập liên kết">
                            @if($errors->has('link')) 
                                <div class="text-red-500">{{ $errors->first('link') }}</div> 
                            @endif
                        </div>

                        <!-- Thứ tự -->
                        <div class="mb-3">
                            <label for="sort_order"><strong>Thứ Tự</strong></label>
                            <input value="{{ old('sort_order', $menu->sort_order) }}" type="number" class="w-full border border-[rgb(246,81,119)] rounded-lg p-2" name="sort_order" id="sort_order" placeholder="Thứ tự hiển thị">
                        </div>
                    </div>

                    <!-- Cột phải -->
                    <div>
                        <!-- Menu Cha -->
                        <div class="mb-3">
                            <label for="parent_id"><strong>Menu Cha</strong></label>
                            <select name="parent_id" id="parent_id" class="w-full border border-[rgb(246,81,119)] rounded-lg p-2">
                                <option value="">-- Chọn Menu Cha --</option>
                                @foreach($menus as $item)
                                    <option value="{{ $item->id }}" {{ old('parent_id', $menu->parent_id) == $item->id ? 'selected' : '' }}>
                                        {{ $item->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Loại Menu -->
                        <div class="mb-3">
                            <label for="type"><strong>Loại Menu</strong></label>
                            <select name="type" id="type" class="w-full border border-[rgb(246,81,119)] rounded-lg p-2">
                                <option value="category" {{ old('type', $menu->type) == 'category' ? 'selected' : '' }}>Danh mục</option>
                                <option value="brand" {{ old('type', $menu->type) == 'brand' ? 'selected' : '' }}>Thương hiệu</option>
                                <option value="page" {{ old('type', $menu->type) == 'page' ? 'selected' : '' }}>Trang</option>
                                <option value="topic" {{ old('type', $menu->type) == 'topic' ? 'selected' : '' }}>Chủ đề</option>
                                <option value="custom" {{ old('type', $menu->type) == 'custom' ? 'selected' : '' }}>Tùy chỉnh</option>
                            </select>
                            @if($errors->has('type')) 
                                <div class="text-red-500">{{ $errors->first('type') }}</div> 
                            @endif
                        </div>

                        <!-- Vị trí hiển thị -->
                        <div class="mb-3">
                            <label for="position"><strong>Vị Trí Hiển Thị</strong></label>
                            <select name="position" id="position" class="w-full border border-[rgb(246,81,119)] rounded-lg p-2">
                                <option value="mainmenu" {{ old('position', $menu->position) == 'mainmenu' ? 'selected' : '' }}>Menu Chính</option>
                                <option value="footer" {{ old('position', $menu->position) == 'footer' ? 'selected' : '' }}>Chân Trang</option>
                            </select>
                            @if($errors->has('position')) 
                                <div class="text-red-500">{{ $errors->first('position') }}</div> 
                            @endif
                        </div>

                        <!-- Trạng thái -->
                        <div class="mb-3">
                            <label for="status"><strong>Trạng Thái</strong></label>
                            <select name="status" id="status" class="w-full border border-[rgb(246,81,119)] rounded-lg p-2">
                                <option value="1" {{ old('status', $menu->status) == '1' ? 'selected' : '' }}>Xuất Bản</option>
                                <option value="0" {{ old('status', $menu->status) == '0' ? 'selected' : '' }}>Không Xuất Bản</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</x-layout-admin>
