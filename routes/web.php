<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

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

Route::group(['middleware' => 'guest', 'prefix' => 'login', 'namespace' => 'Login_Logout'], function() {
    Route::get('', 'LoginController@login')->name('login');
    Route::post('', 'LoginController@doLogin')->name('do-login');
});

Route::group(['middleware' => 'auth:admin'], function() {
    Route::group(['namespace' => 'Login_Logout'], function() {
        Route::get('logout', 'LogoutController@logout')->name('logout');
    });

    Route::group(['namespace' => 'Admin'], function() {
        Route::get('', 'DashboardController@index')->name('dashboard');

        Route::prefix('chi-tiet-nhan-vien/{id}')->group(function() {
            Route::name('detail.')->group(function() {
                Route::get('', 'QuanTriVienController@show')->name('show');
                Route::post('', 'QuanTriVienController@updateDetail')->name('update');
                Route::get('doi-mat-khau', 'QuanTriVienController@viewChangePassDetail')->name('view-change');
                Route::post('doi-mat-khau', 'QuanTriVienController@changePassDetail')->name('do-change');
            });
        });

        Route::prefix('nhan-vien')->group(function() {
            Route::name('nhan-vien.')->group(function() {
                Route::get('', 'QuanTriVienController@index')->name('list');
                Route::get('them-moi', 'QuanTriVienController@create')->name('create');
                Route::post('them-moi', 'QuanTriVienController@store')->name('store');
                Route::delete('xoa', 'QuanTriVienController@destroy')->name('delete');
                Route::get('cap-nhat/{id}', 'QuanTriVienController@edit')->name('edit');
                Route::post('cap-nhat/{id}', 'QuanTriVienController@update')->name('update');
                Route::post('doi-mat-khau', 'QuanTriVienController@changePass')->name('change-pass');
                Route::post('khoa-hoac-mo-khoa', 'QuanTriVienController@lockOrUnlockUser')->name('lock');
            });
        });

        Route::prefix('khach-hang')->group(function() {
            Route::name('khach-hang.')->group(function() {
                Route::get('', 'KhachHangController@index')->name('list');
                Route::delete('xoa', 'KhachHangController@destroy')->name('delete');
                Route::post('doi-mat-khau', 'KhachHangController@changePass')->name('change-pass');
                Route::post('khoa-hoac-mo-khoa', 'KhachHangController@lockOrUnlockUser')->name('lock');
            });
        });

        Route::prefix('vai-tro')->group(function() {
            Route::name('vai-tro.')->group(function() {
                Route::get('', 'VaiTroController@index')->name('list');
            });
        });
    });

});
