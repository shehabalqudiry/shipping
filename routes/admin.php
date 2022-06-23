<?php

use Illuminate\Support\Facades\Route;
// use Illuminate\Support\Facades\Auth;

// Admin Controllers
use App\Http\Controllers\Admin\LoginController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\CityController;
use App\Http\Controllers\Admin\ShipmentController;
// use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\HomeController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\ShipmentImportController;
use App\Http\Controllers\Admin\TransactionController;

Route::prefix('superAdmin/admin/dashboard')->middleware('auth:admin')->name('admin.')->group(function () {
    Route::get('/', [HomeController::class, 'index'])->name('dashboard');
    Route::resource('users', UserController::class);
    Route::post('users/documents/delete/{id}', [UserController::class, 'documents_delete'])->name('users.documents_delete');
    Route::post('users/documents/update/{id}', [UserController::class, 'documents_update'])->name('users.documents_update');
    Route::resource('shipments', ShipmentController::class);
    Route::resource('orders', OrderController::class);
    Route::resource('admins', AdminController::class);
    Route::resource('transactions', TransactionController::class);
    Route::resource('cities', CityController::class);

    Route::get('import', [ShipmentController::class, 'import_create'])->name('import.create');
    Route::post('import', [ShipmentController::class, 'import_store'])->name('import.store');

    Route::get('import_shipments', [ShipmentImportController::class, 'create'])->name('import_shipments.create');
    Route::post('import_shipments', [ShipmentImportController::class, 'import_store'])->name('import_shipments.store');

    Route::get('cities/rates/{city_id}', [CityController::class, 'rates'])->name('cities.rates');
    Route::post('cities/add_rate', [CityController::class, 'add_rate'])->name('cities.add_rate');
    Route::post('cities/rate_destroy/{id}', [CityController::class, 'rate_destroy'])->name('cities.rate_destroy');
    Route::post('cities/update_rate/{id}', [CityController::class, 'update_rate'])->name('cities.update_rate');

    Route::post('/logout', [HomeController::class ,'logout'])->name('logout');
    Route::post('/mode', [HomeController::class , 'mode'])->name('mode');
    Route::get('/setting', [SettingController::class ,'index'])->name('setting.index');
    Route::post('/setting/update', [SettingController::class , 'update'])->name('setting.update');
});

// Route::get('', [LoginController::class ,'getLogin']);
Route::group(['prefix' => 'admin' ,'middleware' => 'guest:admin'], function () {
    Route::get('login', [LoginController::class ,'getLogin'])->name('admin.login');
    Route::post('login', [LoginController::class ,'login'])->name('admin.login');
});
