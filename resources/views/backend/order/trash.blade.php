<x-layout-admin>
    <x-slot:title> Thùng Rác</x-slot:title>

    <div class="content-wrapper">
        <div class="mb-3 rounded-lg p-2">
            <div class="flex items-center justify-between">
                <h2 class="text-xl font-bold text-[rgb(246,81,119)]">Danh Sách Đơn Hàng Đã Xóa</h2>
                <div class="text-right">
                    <a href="{{ route('order.index') }}" class="text-[rgb(246,81,119)] px-2 py-2 rounded-xl mx-1 font-semibold hover:text-[rgb(244,8,8)]">
                        <i class="fa fa-arrow-left" aria-hidden="true"></i>
                    </a>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg p-4">
            <table class="w-full border-collapse border border-gray-300">
                <thead>
                    <tr class="bg-gray-200">
                        <th class="border border-gray-300 p-3 font-semibold text-[rgb(246,81,119)] text-lg">ID</th>
                        <th class="border border-gray-300 p-3 font-semibold text-[rgb(246,81,119)] text-lg">Tên Người Dùng</th>
                        <th class="border border-gray-300 p-3 font-semibold text-[rgb(246,81,119)] text-lg">Số Điện Thoại</th>
                        <th class="border border-gray-300 p-3 font-semibold text-[rgb(246,81,119)] text-lg">Địa Chỉ Email</th>
                        <th class="border border-gray-300 p-3 font-semibold text-[rgb(246,81,119)] text-lg">Ngày Tạo</th>
                        <th class="border border-gray-300 p-3 font-semibold text-[rgb(246,81,119)] text-lg">Hành Động</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($list as $item)
                        <tr class="hover:bg-gray-100">
                            <td class="border border-gray-300 p-3 text-center text-[rgb(246,81,119)]">{{ $item->id }}</td>
                            <td class="border border-gray-300 p-3 text-center text-[rgb(246,81,119)]">{{ $item->name }}</td>
                            <td class="border border-gray-300 p-3 text-center text-[rgb(246,81,119)]">{{ $item->phone }}</td>
                            <td class="border border-gray-300 p-3 text-center text-[rgb(246,81,119)]">{{ $item->email }}</td>
                            <td class="border border-gray-300 p-3 text-center text-[rgb(246,81,119)]">{{ $item->created_at }}</td>

                            <td class="border border-gray-300 p-3 text-center">
                                <!-- Khôi phục đơn hàng -->
                                <a href="{{ route('order.restore', ['order' => $item->id]) }}">
                                    <i class="fa-solid fa-rotate-left text-blue-500 text-2xl" aria-hidden="true"></i>
                                </a>
                                <!-- Xóa vĩnh viễn đơn hàng -->
                                <form action="{{ route('order.destroy', ['order' => $item->id]) }}" class="inline" method="post">
                                    @csrf
                                    @method('DELETE')
                                    <button>
                                        <i class="fa fa-trash text-red-500 text-2xl" aria-hidden="true"></i>
                                    </button>
                                </form>
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
