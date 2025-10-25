<x-layout-admin>
    <x-slot:title>
        Thùng Rác Thương Hiệu
    </x-slot:title>

    <div class="content-wrapper">
        <!-- Thanh tiêu đề -->
        <div class="mb-3 rounded-lg p-2">
            <div class="flex items-center justify-between ">
                <div class="">
                    <h2 class="text-xl font-bold text-[rgb(246,81,119)]">Danh Sách Thương Hiệu Đã Xóa</h2>
                </div>
                <div class="text-right">
                    <a href="{{ route ('brand.index') }}" class="text-[rgb(246,81,119)] px-2 py-2 rounded-xl mx-1 font-semibold hover:text-[rgb(244,8,8)]">
                        <i class="fa fa-arrow-left" aria-hidden="true"></i>                     
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Bảng danh sách thương hiệu -->
    <div class="bg-white rounded-lg p-4">
        <table class="w-full border-collapse border border-gray-300">
            <thead class="bg-gray-200">
                <tr>
                    <th class="border border-gray-300 p-4 text-[rgb(246,81,119)] text-lg">ID</th>
                    <th class="border border-gray-300 p-4 text-[rgb(246,81,119)] text-lg">Hình</th>
                    <th class="border border-gray-300 p-4 text-[rgb(246,81,119)] text-lg">Tên thương hiệu</th>
                    <th class="border border-gray-300 p-4 text-[rgb(246,81,119)] text-lg">Hành động</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($list as $item)
                    <tr class="hover:bg-gray-100">
                        <td class="border border-gray-300 p-4 text-center">{{ $item->id }}</td>
                        <td class="border border-gray-300 p-4 text-center">
                            <img src="{{ asset('assets/images/brand/' . $item->image) }}" class="h-28 w-auto mx-auto rounded object-cover" alt="{{ $item->name }}">
                        </td>
                        <td class="border border-gray-300 p-4 text-center">{{ $item->name }}</td>
                        <td class="border border-gray-300 p-3 text-center text-[rgb(246,81,119)]">
                            <a href="{{ route('brand.restore', ['brand' => $item->id]) }}">
                                <i class="fa-solid fa-rotate-left text-blue-500 text-2xl" aria-hidden="true"></i>
                            </a>
                            <form action="{{ route('brand.destroy',['brand' => $item->id]) }}" class="inline" method="post">
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
</x-layout-admin>
