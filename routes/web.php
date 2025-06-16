<?php

use App\Models\Book;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Dashboard\DashboardController;
use Illuminate\Support\Facades\Broadcast;

Route::redirect('/', '/login');

Route::controller(AuthController::class)->group(function () {
    Route::get('/login', 'show_login')->name('show-login');
    Route::post('/login', 'attempt_login')->name('attempt-login');
    Route::get('/register', 'show_register')->name('show-register');
    Route::post('/register', 'attempt_register')->name('attempt-register');
    Route::post('/logout', 'logout')->name('logout');
    Route::get('/verify', 'show_verify_code')->name('show_verify_code');
    Route::post('/verify', 'verify_code')->name('verify_code');
});

Route::controller(DashboardController::class)->group(function () {
    Route::get('/dashboard', 'dashboard')->middleware('auth')->name('show-dashboard');
});

Route::get('/download/books/{bookId}', function (int $bookId) {
    $book = Book::findOrFail($bookId);
    return Storage::download($book->path, $book->name);
})->name('book-download');

Broadcast::routes(['middleware' => ['auth']]);