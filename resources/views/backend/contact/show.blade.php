<x-layout-admin>
    <x-slot:title>
        Chi Tiết Liên Hệ
    </x-slot:title>
    <div class="mb-3 rounded-lg p-2">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-xl font-bold text-[rgb(246,81,119)]">Chi Tiết Liên Hệ</h2>
            </div>
            <div class="text-right">
                <a href="{{ route('contact.index') }}" class="text-[rgb(246,81,119)] px-2 py-2 rounded-xl mx-1 font-semibold hover:text-[rgb(244,8,8)]">
                    <i class="fa fa-arrow-left" aria-hidden="true"></i> 
                </a>
            </div>
        </div>
    </div>

    <div class="content-wrapper p-4 border border-[rgb(246,81,119)] rounded-lg">

        <div class="grid grid-cols-2 gap-4 mb-4">
            <div><strong>Tên người gửi:</strong> {{ $contact->name }}</div>
            <div><strong>Email:</strong> {{ $contact->email }}</div>
            <div><strong>Điện thoại:</strong> {{ $contact->phone }}</div>
            <div><strong>Tiêu đề:</strong> {{ $contact->title }}</div>
            <div><strong>Nội dung:</strong> <p>{{ $contact->content }}</p></div>
            <div><strong>Trạng thái:</strong> 
                <span class="{{ $contact->status ? 'text-green-600' : 'text-red-600' }}">
                    {{ $contact->status ? 'Đã xử lý' : 'Chưa xử lý' }}
                </span>
            </div>
            <div><strong>Ngày tạo:</strong> {{ $contact->created_at->format('d/m/Y H:i') }}</div>
            <div><strong>Ngày cập nhật:</strong> 
                {{ $contact->updated_at ? $contact->updated_at->format('d/m/Y H:i') : 'Chưa cập nhật' }}
            </div>
        </div>

        @if ($contact->reply_id)
            <div class="mt-4">
                <strong>Trả lời:</strong>
                <p>{{ $contact->reply_id }}</p> <!-- Hiển thị thông tin trả lời nếu có -->
            </div>
        @endif

    </div>
</x-layout-admin>
