<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\FrontPage\HistoryController;
use App\Http\Controllers\FrontPage\HomeController;
use App\Http\Controllers\FrontPage\StarController;
use App\Http\Controllers\LevelController;
use App\Models\Story;
use Diglactic\Breadcrumbs\Breadcrumbs;
use Diglactic\Breadcrumbs\Generator as BreadcrumbTrail;
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


Route::controller(AuthController::class)->group(function () {
    Route::get('/login', 'login')->name('login');
    Route::post('/login', 'logining')->name('logining');

    Route::get('/register', 'register')->name('register');
    Route::post('/register', 'registering')->name('registering');

    Route::get('/auth/redirect/{provider}', 'redirect')->name('auth.redirect');
    Route::get('/auth/callback/{provider}', 'callback')->name('auth.callback');

    Route::post('/logout', 'logout')->name('logout');
});

Route::controller(HomeController::class)->group(function () {
    Route::get('/', 'index')->name('index');
    Route::get('/tim-truyen-nang-cao', 'advancedSearch')->name('advanced_search');
    Route::get('/the-loai/{slug}', 'showCategories')->name('show_categories');
    Route::get('/truyen/{slug}', 'showStory')->name('show_story');
    Route::get('/truyen/{slug}/chuong-{number}', 'showChapter')->name('show_chapter');
});

Route::post('star/create/{story}', [StarController::class, 'create'])->name('star.create');

Route::post('/history/destroy', [HistoryController::class, 'destroy'])->name('history.destroy');

Route::get('/test', function (){
   return view('page.header');
});


// Trang chủ
Breadcrumbs::for('index', function(BreadcrumbTrail $trail) {
    $trail->push('Trang chủ', route('index'));
});

Breadcrumbs::for('show_story', function(BreadcrumbTrail $trail, Story $story) {
    $trail->parent('index');
    $trail->push(ucfirst(strtolower($story->name)), route('show_story', $story->slug));
});
