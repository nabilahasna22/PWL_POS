<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\BarangController;
use App\Http\Controllers\LevelController;
use App\Http\Controllers\StokController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\WelcomeController;
use App\Http\Controllers\PenjualanController;
use App\Http\Controllers\DetailController;
use App\Http\Controllers\ProfileController;
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
    Route::get('/level/import', [LevelController::class, 'import']); //ajax form upload excel
    Route::post('/level/import_ajax', [LevelController::class, 'import_ajax']); //ajax form upload excel
    Route::get('/level/export_excel', [LevelController::class, 'export_excel']); //export excel
    Route::get('/level/export_pdf', [LevelController::class, 'export_pdf']); //export excel
    Route::delete('/level/{id}', [LevelController::class, 'destroy']);   // menghapus data level
});

Route::middleware(['authorize:ADM'])->group( function () {
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
    Route::get('/import', [UserController::class, 'import']); //ajax form upload excel
    Route::post('/import_ajax', [UserController::class, 'import_ajax']); //ajax form upload excel
    Route::get('/export_excel', [UserController::class, 'export_excel']); //export excel
    Route::get('/export_pdf', [UserController::class, 'export_pdf']); //export excel
    Route::delete('/{id}', [UserController::class, 'destroy']); // menghapus data user
});
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
    Route::get('/import', [KategoriController::class, 'import']); //ajax form upload excel
    Route::post('/import_ajax', [KategoriController::class, 'import_ajax']); //ajax form upload excel
    Route::get('/export_excel', [KategoriController::class, 'export_excel']); //export excel
    Route::get('/export_pdf', [KategoriController::class, 'export_pdf']); //export excel
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
    Route::get('/import', [BarangController::class, 'import']);
    Route::post('/import_ajax', [BarangController::class, 'import_ajax']);
    Route::get('/export_excel', [BarangController::class, 'export_excel']); 
    Route::get('/export_pdf', [BarangController::class, 'export_pdf']); 
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
    Route::get('/import', [SupplierController::class, 'import']);
    Route::post('/import_ajax', [SupplierController::class, 'import_ajax']);
    Route::get('/export_excel', [SupplierController::class, 'export_excel']); 
    Route::get('/export_pdf', [SupplierController::class, 'export_pdf']); 
    Route::delete('/{id}', [SupplierController::class, 'destroy']); // menghapus data supplier
});
});

Route::middleware(['authorize:ADM,MNG,STF,CUS'])->group(function () {
    Route::get('/stok', [StokController::class, 'index']);          // menampilkan halaman awal stok
    Route::post('/stok/list', [StokController::class, 'list']);      // menampilkan data stok dalam bentuk json untuk datatables
    Route::get('/stok/create', [StokController::class, 'create']);   // menampilkan halaman form tambah stok
    Route::get('/stok/create_ajax', [StokController::class, 'create_ajax']);
    Route::post('/stok/ajax', [StokController::class, 'store_ajax']);
    Route::post('/stok', [StokController::class, 'store']);         // menyimpan data stok baru
    Route::get('/stok/import', [StokController::class, 'import']);
    Route::post('/stok/import_ajax', [StokController::class, 'import_ajax']);
    Route::get('/stok/export_excel', [StokController::class, 'export_excel']); // export excel
    Route::get('/stok/export_pdf', [StokController::class, 'export_pdf']); // export pdf
    Route::get('/stok/{id}', [StokController::class, 'show']);       // menampilkan detail stok
    Route::get('/stok/{id}/show_ajax', [StokController::class, 'show_ajax']);// menampilkan detail stok
    Route::get('/stok/{id}/edit', [StokController::class, 'edit']);  // menampilkan halaman form edit stok
    Route::put('/stok/{id}', [StokController::class, 'update']);     // menyimpan perubahan data stok
    Route::get('/stok/{id}/edit_ajax', [StokController::class, 'edit_ajax']);
    Route::put('/stok/{id}/update_ajax', [StokController::class, 'update_ajax']);
    Route::get('/stok/{id}/delete_ajax', [StokController::class, 'confirm_ajax']);
    Route::delete('/stok/{id}/delete_ajax', [StokController::class, 'delete_ajax']);
    Route::delete('/stok/{id}', [StokController::class, 'destroy']); // menghapus data stok
});

