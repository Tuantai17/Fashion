<x-layout-admin>
    <x-slot:title>
        Quản Lí Menu
    </x-slot:title>

    <div class="content-wrapper">
    <div class="mb-3 rounded-lg p-2">
            <div class="flex items-center justify-between ">
                <div class="">
                    <h2 class="text-xl font-semibold text-[rgb(246,81,119)]">Danh Sách Menu</h2>
                </div>
                <div class="text-right">
                    <a href="{{ route ('menu.create') }}" class="text-[rgb(246,81,119)] px-2 py-2 rounded-xl mx-1 font-semibold hover:text-[rgb(244,8,8)]">
                        <i class="fa-solid fa-plus "></i>
                    </a>
                    <a href="{{ route('menu.trash') }}" class="text-[rgb(246,81,119)] px-2 py-2 rounded-xl mx-1 font-semibold hover:text-[rgb(244,8,8)]">
                        <i class="fa fa-trash" aria-hidden="true"></i>
                    </a>

                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg p-4">
            <table class="w-full border-collapse border border-gray-300 table-auto">
                <thead>
                    <tr class="bg-gray-200">
                        <th class="border border-gray-300 p-3 font-semibold text-[rgb(246,81,119)] text-lg">ID</th>
                        <th class="border border-gray-300 p-3 font-semibold text-[rgb(246,81,119)] text-lg">Tên Menu</th>
                        <th class="border border-gray-300 p-3 font-semibold text-[rgb(246,81,119)] text-lg">Link</th>
                        <th class="border border-gray-300 p-3 font-semibold text-[rgb(246,81,119)] text-lg">Parent ID</th>
                        <th class="border border-gray-300 p-3 font-semibold text-[rgb(246,81,119)] text-lg">Thứ tự</th>
                        <th class="border border-gray-300 p-3 font-semibold text-[rgb(246,81,119)] text-lg">Loại</th>
                        <th class="border border-gray-300 p-3 font-semibold text-[rgb(246,81,119)] text-lg">Vị trí</th>
                        <th class="border border-gray-300 p-3 font-semibold text-[rgb(246,81,119)] text-lg">Hành động</th>
                        <th class="border border-gray-300 p-3 font-semibold text-[rgb(246,81,119)] text-lg">Chi Tiết</th>

                    </tr>
                </thead>
                <tbody>
                    @foreach ($list as $item)
                        <tr class="hover:bg-gray-100">
                            <td class="border border-gray-300 p-3 text-center text-[rgb(246,81,119)]">{{ $item->id }}</td>
                            <td class="border border-gray-300 p-3 text-center text-[rgb(246,81,119)]">{{ $item->name }}</td>
                            <td class="border border-gray-300 p-3 text-center text-[rgb(246,81,119)]">{{ $item->link }}</td>
                            <td class="border border-gray-300 p-3 text-center text-[rgb(246,81,119)]">{{ $item->parent_id }}</td>
                            <td class="border border-gray-300 p-3 text-center text-[rgb(246,81,119)]">{{ $item->sort_order }}</td>
                            <td class="border border-gray-300 p-3 text-center text-[rgb(246,81,119)]">{{ $item->type }}</td>
                            <td class="border border-gray-300 p-3 text-center text-[rgb(246,81,119)]">{{ $item->position }}</td>
                            <td class="border border-gray-300 p-3 text-center text-[rgb(246,81,119)]">
                            <a href="{{ route('menu.status', ['menu' => $item->id]) }}">
                                @if ($item->status == 1)
                                    <i class="fa fa-toggle-on text-2xl text-[rgb(246,81,119)]" aria-hidden="true"></i>
                                @else
                                    <i class="fa fa-toggle-off text-2xl text-[rgb(246,81,119)]" aria-hidden="false"></i>
                                @endif
                            </a>
                            <a href="{{ route('menu.edit', ['menu' => $item->id]) }}">
                                <i class="fa fa-edit text-blue-500 text-2xl" aria-hidden="true"></i>
                            </a>
                            <a href="{{ route('menu.delete', ['menu' => $item->id]) }}">
                                <i class="fa fa-trash text-red-500 text-2xl" aria-hidden="true"></i>
                            </a>
                            </td>
                            <td class="border border-gray-300 p-3 text-center text-[rgb(246,81,119)]">
                                <a href="{{ route('menu.show', ['menu' => $item->id]) }}" class="text-blue-500">
                                    <i class="fa fa-eye text-blue-500 text-2xl" aria-hidden="true"></i>
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <div class="mt-4">
                {{ $list->links() }}
            </div>
        </div>
    </div>
</x-layout-admin>
