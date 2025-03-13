<?php

use App\Http\Controllers\usercontroller;
use Illuminate\Support\Facades\Route;

// guest
Route::middleware('guest')->group(function(){
    Route::get('/',[usercontroller::class ,'login'])->name('login');

    Route::get('/register',[usercontroller::class, 'register'])->name('register');
});

// user
Route::get('/produk', function () {
    return view('produk');
});
Route::get('/laporan', function () {
    return view('laporan');
});
Route::get('/pengaturan', function () {
    return view('pengaturan');
});
Route::get('/regist', function () {
    return view('regist');
});
Route::get('/login', function () {
    return view('login');
});
