<?php

use App\Http\Controllers\master\KategoriController;
use App\Http\Controllers\master\MemberController;
use App\Http\Controllers\master\ProdukController;
use App\Http\Controllers\master\SatuanController;
use App\Http\Controllers\pengaturan\PerusahaanController;
use App\Http\Controllers\pengaturan\ProfilController;
use App\Http\Controllers\pengaturan\UsersController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

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

Route::get('/', function () {
    return redirect()->route('login');
});

Route::group(['prefix' => 'pengaturan', 'as' => 'pengaturan.', 'middleware' => ['auth', 'perusahaan']], function () {
    Route::resource('profil', ProfilController::class);
    Route::resource('users', UsersController::class);

    Route::resource('perusahaan', PerusahaanController::class);
    Route::post('perusahaan/logo', [PerusahaanController::class, 'logo_update'])->name('perusahaan.logo_update');
});
Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified', 'perusahaan'])->name('dashboard');


Route::middleware('auth')->group(function () {
    // master 
    Route::prefix('master')->group(function () {
        Route::resource('satuan', SatuanController::class);
        Route::resource('kategori', KategoriController::class);
        Route::resource('produk', ProdukController::class);
        Route::resource('member', MemberController::class);
    });

    // pengaturan 
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::post('/profile/foto', [ProfileController::class, 'foto'])->name('profile.foto');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/perusahaan', [PerusahaanController::class, 'create'])->name('perusahaan.create');
    Route::post('/perusahaan', [PerusahaanController::class, 'store'])->name('perusahaan.store');
    Route::post('/theme', [ProfileController::class, 'theme'])->name('theme');
});

require __DIR__ . '/auth.php';
