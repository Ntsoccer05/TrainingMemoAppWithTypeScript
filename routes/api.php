<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Models\User;
use Illuminate\Support\Facades\Redis;
use App\Http\Controllers\RecordController;

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
    Route::post('/record', [RecordController::class, 'create']);
    Route::post('/record', [RecordController::class, 'update']);
    Route::post('/record', [RecordController::class, 'edit']);
    Route::post('/record', [RecordController::class, 'destroy']);
});

// ログイン済みのみ
Route::middleware('auth:sanctum')->get('users', function(Request $request){
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