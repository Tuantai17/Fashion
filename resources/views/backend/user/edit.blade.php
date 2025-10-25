<x-layout-admin>
    <x-slot:title>Chỉnh Sửa Người Dùng</x-slot:title>

    <form action="{{ route('user.update', ['user' => $user->id]) }}" method="post" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="content-wrapper">
            <!-- Header -->
            <div class="mb-3 rounded-lg p-2">
                <div class="flex items-center justify-between">
                    <h2 class="text-xl font-bold text-[rgb(246,81,119)]">Chỉnh Sửa Người Dùng</h2>
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

            <!-- Form Body -->
            <div class="border border-[rgb(246,81,119)] rounded-lg p-3">
                <div class="flex gap-6">
                    <div class="basis-9/12">
                        <!-- Tên người dùng -->
                        <div class="mb-3">
                            <label for="name"><strong>Tên Người Dùng</strong></label>
                            <input value="{{ old('name', $user->name) }}" type="text" class="w-full border border-[rgb(246,81,119)] rounded-lg p-2" name="name" id="name" placeholder="Nhập Tên Người Dùng">
                            @if($errors->has('name')) 
                                <div class="text-red-500">{{ $errors->first('name') }}</div> 
                            @endif
                        </div>

                        <!-- Email -->
                        <div class="mb-3">
                            <label for="email"><strong>Email</strong></label>
                            <input value="{{ old('email', $user->email) }}" type="email" class="w-full border border-[rgb(246,81,119)] rounded-lg p-2" name="email" id="email" placeholder="Nhập Email">
                            @if($errors->has('email')) 
                                <div class="text-red-500">{{ $errors->first('email') }}</div> 
                            @endif
                        </div>

                        <!-- Mật khẩu -->
                        <div class="mb-3">
                            <label for="password"><strong>Mật Khẩu</strong></label>
                            <input type="password" class="w-full border border-[rgb(246,81,119)] rounded-lg p-2" name="password" id="password" placeholder="Nhập Mật Khẩu (nếu muốn thay đổi)">
                        </div>

                        <!-- Xác nhận mật khẩu -->
                        <div class="mb-3">
                            <label for="password_confirmation"><strong>Xác Nhận Mật Khẩu</strong></label>
                            <input type="password" class="w-full border border-[rgb(246,81,119)] rounded-lg p-2" name="password_confirmation" id="password_confirmation" placeholder="Xác Nhận Mật Khẩu">
                        </div>

                        <!-- Trạng thái -->
                        <div class="mb-3">
                            <label for="status"><strong>Trạng Thái</strong></label>
                            <select name="status" id="status" class="w-full border border-[rgb(246,81,119)] rounded-lg p-2">
                                <option value="1" {{ old('status', $user->status) == '1' ? 'selected' : '' }}>Kích Hoạt</option>
                                <option value="0" {{ old('status', $user->status) == '0' ? 'selected' : '' }}>Khóa</option>
                            </select>
                        </div>

                    </div>

                    <div class="basis-3/12">
                        <!-- Avatar -->
                        <div class="mb-3">
                            <label for="avatar"><strong>Ảnh Đại Diện</strong></label>
                            <input type="file" name="avatar" id="avatar" class="w-full border border-[rgb(246,81,119)] rounded-lg p-2">
                            @if($user->avatar)
                                <div class="mt-2 border border-[rgb(246,81,119)] p-2 rounded-lg inline-block">
                                    <img src="{{ asset('assets/images/user/' . $user->avatar) }}" class="w-32 h-32 object-cover rounded-lg">
                                </div>
                            @endif

                            @if($errors->has('avatar')) 
                                <div class="text-red-500">{{ $errors->first('avatar') }}</div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</x-layout-admin>
