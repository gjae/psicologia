<?php

namespace App\Http\Controllers;

use App\Models\Psychologist;
use App\Models\Schedules;
use App\Models\Reservations;
use Illuminate\Http\Request;
use App\Models\Therapy;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        /**
         * cantidad de reservaciones - contador estadísticas generales
         */
        $reservaciones = '';
        
        if (Auth::user()->hasRole('administrador') ){
            $reservaciones=count(Reservations::all());
        }
        if (Auth::user()->hasRole('psicologo')) {

            $reservaciones = count($reserva1 = Reservations::whereHas('schedule',function($q){ 
                $q-> whereHas('AtThisHourPsyc',function($l){ 
                    $l->whereHas('personalInfo',function($m){ 
                        $m ->where('id',Auth::user()->id); 
                    }); 
                }); 
            })->get());
        }
        
        
        $usuarios        = count(user::all());
        $terapias        = Therapy::all();
        $horarios        = count(Schedules::all());
        $psicologos      = Psychologist::latest('ranking')->take(3)->get();
        $psicologos_cant = count(Psychologist::all());

        return view('home',
            compact('terapias',
            'horarios',
            'psicologos',
            'reservaciones',
            'usuarios',
            'psicologos_cant')
        );
    }
}
