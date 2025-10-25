<x-layout-admin>

<x-slot:title>
   Thêm Người Dùng
</x-slot:title>

<form action="{{ route('user.store') }}" method="post" enctype="multipart/form-data">
    @csrf
    <div class="content-wrapper">
        <div class="mb-3 rounded-lg p-2">
            <div class="flex items-center justify-between">
                <div>
                    <h2 class="text-xl font-bold text-[rgb(246,81,119)]">Thêm Người Dùng</h2>
                </div>
                <div class="text-right">
                    <button type="submit" class="px-2 py-2 cursor-pointer rounded-xl mx-1 text-[rgb(246,81,119)]">
                        <i class="fa fa-save" aria-hidden="true"></i>
                    </button>
                    <a href="{{ route('user.index') }}" class="text-[rgb(246,81,119)] px-2 py-2 rounded-xl mx-1 font-semibold hover:text-[rgb(244,8,8)]">
                        <i class="fa fa-arrow-left" aria-hidden="true"></i>                     
                    </a>
                </div>
            </div>
        </div>

        <div class="border border-[rgb(246,81,119)] rounded-lg p-3">
            <div class="flex gap-6">
                <div class="basic-9/12">
                    <div class="mb-3">
                        <label for="name"><strong>Họ và Tên</strong></label>
                        <input type="text" name="name" id="name" value="{{ old('name') }}"
                            class="w-full border border-[rgb(246,81,119)] rounded-lg p-2" placeholder="Nhập họ tên">
                        @error('name')
                            <div class="text-red-500">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="email"><strong>Email</strong></label>
                        <input type="email" name="email" id="email" value="{{ old('email') }}"
                            class="w-full border border-[rgb(246,81,119)] rounded-lg p-2" placeholder="Nhập email">
                        @error('email')
                            <div class="text-red-500">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="password"><strong>Mật khẩu</strong></label>
                        <input type="password" name="password" id="password"
                            class="w-full border border-[rgb(246,81,119)] rounded-lg p-2" placeholder="Nhập mật khẩu">
                        @error('password')
                            <div class="text-red-500">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="basic-3/12">
                    <div class="mb-3">
                        <label for="avatar"><strong>Ảnh Đại Diện</strong></label>
                        <input type="file" name="avatar" id="avatar"
                            class="w-full border border-[rgb(246,81,119)] rounded-lg p-2">
                        @error('avatar')
                            <div class="text-red-500">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="roles"><strong>Vai Trò</strong></label>
                        <select name="roles" id="roles" class="w-full border border-[rgb(246,81,119)] rounded-lg p-2">
                            <option value="">-- Chọn Vai Trò --</option>
                            <option value="admin" {{ old('roles') == 'admin' ? 'selected' : '' }}>Admin</option>
                            <option value="user" {{ old('roles') == 'user' ? 'selected' : '' }}>Người Dùng</option>
                        </select>
                        @error('roles')
                            <div class="text-red-500">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="status"><strong>Trạng Thái</strong></label>
                        <select name="status" id="status" class="w-full border border-[rgb(246,81,119)] rounded-lg p-2">
                            <option value="1" {{ old('status') == '1' ? 'selected' : '' }}>Hoạt động</option>
                            <option value="0" {{ old('status') == '0' ? 'selected' : '' }}>Tạm khóa</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>

</x-layout-admin>
