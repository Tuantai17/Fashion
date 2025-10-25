<x-layout-admin>
    <x-slot:title>
        Trang Quản Lý Danh Mục
    </x-slot:title>

    <div class="content-wrapper">
        <!-- Thanh tiêu đề -->
        <div class="mb-3 rounded-lg p-2">
            <div class="flex items-center justify-between ">
                <div class="">
                    <h2 class="text-xl font-semibold text-[rgb(246,81,119)]">Danh Sách Danh Mục</h2>
                </div>
                <div class="text-right">
                    <a href="{{ route ('category.create') }}" class="text-[rgb(246,81,119)] px-2 py-2 rounded-xl mx-1 font-semibold hover:text-[rgb(244,8,8)]">
                        <i class="fa-solid fa-plus "></i>
                    </a>
                    <a href="{{ route('category.trash') }}" class="text-[rgb(246,81,119)] px-2 py-2 rounded-xl mx-1 font-semibold hover:text-[rgb(244,8,8)]">
                        <i class="fa fa-trash" aria-hidden="true"></i>
                    </a>

                </div>
            </div>
        </div>

        <!-- Bảng danh mục -->
        <div class="bg-white rounded-lg p-4">
            <table class="w-full border-collapse border border-gray-300">
                <thead>
                    <tr class="bg-gray-200">
                        <th class="border border-gray-300 p-2 font-bold text-[rgb(246,81,119)]">ID</th>
                        <th class="border border-gray-300 p-2 font-bold text-[rgb(246,81,119)]">Hình</th>
                        <th class="border border-gray-300 p-2 font-bold text-[rgb(246,81,119)]">Tên danh mục</th>
                        <th class="border border-gray-300 p-2 font-bold text-[rgb(246,81,119)]">Slug</th>
                        <th class="border border-gray-300 p-2 font-bold text-[rgb(246,81,119)]">Hành động</th>
                        <th class="border border-gray-300 p-2 font-bold text-[rgb(246,81,119)]">Chi Tiết</th>

                    </tr>
                </thead>
                <tbody>
                    @foreach ($list as $item)
                        <tr>
                            <td class="border border-gray-300 p-2 text-[rgb(246,81,119)] text-center">{{ $item->id }}</td>
                            <td class="border border-gray-300 p-2 text-[rgb(246,81,119)] text-center">
                                <!-- Hiển thị ảnh theo cùng cách trong danh sách sản phẩm -->
                                <img src="{{ asset('assets/images/category/'.$item->image) }}" class="h-28 w-auto mx-auto rounded object-cover" alt="{{ $item->name }}">
                            </td>
                            <td class="border border-gray-300 p-2 text-[rgb(246,81,119)] text-center">{{ $item->name }}</td>
                            <td class="border border-gray-300 p-2 text-[rgb(246,81,119)] text-center">{{ $item->slug }}</td>
                            <td class="border border-gray-300 p-2 text-center text-[rgb(246,81,119)]">
                             
                                <a href="{{ route('category.status', ['category' => $item->id]) }}">
                                    @if ($item->status == 1)
                                        <i class="fa fa-toggle-on text-2xl text-[rgb(246,81,119)]" aria-hidden="true"></i>
                                    @else
                                        <i class="fa fa-toggle-off text-2xl text-[rgb(246,81,119)]" aria-hidden="true"></i>
                                    @endif
                                </a>
                               
                                <a href="{{ route('category.edit', ['category' => $item->id]) }}">
                                    <i class="fa fa-edit text-2xl text-blue-500" aria-hidden="true"></i>
                                </a>
                                <a href="{{ route('category.delete', ['category' => $item->id]) }}">
                                    <i class="fa fa-trash text-2xl text-red-500" aria-hidden="true"></i>
                                </a>
                            </td>
                            <td class="border border-gray-300 p-3 text-center text-[rgb(246,81,119)]">
                                <a href="{{ route('category.show', ['category' => $item->id]) }}" class="text-blue-500">
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
