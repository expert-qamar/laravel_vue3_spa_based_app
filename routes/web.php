<?php

use Illuminate\Support\Facades\Route;

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

// Route::get('/', function () {
//     return view('welcome');
// });

Route::post('login', [\App\Http\Controllers\Auth\AuthenticatedSessionController::class, 'store'])->name('login');
Route::post('logout', [\App\Http\Controllers\Auth\AuthenticatedSessionController::class, 'destroy'])->name('logout');
Route::post('register', [\App\Http\Controllers\Auth\RegisteredUserController::class, 'store'])->name('login');
//
Route::view('/{any?}', 'dashboard')
    ->name('dashboard')
    ->where('any', '.*');

//require __DIR__.'/auth.php';
