@extends('adminlte::auth.auth-page', ['auth_type' => 'register'])



<script>

    function registro(){



        
        return {

            activetab:'',
            terapiasSeleccionadas: [],
            cadenaTerapias:'',
            selectedTypes: [],
            tipo_terapias:[],
            tipo_problemas:[],
            checkboxesterapiasSeleccionadas() {
                this.cadenaTerapias = this.terapiasSeleccionadas.join(', ');
            }
            ,
            toggleTipoTerapia(terapia) {
                terapia.selected = !terapia.selected;

                if (terapia.selected) {
                // Habilitar los checkboxes de los tipos de problema relacionados
                terapia.treat_problem.forEach((tipo_problema) => {
                    tipo_problema.disabled = false;
                });
                } else {
                // Deshabilitar los checkboxes de los tipos de problema relacionados
                terapia.treat_problem.forEach((tipo_problema) => {
                    tipo_problema.disabled = true;
                });
                }
            },
            terapias(){

                fetch('{{route("terapias")}}')
                    .then(r => r.json())
                    .then(
                        (data) => {
                            this.tipo_terapias = data
                            console.log(this.tipo_terapias)
                        }
                    )
            }

        }

    }

</script>

@php( $login_url = View::getSection('login_url') ?? config('adminlte.login_url', 'login') )

@php( $register_url = View::getSection('register_url') ?? config('adminlte.register_url', 'register') )



@php( $registerpsycho_url = View::getSection('registerpsycho_url') ?? config('adminlte.registerpsycho_url', 'registerpsychologist') )



@if (config('adminlte.use_route_url', false))

    @php( $login_url = $login_url ? route($login_url) : '' )

    @php( $register_url = $register_url ? route($register_url) : '' )

@else

    @php( $login_url = $login_url ? url($login_url) : '' )

    @php( $register_url = $register_url ? url($register_url) : '' )

@endif



@section('auth_header', __('adminlte::adminlte.register_message'))







