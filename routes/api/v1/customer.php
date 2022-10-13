<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\CustomerController;

Route::get('/companies/{company}/services/{service}/customers',  [CustomerController::class, 'show']);
Route::get('/companies/{company}/services/{service}/customers/{customer}',  [CustomerController::class, 'index']);
Route::post('/companies/{company}/services/{service}/customers',  [CustomerController::class, 'store']);
Route::put('/companies/{company}/services/{service}/customers/{customer}',  [CustomerController::class, 'update']);
Route::delete('/companies/{company}/services/{service}/customers/{customer}',  [CustomerController::class, 'destroy']);