<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\IRSController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\MahasiswaController;
use App\Http\Controllers\RegisterController;
 use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return view('welcome');
});

Route::controller(LoginController::class)->group(function() {
    Route::get('/login', 'index')->middleware('guest')->name('login');
    Route::post('/login', 'authenticate')->name('authenticate');
    Route::post('/logout', 'logout');
});

// Route::get('/register', [RegisterController::class, 'index'])->middleware('guest')->name('register');
// Route::post('/register', [RegisterController::class, 'store'])->name('registerStore');

Route::controller(RegisterController::class)->group(function() {
    Route::get('/register', 'index')->middleware('guest')->name('register');
    Route::post('/register', 'store')->name('registerStore');
});

Route::controller(DashboardController::class)->middleware('auth')->group(function() {
    Route::get('/operator/dashboard', 'viewDashboardOperator')->name('operator.dashboard');
    Route::get('/mahasiswa/dashboard', 'viewDashboardMahasiswa')->name('mahasiswa.dashboard');
});

Route::controller(MahasiswaController::class)->group(function() {
    Route::get('/operator/entry-data-mahasiswa', 'showEntryMhs')->name('mahasiswa.showEntry');
    Route::post('/operator/store-mahasiswa', 'store')->name('mahasiswa.store');
    Route::get('/mahasiswa/profile', 'viewProfile')->name('mahasiswa.viewProfile');
    Route::get('/mahasiswa/edit-profile', 'viewEditProfile')->name('mahasiswa.viewEditProfile');
    Route::post('/mahasiswa/edit-profile', 'update')->name('mahasiswa.update');
});

Route::controller(IRSController::class)->group(function() {
    Route::get('/mahasiswa/entry-irs', 'viewEntryIRS')->name('irs.viewEntry');
    Route::get('/mahasiswa/irs', 'viewIRS')->name('irs.viewIRS');
    Route::post('/mahasiswa/irs', 'store')->name('irs.store');
});

Route::get('/get-matkul-by-semester/{semester}', 'MatkulController@getMatkulBySemester');
