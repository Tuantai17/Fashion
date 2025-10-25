<div class="mb-5">
    <h3 class="text-[#1c2e3f] font-bold uppercase text-2xl mb-4">Danh mục</h3>
    <ul class="space-y-3">
        @foreach($category_list as $category)
            <li>
                <a href="{{ route('site.by-category', ['slug' => $category->slug]) }}"
                   class="flex items-center space-x-4 p-3 rounded-lg bg-white shadow-sm hover:bg-pink-100 transition duration-300 ease-in-out transform hover:scale-[1.02]">
                    @if($category->image)
                        <img src="{{ asset('assets/images/category/' . $category->image) }}"
                             alt="{{ $category->name }}"
                             class="w-12 h-12 rounded-full object-cover shadow-md transition duration-300 ease-in-out hover:scale-110">
                    @else
                        <div class="w-12 h-12 rounded-full bg-gray-300 flex items-center justify-center text-white">
                            <i class="fa fa-image"></i>
                        </div>
                    @endif
                    <span class="text-lg font-medium text-gray-800 hover:text-pink-600 transition duration-200">
                        {{ $category->name }}
                    </span>
                </a>
            </li>
        @endforeach
    </ul>
</div>
