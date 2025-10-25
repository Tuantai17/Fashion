<li class="relative group border-b-3 border-transparent hover:border-[#c12e37]">
    <a href="{{ $menuitem->link }}"
       class="inline-block p-4 text-lg text-red-600 transition-all duration-300 group-hover:text-[#f66] hover:text-[#f66] group-hover:scale-105">
        {{ $menuitem->name }}
    </a>

    @if ($menuitem->menu->isNotEmpty())
        <ul class="absolute left-0 top-full bg-white shadow-lg hidden group-hover:block z-10 min-w-[160px] rounded-md mt-1">
            @foreach ($menuitem->menu as $child)
                <li class="border-b border-gray-100 last:border-b-0">
                    <a href="{{ $child->link }}"
                       class="block px-4 py-2 text-gray-700 hover:bg-gray-100 hover:text-[#f66] transition duration-200">
                        {{ $child->name }}
                    </a>
                </li>
            @endforeach
        </ul>
    @endif
</li>
