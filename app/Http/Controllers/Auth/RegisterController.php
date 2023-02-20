<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Psychologist;
use App\Providers\RouteServiceProvider;
use App\Models\User;
use App\Rules\AgeValidator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'lastname' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'age' => ['required',new AgeValidator(),'digits:2'],
            'phone' => ['required','int','digits:7']
        ],$messages = 
        [
            'required' => 'El campo :attribute es requerido.',
            
            'max'      => 'El campo :attribute debe contener hasta :max caracteres.',
            
            'digits'      => 'El campo :attribute debe contener :digits caracteres.',

            'email'      => 'El correo ya ha sido registrado por otra persona.',
            
            'alpha'    => 'El campo :attribute debe contener solo caracteres alfabéticos.',
            
            'age'    => 'Debe ser mayor de 18 años',
            'integer'  => 'El campo :attribute debe contener solo caracteres numéricos.',
            
        ]);
    }

 
    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    protected function create(array $data)
    {
        

        return User::create([
            'name' => $data['name'],
            'lastname' => $data['lastname'],
            'email' => $data['email'],
            'phone' => $data['phone'],
            'gender' => $data['gender'],
            'age' => $data['age'],
            'role' => 1, //Paciente
            'password' => Hash::make($data['password']),
        ]);

    }
    protected function createPsychologist(Request $request)
    {   
        //dd($request);
        //dd($request['photo']);
        //request()->file('photo');
        $validator = Validator::make($request->all(), [
            
            'name'   => 'required|max:30',
            
            'lastname' => 'required|max:30',
            
            'genre'   => 'required|max:1',
            //'age'   => 'required|digits:2|min:18',
            
            'phone' => ['required','int','size:7'],
            'age' => 'required|digits_between:18,99',
            'email'    => 'required|max:50|unique:users,email',
             
            'password' => 'required|max:30',
            
            'photo' => 'required', //|image|mimes:jpeg,png,jpg,gif,svg|max:2048'
            
        ],$messages = 
        [
            'required' => 'El campo :attribute es requerido.',
            
            'max'      => 'El campo :attribute debe contener :max caracteres.',
            
            'alpha'    => 'El campo :attribute debe contener solo caracteres alfabéticos.',
            
            'integer'  => 'El campo :attribute debe contener solo caracteres numéricos.',
            'age.digits_between'    => 'Debe tener minimo 18 años',
            'integer'  => 'El campo :attribute debe contener solo caracteres numéricos.',

            'image'  => 'El archivo debe ser una imagen.',
        ]);

        if(!User::where('email',$request['email'])->exists())
        {
            User::create([
            'name' => $request['name'],
            'lastname' => $request['lastname'],
            'email' => $request['email'],
            'phone' => $request['personal_phone'],
            'age' => $request['age'],
            'gender' => $request['gender'],
            'role' => 3, //Paciente
            'password' => Hash::make($request['password']),
        ]);
        $id_user= User::latest()->first()->id;

         $imagen = $request->file("photo");
        $nombreimagen = Str::slug("profile-").".".$imagen->guessExtension();
        $ruta = public_path();
        copy($imagen->getRealPath(),$ruta.'/images/'.$id_user.$nombreimagen);
        $url_final= $ruta.'/images/'.$nombreimagen;

            Psychologist::create(
            [
                'therapy_id' => $request['therapy_id'],
                'id_user' => $id_user,
                'photo' => $url_final,
                'personal_phone' => $request['personal_phone'],
                'bussiness_phone' => $request['bussiness_phone'],
                'specialty' => $request['specialty']
            ]
            );
        }else{
            //el usuario ya existe.
            return back()->with('error', 'El psicologo ya está registrado');
        }
                
        return redirect()->route('inicio')->with('success', 'El psicologo ha sido creado con éxito! Inicie sesión');
          
    }
}
