<?php



namespace App\Http\Controllers;



use Illuminate\Http\Request;

use App\Models\Reservations;

use Illuminate\Support\Facades\Auth;



class ReservasController extends Controller

{

    /**

     * Display a listing of the resource.

     *

     * @return \Illuminate\Http\Response

     */

    public function __construct(){
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

    public function store(Request $request)

    {

        if( Reservations::where('appointment_date',$request->appointment_date)

            ->where('id_schedule',$request->schedule)

            ->exists()) {

                return 1;

        }else{

            Reservations::create([

                'appointment_date'  => $request->appointment_date,

                'id_user'           => $request->id_user,

                'id_schedule'       => $request->schedule,

                'cause'             => $request->cause 

            ]);

            return 0;

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

    public function destroy($id)

    {

        //

    }

}

