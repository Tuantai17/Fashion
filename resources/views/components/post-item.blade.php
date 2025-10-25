<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
    @foreach($relatedPosts as $post)
        <div class="group relative overflow-hidden rounded-xl shadow-lg transition-all duration-300 hover:shadow-2xl hover:-translate-y-1">
            <a href="{{ route('site.post.detail', ['slug' => $post->slug]) }}">
                <img 
                    src="{{ asset('assets/images/post/' . $post->thumbnail) }}" 
                    alt="{{ $post->title }}" 
                    class="w-full h-100 object-cover transition-transform duration-500 group-hover:scale-105"
                >

                {{-- Đã xóa lớp nền đen mờ ở đây --}}

                <div class="p-4 bg-white">
                    <h2 class="text-lg font-bold text-gray-800 group-hover:text-[rgb(246,81,119)] transition duration-300">
                        {{ $post->title }}
                    </h2>
                    <p class="text-sm text-gray-600 mt-2 line-clamp-3">
                        {{ $post->description }}
                    </p>
                    <div class="mt-3">
                        <span class="inline-block text-sm text-[rgb(246,81,119)] font-semibold">Xem thêm →</span>
                    </div>
                </div>
            </a>
        </div>
    @endforeach
</div>
