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

    public function __construct(){
        $this->middleware('auth')->except(['logout']);
    }

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

    public function show($psicologo)

    {
        $info_psicologo = Psychologist::where('id',$psicologo)
        ->with('personalInfo')
        ->with('worksAtHours')
        ->with('personalInfo.Reservations')
        ->first();

        $reservations = Reservations::whereHas('Schedule',function($q) use ($psicologo){
            $q->where('id_psychologist',$psicologo);
        })
        ->get();

        return view('psicologos.info_psicologo',compact('info_psicologo','reservations'));
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

    

    public function link_meet(Request $request){
        if(Reservations::where('id',$request['id'])->exists() == true){
            Reservations::where('id',$request['id'])
            ->update([ 'link_meeting' => $request['link_meeting'] ]);
            return redirect()->back();
        }else
        {
           return 0;
        }
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
        
        $id_usuario = $id;
        $id_psicologo = User::where('id',$id_usuario)
        ->first()
        ->isPsychologist
        ->id;

        Reservations::whereHas('schedule',function($q) use ($id_psicologo){
            $q->where('id_psychologist',$id_psicologo);
        })->delete();

        Schedules::where('id_psychologist',$id_psicologo)->delete();
        
        Psychologist::where('id',$id_psicologo)->delete();

        User::where('id',$id)->delete();

        return redirect('/psicologos');
    }

    public function problems($id_problema){
        /** POST */
        $problemas = Problems::where('id_therapy',$id_problema)->get();
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

    public function seleccionarEspecialista($idTerapia,$idProblema){
            return Psychologist::with('personalInfo')
            ->with('TherapiesOffered.therapy')
            ->with('WorksAtHours')
            ->whereHas('TherapiesOffered',
            function($q) use ($idTerapia){ 
                $q->where('id_therapy',$idTerapia);
            })
            ->whereHas('TherapiesOffered.ProblemsTreated',function($j) use ($idProblema){
                $j->where('id_problem',$idProblema);
            })
            ->take(3)
            ->orderBy('ranking', 'desc')
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

