<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\BarangController;
use App\Http\Controllers\LevelController;
use App\Http\Controllers\StokController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\WelcomeController;
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

Route::middleware(['authorize:ADM'])->group(function () {
    Route::get('/level', [LevelController::class, 'index']);             // menampilkan halaman awal level
    Route::post('/level/list', [LevelController::class, 'list']);        // menampilkan data level dalam bentuk json untuk datatables
    Route::get('/level/create', [LevelController::class, 'create']);     // menampilkan halaman form tambah level
    Route::get('/level/create_ajax', [LevelController::class, 'create_ajax']); // menampilkan form tambah level via AJAX
    Route::post('/level', [LevelController::class, 'store']);            // menyimpan data level baru
    Route::post('/level/ajax', [LevelController::class, 'store_ajax']);  // menyimpan data level baru via AJAX
    Route::get('/level/{id}', [LevelController::class, 'show']);         // menampilkan detail level
    Route::get('/level/{id}/edit', [LevelController::class, 'edit']);    // menampilkan halaman form edit level
    Route::get('/level/{id}/edit_ajax', [LevelController::class, 'edit_ajax']); // menampilkan form edit level via AJAX
    Route::put('/level/{id}', [LevelController::class, 'update']);       // menyimpan perubahan data level
    Route::put('/level/{id}/update_ajax', [LevelController::class, 'update_ajax']); // menyimpan perubahan data level via AJAX
    Route::get('/level/{id}/delete_ajax', [LevelController::class, 'confirm_ajax']); // menampilkan konfirmasi penghapusan via AJAX
    Route::delete('/level/{id}/delete_ajax', [LevelController::class, 'delete_ajax']); // menghapus data level via AJAX
    Route::delete('/level/{id}', [LevelController::class, 'destroy']);   // menghapus data level
});


Route::group(['prefix' => 'user'], function () {
    Route::get('/', [UserController::class, 'index']);          // menampilkan halaman awal user
    Route::post('/list', [UserController::class, 'list']);      // menampilkan data user dalam bentuk json untuk datatables
    Route::get('/create', [UserController::class, 'create']);   // menampilkan halaman form tambah user
    Route::post('/', [UserController::class, 'store']);         // menyimpan data user baru
    Route::get('/create_ajax', [UserController::class, 'create_ajax']);   // menampilkan halaman form tambah user via Ajax
    Route::post('/ajax', [UserController::class, 'store_ajax']);         // menyimpan data user via Ajax
    Route::get('/{id}', [UserController::class, 'show']);       // menampilkan detail user
    Route::get('/{id}/edit', [UserController::class, 'edit']);  // menampilkan halaman form edit user
    Route::put('/{id}', [UserController::class, 'update']);     // menyimpan perubahan data user
    Route::get('/{id}/edit_ajax', [UserController::class, 'edit_ajax']);  // menampilkan halaman form edit user via Ajax
    Route::put('/{id}/update_ajax', [UserController::class, 'update_ajax']);     // menyimpan perubahan data user via Ajax
    Route::get('/{id}/delete_ajax', [UserController::class, 'confirm_ajax']);  // menampilkan halaman konfirmasi hapus user via Ajax
    Route::delete('/{id}/delete_ajax', [UserController::class, 'delete_ajax']);     // menghapus data user via Ajax
    Route::delete('/{id}', [UserController::class, 'destroy']); // menghapus data user
});

Route::middleware(['authorize:ADM,MNG'])->group( function () {
Route::group(['prefix' => 'kategori'], function () {
    Route::get('/', [KategoriController::class, 'index']);           // menampilkan halaman awal kategori
    Route::post('/list', [KategoriController::class, 'list']);       // menampilkan data kategori dalam bentuk json untuk datatables
    Route::get('/create', [KategoriController::class, 'create']);    // menampilkan halaman form tambah kategori
    Route::post('/', [KategoriController::class, 'store']);          // menyimpan data kategori baru
    Route::get('/create_ajax', [KategoriController::class, 'create_ajax']); // menampilkan form tambah kategori via Ajax
    Route::post('/ajax', [KategoriController::class, 'store_ajax']); // menyimpan data kategori via Ajax
    Route::get('/{id}', [KategoriController::class, 'show']);        // menampilkan detail kategori
    Route::get('/{id}/edit', [KategoriController::class, 'edit']);   // menampilkan form edit kategori
    Route::put('/{id}', [KategoriController::class, 'update']);      // menyimpan perubahan data kategori
    Route::get('/{id}/edit_ajax', [KategoriController::class, 'edit_ajax']); // menampilkan form edit kategori via Ajax
    Route::put('/{id}/update_ajax', [KategoriController::class, 'update_ajax']); // menyimpan perubahan data kategori via Ajax
    Route::get('/{id}/delete_ajax', [KategoriController::class, 'confirm_ajax']); // menampilkan konfirmasi hapus kategori via Ajax
    Route::delete('/{id}/delete_ajax', [KategoriController::class, 'delete_ajax']); // menghapus data kategori via Ajax
    Route::delete('/{id}', [KategoriController::class, 'destroy']);  // menghapus data kategori
});
});

