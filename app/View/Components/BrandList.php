<?php

namespace App\View\Components;

use App\Models\Brand; // Add this line to import the Category model
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class BrandList extends Component
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
        $brand_list = Brand::select('id', 'name', 'slug','image')->where('status','=',1)->orderBy('sort_order')->get();
        return view('components.brand-list',compact('brand_list'));
    }
}
