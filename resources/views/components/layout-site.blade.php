<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>{{ $title ?? 'Shop NV'}}</title>
        
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" >
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Winky+Rough:ital,wght@0,300..900;1,300..900&display=swap" rel="stylesheet">
        
        {{ $header ?? ''}}
        
    </head>

    

    <body style="font-family: 'Winky Rough', sans-serif; background-color: rgb(249, 228, 228); color:rgb(246, 81, 119)">
        <header class="bg-white">
            <div class="container mx-auto px-8 py-4">
                <div class="flex items-center">
                    <!-- Logo -->
                    <div class="md:basis-3/12 basis-3/12 py-2">
                        <a href="#">
                            <img src="{{ asset('assets/images/logo.jpg') }}" class="w-50" alt="Logo">
                        </a>
                    </div>

<!-- Khung tìm kiếm -->
<div class="md:basis-6/12 basis-full">
    <form action="{{ route('site.product.search') }}" method="GET" class="relative w-full">
        <input type="search" name="keyword" placeholder="Từ khóa..."
            class="rounded-full bg-[rgb(249,228,228)] px-5 py-2 w-full pr-12 
            placeholder:text-[rgb(246,81,119)] text-gray-800 
            transition-all duration-300 focus:ring-2 focus:ring-[rgb(246,81,119)] 
            focus:outline-none hover:ring-2 hover:ring-[rgb(246,81,119)] hover:scale-105 shadow-md" />
        
        <!-- Nút tìm kiếm -->
        <button type="submit" 
            class="absolute right-3 top-1/2 transform -translate-y-1/2 p-2 
            transition-all duration-300 hover:scale-125">
            <i class="fa-solid fa-magnifying-glass text-[rgb(246,81,119)] text-lg 
                hover:text-[rgb(244,8,8)] transition-all duration-300"></i>
        </button>
    </form>
</div>

                    <!-- Biểu tượng bên phải -->
<div class="md:basis-3/12 basis-8/12 ml-20">
    <div class="grid grid-cols-3 gap-4 justify-items-center items-start">
        <!-- Yêu thích -->
        <div class="flex flex-col items-center text-center transition-all duration-300 hover:scale-110 p-2">
            <div class="w-10 h-10 flex items-center justify-center">
                <i class="fa-regular fa-heart text-[rgb(246,81,119)] text-[20px] group-hover:text-[rgb(244,8,8)] transition-all duration-300"></i>
            </div>
            <span class="mt-1 text-[rgb(246,81,119)] font-bold group-hover:text-[rgb(244,8,8)] text-sm">Yêu Thích</span>
        </div>

        <!-- Tài khoản -->
        <div class="relative flex flex-col items-center text-center transition-all duration-300 hover:scale-110 p-2">
            <div onclick="toggleAccountInfo()" class="cursor-pointer">
                <div class="w-10 h-10 flex items-center justify-center">
                    <i class="fa fa-user text-green-600 text-[20px] group-hover:text-green-800 transition-all duration-300"></i>
                </div>
                <span class="mt-1 text-green-600 font-bold group-hover:text-green-800 text-sm">
                    {{ Auth::check() ? Auth::user()->name : 'Tài khoản' }}
                </span>
            </div>

            <!-- Dropdown thông tin tài khoản -->
            <div id="accountInfo"
                class="absolute mt-12 w-72 bg-white border border-gray-200 rounded-xl shadow-xl hidden p-4 text-sm z-50">
                @auth
                    <div class="mb-3 text-gray-800">
                        <div class="font-semibold text-base mb-1 border-b pb-1">👤 Thông tin tài khoản</div>
                        <p class="py-1"><strong>Tên:</strong> {{ Auth::user()->name }}</p>
                        <p class="py-1"><strong>Email:</strong> {{ Auth::user()->email }}</p>
                    </div>

                    <div class="flex flex-col space-y-2">
                        <a href="{{ route('user.account') }}"
                        class="text-blue-600 hover:text-blue-800 px-3 py-1 rounded-md hover:bg-blue-50 transition-all duration-200">
                            📄 Xem chi tiết tài khoản
                        </a>
                        <a href="#" onclick="logoutUser()"
                        class="text-red-600 hover:text-red-800 px-3 py-1 rounded-md hover:bg-red-50 transition-all duration-200">
                            🚪 Đăng xuất
                        </a>
                    </div>

                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">
                        @csrf
                    </form>
                @else
                    <div class="flex flex-col space-y-2">
                        <a href="{{ route('site.loginuser') }}"
                        class="text-green-600 hover:text-green-800 px-3 py-1 rounded-md hover:bg-green-50 transition-all duration-200">
                            🔐 Đăng nhập
                        </a>
                        <a href="{{ route('user.register.form') }}"
                        class="text-green-600 hover:text-green-800 px-3 py-1 rounded-md hover:bg-green-50 transition-all duration-200">
                            📝 Đăng ký
                        </a>
                    </div>
                @endauth
            </div>

        </div>

        <!-- Giỏ hàng -->
        <div class="flex flex-col items-center text-center transition-all duration-300 hover:scale-110 p-2">
            <a href="{{ route('site.cart') }}">
                <div class="w-10 h-10 flex items-center justify-center">
                    <i class="fa fa-shopping-cart text-pink-500 text-[20px] group-hover:text-pink-700 transition-all duration-300"></i>
                </div>
                <span class="mt-1 text-pink-500 font-bold group-hover:text-pink-700 text-sm">
                    Giỏ Hàng
                </span>
            </a>
        </div>
    </div>
