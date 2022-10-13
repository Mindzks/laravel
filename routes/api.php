<?php

use App\Http\Controllers\CompanyController;
use Illuminate\Http\JsonResponse;
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

Route::prefix('v1')
    ->group(function(){
        require_once __DIR__ .'/api/v1/company.php';
    });

Route::prefix('v1')
    ->group(function(){
        require_once __DIR__ .'/api/v1/service.php';
    });
Route::prefix('v1')
    ->group(function(){
        require_once __DIR__ .'/api/v1/customer.php';
    });

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::fallback(function(){
    return response()->json([
        'message' => 'Page Not Found'], 404);
});

