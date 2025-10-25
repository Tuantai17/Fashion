<x-layout-site>
<div class="container mx-auto py-10">
    <!-- Nội dung chính -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-10 items-center">
        <!-- Hình ảnh bài viết -->
        <div class="w-full flex justify-center">
            <img 
                src="{{ asset('assets/images/post/' . $post->thumbnail) }}" 
                alt="{{ $post->title }}"
                class="rounded-xl shadow-md w-full max-w-md h-auto object-cover"
            >
        </div>

        <!-- Nội dung bài viết -->
        <div class="w-full md:pl-6">
            <h2 class="text-3xl font-bold text-gray-900 mb-4">{{ $post->title }}</h2>
            <p class="text-gray-700 text-lg leading-relaxed mb-6">
                {{ $post->description }}
            </p>
        </div>
    </div>

    <!-- Bài viết liên quan -->
    <div class="mt-10">
        <h3 class="text-2xl font-semibold text-green-800 mb-4">Bài viết liên quan</h3>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            @foreach ($relatedPosts as $related)
                <div class="bg-white p-4 shadow rounded-xl">
                    <a href="{{ route('site.post.detail', ['slug' => $related->slug]) }}">
                        <img 
                            src="{{ asset('assets/images/post/' . $related->thumbnail) }}" 
                            alt="{{ $related->title }}" 
                            class="w-full h-100 object-cover rounded mb-4"
                        >
                        <h4 class="text-lg font-semibold text-gray-800">{{ $related->title }}</h4>
                    </a>
                </div>
            @endforeach
        </div>
    </div>
</div>
</x-layout-site>