<?php

namespace App\Http\Controllers\backend;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Brand;
use App\Http\Requests\StoreBrandRequest;
use App\Http\Requests\UpdateBrandRequest;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;



class BrandController extends Controller
{
    /*index---------------------------------------------------------*/
    public function index()
    {
        $list = Brand::select('id', 'name', 'image', 'status', 'description')
            ->orderBy('created_at', 'desc')
            ->paginate(5);
        return view('backend.brand.index', compact('list'));
    }

    /*create---------------------------------------------------------*/
    public function create()
    {
        return view('backend.brand.create');

    }

    /*store---------------------------------------------------------*/
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255',
            'description' => 'nullable|string|max:1000', // Validate cho description
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp,svg|max:2048',
        ]);

        $brand = new Brand();
        $brand->name = $request->name;
        $brand->description = $request->description; // Lưu mô tả

        // Tạo slug và xử lý trùng slug
        $slug = $request->slug ?: Str::slug($request->name);
        $originalSlug = $slug;
        $counter = 1;
        while (Brand::where('slug', $slug)->exists()) {
            $slug = $originalSlug . '-' . $counter++;
        }
        $brand->slug = $slug;

        // Xử lý hình ảnh nếu có upload
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $extension = $file->getClientOriginalExtension();
            $fileName = $slug . '.' . $extension;
            $file->move(public_path('assets/images/brand'), $fileName);
            $brand->image = $fileName;
        } else {
            $brand->image = 'default.png'; // Dùng hình mặc định nếu không có upload
        }

        $brand->status = $request->status ?? 1;
        $brand->sort_order = 0;
        $brand->created_by = Auth::id() ?? 1;
        $brand->save();

        return redirect()->route('brand.index')->with('success', 'Thêm thương hiệu thành công!');
    }


    


    /*show---------------------------------------------------------*/
    public function show($id)
    {
        $brand = Brand::find($id);
        if (!$brand) {
            return redirect()->route('brand.index')->with('error', 'Thương hiệu không tồn tại');
        }

        return view('backend.brand.show', compact('brand'));
    }



    /*edit---------------------------------------------------------*/
    public function edit(string $id)
    {
        $brand = Brand::find($id);
        
        // Nếu không tìm thấy brand, có thể chuyển hướng hoặc báo lỗi
        if (!$brand) {
            return redirect()->route('brand.index')->with('error', 'Không tìm thấy thương hiệu!');
        }
        
        return view('backend.brand.edit', compact('brand'));
    }


    /*update---------------------------------------------------------*/
public function update(Request $request, string $id)
{
    $brand = Brand::find($id);
    if ($brand === null) {
        return redirect()->route('brand.index');
    }

    $slug = Str::slug($request->name, '-');
    $brand->name = $request->name;
    $brand->slug = $slug;
    $brand->description = $request->description; // Cập nhật mô tả

    if ($request->hasFile('image')) {
        $image_path = public_path('assets/images/brand/' . $brand->image);
        if (File::exists($image_path)) {
            File::delete($image_path);
        }

        $file = $request->file('image');
        $extension = $file->getClientOriginalExtension();
        $fileName = $slug . '.' . $extension;
        $file->move(public_path('assets/images/brand'), $fileName);
        $brand->image = $fileName;
    }

    $brand->status = $request->status;
    $brand->updated_by = Auth::id() ?? 1;
    $brand->updated_at = now();
    $brand->save();

    return redirect()->route('brand.index')->with('thongbao', 'Cập nhật thương hiệu thành công');
}


    /*destroy---------------------------------------------------------*/
    public function destroy(string $id)
    {
        $brand = Brand::onlyTrashed()->find($id);
        if ($brand === null) {
            return redirect()->route('brand.trash');
        }

        $image_path = public_path('assets/images/brand/' . $brand->image);
        if ($brand->forceDelete()) {
            if (File::exists($image_path)) {
                File::delete($image_path);
            }
        }
        return redirect()->route('brand.trash');
    }

    /*trash---------------------------------------------------------*/
    public function trash()
    {
        $list = Brand::onlyTrashed()->orderBy('created_at', 'desc')->paginate(5);
        return view('backend.brand.trash', compact('list'));
    }

    /*delete---------------------------------------------------------*/
    public function delete($id)
    {
        $brand = Brand::find($id);
        if ($brand === null) {
            return redirect()->route('brand.index');
        }
        $brand->delete(); // Khóa mềm
        return redirect()->route('brand.index');
    }


    /*status---------------------------------------------------------*/
    public function status($id)
    {
        $brand = Brand::find($id);
        if ($brand == null) {
            return redirect()->route('brand.index');
        }

        $brand->status = $brand->status == 1 ? 0 : 1;
        $brand->updated_by = Auth::id();
        $brand->updated_at = now();
        $brand->save();

        return redirect()->route('brand.index');
    }

    /*restore---------------------------------------------------------*/
    public function restore($id)
    {
        $brand = Brand::onlyTrashed()->find($id);
        if ($brand === null) {
            return redirect()->route('brand.trash');
        }
        $brand->restore();
        return redirect()->route('brand.trash');
    }


}
