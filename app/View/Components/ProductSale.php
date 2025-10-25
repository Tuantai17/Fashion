<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;
use App\Models\Product;


class ProductSale extends Component
{
   
    public function __construct()
    {
        //
    }

    
    public function render(): View|Closure|string
{
    $product_sale = Product::where('status', 1)
        ->where('price_sale', '>', 0)
        ->get()
        ->sortByDesc(function ($product) {
            return ($product->price_root > 0) 
                ? (($product->price_root - $product->price_sale) / $product->price_root) * 100 
                : 0;
        })
        ->take(4); // Lấy 4 sản phẩm có % giảm giá cao nhất

    return view('components.product-sale', compact('product_sale'));
}

}
