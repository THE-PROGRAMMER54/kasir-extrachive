<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('dashboard');
});
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