Route::middleware(['authorize:ADM,MNG,STF,CUS'])->group(function () {
    Route::group(['prefix' => 'barang'], function () {
    Route::get('/', [BarangController::class, 'index']);          // menampilkan halaman awal barang
    Route::post('/list', [BarangController::class, 'list']);      // menampilkan data barang dalam bentuk json untuk datatables
    Route::get('/create', [BarangController::class, 'create']);   // menampilkan halaman form tambah barang
    Route::get('/create_ajax', [BarangController::class, 'create_ajax']); // menampilkan halaman form tambah barang via Ajax
    Route::post('/', [BarangController::class, 'store']);         // menyimpan data barang baru
    Route::post('/ajax', [BarangController::class, 'store_ajax']); // menyimpan data barang baru via Ajax
    Route::get('/{id}', [BarangController::class, 'show']);       // menampilkan detail barang
    Route::get('/{id}/edit', [BarangController::class, 'edit']);  // menampilkan halaman form edit barang
    Route::put('/{id}', [BarangController::class, 'update']);     // menyimpan perubahan data barang
    Route::get('/{id}/edit_ajax', [BarangController::class, 'edit_ajax']); // menampilkan halaman form edit barang via Ajax
    Route::put('/{id}/update_ajax', [BarangController::class, 'update_ajax']); // menyimpan perubahan data barang via Ajax
    Route::get('/{id}/delete_ajax', [BarangController::class, 'confirm_ajax']); // menampilkan halaman konfirmasi hapus barang via Ajax
    Route::delete('/{id}/delete_ajax', [BarangController::class, 'delete_ajax']); // menghapus data barang via Ajax
    Route::delete('/{id}', [BarangController::class, 'destroy']); // menghapus data barang
    });
});

Route::middleware(['authorize:ADM,MNG'])->group(function () {
Route::group(['prefix' => 'supplier'], function () {
    Route::get('/', [SupplierController::class, 'index']);          // menampilkan halaman awal supplier
    Route::post('/list', [SupplierController::class, 'list']);      // menampilkan data supplier dalam bentuk json untuk datatables
    Route::get('/create', [SupplierController::class, 'create']);   // menampilkan halaman form tambah supplier
    Route::post('/', [SupplierController::class, 'store']);         // menyimpan data supplier baru
    Route::get('/create_ajax', [SupplierController::class, 'create_ajax']); // menampilkan halaman form tambah supplier via Ajax
    Route::post('/ajax', [SupplierController::class, 'store_ajax']); // menyimpan data supplier via Ajax
    Route::get('/{id}', [SupplierController::class, 'show']);       // menampilkan detail supplier
    Route::get('/{id}/edit', [SupplierController::class, 'edit']);  // menampilkan halaman form edit supplier
    Route::put('/{id}', [SupplierController::class, 'update']);     // menyimpan perubahan data supplier
    Route::get('/{id}/edit_ajax', [SupplierController::class, 'edit_ajax']); // menampilkan halaman form edit supplier via Ajax
    Route::put('/{id}/update_ajax', [SupplierController::class, 'update_ajax']); // menyimpan perubahan data supplier via Ajax
    Route::get('/{id}/delete_ajax', [SupplierController::class, 'confirm_ajax']); // menampilkan konfirmasi hapus supplier via Ajax
    Route::delete('/{id}/delete_ajax', [SupplierController::class, 'delete_ajax']); // menghapus data supplier via Ajax
    Route::delete('/{id}', [SupplierController::class, 'destroy']); // menghapus data supplier
});
});

Route::middleware(['authorize:ADM,MNG,STF,CUS'])->group(function () {
Route::group(['prefix' => 'stok'], function () {
    Route::get('/', [StokController::class, 'index']);              // menampilkan halaman awal stok
    Route::post('/list', [StokController::class, 'list']);          // menampilkan data stok dalam bentuk json untuk datatables
    Route::get('/create', [StokController::class, 'create']);       // menampilkan form tambah stok
    Route::post('/', [StokController::class, 'store']);             // menyimpan data stok baru
    Route::get('/{id}', [StokController::class, 'show']);           // menampilkan detail stok
    Route::get('/{id}/edit', [StokController::class, 'edit']);      // menampilkan form edit stok
    Route::put('/{id}', [StokController::class, 'update']);         // menyimpan perubahan data stok
    Route::delete('/{id}', [StokController::class, 'destroy']);      // menghapus data stok
});
});
});