<?php

namespace App\Http\Controllers\backend;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Banner;
use App\Http\Requests\StoreBannerRequest;
use App\Http\Requests\UpdateBannerRequest;
use Illuminate\Support\Facades\File;

class BannerController extends Controller
{
    /* index --------------------------------------------------------- */
    public function index()
    {
        $list = Banner::orderBy('created_at', 'desc')->paginate(5);
        return view('backend.banner.index', compact('list'));
    }

    /* create --------------------------------------------------------- */
    public function create()
    {
        return view('backend.banner.create');
    }

    /* store --------------------------------------------------------- */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp,svg|max:2048',
            'sort_order' => 'nullable|integer',
            'position' => 'nullable|string|max:255',
        ]);

        $banner = new Banner();
        $banner->name = $request->name;
        $banner->sort_order = $request->sort_order ?? 1;
        $banner->position = $request->position;
        $banner->created_by = Auth::id() ?? 1;
        $banner->status = 1;

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = Str::slug(pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME)) . '-' . time() . '.' . $file->getClientOriginalExtension();
            $destinationPath = public_path('assets/images/banner');
            if (!file_exists($destinationPath)) {
                mkdir($destinationPath, 0777, true);
            }
            $file->move($destinationPath, $filename);
            $banner->image = 'assets/images/banner/' . $filename;
        } else {
            $banner->image = 'assets/images/banner/default.jpg';
        }

        $banner->save();

        return redirect()->route('banner.index')->with('success', 'Thêm banner thành công!');
    }

    /* show --------------------------------------------------------- */
    public function show(string $id)
    {
        $banner = Banner::find($id);

        if (!$banner) {
            return redirect()->route('banner.index')->with('error', 'Không tìm thấy banner');
        }

        return view('backend.banner.show', compact('banner'));
    }


    /* edit --------------------------------------------------------- */
    public function edit(string $id)
    {
        $banner = Banner::find($id);
        if ($banner == null) {
            return redirect()->route('banner.index')->with('error', 'Không tìm thấy banner');
        }

        return view('backend.banner.edit', compact('banner'));
    }

    /* update --------------------------------------------------------- */
    public function update(Request $request, string $id)
    {
        $banner = Banner::find($id);
        if (!$banner) {
            return redirect()->route('banner.index')->with('error', 'Không tìm thấy banner');
        }

        $banner->name = $request->name;
        $banner->status = $request->status;
        $banner->updated_by = Auth::id();
        $banner->updated_at = now();

        if ($request->hasFile('image')) {
            $oldImage = public_path($banner->image);
            if (File::exists($oldImage)) {
                File::delete($oldImage);
            }

            $file = $request->file('image');
            $filename = Str::slug($request->name) . '-' . time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('assets/images/banner'), $filename);
            $banner->image = 'assets/images/banner/' . $filename;
        }

        $banner->save();

        return redirect()->route('banner.index')->with('thongbao', 'Cập nhật banner thành công');
    }

    /* delete (soft delete) --------------------------------------------------------- */
    public function delete($id)
    {
        $banner = Banner::find($id);
        if (!$banner) {
            return redirect()->route('banner.index');
        }
        $banner->delete(); // soft delete
        return redirect()->route('banner.index')->with('thongbao', 'Đã chuyển vào thùng rác');
    }

    /* trash (list deleted) --------------------------------------------------------- */
    public function trash()
    {
        $list = Banner::onlyTrashed()
        ->orderBy('created_at', 'desc')
        ->onlyTrashed()
        ->paginate(5);
        return view('backend.banner.trash', compact('list'));
    }

    /* restore --------------------------------------------------------- */
    public function restore($id)
    {
        $banner = Banner::onlyTrashed()->find($id);
        if ($banner) {
            $banner->restore();
        }
        return redirect()->route('banner.trash')->with('thongbao', 'Khôi phục thành công');
    }

    /* destroy (force delete) --------------------------------------------------------- */
    public function destroy($id)
    {
        $banner = Banner::onlyTrashed()->find($id);
        if ($banner) {
            $image_path = public_path($banner->image);
            if ($banner->forceDelete()) {
                if (File::exists($image_path)) {
                    File::delete($image_path);
                }
            }
        }
        return redirect()->route('banner.trash')->with('thongbao', 'Xóa vĩnh viễn thành công');
    }

    /* status toggle --------------------------------------------------------- */
    public function status($id)
    {
        $banner = Banner::find($id);
        if ($banner === null) {
            return redirect()->route('banner.index')->with('error', 'Không tìm thấy banner');
        }

        $banner->status = ($banner->status == 1) ? 0 : 1;
        $banner->updated_by = Auth::id() ?? 1;
        $banner->updated_at = now();
        $banner->save();

        return redirect()->route('banner.index')->with('thongbao', 'Cập nhật trạng thái thành công');
    }
}
