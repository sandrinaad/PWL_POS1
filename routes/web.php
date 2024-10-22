<?php
use App\Http\Controllers\AuthController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\BarangController;
use App\Http\Controllers\LevelController;
use App\Http\Controllers\StokController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\WelcomeController;
use App\Models\KategoriModel;
use Illuminate\Support\Facades\Route;

Route::pattern('id', '[0-9]+'); //artinya ketika ada parameter (id), maka harus berupa angka

Route::get('login', [AuthController::class, 'login'])->name('login');
Route::post('login', [AuthController::class, 'postlogin']);
Route::get('logout', [AuthController::class, 'logout'])->middleware('auth');
Route::get('register', [AuthController::class, 'register']);
Route::post('register', [AuthController::class, 'store']);
Route::middleware(['auth'])->group(function () { //artinya semua route di dalam group ini harus login dulu

//masukkan semua route yang perlu autentikasi di sini

Route::get('/', [WelcomeController::class, 'index']);
//route level

//artinya semua route didalam group ini harus memiliki role ADM
Route::middleware(['authorize:ADM'])->group(function(){ //semua route harus punya role adm baru bisa akses
    Route::get('/level', [LevelController::class, 'index']); //menampilkan halaman awal leevel
    Route::post('/level/list',[LevelController::class,'list']);   //menampilkan data level dalam bentuk json
    Route::get('/level/create', [LevelController::class, 'create']);   // menampilkan halaman form tambah level
    Route::get('/level/create_ajax', [LevelController::class, 'create_ajax']); //Menampilkan halaman form tambah user Ajax
    Route::post('/level/ajax', [LevelController::class, 'store_ajax']); // Menyimpan data user baru Ajax
    Route::post('/level', [LevelController::class, 'store']);         // menyimpan data level baru
    Route::get('/level/{id}/edit', [LevelController::class, 'edit']); // menampilkan halaman form edit level
    Route::put('/level/{id}', [LevelController::class, 'update']);     // menyimpan perubahan data level
    Route::get('/level/{id}/edit_ajax', [LevelController::class,'edit_ajax']); //menampilkan halaman form edit user ajax
    Route::put('/level/{id}/update_ajax', [LevelController::class,'update_ajax']);   //menyimpan halaman form edit user ajax
    Route::get('/level/{id}/delete_ajax', [LevelController::class, 'confirm_ajax']); //tampil form confirm delete user ajax
    Route::delete('/level/{id}/delete_ajax', [LevelController::class, 'delete_ajax']);  //hapus data user
    Route::get('/level/{id}/show_ajax', [LevelController::class, 'show_ajax']); // menampilkan detail level
    Route::get('/barang/{id}/show',[LevelController::class,'show']);
    Route::get('/level/import', [LevelController::class, 'import']); //ajax form upload excel
    Route::post('/level/import_ajax', [LevelController::class, 'import_ajax']); //ajax form upload excel
    Route::get('/level/export_excel', [LevelController::class, 'export_excel']); //export_excel
    Route::get('/level/export_pdf', [LevelController::class, 'export_pdf']); //export_pdf
    Route::delete('/level/{id}', [LevelController::class, 'destroy']); // menghapus data level
});

Route::middleware(['authorize:ADM,MNG'])->group(function () {
    Route::get('/kategori', [KategoriController::class, 'index']);          // menampilkan halaman awal kategori
    Route::post('/kategori/list', [KategoriController::class, 'list']);      // menampilkan data kategori dalam bentuk json untuk datatables
    Route::get('/kategori/create', [KategoriController::class, 'create']);   // menampilkan halaman form tambah kategori
    Route::get('/kategori/create_ajax', [KategoriController::class, 'create_ajax']);
    Route::post('/kategori/ajax', [KategoriController::class, 'store_ajax']);
    Route::post('/kategori', [KategoriController::class, 'store']);         // menyimpan data kategori baru
    Route::get('/kategori/{id}', [KategoriController::class, 'show']);       // menampilkan detail kategori
    Route::get('/kategori/{id}/edit', [KategoriController::class, 'edit']);  // menampilkan halaman form edit kategori
    Route::put('/kategori/{id}', [KategoriController::class, 'update']);     // menyimpan perubahan data kategori
    Route::get('/kategori/{id}/edit_ajax', [KategoriController::class, 'edit_ajax']);
    Route::put('/kategori/{id}/update_ajax', [KategoriController::class, 'update_ajax']);
    Route::get('/kategori/{id}/delete_ajax', [KategoriController::class, 'confirm_ajax']);
    Route::get('/kategori/import', [KategoriController::class, 'import']);
    Route::post('/kategori/import_ajax', [KategoriController::class, 'import_ajax']);
    Route::delete('/kategori/{id}/delete_ajax', [KategoriController::class, 'delete_ajax']);
    Route::get('/kategori/export_excel', [KategoriController::class, 'export_excel']); //export excel
    Route::get('/kategori/export_pdf', [KategoriController::class, 'export_pdf']); //export pdf
    Route::delete('/kategori/{id}', [KategoriController::class, 'destroy']); // menghapus data kategori
});

Route::middleware(['authorize:ADM,MNG,STF'])->group(function () {
    Route::get('/barang', [BarangController::class, 'index']);          // menampilkan halaman awal barang
    Route::post('/barang/list', [BarangController::class, 'list']);      // menampilkan data barang dalam bentuk json untuk datatables
    Route::get('/barang/create', [BarangController::class, 'create']);   // menampilkan halaman form tambah barang
    Route::get('/barang/create_ajax', [BarangController::class, 'create_ajax']);
    Route::post('/barang', [BarangController::class, 'store']);         // menyimpan data barang baru
    Route::post('/barang/ajax', [BarangController::class, 'store_ajax']);
    Route::get('/barang/{id}', [BarangController::class, 'show']);       // menampilkan detail barang
    Route::get('/barang/{id}/edit', [BarangController::class, 'edit']);  // menampilkan halaman form edit barang
    Route::put('/barang/{id}', [BarangController::class, 'update']);     // menyimpan perubahan data barang
    Route::get('/barang/{id}/edit_ajax', [BarangController::class, 'edit_ajax']);
    Route::put('/barang/{id}/update_ajax', [BarangController::class, 'update_ajax']);
    Route::get('/barang/{id}/delete_ajax', [BarangController::class, 'confirm_ajax']);
    Route::delete('/barang/{id}/delete_ajax', [BarangController::class, 'delete_ajax']);
    Route::delete('/barang/{id}', [BarangController::class, 'destroy']); // menghapus data barang
    Route::get('/barang/import', [BarangController::class, 'import']); // ajax form upload excel
    Route::post('/barang/import_ajax', [BarangController::class, 'import_ajax']); // ajax import excel
    Route::get('/barang/export_excel', [BarangController::class, 'export_excel']); //export excel
    Route::get('/barang/export_pdf', [BarangController::class, 'export_pdf']); //export pdf
});


 Route::group(['prefix' => 'user', 'middleware' => ['authorize:ADM,MNG']], function () {
//Route::middleware(['authorize:ADM,MNG'])->group(function(){
    Route::get('/', [UserController::class, 'index']);          // menampilkan halaman awal user
    Route::post('/list', [UserController::class, 'list']);      // menampilkan data user dalam bentuk json untuk datatables
    Route::get('/create', [UserController::class, 'create']);   // menampilkan halaman form tambah user
    Route::post('/', [UserController::class, 'store']);         // menyimpan data user baru
    Route::get('/create_ajax', [UserController::class, 'create_ajax']);   // menampilkan halaman form tambah user via Ajax
    Route::post('/ajax', [UserController::class, 'store_ajax']);         // menyimpan data user via Ajax
    Route::get('/{id}', [UserController::class, 'show']);       // menampilkan detail user
    Route::get('/{id}/show_ajax', [UserController::class, 'show_ajax']);       // menampilkan detail user
    Route::get('/{id}/edit', [UserController::class, 'edit']);  // menampilkan halaman form edit user
    Route::put('/{id}', [UserController::class, 'update']);     // menyimpan perubahan data user
    Route::get('/{id}/edit_ajax', [UserController::class, 'edit_ajax']);  // menampilkan halaman form edit user via Ajax
    Route::put('/{id}/update_ajax', [UserController::class, 'update_ajax']);     // menyimpan perubahan data user via Ajax
    Route::get('/{id}/delete_ajax', [UserController::class, 'confirm_ajax']);  // menampilkan halaman konfirmasi hapus user via Ajax
    Route::delete('/{id}/delete_ajax', [UserController::class, 'delete_ajax']);     // menghapus data user via Ajax
    Route::get('/import', [UserController::class, 'import']); //ajax form upload excel
    Route::post('/import_ajax', [UserController::class, 'import_ajax']);
    Route::get('/export_excel', [UserController::class, 'export_excel']);
    Route::get('/export_pdf', [UserController::class, 'export_pdf']);
    Route::delete('/{id}', [UserController::class, 'destroy']); // menghapus data user
    
});


Route::middleware(['authorize:ADM,MNG'])->group(function(){
    Route::get('/supplier', [SupplierController::class, 'index']); //menampilkan halaman awal leevel
    Route::post('/supplier/list',[SupplierController::class,'list']);   //menampilkan data Supplier dalam bentuk json
    Route::get('/supplier/create', [SupplierController::class, 'create']);   // menampilkan halaman form tambah Supplier
    Route::get('/supplier/create_ajax', [SupplierController::class, 'create_ajax']); // menampilkan halaman form tambah supplier Ajax
    Route::post('/supplier/ajax', [SupplierController::class, 'store_ajax']); // menyimpan data supplier baru Ajax
    Route::post('/supplier', [SupplierController::class, 'store']);         // menyimpan data Supplier baru
    Route::get('/supplier/{id}/edit', [SupplierController::class, 'edit']); // menampilkan halaman form edit Supplier
    Route::put('/supplier/{id}', [SupplierController::class, 'update']);     // menyimpan perubahan data Supplier
    Route::get('/supplier/{id}/edit_ajax', [SupplierController::class,'edit_ajax']); //menampilkan halaman form edit user ajax
    Route::put('/supplier/{id}/update_ajax', [SupplierController::class, 'update_ajax']); // menyimpan perubahan data supplier Ajax
    Route::get('/supplier/{id}/delete_ajax', [SupplierController::class, 'confirm_ajax']); // untuk tampilkan form confirm delete supplier Ajax
    Route::delete('/supplier/{id}/delete_ajax', [SupplierController::class, 'delete_ajax']); // untuk hapus data supplier Ajax
    Route::get('/supplier/{id}', [SupplierController::class, 'show']);       // menampilkan detail level
    Route::get('/supplier/{id}/show_ajax', [SupplierController::class, 'show_ajax']);
    Route::get('/supplier/import', [SupplierController::class, 'import']); //ajax form upload excel
    Route::post('/supplier/import_ajax', [SupplierController::class, 'import_ajax']); //ajax form upload excel
    Route::get('/supplier/export_excel', [SupplierController::class, 'export_excel']); //export_excel
    Route::get('/supplier/export_pdf', [SupplierController::class, 'export_pdf']); //export_pdf
    Route::delete('/supplier/{id}', [SupplierController::class, 'destroy']); // menghapus data Supplier
});

// Route::group(['prefix' => 'stok'], function () {
    Route::middleware(['authorize:ADM,MNG,STF'])->group(function(){
        Route::get('/stok', [StokController::class, 'index']);  // menampilkan halaman stok
        Route::post('/stok/list', [StokController::class, 'list'] );    //menampilkan data stok dalam bentuk json datatables
        Route::get('/stok/create_ajax', [StokController::class, 'create_ajax']); //Menampilkan halaman form tambah stok Ajax
        Route::post('/stok/ajax', [StokController::class, 'store_ajax']); // Menyimpan data stok baru Ajax
        Route::get('/stok/{id}', [StokController::class, 'show']);       //menampilkan detai stok
        Route::get('/stok/{id}/show_ajax', [StokController::class, 'show_ajax']);
        Route::get('/stok/{id}/edit_ajax', [StokController::class,'edit_ajax']); //menampilkan halaman form edit stok ajax
        Route::put('/stok/{id}/update_ajax', [StokController::class,'update_ajax']);   //menyimpan halaman form edit stok ajax
        Route::get('/stok/{id}/delete_ajax', [StokController::class, 'confirm_ajax']); //tampil form confirm delete stok ajax
        Route::delete('/stok/{id}/delete_ajax', [StokController::class, 'delete_ajax']);  //hapus data stok
        Route::delete('/stok/{id}', [StokController::class, 'destroy']);     //mengahpus data stok
        Route::get('/stok/import', [StokController::class, 'import']); //ajax form upolad
        Route::post('/stok/import_ajax', [StokController::class, 'import_ajax']); //ajax import exvel)
        Route::get('/stok/export_excel', [StokController::class, 'export_excel']);  //export excel
        Route::get('/stok/export_pdf', [StokController::class, 'export_pdf']); //export pdf
    });
});