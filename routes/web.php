<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Route::get("/login",[ \App\Http\Controllers\AuthController::class,'login'])->name("login");
Route::get("/login/authenticate",[ \App\Http\Controllers\AuthController::class,'authenticate'])->name("authenticate");

Route::middleware([\App\Http\Middleware\AccessTokenExists::class])->group(function () {
    Route::get('/', function () {
        return redirect('dashboard');
    });

    Route::get("/dashboard", [\App\Http\Controllers\ClientController::class, 'index'])->name("dashboard");
});