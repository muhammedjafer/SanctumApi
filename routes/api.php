<?php

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Route::get('/products', [ProductController::class, 'index']);
// Route::post('/products', [ProductController::class, 'store']);
Route::resource('products', ProductController::class);
Route::get('products/search/{name}', [ProductController::class, 'search']);

// Route::get('/products', function() {
//     return Product::create([
//         'name' => 'Product One',
//         'slug' => 'product-one',
//         'description' => 'Product One and two',
//         'price' => '999.99'
//     ]);
// });

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