Route::middleware(['authorize:ADM,MNG,STF'])->group(function () {
Route::group(['prefix' => 'penjualan'], function () {
    Route::get('/', [PenjualanController::class, 'index']);          // menampilkan halaman awal stok
    Route::post('/list', [PenjualanController::class, 'list']);      // menampilkan data stok dalam bentuk json untuk datatables
    Route::get('/create', [PenjualanController::class, 'create']);   // menampilkan halaman form tambah stok
    Route::get('/create_ajax', [PenjualanController::class, 'create_ajax']);
    Route::post('/ajax', [PenjualanController::class, 'store_ajax']);
    Route::post('/', [PenjualanController::class, 'store']);         // menyimpan data stok baru
    Route::get('/import', [PenjualanController::class, 'import']);
    Route::post('/import_ajax', [PenjualanController::class, 'import_ajax']);
    Route::get('/export_excel', [PenjualanController::class, 'export_excel']); // export excel
    Route::get('/export_pdf', [PenjualanController::class, 'export_pdf']); // export pdf
    Route::get('/{id}', [PenjualanController::class, 'show']);       // menampilkan detail stok
    Route::get('/{id}/show_ajax', [PenjualanController::class, 'show_ajax']);
    Route::get('/{id}/edit', [PenjualanController::class, 'edit']);  // menampilkan halaman form edit stok
    Route::put('/{id}', [PenjualanController::class, 'update']);     // menyimpan perubahan data stok
    Route::get('/{id}/edit_ajax', [PenjualanController::class, 'edit_ajax']);
    Route::put('/{id}/update_ajax', [PenjualanController::class, 'update_ajax']);
    Route::get('/{id}/delete_ajax', [PenjualanController::class, 'confirm_ajax']);
    Route::delete('/{id}/delete_ajax', [PenjualanController::class, 'delete_ajax']);
    Route::delete('/{id}', [PenjualanController::class, 'destroy']); // menghapus data stok
});
});

Route::middleware(['authorize:ADM,MNG,STF'])->group(function () {
    Route::group(['prefix' => 'detail'], function () {
        Route::get('/', [DetailController::class, 'index']);          // menampilkan halaman awal stok
        Route::post('/list', [DetailController::class, 'list']);      // menampilkan data stok dalam bentuk json untuk datatables
        Route::get('/create', [DetailController::class, 'create']);   // menampilkan halaman form tambah stok
        Route::get('/create_ajax', [DetailController::class, 'create_ajax']);
        Route::post('/ajax', [DetailController::class, 'store_ajax']);
        Route::post('/', [DetailController::class, 'store']);         // menyimpan data stok baru
        Route::get('/import', [DetailController::class, 'import']);
        Route::post('/import_ajax', [DetailController::class, 'import_ajax']);
        Route::get('/export_excel', [DetailController::class, 'export_excel']); // export excel
        Route::get('/export_pdf', [DetailController::class, 'export_pdf']); // export pdf
        Route::get('/{id}', [DetailController::class, 'show']);       // menampilkan detail stok        
        Route::get('/{id}/show_ajax', [DetailController::class, 'show_ajax']);
        Route::get('/{id}/edit', [DetailController::class, 'edit']);  // menampilkan halaman form edit stok
        Route::put('/{id}', [DetailController::class, 'update']);     // menyimpan perubahan data stok
        Route::get('/{id}/edit_ajax', [DetailController::class, 'edit_ajax']);
        Route::put('/{id}/update_ajax', [DetailController::class, 'update_ajax']);
        Route::get('/{id}/delete_ajax', [DetailController::class, 'confirm_ajax']);
        Route::delete('/{id}/delete_ajax', [DetailController::class, 'delete_ajax']);
        Route::delete('/{id}', [DetailController::class, 'destroy']); // menghapus data stok
    });
    });

    Route::middleware(['authorize:ADM,MNG,STF,CUS'])->group(function(){
        Route::get('/profile', [ProfileController::class, 'index']);
        Route::get('/profile/{id}/edit_ajax', [ProfileController::class, 'edit_ajax']);        
        Route::put('/profile/{id}/update_ajax', [ProfileController::class, 'update_ajax']);
        Route::get('/profile/{id}/edit_foto', [ProfileController::class, 'edit_foto']);
        Route::put('/profile/{id}/update_foto', [ProfileController::class, 'update_foto']);
    });
});