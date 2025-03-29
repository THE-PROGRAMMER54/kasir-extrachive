<?php

use App\Http\Controllers\BarangController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\PenjualanController;
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
    Route::get('dashboard',[PenjualanController::class, 'dashboard'])->name('dashboard');

    // kasir
    Route::get('/kasir',[PenjualanController::class, 'kasir'])->name('kasir');
    Route::post('/tkeranjang',[PenjualanController::class, 'tkeranjang'])->name('tkeranjang');
    Route::post('/bayar',[PenjualanController::class, 'bayar'])->name('bayar');
    Route::post('/dkeranjang/{kode_barang}',[PenjualanController::class, 'dkeranjang'])->name('dkeranjang');
    Route::post('/searchk',[PenjualanController::class, 'searchkasir'])->name('searchkasir');

    // laporan
    Route::get('/laporan',[PenjualanController::class, 'laporan'])->name('laporan');
    Route::post('/tanggalLaporan',[PenjualanController::class, 'tanggalLaporan'])->name('tanggalLaporan');

    //produk
    Route::get('/produk',[BarangController::class, 'produk'])->name('produk');
    Route::post('/tporduk',[BarangController::class, 'tporduk'])->name('tporduk');
    Route::post('/eporduk/{kode_barang}',[BarangController::class, 'eporduk'])->name('eporduk');
    Route::post('/tstok/{kode_barang}',[BarangController::class, 'tstok'])->name('tstok');
    Route::post('/deleteproduk/{kode_barang}',[BarangController::class, 'deleteproduk'])->name('deleteproduk');

    // pengaturan
    Route::get('/pengaturan',[usercontroller::class, 'pengaturan'])->name('pengaturan');
    Route::post('/updatephoto/{id}',[usercontroller::class, 'updatephoto'])->name('updatephoto');
    Route::post('/deletephoto/{id}',[usercontroller::class, 'deletephoto'])->name('deletephoto');
    Route::post('/edituser/{id}',[usercontroller::class, 'edituser'])->name('edituser');
    Route::post('/editpass/{id}',[usercontroller::class, 'editpass'])->name('editpass');
    Route::post('/deleteakun/{id}',[usercontroller::class, 'deleteakun'])->name('deleteakun');

    // useradmin
    Route::get('/users',[usercontroller::class, 'users'])->name('users');
    Route::post("/editdatauser/{id}",[usercontroller::class, "editdatauser"])->name('editdatauser');
    Route::post('/deleteuserakun/{id}',[usercontroller::class, 'deleteuserakun'])->name('deleteuserakun');

    //logout
    Route::post('/logout',[usercontroller::class, 'logout'])->name('logout');
});
