<?php

use App\Http\Controllers\admin\AdminAddressController;
use App\Http\Controllers\admin\AdminCategoryController;
use App\Http\Controllers\admin\AdminController;
use App\Http\Controllers\admin\AdminEmailController;
use App\Http\Controllers\admin\AdminImageController;
use App\Http\Controllers\admin\AdminOrderController;
use App\Http\Controllers\admin\AdminPostController;
use App\Http\Controllers\admin\AdminProductController;
use App\Http\Controllers\admin\AdminProductReviewController;
use App\Http\Controllers\admin\AdminMenuController;
use App\Http\Controllers\admin\AdminStatisticalController;
use App\Http\Controllers\admin\AdminUserController;
use App\Http\Controllers\client\AuthController;
use App\Http\Controllers\client\CartController;
use App\Http\Controllers\client\CheckoutController;
use App\Http\Controllers\client\ContactController;
use App\Http\Controllers\client\GoogleController;
use App\Http\Controllers\client\HomeController;
use App\Http\Controllers\client\PostController;
use App\Http\Controllers\client\ProductController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// client
Route::get('/', [HomeController::class, 'index'])->name('home');

// Auth
Route::get('/login', [AuthController::class, 'pageLogin'])->name('client.login');
Route::post('/login', [AuthController::class, 'login'])->name('client.handleLogin');
Route::get('/register', [AuthController::class, 'pageRegister'])->name('client.register');
Route::post('/register', [AuthController::class, 'register'])->name('client.handleRegister');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::prefix('auth')->group(function () {
    Route::get('/google', [GoogleController::class, 'redirectToGoogle'])->name('auth.google');
    Route::get('/google/callback', [GoogleController::class, 'handleGoogleCallback']);
    Route::get('/facebook', [GoogleController::class, 'redirectToFacebook'])->name('auth.facebook');
    Route::get('/facebook/callback', [GoogleController::class, 'handleFacebookCallback']);

    Route::get('/forgot-password', [AuthController::class, 'forgot_password'])->name('client.forgot-password');
    Route::post('/check-forgot-password', [AuthController::class, 'check_forgot_password'])->name('client.check_forgot_password');
    Route::get('/reset-password/{token}', [AuthController::class, 'reset_password'])->name('client.reset-password');
    Route::post('/reset-password/{token}', [AuthController::class, 'check_reset_password']);
});

Route::prefix('checkout')->group(function () {
    Route::get('/', [CheckoutController::class, 'checkout'])->name('client.checkout');
    Route::post('/store', [CheckoutController::class, 'order'])->name('client.order.store');
});

// get address
Route::get('/get-districts/{provinveId}', [HomeController::class, 'getDistrict']);
Route::get('/get-wards/{districtId}', [HomeController::class, 'getWard']);

Route::prefix('san-pham')->group(function () {
    Route::get('/', [ProductController::class, 'index'])->name('client.product');

    Route::get('/{category}/{product}-{id}', [ProductController::class, 'productDetail'])
        ->name('client.product-detail')
        ->where([
            'product' => '.+',
            'id' => '[0-9]+'
        ]);

    Route::get('/{category}-{id}', [ProductController::class, 'category'])
        ->name('client.category')
        ->where([
            'category' => '.+',
            'id' => '[0-9]+'
        ]);

    Route::post('/danh-gia', [ProductController::class, 'productReview'])->name('client.product.review');
});

Route::prefix('danh-muc-bai-viet')->group(function () {
    Route::get('/{post_category_alias}', [PostController::class, 'index'])->name('client.post.category');
    Route::get('/{post_category_alias}/{post_alias}', [PostController::class, 'singlePost'])->name('client.post');
});

