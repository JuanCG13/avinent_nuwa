<?php

use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

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

// Route::get('/welcome', function () {
//     return Inertia::render('Auth/Welcome', [
//          'canLogin' => Route::has('login'),
//          'canRegister' => Route::has('register'),
//          'laravelVersion' => Application::VERSION,
//          'phpVersion' => PHP_VERSION,
//     ]);
// })->name('welcome');

Route::get('/', function () {
    return redirect('/login');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return Inertia::render('Dashboard');
    })->name('dashboard');
    Route::get('/welcome', function () {
        return Inertia::render('Auth/Welcome', []);
    })->name('welcome');
    Route::get('/order/new', function () {
        return Inertia::render('Orders/New', []);
    })->name('orders.new');

});

//** admin routes middleware Admin 
Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'admin',
])->group(function () {
    Route::get('/admin/dashboard', 'App\Http\Controllers\AdminController@dashboard')->name('admin.dashboard');
});
