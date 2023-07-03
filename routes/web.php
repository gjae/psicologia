<?php

use App\Models\Psychologist;
use App\Models\Therapy;

use App\Models\Schedules;

use App\Models\Problems;
use App\Models\Reservations;
use App\Models\Psycho_therapy;

use App\Models\problem_psycho_therapy;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Auth\VerificationController;

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



//Route::middleware(["web","auth","auth.session.timeout"])->group(function () {
    
Route::middleware(["web","auth","verified","auth.session.timeout"])->group(function () {

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

})->middleware(['guest'])->name('inicio');

Route::get('confirmar_asistencia/{confirm}/{idCita}',function($confirmation,$idCita){
    Reservations::where('id',$idCita)->update(['status'=>$confirmation]);

});

Route::post('link_meet/{reservation}',[App\Http\Controllers\PsychologistController::class,'link_meet'])->name('link_meet');


/* Registro de usuario. Rutas equivalentes a Auth::routes();******************************************************************************************/

Route::middleware(["web"])->group(function () {
    


    Route::post('/password/email', 'App\Http\Controllers\Auth\ForgotPasswordController@sendResetLinkEmail');
    Route::get('/password/reset', 'App\Http\Controllers\Auth\ForgotPasswordController@showLinkRequestForm');
    Route::post('/password/reset', 'App\Http\Controllers\Auth\ResetPasswordController@reset')->name('password.reset');
    Route::get('/password/reset/{token}', 'App\Http\Controllers\Auth\ResetPasswordController@showResetForm');



    

    Route::get('/email/verify/redirect', function () {
        return redirect()->route('register');
    })->name('verification.redirect');





    
});


/* PARA IMPLEMENTAR ESTAS RUTAS DE FORMA PERSONALIZADA, TIENES QUE PONERLE LOS NOMBRES A LAS RUTAS logout, login, register, verification.verify, verification.notice, y verification.resend. Equivale a Auth::routes(['verify => true']);

RUTAS DE Autenticacion*/
    
    Route::post('/register', 'App\Http\Controllers\Auth\RegisterController@register');
    Route::get('/register', 'App\Http\Controllers\Auth\RegisterController@showRegistrationForm')->name('register');

    Route::post('/login', 'App\Http\Controllers\Auth\LoginController@login');
    Route::get('/login', 'App\Http\Controllers\Auth\LoginController@showLoginForm')->name('login');

    Route::get('/email/verify', function () {
        return view('auth.verify');
    })->name('verification.notice');

    Route::get('/email/verify/{id}/{hash}', 'App\Http\Controllers\Auth\VerificationController@verify')
        ->middleware(['signed', 'throttle:6,1'])
        ->name('verification.verify');
        
    Route::post('/logout', 'App\Http\Controllers\Auth\LoginController@logout')->name('logout');
Route::post('/email/resend', 'App\Http\Controllers\Auth\VerificationController@resend')->name('verification.resend');
/*
 PARA IMPLEMENTAR ESTAS RUTAS DE FORMA PERSONALIZADA, TIENES QUE PONERLE LOS NOMBRES A LAS SIGUIENTES TRES RUTAS QUE SON LAS RESPONSABLES DE LA VERIFICACION POR CORREO ELECTRONICO */

Route::get('registrar_nuevo_correo',function(){
    Auth::logout();
    return redirect()->route('register');
})->name('registrar_nuevo_correo');



 /*Registro de usuario ******************************************************************************************/
Route::get('terapias',function(){
    return Therapy::with('TreatProblem')->get();
})->name('terapias');



Route::get('tipos_terapia_current_user/{id}',function($id){
    /** pasar esta funcion a un controlador y refactorizar. */
    $availableProblems = [];
    
    $currentTherapies = Psycho_therapy::with('therapy.TreatProblems')->where('id_psycho',$id)->pluck('id_therapy')->toArray();
    $available_therapies = Therapy::all();

    $currentProblems = problem_psycho_therapy::whereHas('psycho_therapy',function($q){ 
        $q->where('id_psycho',Auth::user()->isPsychologist->id);
    })
    ->whereHas('problems')
    ->pluck('id_problem')
    ->toArray();

    foreach ($available_therapies as $item_therapy) {
        $problemas_asociados_a_terapia_iterada = 
        Problems::where('id_therapy', $item_therapy->id)
        ->whereNotIn('id',$currentProblems)
        ->get();

        $availableProblems = array_merge($availableProblems, $problemas_asociados_a_terapia_iterada->toArray());
    }

    $data = array(
        "currentTherapies" => Psycho_therapy::with('therapy')->with('problemsTreated.problems')
        ->where('id_psycho',$id)
        ->get(),
        "availableTherapies" => $available_therapies,
        "availableProblems"=> $availableProblems
    );
    return $data;
})->name('tipos_terapia_current_user');


Route::post('/registerpsychologist',[App\Http\Controllers\Auth\RegisterController::class, 'createPsychologist'])->name('registerpsychologist');


/** PRUEBA BROADCASTING */

Route::post('/actualizar-valor', [App\Http\Controllers\PsychologistController::class, 'actualizarValor']);
