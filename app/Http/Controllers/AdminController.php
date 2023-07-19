<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Reservations;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use App\Models\Psychologist;
use App\Models\Therapy;
use Illuminate\Support\Facades\Validator;
use DB;

class AdminController extends Controller
{
    //
    public function __construct(){
        $this->middleware('auth')->except(['logout']);
    }

    public function evaluar_psicologo(){

        $psicologos= Psychologist::orderBy('ranking', 'desc')->get();

        return view('puntajes',compact('psicologos'));
    }
    
    public function registrar_pacientes_form(){
        return view('registropacientes');
    }

    public function registrar_pacientes_post(Request $request){

        $validator = Validator::make($request->all(), [
            'name'      => ['required', 'string', 'max:255'],

            'lastname'  => ['required', 'string', 'max:255'],

            'email'     => ['required', 'string', 'email', 'max:255', 'unique:users'],


            //'password'  => ['required', 'string', 'min:8', 'confirmed'],

            'gender'  => ['required', 'string'],

            'age'       => ['required','digits:2'],

            'phone'     => ['required','min:6','max:13']
            // Agrega aquí las reglas de validación para los demás campos
        ],$messages = 

        [

            'required'      => 'El campo :attribute es requerido.',

            

            'max'           => 'El campo :attribute debe contener hasta :max caracteres.',

            

            'numeric'       => 'El campo :attribute debe contener :numeric caracteres.',



            'email'         => 'El correo ya ha sido registrado por otra persona.',

            

            'alpha'         => 'El campo :attribute debe contener solo caracteres alfabéticos.',

            

            'integer'       => 'El campo :attribute debe contener solo caracteres numéricos.',

            

        ]);

        if($validator->fails()){

            return redirect('registro_pacientes')

                ->withErrors($validator)

                ->withInput();


        }else{
            User::create([

            'name'      => $request['name'],

            'lastname'  => $request['lastname'],

            'email'     => $request['email'],

            'phone'     => $request['phone'],

            'gender'    => $request['gender'],

            'age'       => $request['age'],


            'password'  => Hash::make('00000000'),

        ])->assignRole('paciente');
            return back()->with('success', 'El paciente ha sido creado con éxito!');
        }

    }

    public function registrar_reserva_form(){
        $pacientes = User::whereDoesntHave('isPsychologist')
        ->whereDoesntHave('roles', function ($query) {$query->where('name', 'administrador');})
        ->get();
        $psicologos = User::whereHas('isPsychologist')->get();
        $terapias = Therapy::all();


        return view('registrar_reserva',compact('pacientes','psicologos','terapias'));
    }
    public function evaluar(Request $request){
        
        $puntajeanterior= DB::table('psychologist')
                            ->where('id',$request->id)
                            ->pluck('ranking');


        if($request->opcion == 1){
            $puntaje = $puntajeanterior[0]+2;
        }elseif($request->opcion == 0)
        {
            $puntaje = $puntajeanterior[0]-1;
        }
        DB::table('psychologist')->where('id',$request->id)
   ->update([ 'ranking' => $puntaje ]);
    }
}