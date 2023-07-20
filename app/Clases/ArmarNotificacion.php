<?php namespace App\Clases;


use App\Mail\AppointmentNotification;
use App\Models\User;
use App\Models\Schedules;
use Illuminate\Support\Facades\Mail;
use App\Models\Reservations;
use App\Http\Controllers\ZoomAuthController;
    class ArmarNotificacion 
{
    /* métodos y/o atributos */

    public $response=[];
    public $destinatarios=[];
    public $link_meeting;

    public function __construct()
    {
    }


    public function enviarNotification($link, $appointment_date){
        //$apiResponse= $this->response->json();
        //dd("Paso por aqui?");
        $notificar_paciente= User::where('id',Reservations::latest()->first()->id_user)->pluck('email')
        ->first();

        $notificar_psicologo = Reservations::latest()->first()->schedule
        ->AtThisHourPsyc
        ->personalInfo
        ->email;

        $hora= Reservations::latest()->first()->schedule->schedule;
        $fecha= Reservations::latest()->first()->schedule->dia;

        $rec = array($notificar_paciente,$notificar_psicologo);
        //dd($response);

        Mail::to($rec)->send(new AppointmentNotification($link, $fecha, $appointment_date, $hora));
         return redirect()->back()->withInput()->with('cita_agendada','Se ha creado la reserva y se ha notificado por correo electrónico al paciente y al psicólogo ');
    }

    public function retrieveZoomLink(){
        return $this->link_meeting;
    }
    
}
?>