<x-layout-site>
<div class="container mx-auto px-4 py-8">
    <h1 class="text-3xl font-bold mb-6 text-[rgb(246,81,119)]">Tất cả bài viết</h1>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach($posts as $post)
        <div class="bg-white p-5 rounded-2xl shadow-md hover:shadow-xl transition-all duration-300 flex flex-col min-h-[460px]">
            <a href="{{ route('site.post.detail' , ['slug' => $post->slug]) }}">
                <img 
                    src="{{ asset('assets/images/post/' . $post->thumbnail) }}" 
                    alt="{{ $post->title }}" 
                    class="w-full h-100 object-cover rounded-xl mb-4 transition-transform duration-300 hover:scale-105"
                >
                <h2 class="text-lg font-semibold text-gray-800 mb-2 hover:text-[rgb(246,81,119)] transition">
                    {{ $post->title }}
                </h2>
                <p class="text-gray-600 text-sm mb-4">{{ Str::limit($post->description, 100) }}</p>
            </a>

            <a href="{{ route('site.post.detail' , ['slug' => $post->slug]) }}"
               class="mt-auto inline-flex items-center gap-2 text-sm text-white bg-[rgb(246,81,119)] hover:bg-pink-600 px-4 py-2 rounded-xl transition">
                <i class="fas fa-arrow-right"></i>
                Xem chi tiết
            </a>
        </div>
        @endforeach
    </div>

    <div class="mt-10">
        {{ $posts->links() }}
    </div>
</div>
</x-layout-site>
