@extends('adminlte::page')

@section('content')


@can('registrar_reservacion_paciente_psicologo')

<div class="container" x-data="reservacita">

<div class="row">
    <div class="col-lg-12">
        <center>
            @if(session()->has('cita_agendada'))
                <div class="alert alert-success">
                    {{ session()->get('cita_agendada') }}
                </div>
            @endif
        </center>
    </div>
</div>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h1>Reservar cita paciente-psicólogo</h1>
                </div>
                
                <div class="card-body">
                    <form action="" method="post" @submit.prevent="ReservaForm">
                        <div class="row">

                            <div class="container p-5">
                                <h1 class="text-primary">Registro de pacientes</h1>
                                <small>Introduzca el email de la persona para verificar si ya existe en nuestra base de datos</small>


                                {{-- Email field --}}



                                <div class=" mb-5 d-flex">
                                    <div class="col-2">
                                        <h4><b>EMAIL</b></h4>
                                    </div>
                                    <div class="col-10 input-group">
                                        <input title="Email" type="email" name="email" x-model="formData.email" class="form-control @error('email') is-invalid @enderror"

                                        value="{{ old('email') }}" placeholder="{{ __('adminlte::adminlte.email') }}" @blur="buscarUsuario">
                                        



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
                                </div>


                                {{-- Name field --}}

                                <div class="mb-5 d-flex">
                                    <div class="col-2">
                                        <h4><b>NOMBRE</b></h4>
                                    </div>
                                    <div class="col-10 input-group">
                                        <input title="Introduce tu nombre" type="text" required name="name" x-model="formData.name" class="form-control @error('name') is-invalid @enderror"

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
                                </div>



                                {{-- lastName field --}}

                                <div class="mb-5 d-flex">
                                    <div class="col-2">
                                        <h4><b>APELLIDO</b></h4>
                                    </div>
                                    <div class="col-10 input-group">
                                        <input title="Apellido" title="Introduce tu apellido" type="text" x-model="formData.lastname" required name="lastname" class="form-control @error('lastname') is-invalid @enderror"

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
                                </div>



                                {{-- Phone field --}}

                                <div class="mb-5 d-flex">
                                    <div class="col-2">
                                        <h4><b>TELÉFONO</b></h4>
                                    </div>
                                    <div class="col-10 input-group">
                                        <input title="Teléfono" type="text" required x-model="formData.phone" name="phone" class="form-control @error('phone') is-invalid @enderror" value="{{ old('phone') }}" placeholder="Teléfono">



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
                                </div>



                                {{-- Gender field --}}

                                <div class="mb-5 d-flex">
                                    <div class="col-2">
                                        <h4><b>SEXO</b></h4>
                                    </div>
                                    <div class="col-10 input-group">
                                        <select title="Género" name="gender" id="gender" x-model="formData.gender" class="form-control m-0 @error('gender') is-invalid @enderror" value="{{ old('gender') }}">

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
                                </div>



                                {{-- Age field --}}

                                <div class="mb-5 d-flex">
                                    <div class="col-2">
                                        <h4><b>EDAD</b></h4>
                                    </div>
                                    <div class="col-10 input-group">
                                        <input title="edad" type="text" required name="age" x-model="formData.age" class="form-control @error('age') is-invalid @enderror" value="{{ old('age') }}" placeholder="Edad" maxlength="2" >



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
                                </div>
                            </div>
                        </div>
                        <!--div class="row p-5">
                            <div class="col-3 d-flex align-items-center">
                                <h3>Paciente</h3>
                            </div>
                            <div class="col">
                                <select name="paciente" class="form-control" x-model="formData.id_user" @click="setPacienteName($event)">
                                    
                                    <option class="text-bold evitar-click" value="#"><b>Seleccione una opción </b></option>
                                    @foreach($pacientes as $paciente)
                                        <option value="{{$paciente->id}}" data-paciente="{{$paciente->name}} {{$paciente->lastname}}">{{$paciente->name}} {{$paciente->lastname}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div-->
                        <div class="row">
                            <div class="container p-5">
                                <h1 class="text-primary">Datos para la reserva</h1>
                                <div class="row ">
                                    <div class="col-3 align-items-center">
                                        <h3>Tipo de terapia</h3>

                                        <select name="terapia" class="form-control" x-model="tipo_terapia_id" x-on:change="tipo_problema($event)">
                                            
                                            <option class="text-bold evitar-click" value="#"><b>Seleccione una opción </b></option>
                                            @foreach($terapias as $terapia)
                                                <option value="{{$terapia->id}}" data-name="{{$terapia->therapy_type}}">{{$terapia->therapy_type}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col">
                                        <h3>
                                            Tipo de problema
                                        </h3>

                                        <select name="tipo_problema_id" id="" class="form-control @error('tipo_problema') is-invalid @enderror" x-model="tipo_problema_id" x-model="motivo_consulta" @change="seleccionarespecialista($event)">
                                                
                                            <option class="text-bold evitar-click" value="#"><b>Seleccione una opción </b></option> 
                                            <template x-for="tipo_problema in problemas_bag" :key="tipo_problema.id">
                                                <option :value="tipo_problema.id" x-text="tipo_problema.problem" :data-name="tipo_problema.problem"></option>
                                            </template>
                                        </select>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-2 align-items-center ">
                                        <button class="btn btn-primary p-2"> <a href="https://meet.google.com/" class="text-decoration-none  text-white" target="_blank">Obtener link de la reunión</a></button>
                                    </div>
                                    <div class="col-6 offset-1 align-items-center">
                                        <h3>Inserte el link de la reunión de google meet</h3>
                                        <input type="text" name="link_meet" class="form-control" @blur="linkText(formData.link_meeting)" x-model="formData.link_meeting" required>
                                    </div>
                                </div>

                                <div class="row p-5 " >
                                    <div class="col d-flex justify-content-center">
                                        <h2 class="text-primary">Lista de psicólogos especialistas en <span x-text="tipo_de_terapia_name"></span> especializados en <span x-text="tipo_de_problema_name"></span></h2>
                                    </div>
                                </div>
                                
                                <div class="row  table-responsive" x-bind:class="{ 'd-none': !especialistas }">
                                        
                                            <template x-for="especialista in especialistas" :key="especialista.id" >
                                                <div class="col-lg-4 col-md-6 col-sm-12 p-5 efecto-foto">
                                                    <div x-on:click="psicologos(especialista.id)">
                                                            <div class="efecto-foto">
                                                                <a class="d-block my-3 text-center" href="#" @click="formData.especialista=`${especialista.personal_info.name} ${especialista.personal_info.lastname}`,selectedTherapist= true">
                                                                    <img :src="`${especialista.photo.substring(1)}`" class="mx-auto d-block my-4" alt="" height="200" width="200" >
                                                                    <h2 class="text-center text-capitalize"><span x-text="especialista.personal_info.name"></span>  <span x-text="especialista.personal_info.lastname"></span></h2>
                                                                </a>

                                                            </div>
                                                            
                                                            <h4 class="text-center text-capitalize"><span x-text="especialista.bio"></span></h4>
                                                            <h4 class="text-center font-weight-bold">Días y horarios de atención: </h4>
                                                        

                                                        <template x-for="schedule in especialista.works_at_hours">
                                                            <p>
                                                                <span x-text="schedule.dia"></span>: <span x-text="schedule.schedule"></span>
                                                            </p>
                                                        </template>
                                                </div>
                                                
                                                </div>
                                            </template>
                                        
                                        <h4 x-text="mensaje"></h4>
                                </div>

                                <div class="row ">
                                    <div class="col p10" x-show="selectedTherapist">

                                        <div class="container col-lg-6">
                                            <label>Fecha de consulta</label>
                                            <input type="date" class="form-control" x-model="formData.appointment_date" :min="fecha_actual" :max="fecha_actual_mas_1" :change="validarfecha()">
                                        </div>

                                        <div class="col-lg-6">
                                            <label >Horarios disponibles</label>
                                            <select name="horario" class="form-control" id="horario" x-model="horario" @change="disableButton=false, resume_pane= true">
                                                <option value="#"><b>Seleccione una opcion</b></option>
                                                <template x-if="horarios.length === 0">

                                                    <option value="#">Este psicólogo no ha registrado ningún horario de atención</option>

                                                </template>

                                                <template x-for="horario in horarios" :key="horario.id">

                                                    <option :value="horario.id" x-text="horario.schedule" @click="horario_consulta: horario.schedule"></option>

                                                </template>

                                            </select>
                                        </div>

                                        <div class="col-lg-6" x-show="menores">
                                            <label for="apoderado">Soy el apoderado</label>
                                            <input name="apoderado" x-model="formData.apoderado" type="checkbox">
                                        </div>
                                    </div>
                                </div>
                                <div class="row ">
                                    <div class="col-12" >
                                        <div id="resume_pane"  x-show="resume_pane">
                                            <h1>Resumen</h1>

                                            <div class="card">
                                                <div class="card-body">

                                                    <h4>Paciente: <span x-text="formData.name"></span></h4>

                                                    <h4>
                                                    Fecha de consulta: <span x-text="formData.appointment_date"></span></h4>

                                                    <h4>Horario de consulta: <span x-text="horario_de_consulta_prop"></span></h4>

                                                    <h4>Especialista: <span x-text="formData.especialista"></span> </h4>

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                {{-- Register button --}}

                                <div class="row">
                                    <div class="col-12">
                                        <button type="submit" class="btn btn-block {{ config('adminlte.classes_auth_btn', 'btn-flat btn-primary') }}" @click="ReservaForm()" :disabled="disableButton" >
                                            <span class="fas fa-bookmark"></span>
                                            Reservar
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@endcan

@endsection

