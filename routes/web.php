<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\frontend\HomeController;
use App\Http\Controllers\frontend\ProductController as SanphamController;
use App\Http\Controllers\frontend\ContactController as LienheController;
use App\Http\Controllers\frontend\PostController as BaivietController;
use App\Http\Controllers\frontend\TopicController as ChudeController;
use App\Http\Controllers\frontend\LoginController;
use App\Http\Controllers\frontend\MenuController as NavController;
use App\Http\Controllers\frontend\BrandController as ThuonghieuController;
use App\Http\Controllers\frontend\CategoryController as DanhmucController;


use App\Http\Controllers\frontend\UserController as NguoiDungController;



use App\Http\Controllers\backend\AuthController;
use App\Http\Controllers\backend\DashboardController;
use App\Http\Controllers\backend\ContactController;
use App\Http\Controllers\backend\MenuController;
use App\Http\Controllers\backend\BrandController;
use App\Http\Controllers\backend\BannerController;
use App\Http\Controllers\backend\TopicController;
use App\Http\Controllers\backend\PostController;
use App\Http\Controllers\backend\CategoryController;
use App\Http\Controllers\backend\OrderController;
use App\Http\Controllers\backend\ProductController;
use App\Http\Controllers\backend\UserController;



// routes/web.php
Route::get('/health', fn() => response('ok', 200));





Route::get('loginuser', [HomeController::class, 'loginuser'])->name('site.loginuser');
Route::post('dologin', [HomeController::class, 'dologinuser'])->name('site.dologinuser');

//shop
Route::get('/', [HomeController::class, 'index'])->name('site.home');
Route::get('/product', [SanphamController::class, 'index'])->name('site.product');
Route::get('/san-pham/{slug}', [sanphamController::class, 'detail'])->name('site.product.detail');
Route::get('/detail', [SanphamController::class, 'detail'])->name('site.detail');
Route::get('/contact', [LienheController::class, 'index'])->name('site.contact');
Route::post('dologin', [HomeController::class, 'dologinuser'])->name('site.dologinuser');

// Route::get('/account', [UserController::class, 'account'])->name('user.account');
// Route::get('/register', [HomeController::class, 'register'])->name('frontend.register');
// Route::post('/register', [HomeController::class, 'handleRegister'])->name('frontend.handleRegister');





Route::get('/danh-muc/{category_slug}', [SanPhamController::class, 'byCategory'])->name('site.product.byCategory');












Route::get('tim-kiem', [HomeController::class, 'searchProduct'])->name('site.product.search');

Route::get('dang-ky', [UserController::class, 'registerForm'])->name('user.register.form');
Route::post('/dang-ky', [UserController::class, 'doRegister'])->name('user.register');

Route::post('/logout', function () {
    Auth::logout();
    return redirect()->route('user.register.form')->with('success', 'Bạn đã đăng xuất thành công!');
})->name('logout');

// Đảm bảo người dùng đã đăng nhập trước khi truy cập vào trang tài khoản
Route::middleware('auth')->get('/account', [HomeController::class, 'accountInfo'])->name('user.account');

// Đảm bảo người dùng đã đăng nhập trước khi cập nhật thông tin tài khoản
// Route::middleware('auth')->group(function () {
//     Route::get('/checkout', [CheckoutController::class, 'index'])->name('site.cart.checkout');
// });
// ✅ Route xử lý login frontend
Route::post('/loginngdung', [NguoiDungController::class, 'loginuser'])->name('login.store');
Route::get('/loginngdung', [NguoiDungController::class, 'loginuser'])->name('loginngdung');


// Route cho form đăng nhập của shop
Route::get('/loginuser', [UserController::class, 'showLoginForm'])->name('site.loginuser');



Route::get('/about', [HomeController::class, 'about'])->name('site.about');

Route::get('/bai-viet/{slug}', [PostController::class, 'detail'])->name('site.post.detail');
Route::get('/chu-de/{slug}', [TopicController::class, 'detail'])->name('site.topic.detail');
Route::get('/tat-ca-bai-viet', [HomeController::class, 'allPosts'])->name('site.posts.all');
Route::get('chi-tiet-bai-viet/{slug}', [HomeController::class, 'detail'])->name('site.post.detail');


// giỏ hàng
Route::get('/gio-hang', [SanPhamController::class, 'cart'])->name('site.cart');
Route::post('/them-vao-gio-hang', [SanPhamController::class, 'addToCart'])->name('site.cart.add');
Route::post('/cap-nhat-so-luong', [SanPhamController::class, 'updateCart'])->name('site.cart.update');
Route::post('/xoa-gio-hang', [SanPhamController::class, 'removeFromCart'])->name('site.cart.remove');

Route::post('/xoa-toan-bo-gio-hang', function () {
    session()->forget('cart');
    return redirect()->back()->with('success', 'Đã xóa toàn bộ giỏ hàng!');
})->name('site.cart.clear');
Route::post('/thanh-toan', [SanPhamController::class, 'checkout'])->name('site.cart.checkout');
Route::get('/thanh-toan', [SanPhamController::class, 'checkoutForm'])->name('site.cart.checkout');
Route::post('/thanh-toan', [SanPhamController::class, 'checkoutSubmit'])->name('site.cart.checkout.submit');

Route::get('/danh-muc/{slug}', [SanPhamController::class, 'productByCategory'])->name('site.by-category');
Route::get('/thuong-hieu/{slug}', [SanPhamController::class, 'productByBrand'])->name('site.by-brand');



