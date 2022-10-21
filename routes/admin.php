<?php


use App\Http\Controllers\Admin\AdminController;
use Illuminate\Support\Facades\Route;

Route::get('/welcome', [AdminController::class, 'welcome'])->name('welcome');
