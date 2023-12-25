<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\RecordContentController;
use App\Http\Controllers\RecordController;
use App\Http\Controllers\RecordMenuController;

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

// ログイン済みのみ
Route::middleware('auth:sanctum')->group(function(){
    Route::post('/logout',[LoginController::class, 'logout']);
    Route::get('/record', [RecordController::class, 'index']);
    Route::post('/record/create', [RecordController::class, 'create']);
    Route::get('/record/edit', [RecordController::class, 'edit']);
    Route::post('/record/edit', [RecordController::class, 'update']);
    Route::post('/record/destroy', [RecordController::class, 'destroy']);
    Route::get('/menus', [MenuController::class, 'index']);
    Route::post('/menus/store', [MenuController::class, 'store']);
    Route::post('/category/update', [MenuController::class, 'edit']);
    Route::post('/menus/update', [MenuController::class, 'update']);
    Route::post('/category/delete', [MenuController::class, 'destroy']);
    Route::post('/menus/delete', [MenuController::class, 'delete']);
    Route::get('/recordMenu', [RecordMenuController::class, 'index']);
    Route::post('/recordMenu/create', [RecordMenuController::class, 'create']);
    Route::get('/recordContent', [RecordContentController::class, 'index']);
    Route::post('/recordContent/create', [RecordContentController::class, 'create']);
    Route::post('/recordContent/delete', [RecordContentController::class, 'delete']);
});

// ログイン済みのみ
Route::middleware('auth:sanctum')->get('users', function(Request $request){
    // コントローラーでも$request->user();でログインしているユーザ情報を取得できる
    return $request->user();
});

Route::post('/login',[LoginController::class, 'login']);
Route::post('/register',[RegisterController::class, 'register']);

// ソーシャルログイン
Route::prefix('login')->group(function () {
    Route::get('/{provider}', [LoginController::class, 'getProviderOAuthURL']);
    Route::post('/{provider}/callback', [LoginController::class, 'handleProviderCallback']);
});

Route::prefix('register')->group(function () {
    Route::post('/{provider}', [RegisterController::class, 'registerProviderUser']);
});