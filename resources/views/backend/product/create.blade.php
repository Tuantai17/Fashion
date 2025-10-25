<x-layout-admin>

<x-slot:title>
   Thêm Sản Phẩm
</x-slot:title>

<form action="{{ route('product.store') }}" method="post" enctype="multipart/form-data">
    @csrf
    <div class="content-wrapper">
        <div class="mb-3 rounded-lg p-2">
                <div class="flex items-center justify-between ">
                    <div class="">
                        <h2 class="text-xl font-bold text-[rgb(246,81,119)]">Thêm Sản Phẩm</h2>
                    </div>
                    <div class="text-right">
                        <button type="submit" class="px-2 py-2 cursor-pointer rounded-xl mx-1 text-[rgb(246,81,119)]">
                            <i class="fa fa-save" aria-hidden="true"></i>
                        </button>

                        <a href="{{ route ('product.index') }}" class="text-[rgb(246,81,119)] px-2 py-2 rounded-xl mx-1 font-semibold hover:text-[rgb(244,8,8)]">
                            <i class="fa fa-arrow-left" aria-hidden="true"></i>                     
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <div class="border border-[rgb(246,81,119)] rounded-lg p-3">
            <div class="flex gap-6">
                <div class="basic-9/12">
                    <div class="mb-3">
                        <label id="name">
                            <strong>Tên Sản Phẩm</strong>
                        </label>
                        <input value="{{old('name')}}" type="text" class="w-full border border-[rgb(246,81,119)] rounded-lg p-2" placeholder="Nhập Tên Sản Phẩm" name="name" id="name">
                        @if($errors->has('name'))
                            <div class="text-red-500">{{$errors->first('name')}}</div>
                        @endif
                    </div>
                    <div class="mb-3">
                        <label id="detail">
                            <strong>Chi Tiết Sản Phẩm</strong>
                        </label>
                        <textarea name="detail" id="detail" rows="4" class="w-full border border-[rgb(246,81,119)] rounded-lg p-2">{{old('detail')}}</textarea>
                        @if($errors->has('detail'))
                            <div class="text-red-500">{{$errors->first('detail')}}</div>
                        @endif
                    </div>
                    <div class="mb-3">
                        <label id="description">
                            <strong>Mô Tả</strong>
                        </label>
                        <textarea name="description" id="description" class="w-full border border-[rgb(246,81,119)] rounded-lg p-2">{{old('description')}}</textarea>
                    </div>
                    <div class="flex justify-between gap-5">
                        <div class="mb-3">
                            <label id="price-root">
                                <strong>Giá Bán</strong>
                            </label>
                            <input value="{{old('price_root')}}" type="number" class="w-full border border-[rgb(246,81,119)] rounded-lg p-2" placeholder="Giá Bán" name="price_root" id="price-root">
                            @if($errors->has('price_root'))
                                <div class="text-red-500">{{$errors->first('price_root')}}</div>
                            @endif
                        </div>
                        <div class="mb-3">
                            <label id="price_sale">
                                <strong>Giá Khuyến Mãi</strong>
                            </label>
                            <input value="{{old('price_sale')}}" type="number" class="w-full border border-[rgb(246,81,119)] rounded-lg p-2" placeholder="Giá Khuyến Mãi" name="price_sale" id="price_sale">
                            @if($errors->has('price_sale'))
                                <div class="text-red-500">{{$errors->first('price_sale')}}</div>
                            @endif
                        </div>
                        <div class="mb-3">
                            <label id="qty">
                                <strong>Số Lượng</strong>
                            </label>
                            <input type="number" class="w-full border border-[rgb(246,81,119)] rounded-lg p-2" value="{{old('qty')}}" name="qty" min="1" id="qty">
                        </div>
                    </div>
                </div>
                <div class="basic-3/12">
                    <div class="mb-3">
                        <label id="category_id">
                            <strong>Danh Mục</strong>
                        </label>
                        <select name="category_id" id="category_id" class="w-full border border-[rgb(246,81,119)] rounded-lg p-2">
                            <option value="">Chọn Danh Mục</option>
                            @foreach($list_category as $category)
                                @if($category->id == old('category_id'))
                                    <option selected value="{{$category->id}}">{{$category->name}}</option>
                                @else
                                    <option value="{{$category->id}}">{{$category->name}}</option>
                                @endif
                            @endforeach
                        </select>
                        @if($errors->has('category_id'))
                            <div class="text-red-500">{{$errors->first('category_id')}}</div>
                        @endif
                    </div>
                    <div class="mb-3">
                        <label id="brand_id">
                            <strong>Thương Hiệu</strong>
                        </label>
                        <select name="brand_id" id="brand_id" class="w-full border border-[rgb(246,81,119)] rounded-lg p-2">
                            <option value="">Chọn Thương Hiệu</option>
                            @foreach($list_brand as $brand)
                                @if($brand->id == old('brand_id'))
                                    <option selected value="{{$brand->id}}">{{$brand->name}}</option>
                                @else
                                    <option value="{{$brand->id}}">{{$brand->name}}</option>
                                @endif
                            @endforeach
                        </select>
                        @if($errors->has('brand_id'))
                            <div class="text-red-500">{{$errors->first('brand_id')}}</div>
                        @endif
                    </div>
                    <div class="mb-3">
                        <label id="thumbnail">
                            <strong>Hình</strong>
                        </label>
                        <input type="file" class="w-full border border-[rgb(246,81,119)] rounded-lg p-2" name="thumbnail" id="thumbnail">
                        @if($errors->has('thumbnail'))
                            <div class="text-red-500">{{$errors->first('thumbnail')}}</div>
                        @endif
                    </div>
                <div class="mb-3">
                    <label id="status">
                        <strong>Trạng Thái</strong>
                    </label>
                    <select name="status" id="status" class="w-full border border-[rgb(246,81,119)] rounded-lg p-2">
                        <option value="1" {{ old('status') == '1' ? 'selected' : '' }}>Xuất Bản</option>
                        <option value="0" {{ old('status') == '0' ? 'selected' : '' }}>Không Xuất Bản</option>
                    </select>
                </div>
            </div>
        </div>
    </form>


</x-layout-admin>
