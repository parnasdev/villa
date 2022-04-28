<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "admin" middleware group. Enjoy building your Admin!
|
*/

Route::middleware('web')->group(function () {
    Route::get('/panel', \App\Http\Livewire\Admin\IndexPanel::class)->name('panel');

    Route::prefix('posts')->name('posts.')->group(function () {
        Route::get('/', \App\Http\Livewire\Admin\posts\PostIndex::class)->name('index');
        Route::get('/create', \App\Http\Livewire\Admin\posts\PostCreate::class)->name('create');
        Route::get('/edit/{post}', \App\Http\Livewire\Admin\posts\PostEdit::class)->name('edit');
    });

    Route::prefix('categories')->name('categories.')->group(function () {
        Route::get('/', \App\Http\Livewire\Admin\Categories\CategoryIndex::class)->name('index');
        Route::get('/create', \App\Http\Livewire\Admin\Categories\CategoryCreate::class)->name('create');
        Route::get('/edit/{category}', \App\Http\Livewire\Admin\Categories\CategoryEdit::class)->name('edit');
    });

    Route::prefix('links')->name('links.')->group(function () {
        Route::get('/', \App\Http\Livewire\Admin\Links\LinkIndex::class)->name('index');
        Route::get('/create', \App\Http\Livewire\Admin\Links\LinkCreate::class)->name('create');
        Route::get('/edit/{link}', \App\Http\Livewire\Admin\Links\LinkEdit::class)->name('edit');
    });

    Route::prefix('users')->name('users.')->group(function () {
        Route::get('/', \App\Http\Livewire\Admin\Users\UserIndex::class)->name('index');
        Route::get('/create', \App\Http\Livewire\Admin\Users\UserCreate::class)->name('create');
        Route::get('/edit/{user}', \App\Http\Livewire\Admin\Users\UserEdit::class)->name('edit');
    });

    Route::prefix('roles')->name('roles.')->group(function () {
        Route::get('/', \App\Http\Livewire\Admin\Roles\RoleIndex::class)->name('index');
        Route::get('/create', \App\Http\Livewire\Admin\Roles\RoleCreate::class)->name('create');
        Route::get('/edit/{role}', \App\Http\Livewire\Admin\Roles\RoleEdit::class)->name('edit');
    });

    Route::prefix('pages')->name('pages.')->group(function () {
        Route::get('/', \App\Http\Livewire\Admin\Pages\PageIndex::class)->name('index');
        Route::get('/create', \App\Http\Livewire\Admin\Pages\PageCreate::class)->name('create');
        Route::get('/edit/{post}', \App\Http\Livewire\Admin\Pages\PageEdit::class)->name('edit');
    });

});
Route::prefix('')->group(function () {
    Route::get('/login', \App\Http\Livewire\Auth\Login::class)->name('login');
    Route::post('logout', function () {
        auth()->logout();
        return redirect(route('login'));
    })->name('logout');
});