Route::prefix('gio-hang')->group(function () {
    Route::get('/', [CartController::class, 'cart'])->name('client.cart');
    Route::post('/add', [CartController::class, 'addToCart'])->name('client.addToCart');
    Route::post('/update-quantity', [CartController::class, 'updateQuantityCart'])->name('client.cart.update');
    Route::get('/remove/{productId}', [CartController::class, 'deleteCartItem'])->name('client.cart.remove');
    Route::post('/buy-now', [CartController::class, 'buyNow'])->name('client.buyNow');
});

Route::prefix('lien-he')->group(function () {
    Route::get('/', [ContactController::class, 'index'])->name('client.contact');
    Route::post('/dang-ky', [ContactController::class, 'subscriber'])->name('client.subscriber');
});

// đăng nhập admin
Route::get('/logon', [AdminController::class, 'formLogon'])->name('formLogon');
Route::post('/logon', [AdminController::class, 'logon'])->name('logon');
// admin
Route::prefix('admin')->middleware('admin')->group(function () {
    // ckeditor
    Route::get('/', [AdminController::class, 'index'])->name('admin.dashboard');
    Route::post('/uploads-ckeditor', [AdminController::class, 'ckeditorImage']);
    Route::get('/file-browser', [AdminController::class, 'fileBrowser']);

    // cấu hình chung
    Route::get('/configs', [AdminController::class, 'config'])->name('admin.config');
    Route::post('/configs', [AdminController::class, 'updateConfig'])->name('admin.config.update');

    // đổi mật khẩu
    Route::get('/doi-mat-khau/{adminId}', [AdminController::class, 'formChangePassword'])->name('admin.password.change');
    Route::post('/doi-mat-khau/{adminId}', [AdminController::class, 'changePassword'])->name('admin.password.update');

    Route::prefix('/thong-ke')->group(function () {
        Route::get('/doanh-thu', [AdminStatisticalController::class, 'getRevenueData'])->name('admin.statistical.revenue');
    });

    Route::prefix('danh-muc-san-pham')->group(function () {
        Route::get('/', [AdminCategoryController::class, 'index'])->name('admin.category.product');
        Route::post('/change-status', [AdminCategoryController::class, 'changeStatus'])->name('admin.category.product.change-status');

        Route::get('/them-danh-muc', [AdminCategoryController::class, 'addCategory'])->name('admin.category.product.add');
        Route::post('/them-danh-muc', [AdminCategoryController::class, 'storeCategory'])->name('admin.category.product.store');

        Route::get('/sua-danh-muc/{categoryId}', [AdminCategoryController::class, 'editCategory'])->name('admin.category.product.edit');
        Route::post('/update', [AdminCategoryController::class, 'updateCategory'])->name('admin.category.product.update');
        Route::post('/xoa-danh-muc/{categoryId}', [AdminCategoryController::class, 'deleteCategory']);
    });

    Route::prefix('san-pham')->group(function () {
        Route::get('/', [AdminProductController::class, 'index'])->name('admin.product');
        Route::get('/them-san-pham', [AdminProductController::class, 'addProduct'])->name('admin.product.add');
        Route::post('/them-san-pham', [AdminProductController::class, 'storeProduct'])->name('admin.product.store');

        Route::get('/sua-san-pham/{productId}', [AdminProductController::class, 'editProduct'])->name('admin.product.edit');
        Route::post('/sua-san-pham', [AdminProductController::class, 'updateProduct'])->name('admin.product.update');

        Route::post('/change-status', [AdminProductController::class, 'changeStatus'])->name('admin.product.change-status');
        Route::post('/xoa-san-pham/{productId}', [AdminProductController::class, 'deleteProduct'])->name('admin.product.delete');

        Route::get('/doanh-thu', [AdminProductController::class, 'revenue'])->name('admin.product.revenue');
    });

    Route::prefix('binh-luan')->group(function () {
        Route::get('/', [AdminProductReviewController::class, 'index'])->name('admin.comment');
        Route::post('/change-status', [AdminProductReviewController::class, 'changeStatus'])->name('admin.comment.change-status');
        Route::post('/xoa-binh-luan/{reviewId}', [AdminProductReviewController::class, 'deleteComment']);
        Route::get('/sua-binh-luan/{reviewId}', [AdminProductReviewController::class, 'editReview'])->name('admin.comment.edit');
        Route::post('/sua-binh-luan/{reviewId}', [AdminProductReviewController::class, 'updateReview'])->name('admin.comment.update');
    });

    Route::prefix('menu')->group(function () {
        Route::get('/', [AdminMenuController::class, 'index'])->name('admin.menu');
        Route::get('/them-menu', [AdminMenuController::class, 'addMenu'])->name('admin.menu.add');
        Route::post('/them-menu', [AdminMenuController::class, 'storeMenu'])->name('admin.menu.store');

        Route::get('/sua-menu/{menuId}', [AdminMenuController::class, 'editMenu'])->name('admin.menu.edit');
        Route::post('/sua-menu/{menuId}', [AdminMenuController::class, 'updateMenu'])->name('admin.menu.update');
        Route::post('/change-status', [AdminMenuController::class, 'changeStatus'])->name('admin.menu.change-status');
        Route::post('/xoa-menu/{menuId}', [AdminMenuController::class, 'deleteMenu']);
    });

    Route::prefix('danh-muc-bai-viet')->group(function () {
        Route::get('/', [AdminPostController::class, 'index'])->name('admin.category.post');
        Route::get('/them-danh-muc', [AdminPostController::class, 'addCategory'])->name('admin.category.post.add');
        Route::post('/them-danh-muc', [AdminPostController::class, 'storeCategory'])->name('admin.category.post.store');
        Route::post('/change-status', [AdminPostController::class, 'changeStatus'])->name('admin.category.post.change-status');
        Route::get('/sua-danh-muc/{categoryId}', [AdminPostController::class, 'editCategory'])->name('admin.category.post.edit');
        Route::post('/sua-danh-muc/{categoryId}', [AdminPostController::class, 'updateCategory'])->name('admin.category.post.update');
        Route::post('/xoa-danh-muc/{categoryId}', [AdminPostController::class, 'deleteCategory'])->name('admin.category.post.delete');
    });

    Route::prefix('bai-viet')->group(function () {
        Route::get('/', [AdminPostController::class, 'post'])->name('admin.post');
        Route::post('/change-status', [AdminPostController::class, 'changeStatusPost'])->name('admin.post.change-status');
        Route::get('/them-bai-viet', [AdminPostController::class, 'addPost'])->name('admin.post.add');
        Route::post('/them-bai-viet', [AdminPostController::class, 'storePost'])->name('admin.post.store');
        Route::get('/sua-bai-viet/{postId}', [AdminPostController::class, 'editPost'])->name('admin.post.edit');
        Route::post('/sua-bai-viet/{postId}', [AdminPostController::class, 'updatePost'])->name('admin.post.update');
        Route::post('/xoa-bai-viet/{postId}', [AdminPostController::class, 'deletePost']);
    });

    Route::prefix('don-hang')->group(function () {
        Route::get('/', [AdminOrderController::class, 'index'])->name('admin.order');
        Route::post('/change-status', [AdminOrderController::class, 'changeStatus'])->name('admin.order.change-status');
        Route::get('/chi-tiet/{orderId}', [AdminOrderController::class, 'detailOrder'])->name('admin.order.detail');
        Route::post('/xoa-don-hang/{orderId}', [AdminOrderController::class, 'deleteOrder']);
    });

    Route::prefix('khach-hang')->group(function () {
        Route::get('/', [AdminUserController::class, 'index'])->name('admin.user');
        Route::get('/xem-chi-tiet/{userId}', [AdminUserController::class, 'userDetail'])->name('admin.user.detail');
    });

    Route::prefix('hinh-anh')->group(function () {
        Route::get('/', [AdminImageController::class, 'index'])->name('admin.image');
        Route::post('/change-status', [AdminImageController::class, 'changeStatus'])->name('admin.image.change-status');
        Route::post('/xoa-hinh-anh/{imageId}', [AdminImageController::class, 'deleteImage']);
        Route::get('/them-hinh-anh', [AdminImageController::class, 'addImage'])->name('admin.image.add');
        Route::post('/them-hinh-anh', [AdminImageController::class, 'storeImage'])->name('admin.image.store');
    });

    Route::prefix('dia-chi')->group(function () {
        Route::get('/tinh-thanh', [AdminAddressController::class, 'province'])->name('admin.address.province');
        Route::get('/quan-huyen', [AdminAddressController::class, 'district'])->name('admin.address.district');
        Route::get('/sua-tinh-thanh/{provinceId}', [AdminAddressController::class, 'editProvince'])->name('admin.address.province.edit');
        Route::post('/sua-tinh-thanh/{provinceId}', [AdminAddressController::class, 'updateProvince'])->name('admin.address.province.update');
        Route::get('/them-tinh-thanh', [AdminAddressController::class, 'addProvince'])->name('admin.address.province.add');
        Route::post('/them-tinh-thanh', [AdminAddressController::class, 'storeProvince'])->name('admin.address.province.store');
        Route::post('/xoa-dia-chi/{address}/{addressId}', [AdminAddressController::class, 'deleteAddress']);
        Route::get('/them-quan-huyen', [AdminAddressController::class, 'addDistrict'])->name('admin.address.district.add');
        Route::post('/them-quan-huyen', [AdminAddressController::class, 'storeDistrict'])->name('admin.address.district.store');
        Route::get('/sua-quan-huyen/{districtId}', [AdminAddressController::class, 'editDistrict'])->name('admin.address.district.edit');
        Route::post('/sua-quan-huyen/{districtId}', [AdminAddressController::class, 'updateDistrict'])->name('admin.address.district.update');
    });

    Route::prefix('email')->group(function () {

        Route::get('/email-dang-ky', [AdminEmailController::class, 'emailSubscribers'])->name('admin.email.subscribers');
        Route::post('/xoa-email-dang-ky/{subscriberId}', [AdminEmailController::class, 'deleteEmailSubscribers']);
        Route::post('/email-dang-ky/change-status', [AdminEmailController::class, 'changeStatus'])->name('admin.email.subscribers.change-status');

        Route::prefix('mau-email')->group(function () {
            Route::get('/', [AdminEmailController::class, 'templates'])->name('admin.email.templates');
            Route::get('/them', [AdminEmailController::class, 'addTemplate'])->name('admin.email.template.add');
            Route::post('/them', [AdminEmailController::class, 'storeTemplate'])->name('admin.email.template.store');
            Route::get('/sua/{templateId}', [AdminEmailController::class, 'editTemplate'])->name('admin.email.template.edit');
            Route::post('/sua/{templateId}', [AdminEmailController::class, 'updateTemplate'])->name('admin.email.template.update');
            Route::post('/xoa/{templateId}', [AdminEmailController::class, 'deleteTemplate']);
            Route::get('/gui-email/{templateId}', [AdminEmailController::class, 'emailDetail'])->name('admin.email.detail');
            Route::post('/gui-email/{templateId}', [AdminEmailController::class, 'sendEmail'])->name('admin.email.send');
        });

        Route::prefix('nhat-ky')->group(function () {
            Route::get('/', [AdminEmailController::class, 'logs'])->name('admin.email.logs');
            Route::get('/chi-tiet/{logId}', [AdminEmailController::class, 'logDetail'])->name('admin.email.logs.detail');
            Route::post('/retry/{logId}', [AdminEmailController::class, 'retry'])->name('admin.email.logs.retry');
            Route::post('/xoa/{logId}', [AdminEmailController::class, 'deleteLog']);
        });
    });
});