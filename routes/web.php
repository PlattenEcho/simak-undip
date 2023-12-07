<?php

use App\Http\Controllers\AccountController;
use App\Http\Controllers\CaptchaController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DepartemenController;
use App\Http\Controllers\IRSController;
use App\Http\Controllers\KHSController;
use App\Http\Controllers\PKLController;
use App\Http\Controllers\DoswalController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\MahasiswaController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\SkripsiController;
use App\Http\Controllers\OperatorController;
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

Route::get('/cetak', function () {
    return view('doswal.sudah_pkl_pdf');
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
    Route::get('/mahasiswa/dashboard', 'viewDashboardMahasiswa')->middleware('only_mahasiswa',  'profile_completed')->name('mahasiswa.dashboard');
    Route::get('/doswal/dashboard', 'viewDashboardDoswal')->middleware('only_doswal')->name('doswal.dashboard');
    Route::get('departemen/dashboard', 'viewDashboardDepartemen')->middleware('only_departemen')->name('departemen.dashboard');
});

Route::controller(MahasiswaController::class)->group(function () {
    Route::get('/operator/entry-data-mahasiswa', 'showEntryMhs')->middleware('only_operator')->name('mahasiswa.showEntry');
    Route::post('/operator/store-mahasiswa', 'store')->middleware('only_operator')->name('mahasiswa.store');
    Route::get('/mahasiswa/profile', 'viewProfile')->middleware('only_mahasiswa')->name('mahasiswa.viewProfile');
    Route::get('/mahasiswa/edit-profile', 'viewEditProfile')->middleware('only_mahasiswa')->name('mahasiswa.viewEditProfile');
    Route::post('/mahasiswa/edit-profile', 'update')->name('mahasiswa.update');
    Route::get('/mahasiswa/change-password', 'viewChangePassword')->middleware('only_mahasiswa', 'profile_completed')->name('mahasiswa.viewChangePassword');
    Route::post('/mahasiswa/change-password', 'update')->name('mahasiswa.update');
    // Route::get('/doswal/daftar-mhs', 'viewDaftarMhs')->middleware('only_doswal')->name('mahasiswa.viewDaftarMhs');
    // Route::get('/doswal/info-akademik/{nim}', 'viewInfoAkademik')->middleware('only_doswal')->name('mahasiswa.viewInfoAkademik');
    // Route::get('/mahasiswa', 'index');
    Route::get('/operator/generate-akun', 'viewGenerateAkun')->middleware('only_operator')->name('mahasiswa.viewGenerateAkun');
    Route::post('/operator/generate-akun', 'generateAccounts')->middleware('only_operator')->name('mahasiswa.generateAccounts');
    Route::get('/operator/daftar-akun', 'viewAccount')->middleware('only_operator')->name('mahasiswa.viewAccount');
    Route::post('/operator/mhs-import', 'import')->middleware('only_operator')->name('mahasiswa.import');
    Route::get('/operator/mhs-export', 'export')->middleware('only_operator')->name('mahasiswa.export');
});

