<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
/*
Route::get('/', function () {
    //return redirect('/login');
    return view('welcome');
});
*/
Auth::routes();
Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('landing');
Route::get('/get_bot', [App\Http\Controllers\HomeController::class, 'get_bot']);

//ADMIN
//GET
Route::get('/admin/dashboard', [App\Http\Controllers\AdminController::class, 'index'])->name('admin.dashboard');
Route::get('/admin/departemen', [App\Http\Controllers\AdminController::class, 'departemen'])->name('admin.departemen');
Route::get('/admin/artikel', [App\Http\Controllers\AdminController::class, 'artikel'])->name('admin.artikel');
Route::get('/admin/komentar', [App\Http\Controllers\AdminController::class, 'komentar'])->name('admin.komentar');
Route::get('/admin/lampiran', [App\Http\Controllers\AdminController::class, 'lampiran'])->name('admin.lampiran');
Route::get('/admin/diskusi', [App\Http\Controllers\AdminController::class, 'diskusi'])->name('admin.diskusi');
Route::get('/admin/user', [App\Http\Controllers\AdminController::class, 'user'])->name('admin.user');

Route::get('/admin/artikel/tambah', [App\Http\Controllers\KMSController::class, 'baru']);
Route::get('/admin/artikel/edit/{id}', [App\Http\Controllers\KMSController::class, 'edit']);
Route::get('/admin/diskusi/tambah', [App\Http\Controllers\DiskusiController::class, 'baru']);
Route::get('/admin/diskusi/edit/{id}', [App\Http\Controllers\DiskusiController::class, 'edit']);

//POST
Route::POST('/admin/departemen/store', [App\Http\Controllers\DepartemenController::class, 'store']);
Route::POST('/admin/artikel/store', [App\Http\Controllers\KMSController::class, 'store']);
Route::POST('/admin/komentar/store', [App\Http\Controllers\KomentarController::class, 'store']);
Route::POST('/admin/lampiran/store', [App\Http\Controllers\LampiranController::class, 'store']);
Route::POST('/admin/diskusi/store', [App\Http\Controllers\DiskusiController::class, 'store']);
Route::POST('/admin/user/store', [App\Http\Controllers\UsersController::class, 'store']);

//UPDATE POST
Route::POST('/admin/departemen/update/{id}', [App\Http\Controllers\DepartemenController::class, 'update']);
Route::POST('/admin/artikel/update/{id}', [App\Http\Controllers\KMSController::class, 'update']);
Route::POST('/admin/komentar/update/{id}', [App\Http\Controllers\KomentarController::class, 'update']);
Route::POST('/admin/lampiran/update/{id}', [App\Http\Controllers\LampiranController::class, 'update']);
Route::POST('/admin/diskusi/update/{id}', [App\Http\Controllers\DiskusiController::class, 'update']);
Route::POST('/admin/user/update/{id}', [App\Http\Controllers\UsersController::class, 'update']);

//DESTROY
Route::GET('/admin/departemen/delete/{id}', [App\Http\Controllers\DepartemenController::class, 'destroy']);
Route::GET('/admin/artikel/delete/{id}', [App\Http\Controllers\KMSController::class, 'destroy']);
Route::GET('/admin/komentar/delete/{id}', [App\Http\Controllers\KomentarController::class, 'destroy']);
Route::GET('/admin/lampiran/delete/{id}', [App\Http\Controllers\LampiranController::class, 'destroy']);
Route::GET('/admin/diskusi/delete/{id}', [App\Http\Controllers\DiskusiController::class, 'destroy']);
Route::GET('/admin/user/delete/{id}', [App\Http\Controllers\UsersController::class, 'destroy']);

//FIND
Route::get('/admin/departemen/find/{id}', [App\Http\Controllers\DepartemenController::class, 'find']);
Route::get('/admin/artikel/find/{id}', [App\Http\Controllers\KMSController::class, 'find']);
Route::get('/admin/komentar/find/{id}', [App\Http\Controllers\KomentarController::class, 'find']);
Route::get('/admin/lampiran/find/{id}', [App\Http\Controllers\LampiranController::class, 'find']);
Route::get('/admin/diskusi/find/{id}', [App\Http\Controllers\DiskusiController::class, 'find']);
Route::get('/admin/user/find/{id}', [App\Http\Controllers\UsersController::class, 'find']);

