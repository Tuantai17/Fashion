<x-layout-site>
    <x-slot:title>Đăng ký</x-slot:title>

    <main class="max-w-md mx-auto mt-10 pt-40 pb-40">
        <h2 class="text-2xl font-bold mb-4">Đăng ký tài khoản</h2>

        {{-- Hiển thị thông báo lỗi --}}
        @if (session('error'))
            <div 
                x-data="{ show: true }" 
                x-init="setTimeout(() => show = false, 5000)" 
                x-show="show"
                x-transition
                class="bg-red-100 text-red-700 px-4 py-2 rounded mb-4"
            >
                {{ session('error') }}
            </div>
        @endif

        {{-- Hiển thị thông báo thành công --}}
        @if (session('success'))
            <div 
                x-data="{ show: true }" 
                x-init="setTimeout(() => show = false, 5000)" 
                x-show="show"
                x-transition
                class="bg-green-100 text-green-700 px-4 py-2 rounded mb-4"
            >
                {{ session('success') }}
            </div>
        @endif

        <form action="{{ route('user.register') }}" method="POST" enctype="multipart/form-data" class="bg-white shadow-md rounded px-8 py-6 space-y-4">
            @csrf

            {{-- Họ và tên --}}
            <input type="text" name="name" placeholder="Họ và tên" class="w-full p-2 border rounded" value="{{ old('name') }}" required>
            @error('name') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror

            {{-- Tên đăng nhập --}}
            <input type="text" name="username" placeholder="Tên đăng nhập" class="w-full p-2 border rounded" value="{{ old('username') }}" required>
            @error('username') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror

            {{-- Email --}}
            <input type="email" name="email" placeholder="Email" class="w-full p-2 border rounded" value="{{ old('email') }}" required>
            @error('email') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror

            {{-- Mật khẩu --}}
            <input type="password" name="password" placeholder="Mật khẩu" class="w-full p-2 border rounded" required>
            @error('password') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror

            {{-- Nhập lại mật khẩu --}}
            <input type="password" name="password_confirmation" placeholder="Nhập lại mật khẩu" class="w-full p-2 border rounded" required>

            {{-- Số điện thoại --}}
            <input type="text" name="phone" placeholder="Số điện thoại" class="w-full p-2 border rounded" value="{{ old('phone') }}" required>
            @error('phone') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror

            {{-- Địa chỉ --}}
            <input type="text" name="address" placeholder="Địa chỉ" class="w-full p-2 border rounded" value="{{ old('address') }}" required>
            @error('address') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror

            {{-- Ảnh đại diện --}}
            <input type="file" name="avatar" class="w-full p-2 border rounded" accept="image/*" required>
            @error('avatar') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror

            <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700 w-full">
                Đăng ký
            </button>
        </form>
    </main>
</x-layout-site>
