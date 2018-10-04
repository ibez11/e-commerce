<?php

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

// Route::get('/', function () {
//     return view('common/home');
// });

Route::get('/',['uses' => 'common\HomeController@index', 'as' => 'home']);
Route::get('/login','Auth\LoginController@index');
Route::get('/register',['uses' => 'Auth\RegisterController@index', 'as' => 'register']);
Route::post('/register',['uses' => 'Auth\RegisterController@index', 'as' => 'register']);
Route::post('/login/customer',['uses' => 'Auth\LoginController@customer', 'as' => 'login']);
Route::get('/logout',['uses' => 'Auth\LogoutController@index', 'as' => 'logout']);
Route::get('/my_shop',['uses' => 'Shop\MyShopController@index', 'as' => 'my_shop']);
Route::get('/cart',['uses' => 'common\CartController@index', 'as' => 'cart']);
Route::get('/order',['uses' => 'Account\OrderController@index', 'as' => 'order']);
Route::post('/location/zone',['uses' => 'common\ZoneController@zone', 'as' => 'zone']);
Route::post('/location/state',['uses' => 'common\ZoneController@state', 'as' => 'state']);
Route::post('/cart/add',['uses' => 'common\CartController@add', 'as' => 'add_cart']);
Route::get('/product',['uses' => 'Product\ProductController@index', 'as' => 'product']);
Route::post('/upload_files',['uses' => 'Tool\UploadController@index', 'as' => 'upload_files']);
Route::post('/my_shop/update_banner',['uses' => 'Shop\MyShopController@updateBanner', 'as' => 'update_banner']);
Route::post('/my_shop',['uses' => 'Shop\MyShopController@index', 'as' => 'add_shop']);
Route::get('/my_shop/product/add_product',['uses' => 'Shop\ProductController@add', 'as' => 'add_product']);
Route::get('/my_shop/product/edit_product',['uses' => 'Shop\ProductController@edit', 'as' => 'edit_product']);
Route::get('/checkout',['uses' => 'Checkout\CheckoutController@index', 'as' => 'checkout']);
Route::post('/checkout',['uses' => 'Checkout\CheckoutController@index', 'as' => 'pay']);
Route::post('/my_shop/product/edit_product',['uses' => 'Shop\ProductController@edit', 'as' => 'edit_product']);
Route::post('/my_shop/product/add_product',['uses' => 'Shop\ProductController@add', 'as' => 'add_product']);
Route::post('/my_shop/product/update_image_product',['uses' => 'Shop\ProductController@updateImageProduct', 'as' => 'update_image_product']);
Route::get('/my_shop/product',['uses' => 'Shop\ProductController@index', 'as' => 'my_product']); 
Route::get('/s/{shop_name}',['uses' => 'Shop\SellerController@index', 'as' => '{shop_name}']);
Route::get('/c/{category_name}',['uses' => 'Product\CategoryController@index', 'as' => '{category_name}']);
Route::get('/p/{shop_name}/{product_name}',['uses' => 'Product\ProductController@index', 'as' => '{product_name}']);
 


// Route::post('login_customer',function (Request $request) {
//     $login_customer = LoginController::all();
//     return $login_customer;
// });

// Route::get('/login', function () {
//     return view('auth/login');
// });
