<?php

use App\Http\Controllers\API\Auth;
use App\Http\Controllers\API\Cart;
use App\Http\Controllers\API\Category;
use App\Http\Controllers\API\Frontend;
use App\Http\Controllers\API\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Auth Portals for application users
Route::post('login', [Auth::class, 'LoginUser']);
Route::post('register', [Auth::class, 'RegisterUser']);
Route::post('login/seller', [Auth::class, 'LoginSeller']);

Route::get('getcollections', [Frontend::class, 'Collect']);
Route::get('collections/{slug}', [Frontend::class, 'SubCollect']);
Route::get('collections/{category}/{product}', [Frontend::class, 'ItemCollect']);
Route::post('add-to-cart', [Cart::class, 'AddToCart']);

Route::get('Category', [Category::class, 'Index']); //done
Route::post('Store-Category', [Category::class, 'Store']); //done
Route::get('Category/Edit-Category/{id}', [Category::class, 'Edit']);
Route::post('Update-Category/{id}', [Category::class, 'Update']);
Route::post('Delete-Category/{id}', [Category::class, 'Destroy']); //done
Route::post('Restore-Category/{id}', [Category::class, 'Restore']); //done

Route::get('Index', [Auth::class, 'Index']);
// Products
Route::get('Product', [Product::class, 'Index']);
Route::get('Product/Deleted', [Product::class, 'Index2']);
Route::post('Store-Product', [Product::class, 'Store']);
Route::get('Product/Edit-Product/{id}', [Product::class, 'Edit']);
Route::post('Update-Product/{id}', [Product::class, 'Update']);
Route::post('Delete-Product/{id}', [Product::class, 'Destroy']);
Route::post('Restore/Product/{id}', [Product::class, 'Restore']);



Route::middleware(['auth:sanctum'])->group(function (){
    Route::post('logout', [Auth::class, 'logout']);
});


Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
    
});
