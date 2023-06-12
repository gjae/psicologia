<?php

use App\Models\Psychologist;
use App\Models\Therapy;

use App\Models\Schedules;

use App\Models\Problems;
use App\Models\Reservations;
use App\Models\Psycho_therapy;

use App\Models\Problem_psycho_therapy;
use Illuminate\Support\Facades\Route;

use Illuminate\Http\Request;


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



Route::middleware(["web","auth","auth.session.timeout"])->group(function () {

//Route::middleware(["web","auth","verified","auth.session.timeout"])->group(function () {

    Route::resource('usuarios',App\Http\Controllers\UserController::class)->middleware('permission:usuarios.index');

    
    Route::resource('pacientes',App\Http\Controllers\PacientesController::class)->middleware('permission:pacientes.index');


    Route::get('mis_reservaciones/{id_usuario}', function($id){

        $mis_reservaciones = Reservations::with('schedule')

            ->with(['patient', 'schedule.atThisHourPsyc.personalInfo'])

            ->where('id_user',$id)

            ->get();

        return $mis_reservaciones;

    }); //bueno, aquí probar si el administrador no puede acceder a ésto, y si el psicologo no puede acceder a ésto. De lo contrario hay que crear un permiso para ésta ruta.
     

    Route::get('horarios_psicologos/{id_especialista}', function($id) {

        return Schedules::where('id_psychologist',$id)->get();

    })->name('horarios_psicologos'); //->middleware('permission:registrar_horarios_index') Al habilitar este middleware para ésta ruta obtengo un error al consultar ésta ruta desde el panel de reservas.. Es obvio


    Route::resource('reservas',App\Http\Controllers\ReservasController::class);


    Route::get('reserva_gratuita/{id_usuario}',[App\Http\Controllers\ReservasController::class,'reserva_gratuita'])->name('reserva_gratuita');

    

    Route::get('evaluar_psicologo',[App\Http\Controllers\AdminController::class,'evaluar_psicologo'])->name('evaluar_psicologo')->middleware('permission:evaluar');



    Route::post('evaluar/{id}',[App\Http\Controllers\AdminController::class,'evaluar'])->name('evaluar'); //intenta ver si como administrador o paciente puedes acceder a ésta seccion. Si sí puedes, entonces hay que hacer un permiso para ésta ruta.

     Route::resource('psicologos',App\Http\Controllers\PsychologistController::class)->middleware('permission:psicologos.index');


    Route::delete('eliminar_horarios/{id}',[App\Http\Controllers\PsychologistController::class, 'eliminar_horarios'])->name('eliminar_horarios');

    Route::get('registrar_horarios',[App\Http\Controllers\PsychologistController::class,'registrar_horarios'])->name('registrar_horarios_index')->middleware('permission:registrar_horarios_index');

    Route::post('registrar_horarios',[App\Http\Controllers\PsychologistController::class,'registrar_horarios_store'])->name('registrar_horarios_post');

    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

    /* ACTUALIZAR INFO PSICOLOGO */
    
        Route::get('actualizar_informacion/edit',[App\Http\Controllers\PsychologistController::class,'edit'])->name('actualizarinfo')->middleware('permission:actualizarinfo');

        Route::post('update_info/{psicologo}',[App\Http\Controllers\PsychologistController::class,'update'])->name('update_info_post');

        Route::get('delete_therapies/{id}',[App\Http\Controllers\PsychologistController::class,'delete_therapies'])->name('delete_therapies');
    
        Route::get('delete_problems/{id}/{idproblema}',[App\Http\Controllers\PsychologistController::class,'delete_problems'])->name('delete_problems');
        /* ACTUALIZAR INFO PSICOLOGO */

});
Route::post('/consulta_problemas/{id_problema}',[App\Http\Controllers\PsychologistController::class,'problems'])->name('consulta_problemas');

Route::get('/tipo_terapia_tipo_problema/{id_terapia}',function($id){ 
    $problemas = Problems::where('id_therapy',$id)->get();
        return $problemas;
})->name('tipo_problemas');


Route::get('seleccionar_especialista/{id_terapia}/{id_problema}',[App\Http\Controllers\PsychologistController::class,'seleccionarEspecialista'])->name('especialistaEn');

Route::get('/', function () {

    return view('auth.login');

})->middleware('guest')->name('inicio');

Route::get('confirmar_asistencia/{confirm}/{idCita}',function($confirmation,$idCita){
    Reservations::where('id',$idCita)->update(['status'=>$confirmation]);

});

Route::post('link_meet/{reservation}',[App\Http\Controllers\PsychologistController::class,'link_meet'])->name('link_meet');

Auth::routes();
//Auth::routes(['verify' => true]);



Route::get('terapias',function(){
    return Therapy::with('TreatProblem')->get();
})->name('terapias');



Route::get('tipos_terapia_current_user/{id}',function($id){
    //$currentProblems= Problem_psycho_therapy::with('problems')->where('id_psycho_therapy',1)->pluck('id_problem')->toArray();
    $currentTherapies=Psycho_therapy::with('therapy')->with('problemsTreated.problems')->where('id_psycho',$id)->pluck('id_therapy')->toArray(); //retorna array de los ID de los tipos de terapia que presta elpsicologo logueado
    $data=array(
        "currentTherapies" => Psycho_therapy::with('therapy')->with('problemsTreated.problems')
        ->where('id_psycho',$id)
        ->get(),
        "availableTherapies"=> Therapy::whereNotIn('id',$currentTherapies)->get(),
        
        //"availableProblems"=> Problems::whereNotIn('id',$currentProblems)->get()
    );
    return $data;
})->name('tipos_terapia_current_user');


Route::post('/registerpsychologist',[App\Http\Controllers\Auth\RegisterController::class, 'createPsychologist'])->name('registerpsychologist');


