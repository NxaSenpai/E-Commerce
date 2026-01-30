<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use \App\Http\Controllers\CategoryController;
use \App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\AuthorController;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\AudienceController;
use App\Http\Controllers\CommentController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::controller(CategoryController::class)->prefix('categories')->group(function () {
    Route::get('/', 'getCategories');
    Route::post('/', 'createCategory');
    Route::get('/{categoryId}', 'getCategory');
    Route::patch('/{categoryId}', 'updateCategory');
    Route::delete('/{categoryId}', 'deleteCategory');
});

Route::controller(ProductController::class)->prefix('products')->group(function () {
    Route::get('/', 'getProducts');
    Route::post('/', 'createProduct')->middleware('can:products.create');
    Route::get('/{productId}', 'getProduct');
    Route::patch('/{productId}', 'updateProduct');
    Route::delete('/{productId}', 'deleteProduct');
});

Route::post('/login', function (Request $request) {
    $request->validate(['email'=>'required|email','password'=>'required']);

    if (!Auth::attempt($request->only('email','password'))) {
        return response()->json(['message'=>'Invalid credentials'], 401);
    }

    $user = $request->user();
    $token = $user->createToken('mobile')->accessToken;

    return response()->json(['token'=>$token]);
});

Route::middleware('auth:api')->group(function () {
    Route::get('/me', fn(Request $r) => $r->user()->load('roles'));
    // Add other protected routes here
});

// Author APIs
Route::post('/authors', [AuthorController::class, 'store']);

// Article APIs
Route::post('/articles', [ArticleController::class, 'store']);

// Audience APIs
Route::post('/audiences', [AudienceController::class, 'store']);

// Subscribe API
Route::post('/articles/{article}/subscribe', [ArticleController::class, 'subscribe']);

// Comment APIs
Route::post('/comments', [CommentController::class, 'store']);

// Get APIs
Route::get('/authors/{author}/articles', [AuthorController::class, 'articles']);
Route::get('/articles/{article}/audiences', [ArticleController::class, 'audiences']);
Route::get('/authors/{author}/audiences', [AuthorController::class, 'audiences']);
Route::get('/audiences/{audience}/comments', [AudienceController::class, 'comments']);
Route::get('/comments', [CommentController::class, 'index']);