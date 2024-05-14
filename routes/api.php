<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\authController;
use App\Http\Controllers\API\aparController;

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

Route::get('/', function(){
    return response()->json(['response' => 'Hello Babi!', 'metadata' => ['status' => 200, 'message' => 'success']]);
});

Route::post('/check_auth', [authController::class, 'check_auth']);
Route::post('/login', [authController::class, 'auth_login']);

Route::group(['middleware' => [ 'auth', 'InputSanitasi']], function () {

    //========================= APAR ==========================
    Route::post('/apar/datatable', [aparController::class, 'datatable']);
    Route::post('/apar/process', [aparController::class, 'process']);
    Route::post('/apar/delete', [aparController::class, 'hapus']);
});



