<?php

namespace App\View\Components;

use App\Models\Category; // Add this line to import the Category model
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class CategoryList extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
       $category_list = Category::select('id', 'name', 'slug', 'image')
            ->where('status', 1)
            ->orderBy('sort_order')
            ->get();

        // ✅ Bắt buộc phải return một view, closure, hoặc string
        return view('components.category-list', compact('category_list'));
    }
}
