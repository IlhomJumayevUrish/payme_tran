<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Admin\Payme\PaymeSettingController;
use App\Http\Controllers\Admin\Click\ClickSettingController;
use App\Http\Controllers\Admin\Bills\BillsController;
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

Route::get('login', [LoginController::class,'showLoginForm'])->name('login');
Route::post('login', [LoginController::class,'login']);
Route::post('logout', [LoginController::class,'logout'])->name('logout');

Route::get('/', function () {
    return redirect()->route('admin.index');
});


Route::prefix('admin')->name('admin.')->middleware('auth')->group(function(){
    Route::get('/',[HomeController::class,'index'])->name('index');

    Route::prefix('payme')->name('payme.')->group(function (){
        Route::get('/', [PaymeSettingController::class, 'index'])->name('index');
        Route::get('/edit/{psystem}', [PaymeSettingController::class, 'edit'])->name('edit');
        Route::post('/update/{psystem}', [PaymeSettingController::class, 'update'])->name('update');
    });

    Route::prefix('click')->name('click.')->group(function (){
        Route::get('/', [ClickSettingController::class, 'index'])->name('index');
        Route::get('/edit/{psystem}', [ClickSettingController::class, 'edit'])->name('edit');
        Route::post('/update/{psystem}', [ClickSettingController::class, 'update'])->name('update');
    });

    Route::get('/bills', [BillsController::class, 'index'])->name('bills.index');

});

