<?php


use App\Http\Controllers\User\CategoryController;
use App\Http\Controllers\User\ChapterController;
use App\Http\Controllers\User\StoryController;
use App\Http\Controllers\User\UserController;
use App\Models\Chapter;
use App\Models\Story;
use Diglactic\Breadcrumbs\Breadcrumbs;
use Diglactic\Breadcrumbs\Generator as BreadcrumbTrail;
use Illuminate\Support\Facades\Route;


Route::prefix('categories')->name('categories.')
    ->controller(CategoryController::class)->group(function() {
    Route::get('/', 'index')->name('index');
});

Route::prefix('my_stories')->name('stories.')->group(function() {
    Route::controller(StoryController::class)->group(function() {
        Route::get('/', 'index')->name('index');
        Route::get('/black_list', 'blackList')->name('black_list');
        Route::get('/find', 'find')->name('find');
        Route::get('/{slug}-{story}', 'show')->name('show')
            ->where([
                'slug' => '^(?!((.*/)|(create$))).*\D+.*$',
                'story' => '[0-9]+',
            ]);
        Route::get('/create', 'create')->name('create');
        Route::post('/create', 'store')->name('store');

        Route::get('/edit/{id}', 'edit')->name('edit');
        Route::put('/edit/{id}', 'update')->name('update');

        Route::delete('/destroy/{id}', 'destroy')->name('destroy');
        Route::post('/approve/{id}', 'approve')->name('approve');
        Route::post('/pinned/{id}', 'pinned')->name('pinned');

        Route::post('/restore/{id}', 'restore')->name('restore');
        Route::delete('/kill/{id}', 'kill')->name('kill');

        Route::post('/upload/{id}', 'upload')->name('upload');
    });

    Route::controller(ChapterController::class)->name('chapters.')
        ->group(function() {
        Route::get('/{slug}/chapter/create', 'create')->name('create');
        Route::post('/{slug}/chapter/create', 'store')->name('store');

        Route::get('/{slug}/chuong-{number}', 'index')->name('index');

        Route::get('/{slug}/chapter/edit/{id}', 'edit')->name('edit');
        Route::put('/{slug}/chapter/edit/{id}', 'update')->name('update');

        Route::delete('/{slug}/chapter/destroy/{number}', 'destroy')->name('destroy');
    });
});






// Thể loại
Breadcrumbs::for('user.categories.index', function(BreadcrumbTrail $trail) {
    $trail->parent('index');
    $trail->push('Thể loại', route('user.categories.index'));
});

// Truyện
Breadcrumbs::for('user.stories.index', function(BreadcrumbTrail $trail) {
    $trail->parent('index');
    $trail->push('Danh sách truyện của tôi', route('user.stories.index'));
});
Breadcrumbs::for('user.stories.create', function(BreadcrumbTrail $trail) {
    $trail->parent('user.stories.index');
    $trail->push('Thêm truyện mới', route('user.stories.create'));
});

Breadcrumbs::for('user.stories.show', function(BreadcrumbTrail $trail, Story $story) {
    $trail->parent('user.stories.index');
    $trail->push("$story->name", route('user.stories.show', [$story->slug, $story]));
});

Breadcrumbs::for('user.stories.edit', function(BreadcrumbTrail $trail, Story $story) {
    $trail->parent('user.stories.show', $story);
    $trail->push("Thay đổi thông tin truyện", route('user.stories.edit', $story->id));
});

// chapter

Breadcrumbs::for('user.chapter.index', function(BreadcrumbTrail $trail, Story $story, Chapter $chapter) {
    $trail->parent('user.stories.show', $story);
    $trail->push("Chương $chapter->number", route('user.stories.chapters.index', [$story->slug, $chapter->number]));
});

Breadcrumbs::for('user.chapter.create', function(BreadcrumbTrail $trail, Story $story) {
    $trail->parent('user.stories.show', $story);
    $trail->push("Thêm chương truyện", route('user.stories.chapters.create', $story->slug));
});

Breadcrumbs::for('user.chapter.edit', function(BreadcrumbTrail $trail, Story $story, Chapter $chapter) {
    $trail->parent('user.chapter.index', $story, $chapter);
    $trail->push("Sửa chương truyện", route('user.stories.chapters.edit', [$story->slug, $chapter->id]));
});
