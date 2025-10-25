@php
    $total = count($menu_list);
    $half = ceil($total / 2);
@endphp

<nav class="mainmenu bg-white text-center">
    <div class="container mx-auto px-2 md:px-4">
        <ul class="flex flex-wrap justify-center space-x-4">
            {{-- Nửa đầu (trước mục "Post") --}}
            @foreach ($menu_list->slice(0, 2) as $menu_item) {{-- Chỉ lấy 2 mục đầu tiên --}}
                <x-main-menu-item :menuitem="$menu_item" />
            @endforeach

            {{-- Mục Post ở vị trí thứ 3 --}}
            <li class="relative group border-b-3 border-transparent hover:border-[#c12e37]">
                
                {{-- Dropdown nếu có các bài viết con --}}
                <ul class="absolute left-0 top-full bg-white shadow-lg hidden group-hover:block z-10 min-w-[160px] rounded-md mt-1">
                    @foreach ($menu_list->where('name', 'Bài Viết')->first()->menu ?? [] as $child) {{-- Thêm các bài viết con --}}
                        <li class="border-b border-gray-100 last:border-b-0">
                            <a href="{{ $child->link }}"
                               class="block px-4 py-2 text-gray-700 hover:bg-gray-100 hover:text-[#f66] transition duration-200">
                                {{ $child->name }}
                            </a>
                        </li>
                    @endforeach
                </ul>
            </li>

            {{-- Nửa sau (sau mục "Post") --}}
            @foreach ($menu_list->slice(2) as $menu_item) {{-- Lấy các mục còn lại sau mục "Post" --}}
                <x-main-menu-item :menuitem="$menu_item" />
            @endforeach
        </ul>
    </div>
</nav>
