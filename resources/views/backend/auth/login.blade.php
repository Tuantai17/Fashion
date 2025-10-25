<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.1.4/toastr.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.1.4/toastr.css" />

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <title>LOGIN</title>
</head>
<body class="bg-pink-100 flex items-center justify-center min-h-screen">

    <form action="{{ route('admin.dologin') }}" method="post" class="bg-white shadow-lg rounded-xl p-8 w-full max-w-md">
        @csrf 

        <h2 class="text-3xl font-bold text-center text-pink-600 mb-6">Đăng nhập</h2>

        <div class="mb-4">
            <label for="username" class="block text-sm font-semibold text-gray-700 mb-1">Tên đăng nhập</label>
            <input type="text" name="username" id="username"
                value="{{ old('username') }}"
                placeholder="Tên đăng nhập hoặc email"
                class="w-full px-4 py-2 border border-pink-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-pink-400">
        </div>

        <div class="mb-6">
            <label for="password" class="block text-sm font-semibold text-gray-700 mb-1">Mật khẩu</label>
            <input type="password" name="password" id="password"
                placeholder="Mật khẩu"
                class="w-full px-4 py-2 border border-pink-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-pink-400">
        </div>

        <button type="submit"
            class="w-full py-2 px-4 bg-pink-500 text-white font-semibold rounded-lg hover:bg-pink-600 transition duration-300 ease-in-out">
            Đăng nhập
        </button>

        @include("backend.notifications")
    </form>

</body>
</html>
