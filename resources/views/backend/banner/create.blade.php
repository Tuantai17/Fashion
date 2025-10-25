<x-layout-admin>
    <x-slot:title>Thêm Banner</x-slot:title>

    <form action="{{ route('banner.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="content-wrapper">
            <div class="mb-3 p-2">
                <div class="flex justify-between items-center">
                    <h2 class="text-xl font-bold text-[rgb(246,81,119)]">Thêm Banner</h2>
                    <div>
                        <button type="submit" class="px-2 py-2 rounded-xl text-[rgb(246,81,119)]">
                            <i class="fa fa-save"></i>
                        </button>
                        <a href="{{ route('banner.index') }}" class="px-2 py-2 rounded-xl text-[rgb(246,81,119)] hover:text-red-600">
                            <i class="fa fa-arrow-left"></i>
                        </a>
                    </div>
                </div>
            </div>

            <div class="border border-[rgb(246,81,119)] rounded-lg p-3 grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <!-- Tên banner -->
                    <div class="mb-3">
                        <label id="name">
                            <strong>Tên Banner</strong>
                        </label>
                        <input value="{{old('name')}}" type="text" class="w-full border border-[rgb(246,81,119)] rounded-lg p-2" placeholder="Nhập Tên Sản Phẩm" name="name" id="name">
                        @if($errors->has('name'))
                            <div class="text-red-500">{{$errors->first('name')}}</div>
                        @endif
                    </div>
                    

                    <!--Hình ảnh -->
                    <div class="mb-3">
                        <label for="image"><strong>Hình ảnh</strong></label>
                        <input type="file" name="image" id="image"
                            accept="image/*"
                            class="w-full border border-[rgb(246,81,119)] rounded-lg p-2">
                            @if($errors->has('image'))
                                <div class="text-red-500">{{ $errors->first('image') }}</div>
                            @endif
                    </div>
                </div>

                {{-- Cột phải --}}
                <div>
                    {{-- Thứ tự --}}
                    <div class="mb-3">
                        <label for="sort_order"><strong>Thứ tự</strong></label>
                        <input type="number" name="sort_order" id="sort_order"
                            class="w-full border border-[rgb(246,81,119)] rounded-lg p-2"
                            value="{{ old('sort_order', 1) }}">
                        @if($errors->has('sort_order'))
                            <div class="text-red-500 text-sm mt-1">{{ $errors->first('sort_order') }}</div>
                        @endif
                    </div>

                    {{-- Vị trí --}}
                    <div class="mb-3">
                        <label for="position"><strong>Vị trí</strong></label>
                        <input type="text" name="position" id="position"
                            class="w-full border border-[rgb(246,81,119)] rounded-lg p-2"
                            value="{{ old('position') }}" placeholder="Ví dụ: home, sidebar, slideshow">
                        @if($errors->has('position'))
                            <div class="text-red-500 text-sm mt-1">{{ $errors->first('position') }}</div>
                        @endif
                    </div>

                    {{-- Trạng thái --}}
                    <div class="mb-3">
                        <label for="status"><strong>Trạng thái</strong></label>
                        <select name="status" id="status"
                            class="w-full border border-[rgb(246,81,119)] rounded-lg p-2">
                            <option value="1">Xuất bản</option>
                            <option value="0">Không xuất bản</option>
                        </select>
                        @if($errors->has('status'))
                            <div class="text-red-500 text-sm mt-1">{{ $errors->first('status') }}</div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </form>
</x-layout-admin>
