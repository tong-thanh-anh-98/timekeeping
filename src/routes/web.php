<?php

use Illuminate\Support\Facades\Route;

if (!function_exists('ctl')) {
    function ctl($name, $method)
    {
        return ['App\\Http\\Controllers\\' . $name . 'Controller', $method];
    }
}

Route::get('/login', ctl('Auth', 'index'))->name('login');
Route::post('/login', ctl('Auth', 'authenticate'))->name('authenticate');

Route::middleware('auth')->group(function () {
    Route::post('/logout', ctl('Auth', 'logout'))->name('logout');
    Route::get('/', ctl('Home', 'index'))->name('home');
    // Route::middleware('admin')->group(function () {
    //     Route::get('/admin/create-user', ctl('Admin', 'createUser'))->name('admin.createUser');
    //     Route::post('/admin/store-user', ctl('Admin', 'storeUser'))->name('admin.storeUser');
    // });
});
