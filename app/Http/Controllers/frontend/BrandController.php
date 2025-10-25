<?php

namespace App\Http\Controllers\frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Brand;

class BrandController extends Controller
{
    public function index()
{
    // Lấy tất cả thương hiệu có trạng thái active
    $brands = Brand::where('status', 1)->get();

    // Gán thêm URL ảnh cho mỗi thương hiệu
    foreach ($brands as $brand) {
        if ($brand->image) {
            $brand->image_url = asset('assets/images/brand/' . $brand->image); // chú ý đường dẫn 'assets'
        } else {
            $brand->image_url = asset('assets/images/default-brand.jpg');
        }
    }

    return view('frontend.home', [
        'brand_list' => $brands,
        'menuList' => $this->menu_list,
    ]);
}

}

