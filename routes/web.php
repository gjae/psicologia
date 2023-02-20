<?php

use App\Models\Therapy;
use Illuminate\Support\Facades\Route;

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
    return view('auth.login');
})->name('inicio');

Route::get('terapias',function(){
    return Therapy::all();
})->name('terapias');

Route::resource('usuarios',App\Http\Controllers\UserController::class);
Route::resource('psicologos',App\Http\Controllers\PsychologistController::class);

/*Route::post('rating',[App\Http\Controllers\PsychologistController::class,'rating']);*/
Auth::routes();

Route::post('/registerpsychologist',[App\Http\Controllers\Auth\RegisterController::class, 'createPsychologist'])->name('registerpsychologist');

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
