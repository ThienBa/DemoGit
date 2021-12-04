<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', 'HomeController@index');
Route::get('home/search_header', 'HomeController@search_header');

Route::group(['prefix' => 'laravel-filemanager', 'middleware' => ['web', 'auth']], function () {
    \UniSharp\LaravelFilemanager\Lfm::routes();
});

Auth::routes(['verify' => true]);

// Route::get('/home', 'HomeController@index')->name('home')->middleware('verified');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('dashboard', 'DashboardController@show');
    Route::get('admin', 'DashboardController@show');

    Route::get('admin/user/list', 'AdminUserController@list');
    Route::middleware(['CheckRole:Admintrator'])->group(function () {
        Route::get('admin/user/add', 'AdminUserController@add');
        Route::post('admin/user/store', 'AdminUserController@store');
        Route::get('admin/user/delete/{id}', 'AdminUserController@delete')->name('delete_user');
        Route::post('admin/user/action', 'AdminUserController@action');
        Route::get('admin/user/edit/{id}', 'AdminUserController@edit')->name('user.edit');
        Route::post('admin/user/update/{id}', 'AdminUserController@update')->name('user.update');
    });
    
    Route::get('admin/page/list', 'AdminPageController@list');
    Route::middleware(['CheckRole:ManagerPage'])->group(function () {
        Route::get('admin/page/add', 'AdminPageController@add');
        Route::post('admin/page/store', 'AdminPageController@store')->name('page.store');
        Route::get('admin/page/edit/{id}', 'AdminPageController@edit');
        Route::post('admin/page/update/{id}', 'AdminPageController@update')->name('page.update');
        Route::get('admin/page/delete/{id}', 'AdminPageController@delete');
        Route::post('admin/page/action', 'AdminPageController@action');
    });
    
    Route::get('admin/post/list', 'AdminPostController@list');
    Route::get('admin/post/cat/list', 'AdminPostCatController@list');
    Route::middleware(['CheckRole:ManagerPost'])->group(function () {
        Route::get('admin/post/add', 'AdminPostController@add');
        Route::post('admin/post/store', 'AdminPostController@store')->name('post.store');
        Route::get('admin/post/edit/{id}', 'AdminPostController@edit');
        Route::get('admin/post/delete/{id}', 'AdminPostController@delete');
        Route::post('admin/post/action', 'AdminPostController@action');
        Route::post('admin/post/update/{id}', 'AdminPostController@update')->name('post.update');
        Route::post('admin/post/cat/add', 'AdminPostCatController@add');

        Route::get('admin/post/cat/delete/{id}', 'AdminPostCatController@delete');
        Route::get('admin/post/cat/edit/{id}', 'AdminPostCatController@edit');
        Route::post('admin/post/cat/update/{id}', 'AdminPostCatController@update');
    });

    Route::get('admin/product/list', 'AdminProductController@list');
    Route::get('admin/product/cat/list', 'AdminProductCatController@list');
    Route::middleware(['CheckRole:ManagerProduct'])->group(function () {
        Route::get('admin/product/add', 'AdminProductController@add');
        Route::post('admin/product/store', 'AdminProductController@store')->name('product.store');
        Route::get('admin/product/edit/{id}', 'AdminProductController@edit');
        Route::get('admin/product/delete/{id}', 'AdminProductController@delete');
        Route::post('admin/product/action', 'AdminProductController@action');
        Route::post('admin/product/update/{id}', 'AdminProductController@update')->name('product.update');
        Route::post('admin/product/cat/add', 'AdminProductCatController@add');

        Route::get('admin/product/cat/delete/{id}', 'AdminProductCatController@delete');
        Route::get('admin/product/cat/edit/{id}', 'AdminProductCatController@edit');
        Route::post('admin/product/cat/update/{id}', 'AdminProductCatController@update');
    });

    Route::get('admin/order/list', 'AdminOrderController@list');
    Route::middleware(['CheckRole:ManagerOrder'])->group(function () {
        Route::get('admin/order/edit/{id}', 'AdminOrderController@edit');
        Route::post('admin/order/update/{id}', 'AdminOrderController@update')->name('order.update');
        Route::get('admin/order/delete/{id}', 'AdminOrderController@delete');
        Route::post('admin/order/action', 'AdminOrderController@action');
    });
});

Route::get('san-pham', 'ProductController@show');
Route::get('danh-muc/{cat_id}-{slug}', 'ProductController@list');
Route::get('danh-muc/{cat_name}', 'ProductController@show_cat');
Route::get('san-pham/{id}-{slug}', 'ProductController@detail');
Route::get('product/search_fillter', 'ProductController@search_fillter');


Route::get('bai-viet', 'PostController@show');
Route::get('bai-viet/{id}-{slug}', 'PostController@detail');

Route::get('{id}-{slug}', 'PageController@detail');

Route::get('cart', 'CartController@show');
Route::get('them-gio-hang/{id}-{slug}', 'CartController@add');
Route::get('destroy', 'CartController@destroy');
Route::get('remove/{row_Id}', 'CartController@remove');
Route::post('cart/update', 'CartController@update');
Route::get('cart/update_ajax', 'CartController@update_ajax');

Route::get('checkout', 'CheckoutController@checkout');
Route::post('checkout/store', 'CheckoutController@store');
Route::get('mua-ngay/{id}-{slug}', 'CheckoutController@buy_now');
Route::post('checkout/store_buyNow/{id}', 'CheckoutController@store_buyNow');

Route::get('thank', 'CheckoutController@thank');

