<x-layout-admin>
    <x-slot:title>
        Quản Lý Bài Viết
    </x-slot:title>

    <div class="content-wrapper">
        <!-- Header -->
        <div class="mb-3 rounded-lg p-2">
            <div class="flex items-center justify-between">
                <h2 class="text-xl font-semibold text-[rgb(246,81,119)]">Danh Sách Bài Viết</h2>
                <div class="text-right">
                    <a href="{{ route('post.create') }}" class="text-[rgb(246,81,119)] px-2 py-2 rounded-xl mx-1 font-semibold hover:text-[rgb(244,8,8)]">
                        <i class="fa-solid fa-plus"></i>
                    </a>
                    <a href="{{ route('post.trash') }}" class="text-[rgb(246,81,119)] px-2 py-2 rounded-xl mx-1 font-semibold hover:text-[rgb(244,8,8)]">
                        <i class="fa fa-trash" aria-hidden="true"></i>
                    </a>
                </div>
            </div>
        </div>

        <!-- Bảng bài viết -->
        <div class="bg-white rounded-lg p-4">
            <table class="w-full border-collapse border border-gray-300 table-auto">
                <thead>
                    <tr class="bg-gray-200">
                        <th class="border border-gray-300 p-3 font-semibold text-[rgb(246,81,119)] text-lg">ID</th>
                        <th class="border border-gray-300 p-3 font-semibold text-[rgb(246,81,119)] text-lg">Ảnh</th>
                        <th class="border border-gray-300 p-3 font-semibold text-[rgb(246,81,119)] text-lg">Tiêu đề</th>
                        <th class="border border-gray-300 p-3 font-semibold text-[rgb(246,81,119)] text-lg">Slug</th>
                        <th class="border border-gray-300 p-3 font-semibold text-[rgb(246,81,119)] text-lg">Loại</th>
                        <th class="border border-gray-300 p-3 font-semibold text-[rgb(246,81,119)] text-lg">Trạng thái</th>
                        <th class="border border-gray-300 p-3 font-semibold text-[rgb(246,81,119)] text-lg">Chức năng</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($list as $key => $item)
                        <tr class="hover:bg-gray-100">
                            <td class="border border-gray-300 p-3 text-center text-[rgb(246,81,119)]">{{ $list->firstItem() + $key }}</td>
                            <td class="border border-gray-300 p-3 text-center">
                                <img src="{{ asset('assets/images/post/' . $item->thumbnail) }}" class="w-20 h-20 object-cover rounded" alt="Thumbnail">
                            </td>
                            <td class="border border-gray-300 p-3 text-center text-[rgb(246,81,119)]">{{ $item->title }}</td>
                            <td class="border border-gray-300 p-3 text-center text-[rgb(246,81,119)]">{{ $item->slug }}</td>
                            <td class="border border-gray-300 p-3 text-center text-[rgb(246,81,119)]">{{ $item->type }}</td>
                            <td class="border border-gray-300 p-3 text-center">
                                <a href="{{ route('post.status', $item->id) }}">
                                    @if ($item->status == 1)
                                        <i class="fa fa-toggle-on text-[rgb(246,81,119)] text-2xl"></i>
                                    @else
                                        <i class="fa fa-toggle-off text-[rgb(246,81,119)] text-2xl"></i>
                                    @endif
                                </a>
                            </td>
                            <td class="border border-gray-300 p-3 text-center space-x-2">
                                <a href="{{ route('post.edit', $item->id) }}">
                                    <i class="fa fa-edit text-blue-500 text-2xl"></i>
                                </a>
                                <a href="{{ route('post.delete', $item->id) }}">
                                    <i class="fa fa-trash text-red-500 text-2xl"></i>
                                </a>
                                <a href="{{ route('post.show', ['post' => $item->id]) }}">
                                    <i class="fa fa-eye text-blue-500 text-2xl"></i>
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
