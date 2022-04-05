<?php

/** @var \Laravel\Lumen\Routing\Router $router */

/*
|--------------------------------------------------------------------------
| Admin Application Routes
|--------------------------------------------------------------------------
|
|
*/

use Illuminate\Support\Facades\Route;

Route::prefix('villa')->name('villa.')->group(function () {
    Route::get('/', \Packages\Villa\src\Http\Livewire\Home\IndexPage::class)->name('index');
    Route::get('/list', \Packages\Villa\src\Http\Livewire\Home\ListPage::class)->name('list');
    Route::get('/info/{residence}', \Packages\Villa\src\Http\Livewire\Home\InfoPage::class)->name('info');
});