Route::controller(OperatorController::class)->middleware('only_operator')->group(function () {
    Route::get('/operator/profile', 'viewProfile')->middleware('only_operator')->name('operator.viewProfile');
    Route::get('/operator/edit-profile', 'viewEditProfile')->middleware('only_operator')->name('operator.viewEditProfile');
    Route::post('/operator/edit-profile', 'update')->name('operator.update');
    Route::get('/operator/cetak-daftar-akun', 'cetakDaftarAkun')->name('operator.cetakDaftarAkun');
    Route::get('/operator/daftar-mhs', 'viewDaftarMhs')->name('operator.viewDaftarMhs');
    Route::get('/operator/info-akademik/{nim}', 'viewInfoAkademik')->name('operator.viewInfoAkademik');
    Route::get('/operator/view-status/{nim}', 'viewEditStatus')->middleware('only_operator')->name('operator.viewEditStatus');
    Route::post('/operator/edit-status/{nim}', 'update2')->middleware('only_operator')->name('operator.update2');
    Route::post('/operator/delete-mhs/{nim}', 'delete2')->middleware(['only_operator'])->name('operator.delete2');
    Route::get('/operator/search-mahasiswa', 'searchMahasiswa')->name('operator.searchMahasiswa');


    Route::get('/operator/rekap-pkl', 'viewRekapPKL')->name('operator.viewRekapPKL');
    Route::get('/operator/cetak-rekap-pkl/{tahun1}-{tahun2}', 'cetakRekapPKL')->name('operator.cetakRekapPKL');
    Route::get('/operator/daftar-sudah-pkl/{angkatan}', 'viewSudahPKL')->name('operator.viewSudahPKL');
    Route::get('/operator/daftar-belum-pkl/{angkatan}', 'viewBelumPKL')->name('operator.viewBelumPKL');
    Route::get('/operator/cetak-sudah-pkl/{angkatan}', 'cetakSudahPKL')->name('operator.cetakSudahPKL');
    Route::get('/operator/cetak-belum-pkl/{angkatan}', 'cetakBelumPKL')->name('operator.cetakBelumPKL');
    Route::get('/operator/rekap-skripsi', 'viewRekapSkripsi')->name('operator.viewRekapSkripsi');
    Route::get('/operator/cetak-rekap-skripsi/{tahun1}-{tahun2}', 'cetakRekapSkripsi')->name('operator.cetakRekapSkripsi');
    Route::get('/operator/daftar-sudah-skripsi/{angkatan}', 'viewSudahSkripsi')->name('operator.viewSudahSkripsi');
    Route::get('/operator/daftar-belum-skripsi/{angkatan}', 'viewBelumSkripsi')->name('operator.viewBelumSkripsi');
    Route::get('/operator/cetak-sudah-skripsi/{angkatan}', 'cetakSudahSkripsi')->name('operator.cetakSudahSkripsi');
    Route::get('/operator/cetak-belum-skripsi/{angkatan}', 'cetakBelumSkripsi')->name('operator.cetakBelumSkripsi');
    Route::get('/operator/rekap-status', 'viewRekapStatus')->name('operator.viewRekapStatus');
    Route::get('/operator/cetak-rekap-status', 'cetakRekapStatus')->name('operator.cetakRekapStatus');
    Route::get('/operator/daftar-mahasiswa/{angkatan}/{status}', 'viewDaftarMhsStatus')->name('operator.viewDaftarMhsStatus');
    Route::get('/operator/cetak-daftar-mahasiswa/{angkatan}/{status}', 'cetakDaftarMhsStatus')->name('operator.cetakDaftarMhsStatus');
});

Route::controller(IRSController::class)->group(function () {
    Route::get('/mahasiswa/entry-irs', 'viewEntryIRS')->middleware(['only_mahasiswa', 'profile_completed'])->name('irs.viewEntry');
    Route::get('/mahasiswa/irs', 'viewIRS')->middleware(['only_mahasiswa', 'profile_completed'])->name('irs.viewIRS');
    Route::post('/mahasiswa/irs', 'store')->middleware(['only_mahasiswa', 'profile_completed'])->name('irs.store');
    Route::get('/mahasiswa/edit-irs/{id}', 'viewEditIRS2')->middleware(['only_mahasiswa'])->name('irs.viewEditIRS2');
    Route::post('/mahasiswa/edit-irs/{id}', 'update2')->middleware(['only_mahasiswa'])->name('irs.update2');
    Route::post('/mahasiswa/delete-irs/{id}', 'delete')->middleware(['only_mahasiswa'])->name('irs.delete2');
    Route::post('/doswal/edit-irs/{id}', 'update')->middleware(['only_doswal'])->name('irs.update');
    Route::post('/doswal/delete-irs/{id}', 'delete')->middleware(['only_doswal'])->name('irs.delete');
    Route::get('/doswal/edit-irs/{id}', 'viewEditIRS')->middleware(['only_doswal'])->name('irs.viewEditIRS');
    Route::post('/doswal/verif-irs/{id}', 'verifikasi')->middleware(['only_doswal'])->name('irs.verifikasi');
    Route::get('/doswal/filter-irs', 'filter')->middleware(['only_doswal'])->name('irs.filter');
});

