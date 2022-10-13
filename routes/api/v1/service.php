<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\ServiceController;

Route::get('/companies/{company}/services', [ServiceController::class, 'index']);
Route::get('/companies/{company}/services/{service}',  [ServiceController::class, 'show']);
Route::post('/companies/{company}/services/',  [ServiceController::class, 'store']);
Route::put('/companies/{company}/services/{service}',  [ServiceController::class, 'update']);
Route::delete('/companies/{company}/services/{service}',  [ServiceController::class, 'destroy']);