<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Reservations;
use App\Models\Psychologist;
use DB;

class AdminController extends Controller
{
    //
    public function evaluar_psicologo(){

        $psicologos= Psychologist::all();

        return view('puntajes',compact('psicologos'));
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