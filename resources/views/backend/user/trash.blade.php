<x-layout-admin>
    <x-slot:title>
        Thùng Rác Người Dùng
    </x-slot:title>

    <div class="content-wrapper">
        <div class="mb-3 rounded-lg p-2">
            <div class="flex items-center justify-between">
                <div>
                    <h2 class="text-xl font-bold text-[rgb(246,81,119)]">Danh Sách Người Dùng Đã Xóa</h2>
                </div>
                <div class="text-right">
                    <a href="{{ route('user.index') }}" class="text-[rgb(246,81,119)] px-2 py-2 rounded-xl mx-1 font-semibold hover:text-[rgb(244,8,8)]">
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
                        <th class="border border-gray-300 p-3 font-semibold text-[rgb(246,81,119)] text-lg">Tên</th>
                        <th class="border border-gray-300 p-3 font-semibold text-[rgb(246,81,119)] text-lg">Email</th>
                        <th class="border border-gray-300 p-3 font-semibold text-[rgb(246,81,119)] text-lg">Vai trò</th>
                        <th class="border border-gray-300 p-3 font-semibold text-[rgb(246,81,119)] text-lg">Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($list as $user)
                        <tr class="hover:bg-gray-100">
                            <td class="border border-gray-300 p-3 text-center text-[rgb(246,81,119)]">{{ $user->id }}</td>
                            <td class="border border-gray-300 p-3 text-center text-[rgb(246,81,119)]">{{ $user->name }}</td>
                            <td class="border border-gray-300 p-3 text-center text-[rgb(246,81,119)]">{{ $user->email }}</td>
                            <td class="border border-gray-300 p-3 text-center text-[rgb(246,81,119)]">{{ $user->roles }}</td>
                            <td class="border border-gray-300 p-3 text-center text-[rgb(246,81,119)]">
                                <a href="{{ route('user.restore', ['user' => $user->id]) }}">
                                    <i class="fa-solid fa-rotate-left text-blue-500 text-2xl" aria-hidden="true"></i>
                                </a>
                                <form action="{{ route('user.destroy', ['user' => $user->id]) }}" class="inline" method="post">
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
