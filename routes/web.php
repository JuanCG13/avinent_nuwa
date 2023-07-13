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




// Route::middleware([
//     config('jetstream.auth_session'),
//     'web',
// ])->group(function () {

// }); 

Route::get('/', function () {
    return redirect('/login');
});

 
Route::middleware([
    'auth',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    //impersonation
    Route::get('impersonate/{user}', 'App\Http\Controllers\ImpersonationController@impersonate')
    ->name('impersonate');
    Route::get('/leave-impersonate', 'App\Http\Controllers\ImpersonationController@leaveImpersonate')
    ->name('impersonate.leave');

    //pages
    // Route::get('/dashboard', function () {
    //     return Inertia::render('Dashboard');
    // })->name('dashboard');
    Route::get('/dashboard', 'App\Http\Controllers\OrderController@dashboard')
        ->name('dashboard');
    Route::get('/welcome', function () {
        return Inertia::render('Auth/Welcome', []);
    })->name('welcome');


    //get db data
    Route::get('colors/{lang}', 'App\Http\Controllers\DataController@getColors');
    Route::get('colorsmaterial/{lang}', 'App\Http\Controllers\DataController@getColorsMaterial');

    Route::get('incisal/{lang}', 'App\Http\Controllers\DataController@getIncisal');
    Route::get('posicions/{lang}', 'App\Http\Controllers\DataController@getPosicions');
    Route::get('fitxers/{lang}', 'App\Http\Controllers\DataController@getSistemaFitxers');
    Route::get('zonespulides/{lang}', 'App\Http\Controllers\DataController@getZonesPulides');
    Route::get('angulacions/{lang}', 'App\Http\Controllers\DataController@getAngulacions');
    Route::get('materials/{lang}', 'App\Http\Controllers\DataController@getMaterials');
    Route::get('tipusarticle/{lang}', 'App\Http\Controllers\DataController@getGrupTipusArticle');
 
    Route::get('shipping_addresses/{user}', 'App\Http\Controllers\DataController@getShippingAddresses');
    Route::get('impersonate-users', 'App\Http\Controllers\DataController@getImpersonationUsers');

    //orders 
    Route::get('/order/new', function () {
        return Inertia::render('Orders/New', []);
    })->name('orders.new');
    Route::get('/order/edit/{id}', function () {
        return Inertia::render('Orders/Edit', [id]);
    })->name('orders.edit');
    Route::post('/order/new/store', 'App\Http\Controllers\OrderController@store')
        ->name('order.store');
    Route::get('/order/list', 'App\Http\Controllers\OrderController@getOrders');
});

//** admin routes middleware Admin 
Route::middleware([
    'auth',
    config('jetstream.auth_session'),
    'admin',
    'verified',
])->group(function () {
    Route::get('/admin/dashboard', 'App\Http\Controllers\AdminController@dashboard')->name('admin.dashboard');
});
