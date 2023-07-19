<?php



namespace App\Http\Controllers;



use Illuminate\Http\Request;

use App\Models\Reservations;/** */
use App\Models\Therapy;/** */
use App\Services\ReservaService;
use App\Clases\ArmarNotificacion;
use App\Models\Problems; /* */
use App\Models\User; /** */
use App\Models\Schedules;
use App\Mail\AppointmentNotification;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;


class ReservasController extends Controller

{

    /**

     * Display a listing of the resource.

     *

     * @return \Illuminate\Http\Response

     */

    public function __construct( ReservaService $reservaService){
        $this->middleware('auth')->except(['logout']);
    }
    public function index()

    {

        //



        /** cantidad de reservaciones - detalle */

        $reservations='';

        if (Auth::user()->hasRole('administrador')) {

            

            $reservations=Reservations::all();

        }



        if(Auth::user()->hasRole('psicologo')){



            $reservations = Reservations::whereHas('schedule',function($q){ 

                $q-> whereHas('AtThisHourPsyc',function($l) { 

                    $l->whereHas('personalInfo',function($m) { 

                        $m ->where('id',Auth::user()->id); 

                    }); 

                }); 

            })->get();

        }

        return view('reservaciones',compact('reservations'));

    }



    /**

     * Show the form for creating a new resource.

     *

     * @return \Illuminate\Http\Response

     */

    public function create()

    {

        //

    }



    /**

     * Store a newly created resource in storage.

     *

     * @param  \Illuminate\Http\Request  $request

     * @return \Illuminate\Http\Response

     */

    public function store(Request $request ){
        dd("Pas por aqui?");
    //$reservaService->guardarReservaCompleta($request);


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
            if( Reservations::where('appointment_date',$request->appointment_date)

                ->where('id_schedule',$request->schedule)

                ->exists()) {

                    return 1;

            }else{


                $tipo_terapia= Therapy::where('id',$request->tipo_terapia)->first()->therapy_type;

                $tipo_problema= Problems::where('id',$request->tipo_problema)->first()->problem;

                Reservations::create([

                    'appointment_date'  => $request->appointment_date,

                    'id_user'           => $request->id_user,

                    'id_schedule'       => $request->schedule,

                    //'cause'             => $request->cause,
                    
                    'apoderado'      => $request->apoderado,
                    'tipo_terapia'      => $tipo_terapia,
                    'tipo_problema'     => $tipo_problema

                ]);

                return 0;

            } 
        }






        

    }

    public function reserva_gratuita($id){

        

        if (Reservations::where('id_user',$id)->exists()) {

            return 1; //existe

        }else{

            return 0; //no existe

        }

    }



    /**

     * Display the specified resource.

     *

     * @param  int  $id

     * @return \Illuminate\Http\Response

     */

    public function show($id)

    {

        //

    }



    /**

     * Show the form for editing the specified resource.

     *

     * @param  int  $id

     * @return \Illuminate\Http\Response

     */

    public function edit($id)

    {

        //

    }



    /**

     * Update the specified resource in storage.

     *

     * @param  \Illuminate\Http\Request  $request

     * @param  int  $id

     * @return \Illuminate\Http\Response

     */

    public function update(Request $request, $id)

    {

        //

    }



    /**

     * Remove the specified resource from storage.

     *

     * @param  int  $id

     * @return \Illuminate\Http\Response

     */

    public function destroy($reserva)

    {

        //
        Reservations::where('id',$reserva)->delete();
    
    }

}