<div class="container-fluid">

    <div class="row">

        <div class="col-lg-12">

            <center>

                @if(session()->has('error'))

                    <div class="alert alert-danger">

                        {{ session()->get('error') }}

                    </div>

                @endif

            </center>



            

        </div>

    </div>

    @section('auth_body')

    <ul class="nav nav-tabs m-0 p-0 flex-container">
        <li class="bg-primary lista-registro">
            <a class="texto-registro" data-toggle="tab" href="#pacientes">
                <div class="card-registro-new">
                    <img class="img-responsive d-block" src="vendor/adminlte/dist/img/businessman.png" alt="" srcset="">
                    <img class="img-responsive d-block" src="vendor/adminlte/dist/img/businesswoman.png" alt="" srcset="">
                </div>
                <h3 class="text-center text-uppercase my-3">Registro de Pacientes</h3>
            </a>
        </li>
        <li class="bg-success lista-registro">
            <a class="texto-registro" data-toggle="tab" href="#psicologo">
                <div class="card-registro-new">
                    <img src="vendor/adminlte/dist/img/doctor.png" alt="" srcset="">
                    <img src="vendor/adminlte/dist/img/doctora.png" alt="" srcset="">
                </div>
                <h3 class="text-center text-uppercase my-3">Registro de Psicólogos</h3>
            </a>
        </li>
    </ul>

    <div class="tab-content" x-data="registro()" x-init="terapias()">

    @if(session()->has('psicologo'))

            <div id="pacientes" class="tab-pane" > 

        @else

        <div id="pacientes" class="tab-pane active" >

        @endif

            <div class="card">

                <div class="card-body ">

                    <h4 class="bg-primary text-center text-uppercase">Registro de pacientes</h4>

                        <form class="formulario-ayuda" action="{{ $register_url }}" method="post" >

                            @csrf



                            {{-- Name field --}}

                            <div class="input-group mb-3">
                                <input title="Introduce tu nombre" type="text" required name="name" class="form-control @error('name') is-invalid @enderror"

                                    value="{{ old('name') }}" placeholder="{{ __('adminlte::adminlte.full_name') }}" autofocus>



                                <div class="input-group-append">

                                    <div class="input-group-text">

                                        <span class="fas fa-user-circle {{ config('adminlte.classes_auth_icon', '') }}"></span>

                                    </div>

                                </div>



                                @error('name')

                                    <span class="invalid-feedback" role="alert">

                                        <strong>{{ $message }}</strong>

                                    </span>

                                @enderror

                            </div>



                            {{-- lastName field --}}

                            <div class="input-group mb-3">

                                <input title="Apellido" title="Introduce tu apellido" type="text" required name="lastname" class="form-control @error('lastname') is-invalid @enderror"

                                    value="{{ old('lastname') }}" placeholder="{{ __('adminlte::adminlte.lastname') }}" autofocus>



                                <div class="input-group-append">

                                    <div class="input-group-text">

                                        <span class="fas fa-user-circle {{ config('adminlte.classes_auth_icon', '') }}"></span>

                                    </div>

                                </div>



                                @error('lastname')

                                    <span class="invalid-feedback" role="alert">

                                        <strong>{{ $message }}</strong>

                                    </span>

                                @enderror

                            </div>



                            {{-- Email field --}}



                            <div class="input-group mb-3">

                                <input title="Email" type="email" name="email" class="form-control @error('email') is-invalid @enderror"

                                    value="{{ old('email') }}" placeholder="{{ __('adminlte::adminlte.email') }}">



                                <div class="input-group-append">

                                    <div class="input-group-text">

                                        <span class="fas fa-envelope {{ config('adminlte.classes_auth_icon', '') }}"></span>

                                    </div>

                                </div>



                                @error('email')

                                    <span class="invalid-feedback" role="alert">

                                        <strong>{{ $message }}</strong>

                                    </span>

                                @enderror

                            </div>



                            {{-- Phone field --}}

                            <div class="input-group mb-3">

                                <input title="Teléfono" type="text" required name="phone" class="form-control @error('phone') is-invalid @enderror" value="{{ old('phone') }}" placeholder="Teléfono">



                                <div class="input-group-append">

                                    <div class="input-group-text">

                                        <span class="fas fa-phone {{ config('adminlte.classes_auth_icon', '') }}"></span>

                                    </div>

                                </div>



                                @error('phone')

                                    <span class="invalid-feedback" role="alert">

                                        <strong>{{ $message }}</strong>

                                    </span>

                                @enderror

                            </div>



                            {{-- Gender field --}}

                            <div class="input-group mb-3">

                                <select title="Género" name="gender" id="gender" class="form-control @error('gender') is-invalid @enderror" value="{{ old('gender') }}">

                                <option disabled selected class="text-bold">--Indica tu Sexo--</option>


                                    <option value="H">Hombre</option>

                                    <option value="M">Mujer</option>

                                </select>



                                <div class="input-group-append">

                                    <div class="input-group-text">

                                        <span class="fas fa-venus-mars {{ config('adminlte.classes_auth_icon', '') }}"></span>

                                    </div>

                                </div>



                                @error('gender')

                                    <span class="invalid-feedback" role="alert">

                                        <strong>{{ $message }}</strong>

                                    </span>

                                @enderror

                            </div>



                            {{-- Age field --}}

                            <div class="input-group mb-3">

                                <input title="edad" type="text" required name="age" class="form-control @error('age') is-invalid @enderror" value="{{ old('age') }}" placeholder="Edad" >



                                <div class="input-group-append">

                                    <div class="input-group-text">

                                        <span class="fas fa-user {{ config('adminlte.classes_auth_icon', '') }}"></span>

                                    </div>

                                </div>



                                @error('age')

                                    <span class="invalid-feedback" role="alert">

                                        <strong>{{ $message }}</strong>

                                    </span>

                                @enderror

                            </div>



                            {{-- Password field --}}

                            <div class="input-group mb-3">

                                <input type="password" name="password" class="form-control @error('password') is-invalid @enderror"

                                    placeholder="{{ __('adminlte::adminlte.password') }}">



                                <div class="input-group-append">

                                    <div class="input-group-text">

                                        <span class="fas fa-lock {{ config('adminlte.classes_auth_icon', '') }}"></span>

                                    </div>

                                </div>



                                @error('password')

                                    <span class="invalid-feedback" role="alert">

                                        <strong>{{ $message }}</strong>

                                    </span>

                                @enderror

                            </div>



                            {{-- Confirm password field --}}

                            <div class="input-group mb-3">

                                <input type="password" name="password_confirmation"

                                    class="form-control @error('password_confirmation') is-invalid @enderror"

                                    placeholder="Confirmar contraseña">



                                <div class="input-group-append">

                                    <div class="input-group-text">

                                        <span class="fas fa-lock {{ config('adminlte.classes_auth_icon', '') }}"></span>

                                    </div>

                                </div>



                                @error('password_confirmation')

                                    <span class="invalid-feedback" role="alert">

                                        <strong>{{ $message }}</strong>

                                    </span>

                                @enderror

                            </div>



                            {{-- Register button --}}

                            <button type="submit" class="btn btn-block {{ config('adminlte.classes_auth_btn', 'btn-flat btn-primary') }}" @click="activetab= uno" >

                                <span class="fas fa-user-plus"></span>

                                {{ __('adminlte::adminlte.register') }}

                            </button>



                        </form>

                </div>

            </div>

        </div>



        @if(session()->has('psicologo'))

            <div id="psicologo" class="tab-pane active"> 

        @else

        <div id="psicologo" class="tab-pane">

        @endif



            <form action="{{ $registerpsycho_url }}" method="post" enctype="multipart/form-data" >

                @csrf

                <div class="card">

                    <div class="card-body">

                        <h4 class="bg-success text-center text-uppercase">Registro de psicólogos</h4>

                        

                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                                {{-- Name field --}}

                                <div class="input-group mb-3">

                                    <input title="Nombre" required type="text"  name="name" class="form-control @error('name') is-invalid @enderror"

                                        value="{{ old('name') }}" placeholder="Nombre" autofocus accept="image/*">



                                    <div class="input-group-append">

                                        <div class="input-group-text">

                                            <span class="fas fa-user-circle {{ config('adminlte.classes_auth_icon', '') }}"></span>

                                        </div>

                                    </div>



                                    @error('name')

                                        <span class="invalid-feedback" role="alert">

                                            <strong>{{ $message }}</strong>

                                        </span>

                                    @enderror

                                </div>



                                {{-- lastName field --}}

                                <div class="input-group mb-3">

                                    <input title="Apellido" required type="text"  name="lastname" class="form-control @error('lastname') is-invalid @enderror"

                                        value="{{ old('lastname') }}" placeholder="Apellido" autofocus>



                                    <div class="input-group-append">

                                        <div class="input-group-text">

                                            <span class="fas fa-user-circle {{ config('adminlte.classes_auth_icon', '') }}"></span>

                                        </div>

                                    </div>



                                    @error('lastname')

                                        <span class="invalid-feedback" role="alert">

                                            <strong>{{ $message }}</strong>

                                        </span>

                                    @enderror

                                </div>



                                {{-- Age field --}}

                                <div class="input-group mb-3">

                                    <input title="Edad" required type="text"  name="age" class="form-control @error('age') is-invalid @enderror"

                                        value="{{ old('age') }}" placeholder="Edad" autofocus>



                                    <div class="input-group-append">

                                        <div class="input-group-text">

                                            <span class="fas fa-user {{ config('adminlte.classes_auth_icon', '') }}"></span>

                                        </div>

                                    </div>



                                    @error('lastname')

                                        <span class="invalid-feedback" role="alert">

                                            <strong>{{ $message }}</strong>

                                        </span>

                                    @enderror

                                </div>



                                {{-- Email field --}}



                                <div class="input-group mb-3">

                                    <input title="Email" required type="email"  name="email" class="form-control @error('email') is-invalid @enderror"

                                        value="{{ old('email') }}" placeholder="{{ __('adminlte::adminlte.email') }}">



                                    <div class="input-group-append">

                                        <div class="input-group-text">

                                            <span class="fas fa-envelope {{ config('adminlte.classes_auth_icon', '') }}"></span>

                                        </div>

                                    </div>



                                    @error('email')

                                        <span class="invalid-feedback" role="alert">

                                            <strong>{{ $message }}</strong>

                                        </span>

                                    @enderror

                                </div>



                                



                                {{-- Personal phone field --}}

                                <div class="input-group mb-3">

                                    <input title="Teléfono Personal" required type="text" name="personal_phone" class="form-control @error('personal_phone') is-invalid @enderror" value="{{ old('personal_phone') }}" placeholder="Teléfono personal">



                                    <div class="input-group-append">

                                        <div class="input-group-text">

                                            <span class="fas fa-phone {{ config('adminlte.classes_auth_icon', '') }}"></span>

                                        </div>

                                    </div>



                                    @error('personal_phone')

                                        <span class="invalid-feedback" role="alert">

                                            <strong>{{ $message }}</strong>

                                        </span>

                                    @enderror

                                </div>



                                {{-- Bussiness phone field --}}

                                <div class="input-group mb-3">

                                    <input title="Teléfono de empresa" required type="text"  name="bussiness_phone" class="form-control @error('bussiness_phone') is-invalid @enderror" value="{{ old('bussiness_phone') }}" placeholder="Teléfono de empresa">



                                    <div class="input-group-append">

                                        <div class="input-group-text">

                                            <span class="fas fa-phone {{ config('adminlte.classes_auth_icon', '') }}"></span>

                                        </div>

                                    </div>



                                    @error('bussiness_phone')

                                        <span class="invalid-feedback" role="alert">

                                            <strong>{{ $message }}</strong>

                                        </span>

                                    @enderror

                                </div>



                                {{-- Gender field --}}

                                <div class="input-group mb-3">

                                    <select  name="gender" id="genderp" class="form-control @error('gender') is-invalid @enderror" value="{{ old('gender') }}">

                                        <option value="H">Hombre</option>

                                        <option value="M">Mujer</option>

                                    </select>



                                    <div class="input-group-append">

                                        <div class="input-group-text">

                                            <span class="fas fa-venus-mars {{ config('adminlte.classes_auth_icon', '') }}"></span>

                                        </div>

                                    </div>



                                    @error('gender')

                                        <span class="invalid-feedback" role="alert">

                                            <strong>{{ $message }}</strong>

                                        </span>

                                    @enderror

                                </div>


                                {{-- Therapy --}}

                                <div class="mb-3 check-de-terapia">

                                        <h3 class="text-center py-4 text-bold">Seleccione la terapia o los tipos de terapia en que se especializa:</h3>

                                       <template x-for="terapia in tipo_terapias" :key="terapia.id">
                                            <div class="container-terapia py-3">
                                                <div class="container-terapia-a">
                                                    <label class="label-terapia" title="Selecciona en qué tipo de terapia te especializas" x-text="terapia.therapy_type"></label>
                                                    <input name="therapy[]"  type="checkbox" :value="terapia.id" class="form-control @error('therapy_id') is-invalid @enderror" x-model="selectedTypes" @click="toggleTipoTerapia(terapia)">
                                                </div>

                                                <div class="container-terapia">
                                                    <h3 class="text-center py-4 text-bold">Problema a Atender:</h3>

                                                    <template x-for="tipo_problema in terapia.treat_problem" :key="tipo_problema.id">
                                                        <div class="container-terapia-a">
                                                            <h4 x-text="tipo_problema.problem"></h4>
                                                            <input type="checkbox" :value="tipo_problema.id" name="tipo_problemas[]" class="form-control" x-bind:disabled="!terapia.selected" >
                                                        </div>
                                                    </template>

                                                </div>
                                               


                                                <h3><b>Especialidad</b></h3>

                                                <template x-for="tipo_problema in terapia.treat_problem" :key="tipo_problema.id">
                                                    <div>
                                                        <h4 x-text="tipo_problema.problem"></h4>
                                                        <input type="checkbox" :value="tipo_problema.id" name="tipo_problemas[]" class="form-control" x-bind:disabled="!terapia.selected">
                                                    </div>
                                                </template>
                                            </div>
                                        </template>

                                    @error('therapy')

                                        <span class="invalid-feedback" role="alert">

                                            <strong>{{ $message }}</strong>

                                        </span>

                                    @enderror

                                </div>

                                {{-- Specialty field --}}

                                <div class="input-group mb-3">


                                   <!--  <div class="input-group-append">

                                        <div class="input-group-text">

                                            <span class="fas fa-file-signature {{ config('adminlte.classes_auth_icon', '') }}"></span>

                                        </div>

                                    </div> --> <!-- creo no va -->



                                    @error('specialty')

                                        <span class="invalid-feedback" role="alert">

                                            <strong>{{ $message }}</strong>

                                        </span>

                                    @enderror

                                </div>



                                {{-- BIO field --}}

                                <div class="input-group mb-3 estilo-text-area">

                                    <textarea title="Solo se permiten 200 caracteres" name="bio" class="form-control bio @error('bio') is-invalid @enderror" value="{{ old('bio') }}" placeholder="BIO" maxlength="200"></textarea>

                                    <div class="input-group-append">

                                        <div class="input-group-text">

                                            <span class="fas fa-comments {{ config('adminlte.classes_auth_icon', '') }}"></span>

                                        </div>

                                    </div>



                                    @error('specialty')

                                        <span class="invalid-feedback" role="alert">

                                            <strong>{{ $message }}</strong>

                                        </span>

                                    @enderror

                                </div>
                                <p class="text-center py-3 text-secondary">Solo se permiten 200 caracteres en su bio...</p>




                                {{-- Photo field--}}

                                <div class="input-group mb-3">

                                    <label for="photo">Cargue una foto</label>

                                    <input title="Carga una foto" required type="file"  name="photo" class="form-control @error('photo') is-invalid @enderror" value="{{ old('photo') }}">



                                    <div class="input-group-append">

                                        <div class="input-group-text">

                                            <span class="fas fa-image {{ config('adminlte.classes_auth_icon', '') }}"></span>

                                        </div>

                                    </div>



                                    @error('photo')

                                        <span class="invalid-feedback" role="alert">

                                            <strong>{{ $message }}</strong>

                                        </span>

                                    @enderror

                                </div>



                                {{-- Password field --}}

                                <div class="input-group mb-3">

                                    <input required type="password"  name="password" class="form-control @error('password') is-invalid @enderror"

                                        placeholder="{{ __('adminlte::adminlte.password') }}">



                                    <div class="input-group-append">

                                        <div class="input-group-text">

                                            <span class="fas fa-lock {{ config('adminlte.classes_auth_icon', '') }}"></span>

                                        </div>

                                    </div>



                                    @error('password')

                                        <span class="invalid-feedback" role="alert">

                                            <strong>{{ $message }}</strong>

                                        </span>

                                    @enderror

                                </div>



                                {{-- Confirm password field --}}

                                <div class="input-group mb-3">

                                    <input required type="password"  name="password_confirmation"

                                        class="form-control @error('password_confirmation') is-invalid @enderror"

                                        placeholder="Confirmar contraseña">



                                    <div class="input-group-append">

                                        <div class="input-group-text">

                                            <span class="fas fa-lock {{ config('adminlte.classes_auth_icon', '') }}"></span>

                                        </div>

                                    </div>



                                    @error('password_confirmation')

                                        <span class="invalid-feedback" role="alert">

                                            <strong>{{ $message }}</strong>

                                        </span>

                                    @enderror

                                </div>



                                {{-- Register button --}}

                                <button type="submit" class="btn btn-block {{ config('adminlte.classes_auth_btn', 'btn-flat btn-primary') }}" @click="activetab= dos">

                                    <span class="fas fa-user-plus"></span>

                                    {{ __('adminlte::adminlte.register') }}

                                </button>

                    </div>

                </div>

            </form>

        </div>

    </div>

    <script>

         const checkboxes = document.querySelectorAll('input[name="therapy"]');
  let cadena_terapias = ''; // Variable global que almacenará los valores de los checkboxes seleccionados

  checkboxes.forEach((checkbox) => {
    checkbox.addEventListener('change', function() {
      if (this.checked) {
        cadena_terapias += (cadena_terapias === '') ? this.value : ', ' + this.value;
      } else {
        cadena_terapias = cadena_terapias.replace(this.value, '').replace(', , ', ', ');
      }
      console.log(checkboxes);
       document.querySelector('input[name="terapias_seleccionadas"]').value = cadena_terapias
      console.log(cadena_terapias); // Para comprobar que se están concatenando los valores correctamente
    });
  });
    </script>
@stop



@section('auth_footer')

    <p class="my-0">

        <a href="{{ $login_url }}">

            {{ __('adminlte::adminlte.i_already_have_a_membership') }}

        </a>

    </p>

@stop

