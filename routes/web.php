<?php

use App\Http\Controllers\GuestBookController;
use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/', function () {
    return redirect()->route('guest-books.create');
});

//form input tamu (dapat diakses pengujung/resepsionis)
Route::get('/buku-tamu', [GuestBookController::class, 'create'])->name('guest-books.create');
Route::post ('/buku-tamu', [GuestBookController::class, 'store'])->name('guest-books.store');

//dashboard & Rekap Data Tamu (Hanya untuk pengguna yang sudah login)
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', [GuestBookController::class, 'index'])->name('guest-books.index');
    Route::resource('guest-books', GuestBookController::class)->except(['create', 'store', 'index']);
});


require __DIR__.'/auth.php';
