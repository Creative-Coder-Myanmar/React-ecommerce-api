<?php

use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Api\RoleController;
use App\Http\Controllers\Api\UserController;
use App\Http\Middleware\AdminMiddleware;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;



Route::post('/users', [UserController::class, 'store']);
Route::post('/login', [UserController::class, 'login']);
Route::post('/users/{user}/profile-update', [UserController::class, 'profileImageUpdate'])->middleware('auth:sanctum');

//role api
Route::post('/roles', [RoleController::class, 'store']);
Route::delete('/roles/{role}', [RoleController::class, 'delete']);

//category api
Route::get('/categories', [CategoryController::class, 'show']);
Route::post('/categories', [CategoryController::class, 'store'])->middleware(['auth:sanctum', AdminMiddleware::class]);
Route::put('/categories/{category}', [CategoryController::class, 'update'])->middleware(['auth:sanctum', AdminMiddleware::class]);
Route::delete('/categories/{category}', [CategoryController::class, 'delete'])->middleware(['auth:sanctum', AdminMiddleware::class]);

//product api
Route::get('/products', [ProductController::class, 'show']);
Route::get('/products/{product}', [ProductController::class, 'detail']);
Route::post('/products', [ProductController::class, 'store'])->middleware(['auth:sanctum', AdminMiddleware::class]);
Route::put('/products/{product}', [ProductController::class, 'update'])->middleware(['auth:sanctum', AdminMiddleware::class]);
Route::delete('/products/{product}', [ProductController::class, 'delete'])->middleware(['auth:sanctum', AdminMiddleware::class]);

//order api
Route::get('/orders', [OrderController::class, 'show']);
Route::get('/orders/{order}', [OrderController::class, 'detail']);
Route::post('/orders', [OrderController::class, 'store'])->middleware(['auth:sanctum', AdminMiddleware::class]);
Route::put('/orders/{order}', [OrderController::class, 'update'])->middleware(['auth:sanctum', AdminMiddleware::class]);
Route::delete('/orders/{order}', [OrderController::class, 'delete'])->middleware(['auth:sanctum', AdminMiddleware::class]);

Route::post('/products/{product}/update-image', [ProductController::class, 'imageUpdate'])->middleware(['auth:sanctum', AdminMiddleware::class]);
Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');