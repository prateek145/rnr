<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\backend\AuditController;
use App\Http\Controllers\backend\ApplicationController;
use App\Http\Controllers\backend\GroupController;
use App\Http\Controllers\backend\UserController;
use App\Http\Controllers\backend\FieldController;

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

Route::get('/', function () {
    return redirect()->route('login');
});

Auth::routes();

//after complete backend
Route::group(['prefix' => 'admin', 'middleware' => 'auth'], function () {
    //All the routes that belongs to the group goes here
    Route::get('dashboard', function () {});
});
//

//backend ROutes
Route::get('/home', [HomeController::class, 'home'])->name('backend.home');
Route::resource('audits', AuditController::class);
Route::resource('users', UserController::class);
Route::resource('application', ApplicationController::class);
Route::resource('group', GroupController::class);
Route::resource('field', FieldController::class);
Route::delete('attachment/delete/{id}', [ApplicationController::class, 'attachment_delete'])->name('attachment.delete');

Auth::routes();

// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
