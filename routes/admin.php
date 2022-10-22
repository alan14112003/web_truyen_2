<?php


use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\LevelController;
use Illuminate\Support\Facades\Route;

Route::get('/welcome', [AdminController::class, 'welcome'])->name('welcome');

Route::prefix('levels')->name('levels.')->controller(LevelController::class)->group(function() {
    Route::get('/', 'index')->name('index');
    Route::get('/create', 'create')->name('create');
    Route::post('/create', 'store')->name('store');
    Route::get('/edit/{id}', 'edit')->name('edit');
    Route::put('/edit/{id}', 'update')->name('update');
    Route::delete('/destroy/{id}', 'destroy')->name('destroy');
});
