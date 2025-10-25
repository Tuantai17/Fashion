<x-layout-admin>
    <div class="max-w-2xl mx-auto p-6 bg-white rounded-xl shadow-md">
        <h2 class="text-2xl font-bold mb-6 text-gray-800">Phản hồi liên hệ: {{ $contact->name }}</h2>
        
        <form action="{{ route('contact.reply.submit', $contact->id) }}" method="POST" class="space-y-6">
            @csrf

            <div>
                <label for="reply_content" class="block text-sm font-medium text-gray-700 mb-1">
                    Nội dung phản hồi
                </label>
                <textarea 
                    name="reply_content" 
                    rows="5" 
                    class="w-full border border-gray-300 rounded-lg p-3 focus:outline-none focus:ring-2 focus:ring-pink-500 resize-none"
                >{{ old('reply_content', $contact->reply_content) }}</textarea>
                
                @error('reply_content')
                    <small class="text-red-600">{{ $message }}</small>
                @enderror
            </div>

            <div class="flex items-center space-x-3">
                <button type="submit" class="bg-pink-600 text-white px-5 py-2 rounded-lg hover:bg-pink-700 transition">
                    Gửi phản hồi
                </button>
                <a href="{{ route('contact.index') }}" class="bg-gray-300 text-gray-800 px-5 py-2 rounded-lg hover:bg-gray-400 transition">
                    Hủy
                </a>
            </div>
        </form>
    </div>
</x-layout-admin>
