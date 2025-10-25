<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Winky+Rough:ital,wght@0,300..900;1,300..900&display=swap" rel="stylesheet">

    <title>{{ $title ?? 'Trang quản trị' }}</title>
</head>

<body style="font-family: 'Winky Rough', sans-serif;"> 
    <!-- Header -->
    <header>
        <div class="flex">
            <div class="basis-2/12" style="background-color: rgb(249, 228, 228);">
                <h1 class="text-center font-bold font-semibold text-3xl text-[rgb(246,81,119)] h-12 leading-12">NV STORE</h1>
            </div>
            <div class="basis-10/12 h-12 flex items-center justify-end px-2" style="background-color: rgb(249, 228, 228);">
                <a href="#" class="mx-3 text-[rgb(246,81,119)] font-semibold flex flex-col items-center">
                    <i class="fa fa-user text-lg"></i>
                    <span class="text-sm">Nguyễn Quỳnh Thảo Vy</span>
                </a>
                <a href="{{ route('admin.logout') }}" class="mx-3 text-[rgb(246,81,119)] font-semibold flex flex-col items-center">
                    <i class="fa-solid fa-right-from-bracket text-lg"></i>
                    <span class="text-sm">Đăng xuất</span>
                </a>
            </div>
        </div>
        
    </header>

    <!-- Main -->
    <main style="background-color: rgb(249, 228, 228);">
        <div class="flex min-h-screen">
            <!-- Sidebar -->
            <div class="basis-2/12 p-2">
                <ul class="space-y-1 w-full">
                    <li><a class="block p-2 text-lg font-semibold text-[rgb(246,81,119)] hover:bg-gray-100 hover:shadow-lg hover:scale-105 rounded-lg" href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                    <li><a class="block p-2 text-lg font-semibold text-[rgb(246,81,119)] hover:bg-gray-100 hover:shadow-lg hover:scale-105 rounded-lg" href="{{ route('category.index') }}">Quản Lý Danh Mục</a></li>
                    <li><a class="block p-2 text-lg font-semibold text-[rgb(246,81,119)] hover:bg-gray-100 hover:shadow-lg hover:scale-105 rounded-lg" href="{{ route('product.index') }}">Quản Lý Sản Phẩm</a></li>
                    <li><a class="block p-2 text-lg font-semibold text-[rgb(246,81,119)] hover:bg-gray-100 hover:shadow-lg hover:scale-105 rounded-lg" href="{{ route('brand.index') }}">Quản Lý Thương Hiệu</a></li>
                    <li><a class="block p-2 text-lg font-semibold text-[rgb(246,81,119)] hover:bg-gray-100 hover:shadow-lg hover:scale-105 rounded-lg" href="{{ route('contact.index') }}">Quản Lý Liên hệ</a></li>
                    <li class="relative group">
                        <button id="toggleMenu3" class="w-full flex justify-between items-center p-2 text-lg font-semibold text-[rgb(246,81,119)] hover:bg-gray-100 hover:shadow-lg hover:scale-105 rounded-lg">
                            Giao diện
                            <svg class="w-5 h-5 ml-1" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </button>
                        <ul id="submenu3" class="hidden absolute left-0 top-full bg-white shadow-lg rounded-md w-full mt-1 border border-gray-200 z-10 group-hover:block">
                            <li><a href="{{ route('menu.index') }}" class="block px-4 py-2 hover:bg-gray-200 text-lg font-semibold text-[rgb(246,81,119)]">Menu</a></li>
                            <li><a href="{{ route('banner.index') }}" class="block px-4 py-2 hover:bg-gray-200 text-lg font-semibold text-[rgb(246,81,119)]">Banner</a></li>
                        </ul>
                    </li>
                    <li><a class="block p-2 text-lg font-semibold text-[rgb(246,81,119)] hover:bg-gray-100 hover:shadow-lg hover:scale-105 rounded-lg" href="{{ route('order.index') }}">Quản Lý Đơn hàng</a></li>
                    <li><a class="block p-2 text-lg font-semibold text-[rgb(246,81,119)] hover:bg-gray-100 hover:shadow-lg hover:scale-105 rounded-lg" href="{{ route('post.index') }}">Quản Lý Bài Viết</a></li>
                    <li><a class="block p-2 text-lg font-semibold text-[rgb(246,81,119)] hover:bg-gray-100 hover:shadow-lg hover:scale-105 rounded-lg" href="{{ route('topic.index') }}">Quản Lý Chủ Đề</a></li>
                    <li><a class="block p-2 text-lg font-semibold text-[rgb(246,81,119)] hover:bg-gray-100 hover:shadow-lg hover:scale-105 rounded-lg" href="{{ route('user.index') }}">Quản Lý Người Dùng</a></li>
                </ul>
            </div>

            <!-- Content -->
            <div class="basis-10/12 p-3">
                {{ $slot }}
            </div>
        </div>

        <!-- Script Toggle -->
        <script>
            document.addEventListener("click", (e) => {
                const menuButton = document.getElementById('toggleMenu3');
                const submenu = document.getElementById('submenu3');

                if (e.target.closest('#toggleMenu3')) {
                    submenu.classList.toggle('hidden');
                } else if (!e.target.closest('#submenu3')) {
                    submenu.classList.add('hidden');
                }
            });
        </script>
    </main>

    <!-- Footer -->
    <footer style="background-color: rgb(249, 228, 228);">
        <div class="py-3 text-center font-semibold text-[rgb(246,81,119)]">
            DESIGN: NGUYỄN QUỲNH THẢO VY
        </div>
    </footer>
        @include("backend.notifications")
    {{ $footer ?? '' }}
</body>

</html>
