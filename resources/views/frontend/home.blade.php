<x-layout-site>
    <x-slot:title>
        Trang Chủ
    </x-slot:title>


    <main>
        <!--Banner-->
        <div x-data="{ active: 0, showSlider: false }" x-init="setInterval(() => { if (showSlider) active = (active + 1) % 3 }, 3000)" class="relative w-full overflow-hidden">

            <!-- Video -->
            {{-- <video 
                x-show="!showSlider"
                @ended="showSlider = true"
                class="w-full h-250 object-cover transition-opacity duration-1000"
                autoplay 
                muted 
                playsinline
            >
                <source src="{{ asset('assets/videos/banner.mp4') }}" type="video/mp4">
                Trình duyệt của bạn không hỗ trợ video.
            </video> --}}

            <!-- Slider -->
            <div x-show="showSlider" x-transition:enter="transition-opacity duration-1000"
                x-transition:leave="transition-opacity duration-1000" class="relative w-full overflow-hidden">

                <div class="flex w-[300%] transition-transform duration-1000 ease-in-out"
                    :style="'transform: translateX(-' + (active * 33.3333) + '%);'">
                    <img src="{{ asset('assets/images/banner1.jpg') }}" class="w-1/3 h-full object-cover flex-shrink-0"
                        alt="banner1">
                    <img src="{{ asset('assets/images/banner2.jpg') }}" class="w-1/3 h-full object-cover flex-shrink-0"
                        alt="banner2">
                    <img src="{{ asset('assets/images/banner3.jpg') }}" class="w-1/3 h-full object-cover flex-shrink-0"
                        alt="banner3">
                </div>
            </div>

            <!-- Dots navigation -->
            <div class="absolute bottom-4 left-1/2 transform -translate-x-1/2 flex space-x-2">
                <template x-for="index in 3" :key="index">
                    <div @click="active = index - 1"
                        :class="{
                            'bg-[rgb(246,81,119)]': active === index - 1,
                            'bg-[rgb(244,184,198)]': active !== index - 1
                        }"
                        class="w-3 h-3 rounded-full cursor-pointer transition-colors duration-300"></div>
                </template>
            </div>

        </div>

        <!-- AlpineJS -->
        <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>






        <!-- Component Danh mục -->
        <div class="flex gap-4">
            <!-- DANH MỤC NỔI BẬT - Bên trái -->
            <div class="w-1/2">
                <x-category-list />
            </div>

            <!-- THƯƠNG HIỆU - Bên phải -->
            <div class="w-1/2">
                <x-brand-list />
            </div>
        </div>


        <x-product-new />
        <x-product-sale />



        {{-- Hiển thị danh sách post mới --}}
        @foreach ($posts as $post)
            <x-post-item :postitem="$post" />
        @endforeach







        </div>
        </div>


    </main>

</x-layout-site>
