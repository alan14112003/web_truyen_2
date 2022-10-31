<?php


use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\LevelController;
use App\Http\Controllers\Admin\StoryController;
use App\Http\Controllers\Admin\UserController;
use App\Models\Category;
use Diglactic\Breadcrumbs\Breadcrumbs;
use Diglactic\Breadcrumbs\Generator as BreadcrumbTrail;
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


Breadcrumbs::for('admin.index', function(BreadcrumbTrail $trail) {
    $trail->push('Trang chủ', route('admin.index'));
});

// Cấp bậc
Breadcrumbs::for('admin.levels.index', function(BreadcrumbTrail $trail) {
    $trail->parent('admin.index');
    $trail->push('Danh sách Cấp bậc', route('admin.levels.index'));
});
Breadcrumbs::for('admin.levels.create', function(BreadcrumbTrail $trail) {
    $trail->parent('admin.levels.index');
    $trail->push('Thêm cấp bậc', route('admin.levels.create'));
});
Breadcrumbs::for('admin.levels.edit', function(BreadcrumbTrail $trail) {
    $trail->parent('admin.levels.index');
    $trail->push('Sửa cấp bậc', route('admin.levels.edit'));
});

// Người dùng
Breadcrumbs::for('admin.users.index', function(BreadcrumbTrail $trail) {
    $trail->parent('admin.index');
    $trail->push('Danh sách Người dùng', route('admin.users.index'));
});
Breadcrumbs::for('admin.users.create', function(BreadcrumbTrail $trail) {
    $trail->parent('admin.users.index');
    $trail->push('Thêm người dùng', route('admin.users.create'));
});
Breadcrumbs::for('admin.users.black_list', function(BreadcrumbTrail $trail) {
    $trail->parent('admin.users.index');
    $trail->push('Danh sách người dùng bị xóa', route('admin.users.black_list'));
});

// Thể loại
Breadcrumbs::for('admin.categories.index', function(BreadcrumbTrail $trail) {
    $trail->parent('admin.index');
    $trail->push('Danh sách Thể loại', route('admin.categories.index'));
});
Breadcrumbs::for('admin.categories.create', function(BreadcrumbTrail $trail) {
    $trail->parent('admin.categories.index');
    $trail->push('Thêm Thể loại', route('admin.categories.create'));
});
Breadcrumbs::for('admin.categories.edit', function(BreadcrumbTrail $trail, Category $category) {
    $trail->parent('admin.categories.index');
    $trail->push('Sửa thể loại', route('admin.categories.edit', $category));
});

// stories
Breadcrumbs::for('admin.stories.index', function(BreadcrumbTrail $trail) {
    $trail->parent('admin.index');
    $trail->push('Danh sách truyện', route('admin.stories.index'));
});
Breadcrumbs::for('admin.stories.black_list', function(BreadcrumbTrail $trail) {
    $trail->parent('admin.stories.index');
    $trail->push('Danh sách truyện đã xóa', route('admin.stories.black_list'));
});
