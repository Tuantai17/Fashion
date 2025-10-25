<x-layout-site>
    <x-slot:title>
        Kết quả tìm kiếm
    </x-slot:title>

    <main class="px-8 py-6 bg-gray-100 min-h-screen  pt-40 pb-40">
        <div class="max-w-7xl mx-auto">
            <h2 class="text-3xl font-bold text-gray-800 mb-6">🔍 Kết quả cho: "<span class="text-blue-600">{{ $keyword }}</span>"</h2>

            @if ($products->isEmpty())
                <p class="text-gray-500 italic">Không tìm thấy sản phẩm nào phù hợp.</p>
            @else
                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                    @foreach ($products as $product)
                        <div class="bg-white rounded-xl overflow-hidden shadow hover:shadow-xl transition duration-300 transform hover:-translate-y-1">
                            <img src="{{ asset('assets/images/product/' . $product->thumbnail) }}"
                                 alt="{{ $product->name }}"
                                 class="w-full h-48 object-cover">

                            <div class="p-4">
                                <h3 class="text-lg font-semibold text-gray-800 line-clamp-2">{{ $product->name }}</h3>

                                <div class="flex justify-center items-center gap-2 mt-2">
                                    @if ($product->price_sale > 0 && $product->price_sale < $product->price_root)
                                        <span class="text-red-500 font-bold text-lg">
                                            {{ number_format($product->price_sale) }}₫
                                        </span>
                                        <span class="line-through text-sm text-gray-400">
                                            {{ number_format($product->price_root) }}₫
                                        </span>
                                    @else
                                        <span class="text-gray-800 font-bold text-lg">
                                            {{ number_format($product->price_root) }}₫
                                        </span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </main>
</x-layout-site>
