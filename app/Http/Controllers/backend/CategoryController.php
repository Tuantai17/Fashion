<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Http\Requests\StoreCategoryRequest;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Auth;

class CategoryController extends Controller
{
/*index---------------------------------------------------------*/
    public function index(Request $request)
    {
        $sortBy   = $request->get('sortBy', 'created_at');
        $sortType = $request->get('sortType', 'desc');

        $list = Category::select('id', 'name', 'slug', 'image', 'status')
            ->orderBy($sortBy, $sortType)
            ->paginate(5);

        return view('backend.category.index', compact('list', 'sortBy', 'sortType'));
    }

/*create---------------------------------------------------------*/
    public function create()
    {
        $list_category = Category::select('id', 'name')
            ->where('status', '!=', 0)
            ->orderBy('name', 'asc')
            ->get();

        return view('backend.category.create', compact('list_category'));
    }

/*store---------------------------------------------------------*/
    public function store(StoreCategoryRequest $request)
    {
        $category = new Category();
        $category->name = $request->name;
        $category->slug = \Illuminate\Support\Str::slug($request->name);
        $category->description = $request->description;

        // ✅ Xử lý upload ảnh
        if ($request->hasFile('thumbnail')) {
            $file = $request->file('thumbnail');
            $extension = $file->getClientOriginalExtension();
            $filename = $category->slug . '-' . time() . '.' . $extension;
            $destinationPath = public_path('assets/images/category');

            if (!file_exists($destinationPath)) {
                mkdir($destinationPath, 0777, true);
            }

            $file->move($destinationPath, $filename);
            $category->image = $filename; // Lưu vào cột image
        }

        $category->parent_id = $request->parent_id ?? 0;
        $category->sort_order = $request->sort_order ?? 0;
        $category->status = $request->status;
        $category->created_by = Auth::id() ?? 1;
        $category->created_at = now();
        $category->save();

        return redirect()->route('category.index')->with('thongbao', 'Thêm danh mục thành công');
    }

/*show---------------------------------------------------------*/
    public function show(string $id)
    {
        $category = Category::find($id);
        if ($category == null) {
            return redirect()->route('category.index')->with('error', 'Danh mục không tồn tại');
        }

        return view('backend.category.show', compact('category'));
    }


/*edit---------------------------------------------------------*/
    public function edit(string $id)
    {
        $category = Category::find($id);
        if ($category == null) {
            return redirect()->route('category.index');
        }

        $list_category = Category::select('id', 'name')
            ->where('status', '!=', 0)
            ->orderBy('name', 'asc')
            ->get();

        return view('backend.category.edit', compact('category', 'list_category'));
    }

/*update---------------------------------------------------------*/
    public function update(Request $request, string $id)
    {
        $category = Category::find($id);
        if ($category == null) {
            return redirect()->route('category.index');
        }

        $category->name = $request->name;
        $category->slug = \Illuminate\Support\Str::slug($request->name);
        $category->description = $request->description;

        if ($request->hasFile('thumbnail')) {
            // Xóa ảnh cũ
            $image_path = public_path('assets/images/category/' . $category->image);
            if (File::exists($image_path)) {
                File::delete($image_path);
            }

            $file = $request->file('thumbnail');
            $extension = $file->getClientOriginalExtension();
            $filename = $category->slug . '-' . time() . '.' . $extension;
            $destinationPath = public_path('assets/images/category');
            $file->move($destinationPath, $filename);
            $category->image = $filename; // Lưu vào cột image
        }

        $category->parent_id = $request->parent_id ?? 0;
        $category->sort_order = $request->sort_order ?? 0;
        $category->status = $request->status;
        $category->updated_by = Auth::id() ?? 1;
        $category->updated_at = now();
        $category->save();

        return redirect()->route('category.index')->with('thongbao', 'Cập nhật danh mục thành công');
    }

/*destroy---------------------------------------------------------*/
    public function destroy(string $id)
    {
        $category = Category::onlyTrashed()->find($id);
        if ($category == null) {
            return redirect()->route('category.trash');
        }

        $image_path = public_path('assets/images/category/' . $category->image);
        if ($category->forceDelete()) {
            if (File::exists($image_path)) {
                File::delete($image_path);
            }
        }

        return redirect()->route('category.trash');
    }

/*trash---------------------------------------------------------*/
    public function trash()
    {
        $list = Category::select('id', 'name', 'slug', 'image', 'status')
            ->orderBy('created_at', 'desc')
            ->onlyTrashed()
            ->paginate(5);

        return view('backend.category.trash', compact('list'));
    }


/*delete---------------------------------------------------------*/
    public function delete($id)
    {
        $category = Category::find($id);
        if ($category == null) {
            return redirect()->route('category.index');
        }

        $category->delete();
        return redirect()->route('category.index');
    }

/*status---------------------------------------------------------*/
    public function status($id)
    {
        $category = Category::find($id);
        if ($category == null) {
            return redirect()->route('category.index');
        }

        $category->status = ($category->status == 1) ? 0 : 1;
        $category->updated_by = Auth::id() ?? 1;
        $category->updated_at = now();
        $category->save();

        return redirect()->route('category.index');
    }

/*restore---------------------------------------------------------*/
    public function restore($id)
    {
        $category = Category::onlyTrashed()->find($id);
        if ($category == null) {
            return redirect()->route('category.index');
        }

        $category->restore();
        return redirect()->route('category.trash');
    }
}
