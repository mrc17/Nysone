<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/



Route::get('/', [UserController::class,'vueinscription'])->name('inscription');
Route::post('register',[UserController::class,'register'])->name('register') ;
Route::get('user/confirmation', [UserController::class,'vueconfirmation']);
Route::get('user/connexion', [UserController::class,'vueconnexion'])->name('connexion');
Route::post('user/store',[UserController::class,'store'])->name('store');
Route::get('qrcode/qrcode', [UserController::class, 'scanQrCode'])->name('scan-qr-code');
Route::get('qrcode/code',[UserController::class,'code'])->name('code');
Route::post('send-message', [UserController::class, 'sendMessage'])->name('send-message');
