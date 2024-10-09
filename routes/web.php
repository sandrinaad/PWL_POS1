<?php

use App\Http\Controllers\BarangController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\LevelController;
use App\Http\Controllers\SupplierController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Usercontroller;
use App\Http\Controllers\WelcomeController;


Route::get('/', [WelcomeController::class, 'index']);

Route::group(['prefix' => 'user'], function () {
    Route::get('/', [Usercontroller::class, 'index']);                      //menmapilkan halaman awal user
    Route::post('/list', [Usercontroller::class, 'list']);                  //menampilkan data user dalam bentuk json untuk datatables
    Route::get('/create', [Usercontroller::class, 'create']);               //menampilkan halaman form tambah user
    Route::post('/', [Usercontroller::class, 'store']);                     //menyimpan data user baru
    Route::get('/create_ajax', [Usercontroller::class, 'create_ajax']);     //Menampilkan halaman form tambah user Ajax
    Route::post('/ajax', [Usercontroller::class, 'store_ajax']);            //Menyimpan data user baru Ajax
    Route::get('/{id}', [Usercontroller::class, 'show']);                   //menampilkan detail user
    Route::get('/{id}/edit', [Usercontroller::class, 'edit']);              //menampilkan halaman form edit user
    Route::put('/{id}', [Usercontroller::class, 'update']);                 //menyimpan perubahan data user
    Route::get('/{id}/edit_ajax', [Usercontroller::class, 'edit_ajax']);    // Menampilkan halaman form edit user ajax
    Route::put('//{id}/update_ajax', [Usercontroller::class, 'update_ajax']); // Menyimpan perubahan data user ajax
    Route::get('/{id}/delete_ajax', [Usercontroller::class, 'confirm_ajax']); //untuk menampilkan form confirm delete user ajax
    Route::put('/{id}/delete_ajax', [Usercontroller::class, 'delete_ajax']);
    Route::delete('/{id}', [Usercontroller::class, 'destroy']);             //menghapus data user
});

// untuk m_level
Route::group(['prefix' => 'level'], function () {
    Route::get('/', [LevelController::class, 'index']);                       // menampilkan halaman awal level
    Route::post('/list', [LevelController::class, 'list']);                   // menampilkan data level dalam bentuk json untuk datatables
    Route::get('/create', [LevelController::class, 'create']);                // menampilkan halaman form tambah level
    Route::get('/create_ajax', [LevelController::class, 'create_ajax']);      //Menampilkan halaman form tambah user Ajax
    Route::post('/ajax', [LevelController::class, 'store_ajax']);            //Menyimpan data user baru Ajax
    Route::post('/', [LevelController::class, 'store']);         // menyimpan data level baru
    Route::get('/{id}', [LevelController::class, 'show']);       // menampilkan detail level
    Route::get('/{id}/edit', [LevelController::class, 'edit']);  // menampilkan halaman form edit level
    Route::put('/{id}', [LevelController::class, 'update']);     // menyimpan perubahan data level
    Route::get('/{id}/edit_ajax', [LevelController::class, 'edit_ajax']);    // Menampilkan halaman form edit user ajax
    Route::put('//{id}/update_ajax', [LevelController::class, 'update_ajax']); // Menyimpan perubahan data user ajax
    Route::get('/{id}/delete_ajax', [LevelController::class, 'confirm_ajax']); //untuk menampilkan form confirm delete user ajax
    Route::put('/{id}/delete_ajax', [LevelController::class, 'delete_ajax']);
    Route::delete('/{id}', [LevelController::class, 'destroy']); // menghapus data level
});

