<x-layout-admin>
    <x-slot:title>
        Quản Lý Người Dùng
    </x-slot:title>

    <div class="content-wrapper">
        <div class="mb-3 rounded-lg p-2">
            <div class="flex items-center justify-between">
                <div>
                    <h2 class="text-xl font-semibold text-[rgb(246,81,119)]">Danh Sách Người Dùng</h2>
                </div>
                <div class="text-right">
                    <a href="{{ route ('user.create') }}" class="text-[rgb(246,81,119)] px-2 py-2 rounded-xl mx-1 font-semibold hover:text-[rgb(244,8,8)]">
                        <i class="fa-solid fa-plus" aria-hidden="true"></i>
                    </a>
                    <a href="{{ route('user.trash') }}" class="text-[rgb(246,81,119)] px-2 py-2 rounded-xl mx-1 font-semibold hover:text-[rgb(244,8,8)]">
                        <i class="fa fa-trash" aria-hidden="true"></i>
                    </a>

                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg p-4">
            <table class="w-full border-collapse border border-gray-300">
                <thead>
                    <tr class="bg-gray-200">
                        <th class="border border-gray-300 p-3 font-semibold text-[rgb(246,81,119)] text-lg">ID</th>
                        <th class="border border-gray-300 p-3 font-semibold text-[rgb(246,81,119)] text-lg">Ảnh đại diện</th>
                        <th class="border border-gray-300 p-3 font-semibold text-[rgb(246,81,119)] text-lg">Tên</th>
                        <th class="border border-gray-300 p-3 font-semibold text-[rgb(246,81,119)] text-lg">Email</th>
                        <th class="border border-gray-300 p-3 font-semibold text-[rgb(246,81,119)] text-lg">Vai trò</th>
                        <th class="border border-gray-300 p-3 font-semibold text-[rgb(246,81,119)] text-lg">Hành động</th>
                        <th class="border border-gray-300 p-3 font-semibold text-[rgb(246,81,119)] text-lg">Chi Tiết</th>

                    </tr>
                </thead>
                <tbody>
                    @foreach ($list as $user)
                        <tr class="hover:bg-gray-100">
                            <td class="border border-gray-300 p-3 text-center text-[rgb(246,81,119)]">{{ $user->id }}</td>
                            <td class="border border-gray-300 p-3 text-center">
                                <img src="{{ asset($user->avatar ?? 'assets/images/user/default.jpg') }}"
                                     alt="avatar"
                                     class="w-auto h-28 object-cover mx-auto">
                            </td>
                            <td class="border border-gray-300 p-3 text-center text-[rgb(246,81,119)]">{{ $user->name }}</td>
                            <td class="border border-gray-300 p-3 text-center text-[rgb(246,81,119)]">{{ $user->email }}</td>
                            <td class="border border-gray-300 p-3 text-center text-[rgb(246,81,119)]">{{ $user->roles }}</td>
                            <td class="border border-gray-300 p-3 text-center text-[rgb(246,81,119)]">
                                <a href="{{ route('user.status', ['user' => $user->id]) }}">
                                    @if ($user->status == 1)
                                        <i class="fa fa-toggle-on text-2xl text-[rgb(246,81,119)]" aria-hidden="true"></i>
                                    @else
                                        <i class="fa fa-toggle-off text-2xl text-[rgb(246,81,119)]" aria-hidden="false"></i>
                                    @endif
                                </a>

                                <a href="{{ route('user.edit', ['user' => $user->id]) }}">
                                    <i class="fa fa-edit text-blue-500 text-2xl" aria-hidden="true"></i>
                                </a>
                                <a href="{{ route('user.delete', ['user' => $user->id]) }}">
                                    <i class="fa fa-trash text-red-500 text-2xl" aria-hidden="true"></i>
                                </a>
                            </td>
                            <td class="border border-gray-300 p-3 text-center text-[rgb(246,81,119)]">
                                <a href="{{ route('user.show', ['user' => $user->id]) }}" class="text-blue-500">
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
