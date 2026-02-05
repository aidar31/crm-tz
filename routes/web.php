<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\Admin\AdminTicketController;
;
use Illuminate\Support\Facades\Route;


Route::middleware(['auth'])->group(function () {
    Route::get('/', function () {
        return view('welcome');
    })->name('welcome');
});

Route::prefix('auth')->group(function () {
    Route::controller(AuthController::class)->group(function () {

        Route::middleware(['redirectIfAuthenticated'])->group(function () {
            Route::get("/login", 'login_view')->name('login');
            Route::post("/login", 'authenticate_view');
        });
        Route::middleware(['isAuthenticated'])->group(function () {
            Route::get("/logout", 'logout_view')->name('logout');
        });
    });
});

Route::middleware(['isAuthenticated'])->group(function () {
    Route::group(['prefix' => 'admin', 'as' => 'admin.'], function () {
        Route::get('/tickets', [AdminTicketController::class, 'index'])->name('tickets.index');
        Route::get('/tickets/{ticket}', [AdminTicketController::class, 'show'])->name('tickets.show');
        Route::patch('/tickets/{ticket}/status', [AdminTicketController::class, 'updateStatus'])->name('tickets.update-status');
    });
});
