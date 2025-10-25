<!-- resources/views/frontend/login.blade.php -->
<x-layout-site>
    <x-slot:title>Đăng nhập</x-slot:title>

    <main class="max-w-md mx-auto mt-10">
        <h2 class="text-2xl font-bold mb-4">Đăng nhập vào tài khoản</h2>

        @if (session('error'))
            <div class="bg-red-100 text-red-700 px-4 py-2 rounded mb-4">
                {{ session('error') }}
            </div>
        @endif

        <form action="{{ route('site.dologinuser') }}" method="POST" class="bg-white shadow-md rounded px-8 py-6 space-y-4">
            @csrf
            <input type="email" name="email" placeholder="Email" class="w-full p-2 border rounded" required>
            <input type="password" name="password" placeholder="Mật khẩu" class="w-full p-2 border rounded" required>
            <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700 w-full">
                Đăng nhập
            </button>
        </form>
    </main>
</x-layout-site>
