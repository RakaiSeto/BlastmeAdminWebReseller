<?php

use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\LanguageController;
use App\Http\Controllers\PaginationController;

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

Route::group(['middleware'=>'guest'],function(){
    Route::get('/',[AuthController::class,'login'])->name('login');
    Route::get('/register',[AuthController::class,'register'])->name('register');
    Route::get('/forget-password',[AuthController::class,'forgetPassword'])->name('forget_password');
    Route::post('/dologin',[AuthController::class,'doLogin']);
    Route::post('/signup',[AuthController::class,'signup'])->name('signup');
});

Route::group(['middleware'=>'auth'],function(){
    Route::get('/dashboard',[DashboardController::class,'index']);
    Route::get('/nodes',[DashboardController::class,'nodes']);
    Route::get('/monitor',[DashboardController::class,'monitor']);
    Route::post('/change-node-user',[DashboardController::class,'changeUser']);
    Route::post('/add-participant',[DashboardController::class,'addParticipant']);
    Route::get('/user-management',[DashboardController::class,'userManagement']);
    Route::get('/user-wallet',[DashboardController::class,'walletManagement']);
    Route::get('/toggle-user/{id}',[DashboardController::class,'userToggle']);
    Route::get('/tes', [DashboardController::class, 'socket']);
    Route::get('/logout',[AuthController::class,'logout'])->middleware('auth');
    Route::post('/logout',[AuthController::class,'logout'])->middleware('auth');
});

Route::get('/lang/{lang}',[ LanguageController::class,'switchLang'])->name('switch_lang');
Route::get('/pagination-per-page/{per_page}',[ PaginationController::class,'set_pagination_per_page'])->name('pagination_per_page');

Route::fallback(function () {
    $title = "404";
    $description = "Some description for the page";
    return view('pages.404.404', compact('title', 'description'));
});
