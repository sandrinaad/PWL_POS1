<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\usercontroller;
use App\Http\Controllers\WelcomeController;


Route::get('/', [WelcomeController::class, 'index']);

Route::group(['prefix' => 'user'], function () {
    Route::get('/', [usercontroller::class, 'index']);          //menmapilkan halaman awal user
    Route::post('/list', [usercontroller::class, 'list']);      //menampilkan data user dalam bentuk json untuk datatables
    Route::get('/create', [usercontroller::class, 'create']);   //menampilkan halaman form tambah user
    Route::post('/', [usercontroller::class, 'store']);         //menyimpan data user baru
    Route::get('/{id}', [usercontroller::class, 'show']);       //menampilkan detail user
    Route::get('/{id}/edit', [usercontroller::class, 'edit']);  //menampilkan halaman form edit user
    Route::put('/{id}', [usercontroller::class, 'update']);     //menyimpan perubahan data user
    Route::delete('/{id}', [usercontroller::class, 'destroy']); //menghapus data user
});