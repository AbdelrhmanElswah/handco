<?php

use App\Http\Controllers\Api\BaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::post('/contact', [BaseController::class, 'store']);

Route::get('/about-us', [BaseController::class, 'getAboutUs']);

Route::get('products/category/{categoryId}', [BaseController::class, 'getProductsByCategory']);

Route::get('category/{id}', [BaseController::class, 'getCategory']);