Route::controller(KHSController::class)->group(function () {
    Route::get('/mahasiswa/entry-khs', 'viewEntryKHS')->middleware(['only_mahasiswa', 'profile_completed'])->name('khs.viewEntry');
    Route::get('/mahasiswa/khs', 'viewKHS')->middleware(['only_mahasiswa', 'profile_completed'])->name('khs.viewKHS');
    Route::post('/mahasiswa/khs', 'store')->middleware(['only_mahasiswa', 'profile_completed'])->name('khs.store');
    Route::post('/mahasiswa/edit-khs/{id}', 'update2')->middleware(['only_mahasiswa'])->name('khs.update2');
    Route::post('/mahasiswa/delete-khs/{id}', 'delete')->middleware(['only_mahasiswa'])->name('khs.delete2');
    Route::get('/mahasiswa/edit-khs/{id}', 'viewEditKHS2')->middleware(['only_mahasiswa'])->name('khs.viewEditKHS2');
    Route::post('/doswal/edit-khs/{id}', 'update')->middleware(['only_doswal'])->name('khs.update');
    Route::post('/doswal/delete-khs/{id}', 'delete')->middleware(['only_doswal'])->name('khs.delete');
    Route::get('/doswal/edit-khs/{id}', 'viewEditKHS')->middleware(['only_doswal'])->name('khs.viewEditKHS');
    Route::post('/doswal/verif-khs/{id}', 'verifikasi')->middleware(['only_doswal'])->name('khs.verifikasi');
    Route::get('/doswal/filter-khs', 'filter')->middleware(['only_doswal'])->name('khs.filter');
});

Route::controller(PKLController::class)->group(function () {
    Route::get('/mahasiswa/entry-pkl', 'viewEntryPKL')->middleware(['only_mahasiswa', 'profile_completed'])->name('pkl.viewEntry');
    Route::get('/mahasiswa/pkl', 'viewPKL')->middleware(['only_mahasiswa', 'profile_completed'])->name('pkl.viewPKL');
    Route::post('/mahasiswa/pkl', 'store')->middleware(['only_mahasiswa', 'profile_completed'])->name('pkl.store');
    Route::post('/mahasiswa/edit-pkl/{id}', 'update2')->middleware(['only_mahasiswa'])->name('pkl.update2');
    Route::post('/mahasiswa/delete-pkl/{id}', 'delete')->middleware(['only_mahasiswa'])->name('pkl.delete2');
    Route::get('/mahasiswa/edit-pkl/{id}', 'viewEditPKL2')->middleware(['only_mahasiswa'])->name('pkl.viewEditPKL2');

    Route::post('/doswal/edit-pkl/{id}', 'update')->middleware(['only_doswal'])->name('pkl.update');
    Route::post('/doswal/delete-pkl/{id}', 'delete')->middleware(['only_doswal'])->name('pkl.delete');
    Route::get('/doswal/edit-pkl/{id}', 'viewEditPKL')->middleware(['only_doswal'])->name('pkl.viewEditPKL');
    Route::post('/doswal/verif-pkl/{id}', 'verifikasi')->middleware(['only_doswal'])->name('pkl.verifikasi');
    Route::get('/doswal/filter-pkl', 'filter')->middleware(['only_doswal'])->name('pkl.filter');
});

Route::controller(SkripsiController::class)->group(function () {
    Route::get('/mahasiswa/skripsi', 'viewSkripsi')->middleware(['only_mahasiswa', 'profile_completed'])->name('skripsi.viewSkripsi');
    Route::get('/mahasiswa/entry-skripsi', 'viewEntrySkripsi')->middleware(['only_mahasiswa', 'profile_completed'])->name('skripsi.viewEntry');
    Route::post('/mahasiswa/skripsi', 'store')->middleware(['only_mahasiswa', 'profile_completed'])->name('skripsi.store');
    Route::get('/mahasiswa/edit-skripsi/{id}', 'viewEditSkripsiM')->middleware(['only_mahasiswa', 'profile_completed'])->name('skripsi.viewEditSkripsiM');
    Route::post('/mahasiswa/edit-skripsi/{id}', 'update')->middleware(['only_mahasiswa', 'profile_completed'])->name('skripsi.updateM');
    // Route::get('/mahasiswa/delete-skripsi/{id}', 'viewDeleteSkripsiM')->middleware(['only_mahasiswa', 'profile_completed'])->name('skripsi.viewDeleteSkripsiM');
    Route::post('/mahasiswa/delete-skripsi/{id}', 'deleteM')->middleware(['only_mahasiswa', 'profile_completed'])->name('skripsi.delete2');


    Route::post('/doswal/edit-skripsi/{id}', 'update')->middleware(['only_doswal'])->name('skripsi.update');
    Route::post('/doswal/delete-skripsi/{id}', 'delete')->middleware(['only_doswal'])->name('skripsi.delete');
    Route::get('/doswal/edit-skripsi/{id}', 'viewEditSkripsi')->middleware(['only_doswal'])->name('skripsi.viewEditSkripsi');
    Route::post('/doswal/verif-skripsi/{id}', 'verifikasi')->middleware(['only_doswal'])->name('skripsi.verifikasi');
    Route::get('/doswal/filter-skripsi', 'filter')->middleware(['only_doswal'])->name('skripsi.filter');
});

