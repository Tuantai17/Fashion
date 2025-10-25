<div class="container mx-auto py-10">
    <div class="grid grid-cols-1 md:grid-cols-2 gap-10 items-center">


        <!-- Nội dung -->
        <div class="w-full md:pl-6">
            <h2 class="text-3xl font-bold text-gray-900 mb-4">{{ $topicitem->name }}</h2>
            <p class="text-gray-700 text-lg leading-relaxed mb-6">
                {{ $topicitem->description }}
            </p>
            <a href="{{ route('site.topic.detail', ['slug' => $topicitem->slug]) }}">
                <button class="bg-gray-800 text-white py-2 px-6 rounded-lg hover:bg-gray-700 transition duration-300">
                    Xem bài viết
                </button>
            </a>
        </div>
    </div>
</div>
