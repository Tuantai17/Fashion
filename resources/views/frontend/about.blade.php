<x-layout-site>
    <x-slot:title>Về chúng tôi</x-slot:title>

    <!-- resources/views/frontend/about.blade.php -->

    <main class="bg-[rgb(249,228,228)]">
        <div class=" mx-20 py-10 text-center">
            <h2 class="text-3xl font-semibold">Về NV Store</h2>
            
            <div class="mt-6">
                <p class="text-lg font-bold text-gray-600">Chúng tôi luôn đặt chất lượng sản phẩm và sự hài lòng của khách hàng lên hàng đầu.</p>
            </div>
            
           <!-- Nội dung và bản đồ cùng hàng -->
           <div class="mt-8 flex flex-col md:flex-row gap-8 justify-between">
                <!-- Nội dung -->
                <div class="flex-1">
                    <ul class="list-none pl-0">
                        <li class="text-xl font-bold mt-2 flex items-center">
                            <i class="fa-brands fa-cotton-bureau mr-2"></i> 
                            NV Store cung cấp thời trang cao cấp cho mọi lứa tuổi, cam kết chất lượng và phong cách.
                        </li>
                        <li class="text-xl font-bold mt-2 flex items-center">
                            <i class="fa-brands fa-cotton-bureau mr-2"></i> 
                            Mặt hàng đa dạng từ công sở, dạo phố đến thể thao, đảm bảo đáp ứng nhu cầu khách hàng.
                        </li>
                        <li class="text-xl font-bold mt-2 flex items-center">
                            <i class="fa-brands fa-cotton-bureau mr-2"></i> 
                            Chúng tôi cập nhật xu hướng quốc tế, mang đến bộ sưu tập mới và phong cách.
                        </li>
                        <li class="text-xl font-bold mt-2 flex items-center">
                            <i class="fa-brands fa-cotton-bureau mr-2"></i> 
                            Chúng tôi luôn nỗ lực nâng cao trải nghiệm và sự hài lòng của khách hàng.
                        </li>
                    </ul>
                    <!-- Địa chỉ và thông tin liên hệ -->
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
                </div>

                <!-- Google Maps -->
                <div class="flex-1">
                    <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3918.6289456283475!2d106.79075997467041!3d10.839681789313012!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x31752717e84fda57%3A0xefd79da9620eb9dd!2zMTgyIEzDoyBYdcOibiBPYWksIFTEg25nIE5oxqFuIFBow7ogQSwgVGjhu6cgxJDhu6ljLCBI4buTIENow60gTWluaCA3MDAwMDAsIFZp4buHdCBOYW0!5e0!3m2!1svi!2s!4v1745570436413!5m2!1svi!2s" 
                        width="100%" height="350" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade">
                    </iframe>
                </div>
            </div>



            <!-- Mạng xã hội -->
            <div class="mt-8">
                <h3 class="text-2xl font-semibold">Theo dõi chúng tôi trên mạng xã hội</h3>
                <div class="flex justify-center gap-6 mt-4">
                    <i class="fa-brands fa-facebook text-[rgb(246,81,119)] hover:text-[rgb(244,184,198)] transition-transform duration-300 text-2xl 
                        hover:scale-150 cursor-pointer"></i>
                    <i class="fab fa-instagram text-[rgb(246,81,119)] hover:text-[rgb(244,184,198)] transition-transform duration-300 text-2xl 
                        hover:scale-150 cursor-pointer"></i>
                    <i class="fa-brands fa-tiktok text-[rgb(246,81,119)] hover:text-[rgb(244,184,198)] transition-transform duration-300 text-2xl 
                        hover:scale-150 cursor-pointer"></i>
                </div>
            </div>
            
        </div>
    </main>
</x-layout-site>