Route::get('/admin/lampiran/download/{id}', [App\Http\Controllers\LampiranController::class, 'download']);

//JSON
Route::get('/admin/departemen/json', [App\Http\Controllers\DepartemenController::class, 'json']);
Route::get('/admin/artikel/json', [App\Http\Controllers\KMSController::class, 'json']);
Route::get('/admin/komentar/json', [App\Http\Controllers\KomentarController::class, 'json']);
Route::get('/admin/lampiran/json', [App\Http\Controllers\LampiranController::class, 'json']);
Route::get('/admin/diskusi/json', [App\Http\Controllers\DiskusiController::class, 'json']);
Route::get('/admin/user/json', [App\Http\Controllers\UsersController::class, 'json']);

//PEGAWAI
//GET
Route::get('/pegawai/dashboard', [App\Http\Controllers\LoginPegawai::class, 'index'])->name('pegawai.dashboard');
Route::get('/pegawai/artikel', [App\Http\Controllers\LoginPegawai::class, 'artikel'])->name('pegawai.artikel');
Route::get('/pegawai/artikel/list', [App\Http\Controllers\LoginPegawai::class, 'my_artikel'])->name('pegawai.artikel.list');
Route::get('/pegawai/diskusi', [App\Http\Controllers\LoginPegawai::class, 'diskusi'])->name('pegawai.diskusi');
Route::get('/pegawai/logs', [App\Http\Controllers\LoginPegawai::class, 'logs'])->name('pegawai.logs');

Route::get('/pegawai/artikel/add', [App\Http\Controllers\LoginPegawai::class, 'artikel_baru'])->name('pegawai.artikel.new');
Route::get('/pegawai/artikel/show/{id}', [App\Http\Controllers\LoginPegawai::class, 'artikel_baca']);
Route::get('/pegawai/artikel/edit/{id}', [App\Http\Controllers\LoginPegawai::class, 'artikel_edit']);

Route::get('/pegawai/diskusi/show/{id}', [App\Http\Controllers\LoginPegawai::class, 'diskusi_baca']);

//POST
Route::POST('/pegawai/artikel/store', [App\Http\Controllers\PublicArtikelController::class, 'store']);
Route::POST('/pegawai/komentar/store', [App\Http\Controllers\PublicKomentarController::class, 'store']);
Route::POST('/pegawai/notulen/store', [App\Http\Controllers\PublicNotulenController::class, 'store']);

//UPDATE
Route::POST('/pegawai/artikel/update/{id}', [App\Http\Controllers\PublicArtikelController::class, 'update']);
Route::POST('/pegawai/komentar/update/{id}', [App\Http\Controllers\PublicKomentarController::class, 'update']);
Route::POST('/pegawai/notulen/update/{id}', [App\Http\Controllers\PublicNotulenController::class, 'update']);

//DESTROY
Route::GET('/pegawai/artikel/delete/{id}', [App\Http\Controllers\PublicArtikelController::class, 'destroy']);
Route::GET('/pegawai/komentar/delete/{id}', [App\Http\Controllers\PublicKomentarController::class, 'destroy']);
Route::GET('/pegawai/notulen/delete/{id}', [App\Http\Controllers\PublicNotulenController::class, 'destroy']);

//JSON
Route::get('/pegawai/artikel/json', [App\Http\Controllers\PublicArtikelController::class, 'json']);
Route::get('/pegawai/logs/json', [App\Http\Controllers\PublicLogsController::class, 'json']);

//FIND
Route::get('/pegawai/artikel/find/{id}', [App\Http\Controllers\PublicArtikelController::class, 'find']);
Route::get('/pegawai/komentar/find/{id}', [App\Http\Controllers\PublicKomentarController::class, 'find']);
Route::get('/pegawai/notulen/find/{id}', [App\Http\Controllers\PublicNotulenController::class, 'find']);

//JSON
Route::get('/public/archive/download/{id}', [App\Http\Controllers\HomeController::class, 'download']);
