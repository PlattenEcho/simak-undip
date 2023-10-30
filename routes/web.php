<?php

use App\Http\Controllers\AccountController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\IRSController;
use App\Http\Controllers\KHSController;
use App\Http\Controllers\PKLController;
use App\Http\Controllers\DoswalController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\MahasiswaController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\SkripsiController;
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

Route::controller(LoginController::class)->group(function () {
    Route::get('/login', 'index')->middleware('guest')->name('login');
    Route::post('/login', 'authenticate')->name('authenticate');
    Route::post('/logout', 'logout')->middleware('auth');
});

// Route::get('/register', [RegisterController::class, 'index'])->middleware('guest')->name('register');
// Route::post('/register', [RegisterController::class, 'store'])->name('registerStore');

Route::controller(RegisterController::class)->group(function () {
    Route::get('/register', 'index')->middleware('guest')->name('register');
    Route::post('/register', 'store')->name('registerStore');
});

Route::controller(DashboardController::class)->middleware('auth')->group(function () {
    Route::get('/operator/dashboard', 'viewDashboardOperator')->middleware('only_operator')->name('operator.dashboard');
    Route::get('/mahasiswa/dashboard', 'viewDashboardMahasiswa')->middleware('only_mahasiswa')->name('mahasiswa.dashboard');
    Route::get('/doswal/dashboard', 'viewDashboardDoswal')->middleware('only_doswal')->name('doswal.dashboard');
});

Route::controller(MahasiswaController::class)->group(function () {
    Route::get('/operator/entry-data-mahasiswa', 'showEntryMhs')->middleware('only_operator')->name('mahasiswa.showEntry');
    Route::post('/operator/store-mahasiswa', 'store')->middleware('only_operator')->name('mahasiswa.store');
    Route::get('/mahasiswa/profile', 'viewProfile')->middleware('only_mahasiswa')->name('mahasiswa.viewProfile');
    Route::get('/mahasiswa/edit-profile', 'viewEditProfile')->middleware('only_mahasiswa')->name('mahasiswa.viewEditProfile');
    Route::post('/mahasiswa/edit-profile', 'update')->name('mahasiswa.update');
    Route::get('/doswal/daftar-mhs', 'viewDaftarMhs')->middleware('only_doswal')->name('mahasiswa.viewDaftarMhs');
    Route::get('/doswal/info-akademik/{nim}', 'viewInfoAkademik')->middleware('only_doswal')->name('mahasiswa.viewInfoAkademik');
});

Route::controller(IRSController::class)->middleware(['only_mahasiswa', 'profile_completed'])->group(function () {
    Route::get('/mahasiswa/entry-irs', 'viewEntryIRS')->name('irs.viewEntry');
    Route::get('/mahasiswa/irs', 'viewIRS')->name('irs.viewIRS');
    Route::get('/mahasiswa/edit-irs/{id}', 'viewEditIRS')->name('irs.viewEditIRS');
    Route::post('/mahasiswa/irs', 'store')->name('irs.store');
    Route::post('/mahasiswa/edit-irs/{id}', 'update')->name('irs.update');
});

Route::controller(KHSController::class)->middleware(['only_mahasiswa', 'profile_completed'])->group(function () {
    Route::get('/mahasiswa/entry-khs', 'viewEntryKHS')->name('khs.viewEntry');
    Route::get('/mahasiswa/khs', 'viewKHS')->name('khs.viewKHS');
    Route::get('/mahasiswa/edit-khs/{id}', 'viewEditKHS')->name('khs.viewEditKHS');
    Route::post('/mahasiswa/khs', 'store')->name('khs.store');
    Route::post('/mahasiswa/edit-khs/{id}', 'update')->name('khs.update');
});

Route::controller(PKLController::class)->middleware(['only_mahasiswa','profile_completed'])->group(function() {
    Route::get('/mahasiswa/entry-pkl', 'viewEntryPKL')->name('pkl.viewEntry');
    Route::get('/mahasiswa/pkl', 'viewPKL')->name('pkl.viewPKL');
    Route::get('/mahasiswa/edit-pkl/{id}', 'viewEditPKL')->name('pkl.viewEditPKL');
    Route::post('/mahasiswa/pkl', 'store')->name('pkl.store');
    Route::post('/mahasiswa/edit-pkl/{id}', 'update')->name('pkl.update');
});

Route::controller(SkripsiController::class)->middleware(['only_mahasiswa', 'profile_completed'])->group(function () {
    Route::get('/mahasiswa/skripsi', 'viewSkripsi')->name('skripsi.viewSkripsi');
    // Route::get('/mahasiswa/entry-khs', 'viewEntryKHS')->name('khs.viewEntry');
    // Route::get('/mahasiswa/khs', 'viewKHS')->name('khs.viewKHS');
    // Route::get('/mahasiswa/edit-khs/{id}', 'viewEditKHS')->name('khs.viewEditKHS');
    // Route::post('/mahasiswa/khs', 'store')->name('khs.store');
    // Route::post('/mahasiswa/edit-khs/{id}', 'update')->name('khs.update');
});

Route::controller(DoswalController::class)->group(function () {
    Route::get('/view', 'show')->name('daftar_mhs');
    Route::get('/search-mahasiswa', 'searchMahasiswa')->name('searchMahasiswa');
    Route::post('/search-mahasiswa', 'searchMahasiswa'); 
});



Route::controller(AccountController::class)->middleware('auth')->group(function () {
    Route::get('/change-password', 'viewChangePassword')->name('account.viewChangePassword');
    Route::post('/change-password', 'update')->name('account.update');
});


