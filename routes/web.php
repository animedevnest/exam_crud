<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ExamController;
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
    return view('welcome');
});

Route::middleware(['auth'])->group(function () {    
    Route::post('exam/update/{id}', 'ExamController@update');
    Route::post('exam/destroy', 'ExamController@destroy');
    Route::get('exam/category/{category}', 'ExamController@index');
    Route::resource('exam', 'ExamController')->only([
        'create', 'store', 'edit'
    ]);;
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
