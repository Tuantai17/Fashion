<?php

namespace App\Http\Controllers\backend;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use App\Models\Brand;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;




class ProductController extends Controller
{
/*index---------------------------------------------------------*/
    public function index()
    {
        $list = Product::select('product.id', 'product.name','category.name as categoryname','brand.name as brandname',
        'thumbnail','product.status')
            ->join ('category', 'product.category_id','=','category.id')
            ->join ('brand', 'product.brand_id','=','brand.id')
            ->orderBy('product.created_at','desc')
            ->paginate(5);
       return view('backend.product.index', compact('list'));
       
    }

/*create---------------------------------------------------------*/
    public function create()
    {
        $list_category = Category::select('name', 'id')->orderBy('sort_order', 'asc')->get();
        $list_brand = Brand::select('name', 'id')->orderBy('sort_order', 'asc')->get();
        return view("backend.product.create", compact('list_category', 'list_brand'));
    }

/*store---------------------------------------------------------*/
    public function store(Request $request)
    {
        $product = new Product();
        $product->name = $request->name;
        $product->slug = Str::of($request->name)->slug('-');
        $product->detail = $request->detail;
        $product->description = $request->description;
        $product->price_root = $request->price_root;
        $product->price_sale = $request->price_sale;
        $product->qty = $request->qty;
        $product->category_id = $request->category_id;
        $product->brand_id = $request->brand_id;
      
        if($request->hasFile('thumbnail')) {
            $file = $request->file('thumbnail');
            $extension = $file->getClientOriginalExtension();
            $filename = $product->slug.'.'.$extension;
            $destinationPath = public_path('assets/images/product'); // Định nghĩa đường dẫn thư mục

            // Kiểm tra và tạo thư mục nếu chưa tồn tại
            if (!file_exists($destinationPath)) {
                mkdir($destinationPath, 0777, true);
            }
        
            // Di chuyển file vào thư mục đích
            $file->move($destinationPath, $filename);
            $product->thumbnail = $filename;
        }


        $product->status = $request->status;
        $product->created_at = date('Y-m-d H:i:s');
        $product->created_by = Auth::id() ?? 1;
        $product->save();
        
        return redirect()->route('product.index')->with('thongbao', 'Thêm thành công');

    }

/*show---------------------------------------------------------*/
    public function show(string $id)
    {
        $product = Product::select('product.*', 'category.name as category_name', 'brand.name as brand_name')
            ->join('category', 'product.category_id', '=', 'category.id')
            ->join('brand', 'product.brand_id', '=', 'brand.id')
            ->where('product.id', $id)
            ->first();

        if (!$product) {
            return redirect()->route('product.index')->with('error', 'Không tìm thấy sản phẩm');
        }

        return view('backend.product.show', compact('product'));
    }


/*edit---------------------------------------------------------*/
    public function edit(string $id)
    {
        $product = Product::find($id);
        if ($product == null) {
            return redirect()->route('product.index');
        }
        $list_category = Category::select('id', 'name')->orderBy('sort_order', 'asc')->get();
        $list_brand = Brand::select('id', 'name')->orderBy('sort_order', 'asc')->get();

        return view('backend.product.edit', compact('list_category', 'list_brand', 'product'));
    }

/*update---------------------------------------------------------*/
    public function update(UpdateProductRequest $request, string $id)
    {
        $product = Product::find($id);
        if ($product == null) {
            return redirect()->route('product.index');
        }

        $slug = Str::of($request->name)->slug('-');
        $product->name = $request->name;
        
        $product->slug = $slug;
        $product->detail = $request->detail;
        $product->description = $request->description;
        $product->price_root = $request->price_root;
        $product->price_sale = $request->price_sale;
        $product->qty = $request->qty;
        $product->category_id = $request->category_id;
        $product->brand_id = $request->brand_id;

        // Xử lý ảnh mới nếu có upload
        if ($request->hasFile('thumbnail')) {
            $image_path = public_path('assets/images/product/' . $product->thumbnail);
            if (File::exists($image_path)) {
                File::delete($image_path);
            }

            $file = $request->file('thumbnail');
            $extension = $file->getClientOriginalExtension();
            $fileName = $slug . '.' . $extension;
            $file->move(public_path('assets/images/product'), $fileName);
            $product->thumbnail = $fileName;
        }

        $product->status = $request->status;
        $product->updated_by = Auth::id() ?? 1;
        $product->updated_at = now();
        $product->save();

        return redirect()->route('product.index')->with('thongbao', 'Cập nhật thành công');
    }

/*destroy---------------------------------------------------------*/
    public function destroy(string $id)
    {
        $product = Product::onlyTrashed()->find($id);
        if ($product == null) {
            return redirect()->route('product.trash');
        }
        $image_path = public_path('assets/images/product/' . $product->thumbnail);
        if($product->forceDelete())
        {
            if(File::exists($image_path)){
                File::delete($image_path);
            }
        }
        return redirect()->route('product.trash');
    }
/*trash---------------------------------------------------------*/
    public function trash()
    {
        $list = Product::select('product.id', 'product.name','category.name as categoryname','brand.name as brandname',
        'thumbnail','product.status')
            ->join ('category', 'product.category_id','=','category.id')
            ->join ('brand', 'product.brand_id','=','brand.id')
            ->orderBy('product.created_at','desc')
            ->onlyTrashed()
            ->paginate(5);
       return view('backend.product.trash', compact('list'));
    }
/*delete---------------------------------------------------------*/
    public function delete($id)
    {
        $product = Product::find($id);
        if ($product == null) {
            return redirect()->route('product.index');
        }
        $product->delete();
        return redirect()->route('product.index');
    }
/*status---------------------------------------------------------*/
    public function status($id)
    {
        $product = Product::find($id);
        if ($product == null) {
            return redirect()->route('product.index');
        }
        $product->status = ($product->status == 1)?0:1;
        $product->updated_by = Auth::id() ?? 1;
        $product->updated_at = date('Y-m-d H:i:s');
        $product->save();
        return redirect()->route('product.index');
    }
/*restore---------------------------------------------------------*/
    public function restore($id)
    {
        $product = Product::onlyTrashed()->find($id);
        if ($product == null) {
            return redirect()->route('product.index');
        }
        $product->restore();
        return redirect()->route('product.trash');
    }
  /*showByCategory---------------------------------------------------------*/
  public function showByCategory($category_slug)
  {
      $category = Category::where('slug', $category_slug)->first();

      if (!$category) {
          return redirect()->route('product.index')->with('error', 'Danh mục không tồn tại');
      }

      $products = Product::where('category_id', $category->id)->get();

      return view('frontend.products.category', compact('products', 'category'));
  } 
    
}