Route::controller(DoswalController::class)->middleware('only_doswal')->group(function () {
    Route::get('/view', 'show')->name('daftar_mhs');
    Route::get('/doswal/search-mahasiswa', 'searchMahasiswa')->name('doswal.searchMahasiswa');
    //Route::post('/doswal/search-mahasiswa', 'searchMahasiswa');
    Route::get('/doswal/profile', 'viewProfile')->name('doswal.viewProfile');
    Route::get('/doswal/edit-profile', 'viewEditProfile')->name('doswal.viewEditProfile');
    Route::post('/doswal/edit-profile', 'update')->name('doswal.update');
    Route::get('/doswal/verifikasi-irs', 'viewVerifikasiIRS')->name('doswal.viewVerifikasiIRS');
    Route::get('/doswal/verifikasi-khs', 'viewVerifikasiKHS')->name('doswal.viewVerifikasiKHS');
    Route::get('/doswal/verifikasi-pkl', 'viewVerifikasiPKL')->name('doswal.viewVerifikasiPKL');
    Route::get('/doswal/verifikasi-skripsi', 'viewVerifikasiSkripsi')->name('doswal.viewVerifikasiSkripsi');
    Route::get('/doswal/filter-IRS', 'filterIRS')->name('doswal.filterIRS');
    Route::get('/doswal/daftar-mhs', 'viewDaftarMhs')->name('doswal.viewDaftarMhs');
    Route::get('/doswal/info-akademik/{nim}', 'viewInfoAkademik')->name('doswal.viewInfoAkademik');
    Route::get('/doswal/rekap-pkl', 'viewRekapPKL')->name('doswal.viewRekapPKL');
    Route::get('/doswal/cetak-rekap-pkl/{tahun1}-{tahun2}', 'cetakRekapPKL')->name('doswal.cetakRekapPKL');
    Route::get('/doswal/daftar-sudah-pkl/{angkatan}', 'viewSudahPKL')->name('doswal.viewSudahPKL');
    Route::get('/doswal/daftar-belum-pkl/{angkatan}', 'viewBelumPKL')->name('doswal.viewBelumPKL');
    Route::get('/doswal/cetak-sudah-pkl/{angkatan}', 'cetakSudahPKL')->name('doswal.cetakSudahPKL');
    Route::get('/doswal/cetak-belum-pkl/{angkatan}', 'cetakBelumPKL')->name('doswal.cetakBelumPKL');
    Route::get('/doswal/rekap-skripsi', 'viewRekapSkripsi')->name('doswal.viewRekapSkripsi');
    Route::get('/doswal/cetak-rekap-skripsi/{tahun1}-{tahun2}', 'cetakRekapSkripsi')->name('doswal.cetakRekapSkripsi');
    Route::get('/doswal/daftar-sudah-skripsi/{angkatan}', 'viewSudahSkripsi')->name('doswal.viewSudahSkripsi');
    Route::get('/doswal/daftar-belum-skripsi/{angkatan}', 'viewBelumSkripsi')->name('doswal.viewBelumSkripsi');
    Route::get('/doswal/cetak-sudah-skripsi/{angkatan}', 'cetakSudahSkripsi')->name('doswal.cetakSudahSkripsi');
    Route::get('/doswal/cetak-belum-skripsi/{angkatan}', 'cetakBelumSkripsi')->name('doswal.cetakBelumSkripsi');
    Route::get('/doswal/rekap-status', 'viewRekapStatus')->name('doswal.viewRekapStatus');
    Route::get('/doswal/cetak-rekap-status', 'cetakRekapStatus')->name('doswal.cetakRekapStatus');
    Route::get('/doswal/daftar-mahasiswa/{angkatan}/{status}', 'viewDaftarMhsStatus')->name('doswal.viewDaftarMhsStatus');
    Route::get('/doswal/cetak-daftar-mahasiswa/{angkatan}/{status}', 'cetakDaftarMhsStatus')->name('doswal.cetakDaftarMhsStatus');
});

