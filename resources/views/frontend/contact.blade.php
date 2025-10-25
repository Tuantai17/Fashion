<x-layout-site>
    <x-slot:title>
        Trang Liên Hệ
    </x-slot:title>
        <main class="bg-[rgb(249,228,228)]">
            <div class="max-w-4xl mx-auto py-10 text-center">
                <h2 class="text-3xl font-semibold">Thông Tin Liên Hệ Store</h2>
                <p class="text-gray-600 mt-2">Chúng tôi vinh hạnh vì đã có cơ hội đồng hành với hơn 10.000 khách hàng trên khắp thế giới.</p>
                
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mt-6">
                    <div class="bg-white p-6 rounded-lg shadow transition-transform transform hover:scale-105">
                        <div class="text-red-500 text-3xl">📍</div>
                        <h3 class="font-semibold mt-2">Địa chỉ</h3>
                        <p class="text-gray-600">182, Lã Xuân Oai, Tăng Nhơn Phú A, TP Thủ Đức, TPHCM</p>
                    </div>
                    <div class="bg-white p-6 rounded-lg shadow transition-transform transform hover:scale-105">
                        <div class="text-red-500 text-3xl">✉️</div>
                        <h3 class="font-semibold mt-2">Email</h3>
                        <p class="text-gray-600">nvstore@gmail.com</p>
                    </div>
                    <div class="bg-white p-6 rounded-lg shadow transition-transform transform hover:scale-105">
                        <div class="text-red-500 text-3xl">📞</div>
                        <h3 class="font-semibold mt-2">Hotline</h3>
                        <p class="text-gray-600">1900 6750</p>
                    </div>
                </div>
                
                <!-- Google Maps -->
                <div class="flex-1">
                    <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3918.6289456283475!2d106.79075997467041!3d10.839681789313012!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x31752717e84fda57%3A0xefd79da9620eb9dd!2zMTgyIEzDoyBYdcOibiBPYWksIFTEg25nIE5oxqFuIFBow7ogQSwgVGjhu6cgxJDhu6ljLCBI4buTIENow60gTWluaCA3MDAwMDAsIFZp4buHdCBOYW0!5e0!3m2!1svi!2s!4v1745570436413!5m2!1svi!2s" 
                        width="100%" height="350" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade">
                    </iframe>
                </div>
                
                <div class="mt-8 bg-white p-6 rounded-lg shadow transition-transform transform hover:scale-105">
                <div class="mt-8 bg-white p-6 rounded-lg shadow transition-transform transform hover:scale-105">
                <h3 class="text-xl font-semibold">Vui Lòng Nhập Thông Tin Khách Hàng</h3>
                <form class="mt-4 grid grid-cols-1 gap-4" id="contactForm">
                    <input type="text" id="name" placeholder="Họ và tên *" required 
                        class="p-3 border rounded w-full transition-transform transform hover:scale-105">
                    
                    <input type="tel" id="phone" placeholder="Số điện thoại *" required 
                        class="p-3 border rounded w-full transition-transform transform hover:scale-105">
                    <p id="phoneError" class="text-red-500 text-sm hidden">Số điện thoại phải bắt đầu bằng 0 và có 10 số.</p>

                    <input type="email" id="email" placeholder="Email *" required 
                        class="p-3 border rounded w-full transition-transform transform hover:scale-105">
                    <p id="emailError" class="text-red-500 text-sm hidden">Email không hợp lệ.</p>

                    <input type="text" id="address" placeholder="Địa chỉ" 
                        class="p-3 border rounded w-full transition-transform transform hover:scale-105">
                    
                    <div class="relative">
                        <input type="password" id="password" placeholder="Mật khẩu" 
                            class="p-3 border rounded w-full transition-transform transform hover:scale-105">
                        <button type="button" onclick="togglePassword()" 
                            class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-500 hover:text-gray-800">
                            👁️
                        </button>
                    </div>

                    <button type="submit" 
                        class="bg-[rgb(244,184,198)] text-[rgb(246,81,119)] py-2 rounded text-lg font-semibold transition-transform transform hover:scale-110 hover:bg-[rgb(246,81,119)] hover:text-white">
                        Gửi thông tin
                    </button>
                </form>
            </div>

            <script>
                document.getElementById("contactForm").addEventListener("submit", function(event) {
                    let isValid = true;
                    let phone = document.getElementById("phone").value;
                    let email = document.getElementById("email").value;
                    let phoneError = document.getElementById("phoneError");
                    let emailError = document.getElementById("emailError");

                    // Kiểm tra số điện thoại (bắt đầu bằng 0 và có đúng 10 số)
                    if (!/^0\d{9}$/.test(phone)) {
                        phoneError.classList.remove("hidden");
                        isValid = false;
                    } else {
                        phoneError.classList.add("hidden");
                    }

                    // Kiểm tra email (đúng định dạng)
                    if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email)) {
                        emailError.classList.remove("hidden");
                        isValid = false;
                    } else {
                        emailError.classList.add("hidden");
                    }

                    if (!isValid) {
                        event.preventDefault();
                    }
                });

                function togglePassword() {
                    let passwordField = document.getElementById("password");
                    passwordField.type = passwordField.type === "password" ? "text" : "password";
                }
            </script>
        </main>

</x-layout-site>