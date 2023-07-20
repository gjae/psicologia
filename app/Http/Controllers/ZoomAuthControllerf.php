<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
//use App\Http\Traits\zoom;
use Illuminate\Support\Facades\Mail;
use App\Clases\ArmarNotificacion;
//use Laravel\Socialite\Facades\Socialite;
use App\Models\Reservations;
use Illuminate\Support\Facades\Http;

class ZoomAuthController extends Controller
{
    //
    //use zoom;
    public $link_meeting;
    public function redirectToProvider()
    {
        $clientId= env('ZOOM_API_KEY');
        $redirectUri= env('ZOOM_REDIRECT_URI');
        $url = "https://zoom.us/oauth/authorize?response_type=code&client_id={$clientId}&redirect_uri={$redirectUri}";

        return redirect($url);
    }

    public function handleProviderCallback(Request $request)
    {
         $authorizationCode = $request->query('code');

         $response = Http::asForm()->post('https://zoom.us/oauth/token', [
            'grant_type' => 'authorization_code',
            'code' => $authorizationCode,
            'client_id' => "C4gTVgBkToy9PWDrBMFJuw",
            'client_secret' => "e3A4PJ2A6IfuY9YFLN15v7t2utM3drHU",
            'redirect_uri' => "https://www.registro.psicologomonterrico.pe/auth/zoom/callback",
        ]);
        if ($response->ok()) {
            $data = $response->json();
            $accessToken = $data['access_token'];

            
            //return redirect('/reservas'); // Redirige a la página deseada después de obtener el token de acceso
            $this->getMeeting($accessToken );
           /* return redirect('/reservas')->with('cita_agendada','Se ha creado la reserva y se ha notificado por correo electrónico al paciente y al psicólogo ');*/
        } else {
            // Error al intercambiar el código de autorización por el token de acceso
            return redirect('/error'); // Redirige a una página de error o maneja el error de otra manera
        }
    }

    public function getMeeting($access_Token )
    {
        
        $accessToken = $access_Token;
        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $accessToken,
            'Content-Type' => 'application/json',
        ])->post('https://api.zoom.us/v2/users/me/meetings', [
            'topic' => 'Psicoterapia',
            'type' => 2,
            'start_time' => '2023-07-15T14:00:00',
            'duration' => 60, 
        ]);

        if ($response->successful()) {
            $data = [
                'apiResponse' => $response->json(),
            ];
            $this->link_meeting= $data['apiResponse']['join_url']; 
            
            $objeto = new ArmarNotificacion();
            Reservations::latest()->first()->update(['link_meeting' => $this->link_meeting]);
            //$objeto->enviarNotification($response);
           
        } else {
            // Aquí puedes manejar el caso de error en la creación de la reunión
            // Por ejemplo, obtener el mensaje de error: $response->json()['message']
        }
    }
}