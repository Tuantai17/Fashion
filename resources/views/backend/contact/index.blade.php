<x-layout-admin>
    <x-slot:title> Quản Lý Liên Hệ </x-slot:title>

    <div class="content-wrapper">
        <div class="mb-3 rounded-lg p-4">
            <div class="flex items-center justify-between">
                <div class="">
                    <h2 class="text-xl font-semibold text-[rgb(246,81,119)]">Danh Sách Liên Hệ</h2>
                </div>
                <div class="text-right">
                    <a href="{{ route('contact.trash') }}" class="text-[rgb(246,81,119)] px-2 py-2 rounded-xl mx-1 font-semibold hover:text-[rgb(244,8,8)]">
                        <i class="fa fa-trash" aria-hidden="true"></i>
                    </a>

                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg p-4">
            <table class="w-full border-collapse border border-gray-300">
                <thead class="bg-gray-200">
                    <tr>
                        <th class="border border-gray-300 p-4 font-bold text-[rgb(246,81,119)] text-lg">ID</th>
                        <th class="border border-gray-300 p-4 font-bold text-[rgb(246,81,119)] text-lg">Tên</th>
                        <th class="border border-gray-300 p-4 font-bold text-[rgb(246,81,119)] text-lg">Email</th>
                        <th class="border border-gray-300 p-4 font-bold text-[rgb(246,81,119)] text-lg">Số điện thoại</th>
                        <th class="border border-gray-300 p-4 font-bold text-[rgb(246,81,119)] text-lg">Tiêu đề</th>
                        <th class="border border-gray-300 p-4 font-bold text-[rgb(246,81,119)] text-lg">Nội dung</th>
                        <th class="border border-gray-300 p-4 font-bold text-[rgb(246,81,119)] text-lg">Hành động</th>
                        <th class="border border-gray-300 p-4 font-bold text-[rgb(246,81,119)] text-lg">Chi Tiết</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($list as $item)
                        <tr class="hover:bg-gray-100">
                            <td class="border border-gray-300 p-4 text-center text-[rgb(246,81,119)]">{{ $item->id }}</td>
                            <td class="border border-gray-300 p-4 text-center text-[rgb(246,81,119)]">{{ $item->name }}</td>
                            <td class="border border-gray-300 p-4 text-center text-[rgb(246,81,119)]">{{ $item->email }}</td>
                            <td class="border border-gray-300 p-4 text-center text-[rgb(246,81,119)]">{{ $item->phone }}</td>
                            <td class="border border-gray-300 p-4 text-center text-[rgb(246,81,119)]">{{ $item->title }}</td>
                            <td class="border border-gray-300 p-4 text-center text-[rgb(246,81,119)]">{{ $item->content }}</td>
                            <td class="border border-gray-300 p-4 text-center text-[rgb(246,81,119)]">
                                <a href="{{ route('contact.status', ['contact' => $item->id]) }}">
                                    @if ($item->status == 1)
                                        <i class="fa fa-toggle-on text-2xl text-[rgb(246,81,119)]" aria-hidden="true"></i>
                                    @else
                                        <i class="fa fa-toggle-off text-2xl text-[rgb(246,81,119)]" aria-hidden="false"></i>
                                    @endif
                                </a>
                                <a href="{{ route('contact.reply', $item->id) }}" class="btn btn-sm btn-primary">Trả lời</a>
">
                                    <i class="fa fa-edit text-2xl text-blue-500" aria-hidden="true"></i>
                                </a>
                                <a href="{{ route('contact.delete', ['contact' => $item->id]) }}">
                                    <i class="fa fa-trash text-2xl text-red-500" aria-hidden="true"></i>
                                </a>
                            </td>
                            <td class="border border-gray-300 p-3 text-center text-[rgb(246,81,119)]">
                                <a href="{{ route('contact.show', ['contact' => $item->id]) }}" class="text-blue-500">
                                    <i class="fa fa-eye text-blue-500 text-2xl" aria-hidden="true"></i>
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <!-- Phân trang -->
            <div class="mt-4">
                {{ $list->links() }}
            </div>
        </div>
    </div>
</x-layout-admin>
