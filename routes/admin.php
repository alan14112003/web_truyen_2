<?php


use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\LevelController;
use App\Http\Controllers\Admin\StoryController;
use App\Http\Controllers\Admin\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', [AdminController::class, 'welcome'])->name('index');

Route::prefix('levels')->name('levels.')->controller(LevelController::class)->group(function() {
    Route::get('/', 'index')->name('index');
    Route::get('/create', 'create')->name('create');
    Route::post('/create', 'store')->name('store');
    Route::get('/edit/{id}', 'edit')->name('edit');
    Route::put('/edit/{id}', 'update')->name('update');
    Route::delete('/destroy/{id}', 'destroy')->name('destroy');
});


Route::prefix('users')->name('users.')->controller(UserController::class)->group(function() {
    Route::get('/', 'index')->name('index');
    Route::get('/black_list', 'blackList')->name('black_list');
    Route::get('/create', 'create')->name('create');
    Route::post('/create', 'store')->name('store');
    Route::delete('/destroy/{id}', 'destroy')->name('destroy');

    Route::post('/restore/{id}', 'restore')->name('restore');
    Route::delete('/kill/{id}', 'kill')->name('kill');
});


Route::prefix('categories')->name('categories.')
    ->controller(CategoryController::class)->group(function() {
    Route::get('/', 'index')->name('index');
    Route::get('/create', 'create')->name('create');
    Route::post('/create', 'store')->name('store');
    Route::get('/edit/{id}', 'edit')->name('edit');
    Route::put('/edit/{id}', 'update')->name('update');
    Route::delete('/destroy/{id}', 'destroy')->name('destroy');
});

Route::prefix('stories')->name('stories.')
    ->controller(StoryController::class)->group(function() {
        Route::get('/', 'index')->name('index');
        Route::get('/black_list', 'blackList')->name('black_list');
        Route::get('/view/{id}', 'view')->name('view');

        Route::get('/create', 'create')->name('create');
        Route::post('/create', 'store')->name('store');
        Route::get('/edit/{id}', 'edit')->name('edit');
        Route::put('/edit/{id}', 'update')->name('update');
        Route::delete('/destroy/{id}', 'destroy')->name('destroy');
        Route::post('/approve/{id}', 'approve')->name('approve');
        Route::post('/pinned/{id}', 'pinned')->name('pinned');

        Route::post('/restore/{id}', 'restore')->name('restore');
        Route::delete('/kill/{id}', 'kill')->name('kill');
    });