//untuk m_kategori
Route::group(['prefix' => 'kategori'], function () {
    Route::get('/', [KategoriController::class, 'index']);          // menampilkan halaman awal kategori
    Route::post('/list', [KategoriController::class, 'list']);      // menampilkan data kategori dalam bentuk json untuk datatables
    Route::get('/create', [KategoriController::class, 'create']);   // menampilkan halaman form tambah kategori
    Route::post('/', [KategoriController::class, 'store']);         // menyimpan data kategori baru
    Route::get('/create_ajax', [KategoriController::class, 'create_ajax']);   // menampilkan halaman form tambah user
    Route::post('/ajax', [KategoriController::class, 'store_ajax']);         // menyimpan data user baru
    Route::get('/{id}', [KategoriController::class, 'show']);       // menampilkan detail kategori
    Route::get('/{id}/edit', [KategoriController::class, 'edit']);  // menampilkan halaman form edit kategori
    Route::put('/{id}', [KategoriController::class, 'update']);     // menyimpan perubahan data kategori
    Route::get('/{id}/edit_ajax', [KategoriController::class, 'edit_ajax']); // menampilkan halaman form edit kategori ajax
    Route::put('/{id}/update_ajax', [KategoriController::class, 'update_ajax']); // menyimpan perubahan data kategori ajax
    Route::get('/{id}/delete_ajax', [KategoriController::class, 'confirm_ajax']); // untuk tampilkan form confirm delete kategori ajax
    Route::delete('/{id}/delete_ajax', [KategoriController::class, 'delete_ajax']); // untuk hapus data kategori ajax
    Route::delete('/{id}', [KategoriController::class, 'destroy']); // menghapus data kategori
});

// untuk m_supplier
Route::group(['prefix' => 'stok'], function () {
    Route::get('/', [SupplierController::class, 'index']);          // menampilkan halaman awal supplier
    Route::post('/list', [SupplierController::class, 'list']);      // menampilkan data supplier dalam bentuk json untuk datatables
    Route::get('/create', [SupplierController::class, 'create']);   // menampilkan halaman form tambah supplier
    Route::post('/', [SupplierController::class, 'store']);         // menyimpan data supplier baru
    Route::get('/{id}', [SupplierController::class, 'show']);       // menampilkan detail supplier
    Route::get('/{id}/edit', [SupplierController::class, 'edit']);  // menampilkan halaman form edit supplier
    Route::put('/{id}', [SupplierController::class, 'update']);     // menyimpan perubahan data supplier
    Route::delete('/{id}', [SupplierController::class, 'destroy']); // menghapus data supplier
});

// untuk m_barang
Route::group(['prefix' => 'barang'], function () {
    Route::get('/', [BarangController::class, 'index']);          // menampilkan halaman awal barang
    Route::post('/list', [BarangController::class, 'list']);      // menampilkan data barang dalam bentuk json untuk datatables
    Route::get('/create', [BarangController::class, 'create']);   // menampilkan halaman form tambah barang
    Route::post('/', [BarangController::class, 'store']);         // menyimpan data barang baru
    Route::get('/create_ajax', [BarangController::class, 'create_ajax']);   // menampilkan halaman form tambah barang
    Route::post('/ajax', [BarangController::class, 'store_ajax']);         // menyimpan data barang baru
    Route::get('/{id}', [BarangController::class, 'show']);       // menampilkan detail barang
    Route::get('/{id}/edit', [BarangController::class, 'edit']);  // menampilkan halaman form edit barang
    Route::put('/{id}', [BarangController::class, 'update']);     // menyimpan perubahan data barang
    Route::get('/{id}/edit_ajax', [BarangController::class, 'edit_ajax']); // menampilkan halaman form edit supplier ajax
    Route::put('/{id}/update_ajax', [BarangController::class, 'update_ajax']); // menyimpan perubahan data supplier ajax
    Route::get('/{id}/delete_ajax', [BarangController::class, 'confirm_ajax']); // untuk tampilkan form confirm delete supplier ajax
    Route::delete('/{id}/delete_ajax', [BarangController::class, 'delete_ajax']); // untuk hapus data supplier ajax
    Route::delete('/{id}', [BarangController::class, 'destroy']); // menghapus data barang
});

