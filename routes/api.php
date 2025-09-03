<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProductCategoryController;
use App\Http\Controllers\ProductController;

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::middleware(['jwt.custom'])->group(function (){
    Route::get('/user-profile', [AuthController::class, 'profile']);
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::GET('/list',[AuthController::class, 'userlist']);
    Route::POST('add-category', [ProductCategoryController::class, 'addCategory']);

    Route::POST('add-product', [ProductController::class, 'addProduct', 'addProduct'])->middleware('permission:add product');

    Route::GET('view-product', [ProductController::class, 'productList', 'viewProduct'])->middleware('permission:view product');
});