<?php

use App\Http\Controllers\BarangController;
use App\Http\Controllers\usercontroller;
use Illuminate\Support\Facades\Route;

// guest
Route::middleware('guest')->group(function(){
    Route::get('/',[usercontroller::class ,'login'])->name('login');
    Route::post('/plogin', [usercontroller::class,'proseslogin'])->name('proseslogin');

    Route::get('/register',[usercontroller::class, 'register'])->name('register');
    Route::post('/pregister', [usercontroller::class,'prosesregist'])->name('prosesregist');
});

// user
Route::middleware('auth')->group(function(){
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::get('/kasir', function () {
        return view('kasir');
    })->name('kasir');

    Route::get('/laporan', function () {
        return view('laporan');
    })->name('laporan');
    //produk
    Route::get('/produk',[BarangController::class, 'produk'])->name('produk');
    Route::post('/tporduk',[BarangController::class, 'tporduk'])->name('tporduk');
    Route::post('/eporduk/{kode_barang}',[BarangController::class, 'eporduk'])->name('eporduk');
    Route::post('/tstok/{kode_barang}',[BarangController::class, 'tstok'])->name('tstok');
    Route::post('/deleteproduk/{kode_barang}',[BarangController::class, 'deleteproduk'])->name('deleteproduk');

    //logout
    Route::post('/logout',[usercontroller::class, 'logout'])->name('logout');
});
