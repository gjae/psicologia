<?php


namespace App\Http\Controllers;



use Illuminate\Http\Request;

use App\Models\Psychologist;
use App\Models\User;
use App\Models\Reservations;

use App\Models\Schedules;
use Carbon\Carbon;

use DB;

use Illuminate\Support\Facades\Auth;

use App\Models\Problems;

class PsychologistController extends Controller

{

    /**

     * Display a listing of the resource.

     *

     * @return \Illuminate\Http\Response

     */

    public function index()

    {

        //

        

        $psicologos= Psychologist::all();



        return view('psicologos.index',compact('psicologos'));

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

        //

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

    public function eliminar_horarios($id){
        
        if(Reservations::where('id_schedule',$id)->exists()==true){
            return 0;
        }else{
           Schedules::where('id',$id)->delete();
           return 1;
        }
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
        
        $id_usuario= $id;
        $id_psicologo= User::where('id',$id_usuario)->first()->isPsychologist->id;

        Reservations::whereHas('schedule',function($q) use ($id_psicologo){
            $q->where('id_psychologist',$id_psicologo);
        })->delete();

        Schedules::where('id_psychologist',$id_psicologo)->delete();
        Psychologist::where('id',$id_psicologo)->delete();
        User::where('id',$id)->delete();

        return redirect('/psicologos');

    }

    
    public function problems($id_problema){
        $problemas= Problems::where('id_therapy',$id_problema)->get();
        return $problemas;
    }

    public function registrar_horarios(){


        if(Auth::user()
        ->Ispsychologist){

        $horario_psicologo = 
        Schedules::where('id_psychologist',Auth::user()
        ->Ispsychologist
        ->id)
        ->get();
        }else{
        $horario_psicologo='';
        }

        return view('psicologos.horarios',compact('horario_psicologo'));
    }

    public function seleccionarEspecialista($idTerapia){
        return Psychologist::with('personalInfo')
            ->with('therapy')
            ->with('WorksAtHours')
            ->whereHas('therapy',
            function($q) use ($idTerapia){ 
                $q->where('id',$idTerapia);
            })
            ->take(3)
            ->get();
    }
    public function registrar_horarios_store(Request $request){
        $horariosPorDias= $request['diasDeAtencion'][0];

        foreach($horariosPorDias as $horario){
            if($horario['inicio']!=NULL){
                    
                    if($horario['inicio']==12){
                            $hora_fin = '1:00 PM';
                        }

                    if($horario['inicio']>12 || $horario['inicio']<12){
                        
                        if($horario['inicio']+1==12){
                            $hora_fin = ($horario['inicio']+1).':00 PM';
                        }else{
                        $hora_fin = ($horario['inicio']+1).':00 '.$horario['meridiem'];
                        }

                    }
                $hora= $horario['inicio'].':00 '.$horario['meridiem'].' - '.$hora_fin;
                Schedules::create([
                    'id_psychologist'=>Auth::user()->Ispsychologist->id, 
                    'schedule' => $hora,
                    'dia' => $horario['dia']
                ]);
            }

        }
        if ($request) {
            return 1;
        }elseif ($request == null) {
            return 0;
        }
    }
}

