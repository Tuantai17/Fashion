<x-layout-admin>

<x-slot:title>
    Thùng Rác Sản Phẩm
</x-slot:title>

<div class="content-wrapper">
    <div class="mb-3 rounded-lg p-2">
            <div class="flex items-center justify-between ">
                <div class="">
                    <h2 class="text-xl font-bold text-[rgb(246,81,119)]">Danh Sách Sản Phẩm Đã Xóa</h2>
                </div>
                <div class="text-right">
                    <a href="{{ route ('product.index') }}" class="text-[rgb(246,81,119)] px-2 py-2 rounded-xl mx-1 font-semibold hover:text-[rgb(244,8,8)]">
                        <i class="fa fa-arrow-left" aria-hidden="true"></i>                     
                    </a>
                </div>
            </div>
        </div>
    </div>
    <div class="bg-white rounded-lg p-4">
        <table class="w-full border-collapse border border-gray-300">
            <thead>
                <tr class="bg-gray-200">
                    <th class="border border-gray-300 p-3 font-semibold text-[rgb(246,81,119)] text-lg">ID</th>
                    <th class="border border-gray-300 p-3 font-semibold text-[rgb(246,81,119)] text-lg">Hình ảnh</th>
                    <th class="border border-gray-300 p-3 font-semibold text-[rgb(246,81,119)] text-lg">Tên sản phẩm</th>
                    <th class="border border-gray-300 p-3 font-semibold text-[rgb(246,81,119)] text-lg">Danh mục</th>
                    <th class="border border-gray-300 p-3 font-semibold text-[rgb(246,81,119)] text-lg">Thương hiệu</th>
                    <th class="border border-gray-300 p-3 font-semibold text-[rgb(246,81,119)] text-lg">Hành động</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($list as $item)
                    <tr class="hover:bg-gray-100">
                        <td class="border border-gray-300 p-3 text-center text-[rgb(246,81,119)]">{{ $item->id }}</td>
                        <td class="border border-gray-300 p-3 text-center text-[rgb(246,81,119)]">
                            <img src="{{ asset('assets/images/product/'.$item->thumbnail) }}" class="w-20 h-30"  alt="{{ $item->thumbnail }}">
                        </td>
                        <td class="border border-gray-300 p-3 text-center text-[rgb(246,81,119)]">{{ $item->name }}</td>
                        <td class="border border-gray-300 p-3 text-center text-[rgb(246,81,119)]">{{ $item->categoryname }}</td>
                        <td class="border border-gray-300 p-3 text-center text-[rgb(246,81,119)]">{{ $item->brandname }}</td>
                        <td class="border border-gray-300 p-3 text-center text-[rgb(246,81,119)]">
                            
                            <a href="{{ route('product.restore', ['product' => $item->id]) }}">
                                <i class="fa-solid fa-rotate-left text-blue-500 text-2xl" aria-hidden="true"></i>
                            </a>
                            <form action="{{ route('product.destroy',['product' => $item->id]) }}" class="inline" method="post">
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
