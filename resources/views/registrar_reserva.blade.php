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
                    <h1 class="text-uppercase">Reservar cita paciente-psicólogo</h1>
                </div>
                
                <div class="card-body">
                    <form action="" method="post" @submit.prevent="ReservaForm">
                        <div class="row">
                            <div class="container p-5">
                                <h1 class="text-uppercase">Registro de pacientes</h1>
                            
                                {{-- Name field --}}

                                <div class="input-group mb-3">
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



                                {{-- lastName field --}}

                                <div class="input-group mb-3">

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



                                {{-- Email field --}}



                                <div class="input-group mb-3">

                                    <input title="Email" type="email" name="email" x-model="formData.email" class="form-control @error('email') is-invalid @enderror"

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



                                {{-- Gender field --}}

                                <div class="input-group mb-3">

                                    <select title="Género" name="gender" id="gender" x-model="formData.gender" class="form-control @error('gender') is-invalid @enderror" value="{{ old('gender') }}">

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

                        <div class="row p-5">
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

                        <div class="row p-5" >
                            <div class="col d-flex justify-content-center">
                                <h3>Lista de psicólogos especialistas en <span x-text="tipo_de_terapia_name"></span> especializados en <span x-text="tipo_de_problema_name"></span></h3>
                            </div>
                        </div>
                        
                        <div class="row  p-5 table-responsive" x-bind:class="{ 'd-none': !especialistas }">
                                
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

                        <div class="row p-5">
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
                        <div class="row p-5">
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
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@endcan

@endsection