Route::controller(AccountController::class)->middleware('auth')->group(function () {
    Route::get('/change-password', 'viewChangePassword')->name('account.viewChangePassword');
    Route::post('/change-password', 'update')->name('account.update');
});

Route::controller(DepartemenController::class)->middleware('only_departemen')->group(function () {
    Route::get('/departemen/rekap-status', 'viewRekapStatus')->name('departemen.viewRekapStatus');
    Route::get('/departemen/profile', 'viewProfile')->name('departemen.viewProfile');
    Route::get('/departemen/edit-profile', 'viewEditProfile')->name('departemen.viewEditProfile');
    Route::post('/departemen/edit-profile', 'update')->name('departemen.update');
    Route::get('/departemen/daftar-mhs', 'viewDaftarMhs')->name('departemen.viewDaftarMhs');
    Route::get('/departemen/search-mahasiswa', 'searchMahasiswa')->name('departemen.searchMahasiswa');
    //Route::post('/departemen/search-mahasiswa', 'searchMahasiswa');
    Route::get('/departemen/info-akademik/{nim}', 'viewInfoAkademik')->name('departemen.viewInfoAkademik');
    Route::get('/departemen/rekap-pkl', 'viewRekapPKL')->name('departemen.viewRekapPKL');
    Route::get('/departemen/cetak-rekap-pkl/{tahun1}-{tahun2}', 'cetakRekapPKL')->name('departemen.cetakRekapPKL');
    Route::get('/departemen/daftar-sudah-pkl/{angkatan}', 'viewSudahPKL')->name('departemen.viewSudahPKL');
    Route::get('/departemen/daftar-belum-pkl/{angkatan}', 'viewBelumPKL')->name('departemen.viewBelumPKL');
    Route::get('/departemen/cetak-sudah-pkl/{angkatan}', 'cetakSudahPKL')->name('departemen.cetakSudahPKL');
    Route::get('/departemen/cetak-belum-pkl/{angkatan}', 'cetakBelumPKL')->name('departemen.cetakBelumPKL');
    Route::get('/departemen/rekap-skripsi', 'viewRekapSkripsi')->name('departemen.viewRekapSkripsi');
    Route::get('/departemen/cetak-rekap-skripsi/{tahun1}-{tahun2}', 'cetakRekapSkripsi')->name('departemen.cetakRekapSkripsi');
    Route::get('/departemen/daftar-sudah-skripsi/{angkatan}', 'viewSudahSkripsi')->name('departemen.viewSudahSkripsi');
    Route::get('/departemen/daftar-belum-skripsi/{angkatan}', 'viewBelumSkripsi')->name('departemen.viewBelumSkripsi');
    Route::get('/departemen/cetak-sudah-skripsi/{angkatan}', 'cetakSudahSkripsi')->name('departemen.cetakSudahSkripsi');
    Route::get('/departemen/cetak-belum-skripsi/{angkatan}', 'cetakBelumSkripsi')->name('departemen.cetakBelumSkripsi');
    Route::get('/departemen/rekap-status', 'viewRekapStatus')->name('departemen.viewRekapStatus');
    Route::get('/departemen/cetak-rekap-status', 'cetakRekapStatus')->name('departemen.cetakRekapStatus');
    Route::get('/departemen/daftar-mahasiswa/{angkatan}/{status}', 'viewDaftarMhsStatus')->name('departemen.viewDaftarMhsStatus');
    Route::get('/departemen/cetak-daftar-mahasiswa/{angkatan}/{status}', 'cetakDaftarMhsStatus')->name('departemen.cetakDaftarMhsStatus');
});