//admin

Route::get('login', [AuthController::class, 'login'])->name('admin.login');
Route::post('login', [AuthController::class, 'dologin'])->name('admin.dologin');


Route::prefix('admin')->middleware('loginadmin')->group(function () {
    // Route::prefix('admin')->group (function () {

    Route::get('/', [DashboardController::class, 'index'])->name('admin.dashboard');

    Route::get('logout', [AuthController::class, 'logout'])->name('admin.logout');
    //product
    Route::prefix('product')->group(function () {
        Route::get('trash', [ProductController::class, 'trash'])->name('product.trash');
        Route::get('delete/{product}', [ProductController::class, 'delete'])->name('product.delete');
        Route::get('restore/{product}', [ProductController::class, 'restore'])->name('product.restore');
        Route::get('status/{product}', [ProductController::class, 'status'])->name('product.status');
    });

    Route::resource('product', ProductController::class);

    //category
    Route::prefix('category')->group(function () {
        Route::get('trash', [CategoryController::class, 'trash'])->name('category.trash');
        Route::get('delete/{category}', [CategoryController::class, 'delete'])->name('category.delete');
        Route::get('restore/{category}', [CategoryController::class, 'restore'])->name('category.restore');
        Route::get('status/{category}', [CategoryController::class, 'status'])->name('category.status');
    });

    Route::resource('category', CategoryController::class);

    //brand
    Route::prefix('brand')->group(function () {
        Route::get('trash', [BrandController::class, 'trash'])->name('brand.trash');
        Route::get('delete/{brand}', [BrandController::class, 'delete'])->name('brand.delete');
        Route::get('restore/{brand}', [BrandController::class, 'restore'])->name('brand.restore');
        Route::get('status/{brand}', [BrandController::class, 'status'])->name('brand.status');
    });

    Route::resource('brand', BrandController::class);

    //banner
    Route::prefix('banner')->group(function () {
        Route::get('trash', [BannerController::class, 'trash'])->name('banner.trash');
        Route::get('delete/{banner}', [BannerController::class, 'delete'])->name('banner.delete');
        Route::get('restore/{banner}', [BannerController::class, 'restore'])->name('banner.restore');
        Route::get('status/{banner}', [BannerController::class, 'status'])->name('banner.status');
    });

    Route::resource('banner', BannerController::class);

    //contact

    Route::prefix('contact')->group(function () {
        Route::get('trash', [ContactController::class, 'trash'])->name('contact.trash');
        Route::get('delete/{contact}', [ContactController::class, 'delete'])->name('contact.delete');
        Route::get('restore/{contact}', [ContactController::class, 'restore'])->name('contact.restore');
        Route::get('status/{contact}', [ContactController::class, 'status'])->name('contact.status');
        Route::get('contact/{id}/reply', [ContactController::class, 'replyForm'])->name('contact.reply');
        Route::post('contact/{id}/reply', [ContactController::class, 'replySubmit'])->name('contact.reply.submit');
    });

    Route::resource('contact', ContactController::class);


    //menu
    Route::prefix('menu')->group(function () {
        Route::get('trash', [MenuController::class, 'trash'])->name('menu.trash');
        Route::get('delete/{menu}', [MenuController::class, 'delete'])->name('menu.delete');
        Route::get('restore/{menu}', [MenuController::class, 'restore'])->name('menu.restore');
        Route::get('status/{menu}', [MenuController::class, 'status'])->name('menu.status');
    });

    Route::resource('menu', MenuController::class);


    //order
    Route::prefix('order')->group(function () {
        Route::get('trash', [OrderController::class, 'trash'])->name('order.trash');
        Route::get('delete/{order}', [OrderController::class, 'delete'])->name('order.delete');
        Route::get('restore/{order}', [OrderController::class, 'restore'])->name('order.restore');
        Route::get('status/{order}', [OrderController::class, 'status'])->name('order.status');
        Route::get('admin/order/{id}', [OrderController::class, 'show'])->name('order.show');
    });

    Route::resource('order', OrderController::class);
    //post
    Route::prefix('post')->group(function () {
        Route::get('trash', [PostController::class, 'trash'])->name('post.trash');
        Route::get('delete/{post}', [PostController::class, 'delete'])->name('post.delete');
        Route::get('restore/{post}', [PostController::class, 'restore'])->name('post.restore');
        Route::get('status/{post}', [PostController::class, 'status'])->name('post.status');
    });

    Route::resource('post', PostController::class);

    //topic
    Route::prefix('topic')->group(function () {
        Route::get('trash', [TopicController::class, 'trash'])->name('topic.trash');
        Route::get('delete/{topic}', [TopicController::class, 'delete'])->name('topic.delete');
        Route::get('restore/{topic}', [TopicController::class, 'restore'])->name('topic.restore');
        Route::get('status/{topic}', [TopicController::class, 'status'])->name('topic.status');
    });

    Route::resource('topic', TopicController::class);



    Route::prefix('user')->group(function () {
        Route::get('trash', [UserController::class, 'trash'])->name('user.trash');
        Route::get('delete/{user}', [UserController::class, 'delete'])->name('user.delete');
        Route::get('restore/{user}', [UserController::class, 'restore'])->name('user.restore');
        Route::get('status/{user}', [UserController::class, 'status'])->name('user.status');
    });

    Route::resource('user', UserController::class);
});
