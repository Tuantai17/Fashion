<div class="mb-6">
    <h2 class="text-red-600 font-bold mb-2">THƯƠNG HIỆU</h2>
    <ul class="space-y-1 text-sm">
        @foreach ($brand_list as $brand)
            <a href="{{ route('site.by-brand', ['slug' => $brand->slug]) }}"
                   class="flex items-center space-x-4 p-3 rounded-lg bg-white shadow-sm hover:bg-pink-100 transition duration-300 ease-in-out transform hover:scale-[1.02]">
                    @if($brand->image)
                        <img src="{{ asset('assets/images/brand/' . $brand->image) }}"
                             alt="{{ $brand->name }}"
                             class="w-12 h-12 rounded-full object-cover shadow-md transition duration-300 ease-in-out hover:scale-110">
                    @else
                        <div class="w-12 h-12 rounded-full bg-gray-300 flex items-center justify-center text-white">
                            <i class="fa fa-image"></i>
                        </div>
                    @endif
                    <span class="text-lg font-medium text-gray-800 hover:text-pink-600 transition duration-200">
                        {{ $brand->name }}
                    </span>
                </a>
        @endforeach

    </ul>
</div>