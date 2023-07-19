<?
namespace App\Services;

use App\Models\Reservations;
use App\Models\Therapy;
use App\Models\Problems;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class ReservaService{
    public function guardarReservaCompleta($datosReserva)
    {
        //dd("Pasa por aqui");
        // Lógica para guardar los datos del paciente y la reserva en la base de datos


        $validator = Validator::make($datosReserva->all(), [
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

            'name'      => $datosReserva['name'],

            'lastname'  => $datosReserva['lastname'],

            'email'     => $datosReserva['email'],

            'phone'     => $datosReserva['phone'],

            'gender'    => $datosReserva['gender'],

            'age'       => $datosReserva['age'],


            'password'  => Hash::make('00000000'),

        ])->assignRole('paciente');
            return back()->with('success', 'El paciente ha sido creado con éxito!');
        }


        if( Reservations::where('appointment_date',$datosReserva->appointment_date)

            ->where('id_schedule',$datosReserva->schedule)

            ->exists()) {

                return 1;

        }else{


            $tipo_terapia= Therapy::where('id',$datosReserva->tipo_terapia)->first()->therapy_type;

            $tipo_problema= Problems::where('id',$datosReserva->tipo_problema)->first()->problem;

            Reservations::create([

                'appointment_date'  => $datosReserva->appointment_date,

                'id_user'           => $datosReserva->id_user,

                'id_schedule'       => $datosReserva->schedule,

                //'cause'             => $datosReserva->cause,
                
                'apoderado'      => $datosReserva->apoderado,
                'tipo_terapia'      => $tipo_terapia,
                'tipo_problema'     => $tipo_problema

            ]);

            return 0;

        } 

    }
}

?>