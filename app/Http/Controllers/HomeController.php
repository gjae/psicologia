<?php

namespace App\Http\Controllers;

use App\Models\Psychologist;
use App\Models\Schedules;
use App\Models\Reservations;
use Illuminate\Http\Request;
use App\Models\Therapy;

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
        $terapias=Therapy::all();
        $horarios=Schedules::all();
        $psicologos=Psychologist::all();
        $reservations= Reservations::all();
        return view('home',compact('terapias','horarios','psicologos'));
    }
}
