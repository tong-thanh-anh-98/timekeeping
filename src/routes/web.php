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

Route::get('/forgot-password', ctl('ForgotPassword', 'index'))->name('auth.password.index');
Route::post('/forgot-password', ctl('ForgotPassword', 'store'))->name('auth.password.store');
Route::get('/forgot-password/{token}', ctl('ForgotPassword', 'resetForm'))->name('auth.password.resetForm');
Route::post('/reset-password', ctl('ForgotPassword', 'resetPassword'))->name('auth.password.resetPassword');

Route::middleware('auth')->group(function () {
    Route::post('/logout', ctl('Auth', 'logout'))->name('logout');

    Route::get('/change-password', ctl('ChangePassword', 'showChangePasswordForm'))->name('auth.password.change');
    Route::post('/change-password', ctl('ChangePassword', 'changePassword'))->name('auth.password.update');

    Route::get('/', ctl('Home', 'index'))->name('home');
    Route::post('/home/store', ctl('Home', 'store'))->name('home.store');

    Route::middleware('admin')->group(function () {
        Route::get('/user', ctl('Admin', 'index'))->name('user.list');
        Route::get('/user/create', ctl('Admin', 'create'))->name('user.create');
        Route::post('/user/store', ctl('Admin', 'store'))->name('user.store');
        Route::get('/user/{id}/detail', ctl('Admin', 'detail'))->name('user.detail');
        Route::put('/user/{id}/update', ctl('Admin', 'update'))->name('user.update');
        Route::delete('/user/{id}/delete', ctl('Admin', 'destroy'))->name('user.destroy');
    });
});
