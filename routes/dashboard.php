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
    Route::get('/', \App\Http\Livewire\dashboard\DashboardIndex::class)->name('dashboard');

});
Route::prefix('')->group(function () {
    Route::get('/login', \App\Http\Livewire\Auth\Login::class)->name('login');
    Route::post('logout', function () {
        auth()->logout();
        return redirect(route('login'));
    })->name('logout');
});
