<?php

namespace App\Http\Controllers\backend;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreMenuRequest;
use Illuminate\Http\Request;
use App\Models\Menu;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;


class MenuController extends Controller
{
/*index---------------------------------------------------------*/
    public function index()
    {
        $list = Menu::select('id', 'name', 'link', 'parent_id', 'sort_order', 'type', 'position', 'status')
            ->orderBy('sort_order', 'asc')
            ->paginate(5);

        return view('backend.menu.index', compact('list'));
    }

/*create---------------------------------------------------------*/
    public function create()
    {
        $menus = Menu::all(); // hoặc where('status', 1)
        return view('backend.menu.create', compact('menus'));
    }

/*store---------------------------------------------------------*/
    public function store(StoreMenuRequest $request)
    {
        $data = $request->validated();
        $data['created_by'] = auth()->id() ?? 0;

        Menu::create($data);

        return redirect()->route('menu.index')->with('success', 'Thêm menu thành công!');
    }

/*show---------------------------------------------------------*/
    public function show(string $id)
    {
        // Lấy thông tin menu từ database
        $menu = Menu::find($id);
        if (!$menu) {
            return redirect()->route('menu.index')->with('error', 'Không tìm thấy menu');
        }
        
        // Truyền dữ liệu menu vào view
        return view('backend.menu.show', compact('menu'));
    }

    
    
// edit---------------------------------------------------------
    public function edit(string $id)
    {
        $menu = Menu::find($id);
        if ($menu == null) {
            return redirect()->route('menu.index')->with('error', 'Menu không tồn tại!');
        }

        $menus = Menu::where('id', '!=', $id)->get(); // loại trừ chính nó để tránh tự làm parent

        return view('backend.menu.edit', compact('menu', 'menus'));
    }

// update-------------------------------------------------------
    public function update(Request $request, string $id)
    {
        $menu = Menu::find($id);
        if ($menu == null) {
            return redirect()->route('menu.index')->with('error', 'Menu không tồn tại!');
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'link' => 'nullable|string|max:255',
            'parent_id' => 'nullable|integer|different:id',
            'sort_order' => 'nullable|integer',
            'type' => 'required|string',
            'position' => 'required|string',
            'status' => 'required|in:0,1',
        ]);

        $slug = Str::slug($request->name);

        $menu->name = $request->name;
        $menu->link = $request->link;
        $menu->parent_id = $request->parent_id ?? 0;
        $menu->sort_order = $request->sort_order ?? 0;
        $menu->type = $request->type;
        $menu->position = $request->position;
        $menu->status = $request->status;
        $menu->updated_by = Auth::id() ?? 1;
        $menu->updated_at = now();

        $menu->save();

        return redirect()->route('menu.index')->with('success', 'Cập nhật menu thành công!');
    }

/*destroy---------------------------------------------------------*/
    public function destroy(string $id)
    {
        $menu = Menu::onlyTrashed()->find($id);
        if ($menu == null) {
            return redirect()->route('menu.trash');
        }

        $menu->forceDelete(); // Xóa menu vĩnh viễn khỏi database

        return redirect()->route('menu.trash');
    }


/*trash---------------------------------------------------------*/
    public function trash()
    {
        $list = Menu::select('id', 'name', 'link', 'parent_id', 'sort_order', 'type', 'position', 'status')
            ->orderBy('created_at', 'desc')
            ->onlyTrashed() // Lấy các menu đã bị xóa
            ->paginate(5);

        return view('backend.menu.trash', compact('list'));
    }

/*delete---------------------------------------------------------*/
    public function delete($id)
    {
        $menu = Menu::find($id);
        if ($menu == null) {
            return redirect()->route('menu.index');
        }
        $menu->delete(); // Xóa menu (soft delete)
        return redirect()->route('menu.index');
    }

/*status---------------------------------------------------------*/
    public function status($id)
    {
        $menu = Menu::find($id);
        if ($menu == null) {
            return redirect()->route('menu.index');
        }

        // Đảo ngược trạng thái của menu
        $menu->status = ($menu->status == 1) ? 0 : 1;
        $menu->updated_by = Auth::id() ?? 1;
        $menu->updated_at = date('Y-m-d H:i:s');
        $menu->save();

        return redirect()->route('menu.index');
    }

/*restore---------------------------------------------------------*/
    public function restore($id)
    {
        $menu = Menu::onlyTrashed()->find($id);
        if ($menu == null) {
            return redirect()->route('menu.trash');
        }

        $menu->restore(); // Khôi phục menu đã bị xóa (soft deleted)
        return redirect()->route('menu.trash');
    }

}
