<?php

use App\Jobs\SendEmail;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CartController;
use App\Http\Controllers\PeminjamanController;
use App\Http\Controllers\SeriController;
use App\Http\Controllers\UserController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// #region //*============ peminjaman ============

Route::post('/peminjaman', [PeminjamanController::class, 'create'])->name('peminjaman.create')->middleware(['user']);
Route::post('/peminjaman/webhook', [PeminjamanController::class, 'webhook']);
Route::get('/peminjaman', [PeminjamanController::class, 'getMyPeminjamanList'])->name('peminjaman.index')->middleware(['user']);

// #region //*=============== user ===============

Route::inertia('/auth/register', 'auth/register')->name('auth.register.index');
Route::inertia('/auth/login', 'auth/login')->name('auth.login.index');
Route::post('/auth/register', [UserController::class, 'storeUser'])->name('auth.register');
Route::post('/auth/login', [UserController::class, 'storeLogin'])->name('auth.login');
Route::post('/auth/logout', [UserController::class, 'destroyLogin'])->name('auth.logout')->middleware(['user']);
Route::get('/users', [UserController::class, 'getUserList'])->middleware(['admin']);

// #region //*=============== seri ===============

Route::get('/seri', [SeriController::class, 'getSeriList'])->name('seri.index');
Route::get('/seri/detail/{id}', [SeriController::class, 'getDetailSeri'])->name('seri.detail');
Route::get('/seri/create', [SeriController::class, 'createSeriView'])->name('seri.create.index')->middleware(['admin']);
Route::get('/seri/update/{id}', [SeriController::class, 'updateSeriView'])->name('seri.update.index')->middleware(['admin']);
Route::post('/seri/create', [SeriController::class, 'createSeri'])->name('seri.create')->middleware(['admin']);
Route::post('/seri/genre/create', [SeriController::class, 'createGenre'])->name('seri.genre.create')->middleware(['admin']);
Route::post('/seri/penerbit/create', [SeriController::class, 'createPenerbit'])->name('seri.penerbit.create')->middleware(['admin']);
Route::post('/seri/penulis/create', [SeriController::class, 'createPenulis'])->name('seri.penulis.create')->middleware(['admin']);
Route::patch('/seri/update/{id}', [SeriController::class, 'updateSeri'])->name('seri.update')->middleware(['admin']);
Route::patch('/seri/genre/update/{id}', [SeriController::class, 'updateGenre'])->name('genre.update')->middleware(['admin']);
Route::patch('/seri/penerbit/update/{id}', [SeriController::class, 'updatePenerbit'])->name('penerbit.update')->middleware(['admin']);
Route::patch('/seri/penulis/update/{id}', [SeriController::class, 'updatePenulis'])->name('penulis.update')->middleware(['admin']);
Route::delete('/seri/delete/{id}', [SeriController::class, 'deleteSeri'])->name('seri.delete')->middleware(['admin']);
Route::delete('/seri/genre/delete/{id}', [SeriController::class, 'deleteGenre'])->name('genre.delete')->middleware(['admin']);
Route::delete('/seri/penerbit/delete/{id}', [SeriController::class, 'deletePenerbit'])->name('penerbit.delete')->middleware(['admin']);
Route::delete('/seri/penulis/delete/{id}', [SeriController::class, 'deletePenulis'])->name('penulis.delete')->middleware(['admin']);

// #region //*=============== cart ===============

Route::get('/cart', [CartController::class, 'getCartUser'])->name('cart.index')->middleware(['user']);
Route::post('/cart', [CartController::class, 'createCart'])->name('cart.create')->middleware(['user']);
Route::delete('/cart/{id}', [CartController::class, 'deleteCart'])->name('cart.delete')->middleware(['user']);
Route::delete('/cart/volume/{id}', [CartController::class, 'deleteCartByVolumeId'])->name('cart.delete.volume')->middleware(['user']);

// #region //*=============== home ===============

Route::get('/', function () {
    return redirect(route('seri.index'));
});


Route::get('/queue', function () {
    SendEmail::dispatch();
    return "Email sent";
});