</div>








 





            <style>
                @keyframes fade-in {
                    from {
                        opacity: 0;
                        transform: translateY(-5px);
                    }

                    to {
                        opacity: 1;
                        transform: translateY(0);
                    }
                }

                .animate-fade-in {
                    animation: fade-in 0.2s ease-out;
                }
            </style>

            <script>
                function toggleAccountInfo() {
const dropdown = document.getElementById('accountInfo');
                    dropdown.classList.toggle('hidden');
                }

                function logoutUser() {
                    document.getElementById('logout-form').submit();
                }

                document.addEventListener('click', function(event) {
                    const dropdown = document.getElementById('accountInfo');
                    const button = document.querySelector('button[onclick="toggleAccountInfo()"]');
                    if (!dropdown.contains(event.target) && !button.contains(event.target)) {
                        dropdown.classList.add('hidden');
                    }
                });
            </script>
        </header>


    

    <x-main-menu/>
        



        {{ $slot }}

        <footer class="bg-gradient-to-b from-white to-gray-100 py-8 font-bold text-left text-[rgb(246,81,119)]">
            <div class="max-w-6xl mx-auto px-6">
                <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-5 gap-6">
                    <!-- Logo thương hiệu (col-span-2) -->
                    <div class="col-span-2">
                        <img src="{{ asset('assets/images/logo.jpg') }}" class="w-30 h-30 max-w-screen-xl h-auto object-cover flex-shrink-0 rounded-2xl " alt="Footer">
                        <p class="text-sm font-semibold text-left text-[rgb(246,81,119)]"><i class="fa-brands fa-cotton-bureau"></i> Thương hiệu thời trang NV nổi bật với phong cách thiết kế trẻ trung, năng động và đầy cá tính. 
                            <br><i class="fa-brands fa-cotton-bureau"></i> Với tiêu chí mang đến sự thoải mái và tự tin cho khách hàng, NV luôn chú trọng đến chất lượng sản phẩm và sự sáng tạo trong từng chi tiết. 
                            <br><i class="fa-brands fa-cotton-bureau"></i> Những bộ sưu tập của NV không chỉ bắt kịp xu hướng mà còn phản ánh tinh thần hiện đại và thời thượng.
                        </p>
                    </div>

                    <!-- Chính sách -->
                    <div class="col-span-1">
                        <h3 class="text-lg font-semibold font-bold text-left text-[rgb(246,81,119)] mb-3">CHÍNH SÁCH <i class="fa-solid fa-file-alt"></i></h3>
                        <ul class="space-y-2 text-sm text-left font-semibold text-[rgb(246,81,119)]">
                            <li> <i class="fa-brands fa-cotton-bureau"></i> Chính sách thành viên</li>
                            <li> <i class="fa-brands fa-cotton-bureau"></i> Chính sách thanh toán</li>
                            <li> <i class="fa-brands fa-cotton-bureau"></i> Hướng dẫn mua hàng</li>
                            <li> <i class="fa-brands fa-cotton-bureau"></i> Quà tặng tri ân</li>
                            <li> <i class="fa-brands fa-cotton-bureau"></i> Bảo mật thông tin cá nhân</li>
                        </ul>
                    </div>

                    <!-- Thông tin chung -->
                    <div class="col-span-1">
                        <h3 class="text-lg font-semibold font-bold text-left text-[rgb(246,81,119)] mb-3">THÔNG TIN <i class="fa-solid fa-store"></i></h3>
                        <p class="text-sm font-semibold text-left text-[rgb(246,81,119)]">Địa chỉ: 182, Lã Xuân Oai, Phường Tăng Nhơn Phú A, TP.THỦ ĐỨC, TP.HCM</p>
                        <p class="text-sm font-semibold text-left text-[rgb(246,81,119)]">Điện thoại: 19006750</p>
                        <p class="text-sm font-semibold text-left text-[rgb(246,81,119)]">Email: nvstore@gmal.com</p>
                    </div>

                    <!-- Hỗ trợ -->
                    <div class="col-span-1">
                        <h3 class="text-lg font-semibold font-bold text-left text-[rgb(246,81,119)] mb-3">HỖ TRỢ <i class="fa-solid fa-headset"></i></h3>
                        <p class="text-sm font-semibold text-left text-[rgb(246,81,119)]">Mua Online (08:00 - 21:00): 19006750</p>
                        <p class="text-sm font-semibold text-left text-[rgb(246,81,119)]">Góp ý & Khiếu nại (08:30 - 20:30): 19006750</p>
                    </div>
                    

                </div>
                <p class="text-base text-center text-[rgb(246,81,119)] mt-2">© 2005. NV Store. Nguyễn Quỳnh Thảo Vy.</p>

                <div class="pt-5">
                    <div class="flex space-x-3 justify-center">
                        <i class="fa-brands fa-facebook text-[rgb(246,81,119)] hover:text-[rgb(244,184,198)] transition-transform duration-300 text-2xl 
                            hover:scale-150 cursor-pointer"></i>
                        <i class="fab fa-instagram text-[rgb(246,81,119)] hover:text-[rgb(244,184,198)] transition-transform duration-300 text-2xl 
                            hover:scale-150 cursor-pointer"></i>
                        <i class="fa-brands fa-tiktok text-[rgb(246,81,119)] hover:text-[rgb(244,184,198)] transition-transform duration-300 text-2xl 
                            hover:scale-150 cursor-pointer"></i>
                    </div>
                </div>



            </div>

        </footer>
        {{ $footer ?? '' }}

    </body>
</html>
