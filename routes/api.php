<?php

use App\Http\Controllers\EmailListController;
use App\Http\Controllers\SubscriberController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/
Route::name('api.')->group(function() {
    Route::post('user/create', [UserController::class, 'register'])->name('user.register');
    Route::post('login', [UserController::class, 'login'])->name('user.login');

    Route::post('/list/{list}/subscriber', [SubscriberController::class, 'store'])->name('subscriber.store');
    
    Route::middleware('auth:sanctum')->group(function() {
        Route::post('email-list', [EmailListController::class, 'store'])->name('email-lists.store');
        Route::get('email-lists', [EmailListController::class, 'index'])->name('email-lists.index');
        Route::get('/email-list/{list}', [EmailListController::class, 'show'])->name('email-lists.show');
        Route::put('email-lists/{list}', [EmailListController::class, 'update'])->name('email-lists.update');
        Route::delete('email-list/{list}', [EmailListController::class, 'destroy'])->name('email-lists.destroy');
    });
});
