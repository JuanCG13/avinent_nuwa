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



Route::middleware([
    'setLocale',
])->group(function () {
    Route::get('/', function () {
        return redirect('/login');
    });
}); 

// Route::get('/', function () {
//     return redirect('/login');
// });


//change locale
Route::post('locale/{lang}', function ($lang) {
    Session()->put('locale', $lang);
   // return redirect()->back();
})->name('set.locale');
 
// Route::post('/locale/{lang}', 'App\Http\Controllers\DataController@setLocale')
// ->name('set.locale');

Route::middleware([
    'auth',
    'setLocale',
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
    Route::get('/support', function () {
        return Inertia::render('Support', []);
    })->name('support');

    //get db data
    Route::get('colors/{lang}', 'App\Http\Controllers\DataController@getColors');
    Route::get('colorsmaterial/{lang}', 'App\Http\Controllers\DataController@getColorsMaterial');
    Route::get('incisal/{lang}', 'App\Http\Controllers\DataController@getIncisal');
    Route::get('posicions/{lang}', 'App\Http\Controllers\DataController@getPosicions');
    Route::get('marques/{lang}', 'App\Http\Controllers\DataController@getMarques');
    Route::get('fitxers/{lang}', 'App\Http\Controllers\DataController@getSistemaFitxers');
    Route::get('zonespulides/{lang}', 'App\Http\Controllers\DataController@getZonesPulides');
    Route::get('angulacions/{lang}', 'App\Http\Controllers\DataController@getAngulacions');
    Route::get('materials/{lang}', 'App\Http\Controllers\DataController@getMaterials');
    Route::get('analegs/{lang}', 'App\Http\Controllers\DataController@getAnalegs');
    Route::get('grupsmaterials/{lang}', 'App\Http\Controllers\DataController@getGrupsMaterials');
    Route::get('tipusarticle/{lang}', 'App\Http\Controllers\DataController@getTipusArticle');
    Route::get('grupstipusarticle/{lang}', 'App\Http\Controllers\DataController@getGrupTipusArticle');
    Route::get('tipusarticle2/{lang}', 'App\Http\Controllers\DataController@getTipusArticle2');
    Route::get('materialsarticle/{lang}', 'App\Http\Controllers\DataController@getMaterialsTipusArticle');
    Route::get('implants/{lang}', 'App\Http\Controllers\DataController@getTipusImplants');
    Route::get('basesti/{lang}', 'App\Http\Controllers\DataController@getBasesTi');
    
    Route::get('shipping_addresses/{user}', 'App\Http\Controllers\DataController@getShippingAddresses');
    Route::get('impersonate-users', 'App\Http\Controllers\DataController@getImpersonationUsers');
    Route::get('clients', 'App\Http\Controllers\DataController@getClients');

    //orders 
    Route::get('/order/new', function () {
        return Inertia::render('Orders/New', []);})
        ->name('orders.new');

    Route::get('/order/list', 'App\Http\Controllers\OrderController@getOrders')
        ->name('orders.list');

    Route::get('/order/{id}', 'App\Http\Controllers\OrderController@editOrder')
        ->name('orders.edit');

    Route::post('/order/new/store', 'App\Http\Controllers\OrderController@store')
        ->name('order.store');

    Route::post('/order/fileupload', 'App\Http\Controllers\FileController@fileUpload')
        ->name('order.fileUpload');

    Route::get('/getfile/{filename}', 'App\Http\Controllers\FileController@getFile')
        ->name('order.getFile');
    });

//** admin routes middleware Admin 
Route::middleware([
    'auth',
    'setLocale',
    config('jetstream.auth_session'),
    'admin',
    'verified',
])->group(function () {
    Route::get('/admin/dashboard', 'App\Http\Controllers\AdminController@dashboard')
    ->name('admin.dashboard');

    Route::post('/activateuser', 'App\Http\Controllers\UserController@activateUser')
    ->name('admin.activateuser');
});
