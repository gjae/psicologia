<?php


namespace App\Http\Controllers;



use Illuminate\Http\Request;

use App\Models\Psychologist;
use App\Models\Psycho_therapy;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Hash;

use App\Models\User;
use App\Models\Therapy;
use App\Models\Reservations;

use App\Models\Schedules;
use Carbon\Carbon;

use DB;

use Illuminate\Support\Facades\Auth;
use App\Models\Problem_psycho_therapy;

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

    public function edit()

    {

        //
        $id = Auth::user()->isPsychologist->id;
        $psicologo = session('psicologo');
        $psicologo= Psychologist::where('id',$id)->first();
        $tipos_terapias= json_encode($psicologo->therapiesOffered);
        return view("psicologos.update",compact('psicologo','tipos_terapias'));

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
        
        if(isset($request['nuevos_tipos_de_terapia'])){
            $ultimo_registro='';
            foreach($request['nuevos_tipos_de_terapia'] as $index => $nueva_terapia){

                $existingPsychotherapy = Psycho_therapy::where('id_therapy', $nueva_terapia)
                ->where('id_psycho', Auth::user()->ispsychologist->id)
                ->first();
                if($existingPsychotherapy){
                    $ultimo_registro= $existingPsychotherapy->id;
                }else{

                    Psycho_therapy::firstOrCreate(['id_psycho' => Auth::user()->ispsychologist->id,'id_therapy'=> $nueva_terapia]);
                    $ultimo_registro = Psycho_therapy::orderBy('id', 'desc')->first()->id;
                }
                foreach($request['nuevos_tipos_de_problema'] as $index1 => $nuevo_tipos_de_problema){
                    $id_de_terapia_padre_del_problema= Problems::where('id',$request['nuevos_tipos_de_problema'][$index1])->first()->id_therapy;
                    $ultimo_registro_psycho_therapy_update= Psycho_therapy::where('id_psycho',Auth::user()->ispsychologist->id)->orderBy('id', 'desc')->first()->id;
                    if($nueva_terapia == $id_de_terapia_padre_del_problema){

                        problem_psycho_therapy::create([
                            'id_therapy' => $id_de_terapia_padre_del_problema,
                            'id_psycho_therapy' => $ultimo_registro,
                            'id_problem' => $nuevo_tipos_de_problema
                        ]);
                    }
                }
            }

        }

        $user= User::find($id);
        $usuario_id= $user->id;
        $psychologist_id= $user->Ispsychologist->id;
        $url_final=$request['old_pic'];
        $password= $request['password'];

        if ($request['password'] == Auth::user()->password) {
            $password = Auth::user()->password;
        }else {
            $password = Hash::make($password);
        }

        if(isset($request['photo'])){
            $imagen = $request->file("photo");

            $nombreimagen = Str::slug("profile-").".".$imagen->guessExtension();

            $ruta = public_path();

            $imagen->getRealPath();

            copy($imagen->getRealPath(),$ruta.'/images/'.$usuario_id.$nombreimagen); 

            $url_final= '/images/'.$usuario_id.$nombreimagen;
        }


        /** Actualizacion en tabla de psicologo */
        
        $psychologist= Psychologist::find($psychologist_id);
        $psychologist->bio= $request['bio'];
        $psychologist->personal_phone= $request['personal_phone']; 
        $psychologist->bussiness_phone= $request['bussiness_phone'];
        $psychologist->photo= $url_final; 
        $psychologist->save();

        
        /** Actualizacion en tabla de psicologo */
        
        /** Actualizacion en tabla de usuario */

        $usuario= User::find($usuario_id);
        $usuario->name= $request['nombre'];
        $usuario->lastname= $request['apellido'];

        $usuario->email= $request['email'];
        if($request['gender']== NULL){
            $usuario->gender= 'H';
        }else{
            $usuario->gender= $request['gender'];
        }
        $usuario->password= $password;
        $usuario->save();
        
        /** Actualizacion en tabla de usuario */
        if(isset($request['horarios'])){
            foreach($request['horarios'] as $horario){
                
                if ($horario['dia'] !== 'seleccione' && $horario['inicio'] !== 'hora_de_inicio' && $horario['meridiem'] !== 'meridiem_de_inicio') {
            
                
                if($horario['inicio']!=NULL){
                    
                        if($horario['meridiem']== NULL){
                            $meridiem= 'AM';
                        }else{
                            $meridiem= $horario['meridiem'];
                        }
                        if($horario['inicio']==12){
                                $hora_fin = '1:00 PM';
                        }
    
                        if(intval($horario['inicio'])>12 || intval($horario['inicio'])<12){
                            
                            if(intval($horario['inicio'])+1==12){
                                $hora_fin = (intval($horario['inicio'])+1).':00 PM';
                            }else{
                            $hora_fin = (intval($horario['inicio'])+1).':00 '.$meridiem;
                            }
                        }
                    $hora= $horario['inicio'].':00 '.$meridiem.' - '.$hora_fin;
                    
                }
            
                    $schedule= Schedules::find($horario['dia_schedule']);
                    $schedule->dia = $horario['dia'];
                    $schedule->schedule = $hora;
                    $schedule->save();
                    
                }
            }
        }

        Session::flash('success','Los datos se han actualizado con éxito');
        return back();
    }


    public function delete_therapies($id){
        Psycho_therapy::where('id',$id)->delete();
        Problem_psycho_therapy::where('id_psycho_therapy',$id)->delete();
    }
    public function delete_problems($id,$idproblema){
        Problem_psycho_therapy::where('id',$id)->where('id_problem',$idproblema)->delete();
        
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
        ->orderByRaw("FIELD(dia, 'Lunes', 'Martes', 'Miercoles', 'Jueves', 'Viernes', 'Sabado')")
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


    /*public function schedule_stringify($horariosPorDias){
        foreach($horariosPorDias as $horario){
            if($horario['inicio']!=NULL){
                
                    if($horario['meridiem']== NULL){
                        $meridiem= 'AM';
                    }else{
                        $meridiem= $horario['meridiem'];
                    }
                    if($horario['inicio']==12){
                            $hora_fin = '1:00 PM';
                        }

                    if(intval($horario['inicio'])>12 || intval($horario['inicio'])<12){
                        
                        if(intval($horario['inicio'])+1==12){
                            $hora_fin = (intval($horario['inicio'])+1).':00 PM';
                        }else{
                        $hora_fin = (intval($horario['inicio'])+1).':00 '.$meridiem;
                        }
                    }
                
                $hora= $horario['inicio'].':00 '.$meridiem.' - '.$hora_fin;
                
            }
        }
    }*/
    public function registrar_horarios_store(Request $request){
        
        
        $horariosPorDias= $request['diasDeAtencion'][0];
        foreach($horariosPorDias as $horario){
            if($horario['inicio']!=NULL){

                if($horario['meridiem']== NULL){
                        $meridiem= 'AM';
                    }else{
                        $meridiem= $horario['meridiem'];
                    }
                    if($horario['inicio']==12){
                            $hora_fin = '1:00 PM';
                        }

                    if(intval($horario['inicio'])>12 || intval($horario['inicio'])<12){
                        
                        if(intval($horario['inicio'])+1==12){
                            $hora_fin = (intval($horario['inicio'])+1).':00 PM';
                        }else{
                            $hora_fin = (intval($horario['inicio'])+1).':00 '.$meridiem;
                        }
                    }
                
                $hora= $horario['inicio'].':00 '.$meridiem.' - '.$hora_fin;

                Schedules::firstOrCreate([
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

