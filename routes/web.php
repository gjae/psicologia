<?php

use App\Models\Therapy;
use App\Models\Schedules;
use App\Models\Reservations;
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

Route::get('mis_reservaciones/{id_usuario}', function($id){

    $mis_reservaciones= Reservations::with('schedule')->with(['patient', 'schedule.atThisHourPsyc.personalInfo'])->where('id_user',$id)->get();
    return $mis_reservaciones;
});
Route::get('terapias',function(){
    return Therapy::all();
})->name('terapias');

Route::get('horarios_psicologos/{id_especialista}',function($id){
    return Schedules::where('id_psychologist',$id)->get();
})->name('horarios_psicologos');


Route::resource('usuarios',App\Http\Controllers\UserController::class);

Route::resource('reservas',App\Http\Controllers\ReservasController::class);

Route::get('reserva_gratuita/{id_usuario}',[App\Http\Controllers\ReservasController::class,'reserva_gratuita'])->name('reserva_gratuita');

/** RUTAS PARA EVALUACION DE PSICOLOGOS */
Route::get('evaluar_psicologo',[App\Http\Controllers\AdminController::class,'evaluar_psicologo'])->name('evaluar_psicologo');

Route::post('evaluar/{id}',[App\Http\Controllers\AdminController::class,'evaluar'])->name('evaluar');

/** RUTAS PARA EVALUACION DE PSICOLOGOS */


Route::resource('psicologos',App\Http\Controllers\PsychologistController::class);


Auth::routes();

Route::post('/registerpsychologist',[App\Http\Controllers\Auth\RegisterController::class, 'createPsychologist'])->name('registerpsychologist');

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');


Route::post('/consulta_problemas/{id_problema}',[App\Http\Controllers\PsychologistController::class,'problems'])->name('consulta_problemas');

//Auth::routes();

//Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
