<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\LevelController;
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

Route::get('/', function () {
    return view('page.index');
})->name('index');

Route::controller(AuthController::class)->group(function () {
    Route::get('/login', 'login')->name('login');
    Route::post('/login', 'logining')->name('logining');

    Route::get('/register', 'register')->name('register');
    Route::post('/register', 'registering')->name('registering');

    Route::get('/auth/redirect/{provider}', 'redirect')->name('auth.redirect');
    Route::get('/auth/callback/{provider}', 'callback')->name('auth.callback');

    Route::get('/logout', 'logout')->name('logout');
});
