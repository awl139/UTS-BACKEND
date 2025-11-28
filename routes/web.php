<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProdukController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/', [HomeController::class, 'home']);
Route::get('/home', [HomeController::class, 'home']);
Route::get('/about/{nama}', [HomeController::class, 'about']);

// Routes untuk frontend
Route::get('/produk', [ProdukController::class, 'homeProduk'])->name('produk');
Route::get('/produk/detail/{nama}', [ProdukController::class, 'detail']);
Route::get('/produk/search', [ProdukController::class, 'search'])->name('produk.search');

// Dashboard dan Auth
Route::get('/dashboard', [DashboardController::class, 'index'])->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Routes untuk Admin Produk (Sesuai Soal - TAPI pakai produk bukan products)
Route::middleware(['auth', 'role:admin'])->prefix('admin')->group(function () {
    Route::get('/produk', [ProdukController::class, 'index'])->name('admin.produk');
    Route::get('/produk/create', [ProdukController::class, 'create'])->name('admin.produk.create');
    Route::post('/produk/store', [ProdukController::class, 'store'])->name('admin.produk.store');
    Route::get('/produk/edit/{id}', [ProdukController::class, 'edit'])->name('admin.produk.edit');
    Route::put('/produk/update/{id}', [ProdukController::class, 'update'])->name('admin.produk.update');
    Route::delete('/produk/delete/{id}', [ProdukController::class, 'destroy'])->name('admin.produk.delete');
});

// Routes untuk Staff 
Route::middleware(['auth', 'role:staff'])->prefix('staff')->group(function () {
    Route::get('/produk', [ProdukController::class, 'index'])->name('staff.produk');
    Route::get('/produk/create', [ProdukController::class, 'create'])->name('staff.produk.create');
    Route::post('/produk/store', [ProdukController::class, 'store'])->name('staff.produk.store');
    Route::get('/produk/edit/{id}', [ProdukController::class, 'edit'])->name('staff.produk.edit');
    Route::put('/produk/update/{id}', [ProdukController::class, 'update'])->name('staff.produk.update');
    Route::delete('/produk/delete/{id}', [ProdukController::class, 'destroy'])->name('staff.produk.delete');
});

// Role-based dashboard access
Route::get('/admin-dashboard', function () {
    return view('dashboard.admin');
})->middleware(['auth', 'role:admin']);

Route::get('/user-dashboard', function () {
    return view('dashboard.user');
})->middleware(['auth', 'role:user']);

Route::get('/staff-dashboard', function () {
    return view('dashboard.staff');
})->middleware(['auth', 'role:staff']);

require __DIR__.'/auth.php';